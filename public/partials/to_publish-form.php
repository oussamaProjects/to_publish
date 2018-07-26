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
        'after'         => '</div></div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb'    => 'to_publish_maybe_set_default_from_posted_values',
        'id'            => 'submitted_type_request',
        'type'          => 'radio_inline',
        'options'       => array(
            'sell_my_property'          => __( 'Sell my property', 'to_publish' ),
            'entrust_my_research'       => __( 'Entrust my research', 'to_publish' ),
            'to_estimate_my_property'   => __( 'To estimate my property', 'to_publish' ),
        ),
        'before_row'    => '<div class="container"><div class="row">', 
        'classes'       => 'col-md-8 offset-md-2 custom_checkbox',
        'after_row'     => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb'    => 'to_publish_maybe_set_default_from_posted_values',
        'name'          => __( '2. Description of the property', 'to_publish' ),
        'type'          => 'title',
        'id'            => 'Description_title',
        'before'        => '<div class="container"><div class="row"><div class="col-md-12">',
        'classes'       => '',
        'after'         => '</div></div></div>'
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
        'attributes'     => array( 
            'required'  => 'required'
        ),
        'remove_default' => 'true', // Removes the default metabox provided by WP core. Pending release as of Aug-10-16
        'before_row'     => '<div class="container"><div class="row">',
        'classes'        => 'col-md-8 offset-md-2',
        'after_row'      => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Titre*', 'to_publish' ),
        'id'   => 'submitted_post_title',
        'type' => 'text',
        'attributes'  => array( 
            'required'    => 'required',
        ), 
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-md-8 offset-md-2',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Description', 'to_publish' ),
        'id'   => 'submitted_description',
        'type' => 'textarea',
        'attributes'  => array(  
            'row'       => 8
        ),
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'col-md-8 offset-md-2',
        'after_row'     => '</div></div>', 
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name'             => __( 'Number of rooms', 'to_publish' ),
        'id'               => 'submitted_rooms',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
            '1' => 1,
            '2' => 2,
            '3' => 3,
        ),
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-md-4 offset-md-2', 
    ) );


    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name'             => __( 'Number of bathrooms', 'to_publish' ),
        'id'               => 'submitted_bathrooms',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
            '1' => 1,
            '2' => 2,
            '3' => 3,
        ), 
        'classes'       => 'col-md-4',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Surface', 'to_publish' ),
        'id'   => 'submitted_surface',
        'type' => 'text', 
        'before_row'    => '<div class="container"><div class="row">',
        'classes'       => 'col-md-8 offset-md-2',
        'after_row'     => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name'           => __( 'City', 'to_publish' ),
        'id'             => 'submitted_localisation',
        'taxonomy'       => 'localisation', //Enter Taxonomy Slug
        'type'           => 'taxonomy_select',
        'text'           => array(
            'no_terms_text' => 'Sorry, no localisation could be found.' // Change default text. Default: "No terms"
        ),
        'remove_default' => 'true', // Removes the default metabox provided by WP core. Pending release as of Aug-10-16
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-md-8 offset-md-2',
        'after_row'         => '</div></div>'
    ) );


    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( '3. Your details', 'to_publish' ),
        'type' => 'title',
        'id'   => 'details_title',
        'before'        => '<div class="container"><div class="row"><div class="col-md-12">',
        'classes'       => '',
        'after'         => '</div></div></div>'
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
        'classes'       => 'col-md-8 offset-md-2',
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
        'classes'           => 'col-md-8 offset-md-2',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Phone*', 'to_publish' ),
        'id'   => 'submitted_author_phone',
        'type' => 'text',
        'attributes'  => array( 
            'required'    => 'required',
        ),
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-md-8 offset-md-2',
        'after_row'         => '</div></div>'
    ) );

    $cmb->add_field( array(
		'default_cb' => 'to_publish_maybe_set_default_from_posted_values',
        'name' => __( 'Phone 2', 'to_publish' ),
        'id'   => 'submitted_author_phone_2',
        'type' => 'text',
        'before_row'        => '<div class="container"><div class="row">',
        'classes'       => 'col-md-8 offset-md-2',
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
        'classes'       => 'col-md-8 offset-md-2',
        'after_row'     => '</div></div>', 
    ) );

}
add_action( 'cmb2_init', 'to_publish_frontend_form_register' );
