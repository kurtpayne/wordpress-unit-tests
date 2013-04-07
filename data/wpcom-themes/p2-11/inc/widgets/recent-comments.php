<?php

class P2_Recent_Comments extends WP_Widget {
	function P2_Recent_Comments() {
		$this->WP_Widget( false, __('P2 Recent Comments', 'p2'), array('description' => __('Recent comments with avatars.', 'p2')));
		
		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'wp_set_comment_status', array(&$this, 'flush_widget_cache') );
		
		$this->default_num_to_show = 5;
		$this->default_avatar_size = 32;
	}
	
	function flush_widget_cache() {
		wp_cache_delete( 'p2_recent_comments', 'widget' );
	}
	
	function form( $instance ) {
		$title = esc_attr( $instance['title'] );
		$title_id = $this->get_field_id('title');
		$title_name = $this->get_field_name('title');
		$num_to_show = esc_attr( $instance['num_to_show'] );
		$num_to_show_id = $this->get_field_id('num_to_show');
		$num_to_show_name = $this->get_field_name('num_to_show');
		$avatar_size = esc_attr( $instance['avatar_size'] );
		$avatar_size_id = $this->get_field_id('avatar_size');
		$avatar_size_name = $this->get_field_name('avatar_size');
		$sizes = array(
			'32' => 'Yes &mdash; 32x32',
			'-1' => __('No avatar', 'p2'),
		);
?>
	<p>
		<label for="<?php echo $title_id ?>"><?php _e('Title:', 'p2') ?> 
			<input type="text" class="widefat" id="<?php echo $title_id ?>" name="<?php echo $title_name ?>"
				value="<?php echo $title; ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo $num_to_show_id ?>"><?php _e('Number of comments to show:', 'p2') ?> 
			<input type="text" class="widefat" id="<?php echo $num_to_show_id ?>" name="<?php echo $num_to_show_name ?>"
				value="<?php echo $num_to_show; ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo $avatar_size_id ?>"><?php _e('Avatars:', 'p2') ?> 
			<select name="<?php echo $avatar_size_name ?>" id="<?php echo $avatar_size_id ?>">
			<?php foreach($sizes as $value => $label): ?>
				<option value="<?php echo $value ?>" <?php selected($value, $avatar_size); ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</label>
	</p>
	
<?php		
	}
	
	function update( $new_instance, $old_instance ) {
		$new_instance['num_to_show'] = (int)$new_instance['num_to_show']? (int)$new_instance['num_to_show'] : $this->default_num_to_show;
		$new_instance['avatar_size'] = (int)$new_instance['avatar_size']? (int)$new_instance['avatar_size'] : $this->default_avatar_size;
		return $new_instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = (isset( $instance['title'] ) && $instance['title'])? $instance['title'] : __('Recent comments', 'p2');
		$num_to_show = (isset( $instance['num_to_show'] ) && (int)$instance['num_to_show'])? (int)$instance['num_to_show'] : $this->default_num_to_show;
		$avatar_size = (isset( $instance['avatar_size'] ) && (int)$instance['avatar_size'])? (int)$instance['avatar_size'] : $this->default_avatar_size;
		
		$no_avatar = $avatar_size == '-1';
		
		$recent_comments = $this->recent_comments( $num_to_show );
		
		echo $before_widget . $before_title . wp_specialchars( $title ) . $after_title;
?>
		<table class='p2-recent-comments' cellspacing='0' cellpadding='0' border='0' avatar="<?php echo esc_attr($avatar_size); ?>">
		<?php foreach( $recent_comments as $comment ):
			echo $this->single_comment_html( $comment, $avatar_size );
		endforeach;
		echo "\t</table>";
	}
	
	function comment_url_maybe_local( $comment ) {
		// Only use the URL's #fragment if the comment is visible on the page.
		// Works by detecting if the comment's post is visible on the page... may break if P2 decides to do clever stuff with comments when paginated
		$comment_url = get_comment_link( $comment );
		if ( @constant( 'DOING_AJAX' ) && isset( $_GET['vp'] ) && is_array( $_GET['vp'] ) && in_array( $comment->comment_post_ID, $_GET['vp'] ) ) {
			$comment_url = "#comment-{$comment->comment_ID}";
		} else {
			static $posts_on_page = false;
			if ( false === $posts_on_page ) {
				global $wp_query;
				
				$posts_on_page = array();
				foreach ( (array)array_keys( $wp_query->posts ) as $k )
					$posts_on_page[$wp_query->posts[$k]->ID] = true;
			}

			if ( isset( $posts_on_page[$comment->comment_post_ID] ) )
				$comment_url = "#comment-{$comment->comment_ID}";
		}
		return $comment_url;
	}
	
	function recent_comments( $num_to_show ) {
		global $wpdb;
		$cache = wp_cache_get( 'p2_recent_comments', 'widget' );
		if ( !is_array( $cache ) ) {
			$cache = array();
		}
		if ( isset( $cache[$num_to_show] ) && is_array( $cache[$num_to_show] ) ) {
			return $cache[$num_to_show];
		}
				
		$comments = (array)$wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT $num_to_show");
			
		$cache[$num_to_show] = $comments;
		wp_cache_add( 'p2_recent_comments', $cache, 'widget' );
		return $comments;
	}
	
	function single_comment_html($comment, $avatar_size ) {
		$no_avatar = $avatar_size == '-1';
		
		if ( !$comment->comment_author ) $comment->comment_author = __('Anonymous', 'p2');
		$author_name = $comment->comment_author;
		$author_html = $comment->comment_author;
		
		$excerpt = wp_html_excerpt( $author_name, 20 );
		if ( $author_name != $excerpt ) $author_name = $author_excerpt.'&hellip;';

		$avatar = $no_avatar? '' : get_avatar( $comment, $avatar_size );
		
		$comment_author_url = $comment->comment_author_url ? clean_url( $comment->comment_author_url ) : '';
		if ( $comment_author_url ) {
			$avatar = "<a href='$comment_author_url' rel='nofollow'>$avatar</a>";
			// entitities in comment author are kept escaped in the db and tags are not allowed, so no need of HTML escaping here
			$author_html = "<a href='$comment_author_url' rel='nofollow'>$author_name</a>";
		}
		
		$author_name = esc_attr( $author_name );
		
		$row  = "<tr>";
		if ( !$no_avatar) $row .= "<td title='$author_name' class='avatar' style='height: ${avatar_size}px; width: ${avatar_size}px'>" . $avatar . '</td>';

		$post_title = wp_specialchars( strip_tags( get_the_title( $comment->comment_post_ID ) ) );
		$excerpt = wp_html_excerpt( $post_title, 30 );
		if ( $post_title != $excerpt ) $post_title = $excerpt.'&hellip;';

		$comment_content = strip_tags( $comment->comment_content );
		$excerpt = wp_html_excerpt( $comment_content, 50 );
		if ( $comment_content != $excerpt ) $comment_content = $excerpt.'&hellip;';

		$comment_url = P2_Recent_Comments::comment_url_maybe_local( $comment );

		$row .= sprintf( '<td class="text">'.__( "%s on <a href='%s' class='tooltip' title='%s'>%s</a>" , 'p2') . '</td></tr>', $author_html, $comment_url, attribute_escape($comment_content), $post_title );
		return $row;
	}
}

register_widget('P2_Recent_Comments');
