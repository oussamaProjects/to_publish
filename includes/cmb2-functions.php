<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'to_publish_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists(  dirname(dirname( __FILE__ )) . '/cmb2/init.php' ) ) { 
	require_once  dirname(dirname( __FILE__ )) . '/cmb2/init.php';
} elseif ( file_exists(  dirname(dirname( __FILE__ )) . '/CMB2/init.php' ) ) {
	require_once  dirname(dirname( __FILE__ )) . '/CMB2/init.php';
} 

add_action( 'cmb2_admin_init', 'to_publish_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function to_publish_register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'to_publish_theme_options_page',
		'title'        => esc_html__( 'Theme Options', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'to_publish_theme_options', // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-admin-generic', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'to_publish_options_page_message_callback',
		// 'tab_group'       => '', // Tab-group identifier, enables options page tab navigation.
		// 'tab_title'       => null, // Falls back to 'title' (above).
		// 'autoload'        => false, // Defaults to true, the options-page option will be autloaded.
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'mail', 'cmb2' ),
		'desc'    => esc_html__( '', 'cmb2' ),
		'id'      => 'mail',
		'type'    => 'text_email',
		'default' => 'matt@tanja-marina.com',
	) );

	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Phone', 'cmb2' ),
		'desc'    => esc_html__( '', 'cmb2' ),
		'id'      => 'phone_1',
		'type'    => 'text',
		'default' => '06 61 47 52 25',
	) );

	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Phone 2', 'cmb2' ),
		'desc'    => esc_html__( '', 'cmb2' ),
		'id'      => 'phone_2',
		'type'    => 'text',
		'default' => '06 41 86 30 36',
	) );

}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function to_publish_get_option( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( 'to_publish_theme_options', $key, $default );
	}

	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'to_publish_theme_options', $default );

	$val = $default;

	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;
}
 
 