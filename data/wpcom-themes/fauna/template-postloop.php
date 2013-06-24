<?php /*
	Post Template
	This page holds the code used by category.php, date.php, index.php and single.php.
	It it is the default post design.
	*/
?>

<?php /* Guess Noteworthy categories */
$noteworthy_cat = $wpdb->get_var("SELECT t.term_id FROM $wpdb->terms as t, $wpdb->term_taxonomy as tt WHERE tt.taxonomy='category' AND t.term_id=tt.term_id AND t.slug='noteworthy'");
		
?>

<div <?php post_class( 'box entry' ); ?>>

	<?php /* Show entry date on everything but permalinks */
			if (!is_single()) { ?>
	<div class="entry-date">
		<p><?php comments_popup_link(__('Leave a Comment'), __('Comments (1)'), __('Comments (%)'), '', __('<span>Comments Off</span>') ); ?></p>
	</div>
	<?php } ?>
	
	<?php /* Noteworthies */ ?>
	<?php if ( in_category($noteworthy_cat) ) { ?><div class="noteworthy"><?php echo(noteworthy_link($noteworthy_cat,TRUE,'')); ?></div>
	<?php } ?>

	<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
	<?php /* If we're not on a permalink and there's a written excerpt, only that */
			if (!is_single() && $post->post_excerpt != "") { the_excerpt(); } else { ?> 
	<?php /* If we're not on a permalink and there's NO written excerpt, show content until <!--more--> */
			the_content('Continue reading this entry &raquo;'); } ?>
	
	<?php wp_link_pages('before=<strong>Page: &after=</strong>&next_or_number=number&pagelink=%'); ?>

	<?php /* If we're on the homepage, show some meta information right here */
			if (is_home()) { ?>
	<div class="entry-meta">
		<?php _e("Filed in"); ?> 
		<?php the_category(',') ?> 
		<?php the_tags( ' and ' . __( 'tagged' ) . ' ', ', ', ''); ?>
		<?php if (function_exists('time_since')) {
		echo time_since(abs(strtotime($post->post_date_gmt . " GMT")), time()) . " ago";
		} else {
		the_time('F jS, Y');
		} ?> 
		<? /* by <?php the_author_posts_link(); ?> */ ?>
	</div>
	<?php } ?>
	
	<?php edit_post_link('Edit This', ' &#8212; '); ?>
	
	<hr />
	
</div>
