<li id="prologue-<?php the_ID(); ?>" <?php post_class( get_the_author_meta('ID') ); ?>>

		<?php if ( !is_page() ) : ?>
			<?php 
				printf( 
					'<a href="%1$s" title="%2$s">%3$s</a>',
					get_author_posts_url( p2_get_author_id(), p2_get_author_name() ),
					sprintf( __( 'Posts by %s', 'p2' ), esc_attr( get_the_author() ) ),
					p2_get_user_avatar( array( 'user_id' => p2_get_author_id(), 'size' => 48 ) )
				);
			?>
		<?php endif; ?>
		
		<?php if ( !is_page() ) : ?>
			<h4>
			<?php
				printf(
					'<a href="%1$s" title="%2$s">%3$s</a>',
					get_author_posts_url( p2_get_author_id(), p2_get_author_name() ),
					sprintf( __( 'Posts by %s', 'p2' ), p2_get_author_name() ),
					get_the_author()
				);
			?>
			<span class="meta">
				<?php echo p2_date_time_with_microformat() ?>

				<span class="actions">
					<?php if ( !is_single() ) : ?>
						<a href="<?php the_permalink() ?>" class="thepermalink"><?php _e( 'Permalink', 'p2' ) ?></a> |
					<?php endif; ?>
				
					<?php echo post_reply_link( array( 'before' => '', 'reply_text' => __('Reply', 'p2'), 'add_below' => 'prologue'), get_the_id() ) ?>

					<?php if ( current_user_can('edit_post', get_the_id() ) ) : ?>
						| <a href="<?php echo ( get_edit_post_link( get_the_id() ) ) ?>" class="post-edit-link" rel="<?php the_ID() ?>"><?php _e( 'Edit', 'p2' ) ?></a>
					<?php endif; ?>
				</span>
				
				<span class="tags">
					<?php tags_with_count( '', __( '<br />Tags:' , 'p2' ) .' ', ', ', ' &nbsp;' ) ?>&nbsp;
				</span>
			</span>
		</h4>
	<?php endif; ?>

	<div class="postcontent<?php if ( current_user_can( 'edit_post', get_the_id() ) ) : ?> editarea<?php endif ?>" id="content-<?php the_ID() ?>">
		<?php if ( 'status' == p2_get_the_category() || 'link' == p2_get_the_category() ) : ?>

			<?php p2_title( '<h2>','</h2>' ); ?>
			
			<?php the_content( __( '(More ...)' , 'p2' ) ); ?>
			
		<?php elseif ( 'quote' == p2_get_the_category() ) : ?>

			<?php p2_title( '<h2>','</h2>' ) ?>
						
			<blockquote>
				<?php p2_quote_content() ?>
			</blockquote>
			
		<?php elseif ( 'post' == p2_get_the_category() ) : ?>
			
			<?php p2_title( '<h2>','</h2>' ) ?>
			<?php the_content( __( '(More ...)' , 'p2' ) ); ?>
			
		<?php else : ?>
			
			<?php p2_title( '<h2>','</h2>' ); ?>
			
			<?php the_content( __( '(More ...)' , 'p2' ) ); ?>
		
		<?php endif; ?>
	</div>

	<?php if ( get_comments_number() > 0 ) : ?>
		<div class="discussion" style="display: none">
			<p>
				<?php p2_discussion_links() ?>
				<a href="#" class="show_comments" id="prologue-<?php the_ID(); ?>"><?php _e( 'Toggle Comments', 'p2' ) ?></a>
			</p>
		</div>
	<?php endif; ?>

	<div class="bottom_of_entry">&nbsp;</div>

	<?php if ( !p2_is_ajax_request() ) : ?>
		<?php comments_template() ?>

		<?php if ( p2_show_comment_form() ) : ?>

			<div style="display:none">

				<div id="respond" style="display:none">
					<?php locate_template( array( 'comment-form.php' ), true ) ?>
				</div>

			</div>   

		<?php endif; ?>

	<?php endif; ?>
</li>