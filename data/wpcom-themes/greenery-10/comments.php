<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected.'); ?></p>
	<?php
		return;
	}

function greenery_10_comment($comment, $args, $depth) {
	global $relax_comment_count;
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
	<li <?php comment_class(empty( $args['has_children'] ) ? 'item' : 'item parent') ?> id="comment-<?php comment_ID() ?>" >
		<div id="div-comment-<?php comment_ID() ?>">
		<div class="commentcounter"><?php echo $relax_comment_count; ?></div>
		
			<div class="comment-author vcard">
				<div class="commentgravatar">
					<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>
			
				<h3 class="commenttitle"><span class="fn"><?php comment_author_link() ?></span> <?php _e('said'); ?>,</h3>
			</div>
			<p class="commentmeta comment-meta commentmetadata">
				<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
					<?php comment_date() ?> @ <?php comment_time() ?>
				</a>
				<?php if (function_exists('quoter_comment')) { quoter_comment(); } ?>
				<?php edit_comment_link(__("Edit"), ' &#183; ', ''); ?>
	
			</p>
			<?php comment_text() ?>
			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>		
	<?php $relax_comment_count++; ?>
<?php
}

if (have_comments()) : ?>

	<h2 id="comments">
		<?php comments_number(__('Comments'), __('1 Response'), __('% Responses')); ?> <?php _e('so far'); ?>
		<?php if ( comments_open() ) : ?>
			<a href="#respond" title="<?php _e('Jump to the comments form'); ?>">&raquo;</a>
		<?php endif; ?>
	</h2>
	
	<ol id='commentlist' class="commentlist">
	<!-- Comment Counter -->
	<?php 
	global $relax_comment_count;
	$relax_comment_count=isset($commentcount)? $commentcount+0 : 1; 
	
	wp_list_comments(array('callback'=>'greenery_10_comment', 'avatar_size'=>48)); 
	?>
	</ol>
	
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<br />
	
	<p class="small">
		<?php comments_rss_link(__('Comment <abbr title="Really Simple Syndication">RSS</abbr>')); ?>
		<?php if ( pings_open() ) : ?>
			&#183; <a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Uniform Resource Identifier">URI</abbr>'); ?></a>
		<?php endif; ?>
	</p>
<?php endif; ?>

<?php if (comments_open()) : ?>
	<div id="respond">
	<h2 id="postcomment"><?php comment_form_title(__('Say your words'), __('Say your words to %s')); ?></h2>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
	
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	
		<p><?php _e('You must be'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in'); ?></a> <?php _e('to post a comment.'); ?></p>
	
	<?php else : ?>
	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		
		<?php if ( $user_ID ) : ?>
		
			<p><?php _e('Logged in as'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout'); ?> &raquo;</a></p>

		<?php else : ?>
	
			<p>
			<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="30" tabindex="1" />
			<label for="author"><?php _e('&nbsp;Name'); ?> <?php if ($req) _e('(required)'); ?></label>
			</p>
			
			<p>
			<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="30" tabindex="2" />
			<label for="email"><?php _e('&nbsp;E-mail'); ?> <?php if ($req) _e('(required, hidden to public)'); ?></label>
			</p>
			
			<p>
			<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="30" tabindex="3" />
			<label for="url">&nbsp;<abbr title="<?php _e('Uniform Resource Identifier'); ?>"><?php _e('URI'); ?></abbr> (your blog or website)</label>
			</p>

		<?php endif; ?>

		<!-- Emoitions -->
		<?php if (class_exists('emotions')) { emotions::bar(); } ?>

		<p>
		<textarea name="comment" id="comment" cols="80" rows="12" tabindex="4"><?php if (function_exists('quoter_comment_server')) { quoter_comment_server(); } ?></textarea>
		</p>

		<p>
		<input name="submit" type="submit" id="submit" class="button" tabindex="5" value="<?php _e('Submit Comment'); ?>" />
		<?php comment_id_fields(); ?>
		</p>
	
		<?php do_action('comment_form', $post->ID); ?>
	
		</form>

	<?php endif; // If registration required and not logged in ?>
	</div>
<?php elseif ( have_comments() ) : ?>
	<p><?php _e('Comments are closed.'); ?></p>
<?php endif; // if you delete this the sky will fall on your head ?>
