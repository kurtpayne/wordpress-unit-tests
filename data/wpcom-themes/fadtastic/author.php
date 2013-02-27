<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			
			 <?php
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
			?>
			
			<h1>About <?php echo $curauth->user_firstname; ?> <?php echo $curauth->user_lastname; ?></h1>
			
			<p><strong>Profile:</strong> <?php echo $curauth->user_description; ?></p>
			<p><strong>Website:</strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
			
			
			<h2 class="top_border">Latest posts by <?php echo $curauth->user_firstname; ?> <?php echo $curauth->user_lastname; ?>:</h2>
			
			<!-- The Loop -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			 <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
			<?php the_title(); ?></a><br />
			<small><?php the_time(get_option('date_format')); ?> Filed under: <?php the_category(',') ?> | <?php the_tags('Tags: ', ', ', ' | '); ?> <?php edit_post_link('Edit This'); ?></small></p>
			  
			  <?php endwhile; else: ?>
				 <p><?php _e('No posts by this author.'); ?></p>
			
				<?php endif; ?>
				
			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
