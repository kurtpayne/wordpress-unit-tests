<?php /*
	Trackbacks Template
	This page holds the code used by comments.php for showing trackbacks.
	It's separated out here for ease of use, because the comments.php file is already pretty cluttered.
	*/
?>
<?php function fauna_trackback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<? if ($comment->comment_type == "trackback" || $comment->comment_type == "pingback") { ?>

<? if (!$runonce) { $runonce = true; ?>
<h2 id="trackbacks"><?php _e('Trackbacks &amp; Pingbacks') ?></h2>
<? } ?>

	<li><a name="comment-<?php comment_ID() ?>" href="<? echo($comment->comment_author_url); ?>" title="Visit <? echo($comment->comment_author); ?>">
		<? if (function_exists('comment_favicon')) { comment_favicon($before='<img src="', $after='" alt="" class="trackback-avatar" />'); }; ?>
		<strong><u><? echo($comment->comment_author); ?></u></strong>
		<small>
		<?php comment_type(__('commented'), __('trackbacked'), __('pingbacked')); ?> <?php _e('on') ?> 
		<?php if (function_exists('time_since')) {
		echo time_since(abs(strtotime($comment->comment_date_gmt . " GMT")), time()) . " ago";
		} else { ?>
		<?php comment_date(); ?>, <?php comment_time(); } ?>
		</small>
		<?php
		/* Trackback body text is disabled by default. To enable it, remove lines 22 and 24 of this file.
		comment_text()
		*/
		?>
		</a>
	</li>
	<?php edit_comment_link(__("<li>Edit This</li>")); ?>
	<? } ?>
<?php } ?>

<ol id="trackbacklist">
	<?php wp_list_comments(array('callback' => 'fauna_trackback')); ?>	
</ol>