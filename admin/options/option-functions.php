<?php


// Register sermon field options
include( plugin_dir_path( __FILE__ ) . '/register-options.php');


// Hook to get registered options
add_action( 'admin_init', 'wpp_main_register_options' );
function wpp_main_register_options() {
      do_action( 'wpp_create_options' );
}
