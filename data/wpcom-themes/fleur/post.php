<div <?php post_class(); ?>>
	<h2 class="post-title">
		<em><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></em>
		<?php the_time('l, M j Y'); ?>&nbsp;</h2>
	<p class="post-info">
		<?php if ( !is_page() && !is_attachment() ) : ?>
			<span class="pcat"><?php the_category(' and ') ?></span>
		<?php 
			the_tags( '<span class="pcat">', ', ', '</span>');
			endif;
		?>
		<span class="pauthor"><?php the_author() ?></span>
		<span class="ptime"><?php the_time();?></span><?php edit_post_link(); ?>
	</p>
	<div class="post-content">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<p class="post-info-co">				
			<span class="feedback"><?php comments_popup_link('Leave a Response &#187;','One Response &#187;','% Responses &#187;'); ?></span>								
		</p>
		<div class="post-footer">&nbsp;</div>
	</div>
	<?php comments_template(); ?>
</div>
