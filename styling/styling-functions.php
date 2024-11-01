<?php


// Proposal backend stylesheet
function wpp_backend_styling() {
    wp_enqueue_style( 'wpp-backend-styling', plugins_url( '/wpp-backend-styling.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'wpp_backend_styling' );


// Proposal frontend stylesheet
function wpp_stylesheet() {
    wp_enqueue_style( 'wpp-proposal-styling', plugins_url( '/wpp-frontend-styling.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'wpp_stylesheet' );


// Proposal print stylesheet
function wpp_stylesheet_print() {
    wp_enqueue_style( 'wpp-proposal-print', plugins_url( '/wpp-print.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'wpp_stylesheet_print' );


// Include dynamic css file
include( plugin_dir_path( __FILE__ ) . 'wpp-dynamic-css.php');
