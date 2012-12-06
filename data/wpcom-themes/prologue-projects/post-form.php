<?php
$user			= get_userdata( $current_user->ID );
$first_name		= attribute_escape( $user->first_name );
?>
<form id="pp-update-form" name="pp-update-form" method="post" action="">
	<input type="hidden" name="action" value="post" />
	<?php wp_nonce_field( 'pp-update' ); ?>

	<table id="pp-update-fields">
		<tr>
			<th></th>
			<td colspan="2"><label for="posttext" class="label">
<?php
switch ( $mode ) {
	case 'updates':
		printf( __( 'Hi, %s. Whatcha up to?', 'prologue-projects' ), $first_name );
		break;
	case 'tasks':
		printf( __( 'Hi, %s. Whatcha gonna do?', 'prologue-projects' ), $first_name );
		break;
	case 'questions':
		printf( __( 'Hi, %s. Whatcha wanna know?', 'prologue-projects' ), $first_name );
		break;
}
?>
			</label></td>
		</tr>
		<tr>
			<th><?php echo get_avatar( $user->ID, 48, ''); ?></th>
			<td><textarea name="posttext" id="posttext" rows="3" cols="60"></textarea></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<label for="tags" class="label"><?php _e( 'Tag it', 'prologue-projects' ); ?></label>
				<input type="text" name="tags" id="tags" autocomplete="off" />
			</td>
		</tr>
<?php
switch ( $mode ) {
	case 'tasks':
?>
		<tr>
			<th></th>
			<td>
				<label for="task_level" class="label"><?php _e( 'Rate it', 'prologue-projects' ); ?></label>
				<?php wp_dropdown_categories( array( 'child_of' => $task_category_id, 'hide_empty' => 0, 'name' => 'task_level', 'orderby' => 'name', 'selected' => $default_task_level, 'hierarchical' => true ) ); ?>
			</td>
		</tr>
<?php
		break;
}

switch ( $mode ) {
	case 'updates':
	case 'tasks':
?>
		<tr>
			<th></th>
			<td colspan="2">
				<div id="for-pp-update-categories" class="label"><a href="javascript:void(0);" onclick="pp_toggle('pp-update-categories');"><?php _e( 'Add projects', 'prologue-projects' ); ?></a></div>
				<div id="pp-update-categories" style="display: none;">
					<?php pp_project_checklist(); ?>
				</div>
			</td>
		</tr>
		<tr>
			<th></th>
			<td><input id="submit" type="submit" value="<?php _e( 'Post it', 'prologue-projects' ); ?>" /></td>
		</tr>
<?php
		break;
	case 'questions':
?>
		<tr>
			<th></th>
			<td><input type="hidden" name="post_category" value="<?php echo absint( get_query_var( 'cat' ) ); ?>" />
				<input id="submit" type="submit" value="<?php _e( 'Ask now', 'prologue-projects' ); ?>" /></td>
		</tr>
<?php
		break;
}
?>
	</table>
</form>

