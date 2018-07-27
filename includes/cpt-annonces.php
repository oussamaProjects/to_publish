<?php
function to_publish_register_my_cpts_annonce() {

	/**
	 * Post Type: Annonces.
	 */

	$labels = array(
		"name" => __( "Annonces", "tanja-marina" ),
		"singular_name" => __( "Annonce", "tanja-marina" ),
	);

	$args = array(
		"label" => __( "Annonces", "tanja-marina" ),
		"labels" => $labels,
		"description" => "",
      "public" => true,
      'menu_icon'   => 'dashicons-megaphone',
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "annonce", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail" ),
	);

	register_post_type( "annonce", $args );
}

add_action( 'init', 'to_publish_register_my_cpts_annonce' );


function to_publish_register_my_taxes_types() {

	/**
	 * Taxonomy: Types.
	 */

	$labels = array(
		"name" => __( "Types", "tanja-marina" ),
		"singular_name" => __( "Type", "tanja-marina" ),
	);

	$args = array(
		"label" => __( "Types", "tanja-marina" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Types",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'types', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "types",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "types", array( "annonce" ), $args );
}

add_action( 'init', 'to_publish_register_my_taxes_types' );

function to_publish_register_my_taxes_localisation() {

	/**
	 * Taxonomy: Localisations.
	 */

	$labels = array(
		"name" => __( "Localisations", "tanja-marina" ),
		"singular_name" => __( "Localisation", "tanja-marina" ),
	);

	$args = array(
		"label" => __( "Localisations", "tanja-marina" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Localisations",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'localisation', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "localisation",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "localisation", array( "annonce" ), $args );
}

add_action( 'init', 'to_publish_register_my_taxes_localisation' );
