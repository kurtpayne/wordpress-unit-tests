<?php get_header(); ?>

	<div id="body">

		<div id="main" class="entry">
		
			<?php /* Guess Sidenote category */
			$sidenote_cat = $wpdb->get_var("SELECT t.term_id FROM $wpdb->terms as t, $wpdb->term_taxonomy as tt WHERE tt.taxonomy='category' AND t.term_id=tt.term_id AND (t.slug='sidenotes' OR t.slug='asides' OR t.slug='dailies')");
			?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<?php if ( in_category($sidenote_cat) ) { ?>

					<?php /* Sidenotes box start */ if (!$sidenotes) { ?><div class="box sidenotes"><?php } $sidenotes = true; ?>

					<?php include (TEMPLATEPATH . '/template-sidenote.php'); ?>

				<?php } else { ?>
				
					<?php /* Sidenotes box end */ if ($sidenotes && !$sidenotes_end) { ?></div><hr /><?php } $sidenotes_end = true; $sidenotes = false; $sidenotes_end = false; ?>
					
					<?php include (TEMPLATEPATH . '/template-postloop.php'); ?>
					
				<?php } ?>
		
			<?php endwhile; ?>
			
			<?php /* Sidenotes box end */ if ($sidenotes && !$sidenotes_end) { ?></ul></div><hr /><?php } $sidenotes_end = true; $sidenotes = false; $sidenotes_end = false; ?>
			
			<?php include("nav.php"); ?>

			<?php else : ?>
			
			<div class="box">
				<h2><?php _e('Not Found') ?></h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>		
			
		<?php endif; ?>
			
		</div>

		<?php get_sidebar(); ?>

	</div>

	<?php get_footer(); ?>
