<?php

add_action( 'init', array('P2', 'init') );

class P2 {
	function init() {
	    load_theme_textdomain( 'p2', get_template_directory() . '/languages' );
	
		add_filter( 'the_content', 'make_clickable' );
		
		if ( isset( $_REQUEST['p2ajax'] ) ) {
			require_once( P2_INC_PATH . '/ajax.php' );
			P2Ajax::dispatch();
			die();
		}

		if ( function_exists( 'is_site_admin' ) && !is_site_admin() ) return;

		$is_media_upload = isset( $_REQUEST['p2-upload'] );

		// don't redirect to https version when uploading files, since the domain may be different
		// and we don't have SSL certificates for blog domain, only for admin
		if ( $is_media_upload && isset( $GLOBALS['pagenow'] ) && 'media-upload.php' == $GLOBALS['pagenow'] ) {	
			force_ssl_admin( is_ssl() );
			add_filter( 'get_user_option_use_ssl', returner( false ) );
		}

		if ( $is_media_upload ) {
			add_filter( 'flash_uploader', returner( false) );
			add_filter( 'auth_redirect_scheme', returner( 'logged_in' ) );
			add_filter( 'admin_url', array('P2', 'url_filter') );
			add_filter( 'includes_url', array('P2', 'url_filter') );
			add_filter( 'script_loader_src', array('P2', 'url_filter') );
			add_filter( 'wp_get_attachment_url', lambda( '$url', 'str_replace(get_bloginfo("siteurl")."/", site_url("/"), $url);'), 11);
			add_filter( 'media_upload_form_url', lambda( '$url', 'add_query_arg( array( "p2-upload" => "" ), $url );' ) );
		}
	}

	function media_buttons() {
		include_once ABSPATH . '/wp-admin/includes/media.php'; 
		ob_start();
		do_action( 'media_buttons' );
		return P2::make_media_urls_absolute( ob_get_clean() );
	}

	/**
	 * Make sure the URL is loaded from the same domain as the frontend
	 */
	function url_filter( $url, $path = '' ) {
		$parsed = parse_url( $url );
		$host = $parsed['host'];
		return preg_replace( '|https?://'.preg_quote( $host ).'|', get_bloginfo('wpurl'), $url );
	}

	function admin_url( $path ) {
		return P2::url_filter( admin_url( $path ) );
	} 

	function make_media_urls_absolute( $string ) {
		$string = str_replace( 'images/', P2::admin_url( 'images/' ), $string );
		// This line does not work in .org
		return str_replace( 'media-upload.php?', P2::admin_url( 'media-upload.php?p2-upload&' ), $string );
	}
}
