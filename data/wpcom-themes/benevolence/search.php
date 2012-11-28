<?php include "header.php"; ?>

<div id="content">
 <div <?php post_class(); ?>>
  <?php if (have_posts()) : ?>
	<br />
   <div class="title"><?php _e('Search Results','benevolence'); ?></div>
    <div class="searchdetails"> <?php _e('Search results for','benevolence'); ?> "<?php echo ""."$s"; ?>" </div><br />
     <?php while (have_posts()) : the_post(); ?>
     <a class="title" href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','benevolence'); ?> <?php the_title(); ?>"><?php the_title(); ?></a>
     ( <?php _e('Filed under:','benevolence'); ?> <?php the_category(',') ?> <?php the_tags( ' | ' . __( 'Tags' ) . ': ', ', ', ''); ?> )
      <?php the_excerpt() ?>
       <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','benevolence'); ?> <?php the_title(); ?>">( more )</a>
<br /><br /><br />
  <?php endwhile; ?>
<?php else : ?>
 <?php _e('NothingNot Found','benevolence'); ?>
<?php endif; ?>
</div>

<div class="right"><?php posts_nav_link('','',__('previous &raquo;','benevolence')) ?></div>
 <div class="left"><?php posts_nav_link('',__('&laquo; newer ','benevolence'),'') ?></div>
</div>
<br /><br />

<?php include "footer.php"; ?>
