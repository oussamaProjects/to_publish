<?php
/**
* Register the form and fields for our front-end submission form
*/

function to_publish_admin_annonces_form_register() {

    $cmb = new_cmb2_box( array(
        'id'           => 'admin-annonce-form',
		'title'        => esc_html__( 'Description of the property', 'to_publish' ),
        'object_types' => array( 'annonce' )
    ) ); 

    $cmb->add_field( array(
        'id'            => 'submitted_type_request',
        'type'          => 'radio_inline',
        'options'       => array(
            'sell_my_property'          => __( 'Sell my property', 'to_publish' ),
            'entrust_my_research'       => __( 'Entrust my research', 'to_publish' ),
            'to_estimate_my_property'   => __( 'To estimate my property', 'to_publish' ),
        )
    ) );
    
    $cmb->add_field( array(
        'name'             => __( 'Number of rooms', 'to_publish' ),
        'id'               => 'submitted_rooms',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
            '1' => 1,
            '2' => 2,
            '3' => 3,
        ) 
    ) );


    $cmb->add_field( array(
        'name'             => __( 'Number of bathrooms', 'to_publish' ),
        'id'               => 'submitted_bathrooms',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
            '1' => 1,
            '2' => 2,
            '3' => 3,
        ),
    ) );
    $cmb->add_field( array(
        'name' => __( 'Your Name*', 'to_publish' ),
        'id'   => 'submitted_author_name',
        'type' => 'text',
        'attributes'  => array( 
            'required'    => 'required',
        ),
    ) );

    $cmb->add_field( array(
        'name' => __( 'Your Email*', 'to_publish' ),
        'id'   => 'submitted_author_email',
        'type' => 'text_email',
        'attributes'  => array( 
            'required'    => 'required',
        ),
    ) );

    $cmb->add_field( array(
        'name' => __( 'Phone*', 'to_publish' ),
        'id'   => 'submitted_author_phone',
        'type' => 'text',
        'attributes'  => array( 
            'required'    => 'required',
        )
    ) );

    $cmb->add_field( array(
        'name' => __( 'Phone 2', 'to_publish' ),
        'id'   => 'submitted_author_phone_2',
        'type' => 'text'
    ) );
    
    $cmb->add_field( array(
        'name' => __( 'Message*', 'to_publish' ),
        'id'   => 'submitted_message',
        'type' => 'textarea',
        'attributes'  => array( 
            'required'  => 'required',
            'row'       => 12
        ),
    ) );

}
add_action( 'cmb2_admin_init', 'to_publish_admin_annonces_form_register' );
