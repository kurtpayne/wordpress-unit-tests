<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
<?php
	return;
}

if (comments_open()) : ?>
	<div id="respond">
	<h2 class="top_border"><?php comment_form_title( 'Make a Comment', 'Make a Comment to %s' ); ?>: ( <a href="#respond"><?php comments_number('None', '1', '%'); ?></a> so far )</h2>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
	<div id="comment_form">
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( $user_ID ) : ?>				
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
			<label for="comment"><small>Your Comment</small><br /><textarea name="comment" id="comment" cols="20" rows="5" tabindex="1" style="width:95%;"></textarea></label>
			<p><small>Change comment box size: <a style="cursor: pointer;" onclick="document.getElementById('comment').rows += 5;" title="Click to enlarge the comments textarea">+</a> | <a style="cursor: pointer;" onclick="document.getElementById('comment').rows -= 5;" title="Click to decrease the comments textarea">&#8211;</a><br />
			(<em>blockquote</em> and <em>a</em> tags work here.)</small></p>
			<div class="clear"></div>
			<input name="submit" type="submit" id="submit" tabindex="2" value="Submit Comment" class="float_right" />
			<div class="clear"></div>
			<?php comment_id_fields(); ?>
		<?php else : ?>
			<div class="comment_wrapper">
				<div class="comment_content">
					<label for="comment"><small>Your Comment</small><br /><textarea name="comment" id="comment" cols="20" rows="5" tabindex="1" style="width:95%;"><?php if (function_exists('quoter_comment_server')) { quoter_comment_server(); } ?></textarea></label>
				</div>
			</div>
			<div class="comment_details">				
				<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small><br /><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="2" style="width:95%;" /></label>
				<label for="email"><small>E-mail <?php if ($req) echo "(required)"; ?> (hidden)</small><br /><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="3" style="width:95%;" /></label>
				<label for="url"><small>Website</small><br /><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="4" style="width:95%;" /></label>
				<!--<p><small><strong>XHTML:</strong> You can use these tags: &lt;a href=&quot;&quot; title=&quot;&quot;&gt; &lt;abbr title=&quot;&quot;&gt; &lt;acronym title=&quot;&quot;&gt; &lt;b&gt; &lt;blockquote cite=&quot;&quot;&gt; &lt;code&gt; &lt;em&gt; &lt;i&gt; &lt;strike&gt; &lt;strong&gt; </small></p>-->
			</div>
			<div class="clear"></div>
				<input name="submit" class="button" type="submit" id="submit" tabindex="5" value="Submit Comment" />
				<?php comment_id_fields(); ?>
				<p><small><em>blockquote</em> and <em>a</em> tags work here.</small></p>
			<?php endif; ?>
			<?php do_action('comment_form', $post->ID); ?>
			<div class="clear"></div>
		</form>
		<?php endif; // If registration required and not logged in ?>
	</div>
	</div>
<?php endif; 

function fadtastic_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<div <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="div-comment-<?php comment_ID() ?>">
	<div class="comment_wrapper" id="comment-<?php comment_ID() ?>">
		<div class="comment_content">
			<?php if ($comment->comment_approved == '0') : ?>
			<em>Your comment is awaiting moderation.</em>
			<?php else : ?>
			<?php comment_text() ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="comment_details comment-author vcard">
		<p class="comment-meta commentmetadata comment_meta"><strong class="fn"><?php comment_author_link() ?></strong><br /><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date() ?></a><br /></p>
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>		
	</div>
	<div class="clear"></div>
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<div class="clear comment_bottom"></div>
<?php
}


if (have_comments()) : ?>
	<h2 id="comments" class="top_border"><?php comments_number('No Responses Yet', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h2>
	<p class="author"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_rss.gif" alt="RSS Feed for <?php bloginfo('name'); ?>" border="0" class="vertical_align" /> <strong><?php comments_rss_link('Comments RSS Feed', 'file'); ?></strong></p>

	<div class="commentlist">
	<?php wp_list_comments(array('callback'=>'fadtastic_comment', 'style'=>'div')); ?>
	</div>
	
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	
	<br />

	<?php if ( comments_open() ) : ?> 
		<p><a href="#respond">Where's The Comment Form?</a></p>
	<?php else : ?>
		<p class="nocomments">Comments are closed.</p>
	<?php endif; ?>
<?php endif; ?>
