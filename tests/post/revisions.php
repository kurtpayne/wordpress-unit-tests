<?php

/**
 * @group post
 * @group revision
 */
class Tests_Post_Revisions extends WP_UnitTestCase {
	/**
	 * Note: Test needs reviewing when #16215 is fixed because I'm not sure the test current tests the "correct" behavior
	 * @ticket 20982
	 * @ticket 16215
	 */
	function test_revision_restore_updates_edit_last_post_meta() {
		 $admin_user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		 $editor_user_id = $this->factory->user->create( array( 'role' => 'editor' ) );
		 $author_user_id = $this->factory->user->create( array( 'role' => 'author' ) );

		 //create a post as Author
		 wp_set_current_user( $author_user_id );
		 $post_id = $this->factory->post->create( array( 'post_type' => 'post', 'post_content' => 'I cant spel werds.' ) );

		 //update post as Editor
		 wp_set_current_user( $editor_user_id );
		 wp_update_post( array( 'post_content' => 'The Editor was in fixing your typos.', 'ID' => $post_id ) );

		 //restore back as Admin
		 wp_set_current_user( $admin_user_id );
		 $revisions = wp_get_post_revisions( $post_id );
		 $this->assertEquals( count( $revisions ), 1 );

		 $lastrevision = end( $revisions );
		 $this->assertEquals( $lastrevision->post_content, 'I cant spel werds.' );
		 // #16215
		 $this->assertEquals( $lastrevision->post_author, $author_user_id );

		 wp_restore_post_revision( $lastrevision->ID );

		 //is post_meta correctly set to revision author
		 $this->assertEquals( get_post_meta( $post_id, '_edit_last', true ), $author_user_id ); //after restoring user
	}
}