<?php if ('open' == $post->comment_status || $comments) : ?>
<div id="showcomments"><a href="#comments">&#9654; <?php comments_number(__('No Responses', 'depo-masthead'), __('One Response', 'depo-masthead'), __('% Responses', 'depo-masthead'));?></a></div>

<div id="comments">

<script type="text/javascript" charset="utf-8">
/*<![CDATA[ */
// comment hide/show mechanism
	jQuery(document).ready(function() {
		check_location();			
		function check_location(trick) {
			if(trick != 'hide' && window.location.href.indexOf('#comment') > 0) {
				jQuery('#comments').show('', change_location());
				jQuery('#showcomments a .closed').css('display', 'none');
				jQuery('#showcomments a .open').css('display', 'inline');
				return true;
			} else {
				jQuery('#comments').hide('');
				jQuery('#showcomments a .closed').css('display', 'inline');
				jQuery('#showcomments a .open').css('display', 'none');
				return false;
			}
		}
		jQuery('#showcomments a').click(function(){
			if(jQuery('#comments').css('display') == 'none') {
				self.location.href = '#comments';
				check_location();
			} else {
				check_location('hide');
			}
		});
		function change_location() {
			self.location.href = '#comments';
		}
	});
/* ]]> */
</script>

<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'depo-masthead'); ?></p></div>

			<?php
			return;
		}
	}
if( !function_exists('depo_masthead_comment') ) {
	function depo_masthead_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
	?>
		<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<div id="div-comment-<?php comment_ID() ?>">
			<div class="comments_text">
			<?php comment_text(); ?>
			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.', 'depo-masthead'); ?></em>
			<?php endif; ?>
			
			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			</div>
				
			<div class="comment-meta commentmetadata">
				<div class="gravatar"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
				<div class="cite comment-author vcard">
				<cite class="fn"><?php comment_author_link() ?></cite>
				<small><a href="#comment-<?php comment_ID() ?>" title=""><strong><?php comment_date('j F Y') ?></strong> at <strong><?php comment_time('ga') ?></strong></a> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></small>
				</div>
			</div>
		</div>
	<?php		
	}
}
if (have_comments()) : ?>

	<ol class="commentlist">

	<?php wp_list_comments(array(
		'callback'=>'depo_masthead_comment',
		'avatar_size'=>48,
	)); ?>
	</ol>
	
	<div class="commentnavigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>	

	<?php if ('closed' == $post->comment_status) : ?>
		<p class="nocomments"><?php _e('Comments are closed.', 'depo-masthead'); ?></p>
	<?php endif; ?>
<?php endif; ?>


<?php if (comments_open()) : ?>

<div id="respond">

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'kubrick'), wp_login_url( get_permalink() )); ?></p>

<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php cancel_comment_reply_link() ?>
	<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
	
	<div class="form group">	
	
	<?php if ( $user_ID ) : ?>
		<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'depo-masthead'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'depo-masthead'); ?>"><?php _e('Log out &raquo;', 'depo-masthead'); ?></a></p>
	<?php else : ?>

		<p><label for="author"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		<small><?php _e('Name', 'depo-masthead'); ?></small> <?php if ($req) _e('required', 'depo-masthead'); ?></label></p>

		<p><label for="email"><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			<small><?php _e('E-mail', 'depo-masthead'); ?></small> <span>(<?php if ($req) _e('required, ', 'depo-masthead'); ?><?php _e('not published', 'depo-masthead'); ?>)</span></label></p>

			<p><label for="url"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<small><?php _e('Website', 'depo-masthead'); ?></small> <span><?php _e('(not required)', 'depo-masthead'); ?></span></label></p>

<?php endif; ?>

	<p><input name="submit" type="submit" id="submit" tabindex="5" value="<? _e('Submit', 'depo-masthead'); ?>" />
		<?php comment_id_fields(); ?>
	</p>
		<?php do_action('comment_form', $post->ID); ?>
	</div>
</form>
</div>
<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
</div>
<?php endif; ?>
