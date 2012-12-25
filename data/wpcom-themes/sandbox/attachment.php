<?php get_header(); ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // DOES THIS, AND POPULATES THE NEXT LINE FOR SIZING ?>
<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // GIVES SMALL ITEMS A 'SMALL' CLASS ?>

			<h2 class="page-title"><a href="<?php echo get_permalink($post->post_parent) ?>" rev="attachment"><?php echo get_the_title($post->post_parent) ?></a></h2>
			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class() ?>">
				<h3 class="entry-title"><?php the_title() ?></h3>
				<div class="entry-content">
					<p class="<?php echo $classname ?>"><?php echo $attachment_link ?></p>
					<p class="<?php echo $classname ?>-name"><?php echo basename($post->guid) ?></p>
<?php the_content('<span class="more-link">'.__('Continue Reading &raquo;', 'sandbox').'</span>') ?>

<?php link_pages('<p class="page-link">'.__('Pages: ', 'sandbox'), '</p>', 'number') ?>

				</div>
				<div class="entry-meta">
					<?php printf(__('This entry was written by %1$s and posted on <abbr class="published" title="%2$sT%3$s">%4$s at %5$s</abbr>. Bookmark the <a href="%6$s" title="Permalink to %7$s" rel="bookmark">permalink</a>. Follow any comments here with the <a href="%8$s" title="Comments RSS to %7$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.', 'sandbox'),
						'<a class="url fn" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="View all posts by ' . $authordata->display_name . '">'.get_the_author().'</a>',
						get_the_time('Y-m-d'),
						get_the_time('H:i:sO'),
						the_date('', '', '', false),
						get_the_time(),
						get_permalink(),
						wp_specialchars(get_the_title(), 'double'),
						comments_rss() ) ?>
<?php if (comments_open() && pings_open()) : // COMMENTS & PINGS OPEN ?>
					<?php printf(__('<a href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a href="%s" rel="trackback" title="Trackback URL for your post">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (!comments_open() && pings_open()) : // PINGS ONLY OPEN ?>
					<?php printf(__('Comments are closed, but you can leave a trackback: <a href="%s" rel="trackback" title="Trackback URL for your post">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (comments_open() && !pings_open()) : // COMMENTS OPEN ?>
					<?php printf(__('Trackbacks are closed, but you can <a href="#respond" title="Post a comment">post a comment</a>.', 'sandbox')) ?>
<?php elseif (!comments_open() && !pings_open()) : // NOTHING OPEN ?>
					<?php _e('Both comments and trackbacks are currently closed.') ?>
<?php endif; ?>

<?php edit_post_link(__('Edit this entry.', 'sandbox'),'','') ?>
				</div>
			</div>

<?php comments_template() ?>

		</div>
	</div>

<?php get_sidebar() ?>
<?php get_footer() ?>
