<?php get_header(); ?>

<?php /* These tell the user what type of archive they're on. You can easily customize the messages here. They use _e("...") to make them easily translated into other languages. This should help in localization a bunch. This also reduces the need for a page for all these types of archives. Unless you're using a very different setup on each one, this way seems to be much lighter on file sizes, markup, work, etc... */ ?>

<?php // This is the main loop. Body content is passed in through this code. ?>

<?php is_tag(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h1>
<?php // Spit out the header with a link to the article. ?>

<?php the_content(); ?>
<?php // The content, and what to use if  there is a <!-- more --> extension. ?>

<p class="meta"><?php the_time(get_option('date_format')); ?>. <?php if (is_callable('the_tags')) the_tags(__('Tags:').' ', ', ', '.'); ?> <?php the_category(', '); ?>. <?php comments_popup_link(__('Leave a comment'), __('1 comment'), __('% comments'), 'commentslink', __('Comments off')); ?>. <?php edit_post_link(__('Edit')); ?></p>

<?php // The information related to the post, such as the date, category, and comments. ?>

</div>

<?php endwhile; // End looping ?>

<p class="postnav"><?php posts_nav_link(); ?></p>
<?php // Go to previous and newer posts links. This is needed because WordPress by default limits the number of posts you may have in the loop.?>

<?php else: ?>
<?php if ( is_search () ) { ?>
<p><?php _e('Sadly however, no results were found. Please try searching again.'); ?></p>

<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" length="20" />
<input type="submit" id="searchsubmit" name="Submit" value="<?php echo attribute_escape(__('Search')); ?>" />
</form>

<?php } else { ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p> 
<?php } endif; ?>

<?php get_footer(); ?>
