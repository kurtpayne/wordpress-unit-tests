<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">

<?php if (have_posts()) : ?>

	<h2><?php printf(__('Search Results for <em>&#8216;%s&#8217;</em>', 'flower-power'), wp_specialchars($s, 1)); ?></h2>
	<br />
	<br />

<?php while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

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

<?php endwhile; ?>	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>	
			<td width="120" align="left"><?php next_posts_link(__('Previous Posts', 'flower-power')) ?></td>
			<td width="60"></td>
			<td width="120" align="right"><?php previous_posts_link(__('Next Posts', 'flower-power')) ?></td>
</tr>
	</table>

<?php else : ?>

	<h2><?php printf(__('No Results for <em>&#8216;%s&#8217;</em>', 'flower-power'), wp_specialchars($s, 1)); ?></h2>
	<p><?php _e("Sorry, but you are looking for something that isn't here.", 'flower-power'); ?></p>

<?php endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
