<div id="container">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<div id="postmetadata">
	<div class="sleeve">
		<p>By: <cite><?php the_author(); ?></cite></p>
		<p><small><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php the_time('M d Y') ?></a></small></p>
		<p><?php the_tags('tags: ', ', ', '<br />'); ?></p>
    	
		<p>Category: <?php the_category(', ') ?></p>
		<p><?php edit_post_link('Edit This Post', '', ''); ?></p>
		<p><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
		<?php post_exif(); ?>
	</div>
</div>
<div id="post">
	<div class="sleeve">
	<?php the_content('Read the rest of this entry &raquo;'); ?>
	</div>
</div>

<?php if(is_single()) { ?>
<div class="navigation">
	<div class="prev"><?php next_post_link('%link', '&lsaquo;') ?></div>
	<div class="next"><?php previous_post_link('%link', '&rsaquo;') ?></div>
</div>
<?php comments_template();
} ?>
</div>