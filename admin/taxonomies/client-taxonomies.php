<?php


// This will add the custom client fields to the add new term page
function wpp_client_email_taxonomy_add_new_meta() { ?>
    <div class="form-field">
      	<label for="wpp_client_meta[client_email]"><?php _e( 'Client Email', 'wpp' ); ?></label>
      	<input type="text" name="wpp_client_meta[client_email]" id="wpp_client_meta[client_email]" value="">
      	<p class="description"><?php _e( 'Enter client&#39;s email.','wpp' ); ?></p>
    </div>
    <div class="form-field">
      	<label for="wpp_client_meta[client_phone]"><?php _e( 'Phone Number', 'wpp' ); ?></label>
      	<input type="text" name="wpp_client_meta[client_phone]" id="wpp_client_meta[client_phone]" value="">
      	<p class="description"><?php _e( 'Enter client&#39;s phone number for your record.','wpp' ); ?></p>
    </div>
    <div class="form-field">
      	<label for="wpp_client_meta[client_address]"><?php _e( 'Address', 'wpp' ); ?></label>
      	<input type="text" name="wpp_client_meta[client_address]" id="wpp_client_meta[client_address]" value="">
      	<p class="description"><?php _e( 'Enter client&#39;s mailing address for your record.','wpp' ); ?></p>
    </div>
<?php }
add_action( 'clients_add_form_fields', 'wpp_client_email_taxonomy_add_new_meta', 10, 2 );


// This will add the custom client fields to the edit term page
function wpp_client_email_taxonomy_edit_meta_field($term) {

		// Put the term ID into a variable
		$wpp_client_id = $term->term_id;

		// Retrieve the existing value(s) for this meta field. This returns an array
		$wpp_client_meta = get_option( "taxonomy_$wpp_client_id" ); ?>

		<tr class="form-field">
		<th scope="row" valign="top"><label for="wpp_client_meta[client_email]"><?php _e( 'Client Email', 'clients' ); ?></label></th>
  			<td>
    				<input type="text" name="wpp_client_meta[client_email]" id="wpp_client_meta[client_email]" value="<?php echo esc_attr( $wpp_client_meta['client_email'] ) ? esc_attr( $wpp_client_meta['client_email'] ) : ''; ?>">
    				<p class="description"><?php _e( 'Enter client&#39;s email.','wpp' ); ?></p>
  			</td>
		</tr>

		<tr class="form-field">
		<th scope="row" valign="top"><label for="wpp_client_meta[client_phone]"><?php _e( 'Phone Number', 'clients' ); ?></label></th>
  			<td>
    				<input type="text" name="wpp_client_meta[client_phone]" id="wpp_client_meta[client_phone]" value="<?php echo esc_attr( $wpp_client_meta['client_phone'] ) ? esc_attr( $wpp_client_meta['client_phone'] ) : ''; ?>">
    				<p class="description"><?php _e( 'Enter client&#39;s phone number for your record.','wpp' ); ?></p>
  			</td>
		</tr>

		<tr class="form-field">
		<th scope="row" valign="top"><label for="wpp_client_meta[client_address]"><?php _e( 'Address', 'clients' ); ?></label></th>
  			<td>
    				<input type="text" name="wpp_client_meta[client_address]" id="wpp_client_meta[client_address]" value="<?php echo esc_attr( $wpp_client_meta['client_address'] ) ? esc_attr( $wpp_client_meta['client_address'] ) : ''; ?>">
    				<p class="description"><?php _e( 'Enter client&#39;s mailing address for your record.','wpp' ); ?></p>
  			</td>
		</tr>

<?php
}
add_action( 'clients_edit_form_fields', 'wpp_client_email_taxonomy_edit_meta_field', 10, 2 );


// Save extra taxonomy fields callback function.
function wpp_client_emaiL_save_taxonomy_meta( $term_id ) {
    if ( isset( $_POST['wpp_client_meta'] ) ) {
      	$wpp_client_id = $term_id;
      	$wpp_client_meta = get_option( "taxonomy_$wpp_client_id" );
      	$cat_keys = array_keys( $_POST['wpp_client_meta'] );
          	foreach ( $cat_keys as $key ) {
            		if ( isset ( $_POST['wpp_client_meta'][$key] ) ) {
            			$wpp_client_meta[$key] = $_POST['wpp_client_meta'][$key];
            		}
          	}
  	// Save the option array.
  	update_option( "taxonomy_$wpp_client_id", $wpp_client_meta );
    }
}
add_action( 'edited_clients', 'wpp_client_emaiL_save_taxonomy_meta', 10, 2 );
add_action( 'create_clients', 'wpp_client_emaiL_save_taxonomy_meta', 10, 2 );


// Add client email to client taxamony columns
add_filter( 'manage_edit-clients_columns', 'wpp_taxonomy_columns_client_email');
add_filter( 'manage_clients_custom_column', 'wpp_taxonomy_columns_client_email_manage', 10, 3);

function wpp_taxonomy_columns_client_email($columns) {
    $columns['email'] = 'Email';
		$columns['phone'] = 'Phone';
		$columns['address'] = 'Address';
    return $columns;
}
function wpp_taxonomy_columns_client_email_manage( $out ,$column_name, $term_id) {
	  if ($column_name == 'email') {
		    global $wp_version;
		    $wpp_client_id = $term_id;
				$wpp_client_meta = get_option( "taxonomy_$wpp_client_id" );
		    $client_email = $wpp_client_meta['client_email'];
		    if(((float)$wp_version)<3.1)
		        return $client_email;
		    else
		        echo "<a href='mailto:$client_email' target='_self'>$client_email</a>";
		}
		if ($column_name == 'phone') {
		    global $wp_version;
		    $wpp_client_id = $term_id;
				$wpp_client_meta = get_option( "taxonomy_$wpp_client_id" );
		    $client_phone = $wpp_client_meta['client_phone'];
		    if(((float)$wp_version)<3.1)
		        return $client_phone;
		    else
		        echo "<a href='tel:$client_phone' target='_self'>$client_phone</a>";
		}
		if ($column_name == 'address') {
		    global $wp_version;
		    $wpp_client_id = $term_id;
				$wpp_client_meta = get_option( "taxonomy_$wpp_client_id" );
		    $client_address = $wpp_client_meta['client_address'];
		    if(((float)$wp_version)<3.1)
		        return $client_address;
		    else
		        echo "$client_address";
		}
}


// Make client email column sortable
function wpp_register_client_email_column_for_issues_sortable($columns) {
		$columns['email'] = 'Email';
		$columns['phone'] = 'Phone';
		$columns['address'] = 'Address';
		return $columns;
}
add_filter('manage_edit-clients_sortable_columns', 'wpp_register_client_email_column_for_issues_sortable');
