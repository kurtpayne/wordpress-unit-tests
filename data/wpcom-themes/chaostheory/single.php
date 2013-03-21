<?php get_header(); ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post(); ?>

			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php previous_post_link('&laquo; %link') ?></div>
				<div class="nav-next"><?php next_post_link('%link &raquo;') ?></div>
			</div>

			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class(); ?>">
				<div class="entry-meta">
					<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
					<ul>
						<li class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s', 'sandbox'), the_date('', '', '', false), get_the_time()) ?></abbr></li>
						<li class="entry-category"><?php printf(__('Posted in %s', 'sandbox'), get_the_category_list(', ')) ?></li>
						<?php the_tags('<li class="entry-tags">'.__('Tagged').' ', ", ", "</li>\n") ?>
<?php edit_post_link(__('Edit', 'sandbox'), "\t\t\t\t\t<li class='entry-editlink'>", "</li>"); ?>
					</ul>
				</div>
				<div class="entry-content">
<?php the_content('<span class="more-link">'.__('Read More &raquo;', 'sandbox').'</span>'); ?>

<?php link_pages('<div class="page-link">'.__('Pages: ', 'sandbox'), '</div>', 'number'); ?>

				</div>
			</div><!-- .post -->

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php previous_post_link('&laquo; %link') ?></div>
				<div class="nav-next"><?php next_post_link('%link &raquo;') ?></div>
			</div>

<?php comments_template(); ?>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
