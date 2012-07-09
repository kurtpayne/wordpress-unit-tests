<?php

/**
 * test wp-includes/post.php
 *
 * @group post
 */
class WPTestIncludesPost extends WP_UnitTestCase {
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

	function test_permalink_without_title() {
		// bug: permalink doesn't work if post title is empty
		// wpcom #663, also http://trac.wordpress.org/ticket/5305

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

/**
 * @group post
 * @group media
 * @group upload
 */
class WPTestAttachments extends WP_UnitTestCase {

	function tearDown() {
		// Remove all uploads.
		$uploads = wp_upload_dir(); 
		foreach ( scandir( $uploads['basedir'] ) as $file )
			_rmdir( $uploads['basedir'] . '/' . $file ); 

		parent::tearDown();
	}

	function _make_attachment($upload, $parent_post_id=-1) {

		$type = '';
		if ( !empty($upload['type']) ) {
			$type = $upload['type'];
		} else {
			$mime = wp_check_filetype( $upload['file'] );
			if ($mime)
				$type = $mime['type'];
		}

		$attachment = array(
			'post_title' => basename( $upload['file'] ),
			'post_content' => '',
			'post_type' => 'attachment',
			'post_parent' => $parent_post_id,
			'post_mime_type' => $type,
			'guid' => $upload[ 'url' ],
		);

		// Save the data
		$id = wp_insert_attachment( $attachment, $upload[ 'file' ], $parent_post_id );
		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );

		return $this->ids[] = $id;

	}

	function test_insert_bogus_image() {
		$filename = rand_str().'.jpg';
		$contents = rand_str();

		$upload = wp_upload_bits($filename, null, $contents);
		$this->assertTrue( empty($upload['error']) );

		$id = $this->_make_attachment($upload);
	}

	function test_insert_image_no_thumb() {

		// this image is smaller than the thumbnail size so it won't have one
		$filename = ( DIR_TESTDATA.'/images/test-image.jpg' );
		$contents = file_get_contents($filename);

		$upload = wp_upload_bits(basename($filename), null, $contents);
		$this->assertTrue( empty($upload['error']) );

		$id = $this->_make_attachment($upload);

		// intermediate copies should not exist
		$this->assertFalse( image_get_intermediate_size($id, 'thumbnail') );
		$this->assertFalse( image_get_intermediate_size($id, 'medium') );

		// medium and full size will both point to the original
		$downsize = image_downsize($id, 'medium');
		$this->assertEquals( 'test-image.jpg', basename($downsize[0]) );
		$this->assertEquals( 50, $downsize[1] );
		$this->assertEquals( 50, $downsize[2] );

		$downsize = image_downsize($id, 'full');
		$this->assertEquals( 'test-image.jpg', basename($downsize[0]) );
		$this->assertEquals( 50, $downsize[1] );
		$this->assertEquals( 50, $downsize[2] );

	}

	function test_insert_image_thumb_only() {
		update_option( 'medium_size_w', 0 );
		update_option( 'medium_size_h', 0 );

		$filename = ( DIR_TESTDATA.'/images/a2-small.jpg' );
		$contents = file_get_contents($filename);

		$upload = wp_upload_bits(basename($filename), null, $contents);
		$this->assertTrue( empty($upload['error']) );

		$id = $this->_make_attachment($upload);

		// intermediate copies should exist: thumbnail only
		$thumb = image_get_intermediate_size($id, 'thumbnail');
		$this->assertEquals( 'a2-small-150x150.jpg', $thumb['file'] );

		$uploads = wp_upload_dir();
		$this->assertTrue( is_file($uploads['basedir'] . DIRECTORY_SEPARATOR . $thumb['path']) );

		$this->assertFalse( image_get_intermediate_size($id, 'medium') );

		// the thumb url should point to the thumbnail intermediate
		$this->assertEquals( $thumb['url'], wp_get_attachment_thumb_url($id) );

		// image_downsize() should return the correct images and sizes
		$downsize = image_downsize($id, 'thumbnail');
		$this->assertEquals( 'a2-small-150x150.jpg', basename($downsize[0]) );
		$this->assertEquals( 150, $downsize[1] );
		$this->assertEquals( 150, $downsize[2] );

		// medium and full will both point to the original
		$downsize = image_downsize($id, 'medium');
		$this->assertEquals( 'a2-small.jpg', basename($downsize[0]) );
		$this->assertEquals( 400, $downsize[1] );
		$this->assertEquals( 300, $downsize[2] );

		$downsize = image_downsize($id, 'full');
		$this->assertEquals( 'a2-small.jpg', basename($downsize[0]) );
		$this->assertEquals( 400, $downsize[1] );
		$this->assertEquals( 300, $downsize[2] );

	}

	function test_insert_image_medium() {
		update_option('medium_size_w', 400);
		update_option('medium_size_h', 0);

		$filename = ( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG' );
		$contents = file_get_contents($filename);

		$upload = wp_upload_bits(basename($filename), null, $contents);
		$this->assertTrue( empty($upload['error']) );

		$id = $this->_make_attachment($upload);
		$uploads = wp_upload_dir();

		// intermediate copies should exist: thumbnail and medium
		$thumb = image_get_intermediate_size($id, 'thumbnail');
		$this->assertEquals( '2007-06-17DSC_4173-150x150.jpg', $thumb['file'] );
		$this->assertTrue( is_file($uploads['basedir'] . DIRECTORY_SEPARATOR . $thumb['path']) );

		$medium = image_get_intermediate_size($id, 'medium');
		$this->assertEquals( '2007-06-17DSC_4173-400x602.jpg', $medium['file'] );
		$this->assertTrue( is_file($uploads['basedir'] . DIRECTORY_SEPARATOR . $medium['path']) );

		// the thumb url should point to the thumbnail intermediate
		$this->assertEquals( $thumb['url'], wp_get_attachment_thumb_url($id) );

		// image_downsize() should return the correct images and sizes
		$downsize = image_downsize($id, 'thumbnail');
		$this->assertEquals( '2007-06-17DSC_4173-150x150.jpg', basename($downsize[0]) );
		$this->assertEquals( 150, $downsize[1] );
		$this->assertEquals( 150, $downsize[2] );

		$downsize = image_downsize($id, 'medium');
		$this->assertEquals( '2007-06-17DSC_4173-400x602.jpg', basename($downsize[0]) );
		$this->assertEquals( 400, $downsize[1] );
		$this->assertEquals( 602, $downsize[2] );

		$downsize = image_downsize($id, 'full');
		$this->assertEquals( '2007-06-17DSC_4173.jpg', basename($downsize[0]) );
		$this->assertEquals( 680, $downsize[1] );
		$this->assertEquals( 1024, $downsize[2] );
	}


	function test_insert_image_delete() {
		update_option('medium_size_w', 400);
		update_option('medium_size_h', 0);

		$filename = ( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG' );
		$contents = file_get_contents($filename);

		$upload = wp_upload_bits(basename($filename), null, $contents);
		$this->assertTrue( empty($upload['error']) );

		$id = $this->_make_attachment($upload);
		$uploads = wp_upload_dir();

		// check that the file and intermediates exist
		$thumb = image_get_intermediate_size($id, 'thumbnail');
		$this->assertEquals( '2007-06-17DSC_4173-150x150.jpg', $thumb['file'] );
		$this->assertTrue( is_file($uploads['basedir'] . DIRECTORY_SEPARATOR . $thumb['path']) );

		$medium = image_get_intermediate_size($id, 'medium');
		$this->assertEquals( '2007-06-17DSC_4173-400x602.jpg', $medium['file'] );
		$this->assertTrue( is_file($uploads['basedir'] . DIRECTORY_SEPARATOR . $medium['path']) );

		$meta = wp_get_attachment_metadata($id);
		$original = $meta['file'];
		$this->assertTrue( is_file($uploads['basedir'] . DIRECTORY_SEPARATOR . $original) );

		// now delete the attachment and make sure all files are gone
		wp_delete_attachment($id);

		$this->assertFalse( is_file($thumb['path']) );
		$this->assertFalse( is_file($medium['path']) );
		$this->assertFalse( is_file($original) );
	}

}

/**
 * @group post
 * @group meta
 */
class WPTestPostMeta extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();

		$this->author = new WP_User( $this->factory->user->create( array( 'role' => 'editor' ) ) );

		$post = array(
			'post_author' => $this->author->ID,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
		);

		// insert a post
		$this->post_id = wp_insert_post($post);


		$post = array(
			'post_author' => $this->author->ID,
			'post_status' => 'publish',
			'post_content' => rand_str(),
			'post_title' => rand_str(),
		);

		// insert a post
		$this->post_id_2 = wp_insert_post($post);
	}

	function tearDown() {
		parent::tearDown();
		wp_delete_post($this->post_id);
		wp_delete_post($this->post_id_2);
	}

	function test_unique_postmeta() {
		// Add a unique post meta item
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'unique', 'value', true) );

		// Check unique is enforced
		$this->assertFalse(add_post_meta($this->post_id, 'unique', 'another value', true));

		//Check it exists
		$this->assertEquals('value', get_post_meta($this->post_id, 'unique', true));
		$this->assertEquals(array('value'), get_post_meta($this->post_id, 'unique', false));

		//Fail to delete the wrong value
		$this->assertFalse(delete_post_meta($this->post_id, 'unique', 'wrong value'));

		//Delete it
		$this->assertTrue(delete_post_meta($this->post_id, 'unique', 'value'));

		//Check it is deleted
		$this->assertEquals('', get_post_meta($this->post_id, 'unique', true));
		$this->assertEquals(array(), get_post_meta($this->post_id, 'unique', false));

	}

	function test_nonunique_postmeta() {
		// Add two non unique post meta item
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'nonunique', 'value') );
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'nonunique', 'another value'));

		//Check they exists
		$this->assertEquals('value', get_post_meta($this->post_id, 'nonunique', true));
		$this->assertEquals(array('value', 'another value'), get_post_meta($this->post_id, 'nonunique', false));

		//Fail to delete the wrong value
		$this->assertFalse(delete_post_meta($this->post_id, 'nonunique', 'wrong value'));

		//Delete the first one
		$this->assertTrue(delete_post_meta($this->post_id, 'nonunique', 'value'));

		//Check the remainder exists
		$this->assertEquals('another value', get_post_meta($this->post_id, 'nonunique', true));
		$this->assertEquals(array('another value'), get_post_meta($this->post_id, 'nonunique', false));

		//Add a third one
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'nonunique', 'someother value') );

		//Check they exists
		$expected = array(
			'someother value',
			'another value'
		);
		sort( $expected );
		$this->assertTrue( in_array( get_post_meta( $this->post_id, 'nonunique', true ), $expected ) );
		$actual = get_post_meta( $this->post_id, 'nonunique', false );
		sort( $actual );
		$this->assertEquals( $expected, $actual );

		//Delete the lot
		$this->assertTrue(delete_post_meta_by_key('nonunique'));
	}

	function test_update_post_meta() {
		// Add a unique post meta item
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'unique_update', 'value', true) );

		// Add two non unique post meta item
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'nonunique_update', 'value') );
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'nonunique_update', 'another value') );

		//Check they exists
		$this->assertEquals('value', get_post_meta($this->post_id, 'unique_update', true));
		$this->assertEquals(array('value'), get_post_meta($this->post_id, 'unique_update', false));
		$this->assertEquals('value', get_post_meta($this->post_id, 'nonunique_update', true));
		$this->assertEquals(array('value', 'another value'), get_post_meta($this->post_id, 'nonunique_update', false));

		// Update them
		$this->assertTrue(update_post_meta($this->post_id, 'unique_update', 'new', 'value'));
		$this->assertTrue(update_post_meta($this->post_id, 'nonunique_update', 'new', 'value'));
		$this->assertTrue(update_post_meta($this->post_id, 'nonunique_update', 'another new', 'another value'));

		//Check they updated
		$this->assertEquals('new', get_post_meta($this->post_id, 'unique_update', true));
		$this->assertEquals(array('new'), get_post_meta($this->post_id, 'unique_update', false));
		$this->assertEquals('new', get_post_meta($this->post_id, 'nonunique_update', true));
		$this->assertEquals(array('new', 'another new'), get_post_meta($this->post_id, 'nonunique_update', false));

	}

	function test_delete_post_meta() {
		// Add a unique post meta item
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'unique_delete', 'value', true) );
		$this->assertInternalType( 'integer', add_post_meta($this->post_id_2, 'unique_delete', 'value', true) );

		//Check they exists
		$this->assertEquals('value', get_post_meta($this->post_id, 'unique_delete', true));
		$this->assertEquals('value', get_post_meta($this->post_id_2, 'unique_delete', true));

		//Delete one of them
		$this->assertTrue(delete_post_meta($this->post_id, 'unique_delete', 'value'));

		//Check the other still exitsts
		$this->assertEquals('value', get_post_meta($this->post_id_2, 'unique_delete', true));


	}

	function test_delete_post_meta_by_key() {
		// Add a unique post meta item
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'unique_delete_by_key', 'value', true) );
		$this->assertInternalType( 'integer', add_post_meta($this->post_id_2, 'unique_delete_by_key', 'value', true) );

		//Check they exist
		$this->assertEquals('value', get_post_meta($this->post_id, 'unique_delete_by_key', true));
		$this->assertEquals('value', get_post_meta($this->post_id_2, 'unique_delete_by_key', true));

		//Delete one of them
		$this->assertTrue(delete_post_meta_by_key('unique_delete_by_key'));

		//Check the other still exists
		$this->assertEquals('', get_post_meta($this->post_id_2, 'unique_delete_by_key', true));
		$this->assertEquals('', get_post_meta($this->post_id_2, 'unique_delete_by_key', true));
	}

	function test_get_post_meta_by_id() {
		$mid = add_post_meta( $this->post_id, 'get_post_meta_by_key', 'get_post_meta_by_key_value', true );
		$this->assertInternalType( 'integer', $mid );

		$mobj = new stdClass;
		$mobj->meta_id = $mid;
		$mobj->post_id = $this->post_id;
		$mobj->meta_key = 'get_post_meta_by_key';
		$mobj->meta_value = 'get_post_meta_by_key_value';
		$this->assertEquals( $mobj, get_post_meta_by_id( $mid ) );
		delete_metadata_by_mid( 'post', $mid );

		$mid = add_post_meta( $this->post_id, 'get_post_meta_by_key', array( 'foo', 'bar' ), true );
		$this->assertInternalType( 'integer', $mid );
		$mobj->meta_id = $mid;
		$mobj->meta_value = array( 'foo', 'bar' );
		$this->assertEquals( $mobj, get_post_meta_by_id( $mid ) );
		delete_metadata_by_mid( 'post', $mid );
	}

	function test_delete_meta() {
		$mid = add_post_meta( $this->post_id, 'delete_meta', 'delete_meta_value', true );
		$this->assertInternalType( 'integer', $mid );

		$this->assertTrue( delete_meta( $mid ) );
		$this->assertFalse( get_metadata_by_mid( 'post', $mid ) );

		$this->assertFalse( delete_meta( 123456789 ) );
	}

	function test_update_meta() {
		// Add a unique post meta item
		$this->assertInternalType( 'integer', $mid1 = add_post_meta($this->post_id, 'unique_update', 'value', true) );

		// Add two non unique post meta item
		$this->assertInternalType( 'integer', $mid2 = add_post_meta($this->post_id, 'nonunique_update', 'value') );
		$this->assertInternalType( 'integer', $mid3 = add_post_meta($this->post_id, 'nonunique_update', 'another value') );

		//Check they exist
		$this->assertEquals('value', get_post_meta($this->post_id, 'unique_update', true));
		$this->assertEquals(array('value'), get_post_meta($this->post_id, 'unique_update', false));
		$this->assertEquals('value', get_post_meta($this->post_id, 'nonunique_update', true));
		$this->assertEquals(array('value', 'another value'), get_post_meta($this->post_id, 'nonunique_update', false));

		// Update them
		$this->assertTrue( update_meta( $mid1, 'unique_update', 'new' ) );
		$this->assertTrue( update_meta( $mid2, 'nonunique_update', 'new' ) );
		$this->assertTrue( update_meta( $mid3, 'nonunique_update', 'another new' ) );

		//Check they updated
		$this->assertEquals('new', get_post_meta($this->post_id, 'unique_update', true));
		$this->assertEquals(array('new'), get_post_meta($this->post_id, 'unique_update', false));
		$this->assertEquals('new', get_post_meta($this->post_id, 'nonunique_update', true));
		$this->assertEquals(array('new', 'another new'), get_post_meta($this->post_id, 'nonunique_update', false));

		// Slashed update
		$data = "'quote and \slash";
		$this->assertTrue( update_meta( $mid1, 'unique_update', addslashes( $data ) ) );
		$meta = get_metadata_by_mid( 'post', $mid1 );
		$this->assertEquals( $data, $meta->meta_value );
	}

	/**
	 * @ticket 12860
	 */
	function test_funky_post_meta() {
		$classy = new StdClass();
		$classy->ID = 1;
		$classy->stringy = "I love slashes\\\\";
		$funky_meta[] = $classy;

		$classy = new StdClass();
		$classy->ID = 2;
		$classy->stringy = "I love slashes\\\\ more";
		$funky_meta[] = $classy;

		// Add a post meta item
		$this->assertInternalType( 'integer', add_post_meta($this->post_id, 'test_funky_post_meta', $funky_meta, true) );

		//Check they exists
		$this->assertEquals($funky_meta, get_post_meta($this->post_id, 'test_funky_post_meta', true));

	}
}

/**
 * @group post
 */
class WPTestPostTypes extends WP_UnitTestCase {
	function test_register_post_type() {
		$this->assertNull( get_post_type_object( 'foo' ) );
		register_post_type( 'foo' );

		$pobj = get_post_type_object( 'foo' );
		$this->assertInstanceOf( 'stdClass', $pobj );
		$this->assertEquals( 'foo', $pobj->name );

		// Test some defaults
		$this->assertFalse( is_post_type_hierarchical( 'foo' ) );
		$this->assertEquals( array(), get_object_taxonomies( 'foo' ) );
	}

	function test_register_taxonomy_for_object_type() {
		global $wp_taxonomies;

		register_post_type( 'bar' );
		register_taxonomy_for_object_type( 'post_tag', 'bar' );
		$this->assertEquals( array( 'post_tag' ), get_object_taxonomies( 'bar' ) );
		register_taxonomy_for_object_type( 'category', 'bar' );
		$this->assertEquals( array( 'category', 'post_tag' ), get_object_taxonomies( 'bar' ) );

		$this->assertTrue( is_object_in_taxonomy( 'bar', 'post_tag' ) );
		$this->assertTrue( is_object_in_taxonomy( 'bar', 'post_tag' ) );

		// Clean up. Remove the 'bar' post type from these taxonomies.
		$GLOBALS['wp_taxonomies']['post_tag']->object_type = array( 'post' );
		$GLOBALS['wp_taxonomies']['category']->object_type = array( 'post' );

		$this->assertFalse( is_object_in_taxonomy( 'bar', 'post_tag' ) );
		$this->assertFalse( is_object_in_taxonomy( 'bar', 'post_tag' ) );
	}

	function test_post_type_exists() {
		$this->assertFalse( post_type_exists( 'notaposttype' ) );
		$this->assertTrue( post_type_exists( 'post' ) );
	}

	function test_post_type_supports() {
		$this->assertTrue( post_type_supports( 'post', 'post-formats' ) );
		$this->assertFalse( post_type_supports( 'page', 'post-formats' ) );
		$this->assertFalse( post_type_supports( 'notaposttype', 'post-formats' ) );
		$this->assertFalse( post_type_supports( 'post', 'notafeature' ) );
		$this->assertFalse( post_type_supports( 'notaposttype', 'notafeature' ) );
	}
}
