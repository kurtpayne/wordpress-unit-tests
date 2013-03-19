<div <?php post_class(); ?>>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title();?>"><?php the_title(); ?></a></h2>

<small><?php printf(__('Posted in %1$s %2$s on %3$s by %4$s', 'black-letterhead'), get_the_category_list(', '), get_the_tag_list(__('with tags', 'black-letterhead') . ' ', ', ', ' '), get_the_time(get_option('date_format')), get_the_author()); ?></small>

<div class="entry">
<?php the_content(__('Read more &raquo;', 'black-letterhead')); ?></div>

<p class="postmetadata"><?php edit_post_link(__('Edit', 'black-letterhead'),'',' | '); ?><?php comments_popup_link(' '.__('Leave A Comment &#187;', 'black-letterhead'), __('1 Comment &#187;', 'black-letterhead'), __('% Comments &#187;', 'black-letterhead')); ?></p>

</div>
