<?php
/*
Template Name: Contact
*/
$cp_question = "6+3 = ?";
$cp_answer = "9";
?>
<?php get_header(); ?>
	<div id="content">
	<div id="content-main">
 		   
    	<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div <?php post_class(); ?>>
				<?php
					function is_valid_answer($answer)
					{
						global $cp_answer;
						if ($answer == $cp_answer) { return true; } else { return false;}
					}
					//clean up text
					function clean($text)
					{
						return stripslashes($text);
					}

					$cp_name    = (!empty($_POST['cp_name']))    ? $_POST['cp_name']    : "";
					$cp_email   = (!empty($_POST['cp_email']))   ? $_POST['cp_email']   : "";
					$cp_url     = (!empty($_POST['cp_url']))     ? $_POST['cp_url']     : "";
					$cp_ans     = (!empty($_POST['cp_ans']))     ? $_POST['cp_ans']     : "";
					$cp_message = (!empty($_POST['cp_message'])) ? $_POST['cp_message'] : "";
					$cp_message = clean($cp_message);
					$error_msg = "";
					$send = 0;
					if (!empty($_POST['submit'])) {
						$send = 1;
						if (empty($cp_name) || empty($cp_email) || empty($cp_message) || empty($cp_ans)) {
							$error_msg.= "<p style='color:#a00'><strong>".__('Please fill in all required fields.','mistylook')."</strong></p>\n";
							$send = 0;
						}
						if (!is_email($cp_email)) {
							$error_msg.= "<p style='color:#a00'><strong>".__('Your email adress failed to validate.')."</strong></p>\n";
							$send = 0;
						}
						if (!is_valid_answer($cp_ans)) {
							$error_msg.= "<p style='color:#a00'><strong>".__('Incorrect Answer to the AntiSpam Question.')."</strong></p>\n";
							$send = 0;
						}
					}
					if (!$send) { ?>
						<h2 class="post-title"><?php the_title(); ?></h2>
						<p class="post-info">
						<?php edit_post_link(); ?>
						</p>
						<div class="post-content">
							<?php the_content(__("Continue Reading &raquo;",'mistylook'));
							?>
							<p class="post-info">* &mdash; <?php _e('Required Fields','mistylook'); ?></p>
							<?php echo $error_msg;?>
							<form method="post" action="<?php echo attribute_escape("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" id="contactform">
              
								<fieldset>
									<strong><?php _e('Name','mistylook'); ?></strong>*<br/>
									<input type="text" class="textbox" id="cp_name" name="cp_name" value="<?php echo $cp_name ;?>" /><br/><br/>
									<strong><?php _e('Email','mistylook'); ?></strong>*<br/>
									<input type="text" class="textbox" id="cp_email" name="cp_email" value="<?php echo $cp_email ;?>" /><br/><br/>
									<strong><?php _e('Website','mistylook'); ?></strong><br/>
									<input type="text" class="textbox" id="cp_url" name="cp_url" value="<?php echo $cp_url ;?>" /><br/><br/>
									<strong><?php _e('AntiSpam Challenge:','mistylook'); ?> <?php echo $cp_question; ?> </strong>*<br/>
									<input type="text" class="textbox" id="cp_ans" name="cp_ans" value="<?php echo $cp_ans ;?>" /><p class="post-info">[<?php _e('Just to prove you are not a spammer','mistylook'); ?>]</p><br/>
									<strong><?php _e('Message','mistylook'); ?></strong>*<br/>				
									<textarea id="cp_message" name="cp_message" cols="100%" rows="10"><?php echo $cp_message ;?></textarea><br/>
									<input type="submit" id="submit" name="submit" value="<?php _e('Send Message','mistylook'); ?>" />		
								</fieldset>
							</form>
						</div>
					<?php
					} else {
						$displayName_array	= explode(" ",$cp_name);
						$displayName = $displayName_array[0];
			
						$header  = "MIME-Version: 1.0\n";
						$header .= "Content-Type: text/plain; charset=\"utf-8\"\n";
						$header .= "From: $cp_name <$cp_email>\n";
						$email_subject	= "[" . get_settings('blogname') . "] $cp_name";
						$email_text		= __("From......:",'mistylook') . ' ' . $cp_name . "\n" .
							  __("Email.....:",'mistylook') . ' ' . $cp_email . "\n" .
							  __("Url.......:",'mistylook') . ' ' . $cp_url . "\n\n" .
							  $cp_message;

						$post_author = get_userdata( $post->post_author );

						if (wp_mail($post_author->user_email, $email_subject, $email_text, $header)) {
							echo "<h2>" . sprintf(__('Hey %s,','mistylook'), $displayName) . "</h2><p>" . __("Thanks for your message! I'll get back to you as soon as possible.",'mistylook') . "</p>";
						}
					}
					?>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
