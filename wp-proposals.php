<?php


/*
Plugin Name: WP Proposals
Plugin URI: https://wordpress.org/plugins/wp-proposals/
Description: Beautiful, simple free WordPress proposal software. Transform your sales team into a closing machine.
Author: WP Codeus
Version: 2.3
Author URI: https://wpcodeus.com/
Text Domain: wp-proposals
*/


// If this file is called directly, abort
if ( ! defined( 'ABSPATH' ) ) {
     die ('Silly human what are you doing here');
}


// The core plugin file that is used to define internationalization, hooks and functions
require( plugin_dir_path( __FILE__ ) . '/include/plugin-functions.php');


// Plugin file that manages admin views and functionality
require( plugin_dir_path( __FILE__ ) . '/admin/admin-functions.php');


// Plugin file that manages stylsheets
require( plugin_dir_path( __FILE__ ) . '/styling/styling-functions.php');


// Get WP Proposal current version
$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$wpp_plugin_version = $plugin_data['Version'];
global $wpp_plugin_version;


// Adds settings link to plugin list
function wpp_plugin_add_settings_link( $links ) {
    $settings_link = '<a href="edit.php?post_type=proposal&page=wpp-settings">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wpp_plugin_add_settings_link' );


// Flush permalinks when plugin is activated
function wpp_flush_rewrites() {
    // Hook into create proposal custom post type
    wpp_register_cpts_proposal();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'wpp_flush_rewrites' );


// Display install notice
register_activation_hook( __FILE__, 'wpp_install_activation_hook' );
function wpp_install_activation_hook() {
    set_transient( 'wpp-install-notice', true, 5 );
}

add_action( 'admin_notices', 'wpp_install_notice' );
function wpp_install_notice(){
    /* Check transient, if available display notice */
    if( get_transient( 'wpp-install-notice' ) ){
        ?>
        <div class="updated notice is-dismissible">
            <p>To get started with WP Proposals, visit the <a href="edit.php?post_type=proposal&page=wpp-settings">general settings</a> page to brand and personalize your proposals.</p>
        </div>
        <?php

        /* Delete transient, only display this notice once. */
        // delete_transient( 'wpp-install-notice' );
    }
}
