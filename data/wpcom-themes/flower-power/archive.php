<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">

<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2><?php printf(__('Posts filed under &#8216;<strong>%s</strong>&#8217;', 'flower-power'), single_cat_title('', false)); ?></h2>

	<?php } elseif (is_tag()) { ?>
	<h2><?php printf(__('Posted files under &#8216;<strong>%s</strong>&#8217;', 'flower-power'), single_tag_title('', false)); ?></h2>

	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2><?php printf(__('Archive for %s', 'flower-power'), get_the_time(get_option('date_format'))); ?></h2>

	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2><?php printf(__('Archive for %s', 'flower-power'), get_the_time('F Y')); ?></h2>

	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2><?php printf(__('Archive for %s', 'flower-power'), get_the_time('Y')); ?></h2>

	<?php /* If this is a search */ } elseif (is_search()) { ?>
	<h2><?php _e('Search Results', 'flower-power'); ?></h2>

	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2><?php _e('Author Archive', 'flower-power'); ?></h2>

	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2><?php _e('Blog Archives', 'flower-power'); ?></h2>

<?php } ?>

<br /><br /><br />

<?php while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'main' ); ?>>

		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

		<?php ($post->post_excerpt != "")? the_excerpt() : the_content(); ?>

		<p class="info"><?php if ($post->post_excerpt != "") { ?><a href="<?php the_permalink() ?>" class="more"><?php _e('Continue Reading', 'flower-power'); ?></a><?php } ?>
   		<?php comments_popup_link(__('Add comment', 'flower-power'), __('1 comment', 'flower-power'), __('% comments', 'flower-power'), 'commentlink', ''); ?>
   		<em class="date"><?php the_time(get_option('date_format')) ?><!-- at <?php the_time()  ?>--></em>
   		<!--<em class="author"><?php the_author(); ?></em>-->
   		<?php edit_post_link(__('Edit', 'flower-power'),'<span class="editlink">','</span>'); ?>
   		</p>
		
		<div class="divider"></div>

	</div>

<?php endwhile; ?>

	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>			
			<td width="120" align="left"><?php next_posts_link(__('Previous Posts', 'flower-power')) ?></td>
			<td width="60"></td>
			<td width="120" align="right"><?php previous_posts_link(__('Next Posts', 'flower-power')) ?></td>
</tr>
	</table>

<?php else : ?>

	<h2><?php _e('Not Found', 'flower-power'); ?></h2>
	<p><?php _e("Sorry, but you are looking for something that isn't here.", 'flower-power'); ?></p>

<?php endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
