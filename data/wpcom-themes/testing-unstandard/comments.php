<div id="comments">
  <div id="comment-breaker">
    <h2><?php comments_number('No Comments Yet', 'One Comment', '% Comments' );?></h2>
  </div>
<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments">This post is password protected. Enter the password to view comments.<p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>
<!-- You can start editing here. -->
<?php if ($comments) : ?>
  <div class="fix">
	<ol class="commentslist">
	<?php foreach ($comments as $comment) : ?>
	<?php if (get_comment_type() == "comment"){ ?>
		<li class="<?php if ($comment->comment_author_email == "admin@yoursite.com") echo 'author'; else echo $oddcomment; ?> item" id="comment-<?php comment_ID() ?>">
			<div class="fix">
				<div class="author_meta">
					<a href="#comment-<?php comment_ID() ?>" title="Comment Permalink"><?php comment_date('M jS, Y') ?></a><br />
					<?php if (function_exists('quoter_comment')) { quoter_comment(); } ?><br />
					<?php edit_comment_link('edit this','(',')'); ?>
				</div>
				<div class="comment_text">
				  <div class="comment-author"><?php comment_author_link() ?></div>
					<?php if ($comment->comment_approved == '0') : ?>
					<em>Your comment is awaiting moderation.</em>
						<?php endif; ?>
					<?php comment_text() ?>
				</div>
			</div>
		</li>	
	<?php /* Changes every other comment to a different class */ if ('alt' == $oddcomment) $oddcomment = ''; else $oddcomment = 'alt'; ?>
	<?php } ?>
	<?php endforeach; /* end for each comment */ ?>
	</ol>
	<div class="pings">
	  <h3>Incoming Links</h3>
    	<ul class="pingslist">
    	<?php foreach ($comments as $comment) : ?>
    	<?php if (get_comment_type() != "comment"){ ?>
    		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
    			<?php comment_author_link() ?>
    		</li>
    	<?php /* Changes every other comment to a different class */ if ('alt' == $oddcomment) $oddcomment = ''; else $oddcomment = 'alt'; ?>
    	<?php } ?>
    	<?php endforeach; /* end for each comment */ ?>
    	</ul>
	</div>
	</div>
		<?php else : // this is displayed if there are no comments so far ?>
 		<?php if ('open' == $post->comment_status) : ?> 
	<!-- If comments are open, but there are no comments. -->
 	<?php else : // comments are closed ?>
	<!-- If comments are closed. -->
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>
	<h3 id="respond" style="color:#f47a0e;font-size:18px;margin-left:90px;">Leave a Reply</h3>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<?php else : ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php if ( $user_ID ) : ?>
		<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
	<?php else : ?>
		<p>
		  <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="101" />
		  <label for="author"><small>Name <?php if ($req) echo "*"; ?></small></label>
		</p>
		<p>
		  <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="102" />
		  <label for="email"><small>Email <?php if ($req) echo "*"; ?></small></label>
		</p>
		<p>
		  <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="103" /> 
		  <label for="url"><small>Website</small></label>
		</p>
<?php endif; ?>
		<p>
		  <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="104"></textarea>
		</p>
		<p>
		  <input name="submit" type="submit" id="submit" tabindex="105" value="Submit Comment" />
      <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		</p>
	<?php do_action('comment_form', $post->ID); ?>
	</form>
<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
</div>