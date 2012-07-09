<?php

/**
 * test wp-includes/theme.php
 *
 * @group themes
 */
class TestDefaultThemes extends WP_UnitTestCase {

	var $theme_slug = 'twentyeleven';
	var $theme_name = 'Twenty Eleven';

	function setUp() {
		parent::setUp();
		add_filter( 'extra_theme_headers', array( $this, '_theme_data_extra_headers' ) );
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
	}

	function tearDown() {
		remove_filter( 'extra_theme_headers', array( $this, '_theme_data_extra_headers' ) );
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
		parent::tearDown();
	}

	function test_wp_get_themes_default() {
		$themes = wp_get_themes();
		$this->assertInstanceOf( 'WP_Theme', $themes[ $this->theme_slug ] );
		$this->assertEquals( $this->theme_name, $themes[ $this->theme_slug ]->get('Name') );

		$single_theme = wp_get_theme( $this->theme_slug );
		$this->assertEquals( $single_theme->get('Name'), $themes[ $this->theme_slug ]->get('Name') );
		$this->assertEquals( $themes[ $this->theme_slug ], $single_theme );
	}

	function test_get_themes_default() {
		$themes = get_themes();
		$this->assertInstanceOf( 'WP_Theme', $themes[ $this->theme_name ] );
		$this->assertEquals( $themes[ $this->theme_name ], get_theme( $this->theme_name ) );

		$this->assertEquals( $this->theme_name, $themes[ $this->theme_name ]['Name'] );
		$this->assertEquals( $this->theme_name, $themes[ $this->theme_name ]->Name );
		$this->assertEquals( $this->theme_name, $themes[ $this->theme_name ]->name );
	}

	function test_get_theme() {
		$themes = get_themes();
		foreach (array_keys($themes) as $name) {
			$theme = get_theme($name);
			// WP_Theme implements ArrayAccess. Even ArrayObject returns false for is_array().
			$this->assertFalse( is_array( $theme ) );
			$this->assertInstanceOf( 'WP_Theme', $theme );
			$this->assertEquals($theme, $themes[$name]);
		}
	}

	function test_wp_get_theme() {
		$themes = wp_get_themes();
		foreach ( $themes as $theme ) {
			$this->assertInstanceOf( 'WP_Theme', $theme );
			$this->assertFalse( $theme->errors() );
			$_theme = wp_get_theme( $theme->get_stylesheet() );
			// This primes internal WP_Theme caches for the next assertion (headers_sanitized, textdomain_loaded)
			$this->assertEquals( $theme->get('Name'), $_theme->get('Name') );
			$this->assertEquals( $theme, $_theme );
		}
	}

	function test_get_themes_contents() {
		$themes = get_themes();

		// Generic tests that should hold true for any theme
		foreach ($themes as $k=>$theme) {
			$this->assertEquals($theme['Name'], $k);
			$this->assertTrue(!empty($theme['Title']));

			// important attributes should all be set
			$default_headers = array(
				'Title' => 'Theme Title',
				'Version' => 'Version',
				'Parent Theme' => 'Parent Theme',
				'Template Dir' => 'Template Dir',
				'Stylesheet Dir' => 'Stylesheet Dir',
				'Template' => 'Template',
				'Stylesheet' => 'Stylesheet',
				'Screenshot' => 'Screenshot',
				'Description' => 'Description',
				'Author' => 'Author',
				'Tags' => 'Tags',
				// Introduced in WordPress 2.9
				'Theme Root' => 'Theme Root',
				'Theme Root URI' => 'Theme Root URI'
			);
			foreach ($default_headers as $name => $value) {
				$this->assertTrue(isset($theme[$name]));
			}

			// Make the tests work both for WordPress 2.8.5 and WordPress 2.9-rare
			$dir = isset($theme['Theme Root']) ? '' : WP_CONTENT_DIR;

			// important attributes should all not be empty as well
			$this->assertTrue(!empty($theme['Description']));
			$this->assertTrue(!empty($theme['Author']));
			$this->assertTrue(is_numeric($theme['Version']));
			$this->assertTrue(!empty($theme['Template']));
			$this->assertTrue(!empty($theme['Stylesheet']));

			// template files should all exist
			$this->assertTrue(is_array($theme['Template Files']));
			$this->assertTrue(count($theme['Template Files']) > 0);
			foreach ($theme['Template Files'] as $file) {
				$this->assertTrue(is_file($dir . $file));
				$this->assertTrue(is_readable($dir . $file));
			}

			// css files should all exist
			$this->assertTrue(is_array($theme['Stylesheet Files']));
			$this->assertTrue(count($theme['Stylesheet Files']) > 0);
			foreach ($theme['Stylesheet Files'] as $file) {
				$this->assertTrue(is_file($dir . $file));
				$this->assertTrue(is_readable($dir . $file));
			}

			$this->assertTrue(is_dir($dir . $theme['Template Dir']));
			$this->assertTrue(is_dir($dir . $theme['Stylesheet Dir']));

			$this->assertEquals('publish', $theme['Status']);

			$this->assertTrue(is_file($dir . $theme['Stylesheet Dir'] . '/' . $theme['Screenshot']));
			$this->assertTrue(is_readable($dir . $theme['Stylesheet Dir'] . '/' . $theme['Screenshot']));
		}
	}

	/**
	 * @ticket 20897
	 */
	function test_extra_theme_headers() {
		$wp_theme = wp_get_theme( $this->theme_slug );
		$this->assertNotEmpty( $wp_theme->get('License') );
		$path_to_style_css = $wp_theme->get_theme_root() . '/' . $wp_theme->get_stylesheet() . '/style.css';
		$this->assertTrue( file_exists( $path_to_style_css ) );
		$theme_data = get_theme_data( $path_to_style_css );
		$this->assertArrayHasKey( 'License', $theme_data );
		$this->assertArrayNotHasKey( 'Not a Valid Key', $theme_data );
		$this->assertNotEmpty( $theme_data['License'] );
		$this->assertSame( $theme_data['License'], $wp_theme->get('License') );
	}

	function _theme_data_extra_headers() {
		return array( 'License' );
	}

	function test_switch_theme() {
		$themes = get_themes();

		$switch_theme_one_argument = version_compare( $GLOBALS['wp_version'], '3.5-alpha-21103', '>=' );

		// switch to each theme in sequence
		// do it twice to make sure we switch to the first theme, even if it's our starting theme
		for ( $i = 0; $i < 3; $i++ ) {
			foreach ($themes as $name=>$theme) {
				// switch to this theme
				if ( $i === 2 || $switch_theme_one_argument )
					switch_theme( $theme['Template'], $theme['Stylesheet'] );
				else
					switch_theme( $theme['Stylesheet'] );

				$this->assertEquals($name, get_current_theme());

				// make sure the various get_* functions return the correct values
				$this->assertEquals($theme['Template'], get_template());
				$this->assertEquals($theme['Stylesheet'], get_stylesheet());

				$root_fs = get_theme_root();
				$this->assertTrue(is_dir($root_fs));

				$root_uri = get_theme_root_uri();
				$this->assertTrue(!empty($root_uri));

				$this->assertEquals($root_fs . '/' . get_stylesheet(), get_stylesheet_directory());
				$this->assertEquals($root_uri . '/' . get_stylesheet(), get_stylesheet_directory_uri());
				$this->assertEquals($root_uri . '/' . get_stylesheet() . '/style.css', get_stylesheet_uri());
#				$this->assertEquals($root_uri . '/' . get_stylesheet(), get_locale_stylesheet_uri());

				$this->assertEquals($root_fs . '/' . get_template(), get_template_directory());
				$this->assertEquals($root_uri . '/' . get_template(), get_template_directory_uri());

				//get_query_template

				// template file that doesn't exist
				$this->assertEquals('', get_query_template(rand_str()));

				// template files that do exist
				//foreach ($theme['Template Files'] as $path) {
				//$file = basename($path, '.php');
				// FIXME: untestable because get_query_template uses TEMPLATEPATH
				//$this->assertEquals('', get_query_template($file));
				//}

				// these are kind of tautologies but at least exercise the code
				$this->assertEquals(get_404_template(), get_query_template('404'));
				$this->assertEquals(get_archive_template(), get_query_template('archive'));
				$this->assertEquals(get_author_template(), get_query_template('author'));
				$this->assertEquals(get_category_template(), get_query_template('category'));
				$this->assertEquals(get_date_template(), get_query_template('date'));
				$this->assertEquals(get_home_template(), get_query_template('home', array('home.php','index.php')));
				$this->assertEquals(get_page_template(), get_query_template('page'));
				$this->assertEquals(get_paged_template(), get_query_template('paged'));
				$this->assertEquals(get_search_template(), get_query_template('search'));
				$this->assertEquals(get_single_template(), get_query_template('single'));
				$this->assertEquals(get_attachment_template(), get_query_template('attachment'));

				// this one doesn't behave like the others
				if (get_query_template('comments-popup'))
					$this->assertEquals(get_comments_popup_template(), get_query_template('comments-popup'));
				else
					$this->assertEquals(get_comments_popup_template(), ABSPATH.'wp-includes/theme-compat/comments-popup.php');

				$this->assertEquals(get_tag_template(), get_query_template('tag'));

				// nb: this probably doesn't run because WP_INSTALLING is defined
				$this->assertTrue(validate_current_theme());
			}
		}
	}

	function test_switch_theme_bogus() {
		// try switching to a theme that doesn't exist
		$template = rand_str();
		$style = rand_str();
		update_option('template', $template);
		update_option('stylesheet', $style);

		$theme = wp_get_theme();
		$this->assertEquals( $style, (string) $theme );
		$this->assertNotSame( false, $theme->errors() );
		$this->assertFalse( $theme->exists() );

		// these return the bogus name - perhaps not ideal behaviour?
		$this->assertEquals($template, get_template());
		$this->assertEquals($style, get_stylesheet());
	}
}

/**
 * Test functions that fetch stuff from the theme directory
 *
 * @group themes
 */
class TestThemeDir extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
		$this->theme_root = DIR_TESTDATA . '/themedir1';

		$this->orig_theme_dir = $GLOBALS['wp_theme_directories'];

		// /themes is necessary as theme.php functions assume /themes is the root if there is only one root.
		$GLOBALS['wp_theme_directories'] = array( WP_CONTENT_DIR . '/themes', $this->theme_root );

		add_filter('theme_root', array(&$this, '_theme_root'));
		add_filter( 'stylesheet_root', array(&$this, '_theme_root') );
		add_filter( 'template_root', array(&$this, '_theme_root') );
		// clear caches
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
	}

	function tearDown() {
		$GLOBALS['wp_theme_directories'] = $this->orig_theme_dir;
		remove_filter('theme_root', array(&$this, '_theme_root'));
		remove_filter( 'stylesheet_root', array(&$this, '_theme_root') );
		remove_filter( 'template_root', array(&$this, '_theme_root') );
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
		parent::tearDown();
	}

	// replace the normal theme root dir with our premade test dir
	function _theme_root($dir) {
		return $this->theme_root;
	}

	function test_theme_default() {
		$themes = get_themes();
		$theme = get_theme('WordPress Default');
		$this->assertEquals( $themes['WordPress Default'], $theme );

		$this->assertFalse( empty($theme) );

		#echo gen_tests_array('theme', $theme);

		$this->assertEquals( 'WordPress Default', $theme['Name'] );
		$this->assertEquals( 'WordPress Default', $theme['Title'] );
		$this->assertEquals( 'The default WordPress theme based on the famous <a href="http://binarybonsai.com/kubrick/">Kubrick</a>.', $theme['Description'] );
		$this->assertEquals( '<a href="http://binarybonsai.com/" title="Visit author homepage">Michael Heilemann</a>', $theme['Author'] );
		$this->assertEquals( '1.6', $theme['Version'] );
		$this->assertEquals( 'default', $theme['Template'] );
		$this->assertEquals( 'default', $theme['Stylesheet'] );

		$this->assertContains( $this->theme_root . '/default/functions.php', $theme['Template Files'] );
		$this->assertContains( $this->theme_root . '/default/index.php', $theme['Template Files'] );
		$this->assertContains( $this->theme_root . '/default/style.css', $theme['Stylesheet Files'] );

		$this->assertEquals( $this->theme_root.'/default', $theme['Template Dir'] );
		$this->assertEquals( $this->theme_root.'/default', $theme['Stylesheet Dir'] );
		$this->assertEquals( 'publish', $theme['Status'] );
		$this->assertEquals( '', $theme['Parent Theme'] );
	}

	function test_theme_sandbox() {
		$theme = get_theme('Sandbox');

		$this->assertFalse( empty($theme) );

		#echo gen_tests_array('theme', $theme);

		$this->assertEquals( 'Sandbox', $theme['Name'] );
		$this->assertEquals( 'Sandbox', $theme['Title'] );
		$this->assertEquals( 'A theme with powerful, semantic CSS selectors and the ability to add new skins.', $theme['Description'] );
		$this->assertEquals( '<a href="http://andy.wordpress.com/">Andy Skelton</a> &amp; <a href="http://www.plaintxt.org/">Scott Allan Wallick</a>', $theme['Author'] );
		$this->assertEquals( '0.6.1-wpcom', $theme['Version'] );
		$this->assertEquals( 'sandbox', $theme['Template'] );
		$this->assertEquals( 'sandbox', $theme['Stylesheet'] );
		$this->assertEquals( $this->theme_root.'/sandbox/functions.php', reset($theme['Template Files']) );
		$this->assertEquals( $this->theme_root.'/sandbox/index.php', next($theme['Template Files']) );

		$this->assertEquals( $this->theme_root.'/sandbox/style.css', reset($theme['Stylesheet Files']) );

		$this->assertEquals( $this->theme_root.'/sandbox', $theme['Template Dir'] );
		$this->assertEquals( $this->theme_root.'/sandbox', $theme['Stylesheet Dir'] );
		$this->assertEquals( 'publish', $theme['Status'] );
		$this->assertEquals( '', $theme['Parent Theme'] );

	}

	// a css only theme
	function test_theme_stylesheet_only() {
		$themes = get_themes();

		$theme = $themes['Stylesheet Only'];
		$this->assertFalse( empty($theme) );

		#echo gen_tests_array('theme', $theme);

		$this->assertEquals( 'Stylesheet Only', $theme['Name'] );
		$this->assertEquals( 'Stylesheet Only', $theme['Title'] );
		$this->assertEquals( 'A three-column widget-ready theme in dark blue.', $theme['Description'] );
		$this->assertEquals( '<a href="http://www.example.com/" title="Visit author homepage">Henry Crun</a>', $theme['Author'] );
		$this->assertEquals( '1.0', $theme['Version'] );
		$this->assertEquals( 'sandbox', $theme['Template'] );
		$this->assertEquals( 'stylesheetonly', $theme['Stylesheet'] );
		$this->assertContains( $this->theme_root.'/sandbox/functions.php', $theme['Template Files'] );
		$this->assertContains( $this->theme_root.'/sandbox/index.php', $theme['Template Files'] );

		$this->assertContains( $this->theme_root.'/stylesheetonly/style.css', $theme['Stylesheet Files']);

		$this->assertEquals( $this->theme_root.'/sandbox', $theme['Template Dir'] );
		$this->assertEquals( $this->theme_root.'/stylesheetonly', $theme['Stylesheet Dir'] );
		$this->assertEquals( 'publish', $theme['Status'] );
		$this->assertEquals( 'Sandbox', $theme['Parent Theme'] );

	}

	function test_theme_list() {
		$themes = get_themes();

		// Ignore themes in the default /themes directory.
		foreach ( $themes as $theme_name => $theme ) {
			if ( $theme->get_theme_root() != $this->theme_root )
				unset( $themes[ $theme_name ] );
		}

		$theme_names = array_keys($themes);
		$expected = array(
			'WordPress Default',
			'Sandbox',
			'Stylesheet Only',
			'My Theme',
			'My Theme/theme1', // duplicate theme should be given a unique name
			'My Subdir Theme',// theme in a subdirectory should work
			'Page Template Theme', // theme with page templates for other test code
		);

		sort($theme_names);
		sort($expected);

		$this->assertEquals($expected, $theme_names);
	}

	function test_broken_themes() {
		$themes = get_themes();
		$expected = array('broken-theme' => array('Name' => 'broken-theme', 'Title' => 'broken-theme', 'Description' => __('Stylesheet is missing.')));

		$this->assertEquals($expected, get_broken_themes() );
	}

	function test_wp_get_theme_with_non_default_theme_root() {
		$this->assertFalse( wp_get_theme( 'sandbox', $this->theme_root )->errors() );
		$this->assertFalse( wp_get_theme( 'sandbox' )->errors() );
	}

	function test_page_templates() {
		$themes = get_themes();

		$theme = $themes['Page Template Theme'];
		$this->assertFalse( empty($theme) );

		$templates = $theme['Template Files'];
		$this->assertTrue( in_array( $this->theme_root . '/page-templates/template-top-level.php', $templates));
	}

	function test_get_theme_data_top_level() {
		$theme_data = get_theme_data( DIR_TESTDATA . '/themedir1/theme1/style.css' );

		$this->assertEquals( 'My Theme', $theme_data['Name'] );
		$this->assertEquals( 'http://example.org/', $theme_data['URI'] );
		$this->assertEquals( 'An example theme', $theme_data['Description'] );
		$this->assertEquals( '<a href="http://example.com/" title="Visit author homepage">Minnie Bannister</a>', $theme_data['Author'] );
		$this->assertEquals( 'http://example.com/', $theme_data['AuthorURI'] );
		$this->assertEquals( '1.3', $theme_data['Version'] );
		$this->assertEquals( '', $theme_data['Template'] );
		$this->assertEquals( 'publish', $theme_data['Status'] );
		$this->assertEquals( array(), $theme_data['Tags'] );
		$this->assertEquals( 'My Theme', $theme_data['Title'] );
		$this->assertEquals( 'Minnie Bannister', $theme_data['AuthorName'] );
	}

	function test_get_theme_data_subdir() {
		$theme_data = get_theme_data( $this->theme_root . '/subdir/theme2/style.css' );

		$this->assertEquals( 'My Subdir Theme', $theme_data['Name'] );
		$this->assertEquals( 'http://example.org/', $theme_data['URI'] );
		$this->assertEquals( 'An example theme in a sub directory', $theme_data['Description'] );
		$this->assertEquals( '<a href="http://wordpress.org/" title="Visit author homepage">Mr. WordPress</a>', $theme_data['Author'] );
		$this->assertEquals( 'http://wordpress.org/', $theme_data['AuthorURI'] );
		$this->assertEquals( '0.1', $theme_data['Version'] );
		$this->assertEquals( '', $theme_data['Template'] );
		$this->assertEquals( 'publish', $theme_data['Status'] );
		$this->assertEquals( array(), $theme_data['Tags'] );
		$this->assertEquals( 'My Subdir Theme', $theme_data['Title'] );
		$this->assertEquals( 'Mr. WordPress', $theme_data['AuthorName'] );
	}

}

/**
 * @group themes
 */
class TestLargeThemeDir extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
		$this->theme_root = DIR_TESTDATA . '/wpcom-themes';

		$this->orig_theme_dir = $GLOBALS['wp_theme_directories'];
		$GLOBALS['wp_theme_directories'] = array( WP_CONTENT_DIR . '/themes', $this->theme_root );

		add_filter('theme_root', array(&$this, '_theme_root'));

		// clear caches
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
	}

	function tearDown() {
		$GLOBALS['wp_theme_directories'] = $this->orig_theme_dir;
		remove_filter('theme_root', array(&$this, '_theme_root'));
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
		parent::tearDown();
	}

	// replace the normal theme root dir with our premade test dir
	function _theme_root($dir) {
		return $this->theme_root;
	}

	function _filter_out_themes_not_in_root( &$themes ) {
		foreach ( $themes as $key => $theme ) {
			if ( $theme->get_theme_root() != $this->theme_root )
				unset( $themes[ $key ] );
		}
	}

	function test_theme_list() {
		$themes = get_themes();
		$this->_filter_out_themes_not_in_root( $themes );
		$theme_names = array_keys( $themes );
		$this->assertEquals(87, count( $theme_names ) );
		$length = strlen( serialize( $themes ) );

		//2.9 pre [12226]
		$this->assertLessThanOrEqual(387283, $length );
		//2.8.5
		$this->assertLessThanOrEqual(368319, $length );
		//2.9 post [12226]
		$this->assertLessThanOrEqual(261998, $length );
		//3.4 post [20029], #20103
		$this->assertLessThanOrEqual(100000, $length );
	}

	/**
	 * Reducing in-memory size further.
	 *
	 * @ticket 11214
	 */
	function test_smaller_storage() {
		$themes = get_themes();
		$this->_filter_out_themes_not_in_root( $themes );
		$theme_names = array_keys($themes);
		$this->assertEquals(87, count($theme_names));
		$this->assertLessThanOrEqual(136342, strlen(serialize($themes)));
	}
}

/**
 * @group themes
 */
class TestThemeSupport extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
	}

	function tearDown() {
		parent::tearDown();
	}

	function test_the_basics() {
		add_theme_support( 'automatic-feed-links' );
		$this->assertTrue( current_theme_supports( 'automatic-feed-links' ) );
		remove_theme_support( 'automatic-feed-links' );
		$this->assertFalse( current_theme_supports( 'automatic-feed-links' ) );
		add_theme_support( 'automatic-feed-links' );
		$this->assertTrue( current_theme_supports( 'automatic-feed-links' ) );
	}

	function test_admin_bar() {
		add_theme_support( 'admin-bar' );
		$this->assertTrue( current_theme_supports( 'admin-bar' ) );
		remove_theme_support( 'admin-bar' );
		$this->assertFalse( current_theme_supports( 'admin-bar' ) );
		add_theme_support( 'admin-bar' );
		$this->assertTrue( current_theme_supports( 'admin-bar' ) );

		add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );
		$this->assertTrue( current_theme_supports( 'admin-bar' ) );

		$this->assertEquals(
			array( 0 => array( 'callback' => '__return_false' ) ),
			get_theme_support( 'admin-bar' )
		);
		remove_theme_support( 'admin-bar' );
		$this->assertFalse( current_theme_supports( 'admin-bar' ) );
		$this->assertFalse( get_theme_support( 'admin-bar' ) );
	}

	function test_post_thumbnails() {
		add_theme_support( 'post-thumbnails' );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		remove_theme_support( 'post-thumbnails' );
		$this->assertFalse( current_theme_supports( 'post-thumbnails' ) );
		add_theme_support( 'post-thumbnails' );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );

		// simple array of post types.
		add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails', 'post' ) );
		$this->assertFalse( current_theme_supports( 'post-thumbnails', 'book' ) );
		remove_theme_support( 'post-thumbnails' );
		$this->assertFalse( current_theme_supports( 'post-thumbnails' ) );

		#WP18548
		if ( ! function_exists( '_wp_render_title_tag' ) )
			return;

		// array of arguments, with the key of 'types' holding the post types.
		add_theme_support( 'post-thumbnails', array( 'types' => array( 'post', 'page' ) ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails', 'post' ) );
		$this->assertFalse( current_theme_supports( 'post-thumbnails', 'book' ) );
		remove_theme_support( 'post-thumbnails' );
		$this->assertFalse( current_theme_supports( 'post-thumbnails' ) );

		// array of arguments, with the key of 'types' holding the post types.
		add_theme_support( 'post-thumbnails', array( 'types' => true ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails', rand_str() ) ); // any type
		remove_theme_support( 'post-thumbnails' );
		$this->assertFalse( current_theme_supports( 'post-thumbnails' ) );

		// array of arguments, with some other argument, and no 'types' argument.
		add_theme_support( 'post-thumbnails', array( rand_str() => rand_str() ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails', rand_str() ) ); // any type
		remove_theme_support( 'post-thumbnails' );
		$this->assertFalse( current_theme_supports( 'post-thumbnails' ) );

	}

	function supports_foobar( $yesno, $args, $feature ) {
		if ( $args[0] == $feature[0] )
			return true;
		return false;
	}

	function test_plugin_hook() {
		$this->assertFalse( current_theme_supports( 'foobar' ) );
		add_theme_support( 'foobar' );
		$this->assertTrue( current_theme_supports( 'foobar' ) );

		add_filter( 'current_theme_supports-foobar', array( $this, 'supports_foobar'), 10, 3 );

		add_theme_support( 'foobar', 'bar' );
		$this->assertFalse( current_theme_supports( 'foobar', 'foo' ) );
		$this->assertTrue( current_theme_supports( 'foobar', 'bar' ) );

		remove_theme_support( 'foobar' );
		$this->assertFalse( current_theme_supports( 'foobar', 'bar' ) );
	}
}
