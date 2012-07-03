<?php

abstract class WP_Import_UnitTestCase extends WP_UnitTestCase {
	/**
	 * Import a WXR file.
	 *
	 * The $users parameter provides information on how users specified in the import
	 * file should be imported. Each key is a user login name and indicates if the user
	 * should be mapped to an existing user, created as a new user with a particular login
	 * or imported with the information held in the WXR file. An example of this:
	 *
	 * <code>
	 * $users = array(
	 *   'alice' => 1, // alice will be mapped to user ID 1
	 *   'bob' => 'john', // bob will be transformed into john
	 *   'eve' => false // eve will be imported as is
	 * );</code>
	 *
	 * @param string $filename Full path of the file to import
	 * @param array $users User import settings
	 * @param bool $fetch_files Whether or not do download remote attachments
	 */
	protected function _import_wp( $filename, $users = array(), $fetch_files = true ) {
		$importer = new WP_Import();
		$file = realpath( $filename );
		assert('!empty($file)');
		assert('is_file($file)');

		$authors = $mapping = $new = array();
		$i = 0;

		// each user is either mapped to a given ID, mapped to a new user
		// with given login or imported using details in WXR file
		foreach ( $users as $user => $map ) {
			$authors[$i] = $user;
			if ( is_int( $map ) )
				$mapping[$i] = $map;
			else if ( is_string( $map ) )
				$new[$i] = $map;

			$i++;
		}

		$_POST = array( 'imported_authors' => $authors, 'user_map' => $mapping, 'user_new' => $new );

		ob_start();
		$importer->fetch_attachments = $fetch_files;
		$importer->import( $file );
		ob_end_clean();

		$_POST = array();
	}
}

/**
 * @group import
 */
class WXRParserTest extends WP_Import_UnitTestCase {
	function setUp() {
		parent::setUp();

		if ( ! defined( 'WP_IMPORTING' ) )
			define( 'WP_IMPORTING', true );

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
			define( 'WP_LOAD_IMPORTERS', true );

		require_once DIR_TESTDATA . '/plugins/wordpress-importer/wordpress-importer.php';
	}

	function test_malformed_wxr() {
		$file = DIR_TESTDATA . '/export/malformed.xml';

		// regex based parser cannot detect malformed XML
		foreach ( array( 'WXR_Parser_SimpleXML', 'WXR_Parser_XML' ) as $p ) {
			$parser = new $p;
			$result = $parser->parse($file);
			$this->assertTrue( is_wp_error( $result ) );
			$this->assertEquals( 'There was an error when reading this WXR file', $result->get_error_message() );
		}
	}

	function test_invalid_wxr() {
		$f1 = DIR_TESTDATA . '/export/missing-version-tag.xml';
		$f2 = DIR_TESTDATA . '/export/invalid-version-tag.xml';

		foreach ( array( 'WXR_Parser_SimpleXML', 'WXR_Parser_XML', 'WXR_Parser_Regex' ) as $p ) {
			foreach ( array( $f1, $f2 ) as $file ) {
				$parser = new $p;
				$result = $parser->parse( $file );
				$this->assertTrue( is_wp_error( $result ) );
				$this->assertEquals( 'This does not appear to be a WXR file, missing/invalid WXR version number', $result->get_error_message() );
			}
		}
	}

	function test_wxr_version_1_1() {
		$file = DIR_TESTDATA . '/export/valid-wxr-1.1.xml';

		foreach ( array( 'WXR_Parser_SimpleXML', 'WXR_Parser_XML', 'WXR_Parser_Regex' ) as $p ) {
			$message = $p . ' failed';
			$parser = new $p;
			$result = $parser->parse( $file );

			$this->assertTrue( is_array( $result ), $message );
			$this->assertEquals( 'http://localhost/', $result['base_url'], $message );
			$this->assertEquals( array(
				'author_id' => 2,
				'author_login' => 'john',
				'author_email' => 'johndoe@example.org',
				'author_display_name' => 'John Doe',
				'author_first_name' => 'John',
				'author_last_name' => 'Doe'
			), $result['authors']['john'], $message );
			$this->assertEquals( array(
				'term_id' => 3,
				'category_nicename' => 'alpha',
				'category_parent' => '',
				'cat_name' => 'alpha',
				'category_description' => 'The alpha category'
			), $result['categories'][0], $message );
			$this->assertEquals( array(
				'term_id' => 22,
				'tag_slug' => 'clippable',
				'tag_name' => 'Clippable',
				'tag_description' => 'The Clippable post_tag'
			), $result['tags'][0], $message );
			$this->assertEquals( array(
				'term_id' => 40,
				'term_taxonomy' => 'post_tax',
				'slug' => 'bieup',
				'term_parent' => '',
				'term_name' => 'bieup',
				'term_description' => 'The bieup post_tax'
			), $result['terms'][0], $message );

			$this->assertEquals( 2, count($result['posts']), $message );
			$this->assertEquals( 19, count($result['posts'][0]), $message );
			$this->assertEquals( 18, count($result['posts'][1]), $message );
			$this->assertEquals( array(
				array( 'name' => 'alpha', 'slug' => 'alpha', 'domain' => 'category' ),
				array( 'name' => 'Clippable', 'slug' => 'clippable', 'domain' => 'post_tag' ),
				array( 'name' => 'bieup', 'slug' => 'bieup', 'domain' => 'post_tax' )
			), $result['posts'][0]['terms'], $message );
			$this->assertEquals( array(
				array( 'key' => '_wp_page_template', 'value' => 'default' )
			), $result['posts'][1]['postmeta'], $message );
		}
	}

	function test_wxr_version_1_0() {
		$file = DIR_TESTDATA . '/export/valid-wxr-1.0.xml';

		foreach ( array( 'WXR_Parser_SimpleXML', 'WXR_Parser_XML', 'WXR_Parser_Regex' ) as $p ) {
			$message = $p . ' failed';
			$parser = new $p;
			$result = $parser->parse( $file );

			$this->assertTrue( is_array( $result ), $message );
			$this->assertEquals( 'http://localhost/', $result['base_url'], $message );
			$this->assertEquals( $result['categories'][0]['category_nicename'], 'alpha', $message );
			$this->assertEquals( $result['categories'][0]['cat_name'], 'alpha', $message );
			$this->assertEquals( $result['categories'][0]['category_parent'], '', $message );
			$this->assertEquals( $result['categories'][0]['category_description'], 'The alpha category', $message );
			$this->assertEquals( $result['tags'][0]['tag_slug'], 'chicken', $message );
			$this->assertEquals( $result['tags'][0]['tag_name'], 'chicken', $message );

			$this->assertEquals( 6, count($result['posts']), $message );
			$this->assertEquals( 19, count($result['posts'][0]), $message );
			$this->assertEquals( 18, count($result['posts'][1]), $message );

			$this->assertEquals( array(
				array( 'name' => 'Uncategorized', 'slug' => 'uncategorized', 'domain' => 'category' )
			), $result['posts'][0]['terms'], $message );
			$this->assertEquals( array(
				array( 'name' => 'alpha', 'slug' => 'alpha', 'domain' => 'category' ),
				array( 'name' => 'news', 'slug' => 'news', 'domain' => 'tag' ),
				array( 'name' => 'roar', 'slug' => 'roar', 'domain' => 'tag' )
			), $result['posts'][2]['terms'], $message );
			$this->assertEquals( array(
				array( 'name' => 'chicken', 'slug' => 'chicken', 'domain' => 'tag' ),
				array( 'name' => 'child', 'slug' => 'child', 'domain' => 'category' ),
				array( 'name' => 'face', 'slug' => 'face', 'domain' => 'tag' )
			), $result['posts'][3]['terms'], $message );

			$this->assertEquals( array(
				array( 'key' => '_wp_page_template', 'value' => 'default' )
			), $result['posts'][1]['postmeta'], $message );
		}
	}

	/**
	 * Test the WXR parser's ability to correctly retrieve content from CDATA
	 * sections that contain escaped closing tags ("]]>" -> "]]]]><![CDATA[>").
	 *
	 * @link http://core.trac.wordpress.org/ticket/15203
	 */
	function test_escaped_cdata_closing_sequence() {
		$file = DIR_TESTDATA . '/export/crazy-cdata-escaped.xml';

		foreach( array( 'WXR_Parser_SimpleXML', 'WXR_Parser_XML', 'WXR_Parser_Regex' ) as $p ) {
			$message = 'Parser ' . $p;
			$parser = new $p;
			$result = $parser->parse( $file );

			$post = $result['posts'][0];
			$this->assertEquals( 'Content with nested <![CDATA[ tags ]]> :)', $post['post_content'], $message );
			foreach ( $post['postmeta'] as $meta ) {
				switch ( $meta['key'] ) {
					case 'Plain string': $value = 'Foo'; break;
					case 'Closing CDATA': $value = ']]>'; break;
					case 'Alot of CDATA': $value = 'This has <![CDATA[ opening and ]]> closing <![CDATA[ tags like this: ]]>'; break;
					default: $this->fail( 'Unknown postmeta (' . $meta['key'] . ') was parsed out by' . $p );
				}
				$this->assertEquals( $value, $meta['value'], $message );
			}
		}
	}

	/**
	 * Ensure that the regex parser can still parse invalid CDATA blocks (i.e. those
	 * with "]]>" unescaped within a CDATA section).
	 */
	function test_unescaped_cdata_closing_sequence() {
		$file = DIR_TESTDATA . '/export/crazy-cdata.xml';

		$parser = new WXR_Parser_Regex;
		$result = $parser->parse( $file );

		$post = $result['posts'][0];
		$this->assertEquals( 'Content with nested <![CDATA[ tags ]]> :)', $post['post_content'] );
		foreach ( $post['postmeta'] as $meta ) {
			switch ( $meta['key'] ) {
				case 'Plain string': $value = 'Foo'; break;
				case 'Closing CDATA': $value = ']]>'; break;
				case 'Alot of CDATA': $value = 'This has <![CDATA[ opening and ]]> closing <![CDATA[ tags like this: ]]>'; break;
				default: $this->fail( 'Unknown postmeta (' . $meta['key'] . ') was parsed out by' . $p );
			}
			$this->assertEquals( $value, $meta['value'] );
		}
	}

	// tags in CDATA #11574
}

/**
 * @group import
 */
class WPImportTest extends WP_Import_UnitTestCase {
	function setUp() {
		parent::setUp();

		if ( ! defined( 'WP_IMPORTING' ) )
			define( 'WP_IMPORTING', true );

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
			define( 'WP_LOAD_IMPORTERS', true );

		add_filter( 'import_allow_create_users', '__return_true' );
		require_once DIR_TESTDATA . '/plugins/wordpress-importer/wordpress-importer.php';

		global $wpdb;
		// crude but effective: make sure there's no residual data in the main tables
		foreach ( array('posts', 'postmeta', 'comments', 'terms', 'term_taxonomy', 'term_relationships', 'users', 'usermeta') as $table)
			$wpdb->query("DELETE FROM {$wpdb->$table}");
	}

	function tearDown() {
		remove_filter( 'import_allow_create_users', '__return_true' );

		parent::tearDown();
	}

	function test_small_import() {
		global $wpdb;

		$authors = array( 'admin' => false, 'editor' => false, 'author' => false );
		$this->_import_wp( DIR_TESTDATA . '/export/small-export.xml', $authors );

		// ensure that authors were imported correctly
		$user_count = count_users();
		$this->assertEquals( 3, $user_count['total_users'] );
		$admin = get_user_by( 'login', 'admin' );
		$this->assertEquals( 'admin', $admin->user_login );
		$this->assertEquals( 'local@host.null', $admin->user_email );
		$editor = get_user_by( 'login', 'editor' );
		$this->assertEquals( 'editor', $editor->user_login );
		$this->assertEquals( 'editor@example.org', $editor->user_email );
		$this->assertEquals( 'FirstName', $editor->user_firstname );
		$this->assertEquals( 'LastName', $editor->user_lastname );
		$author = get_user_by( 'login', 'author' );
		$this->assertEquals( 'author', $author->user_login );
		$this->assertEquals( 'author@example.org', $author->user_email );

		// check that terms were imported correctly
		$this->assertEquals( 30, wp_count_terms( 'category' ) );
		$this->assertEquals( 3, wp_count_terms( 'post_tag' ) );
		$foo = get_term_by( 'slug', 'foo', 'category' );
		$this->assertEquals( 0, $foo->parent );
		$bar = get_term_by( 'slug', 'bar', 'category' );
		$foo_bar = get_term_by( 'slug', 'foo-bar', 'category' );
		$this->assertEquals( $bar->term_id, $foo_bar->parent );

		// check that posts/pages were imported correctly
		$post_count = wp_count_posts( 'post' );
		$this->assertEquals( 5, $post_count->publish );
		$this->assertEquals( 1, $post_count->private );
		$page_count = wp_count_posts( 'page' );
		$this->assertEquals( 4, $page_count->publish );
		$this->assertEquals( 1, $page_count->draft );
		$comment_count = wp_count_comments();
		$this->assertEquals( 1, $comment_count->total_comments );

		$posts = get_posts( array( 'numberposts' => 20, 'post_type' => 'any', 'post_status' => 'any', 'orderby' => 'ID' ) );
		$this->assertEquals( 11, count($posts) );

		$post = $posts[0];
		$this->assertEquals( 'Many Categories', $post->post_title );
		$this->assertEquals( 'many-categories', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'post', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$cats = wp_get_post_categories( $post->ID );
		$this->assertEquals( 27, count($cats) );

		$post = $posts[1];
		$this->assertEquals( 'Non-standard post format', $post->post_title );
		$this->assertEquals( 'non-standard-post-format', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'post', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$cats = wp_get_post_categories( $post->ID );
		$this->assertEquals( 1, count($cats) );
		$this->assertTrue( has_post_format( 'aside', $post->ID ) );

		$post = $posts[2];
		$this->assertEquals( 'Top-level Foo', $post->post_title );
		$this->assertEquals( 'top-level-foo', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'post', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$cats = wp_get_post_categories( $post->ID, array( 'fields' => 'all' ) );
		$this->assertEquals( 1, count($cats) );
		$this->assertEquals( 'foo', $cats[0]->slug );

		$post = $posts[3];
		$this->assertEquals( 'Foo-child', $post->post_title );
		$this->assertEquals( 'foo-child', $post->post_name );
		$this->assertEquals( $editor->ID, $post->post_author );
		$this->assertEquals( 'post', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$cats = wp_get_post_categories( $post->ID, array( 'fields' => 'all' ) );
		$this->assertEquals( 1, count($cats) );
		$this->assertEquals( 'foo-bar', $cats[0]->slug );

		$post = $posts[4];
		$this->assertEquals( 'Private Post', $post->post_title );
		$this->assertEquals( 'private-post', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'post', $post->post_type );
		$this->assertEquals( 'private', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$cats = wp_get_post_categories( $post->ID );
		$this->assertEquals( 1, count($cats) );
		$tags = wp_get_post_tags( $post->ID );
		$this->assertEquals( 3, count($tags) );
		$this->assertEquals( 'tag1', $tags[0]->slug );
		$this->assertEquals( 'tag2', $tags[1]->slug );
		$this->assertEquals( 'tag3', $tags[2]->slug );

		$post = $posts[5];
		$this->assertEquals( '1-col page', $post->post_title );
		$this->assertEquals( '1-col-page', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'page', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$this->assertEquals( 'onecolumn-page.php', get_post_meta( $post->ID, '_wp_page_template', true ) );

		$post = $posts[6];
		$this->assertEquals( 'Draft Page', $post->post_title );
		$this->assertEquals( '', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'page', $post->post_type );
		$this->assertEquals( 'draft', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$this->assertEquals( 'default', get_post_meta( $post->ID, '_wp_page_template', true ) );

		$post = $posts[7];
		$this->assertEquals( 'Parent Page', $post->post_title );
		$this->assertEquals( 'parent-page', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'page', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$this->assertEquals( 'default', get_post_meta( $post->ID, '_wp_page_template', true ) );

		$post = $posts[8];
		$this->assertEquals( 'Child Page', $post->post_title );
		$this->assertEquals( 'child-page', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'page', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( $posts[7]->ID, $post->post_parent );
		$this->assertEquals( 'default', get_post_meta( $post->ID, '_wp_page_template', true ) );

		$post = $posts[9];
		$this->assertEquals( 'Sample Page', $post->post_title );
		$this->assertEquals( 'sample-page', $post->post_name );
		$this->assertEquals( $admin->ID, $post->post_author );
		$this->assertEquals( 'page', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$this->assertEquals( 'default', get_post_meta( $post->ID, '_wp_page_template', true ) );

		$post = $posts[10];
		$this->assertEquals( 'Hello world!', $post->post_title );
		$this->assertEquals( 'hello-world', $post->post_name );
		$this->assertEquals( $author->ID, $post->post_author );
		$this->assertEquals( 'post', $post->post_type );
		$this->assertEquals( 'publish', $post->post_status );
		$this->assertEquals( 0, $post->post_parent );
		$cats = wp_get_post_categories( $post->ID );
		$this->assertEquals( 1, count($cats) );
	}

	function test_double_import() {
		$authors = array( 'admin' => false, 'editor' => false, 'author' => false );
		$this->_import_wp( DIR_TESTDATA . '/export/small-export.xml', $authors );
		$this->_import_wp( DIR_TESTDATA . '/export/small-export.xml', $authors );

		$user_count = count_users();
		$this->assertEquals( 3, $user_count['total_users'] );
		$admin = get_user_by( 'login', 'admin' );
		$this->assertEquals( 'admin', $admin->user_login );
		$this->assertEquals( 'local@host.null', $admin->user_email );
		$editor = get_user_by( 'login', 'editor' );
		$this->assertEquals( 'editor', $editor->user_login );
		$this->assertEquals( 'editor@example.org', $editor->user_email );
		$this->assertEquals( 'FirstName', $editor->user_firstname );
		$this->assertEquals( 'LastName', $editor->user_lastname );
		$author = get_user_by( 'login', 'author' );
		$this->assertEquals( 'author', $author->user_login );
		$this->assertEquals( 'author@example.org', $author->user_email );

		$this->assertEquals( 30, wp_count_terms( 'category' ) );
		$this->assertEquals( 3, wp_count_terms( 'post_tag' ) );
		$foo = get_term_by( 'slug', 'foo', 'category' );
		$this->assertEquals( 0, $foo->parent );
		$bar = get_term_by( 'slug', 'bar', 'category' );
		$foo_bar = get_term_by( 'slug', 'foo-bar', 'category' );
		$this->assertEquals( $bar->term_id, $foo_bar->parent );

		$post_count = wp_count_posts( 'post' );
		$this->assertEquals( 5, $post_count->publish );
		$this->assertEquals( 1, $post_count->private );
		$page_count = wp_count_posts( 'page' );
		$this->assertEquals( 4, $page_count->publish );
		$this->assertEquals( 1, $page_count->draft );
		$comment_count = wp_count_comments();
		$this->assertEquals( 1, $comment_count->total_comments );
	}

	// function test_menu_import
}

/**
 * @group import
 */
class TestImportWP_PostMeta extends WP_Import_UnitTestCase {
	function setUp() {
		parent::setUp();

		if ( ! defined( 'WP_IMPORTING' ) )
			define( 'WP_IMPORTING', true );

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
			define( 'WP_LOAD_IMPORTERS', true );

		require_once DIR_TESTDATA . '/plugins/wordpress-importer/wordpress-importer.php';
	}

	function test_serialized_postmeta_no_cdata() {
		$this->_import_wp( DIR_TESTDATA . '/export/test-serialized-postmeta-no-cdata.xml', array( 'johncoswell' => 'john' ) );
		$expected['special_post_title'] = 'A special title';
		$expected['is_calendar'] = '';
		$this->assertEquals( $expected, get_post_meta( 122, 'post-options', true ) );
	}

	function test_utw_postmeta() {
		$this->_import_wp( DIR_TESTDATA . '/export/test-utw-post-meta-import.xml', array( 'johncoswell' => 'john' ) );

		$classy = new StdClass();
		$classy->tag =  "album";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "apple";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "art";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "artwork";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "dead-tracks";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "ipod";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "itunes";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "javascript";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "lyrics";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "script";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "tracks";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "windows-scripting-host";
		$expected[] = $classy;
		$classy = new StdClass();
		$classy->tag =  "wscript";
		$expected[] = $classy;

		$this->assertEquals( $expected, get_post_meta( 150, 'test', true ) );
	}
}

/**
 * @group import
 */
class TestImportWP_PostMetaCDATA extends WP_Import_UnitTestCase {
	function setUp() {
		parent::setUp();

		if ( ! defined( 'WP_IMPORTING' ) )
			define( 'WP_IMPORTING', true );

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
			define( 'WP_LOAD_IMPORTERS', true );

		require_once DIR_TESTDATA . '/plugins/wordpress-importer/wordpress-importer.php';
	}

	// #9633
	function test_serialized_postmeta_with_cdata() {
		$this->_import_wp( DIR_TESTDATA . '/export/test-serialized-postmeta-with-cdata.xml', array( 'johncoswell' => 'johncoswell' ) );

		//HTML in the CDATA should work with old WordPress version
		$this->assertEquals( '<pre>some html</pre>', get_post_meta( 10, 'contains-html', true ) );
		//Serialised will only work with 3.0 onwards.
		$expected["special_post_title"] = "A special title";
		$expected["is_calendar"] = "";
		$this->assertEquals( $expected, get_post_meta( 10, 'post-options', true ) );
	}

	// #11574
	function test_serialized_postmeta_with_evil_stuff_in_cdata() {
		$this->_import_wp( DIR_TESTDATA . '/export/test-serialized-postmeta-with-cdata.xml', array( 'johncoswell' => 'johncoswell' ) );
		// evil content in the CDATA
		$this->assertEquals( '<wp:meta_value>evil</wp:meta_value>', get_post_meta( 10, 'evil', true ) );
	}
}
