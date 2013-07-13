<?php get_header( ); ?>

<div id="main">

<?php 
if( have_posts( ) ) { 
	while( have_posts( ) ) {
		the_post( ); 
?>

<div <?php post_class('post'); ?> id="post-<?php the_ID( ); ?>">
	<h2><?php the_title( ); ?></h2>
	<div class="entry">
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		<?php the_content('<p class="serif">Read the rest of this page &rarr;</p>'); ?>

		<?php comments_template(); ?>

		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

	</div> <!-- // entry -->
</div> <!-- post-<?php the_ID( ); ?> -->

<?php
	} // while have_posts

} // if have_posts
?>

	</ul>
</div> <!-- // main -->

<?php
get_footer( );
