<?php 
	the_post();

	// Post is an aside
	$post_asides = in_category($redo_asidescategory);
?>

<?php /* Only display asides if sidebar asides are not active */ if(!$post_asides || $redo_asidescheck == '0') { ?>

<div id="post-<?php the_ID(); ?>" class="<?php redo_post_class($post_index++, $post_asides); ?>">
	<div class="entry-head">
		<?php
		printf(	__('%1$s','redo_domain'), 
			'<div class="published_sm" title="'. get_the_time('Y-m-d\TH:i:sO') . '">' .
			( '<div class="day">' . get_the_time('d') . '</div><div class="month">' . get_the_time('M') . '</div><div class="year">' . get_the_time('y') . '</div>' ) 
			. '</div>'
			);
		?>
		<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title='<?php printf( __('Permanent Link to "%s"','redo_domain'), wp_specialchars(get_the_title(),1) ); ?>'><?php the_title(); ?></a></h3>
		<?php /* Edit Link */ edit_post_link(__('Edit','redo_domain'), '<span class="editLink">','</span>'); ?>

		<div class="entry-meta">
			<div class="meta-row">
				<?php /* Date & Author */
					printf(    __('%1$s','redo_domain'), sprintf(__('<span class="authordata">By %s</span>','redo_domain'), '<span class="vcard author"><a href="' . get_author_link(0, $authordata->ID, $authordata->user_nicename) .'" class="url fn">' . get_the_author() . '</a></span>') );
				?>
				<?php /* Comments */ comments_popup_link(__('Leave a&nbsp;').'<span>'.__('Comment','redo_domain').'</span>', '1&nbsp;<span>'.__('Comment','redo_domain').'</span>', '%&nbsp;<span>'.__('Comments','redo_domain').'</span>', 'commentslink', '<span>'.__('Closed','redo_domain').'</span>'); ?>
			</div>
			<div class="meta-row">
				<?php /* Categories */ printf(__('<span class="entry-category">Categories: %s</span>','redo_domain'), redo_nice_category(', ', ' '.__('and','redo_domain').' ') ); ?>
				<?php the_tags('<br /><span class="entry-category">Tags: ', ', ', '<br /></span>'); ?>
			</div>
		</div> <!-- .entry-meta -->
	</div> <!-- .entry-head -->	
	
	<div class="entry-content">
		<?php if (is_archive() or is_search() or (function_exists('is_tag') and is_tag())) {
			the_excerpt();
		} else {
			the_content(__('Continue reading','redo_domain') . " '" . the_title('', '', false) . "'");
		} ?>

		<?php if( get_bloginfo('version') < 2.1 ) { ?>
			<?php link_pages('<p><strong>'.__('Pages:','redo_domain').'</strong> ', '</p>','number'); ?>
		<?php } else { ?>
			<?php wp_link_pages('before=<p><strong>'.__('Pages:','redo_domain').'</strong>&after=</p>&next_or_number=number')?>
		<?php } ?>
	</div> <!-- .entry-content -->
	

</div> <!-- #post-ID -->

<?php } /* End sidebar asides test */ ?>
