<?php get_header(); ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

			<h2 class="page-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a></h2>
			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class() ?>">
				<h3 class="entry-title"><?php the_title() ?></h3>
				<div class="entry-content">
					<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
					<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
					<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

					<div class="navigation">
						<div class="alignleft"><?php previous_image_link() ?></div>
						<div class="alignright"><?php next_image_link() ?></div>
					</div>
				</div>
				<div class="entry-meta">
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
