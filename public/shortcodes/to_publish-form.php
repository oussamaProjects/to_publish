<?php

/**
 * * Handle the to_publish-frontend-form shortcode
 *
 * @param  array  $atts Array of shortcode attributes
 * @return string       Form html
 */
function to_publish_do_frontend_form_submission_shortcode( $atts = array() ) {
	// Get CMB2 metabox object
	$cmb = to_publish_frontend_cmb2_get();
	// Get $cmb object_types
	$post_types = $cmb->prop( 'object_types' );
	// Current user
	$user_id = get_current_user_id();
	// Parse attributes
	$atts = shortcode_atts( array(
		'post_author' => $user_id ? $user_id : 1, // Current user, or admin
		'post_status' => 'pending',
		'post_type'   => reset( $post_types ), // Only use first object_type in array
	), $atts, 'cmb_frontend_form' );
	/*
	 * Let's add these attributes as hidden fields to our cmb form
	 * so that they will be passed through to our form submission
	 */
	foreach ( $atts as $key => $value ) {
		$cmb->add_hidden_field( array(
			'field_args'  => array(
				'id'    => "atts[$key]",
				'type'  => 'hidden',
				'default' => $value,
			),
		) );
	}
	// Initiate our output variable
	$output = '';
	// Get any submission errors
	if ( ( $error = $cmb->prop( 'submission_error' ) ) && is_wp_error( $error ) ) {
		// If there was an error with the submission, add it to our ouput.
		$output .= '<div class="container"><div class="row"><div class="col-md-12"> <div class="alert alert-danger">' . sprintf( __( 'There was an error in the submission: %s', 'to_publish' ), '<strong>'. $error->get_error_message() .'</strong>' ) . '</div></div></div></div>';
	}
	// If the post was submitted successfully, notify the user.
	if ( isset( $_GET['post_submitted'] ) && ( $post = get_post( absint( $_GET['post_submitted'] ) ) ) ) {
		// Get submitter's name
		$name = get_post_meta( $post->ID, 'submitted_author_name', 1 );
		$name = $name ? ' '. $name : '';
		// Add notice of submission to our output
		$output .= '<div class="container"><div class="row"><div class="col-md-12"> <div class="alert alert-success">' . sprintf( __( 'Thank you%s, your new post has been submitted and is pending review by a site administrator.', 'to_publish' ), esc_html( $name ) ) . '</div></div></div></div>';
	}
	// Get our form
	$output .= cmb2_get_metabox_form( $cmb, 'fake-oject-id', array( 'save_button' => __( 'Submit Post', 'to_publish' ) ) );
	return $output;
}
add_shortcode( 'to_publish-frontend-form', 'to_publish_do_frontend_form_submission_shortcode' );