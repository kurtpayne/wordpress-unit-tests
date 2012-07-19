<?php

/**
 * test wp-includes/post.php
 *
 * @group post
 */
class Tests_Post extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
		$this->author_id = $this->factory->user->create( array( 'role' => 'editor' ) );
		$this->old_current_user = get_current_user_id();
		wp_set_current_user( $this->author_id );
		_set_cron_array(array());
		$this->post_ids = array();
	}

	function tearDown() {
		wp_set_current_user( $this->old_current_user );
		parent::tearDown();
	}

	// helper function: return the timestamp(s) of cron jobs for the specified hook and post
	function _next_schedule_for_post($hook, $id) {
		return wp_next_scheduled('publish_future_post', array(0=>intval($id)));
	}

	// test simple valid behavior: insert and get a post
	function test_vb_insert_get_delete() {
		register_post_type( 'cpt', array( 'taxonomies' => array( 'post_tag', 'ctax' ) ) );
		register_taxonomy( 'ctax', 'cpt' );
		$post_types = array( 'post', 'cpt' );

		foreach ( $post_types as $post_type ) {
			$post = array(
				'post_author' => $this->author_id,
				'post_status' => 'publish',
				'post_content' => rand_str(),
				'post_title' => rand_str(),
				'tax_input' => array( 'post_tag' => 'tag1,tag2', 'ctax' => 'cterm1,cterm2' ),
				'post_type' => $post_type
			);

			// insert a post and make sure the ID is ok
			$id = wp_insert_post($post);
			$this->assertTrue(is_numeric($id));
			$this->assertTrue($id > 0);

			// fetch the post and make sure it matches
			$out = wp_get_single_post($id);

			$this->assertEquals($post['post_content'], $out->post_content);
			$this->assertEquals($post['post_title'], $out->post_title);
			$this->assertEquals($post['post_status'], $out->post_status);
			$this->assertEquals($post['post_author'], $out->post_author);

			// test cache state
			$pcache = wp_cache_get( $id, 'posts' );
			$this->assertInstanceOf( 'stdClass', $pcache );
			$this->assertEquals( $id, $pcache->ID );

			update_object_term_cache( $id, $post_type );
			$tcache = wp_cache_get( $id, "post_tag_relationships" );
			$this->assertInternalType( 'array', $tcache );
			$this->assertEquals( 2, count( $tcache ) );

			$tcache = wp_cache_get( $id, "ctax_relationships" );
			if ( 'cpt' == $post_type ) {
				$this->assertInternalType( 'array', $tcache );
				$this->assertEquals( 2, count( $tcache ) );
			} else {
				$this->assertFalse( $tcache );
			}

			wp_delete_post( $id, true );
			$this->assertFalse( wp_cache_get( $id, 'posts' ) );
			$this->assertFalse( wp_cache_get( $id, "post_tag_relationships" ) );
			$this->assertFalse( wp_cache_get( $id, "ctax_relationships" ) );
		}

		$GLOBALS['wp_taxonomies']['post_tag']->object_type = array( 'post' );
	}

	function test_vb_insert_future() {
		// insert a post with a future date, and make sure the status and cron schedule are correct

		$future_date = strtotime('+1 day');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);
		#dmp(_get_cron_array());
		$this->assertTrue(is_numeric($id));
		$this->assertTrue($id > 0);

		// fetch the post and make sure it matches
		$out = wp_get_single_post($id);

		$this->assertEquals($post['post_content'], $out->post_content);
		$this->assertEquals($post['post_title'], $out->post_title);
		$this->assertEquals('future', $out->post_status);
		$this->assertEquals($post['post_author'], $out->post_author);
		$this->assertEquals($post['post_date'], $out->post_date);

		// there should be a publish_future_post hook scheduled on the future date
		$this->assertEquals($future_date, $this->_next_schedule_for_post('publish_future_post', $id));
	}

	function test_vb_insert_future_over_dst() {
		// insert a post with a future date, and make sure the status and cron schedule are correct

		// Some magic days - one dst one not
		$future_date_1 = strtotime('June 21st +1 year');
		$future_date_2 = strtotime('Jan 11th +1 year');


		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date_1),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);

		// fetch the post and make sure has the correct date and status
		$out = wp_get_single_post($id);
		$this->assertEquals('future', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// check that there's a publish_future_post job scheduled at the right time
		$this->assertEquals($future_date_1, $this->_next_schedule_for_post('publish_future_post', $id));

		// now save it again with a date further in the future

		$post['ID'] = $id;
		$post['post_date'] = strftime("%Y-%m-%d %H:%M:%S", $future_date_2);
		$post['post_date_gmt'] = NULL;
		wp_update_post($post);

		// fetch the post again and make sure it has the new post_date
		$out = wp_get_single_post($id);
		$this->assertEquals('future', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// and the correct date on the cron job
		$this->assertEquals($future_date_2, $this->_next_schedule_for_post('publish_future_post', $id));
	}

	function test_vb_insert_future_edit_bug() {
		// future post bug: posts get published at the wrong time if you edit the timestamp
		// http://trac.wordpress.org/ticket/4710

		$future_date_1 = strtotime('+1 day');
		$future_date_2 = strtotime('+2 day');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date_1),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);

		// fetch the post and make sure has the correct date and status
		$out = wp_get_single_post($id);
		$this->assertEquals('future', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// check that there's a publish_future_post job scheduled at the right time
		$this->assertEquals($future_date_1, $this->_next_schedule_for_post('publish_future_post', $id));

		// now save it again with a date further in the future

		$post['ID'] = $id;
		$post['post_date'] = strftime("%Y-%m-%d %H:%M:%S", $future_date_2);
		$post['post_date_gmt'] = NULL;
		wp_update_post($post);

		// fetch the post again and make sure it has the new post_date
		$out = wp_get_single_post($id);
		$this->assertEquals('future', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// and the correct date on the cron job
		$this->assertEquals($future_date_2, $this->_next_schedule_for_post('publish_future_post', $id));
	}

	function test_vb_insert_future_draft() {
		// insert a draft post with a future date, and make sure no cron schedule is set

		$future_date = strtotime('+1 day');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'draft',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);
		#dmp(_get_cron_array());
		$this->assertTrue(is_numeric($id));
		$this->assertTrue($id > 0);

		// fetch the post and make sure it matches
		$out = wp_get_single_post($id);

		$this->assertEquals($post['post_content'], $out->post_content);
		$this->assertEquals($post['post_title'], $out->post_title);
		$this->assertEquals('draft', $out->post_status);
		$this->assertEquals($post['post_author'], $out->post_author);
		$this->assertEquals($post['post_date'], $out->post_date);

		// there should be a publish_future_post hook scheduled on the future date
		$this->assertEquals(false, $this->_next_schedule_for_post('publish_future_post', $id));

	}

	function test_vb_insert_future_change_to_draft() {
		// insert a future post, then edit and change it to draft, and make sure cron gets it right
		$future_date_1 = strtotime('+1 day');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date_1),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);

		// fetch the post and make sure has the correct date and status
		$out = wp_get_single_post($id);
		$this->assertEquals('future', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// check that there's a publish_future_post job scheduled at the right time
		$this->assertEquals($future_date_1, $this->_next_schedule_for_post('publish_future_post', $id));

		// now save it again with status set to draft

		$post['ID'] = $id;
		$post['post_status'] = 'draft';
		wp_update_post($post);

		// fetch the post again and make sure it has the new post_date
		$out = wp_get_single_post($id);
		$this->assertEquals('draft', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// and the correct date on the cron job
		$this->assertEquals(false, $this->_next_schedule_for_post('publish_future_post', $id));
	}

	function test_vb_insert_future_change_status() {
		// insert a future post, then edit and change the status, and make sure cron gets it right
		$future_date_1 = strtotime('+1 day');

		$statuses = array('draft', 'static', 'object', 'attachment', 'inherit', 'pending');

		foreach ($statuses as $status) {
			$post = array(
				'post_author' => $this->author_id,
				'post_status' => 'publish',
				'post_content' => rand_str(),
				'post_title' => rand_str(),
				'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date_1),
			);

			// insert a post and make sure the ID is ok
			$id = $this->post_ids[] = wp_insert_post($post);

			// fetch the post and make sure has the correct date and status
			$out = wp_get_single_post($id);
			$this->assertEquals('future', $out->post_status);
			$this->assertEquals($post['post_date'], $out->post_date);

			// check that there's a publish_future_post job scheduled at the right time
			$this->assertEquals($future_date_1, $this->_next_schedule_for_post('publish_future_post', $id));

			// now save it again with status changed

			$post['ID'] = $id;
			$post['post_status'] = $status;
			wp_update_post($post);

			// fetch the post again and make sure it has the new post_date
			$out = wp_get_single_post($id);
			$this->assertEquals($status, $out->post_status);
			$this->assertEquals($post['post_date'], $out->post_date);

			// and the correct date on the cron job
			$this->assertEquals(false, $this->_next_schedule_for_post('publish_future_post', $id));
		}
	}

	function test_vb_insert_future_private() {
		// insert a draft post with a future date, and make sure no cron schedule is set

		$future_date = strtotime('+1 day');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'private',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);
		#dmp(_get_cron_array());
		$this->assertTrue(is_numeric($id));
		$this->assertTrue($id > 0);

		// fetch the post and make sure it matches
		$out = wp_get_single_post($id);

		$this->assertEquals($post['post_content'], $out->post_content);
		$this->assertEquals($post['post_title'], $out->post_title);
		$this->assertEquals('private', $out->post_status);
		$this->assertEquals($post['post_author'], $out->post_author);
		$this->assertEquals($post['post_date'], $out->post_date);

		// there should be a publish_future_post hook scheduled on the future date
		$this->assertEquals(false, $this->_next_schedule_for_post('publish_future_post', $id));
	}

	function test_vb_insert_future_change_to_private() {
		// insert a future post, then edit and change it to private, and make sure cron gets it right
		$future_date_1 = strtotime('+1 day');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date_1),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);

		// fetch the post and make sure has the correct date and status
		$out = wp_get_single_post($id);
		$this->assertEquals('future', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// check that there's a publish_future_post job scheduled at the right time
		$this->assertEquals($future_date_1, $this->_next_schedule_for_post('publish_future_post', $id));

		// now save it again with status set to draft

		$post['ID'] = $id;
		$post['post_status'] = 'private';
		wp_update_post($post);

		// fetch the post again and make sure it has the new post_date
		$out = wp_get_single_post($id);
		$this->assertEquals('private', $out->post_status);
		$this->assertEquals($post['post_date'], $out->post_date);

		// and the correct date on the cron job
		$this->assertEquals(false, $this->_next_schedule_for_post('publish_future_post', $id));
	}

	/**
	 * @ticket 5364
	 */
	function test_delete_future_post_cron() {
		// "When I delete a future post using wp_delete_post($post->ID) it does not update the cron correctly."
		$future_date = strtotime('+1 day');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
			'post_date'  => strftime("%Y-%m-%d %H:%M:%S", $future_date),
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);

		// check that there's a publish_future_post job scheduled at the right time
		$this->assertEquals($future_date, $this->_next_schedule_for_post('publish_future_post', $id));

		// now delete the post and make sure the cron entry is removed
		wp_delete_post($id);

		$this->assertFalse($this->_next_schedule_for_post('publish_future_post', $id));
	}

	/**
	 * @ticket 5305
	 */
	function test_permalink_without_title() {
		// bug: permalink doesn't work if post title is empty
		// might only fail if the post ID is greater than four characters

		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure('/%year%/%monthnum%/%day%/%postname%/');

		$post = array(
			'post_author' => $this->author_id,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => '',
			'post_date' => '2007-10-31 06:15:00',
		);

		// insert a post and make sure the ID is ok
		$id = $this->post_ids[] = wp_insert_post($post);

		$plink = get_permalink($id);

		// permalink should include the post ID at the end
		$this->assertEquals(get_option('siteurl').'/2007/10/31/'.$id.'/', $plink);

		$wp_rewrite->set_permalink_structure('');
	}

	/**
	 * @ticket 21013
	 */
	function test_wp_unique_post_slug_with_non_latin_slugs() {
		$inputs = array(
			'Αρνάκι άσπρο και παχύ της μάνας του καμάρι, και άλλα τραγούδια',
			'Предлагаем супер металлообрабатывающее оборудование',
		);

		$outputs = array(
			'αρνάκι-άσπρο-και-παχύ-της-μάνας-του-κα-2',
			'предлагаем-супер-металлообрабатыва-2',
		);

		foreach ( $inputs as $k => $post_title ) {
			for ( $i = 0; $i < 2; $i++ ) {
				$post = array(
					'post_author' => $this->author_id,
					'post_status' => 'publish',
					'post_content' => rand_str(),
					'post_title' => $post_title,
				);

				$id = $this->post_ids[] = wp_insert_post( $post );
			}

			$post = get_post( $id );
			$this->assertEquals( $outputs[$k], urldecode( $post->post_name ) );
		}
	}
}
