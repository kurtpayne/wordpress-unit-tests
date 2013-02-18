<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : ?>

	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<div class="title">
		<h2 class="pagetitle"><?php printf(__('Archive for the &#8216;%s&#8217; Category', 'kubrick'), single_cat_title('', false)); ?></h2>
		</div>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<div class="title">
		<h2 class="pagetitle"><?php printf(__('Posts Tagged &#8216;%s&#8217;', 'kubrick'), single_tag_title('', false) ); ?></h2>
		</div>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<div class="title">
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Daily archive page', 'kubrick'), get_the_time(__('F jS, Y', 'kubrick'))); ?></h2>
		</div>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<div class="title">
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Monthly archive page', 'kubrick'), get_the_time(__('F, Y', 'kubrick'))); ?></h2>
		</div>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<div class="title">
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Yearly archive page', 'kubrick'), get_the_time(__('Y', 'kubrick'))); ?></h2>
		</div>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<div class="title">
		<h2 class="pagetitle"><?php _e('Author Archive', 'kubrick'); ?></h2>
		</div>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<div class="title">
		<h2 class="pagetitle"><?php _e('Blog Archives', 'kubrick'); ?></h2>
		</div>

	    <?php /* If this is a search */ } elseif (is_search()) { ?>
		<div class="title">
		<h2><?php _e('Search Results'); ?></h2>
		</div>
		
		<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
		    <div class="archive">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
				  <p><?php printf(__('Posted by: %1$s on %2$s'), '<strong>'.get_the_author().'</strong>', get_the_time(get_option('date_format'))); ?></p>
			</div>
	
		<?php endwhile; ?>
	
	<?php else : ?>

		<div class="title">
		<h2><?php _e('Not Found'); ?></h2>
		</div>
        <div <?php post_class(); ?>>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		  <?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    </div>
	<?php endif; ?>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','',__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php posts_nav_link('', __('Next Entries &raquo;'),'') ?></div>
		</div>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
