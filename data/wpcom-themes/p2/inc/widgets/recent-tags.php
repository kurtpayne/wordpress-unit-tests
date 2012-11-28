<?php

class P2_Recent_Tags extends WP_Widget {
	function P2_Recent_Tags() {
		$this->WP_Widget( false, __('P2 Recent Tags', 'p2'), array('description' => __('The tags from the latest posts.', 'p2')));
		$this->default_num_to_show = 35;
	}
	
	function form( $instance ) {
		$title = esc_attr( $instance['title'] );
		$title_id = $this->get_field_id('title');
		$title_name = $this->get_field_name('title');
		$num_to_show = esc_attr( $instance['num_to_show'] );
		$num_to_show_id = $this->get_field_id('num_to_show');
		$num_to_show_name = $this->get_field_name('num_to_show');
		
?>
	<p>
		<label for="<?php echo $title_id ?>"><?php _e('Title:', 'p2') ?> 
			<input type="text" class="widefat" id="<?php echo $title_id ?>" name="<?php echo $title_name ?>"
				value="<?php echo $title; ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo $num_to_show_id ?>"><?php _e('Number of tags to show:', 'p2') ?> 
			<input type="text" class="widefat" id="<?php echo $num_to_show_id ?>" name="<?php echo $num_to_show_name ?>"
				value="<?php echo $num_to_show; ?>" />
		</label>
	</p>
<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$new_instance['num_to_show'] = (int)$new_instance['num_to_show']? (int)$new_instance['num_to_show'] : $this->default_num_to_show;
		return $new_instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = (isset( $instance['title'] ) && $instance['title'])? $instance['title'] : __('Recent tags', 'p2');
		$num_to_show = (isset( $instance['num_to_show'] ) && (int)$instance['num_to_show'])? (int)$instance['num_to_show'] : $this->default_num_to_show;
		
		$recent_tags = $this->recent_tags( $num_to_show );
		
		echo $before_widget . $before_title . wp_specialchars( $title ) . $after_title;
		echo "\t<ul>\n";

		foreach( $recent_tags as $recent ):
	?>
		<li>
			<a class="rss" href="<?php echo clean_url( $recent['feed_link'] ); ?>">RSS</a>&nbsp;
			<a href="<?php echo clean_url( $recent['link'] ); ?>"><?php echo wp_specialchars( $recent['tag']->name ); ?></a>&nbsp;
			(&nbsp;<?php echo number_format_i18n( $recent['tag']->count ); ?>&nbsp;)
		</li>
	<?php
	    endforeach;
	?>
	</ul>
	<p>
		<a class="allrss" href="<?php bloginfo( 'rss2_url' ); ?>"><?php _e('All Updates RSS', 'p2'); ?></a>
	</p>
	<?php
		echo $after_widget;
	}
	
	function recent_tags( $num_to_show ) {
		$cache = wp_cache_get( 'p2_recent_tags', 'widget' );
		if ( !is_array( $cache ) ) {
			$cache = array();
		}
		if ( isset( $cache[$num_to_show] ) && is_array( $cache[$num_to_show] ) ) {
			return $cache[$num_to_show];
		}
		
		$all_tags = (array) get_tags( array( 'get' => 'all' ) );

		$post_ids_and_tags = array();
		foreach( $all_tags as $tag ) {
			if( $tag->count < 1 )
				continue;
			$recent_post_id = max( get_objects_in_term( $tag->term_id, 'post_tag' ) );
			$post_ids_and_tags[] = array( 'post_id' => $recent_post_id, 'tag' => $tag );
		}

		usort( $post_ids_and_tags, create_function('$a, $b', 'return $b["post_id"] - $a["post_id"];') );

		$post_ids_and_tags = array_slice( $post_ids_and_tags, 0, $num_to_show );
		
		$recent_tags = array();
		foreach( $post_ids_and_tags as $v ) {
			$recent_tags[] = array(
				'tag' => $v['tag'],
				'link' => get_tag_link( $v['tag']->term_id ),
				'feed_link' => get_tag_feed_link( $v['tag']->term_id ),
			);
		}
		$cache[$num_to_show] = $recent_tags;
		wp_cache_add( 'p2_recent_tags', $cache, 'widget' );
		return $recent_tags;
	}
	
}

register_widget('P2_Recent_Tags');