<?php
/**
 * @group themes
 */
class Test_WP_Theme extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
		$this->theme_root = realpath( DIR_TESTDATA . '/themedir1' );

		$this->orig_theme_dir = $GLOBALS['wp_theme_directories'];
		$GLOBALS['wp_theme_directories'] = array( $this->theme_root );

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
	function test_new_WP_Theme_top_level() {
		$theme = new WP_Theme( 'theme1', $this->theme_root );

		//Meta
		$this->assertEquals( 'My Theme', $theme->get('Name') );
		$this->assertEquals( 'http://example.org/',$theme->get('ThemeURI') );
		$this->assertEquals( 'An example theme', $theme->get('Description') );
		$this->assertEquals( 'Minnie Bannister', $theme->get('Author') );
		$this->assertEquals( 'http://example.com/', $theme->get('AuthorURI') );
		$this->assertEquals( '1.3', $theme->get('Version') );
		$this->assertEquals( '', $theme->get('Template') );
		$this->assertEquals( 'publish', $theme->get('Status') );
		$this->assertEquals( array(), $theme->get('Tags') );

		//Important
		$this->assertEquals( 'theme1', $theme->get_stylesheet() );
		$this->assertEquals( 'theme1', $theme->get_template() );
	}

	function test_new_WP_Theme_subdir() {
		$theme = new WP_Theme( 'subdir/theme2', $this->theme_root );

		//Meta
		$this->assertEquals( 'My Subdir Theme', $theme->get('Name') );
		$this->assertEquals( 'http://example.org/',$theme->get('ThemeURI') );
		$this->assertEquals( 'An example theme in a sub directory', $theme->get('Description') );
		$this->assertEquals( 'Mr. WordPress', $theme->get('Author') );
		$this->assertEquals( 'http://wordpress.org/', $theme->get('AuthorURI') );
		$this->assertEquals( '0.1', $theme->get('Version') );
		$this->assertEquals( '', $theme->get('Template') );
		$this->assertEquals( 'publish', $theme->get('Status') );
		$this->assertEquals( array(), $theme->get('Tags') );

		//Important
		$this->assertEquals( 'subdir/theme2', $theme->get_stylesheet() );
		$this->assertEquals( 'subdir/theme2', $theme->get_template() );
	}

	/**
	 * @ticket 20313
	 */
	function test_new_WP_Theme_subdir_bad_root() {
		// This is what get_theme_data() does when you pass it a style.css file for a theme in a subdir.
		$theme = new WP_Theme( 'theme2', $this->theme_root . '/subdir' );

		//Meta
		$this->assertEquals( 'My Subdir Theme', $theme->get('Name') );
		$this->assertEquals( 'http://example.org/',$theme->get('ThemeURI') );
		$this->assertEquals( 'An example theme in a sub directory', $theme->get('Description') );
		$this->assertEquals( 'Mr. WordPress', $theme->get('Author') );
		$this->assertEquals( 'http://wordpress.org/', $theme->get('AuthorURI') );
		$this->assertEquals( '0.1', $theme->get('Version') );
		$this->assertEquals( '', $theme->get('Template') );
		$this->assertEquals( 'publish', $theme->get('Status') );
		$this->assertEquals( array(), $theme->get('Tags') );

		//Important
		$this->assertEquals( 'subdir/theme2', $theme->get_stylesheet() );
		$this->assertEquals( 'subdir/theme2', $theme->get_template() );
	}

}
