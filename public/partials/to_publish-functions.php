<?php

/**
 * Disable CMB2 styles on front end forms.
 *
 * @return bool $enabled Whether to enable (enqueue) styles.
 */
function to_publish_disable_cmb2_front_end_styles( $enabled ) {
	if ( ! is_admin() ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'cmb2_enqueue_css', 'to_publish_disable_cmb2_front_end_styles' );

/**
 * Sets the front-end-post-form field values if form has already been submitted.
 *
 * @return string
 */
function to_publish_maybe_set_default_from_posted_values( $args, $field ) {
	if ( ! empty( $_POST[ $field->id() ] ) ) {
		return $_POST[ $field->id() ];
	}
	return '';
}


/**
 * Gets the front-end-post-form cmb instance
 *
 * @return CMB2 object
 */
function to_publish_frontend_cmb2_get() {
	// Use ID of metabox in to_publish_frontend_form_register
	$metabox_id = 'front-end-post-form';
	// Post/object ID is not applicable since we're using this form for submission
	$object_id  = 'fake-oject-id';
	// Get CMB2 metabox object
	return cmb2_get_metabox( $metabox_id, $object_id );
}




/**
 * Handles uploading a file to a WordPress post
 *
 * @param  int   $post_id              Post ID to upload the photo to
 * @param  array $attachment_post_data Attachement post-data array
 */
function to_publish_frontend_form_photo_upload( $post_id, $attachment_post_data = array() ) {
	// Make sure the right files were submitted
	if (
		empty( $_FILES )
		|| ! isset( $_FILES['submitted_post_thumbnail'] )
		|| isset( $_FILES['submitted_post_thumbnail']['error'] ) && 0 !== $_FILES['submitted_post_thumbnail']['error']
	) {
		return;
	}
	// Filter out empty array values
	$files = array_filter( $_FILES['submitted_post_thumbnail'] );
	// Make sure files were submitted at all
	if ( empty( $files ) ) {
		return;
	}
	// Make sure to include the WordPress media uploader API if it's not (front-end)
	if ( ! function_exists( 'media_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
	}
	// Upload the file and send back the attachment post ID
	return media_handle_upload( 'submitted_post_thumbnail', $post_id, $attachment_post_data );
}
