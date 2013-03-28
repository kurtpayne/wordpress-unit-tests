<?php get_header(); ?>

	<div id="mainCol">

		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
  	<h2 class="title"><?php next_posts_link('&laquo; Older Entries') ?><?php previous_posts_link('Newer Entries &raquo;') ?> Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
  	<h2 class="title"><?php next_posts_link('&laquo; Older Entries') ?><?php previous_posts_link('Newer Entries &raquo;') ?> Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
  	<h2 class="title"><?php next_posts_link('&laquo; Older Entries') ?><?php previous_posts_link('Newer Entries &raquo;') ?> Archive for <?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
  	<h2 class="title"><?php next_posts_link('&laquo; Older Entries') ?><?php previous_posts_link('Newer Entries &raquo;') ?> Archive for <?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
  	<h2 class="title"><?php next_posts_link('&laquo; Older Entries') ?><?php previous_posts_link('Newer Entries &raquo;') ?> Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
  	<h2 class="title"><?php next_posts_link('&laquo; Older Entries') ?><?php previous_posts_link('Newer Entries &raquo;') ?> Author Archive</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
  	<h2 class="title"><?php next_posts_link('&laquo; Older Entries') ?><?php previous_posts_link('Newer Entries &raquo;') ?> Blog Archives</h2>
 	  <?php } ?>
		
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<p class="date">
				  <span class="d1"><?php the_time('j') ?></span>
					 <span class="d2"><?php the_time('M') ?></span>
					 <span class="d3"><?php the_time('Y') ?></span>
				</p>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				<p class="author">Posted by <span><?php the_author() ?></span>. <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></p>
				<?php the_tags('<div class="tags"><p><strong>Tags:</strong> ', ' , ' , '</p></div>'); ?>
			</div>
		<?php endwhile; ?>


	<?php else : ?>
		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
		
	<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
