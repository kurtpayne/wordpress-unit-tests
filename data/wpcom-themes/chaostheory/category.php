<?php get_header() ?>
	
	<div id="container">
		<div id="content" class="hfeed">
			<h2 class="page-title"><?php _e('Category Archives:', 'sandbox') ?> <?php echo single_cat_title(); ?></h2>
			<?php if ( category_description() ) { ?><div class="archive-meta"><?php echo apply_filters('archive_meta', category_description()); ?></div><?php } ?>

			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('&laquo; Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts &raquo;', 'sandbox')) ?></div>
			</div>

<?php while (have_posts()) : the_post(); ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<div class="entry-meta">
					<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
					<ul>
						<li class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s', 'sandbox'), the_date('', '', '', false), get_the_time()) ?></abbr></li>
						<!-- <li class="entry-author author vcard"><?php printf(__('By %s', 'sandbox'), '<a class="url fn" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="View all posts by ' . $authordata->display_name . '">'.get_the_author().'</a>') ?></li> -->
						<li class="entry-category"><?php printf(__('Posted in %s', 'sandbox'), get_the_category_list(', ')) ?></li>
						<?php the_tags('<li class="entry-tags">'.__('Tagged').' ', ", ", "</li>\n") ?>
<?php edit_post_link(__('Edit', 'sandbox'), "\t\t\t\t\t<li class='entry-editlink'>", "</li>"); ?>
						<li class="entry-commentlink"><?php comments_popup_link(__('Leave a Comment', 'sandbox'), __('Comments (1)', 'sandbox'), __('Comments (%)', 'sandbox')) ?></li>
					</ul>
				</div>				<div class="entry-content">
<?php the_content('<span class="more-link">'.__('Read More &raquo;', 'sandbox').'</span>') ?>

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
