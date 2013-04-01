<?php is_tag(); ?>
<?php if ( have_posts() ) : $count_users = count( get_users_of_blog() ); // Should really only look for users that can write posts, or maybe check to see how many authors have written posts ?>

<div id="primary">

<?php if( !is_single() && !is_home() && !is_page() ) { ?>
		<div class="entry archive">
			<div class="post-meta">
		<?php if(is_category()) { ?>
			<h1 class="post-title">Category Archive</h1>
		</div>
		<div class="post-content">
			<p>You are currently browsing the category archive for the '<?php echo single_cat_title(); ?>' category.</p>
		<?php } ?>
		<?php if(is_tag()) { ?>
			<h1 class="post-title">Tag Archive</h1>
		</div>
		<div class="post-content">
			<p>You are currently browsing the tag archive for the '<?php echo single_tag_title(); ?>' tag.</p>
		<?php } ?>
		<?php if(is_author()) { ?>
				<h1 class="post-title">Author Archive</h1>
			</div>
			<div class="post-content">
				<?php $_current_author = $wp_query->get_queried_object(); ?>
				<p>You are currently browsing <?php echo $_current_author->display_name; ?>'s articles.</p>
		<?php } ?>
		<?php if(is_day()) { ?>
				<h1 class="post-title">Daily Archive</h1>
			</div>
			<div class="post-content">
				<p>You are currently browsing the daily archive for <?php the_time('F jS, Y'); ?>.</p>
		<?php } ?>
		<?php if(is_month()) { ?>
				<h1 class="post-title">Monthly Archive</h1>
			</div>
			<div class="post-content">
				<p>You are currently browsing the monthly archive for <?php the_time('F Y'); ?>.</p>
		<?php } ?>
		<?php if(is_year()) { ?>
				<h1 class="post-title">Yearly Archive</h1>
			</div>
			<div class="post-content">
				<p>You are currently browsing the yearly archive for <?php the_time('Y'); ?>.</p>
		<?php } ?>
		<?php if(is_search()) { ?>
				<h1 class="post-title">Search Results</h1>
			</div>
			<div class="post-content">
				<p>You searched for '<?php echo $s; ?>'.</p>
		<?php } ?>
			</div>
		</div>
<?php } ?>

<?php if ( is_single() || is_page() ) : while ( have_posts() ) : the_post(); ?>
	<div class="entry<?php if (is_page()) { echo " static"; } ?>">
		<div class="post-meta">
			<h1 class="post-title" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
<?php	if ( !is_page() ) : ?>
			<p class="post-metadata"><?php
				the_time(get_option('date_format'));
				if ( !get_option('tarski_hide_categories') ) :
				?> in <?php
					the_category(', ');
					the_tags(' | Tags: ', ', ', '');
				endif;

				/* If there is more than one author, show author's name */
				if ( $count_users > 1 ) :
				?> | by <?php
					the_author_posts_link();
				endif;
				edit_post_link('Edit',' (',')'); ?>
			</p>
<?php 	endif; ?>
		</div>
		<div class="post-content">
			<?php the_content('Read the rest of this entry &raquo;'); ?>
		</div>
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php if ( is_page() ) { edit_post_link('edit page', '<p class="post-metadata">(', ')</p>'); } ?>
	</div>
<?php endwhile; else : while (have_posts()) : the_post(); ?>
	<div <?php post_class('entry'); ?>>
		<div class="post-meta">
			<h2 class="post-title" id="post-<?php the_ID(); ?>"><?php if( !is_single() ) { ?><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a><?php } else { the_title(); } ?></h2>
			<p class="post-metadata"><?php
				the_time(get_option('date_format'));
				if ( !get_option('tarski_hide_categories') ) :
				?> in <?php
					the_category(', ');
					the_tags(' | Tags: ', ', ', ''); 
				endif;

				/* If there is more than one author, show author's name */
				if ( $count_users > 1 ) :
				?> | by <?php
					the_author_posts_link();
				endif;
				?> | <?php
				comments_popup_link('Leave a comment', '1 comment', '% comments', '', 'Comments closed');
				edit_post_link('Edit',' (',')'); ?>
			</p>
		</div>

		<div class="post-content">
			<?php the_content('Read the rest of this entry &raquo;'); ?>
		</div>
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	</div>
<?php endwhile; endif; // have_posts; is_single || is_page ?>
</div>
<?php else : // have_posts (top of file) ?>
	<div id="primary">
		<div class="entry static">
			<div class="post-meta">
				<h1 class="post-title" id="error-404">Error 404</h1>
			</div>

			<div class="post-content">
				<p>The page you are looking for does not exist; it may have been moved, or removed altogether. You might want to try the search function. Alternatively, return to the <a href="<?php echo get_settings('home'); ?>">front page</a>.</p>
			</div>
		</div>
	</div>
<?php endif; // have_posts (top of file) ?>
