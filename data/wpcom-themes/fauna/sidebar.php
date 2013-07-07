<div id="sidebar">

	<?php /* About Blog */ if (is_home()) { ?>
		<?php $blogdesc = get_bloginfo('description');
		if ( '' != $blogdesc ) { ?>
		<div class="box"><?php echo $blogdesc; ?></div>
		<hr />
	<?php } } ?>
	
	<?php /* Single */ if( is_single() ) { ?>
	<div class="box">
		<h4>This Entry</h4>
		<?php rewind_posts(); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
			<p>"<a href="<?php the_permalink() ?>" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a>" was written <?php the_time('F jS, Y') ?>
				by <?php the_author_posts_link(); ?>, and filed under <?php the_category(',') ?> <?php the_tags( ' and ' . __( 'tagged' ) . ' ', ', ', '.'); ?></p>
	
		<?php endwhile; endif; ?>
		<?php rewind_posts(); ?>

		<?php if ( comments_open() && pings_open() ) {
			// Both Comments and Pings are open ?>

			<p>There are <?php comments_number('leave a response','one response','% responses'); ?>.</p>
			<p>&darr; <a href="#comments">Read comments</a>, <a href="#respond">respond</a> or follow responses via <?php comments_rss_link(__("XML")); ?>.</p>
			<?php if (function_exists('show_manual_subscription_form')) { show_manual_subscription_form(); }; ?>

			<span id="trackback">
				<a href="<?php trackback_url(display) ?>" onclick="show('trackback');return false;" title="Trackback URI to this entry" rel="nofollow">Trackback</a> this entry.
			</span>
			<span id="trackback-hidden" style="display: none;">
				<input name="textfield" type="text" value="<?php trackback_url() ?>" class="inputbox" onclick="select();" />
				<input name="hide" type="button" id="hide" value="Hide" onclick="hide('trackback');return false;" />
			</span>
		<?php } elseif ( !comments_open() && pings_open() ) {
			// Only Pings are Open ?>

			<span id="trackback">
				<a href="<?php trackback_url(display) ?>" onclick="show('trackback');return false;" title="Trackback URI to this entry" rel="nofollow">Trackback</a> this entry.
			</span>
			<span id="trackback-hidden" style="display: none;">
				<input name="textfield" type="text" value="<?php trackback_url() ?>" class="inputbox" onclick="select();" />
				<input name="hide" type="button" id="hide" value="Hide" onclick="hide('trackback');return false;" />
			</span>
		<?php } elseif ( comments_open() && !pings_open() ) {
			// Comments are open, Pings are not ?>

			<p>There are <?php comments_number('leave a response','one response','% responses'); ?>.</p>
			<p>&darr; <a href="#comments">Jump to comments</a> or follow responses via <?php comments_rss_link(__("XML")); ?>.</p>
			<?php if (function_exists('show_manual_subscription_form')) { show_manual_subscription_form(); }; ?>
		<?php } elseif ( !comments_open() && !pings_open() ) {
			// Neither Comments, nor Pings are open ?>
		<?php } ?>
	</div>
	<? } ?>
	
	<?php /* Search Meta */ if ( is_search() ) { ?>
	<div class="box">
		<h4><?php _e('Search'); ?></h4>
		<p><?php _e('All keywords are searched for.') ?></p>
		<?php _e('If only one article contains the keywords you searched for, you will be taken directly to that article.') ?>
	</div>
	<?php } ?>

	<?php /* Dynamic Sidebar */ if ( !is_category() && !is_single() && !is_date() && !is_page() && !is_search() && !is_author() ) { ?>	
	<div class="box">
		<?php if ( !dynamic_sidebar('sidebar') ) {
			wp_list_bookmarks('title_before=<h4>&title_after=</h4>'); ?>

		<h4><?php _e('Meta'); ?></h4>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
		<?php } ?>
	</div>
	<?php } ?>
	
	<?php /* Category Meta */ if ( is_category() ) { ?>
	<div class="box">
		<h4><?php _e('Category: '); ?><?php single_cat_title('', 'display'); ?></h4>
		<p><?php echo category_description(); ?></p>
		<p><?php _e('Also available:') ?>
		<br /><a rel="nofollow" href="<? echo get_category_rss_link(0, $cat, $post->cat_name); ?>" title="<?php _e('RSS 2.0') ?>"><?php _e('RSS Feed for entries in this category') ?></a>.</p>
	</div>
	<?php } ?>

	<?php /* Archive Meta */ if ( is_page("archives") ) { ?>
	<div class="box">
		<h4><?php _e('Archives') ?></h4>
		<p><?php _e('You are viewing the archives for ') ?> <?php bloginfo('name'); ?>.</p>
		<?php
		$numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
		if (0 < $numposts) $numposts = number_format($numposts); 
		
		$numcomms = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
		if (0 < $numcomms) $numcomms = number_format($numcomms);
		
		$numcats = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->term_taxonomy where taxonomy='category'");
		if (0 < $numcats) $numcats = number_format($numcats);
		?>
		<p><?php _e('There are currently ' . $numposts . ' posts and ' . $numcomms . ' comments, contained within ' . $numcats . ' categories.') ?></p>
	</div>
	<?php } ?>

	<?php /* Category List */ if ( is_category() || is_page("archives") ) { ?>
	<?php /* Guess special categories */
	$sidenote_cat = $wpdb->get_var("SELECT t.term_id FROM $wpdb->terms as t, $wpdb->term_taxonomy as tt WHERE tt.taxonomy='category' AND t.term_id=tt.term_id AND (t.slug='sidenotes' OR t.slug='asides' OR t.slug='dailies')"); 
	?>
	<div class="box">
		<h4><?php _e('Categories') ?></h4>
		<ul>
		<?php wp_list_cats("children=1&hide_empty=0&sort_column=name&optioncount=1&feed=XML&exclude=".$sidenote_cat.",".$noteworthy_cat." '") ?>
		</ul>
		

		<?php if ( $noteworthy_cat != "" || $sidenote_cat != "" ) { ?>
		<h4><?php _e('Special Categories') ?></h4>
		<ul>
			<?php if ( $sidenote_cat != "" ) { ?><li><?php echo(get_category_parents($sidenote_cat,TRUE,'')); ?></li><? } ?>
			<?php if ( $noteworthy_cat != "" ) { ?><li><?php echo(get_category_parents($noteworthy_cat,TRUE,'')); ?></li><? } ?>
		</ul>
		<?php } ?>
	
	</div>
	<?php } ?>
	
	<?php /* Author Meta */ if ( is_author() ) { ?>
	<?php $num_authors = count( (array) get_users_of_blog( ) ); ?>
	<div class="box">
		<h4><?php _e('Author Archive') ?></h4>
		<p><?php _e('This page details authors of this weblog.') ?></p>

		<?php /* Fix an annoying WP bug where wp_list_authors borks when there's only one user */
		$numauthors = count( (array) get_users_of_blog( ) );
		if ( sizeof($numauthors) > 1 ) { ?> 
		<p><?php _e('There are ' . $num_authors . ' authors/users attached to this weblog: ') ?></p>
		<ul>
			<?php wp_list_authors('optioncount=1&feed=XML'); ?>
		</ul>
		<?php } else { ?>
		<p><?php _e('There is one author attached to this weblog.') ?></p>
		<?php } ?>
	</div>
	<?php } ?>
	
	
	<?php /* Page List */ if ( is_page() && !is_page('archives') ) { ?>
	<?php
	$currentpage = $post->ID;
	$parent = 1;

	while ( $parent ) {
		$subpages = $wpdb->get_row("SELECT ID, post_name, post_parent FROM $wpdb->posts WHERE ID = '$currentpage'");
		$parent = $currentpage = $subpages->post_parent;
	}
	$parent_id = $subpages->ID;
	$haschildren = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id'"); 
	if ( $haschildren ) { ?>
	<div class="box">
		<h4><?php _e('In this Section') ?></h4>
		<ul>
			<?php wp_list_pages('title_li=&child_of='. $parent_id); ?>
		</ul>
	</div>
	<?php } } ?>

	<hr />

</div>
