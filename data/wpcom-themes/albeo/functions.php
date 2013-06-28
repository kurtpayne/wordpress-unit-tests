<?php

$content_width = 480;

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '8E8778',
	'link' => 'BBD1D8',
	'border' => 'ffffff',
	'url' => 'BBD1D8'
);

if ( function_exists('register_sidebar') )
    register_sidebars(1, array(
        'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-all">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));

function dp_recent_comments($no_comments = 10, $comment_len = 150) {
    global $wpdb;
	
	$request = "SELECT * FROM $wpdb->comments";
	$request .= " JOIN $wpdb->posts ON ID = comment_post_ID";
	$request .= " WHERE comment_approved = '1' AND post_status = 'publish' AND post_password =''";
	$request .= " ORDER BY comment_date DESC LIMIT $no_comments";
		
	$comments = $wpdb->get_results($request);
		
	if ($comments) {
		foreach ($comments as $comment) {
			ob_start();
			?>
				<li>
					<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>"><?php echo dp_get_author($comment); ?>:</a>
					<?php echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len)); ?>
				</li>
			<?php
			ob_end_flush();
		}
	} else {
		echo '<li>'.__('No comments yet', 'albeo').'</li>';
	}
}

function dp_get_author($comment) {
	$author = "";

	if ( empty($comment->comment_author) )
		$author = __('Anonymous', 'albeo');
	else
		$author = $comment->comment_author;
		
	return $author;
}

// Widgets!!!

register_sidebar_widget( __('Albeo Top/Latest/Tags', 'albeo') , 'albeo_selector' );
function albeo_selector() { ?>
	<div class="recent-all"><div class="recent">
	 <ul class="tabs">
<?php if (function_exists('display_top_posts')): ?>
	  <li><a href="#r-posts"><span><?php _e('Top Posts', 'albeo'); ?></span></a></li>
<?php endif; ?>
	  <li><a href="#r-com"><span><?php _e('Latest Comments', 'albeo'); ?></span></a></li>
	  <li><a href="#r-tags"><span><?php _e('Tags', 'albeo'); ?></span></a></li>
	 </ul>
	 <br clear="all" />
<?php if (function_exists('display_top_posts')): ?>
	<div id="r-posts">
		<?php display_top_posts(10); ?>
	</div>
<?php endif; ?>
	<ul id="r-com">
	 <?php dp_recent_comments(3); ?>
	</ul>
	<div id="r-tags">
	 <?php wp_tag_cloud(''); ?>
	</div>
	</div></div>	
<?php }

register_sidebar_widget( __('Albeo Search', 'albeo') , 'albeo_search' );
function albeo_search() { ?>
	<div class="search-all"><div class="search">
	 <h3><?php _e('Search', 'albeo'); ?></h3>
	  <form id="search" action="<?php bloginfo('url'); ?>/">
	    <fieldset>
	    <input type="text" value="<?php the_search_query(); ?>" name="s" style="width: 200px;" />
	    </fieldset>
	    </form>
	</div></div>
<?php }