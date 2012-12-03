<?php
/*
Filename: 		comments.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

$aOptions = get_option('gi_subtle_theme');

load_theme_textdomain('gluedideas_subtle');

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) {
	echo('<p class="nocomments">' . __("This post is password protected. Enter the password to view comments.", 'gluedideas_subtle') . '</p>');
	return;
}

global $iCommentCount;
$iCommentCount = 0;

function subtle_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $iCommentCount;
	extract($args, EXTR_SKIP);
?>
<div id="comment-<?php comment_ID() ?>" <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?>>
	<dl class="metadata reduced vcard">
	<dt class="comment_number gravatar">Gravatar:</dt> <dd class="comment_number"><a href="http://www.gravatar.com/" title="<?php _e('What is this?', get_bloginfo('name')); ?>">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></a></dd>
	<dt class="comment_number"><?php _e("Comment Number:", 'gluedideas_subtle'); ?></dt> <dd class="comment_number"><?php $iCommentCount++; echo($iCommentCount); ?></dd>
	<dt class="writer"><?php _e("Written by:", 'gluedideas_subtle'); ?></dt> <dd class="writer fn"><?php comment_author_link() ?><br /></dd>
	<dt class="timedate"><?php _e("Posted on:", 'gluedideas_subtle'); ?></dt> <dd class="timedate"><?php comment_date() ?> at <?php comment_time() ?> 
	<?php edit_comment_link('Edit','',''); ?>
	<span class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'comment-content', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</span>
	</dd>
	</dl>
	<div class="content" id="comment-content-<?php comment_ID() ?>">
		<?php if ($comment->comment_approved == '0') { echo('<p>Your comment is awaiting moderation.</p>'); } ?>
		<?php comment_text() ?>
	</div>

<?php
}

?>

<div id="comment_area">

<?php if (comments_open()) : ?>
	
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="form_comments" class="prominent reduced"><div class="inner" id="respond">
	
		<h2><?php comment_form_title( __("Write a Comment", 'gluedideas_subtle'), __("Write a Comment to %s", 'gluedideas_subtle') ); ?></h2>
		<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
		<p><?php _e("Take a moment to comment and tell us what you think.  Some basic HTML is allowed for formatting.", 'gluedideas_subtle'); ?></p>
	
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><?php _e("You must be logged in to post a comment.", 'gluedideas_subtle'); ?>  <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e("Click here to login.", 'gluedideas_subtle'); ?></a></p>
<?php else : ?>
	
<?php if ( $user_ID ) : ?>
	
		<p><?php _e("Logged in as", 'gluedideas_subtle'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. | <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php _e("Click to log out", 'gluedideas_subtle'); ?></a>.</p>
	
<?php else : ?>
	
		<p><input type="text" id="input_comments_name" name="author" value="<?php echo $comment_author; ?>" class="input standard" /> <label for="input_comments_name"><?php _e("Name", 'gluedideas_subtle'); ?> <?php if ($req) echo "(required)"; ?></label></p>
		<p><input type="text" id="input_comments_email" name="email" value="<?php echo $comment_author_email; ?>" class="input standard" /> <label for="input_comments_email"><?php _e("E-mail", 'gluedideas_subtle'); ?> <?php if ($req) echo "(required)"; ?></label></p>
		<p><input type="text" id="input_comments_url" name="url" value="<?php echo $comment_author_url; ?>" class="input standard" /> <label for="input_comments_url"><?php _e("Website", 'gluedideas_subtle'); ?></label></p>
		
<?php endif; ?>
	
		<p><input type="checkbox" id="input_allow_float" name="allow_float" value="true" /> <label for="input_allow_float"><?php _e("Allow comment box to float next to comments.", 'gluedideas_subtle'); ?></label></p>

		<p><textarea name="comment" id="input_comment" rows="10" cols="40" class="input textarea" ><?php _e("Type your comment here.", 'gluedideas_subtle'); ?></textarea></p>
	  
		<p><input type="submit" id="input_comments_submit" name="submit" value="Submit Comment"/><?php comment_id_fields(); ?></p>
	
<?php do_action('comment_form', $post->ID); ?>
	
<?php endif; ?>

	</div></form>
	
<?php endif; ?>

	<div id="loop_comments">
	
		<a name="comments"></a>
		
		<h2><?php _e("Reader Comments", 'gluedideas_subtle'); ?></h2>
		
<?php if (have_comments()) : ?>
	<?php wp_list_comments(array('callback'=>'subtle_comment', 'style'=>'div', 'avatar_size' => 40)); ?>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<br />
	
<?php else : ?>
	
	<?php if (comments_open()) : ?> 
				<p><?php _e("Be the first to leave a comment!", 'gluedideas_subtle'); ?></p>
				
	<?php else :  ?>
				<p><?php _e("Sorry, comments are closed.", 'gluedideas_subtle'); ?></p>
				
	<?php endif; ?>
		
<?php endif; ?>
	
	</div>
	
	<br class="clear" />

	<script language="JavaScript" type="text/javascript" src="<?php bloginfo('template_directory'); ?>/assets/js/form_comments.js"></script>

</div>
