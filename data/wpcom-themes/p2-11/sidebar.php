<?php if ( !p2_get_hide_sidebar() ) : ?>
	<div id="sidebar">
	
		<ul>
			<?php 
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) {
				the_widget( 'P2_Recent_Comments', array(), array( 'before_widget' => ' <li> ', 'after_widget' => '</li>', 'before_title' =>'<h2>', 'after_title' => '</h2>' ) );
				the_widget( 'P2_Recent_Tags', array(), array( 'before_widget' => ' <li> ', 'after_widget' => '</li>', 'before_title' =>'<h2>', 'after_title' => '</h2>' ) );
			}
			?>
		</ul>
	
		<div class="clear"></div>
	
	</div> <!-- // sidebar -->
<?php endif; ?>