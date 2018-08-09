<?php 

/**
 * Handles form submission on save
 *
 * @param  CMB2  $cmb       The CMB2 object
 * @param  array $post_data Array of post-data for new post
 * @return mixed            New post ID if successful
 */


function to_publish_handle_frontend_new_post_form_submission() {
	// If no form submission, bail
	if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
		return false;
	}
	
	// Get CMB2 metabox object
	$cmb = to_publish_frontend_cmb2_get();
	$post_data = array();
	// Get our shortcode attributes and set them as our initial post_data args
	if ( isset( $_POST['atts'] ) ) {
		foreach ( (array) $_POST['atts'] as $key => $value ) {
			$post_data[ $key ] = sanitize_text_field( $value );
		}
		unset( $_POST['atts'] );
	}
	// Check security nonce
	if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
	}
	// Check title submitted
	if ( empty( $_POST['submitted_post_title'] ) ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'New post requires a title.' ) ) );
	}
	// And that the title is not the default title
	// if ( $cmb->get_field( 'submitted_post_title' )->default() == $_POST['submitted_post_title'] ) {
	// 	return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'Please enter a new title.' ) ) );
	// }
	/**
	 * Fetch sanitized values
	 */
	$sanitized_values = $cmb->get_sanitized_values( $_POST );

	// Set our post data arguments
	$post_data['post_title']   = $sanitized_values['submitted_post_title'];
	unset( $sanitized_values['submitted_post_title'] );
	$post_data['post_content'] = $sanitized_values['submitted_description'];
	unset( $sanitized_values['submitted_description'] );

	// Create the new post
	// $new_submission_id = wp_insert_post( $post_data, true );

	// If we hit a snag, update the user
	if ( is_wp_error( $new_submission_id ) ) {
		return $cmb->prop( 'submission_error', $new_submission_id );
	}
	// $cmb->save_fields( $new_submission_id, 'post', $sanitized_values );
	
	/**
	 * Other than post_type and post_status, we want
	 * our uploaded attachment post to have the same post-data
	 */
	unset( $post_data['post_type'] );
	unset( $post_data['post_status'] );
	// Try to upload the featured image
	$img_id = to_publish_frontend_form_photo_upload( $new_submission_id, $post_data );
	// If our photo upload was successful, set the featured image
	if ( $img_id && ! is_wp_error( $img_id ) ) {
		set_post_thumbnail( $new_submission_id, $img_id );
	}
	/*
	 * Redirect back to the form page with a query variable with the new post ID.
	 * This will help double-submissions with browser refreshes
	 */

	$_types 				= $sanitized_values['submitted_types'];
	$_description 		= $sanitized_values['submitted_description'];
	$_surface 			= $sanitized_values['submitted_surface'];
	$_bedrooms 			= $sanitized_values['submitted_bedrooms'];
	$_bathrooms 		= $sanitized_values['submitted_bathrooms'];
	$_localisation 	= $sanitized_values['submitted_localisation'];
	$_author_name 		= $sanitized_values['submitted_author_name'];
	$_author_email 	= $sanitized_values['submitted_author_email'];
	$_author_phone 	= $sanitized_values['submitted_author_phone'];
	$_author_phone_2 	= $sanitized_values['submitted_author_phone_2'];
	$_message 			= $sanitized_values['submitted_message'];

	// EDIT THE 2 LINES BELOW AS REQUIRED
	$email_to 		= "oussama@comenscene.com";
	$email_from 	= $_author_email;
	$email_reply	= $_author_email;
	$email_subject = $_types ;  

	$error_message = "";
	$email_exp 		= '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	if(!preg_match($email_exp,$email_from)) {
		$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
	}

	$string_exp = "/^[A-Za-z .'-]+$/";
	if(!preg_match($string_exp, $_author_name)) {
		$error_message .= 'The Username you entered does not appear to be valid.<br />';
	}

	if(strlen($error_message) > 0) {
		died($error_message);
	}
	
	$email_message = __("Form details below.", "to_publish") . "\n\n";

	$email_message .= __("Description : ", "to_publish")		. clean_string($_description) 	. "\n";
	$email_message .= __("Surface : ", "to_publish")			. clean_string($_surface) 			. "\n";
	$email_message .= __("Bedrooms : ", "to_publish")			. clean_string($_bedrooms) 		. "\n";
	$email_message .= __("Bathrooms : ", "to_publish")			. clean_string($_bathrooms) 		. "\n";
	$email_message .= __("Localisation : ", "to_publish")		. clean_string($_localisation) 	. "\n";
	$email_message .= __("Name : ", "to_publish") 				. clean_string($_author_name) 	. "\n";
	$email_message .= __("Phone : ", "to_publish")				. clean_string($_author_phone) 	. "\n";
	$email_message .= __("Phone 2 : ", "to_publish")			. clean_string($_author_phone_2) . "\n";
	$email_message .= __("Message : ", "to_publish")			. clean_string($_message) 			. "\n";

	// create email headers
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_reply."\r\n" .
	'X-Mailer: PHP/' . phpversion();

	// @mail($email_to, $email_subject, $email_message, $headers); 

	wp_mail($email_to, $email_subject, $email_message);

	wp_redirect( esc_url_raw( add_query_arg( 'post_submitted', $new_submission_id ) ) );
	exit;
}
add_action( 'cmb2_after_init', 'to_publish_handle_frontend_new_post_form_submission' );



function died($error) {
	// your error code can go here
 echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 echo "These errors appear below.<br /><br />";
 echo $error."<br /><br />";
 echo "Please go back and fix these errors.<br /><br />";
 die();
}

function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"",$string);
}