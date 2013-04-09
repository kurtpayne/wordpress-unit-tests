<?php 
get_header( ); 

if ( have_posts( ) ) {
	$first_post = true;
?>

<div class="pp-project-main">
	<div class="pp-project-tabs">

<?php
	the_post( );
?>

		<h3>Latest Updates</h3>
	
		<ul class="pp-updates">
			<li id="pp-update-<?php the_ID(); ?>" class="pp-update">
				<?php echo get_avatar( get_the_author_ID(), 48 ); ?>
				<h4>
					<?php the_author_posts_link(); ?>
					<span class="meta">
						<?php printf( __( '%1$s on %2$s' ), get_the_time(), the_date( '', '', '', false ) ); ?> |
						<a href="<?php the_permalink( ); ?>">#</a> |
						<?php edit_post_link( __( 'e', 'prologue-projects' ) ); ?>
					</span>
				</h4>
				<ul class="taxonomy">
					<?php the_tags( '<li>' . __( 'Tags: ', 'prologue-projects' ), ', ', '</li>' ); ?>
					<?php pp_the_projects( '<li>' . __( 'Projects: ', 'prologue-projects' ), ', ', '</li>' ); ?>
					<?php pp_the_question_status( '<li>', __( 'This question is <span class="question-status">%s</span>', 'prologue-projects' ), '</li>' ); ?>
				</ul>
				<div class="pp-update-content">
					<?php the_content( __( '(More ...)' ) ); ?>
				</div>
			</li>
		</ul>

<?php
	comments_template();
?>

	</div>
</div>

<?php
} // if have_posts
?>

<div id="pp-sidebar">
	<ul>
<?php
dynamic_sidebar('pp-sidebar-top');

dynamic_sidebar('pp-single-sidebar');

dynamic_sidebar('pp-sidebar-bottom');
?>
	</ul>
</div>

<?php
get_footer( );
?>