<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="center"><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
<?php
	return;
}


function twenty_eight_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<span class="commentauthor fn" style="font-weight: normal;"><?php comment_author_link(); ?></span>
	</div>
	<?php edit_comment_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="Edit Link" />','<span class="commentseditlink">','</span>'); ?>
	<p class="metadata" style="color:#9c9c9c;font-size:12px;margin-top:2px;"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" title="<?php { ?>Permalink to Comment<?php } ?>"><?php comment_date() ?> at <?php comment_time() ?></a></p>
	<div class="itemtext"><?php comment_text() ?></div>
	<?php if ($comment->comment_approved == '0') : ?>
		<p class="alert"><strong>Your comment is awaiting moderation.</strong></p>
	<?php endif; ?>
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}

function twenty_eight_ping($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $count_pings;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<a href="#comment-<?php comment_ID() ?>" title="Permanent Link to this Comment" class="counter"><?php echo $count_pings; $count_pings++; ?></a>
	<span class="commentauthor"><?php comment_author_link() ?></span>
	<small class="commentmetadata">
	<span class="pingtype"><?php comment_type(); ?></span> on <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" title="<?php if (function_exists('time_since')) { $comment_datetime = strtotime($comment->comment_date); echo time_since($comment_datetime) ?> ago<?php } else { ?>Permalink to Comment<?php } ?>"><?php comment_date('M jS, Y') ?> at <?php comment_time() ?></a> <?php edit_comment_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="Edit Link" />','<span class="commentseditlink">','</span>'); ?>
	</small>
	<?php comment_text(); ?>
<?php 
} 

?>
<?php if ((have_comments()) or (comments_open())) { ?>
<hr />
<div class="comments" id="comments">
<div class="center">
<h4><a href="#comments"><?php comments_number('No Comments Yet', 'One Reply', '% Replies' );?></a></h4>
</div>
<ol class="commentlist" id='commentlist'>
<?php if (have_comments()) { ?>
<?php wp_list_comments(array('callback'=>'twenty_eight_comment', 'avatar_size'=>48, 'type'=>'comment')); ?>
</ol>

<ol class="pinglist">
<?php global $count_pings; $count_pings = 1; ?>
<?php wp_list_comments(array('callback'=>'twenty_eight_ping', 'avatar_size'=>48, 'type'=>'pings')); ?>
</ol>
<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
</div>
<br />
		
	<?php } else { // this is displayed if there are no comments so far ?>

		<?php if (comments_open()) { ?> 
			<!-- If comments are open, but there are no comments. -->
				<!--<li id="leavecomment"></li>-->

		<?php } else { // comments are closed ?>

			<!-- If comments are closed. -->

			<?php if (is_single) { // To hide comments entirely on Pages without comments ?>
				<li>Comments are currently closed.</li><?php 
				}
			} ?>
			</ol><?php 
		} 
		
		if (have_comments()) { 
			include (TEMPLATEPATH . '/navigation.php'); 
		} ?>
		<!-- Reply Form -->
		<?php if (comments_open()) : ?>
		<div id="respond">
		<h4><?php comment_form_title( 'Leave a Comment', 'Leave a Comment to %s' ); ?></h4>
		<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
		<br />
		<p class="metadata" style="padding-bottom:10px;">		<a href="<?php trackback_url(); ?>" title="Send a trackback to this article">trackback address</a></p>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>You must <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">log in</a> to post a comment.</p>
		<?php else : ?><?php { ?><form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform"><?php } ?>
		<div id="errors" style="display:none">There was an error with your comment, please try again.</div>
			
		<?php if ( $user_ID ) { ?>
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>
		<?php } elseif ($comment_author != "") { ?>
		<?php } ?>
		
		<?php if ( !$user_ID ) { ?>
			<div id="authorinfo">
			<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
			<label for="author"><small><strong>name</strong><?php if ($req) _e('(required)'); ?></small></label>
			</p>
			<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
			<label for="email"><small><strong>email</strong> (will not be published) <?php if ($req) _e('(required)'); ?></small></label>
			</p>
			<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
			<label for="url"><small><strong>url</strong></small></label>
			</p>
			</div>
		<?php } ?>
		<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
		
		<?php if (function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>
		<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit" />
		<?php comment_id_fields(); ?>
		<br class="all" /></p>
		
		<?php do_action('comment_form', $post->ID); ?>
		</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>

</div>
<?php } ?>
