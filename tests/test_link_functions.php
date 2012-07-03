<?php

// tests for link-template.php and related URL functions
class TestSSLLinks extends WP_UnitTestCase {
	var $_old_server;
	function setUp() {
		$this->_old_server = $_SERVER;
	}

	function tearDown() {
		$_SERVER = $this->_old_server;
	}

	function test_is_ssl_positive() {
		$_SERVER['HTTPS'] = 'on';
		$this->assertTrue( is_ssl() );

		$_SERVER['HTTPS'] = 'ON';
		$this->assertTrue( is_ssl() );

		$_SERVER['HTTPS'] = '1';
		$this->assertTrue( is_ssl() );

		unset( $_SERVER['HTTPS'] );
		$_SERVER['SERVER_PORT'] = '443';
		$this->assertTrue( is_ssl() );
	}

	function test_is_ssl_negative() {
		$_SERVER['HTTPS'] = 'off';
		$this->assertFalse( is_ssl() );

		$_SERVER['HTTPS'] = 'OFF';
		$this->assertFalse( is_ssl() );

		unset($_SERVER['HTTPS']);
		$this->assertFalse( is_ssl() );
	}

	function test_admin_url_valid() {
		$paths = array(
			'' => "/wp-admin/",
			'foo' => "/wp-admin/foo",
			'/foo' => "/wp-admin/foo",
			'/foo/' => "/wp-admin/foo/",
			'foo.php' => "/wp-admin/foo.php",
			'/foo.php' => "/wp-admin/foo.php",
			'/foo.php?bar=1' => "/wp-admin/foo.php?bar=1",
		);
		$https = array('on', 'off');

		foreach ($https as $val) {
			$_SERVER['HTTPS'] = $val;
			$siteurl = get_option('siteurl');
			if ( $val == 'on' )
				$siteurl = str_replace('http://', 'https://', $siteurl);

			foreach ($paths as $in => $out) {
				$this->assertEquals( $siteurl.$out, admin_url($in), "admin_url('{$in}') should equal '{$siteurl}{$out}'");
			}
		}
	}

	function test_admin_url_invalid() {
		$paths = array(
			null => "/wp-admin/",
			0 => "/wp-admin/",
			-1 => "/wp-admin/",
			'../foo/' => "/wp-admin/",
			'///' => "/wp-admin/",
		);
		$https = array('on', 'off');

		foreach ($https as $val) {
			$_SERVER['HTTPS'] = $val;
			$siteurl = get_option('siteurl');
			if ( $val == 'on' )
				$siteurl = str_replace('http://', 'https://', $siteurl);

			foreach ($paths as $in => $out) {
				$this->assertEquals( $siteurl.$out, admin_url($in), "admin_url('{$in}') should equal '{$siteurl}{$out}'");
			}
		}
	}

	function test_set_url_scheme() {
		if ( ! function_exists( 'set_url_scheme' ) )
			return;

		$links = array(
			'http://wordpress.org/',
			'https://wordpress.org/',
			'http://wordpress.org/news/',
			'http://wordpress.org',
		);

		$https_links = array(
			'https://wordpress.org/',
			'https://wordpress.org/',
			'https://wordpress.org/news/',
			'https://wordpress.org',
		);

		$http_links = array(
			'http://wordpress.org/',
			'http://wordpress.org/',
			'http://wordpress.org/news/',
			'http://wordpress.org',
		);

		$relative_links = array(
			'/',
			'/',
			'/news/',
			''
		);

		$forced_admin = force_ssl_admin();
		$forced_login = force_ssl_login();
		$i = 0;
		foreach ( $links as $link ) {
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link, 'https' ) );
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link, 'http' ) );
			$this->assertEquals( $relative_links[ $i ], set_url_scheme( $link, 'relative' ) );

			$_SERVER['HTTPS'] = 'on';
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link ) );

			$_SERVER['HTTPS'] = 'off';
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link ) );

			force_ssl_login( false );
			force_ssl_admin( true );
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link, 'admin' ) );
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link, 'login_post' ) );
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link, 'login' ) );
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link, 'rpc' ) );

			force_ssl_admin( false );
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link, 'admin' ) );
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link, 'login_post' ) );
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link, 'login' ) );
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link, 'rpc' ) );

			force_ssl_login( true );
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link, 'admin' ) );
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link, 'login_post' ) );
			$this->assertEquals( $http_links[ $i ], set_url_scheme( $link, 'login' ) );
			$this->assertEquals( $https_links[ $i ], set_url_scheme( $link, 'rpc' ) );

			$i++;
		}

		force_ssl_admin( $forced_admin );
		force_ssl_login( $forced_login );
	}
}
