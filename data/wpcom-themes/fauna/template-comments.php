<?php /*
	Comments Template
	This page holds the code used by comments.php for showing comments.
	It's separated out here for ease of use, because the comments.php file is already pretty cluttered.
	*/
?>
<h2 id="comments"><?php _e('Comments') ?></h2>
<?
	$even = "comment-even";
	$odd = "comment-odd";
	$author = "comment-author";
	$bgcolor = $even;
?>

<?php

function fauna_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	
	if ($comment->comment_type != "trackback" && $comment->comment_type != "pingback") {
		if($odd == $bgcolor) { $bgcolor = $even; } else { $bgcolor = $odd; }

		/* Assign .comment-author CSS class to weblog administrator */
		$is_author = false;
		if($comment->comment_author_email == get_settings(admin_email)) {
			$is_author = true;
		}
		?>	
	
		<li id="comment-<?php comment_ID() ?>" <?php if ($is_author == true) { $class .= ' '.$author; } else { $class .= ' '.$bgcolor; }?> <?php post_class($class); ?>>
			<div class="comment-body">
				<div class="comment-header">
					<?php if (function_exists('comment_favicon')) { ?><a href="<? echo($comment->comment_author_url); ?>" title="Visit <? echo($comment->comment_author); ?>"><? comment_favicon($before='<img src="', $after='" alt="" class="comment-avatar" />'); ?></a><?php } ?>
						<?php echo get_avatar( $comment, 48 ); ?>
						<em><a href="#comment-<? echo($comment->comment_ID) ?>" title="<?php _e('Permanent link to this comment') ?>"><? echo($comment_number) ?></a></em>
						<strong><? comment_author_link(); ?></strong> 
						<?php if ( function_exists(comment_subscription_status) ) { if (comment_subscription_status()) { ?><?php _e('(subscribed to comments)') ?><? }} ?>
						<?php _e('says:') ?>
						<?php if ($comment->comment_approved == '0') : ?>
							<small><?php _e('Your comment is awaiting moderation. This is just a spam counter-measure, and will only happen the first time you post here. Your comment will be approved as soon as possible.') ?></small>
						<?php endif; ?>
				</div>
				<?php comment_text() ?>
				<?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ')) ?>
				<small>
					<?php _e('Posted') ?> 
					<?php 
					if (function_exists('time_since')) {
						echo time_since(abs(strtotime($comment->comment_date_gmt . " GMT")), time()) . " ago";
					} else { ?>
						<?php comment_date(); ?>, <?php comment_time(); } ?> 
					<? } ?>
					<?php edit_comment_link(__("Edit This"), ' | '); ?>
				</small>
		</div>
	</li> 
	<?php
}

?>

<ol id="commentlist">

<?php wp_list_comments(array('callback' => 'fauna_comment')); ?>	

</ol><br />
