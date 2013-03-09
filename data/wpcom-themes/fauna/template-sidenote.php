<?php /*
	Sidenote Post Template
	If Sidenotes are used, this template will hold the layout used for these.
	*/
?>

<div <?php post_class( 'sidenote' ); ?>>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a> <?php comments_popup_link(__('(Leave a Comment)'), __('(1 Comments)'), __('(% Comments)'), ('sidenote-permalink'), ('')); ?> 
	<?php if (!comments_open()) { ?><a href="<?php the_permalink() ?>" class="sidenote-permalink">#</a><?php } ?>
	<?php edit_post_link('Edit This', ' &#8212; '); ?>
</h2>
	<?php the_content('Continue reading this entry &raquo;'); ?>
	<?php wp_link_pages('before=<strong>Page: &after=</strong>&next_or_number=number&pagelink=%'); ?>

</div>
