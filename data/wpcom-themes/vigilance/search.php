<?php get_header(); ?>
		<?php if (have_posts()) : ?>
		<h1 class="pagetitle"><?php printf(__('Search Results for %s', 'vigilance'), esc_html( get_search_query() ) ); ?></h1>
		<img class="archive-comment"src="<?php bloginfo('template_url'); ?>/images/comments-bubble.gif" width="17" height="14" alt="<?php _e('Comments', 'vigilance'); ?>"/>
		<?php while (have_posts()) : the_post(); ?>
    <div class="entries">
      <ul>
        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><span class="comments_number"><?php comments_number('0', '1', '%', ''); ?></span><span class="archdate"><?php the_time('n.j.y'); ?></span><?php the_title(); ?></a></li>
      </ul>
    </div><!--end entries-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'vigilance')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'vigilance')) ?></div>
		</div><!--end navigation-->
		<?php else : ?>
    <h1 class="pagetitle">Search Results for "<?php the_search_query(); ?>"</h1>
    <div class="entry">
      <p><?php printf(__('Sorry your search for %s did not turn up any results. Please try again.', 'vigilance'), esc_html( get_search_query() ) ); ?></p>
      <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    </div><!--end entry-->
		<?php endif; ?>
	</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
