<?php


// Require function files
require( plugin_dir_path( __FILE__ ) . '/templates/template-functions.php');
require( plugin_dir_path( __FILE__ ) . '/signature-form.php');


// Register proposal custom post type
function wpp_register_cpts_proposal() {

		// Create Post Type: Proposals.
		$labels = array(
				"name" => __( "Proposals", "" ),
				"singular_name" => __( "Proposal", "" ),
				"not_found" => __( "No Proposals Found", "" ),
				"menu_name" => __( "WP Proposals", "" ),
				"all_items" => __( "All Proposals", "" ),
				'search_items' => __( 'Search Proposals' ),
				"add_new" => __( "Create Proposal", "" ),
				'not_found' => __( 'No proposals found.' ),
				'not_found_in_trash' => __( 'No proposals found in Trash.' ),
				"add_new_item" => __( "Create New Proposal", "" ),
				"edit_item" => __( "Edit Proposal", "" ),
				"new_item" => __( "New Proposal", "" ),
				"view_item" => __( "View Proposal", "" ),
				"view_items" => __( "View Proposals", "" ),
				"search_items" => __( "Search Proposal", "" ),
		);

		$args = array(
				"label" => __( "Proposals", "" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => false,
				"rest_base" => "",
				"has_archive" => false,
				"show_in_menu" => true,
				"show_in_nav_menus" => false,
				"exclude_from_search" => true,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => array( 'slug' => 'proposal' ),
				"query_var" => true,
				"menu_position" => 3,
		    "menu_icon" => 'dashicons-welcome-widgets-menus',
				"supports" => array( "title", "thumbnail","editor" ),
		);
		register_post_type( "proposal", $args );
}
add_action( 'init', 'wpp_register_cpts_proposal' );


// Register proposal invoice taxonomy
function wpp_register_tax_proposal_invoice() {

		// Create Taxonomy: Proposal Invoice.
		$labels = array(
				"name" => __( "Invoice URL", "" ),
				"singular_name" => __( "Invoice URL", "" ),
		    "choose_from_most_used" => __( "Choose from a previous invoice URL", "" ),
		    "separate_items_with_commas" => __( "Add an invoice url that will redirect users to their invoice after the proposal has been approved.", "" ),
		);

		$args = array(
				"label" => __( "Invoice URL", "" ),
				"labels" => $labels,
				"public" => false,
				"hierarchical" => false,
				"label" => "Invoice URL",
				"show_ui" => true,
				"show_in_menu" => false,
				"show_in_nav_menus" => false,
				"exclude_from_search" => true,
				"query_var" => true,
				"has_archive" => false,
				"rewrite" => array( 'slug' => 'proposal-invoice' ),
				"show_admin_column" => false,
				"show_in_rest" => true,
				"rest_base" => "proposal_invoice",
				"show_in_quick_edit" => true,
		);
		register_taxonomy( "proposal_invoice", array( "proposal" ), $args );
}
add_action( 'init', 'wpp_register_tax_proposal_invoice' );


// Register proposal client taxonomy
function wpp_register_tax_client() {

		// Create Taxonomy: Clients.
		$labels = array(
				"name" => __( "Client", "" ),
				"singular_name" => __( "Client", "" ),
		    "menu_name" => __( "Clients", "" ),
		    "add_new_item" => __( "Add New Client", "" ),
		    "edit_item" => __( "Edit Client", "" ),
		    "new_item_name" => __( "New Client", "" ),
		    "choose_from_most_used" => __( "Choose from previously used Clients", "" ),
		    "separate_items_with_commas" => __( "Assign a client to this proposal.", "" ),
				"search_items" => __( "Search Clients", "" ),
				"back_to_items" => __( "Back to Clients", "" ),
				"update_item" => __( "Update Client", "" ),
		);

		$args = array(
				"label" => __( "Client", "" ),
				"labels" => $labels,
				"public" => false,
				"hierarchical" => true,
				"label" => "Client",
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => false,
				"exclude_from_search" => true,
				"query_var" => true,
				"has_archive" => false,
				"rewrite" => array( 'slug' => 'clients' ),
				"show_admin_column" => true,
				"show_in_rest" => true,
				"rest_base" => "clients",
				"show_in_quick_edit" => true,
		);
		register_taxonomy( "clients", array( "proposal" ), $args );
}
add_action( 'init', 'wpp_register_tax_client' );


// Register proposal status taxonomy
function wpp_register_tax_proposal_status() {

		// Create Taxonomy: Proposal Status.
		$labels = array(
				"name" => __( "Proposal Status", "" ),
				"singular_name" => __( "Proposal Status", "" ),
		    "choose_from_most_used" => __( "Choose from Pending or Approved", "" ),
		    "separate_items_with_commas" => __( "Current proposal status", "" ),
		);

		$args = array(
				"label" => __( "Proposal Status", "" ),
				"labels" => $labels,
				"public" => false,
				"hierarchical" => true,
				"label" => "Proposal Status",
				"show_ui" => true,
				"show_in_menu" => false,
				"show_in_nav_menus" => false,
				"exclude_from_search" => true,
				"query_var" => true,
				"has_archive" => false,
				"rewrite" => array( 'slug' => 'proposal-status' ),
				"show_admin_column" => true,
				"show_in_rest" => true,
				"rest_base" => "proposal_status",
				"show_in_quick_edit" => true,
		);
		register_taxonomy( "proposal_status", array( "proposal" ), $args );
}
add_action( 'init', 'wpp_register_tax_proposal_status' );


// Set proposal approval status to pending when published
function wpp_set_default_proposal_status( $post_id, $post ) {
    if ( 'publish' === $post->post_status ) {
        $defaults = array(
            'proposal_status' => array( 'Pending' ),
            );
        $taxonomies = get_object_taxonomies( $post->post_type );
        foreach ( (array) $taxonomies as $taxonomy ) {
            $terms = wp_get_post_terms( $post_id, $taxonomy );
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
            }
        }
    }
}
add_action( 'save_post', 'wpp_set_default_proposal_status', 100, 2 );


// Create print shortcode [print_button]
function wpp_print_button_shortcode( $atts ){
		return '<a class="print-link" href="javascript:window.print()">Print</a>';
}
add_shortcode( 'print_button', 'wpp_print_button_shortcode' );


// Sets proposal pages to do not index
function wpp_noindex_for_proposal() {
    if ( is_singular( 'proposal' ) ) {
        echo '<meta name="robots" content="noindex, follow">';
    }
}

add_action('wp_head', 'wpp_noindex_for_proposal');


// Adds approval status to body class for styling purposes
function wpp_proposal_status_in_body_class( $classes ){
		global $post;
		if( is_singular() ) {
				$custom_terms = get_the_terms($post->ID, 'proposal_status');
				if ($custom_terms) {
						foreach ($custom_terms as $custom_term) {
								$classes[] = 'status-' . $custom_term->slug;
						}
				}
		}
		return $classes;
}
add_filter( 'body_class', 'wpp_proposal_status_in_body_class' );


// Remove slider rev metabox from proposals

if ( is_admin() ) {
		function wpp_remove_revolution_slider_meta_boxes() {
				remove_meta_box( 'mymetabox_revslider_0', 'proposal', 'normal' );
		}
		add_action( 'do_meta_boxes', 'wpp_remove_revolution_slider_meta_boxes' );
}


// Add note above proposal conent editor

add_action( 'edit_form_after_editor', 'wpp_edit_proposal_note' );
function wpp_edit_proposal_note($post) {
    $wpp_misc_hide_reminder = get_option('wpp_misc_hide_reminder');
    if(empty($wpp_misc_hide_reminder)) {
        if( $post->post_type == 'proposal' ){
    				echo '<div class="wpp-proposal-note"><p><strong>Reminder: </strong>You can create custom content by using the content editor and any page builder to design your own sections. This will only replace the main content portion and not effect the metaboxes below. For best results with a page builder turn on "Content Editor Full Width" in the <a href="edit.php?post_type=proposal&page=wpp-settings&tab=design">design settings</a>.</p></div>';
    		}
    }
}
