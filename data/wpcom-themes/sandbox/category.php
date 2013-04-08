<?php get_header() ?>
	
	<div id="container">
		<div id="content" class="hfeed">
			<h2 class="page-title"><?php _e('Category Archives:', 'sandbox') ?> <?php echo single_cat_title(); ?></h2>
			<div class="archive-meta"><?php echo apply_filters('archive_meta', category_description()); ?></div>

			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('&laquo; Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts &raquo;', 'sandbox')) ?></div>
			</div>

<?php while (have_posts()) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class(); ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), get_the_title()) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				<div class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s', 'sandbox'), the_date('', '', '', false), get_the_time()) ?></abbr></div>
				<div class="entry-content">
<?php the_excerpt('<span class="more-link">'.__('Read More &raquo;', 'sandbox').'</span>') ?>

				</div>
				<div class="entry-meta">
					<span class="entry-author author vcard"><?php printf(__('By %s', 'sandbox'), '<a class="url fn" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="View all posts by ' . $authordata->display_name . '">'.get_the_author().'</a>') ?></span>
					<span class="metasep">|</span>
<?php if ( $cats_meow = sandbox_cats_meow(', ') ) : /* only show categories other than the one queried */ ?>
					<span class="entry-category"><?php printf(__('Also posted in %s', 'sandbox'), $cats_meow) ?></span>
					<span class="metasep">|</span>
<?php endif ?>
<?php edit_post_link(__('Edit', 'sandbox'), "\t\t\t\t\t<span class='entry-editlink'>", "</span>\n\t\t\t\t\t<span class='metasep'>|</span>\n"); ?>
					<span class="entry-commentlink"><?php comments_popup_link(__('Leave a Comment', 'sandbox'), __('Comments (1)', 'sandbox'), __('Comments (%)', 'sandbox')) ?></span>
				</div>
			</div><!-- .post -->

<?php endwhile; ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('&laquo; Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts &raquo;', 'sandbox')) ?></div>
			</div>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>