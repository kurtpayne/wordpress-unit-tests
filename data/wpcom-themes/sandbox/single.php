<?php get_header(); ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post(); ?>

			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php previous_post_link('&laquo; %link') ?></div>
				<div class="nav-next"><?php next_post_link('%link &raquo;') ?></div>
			</div>

			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class(); ?>">
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<div class="entry-content">
<?php the_content('<span class="more-link">'.__('Read More &raquo;', 'sandbox').'</span>'); ?>

<?php link_pages('<div class="page-link">'.__('Pages: ', 'sandbox'), '</div>', 'number'); ?>

				</div>
				<div class="entry-meta">
					<?php printf(__('This entry was written by %1$s and posted on <abbr class="published" title="%2$sT%3$s">%4$s at %5$s</abbr> and filed under %6$s%10$s. Bookmark the <a href="%7$s" title="Permalink to %8$s" rel="bookmark">permalink</a>. Follow any comments here with the <a href="%9$s" title="Comments RSS to %8$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.', 'sandbox'),
						'<a class="url fn" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="View all posts by ' . $authordata->display_name . '">'.get_the_author().'</a>',
						get_the_time('Y-m-d'),
						get_the_time('H:i:sO'),
						the_date('', '', '', false),
						get_the_time(),
						get_the_category_list(', '),
						get_permalink(),
						wp_specialchars(get_the_title(), 'double'),
						comments_rss(),
						get_the_tag_list(__(' with tags '), ', ') ) ?>
<?php if (comments_open() && pings_open()) : // COMMENTS & PINGS OPEN ?>
					<?php printf(__('<a href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a href="%s" rel="trackback" title="Trackback URL for your post">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (!comments_open() && pings_open()) : // PINGS ONLY OPEN ?>
					<?php printf(__('Comments are closed, but you can leave a trackback: <a href="%s" rel="trackback" title="Trackback URL for your post">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (comments_open() && !pings_open()) : // COMMENTS OPEN ?>
					<?php printf(__('Trackbacks are closed, but you can <a href="#respond" title="Post a comment">post a comment</a>.', 'sandbox')) ?>
<?php elseif (!comments_open() && !pings_open()) : // NOTHING OPEN ?>
					<?php _e('Both comments and trackbacks are currently closed.') ?>
<?php endif; ?>

<?php edit_post_link(__('Edit this entry.', 'sandbox'),'',''); ?>
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
