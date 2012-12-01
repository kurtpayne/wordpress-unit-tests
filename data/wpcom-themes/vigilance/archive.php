<?php get_header(); ?>
		<?php if (have_posts()) : ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		<h1 class="pagetitle"><?php printf(__('Posts for the %s Category', 'vigilance'), single_cat_title('', false)); ?></h1>
		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1 class="pagetitle"><?php printf(__('Posts tagged &#8216;%s&#8217', 'vigilance'), single_tag_title('', false)); ?></h1>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle"><?php printf(__('Archive for %s', 'vigilance'), get_the_time(get_option('date_format'))); ?></h1>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle"><?php printf(__('Archive for %s', 'vigilance'), get_the_time('F, Y')); ?></h1>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle"><?php printf(__('Archive for %s', 'vigilance'), get_the_time('Y')); ?></h1>
		<?php /* If this is an author archive */ } elseif (is_author()) { if (isset($_GET['author_name'])) $current_author = get_userdatabylogin($author_name); else $current_author = get_userdata(intval($author));?>
		<h1 class="pagetitle"><?php printf(__('Posts by %s', 'vigilance'), $current_author->nickname); ?></h1>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle"><?php _e('Blog Archives', 'vigilance'); ?></h1>
		<?php } ?>
    <img class="archive-comment"src="<?php bloginfo('template_url'); ?>/images/comments-bubble.gif" width="17" height="14" alt="Comments"/>
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
		<?php endif; ?>
	</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
