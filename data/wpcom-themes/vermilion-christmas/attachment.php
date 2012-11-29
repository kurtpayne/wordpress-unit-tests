<?php get_header(); ?>

<!-- BEGIN ATTACHMENT.PHP -->
<div id="wide-page">
<div id="wide-content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
      <h2 align="center" class="post-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
      <div class="entry justify">
	  
	  <p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>

				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
	  
	  <p class="postmetadata">

<?php /* This is commented, because it requires a little adjusting sometimes.
		You'll need to download this plugin, and follow the instructions:
		http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
		/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?> 
Published: <?php the_time(get_option('date_format')) ?> <!-- at <?php the_time() ?> --> <br />

<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
	// Both Comments and Pings are open ?>
<a href="#respond">Leave a response</a> | <a href="<?php trackback_url(true); ?>" rel="trackback">Trackback</a>

<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
	// Only Pings are Open ?>
Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.

<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
	// Comments are open, Pings are not ?>
You can skip to the end and leave a response. Pinging is currently not allowed.

<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
	// Neither Comments, nor Pings are open ?>
Both comments and pings are currently closed.

<?php } edit_post_link('Edit this entry.','| ',''); ?>

</p>
	  
	  </div>

<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no attachments matched your criteria.</p>

<?php endif; ?>

</div>
</div>
<!-- END ATTACHMENT.PHP -->

<?php get_footer(); ?>
