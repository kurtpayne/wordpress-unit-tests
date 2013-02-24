<?php

add_action( 'init', array('P2JS', 'init') );

class P2JS {
	
	function init() {
		if ( !is_admin() ) {
			add_action( 'wp_print_scripts', array('P2JS', 'enqueue_scripts') );
		}
		add_action('wp_head', array('P2JS', 'print_options'));
	}
	
	function enqueue_scripts() {
		global $wp_locale;
		
	    wp_enqueue_script( 'jquery-color' );
		wp_enqueue_script( 'comment-reply' );

		if ( is_user_logged_in() ) {
			wp_enqueue_script( 'suggest' );
			wp_enqueue_script( 'jeditable', P2_JS_URL . '/jquery.jeditable.js', array( 'jquery' )  );
		}

		//bust the cache here	
		wp_enqueue_script( 'p2js', P2_JS_URL . '/p2.js', array( 'jquery', 'utils' ), filemtime(P2_JS_PATH . '/p2.js') );
		wp_localize_script( 'p2js', 'p2txt', array(
		    'tagit' => __('Tag it', 'p2'),
		    'goto_homepage' => __('Go to homepage', 'p2'),
		    // the number is calculated in the javascript in a complex way, so we can't use ngettext
		    'n_new_updates' => __('%d new update(s)', 'p2'),
		    'n_new_comments' => __('%d new comment(s)', 'p2'),
		    'jump_to_top' => __('Jump to top', 'p2'),
		    'not_posted_error' => __('An error has occured, your post was not posted', 'p2'),
		    'update_posted' => __('You update has been posted', 'p2'),
		    'loading' => __('Loading...', 'p2'),
		    'cancel' => __('Cancel', 'p2'),
		    'save' => __('Save', 'p2'),
		    'hide_threads' => __('Hide threads', 'p2'),
		    'show_threads' => __('Show threads', 'p2'),
			'unsaved_changes' => __('Your comments or posts will be lost if you continue.', 'p2'),
			'date_time_format' => __('%1$s <em>on</em> %2$s', 'p2'),
			'date_format' => get_option('date_format'),
			'time_format' => get_option('time_format'),
			// if we don't convert the entities to characters, we can't get < and > inside
			'l10n_print_after' => 'try{convertEntities(p2txt);}catch(e){};',
		));
			
		wp_enqueue_script( 'scrollit', P2_JS_URL .'/jquery.scrollTo-min.js', array( 'jquery' )  );

		wp_enqueue_script( 'wp-locale', P2_JS_URL . '/wp-locale.js', array(), filemtime(P2_JS_PATH . '/wp-locale.js') );

		// the localization functinality can't handle objects, that's why
		// we are using poor man's hash maps here -- using prefixes of the variable names
		$wp_locale_txt = array();
		
		foreach( $wp_locale->month as $key => $month ) $wp_locale_txt["month_$key"] = $month;
		$i = 1;
		foreach( $wp_locale->month_abbrev as $key => $month ) $wp_locale_txt["monthabbrev_".sprintf('%02d', $i++)] = $month;
		foreach( $wp_locale->weekday as $key => $day ) $wp_locale_txt["weekday_$key"] = $day;
		$i = 1;
		foreach( $wp_locale->weekday_abbrev as $key => $day ) $wp_locale_txt["weekdayabbrev_".sprintf('%02d', $i++)] = $day;
		wp_localize_script( 'wp-locale', 'wp_locale_txt', $wp_locale_txt);
	}
	
	function print_options() {
		get_currentuserinfo();
		$page_options['nonce']= wp_create_nonce( 'ajaxnonce' );
		$page_options['prologue_updates'] = 1;
		$page_options['prologue_comments_updates'] = 1;
		$page_options['prologue_tagsuggest'] = 1;
		$page_options['prologue_inlineedit'] = 1;
		$page_options['prologue_comments_inlineedit'] = 1;
		$page_options['is_single'] = (int)is_single();
		$page_options['is_page'] = (int)is_page();
		$page_options['is_front_page'] = (int)is_front_page();
		$page_options['is_first_front_page'] = (int)(is_front_page() && !is_paged() );
		$page_options['is_user_logged_in'] = (int)is_user_logged_in();
		$page_options['login_url'] = wp_login_url( ( ( !empty($_SERVER['HTTPS'] ) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
?>
	<script type="text/javascript" charset="<?php bloginfo('charset'); ?>">
		// <![CDATA[
		// Prologue Configuration
		// TODO: add these int the localize block
		var ajaxUrl = "<?php echo js_escape( get_bloginfo( 'siteurl' ) . '/?p2ajax' ); ?>";
		var updateRate = "30000";
		var nonce = "<?php echo js_escape( $page_options['nonce'] ); ?>";
		var login_url = "<?php echo $page_options['login_url'] ?>";
		var templateDir  = "<?php js_escape( bloginfo('template_directory') ); ?>";
		var isFirstFrontPage = <?php echo $page_options['is_first_front_page'] ?>;
		var isFrontPage = <?php echo $page_options['is_front_page'] ?>;
		var isSingle = <?php echo $page_options['is_single'] ?>;
		var isPage = <?php echo $page_options['is_page'] ?>;
		var isUserLoggedIn = <?php echo $page_options['is_user_logged_in'] ?>;
		var prologueTagsuggest = <?php echo $page_options['prologue_tagsuggest'] ?>;
		var prologuePostsUpdates = <?php echo $page_options['prologue_updates'] ?>;
		var prologueCommentsUpdates = <?php echo $page_options['prologue_comments_updates']; ?>;
		var getPostsUpdate = 0;
		var getCommentsUpdate = 0;
		var inlineEditPosts =  <?php echo $page_options['prologue_inlineedit'] ?>;
		var inlineEditComments =  <?php echo $page_options['prologue_comments_inlineedit'] ?>;
		var wpUrl = "<?php echo js_escape( get_bloginfo( 'wpurl' ) ); ?>";
		var rssUrl = "<?php js_escape( get_bloginfo( 'rss_url' ) ); ?>";
		var pageLoadTime = "<?php echo gmdate('Y-m-d H:i:s'); ?>";
		var latestPermalink = "<?php echo js_escape( latest_post_permalink() ); ?>";
		var original_title = document.title;
		var commentsOnPost = new Array;
		var postsOnPage = new Array;
		var postsOnPageQS = '';
		var currPost = -1;
		var currComment = -1;
		var commentLoop = false;
		var lcwidget = false;
		var hidecomments = false;
		var commentsLists = '';
		var newUnseenUpdates = 0;
		 // ]]>
		</script>
<?php		
	}
}

function p2_toggle_threads() {
	$hide_threads = get_option( 'p2_hide_threads' ); ?>

	<script type="text/javascript">
		jQuery(document).ready( function() {
			<?php if ( (int)$hide_threads ) : ?>
				jQuery('.commentlist').toggle();
				jQuery('.discussion').toggle();
			<?php endif; ?>
			
			jQuery("#togglecomments").click( function(){
				jQuery('.discussion').toggle();
				jQuery('.commentlist').toggle();
				return false;
			});
		});
	</script><?php
}
add_action( 'wp_footer', 'p2_toggle_threads' );
