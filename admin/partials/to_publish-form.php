<?php
/**
* Register the form and fields for our front-end submission form
*/

function to_publish_admin_annonces_form_register() {

    $prefix = "to_publish_" ;
    $cmb = new_cmb2_box( array(
        'id'           => 'admin-annonce-form',
		'title'        => esc_html__( 'Description of the property', 'to_publish' ),
        'object_types' => array( 'annonce' )
    ) ); 

    $cmb->add_field( array(
        'name' => __( 'Sold', 'to_publish' ), 
        'id'   => 'submitted_sold',
        'type' => 'checkbox',
    ) );

     // $group_field_id is the field id string, so in this case: $prefix . 'demo'
     $group_field_id = $cmb->add_field( array(
        'id'          => 'submitted_slides',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => __( 'Entry {#}', 'to_publish' ), // {#} gets replaced by row number
            'add_button'    => __( 'Add Another Entry', 'to_publish' ),
            'remove_button' => __( 'Remove Entry', 'to_publish' ),
            'sortable'      => true, // beta
            // 'closed'     => true, // true to have the groups closed by default
        ),
    ) );

     /**
     * Group fields works the same, except ids only need
     * to be unique to the group. Prefix is not needed.
     *
     * The parent field's id needs to be passed as the first argument.
     */
 


    $cmb->add_field( array(
        'name'    =>  __( 'Plus', 'to_publish' ), 
        'id'      => 'plus',
        'type'    => 'wysiwyg', 
    ) );


    // $cmb->add_field( array(
    //     'id'            => 'submitted_type_request',
    //     'type'          => 'radio_inline',
    //     'options'       => array(
    //         'sell_my_property'          => __( 'Sell my property', 'to_publish' ),
    //         'entrust_my_research'       => __( 'Entrust my research', 'to_publish' ),
    //         'to_estimate_my_property'   => __( 'To estimate my property', 'to_publish' ),
    //     )
    // ) );
    
    $cmb->add_field( array(
        'name' => __( 'Surface', 'to_publish' ),
        'id'   => 'submitted_surface',
        'type' => 'text',
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        ), 
        'attributes'  => array( 
            'required'    => 'required',
        ),
    ) );
    
    $cmb->add_field( array(
        'name'             => __( 'Number of bedrooms', 'to_publish' ),
        'id'               => 'submitted_bedrooms',
        'type'             => 'select',
        'show_option_none' => true,
        'options_cb'        => 'admin_bedrooms_options', 
    ) );

    // Callback function
    function admin_bedrooms_options( $field ) {

        $bedrooms = array(); 
        for ( $i = 1; $i <= 10; $i++ ) {
            $bedrooms[$i] = sprintf( _n( '%d bedroom', '%d bedrooms', $i, 'to_publish' ), $i );
        } 
        return $bedrooms;

    }

    $cmb->add_field( array(
        'name'             => __( 'Number of bathrooms', 'to_publish' ),
        'id'               => 'submitted_bathrooms',
        'type'             => 'select',
        'show_option_none' => true,
        'options_cb'       => 'admin_bathrooms_options', 
    ) );

    // Callback function
    function admin_bathrooms_options( $field ) {

        $bathrooms = array(); 
        for ( $i = 1; $i <= 10; $i++ ) {
            $bathrooms[$i] = sprintf( _n( '%d bathroom', '%d bathrooms', $i, 'to_publish' ), $i );
        } 
        return $bathrooms;
    }

    $cmb->add_field( array(
        'name' => __( 'Rooms', 'to_publish' ),
        'id'   => 'submitted_rooms',
        'type' => 'select',
        'show_option_none' => true,
        'options_cb'        => 'admin_rooms_options', 
    ) );


    // Callback function
    function admin_rooms_options( $field ) {

        $rooms = array(); 
        for ( $i = 1; $i <= 10; $i++ ) {
            $rooms[$i] = sprintf( _n( '%d room', '%d rooms', $i, 'to_publish' ), $i );
        } 
        return $rooms;
    }

    $cmb->add_field( array(
        'name' => __( 'Floor', 'to_publish' ),
        'id'   => 'submitted_floor',
        'type' => 'text',
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        ), 
        'attributes'  => array( 
            'required'    => 'required',
        ),
    ) );

    $cmb->add_field( array(
        'name' => __( 'Price', 'to_publish' ),
        'id'   => 'submitted_price',
        'type' => 'text',
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        ), 
        'attributes'  => array( 
            'required'    => 'required',
        ),
    ) );
    
    $cmb->add_field( array(
        'name' => __( 'Your Name*', 'to_publish' ),
        'id'   => 'submitted_author_name',
        'type' => 'text',
        'attributes'  => array( 
            // 'required'    => 'required',
        ),
    ) );

    $cmb->add_field( array(
        'name' => __( 'Your Email*', 'to_publish' ),
        'id'   => 'submitted_author_email',
        'type' => 'text_email',
        'attributes'  => array( 
            // 'required'    => 'required',
        ),
    ) );

    $cmb->add_field( array(
        'name' => __( 'Phone*', 'to_publish' ),
        'id'   => 'submitted_author_phone',
        'type' => 'text',
        'attributes'  => array( 
            // 'required'    => 'required',
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
            // 'required'    => 'required',
            'row'         => 12
        ),
    ) );


    $cmb->add_field( array(
        'name' => 'Location',
        'desc' => 'Drag the marker to set the exact location',
        'id'   => 'submitted_location',
        'type' => 'pw_map',
        'split_values' => true, // Save latitude and longitude as two separate fields
    ));

    
    $cmb->add_group_field( $group_field_id, array(
        'name' => __( 'Image', 'to_publish' ),
        'id'   => 'submitted_images',
        'type' => 'file',
    ) );

}
add_action( 'cmb2_admin_init', 'to_publish_admin_annonces_form_register' );
