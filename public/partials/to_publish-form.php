<?php
/**
* Register the form and fields for our front-end submission form
*/

function to_publish_frontend_form_register() {

    $cmb = new_cmb2_box( array(
        'id'           => 'front-end-post-form',
        'object_types' => array( 'annonce' ),
        'hookup'       => false,
        'save_fields'  => false,
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( '1. Your request', 'to_publish' ),
        'type' => 'title',
        'id'   => 'request_title',
        'before'        => '<div class="container"><div class="row"><div class="col-md-12">',
        'classes'       => '',
        'after'         => '</div></div></div>',
        'after_row'     => '<div class="step first_step hide_step">'
    ) );

    $cmb->add_field( array(
		'default_cb'    => 'to_publish_maybe_set_default_from_posted_values',
        'id'            => 'submitted_type_request',
        'type'          => 'radio_inline',
        'options'       => array(
            __( 'Sell my property', 'to_publish' )         => __( 'Sell my property', 'to_publish' ),
            __( 'Entrust my research', 'to_publish' )      => __( 'Entrust my research', 'to_publish' ),
            __( 'To estimate my property', 'to_publish' )  => __( 'To estimate my property', 'to_publish' ),
        ),
        'before_row'    => '<div class="container"><div class="row">', 
        'classes'       => 'offset-md-1 col-md-10 custom_checkbox',
        'after_row'     => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'id'   => 'next_second_step',
        'type' => 'next_step',  
        'before_row'    => '<div class="container"><div class="row">', 
        'classes'       => 'offset-md-1 col-md-10',
        'after_row'     => '</div></div></div>', 
    ) );


    $cmb->add_field( array(
		'default_cb'    => 'to_publish_maybe_set_default_from_posted_values',
        'name'          => __( '2. Description of the property', 'to_publish' ),
        'type'          => 'title',
        'id'            => 'Description_title',
        'before'        => '<div class="container"><div class="row"><div class="col-md-12">',
        'classes'       => '',
        'after'         => '</div></div></div>',
        'after_row'      => '<div class="step second_step">'
    ) );

    $cmb->add_field( array(
		'default_cb'     => 'to_publish_maybe_set_default_from_posted_values',
        'name'           => __( 'Type*', 'to_publish' ),
        'id'             => 'submitted_types',
        'taxonomy'       => 'types', //Enter Taxonomy Slug
        'type'           => 'taxonomy_select',
        'text'           => array(
            'no_terms_text' => 'Sorry, no types could be found.' // Change default text. Default: "No terms"
        ), 
        'remove_default' => 'true', // Removes the default metabox provided by WP core. Pending release as of Aug-10-16
        'show_option_none'  => false,
        'before_row'     => '<div class="container"><div class="row">',
        'classes'        => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'      => '</div></div>'
    ) );

    
    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Description', 'to_publish' ),
        'id'   => 'submitted_description',
        'type' => 'textarea',
        'attributes'  => array( 
            'required'  => 'required', 
            'row'       => 8
        ),
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'     => '</div></div>', 
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Surface', 'to_publish' ),
        'id'   => 'submitted_surface',
        'type' => 'text', 
        'attributes' => array(
            'type' => 'number',
			'min' => '0',
            'pattern' => '\d*',
        ), 
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'     => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name'             => __( 'Number of bedrooms', 'to_publish' ),
        'id'               => 'submitted_bedrooms',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => 'custom',
        'options_cb'       => 'bedrooms_options', 
        'before_row'       => '<div class="container"><div class="row">',
        'classes'          => 'col-lg-4 offset-lg-2 col-md-6', 
    ) ); 

    // Callback function
    function bedrooms_options( $field ) {

        $bedrooms = array(); 
        for ( $i = 0; $i <= 10; $i++ ) {
            $bedrooms[$i] = sprintf( _n( '%d', '%d', $i, 'to_publish' ), $i );
        } 
        return $bedrooms;

    }

    $cmb->add_field( array(
		'default_cb'        => 'to_publish_maybe_set_default_from_posted_values',
        'name'              => __( 'Number of bathrooms', 'to_publish' ),
        'id'                => 'submitted_bathrooms',
        'type'              => 'select',
        'show_option_none'  => false,
        'options_cb'        => 'bathrooms_options', 
        'classes'           => 'col-lg-4 col-md-6custom_checkbox',
        'after_row'         => '</div></div>'
    ) ); 
    
    // Callback function
    function bathrooms_options( $field ) {

        $bathrooms = array(); 
        for ( $i = 0; $i <= 10; $i++ ) {
            $bathrooms[$i] = sprintf( _n( '%d', '%d', $i, 'to_publish' ), $i );
        } 
        return $bathrooms;
    }

    $cmb->add_field( array(
		'default_cb'    => 'to_publish_maybe_set_default_from_posted_values',
        'name'          => __( 'City *', 'to_publish' ),
        'id'            => 'submitted_city', 
        'type'          => 'select', 
        'options_cb'    => 'show_city_options',
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'     => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name'           => __( 'District', 'to_publish' ),
        'id'             => 'submitted_district',
        'type'          => 'text',  
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'         => '</div></div>'
    ) );

    // $cmb->add_field( array(
	// 	'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
    //     'name'           => __( 'District', 'to_publish' ),
    //     'id'             => 'submitted_district',
    //     'type'          => 'select', 
    //     'options_cb'    => 'show_district_options',
    //     'before_row'        => '<div class="container"><div class="row">',
    //     'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
    //     'after_row'         => '</div></div>'
    // ) );
    
    function show_city_options( $field ) { 

        $args_ads_city = array( 
            'parent'            => 0,
            'depth'             => 1,
            'taxonomy'          => 'localisation',
            'hide_empty' => false,
        ); 

        $ads_cities = get_terms( $args_ads_city );
        // $cities[0] = __('Choose', 'to_publish');
        foreach ($ads_cities as $ads_city) {
            $cities[$ads_city->term_id] = $ads_city->name;
        } 
        return $cities;
    }
    
    function show_district_options( $field ) { 

        $args_ads_district = array( 
            'parent'            => 1,
            'depth'             => 2,
            'taxonomy'          => 'localisation', 
            'hide_empty' => false,
        ); 
 
        $ads_districts = get_terms( $args_ads_district );
        foreach ($ads_districts as $ads_district) {
            $districts[] = $ads_district->name;
        } 
        return $districts;
    }

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'id'   => 'prev_first_step',
        'type' => 'prev_step', 
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'offset-md-2 col-md-4', 
    ) );
    
    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'id'   => 'next_third_step',
        'type' => 'next_step',  
        'classes'       => 'col-md-4',
        'after_row'     => '</div></div></div>', 
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( '3. Your details', 'to_publish' ),
        'type' => 'title',
        'id'   => 'details_title',
        'before'        => '<div class="container"><div class="row"><div class="col-md-12">',
        'classes'       => '',
        'after'         => '</div></div></div>',
        'after_row'         => '<div class="step third_step hide_step">'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Your Name*', 'to_publish' ),
        'id'   => 'submitted_author_name',
        'type' => 'text',
        'attributes'  => array( 
            'required'    => 'required',
        ), 
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Your Email*', 'to_publish' ),
        'id'   => 'submitted_author_email',
        'type' => 'text_email',
        'attributes'  => array( 
            'required'    => 'required',
        ),
        'before_row'        => '<div class="container"><div class="row">', 
        'classes'           => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Your phone 1*', 'to_publish' ),
        'id'   => 'submitted_author_phone',
        'type' => 'text',
        'attributes'  => array( 
            'required'    => 'required',
        ),
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Your phone 2', 'to_publish' ),
        'id'   => 'submitted_author_phone_2',
        'type' => 'text',
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Country*', 'to_publish' ),
        'id'   => 'submitted_author_country',
        'type' => 'text',
        'attributes'  => array( 
            'required'    => 'required',
        ),
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Message*', 'to_publish' ),
        'id'   => 'submitted_message',
        'type' => 'textarea',
        'attributes'  => array( 
            'required'  => 'required',
            'row'       => 12
        ),
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after'         => '<div class="required_field">' . __('* Required fields', 'to_publish') . '</div>', 
        'after_row'     =>  '</div></div>', 
    ) );


    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'id'   => 'submitted',
        'type' => 'submit', 
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'col-lg-8 offset-lg-2 col-md-12',
        'after_row'     => '</div></div>', 
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'id'   => 'prev_second_step',
        'type' => 'prev_step', 
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'offset-md-2 col-md-8', 
        'after_row'     => '</div></div></div>', 
    ) ); 

}
add_action( 'cmb2_init', 'to_publish_frontend_form_register' );



function cmb2_render_callback_for_submit( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
    echo $field_type_object->input( array( 
        'type'  => 'submit', 
        'name'  => 'submit-cmb', 
        'value' => __( 'Submit', 'to_publish'), 
        'class' => 'btn submit-btn'  
    ) );
}
add_action( 'cmb2_render_submit', 'cmb2_render_callback_for_submit', 10, 5 );


function cmb2_render_callback_for_next_step( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
    echo $field_type_object->input( array( 
        'type'  => 'button', 
        'name'  => 'next_step', 
        'class' => 'btn-step btn white-btn next',
        'value' => __( 'Next > ', 'to_publish'),   
    ) );
}
add_action( 'cmb2_render_next_step', 'cmb2_render_callback_for_next_step', 10, 5 );


function cmb2_render_callback_for_prev_step( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
    echo $field_type_object->input( array( 
        'type'  => 'button', 
        'name'  => 'prev_step', 
        'class' => 'btn-step btn white-btn prev',
        'value' => __( ' < Previous', 'to_publish'),   
    ) );
}
add_action( 'cmb2_render_prev_step', 'cmb2_render_callback_for_prev_step', 10, 5 );


add_action( 'wp_ajax_get_neighborhoods', 'to_publish_get_neighborhoods' );
add_action( 'wp_ajax_nopriv_get_neighborhoods', 'to_publish_get_neighborhoods' );
function to_publish_get_neighborhoods() {
	$taxonomie = 'localisation';
    $get_city = $_GET['city'];
    
	if ( $get_city ) {
        
        $city = term_exists( (int)$get_city, $taxonomie );

        if ( $city ) {

            $args = array(  
                'taxonomy' => $taxonomie, 
                'child_of' => $city['term_taxonomy_id'],
                'hide_empty' => false,  
            ); 
            
            $districts = get_terms( $args ); 

            $output = '';
            foreach( $districts as $district_value => $district_name ){
                $output .= sprintf( "<option value='%s'>%s</option>", $district_value, $district_name->name ); 
            }
            wp_send_json_success( array( $output ) );
        }
	} else {
		wp_send_json_error();
	}
}