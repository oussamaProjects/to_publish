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
	// And that the title is not the default title
	// if ( $cmb->get_field( 'submitted_post_title' )->default() == $_POST['submitted_post_title'] ) {
	// 	return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'Please enter a new title.' ) ) );
	// }
	/**
	 * Fetch sanitized values
	 */
	$sanitized_values = $cmb->get_sanitized_values( $_POST );
	
	$_type_request 	= $sanitized_values['submitted_type_request'];
	$_types 				= $sanitized_values['submitted_types'];
	$_description 		= $sanitized_values['submitted_description'];
	$_surface 			= $sanitized_values['submitted_surface'];
	$_bedrooms 			= $sanitized_values['submitted_bedrooms'];
	$_bathrooms 		= $sanitized_values['submitted_bathrooms'];
	$_city 				= $sanitized_values['submitted_city'];
	$_district 			= $sanitized_values['submitted_district'];
	$_author_name 		= $sanitized_values['submitted_author_name'];
	$_author_email 	= $sanitized_values['submitted_author_email'];
	$_author_phone 	= $sanitized_values['submitted_author_phone'];
	$_author_phone_2 	= $sanitized_values['submitted_author_phone_2'];
	$_author_country 	= $sanitized_values['submitted_author_country'];
	$_message 			= $sanitized_values['submitted_message'];

	$type 				= get_term_by( 'slug', $_types, 'types' );
	$_type_name 		= $type->name ; 

	$city 				= get_term_by( 'id', $_city, 'localisation' );
	$_city_name 		= $city->name ; 

	$_district_name 	= $_district ; 


	$parent_term = term_exists( $_city_name, 'localisation' ); // array is returned if taxonomy is given

	wp_insert_term(
		$_district_name, // the term 
		'localisation', // the taxonomy
		array( 
			'parent'=> $parent_term['term_id']  // get numeric term id
		)
	);

	$new_submission_id = 123;
	if ($_type_request == "Sell my property" || $_type_request == "Vendre mon bien" ) {
		// Set our post data arguments
		$post_data['post_title']   = $_type_request;
		unset( $sanitized_values['submitted_post_title'] );
		
		if ($sanitized_values['submitted_description'] == "") {
			$post_data['post_content'] = "?";
		}else {
			$post_data['post_content'] = $sanitized_values['submitted_description'];
		}

		unset( $sanitized_values['submitted_description'] );

		// Create the new post
		// $new_submission_id = 
		wp_insert_post( $post_data, true );

		// If we hit a snag, update the user
		if ( is_wp_error( $new_submission_id ) ) {
			return $cmb->prop( 'submission_error', $new_submission_id );
		}

		$cmb->save_fields( $new_submission_id, 'post', $sanitized_values );
		
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
	}


	// Send messaeg to admin
	$adminID 		= 1;
	$admin         = get_user_by('id', $adminID);
	
	$email_to 		= $admin->user_email;
	$email_reply	= "oussama@comenscene.com";
	$email_from 	= $_author_email;
	$email_subject = $_type_request ;  

	$error_message = "";
	$email_exp 		= '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	if(!preg_match($email_exp,$email_from)) {
		$error_message .= __("The Email Address you entered does not appear to be valid.", "to_publish") ."<br />";
	}

	$string_exp = "/^[A-Za-z .'-]+$/";
	if(!preg_match($string_exp, $_author_name)) {
		$error_message .= __("The Username you entered does not appear to be valid.", "to_publish") . "<br />";
	}

	if(strlen($error_message) > 0) {
		died($error_message);
	}
	
	$email_message = __("Form details below.", "to_publish") . "<br><br>";

	if( isset($_type_name) && ! empty($_type_name) )
		$email_message .= __("Type : ", "to_publish")				. clean_string($_type_name) 		. "<br>";

	if( isset($_description) && ! empty($_description) )
		$email_message .= __("Description : ", "to_publish")		. clean_string($_description) 	. "<br>";

	if( isset($_surface) && ! empty($_surface) )
		$email_message .= __("Surface : ", "to_publish")			. clean_string($_surface) 			. "<br>";

	if( isset($_bedrooms) && ! empty($_bedrooms) )
		$email_message .= __("Bedrooms : ", "to_publish")			. clean_string($_bedrooms) 		. "<br>";

	if( isset($_bathrooms) && ! empty($_bathrooms) )
		$email_message .= __("Bathrooms : ", "to_publish")			. clean_string($_bathrooms) 		. "<br>";

	if( isset($_city_name) && ! empty($_city_name) )
		$email_message .= __("City : ", "to_publish")				. clean_string($_city_name) 		. "<br>";

	if( isset($_district_name) && ! empty($_district_name) )
		$email_message .= __("District : ", "to_publish")			. clean_string($_district_name) 	. "<br>";

	if( isset($_author_name) && ! empty($_author_name) )
		$email_message .= __("Name : ", "to_publish") 				. clean_string($_author_name) 	. "<br>";

	if( isset($_author_phone) && ! empty($_author_phone) )
		$email_message .= __("Phone : ", "to_publish")				. clean_string($_author_phone) 	. "<br>";

	if( isset($_author_country) && ! empty($_author_country) )
		$email_message .= __("Country : ", "to_publish")			. clean_string($_author_country) . "<br>";

	if( isset($_message) && ! empty($_message) )
		$email_message .= __("Message : ", "to_publish")			. clean_string($_message) 			. "<br>";

		
		// create email headers
		$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_reply."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	
	// @mail($email_to, $email_subject, $email_message, $headers); 
	
	wp_mail('matt@tanja-marina.com', $email_subject, $email_message, $headers);
	
	/*
	* Redirect back to the form page with a query variable with the new post ID.
	* This will help double-submissions with browser refreshes
	*/ 
	wp_redirect( esc_url_raw( add_query_arg( 'post_submitted', $new_submission_id ) ) );
	exit;
}
add_action( 'cmb2_after_init', 'to_publish_handle_frontend_new_post_form_submission' );



function died($error) {
	// your error code can go here
	_e("We are very sorry, but there were error(s) found with the form you submitted. ", "to_publish") . "<br /><br />";
	_e("These errors appear below.", "to_publish") . "<br /><br />";
	echo $error . "<br /><br />";
	_e("Please go back and fix these errors.", "to_publish") . "<br /><br />";
	die();
}

function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"",$string);
}