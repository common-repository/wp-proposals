<?php


// Include template function file
require( plugin_dir_path( __FILE__ ) . '/settings/settings-functions.php');
require( plugin_dir_path( __FILE__ ) . '/options/option-functions.php');
require( plugin_dir_path( __FILE__ ) . '/meta/meta-functions.php');
require( plugin_dir_path( __FILE__ ) . '/taxonomies/client-taxonomies.php');


// Add settings to proposal menu
add_action('admin_menu', 'wpp_setup_settings_menu');
function wpp_setup_settings_menu() {
		add_submenu_page( 'edit.php?post_type=proposal', 'General Settings', 'General Settings', 'edit_posts', 'wpp-settings', 'wpp_settings');
}


// Include color picker assets
add_action( 'admin_enqueue_scripts', 'wpp_add_color_picker' );
function wpp_add_color_picker( $hook ) {
    if( is_admin() ) {
        // Add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( '/js/color-picker-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
}


// Add upload image function to settings page
function wpp_load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'wpp_load_media_files' );


// Adds ability to filter proposals by clients
add_action('restrict_manage_posts', 'wpp_filter_post_type_by_client');
function wpp_filter_post_type_by_client() {
		global $typenow;
		$post_type = 'proposal';
		$taxonomy  = 'clients';
		if ($typenow == $post_type) {
				$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
				$info_taxonomy = get_taxonomy($taxonomy);
				wp_dropdown_categories(array(
						'show_option_all' => __("All Clients"),
						'taxonomy'        => $taxonomy,
						'name'            => $taxonomy,
						'orderby'         => 'name',
						'selected'        => $selected,
						'show_count'      => true,
						'hide_empty'      => true,
				));
		};
}


// Filter posts by taxonomy in admin column
add_filter('parse_query', 'wpp_convert_client_to_term_in_query');
function wpp_convert_client_to_term_in_query($query) {
		global $pagenow;
		$post_type = 'proposal';
		$taxonomy  = 'clients';
		$q_vars    = &$query->query_vars;
		if ( $pagenow == 'edit.php?post_type=proposal' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
				$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
				$q_vars[$taxonomy] = $term->slug;
		}
}


// Gets view count from proposal single
function wpp_getProposalViews($post_id){
		$wpp_misc_view_count = get_option('wpp_misc_view_count');
		if(empty($wpp_misc_view_count)) {
		    $count_key = 'post_views_count';
		    $count = get_post_meta($post_id, $count_key, true);
		    if($count==''){
		        delete_post_meta($post_id, $count_key);
		        add_post_meta($post_id, $count_key, '0');
		        return "0 View";
		    }
		    return $count.' Views';
		}
}
function wpp_setProposalViews($post_id) {
		$wpp_misc_view_count = get_option('wpp_misc_view_count');
		if(empty($wpp_misc_view_count)) {
				if ( current_user_can( 'manage_options' ) ) {
				    // Do nothing
				} else {
				    $count_key = 'post_views_count';
				    $count = get_post_meta($post_id, $count_key, true);
				    if($count==''){
				        $count = 0;
				        delete_post_meta($post_id, $count_key);
				        add_post_meta($post_id, $count_key, '0');
				    } else {
				        $count++;
				        update_post_meta($post_id, $count_key, $count);
				    }
				}
		}
}


// Adds view count to admin column
add_filter('manage_proposal_posts_columns', 'wpp_proposal_column_views');
add_action('manage_proposal_posts_custom_column', 'wpp_proposal_custom_column_views',5,2);
function wpp_proposal_column_views($defaults){ $wpp_misc_view_count = get_option('wpp_misc_view_count'); if(empty($wpp_misc_view_count)) { $defaults['post_views'] = __('View Count'); } return $defaults; } function wpp_proposal_custom_column_views($column_name, $id){ if($column_name === 'post_views'){ echo wpp_getProposalViews(get_the_ID()); } }


// Add duplicate feature to Proposal
function wpp_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'wpp_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	/*
	 * Nonce verification
	 */
	if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
		return;

	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {

		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
      'post_views_count' => '0'
		);

		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );

		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}

		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
      if($new_post_id)  {
      $count_key = 'post_views_count';
      $count = get_post_meta($new_post_id, $count_key, true);
          delete_post_meta($new_post_id, $count_key);
      }
		}


		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_wpp_duplicate_post_as_draft', 'wpp_duplicate_post_as_draft' );


// Add the duplicate link to action list for post_row_actions
function wpp_duplicate_post_link( $actions, $post ) {
		if (current_user_can('edit_posts')) {
				$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=wpp_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
		}
		return $actions;
}
add_filter( 'post_row_actions', 'wpp_duplicate_post_link', 10, 2 );


// Custom save changes option notice
function wpp_custom_save_notice() {
    global $pagenow;
    if ($pagenow == 'edit.php') {
        if ( isset( $_GET['settings-updated'] )) {
            add_settings_error( 'wpp-notices', 'wpp-settings-updated', __('Settings saved.', 'wpp'), 'updated' );
        }
    }
}
add_action('admin_notices', 'wpp_custom_save_notice');


// Send Proposal action row
add_filter('post_row_actions','wpp_send_proposal_action_row', 10, 2);
function wpp_send_proposal_action_row($actions, $post){
    //check for your post type
    if ($post->post_type =="proposal"){
        $actions['send_proposal'] = '<a href="post.php?post=' .$post->ID . '&action=edit">Send Proposal</a>';
    }
    return $actions;
}


// Disable Yoast on proposals
function wpp_remove_yoast_metabox_proposals(){
    remove_meta_box('wpseo_meta', 'proposals', 'normal');
}
add_action( 'add_meta_boxes', 'wpp_remove_yoast_metabox_proposals',11 );
