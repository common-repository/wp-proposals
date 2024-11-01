<?php


// Proposal Scope of Service metabox
add_action( 'add_meta_boxes', 'wpp_proposal_services_box', 10, 1 );

/* Do something with the data entered */
add_action( 'save_post', 'wpp_save_services_data' );

/* Adds a box to the main column on the Post and Page edit screens */
function wpp_proposal_services_box() {
    add_meta_box(
        'wpp_proposal_services_box',
        __( 'Scope of Services', 'wp_proposal' ),
        'wpp_proposal_service_meta_box',
        'proposal',
        'normal',
        'high');
}

/* Creates Services box content */
function wpp_proposal_service_meta_box() {
    global $post;

    // Use nonce for verification
    wp_nonce_field( 'wpp_meta_box_nonce', 'meta_box_nonce' );
    $service_title = get_post_meta( $post->ID, 'wpp_service_title', true );
    $service_description = get_post_meta( $post->ID, 'wpp_service_description', true );
    $service       = get_post_meta( $post->ID, 'service', false ); // get as an array ?>

    <div id="wpp_meta_inner">
    <div>
            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Section Title', 'wp-proposals' ); ?></label>
                <input type="text" name="wpp_service_title" placeholder="Scope of Services" id="wpp_service_title" value="<?php echo esc_attr( $service_title ); ?>" />
                <p><?php esc_html_e( 'Create a custom title for the services section. Will display default title "Scope of Services" if empty.', 'wp-proposals' ); ?></p>
            </div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Description', 'wp-proposals' ) ?></label>
                <textarea  rows="3" cols="200" class="wpp-meta-description" name="wpp_service_description" id="wpp_service_description" value="<?php echo esc_attr( $service_description ); ?>" ><?php echo esc_attr( $service_description ); ?></textarea>
                <p><?php esc_html_e( 'Create a custom description for the services section.', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label class="wpp-label-repeater wpp-row-title"><?php esc_html_e( 'Add Service Item(s)', 'wp-proposals' ); ?></label>
                <?php
                    $c = 0;
                    if ( count( $service ) > 0 ) {
                        if ( ! empty( $service ) ) {
                            foreach( $service as $service_item_val ) {
                               if (!empty($service_item_val)) {
                                  foreach( $service_item_val as $service_item ) {
                                      if ( isset( $service_item['title'] ) || isset( $service_item['service_item'] ) ) {
                                          printf(
                                              '<div class="wpp-repeater-wrapper service">' .
                                                  'Item Title <input class="wpp-repeater-input service" type="text" name="service[%1$s][title]" value="%2$s" />' .
                                                  'Item Details <textarea class="wpp-repeater-input service" name="service[%1$s][service_item]" data-gramm_editor="false" value="">%3$s</textarea><span class="wpp-item-remove service">%4$s</span>' .
                                              '</div>',
                                              esc_attr( $c ),
                                              esc_html( $service_item['title'] ),
                                              esc_textarea( $service_item['service_item'] ),
                                              esc_html( __( 'Remove', 'wp-proposals' ) )
                                          );
                                          $c += 1;
                                      }
                                  }
                               }
                            }
                        }
                    }
                ?>
                <span id="services_here"></span>
                <div class="wpp-item-add services" style="visibility: hidden; margin-bottom: -20px;"><?php esc_html_e( 'Add Item', 'wp-proposals' ); ?></div>
                <div class="wpp-item-add services add-button"><?php esc_html_e( 'Add Item', 'wp-proposals' ); ?></div>
            </div>
        </div>

        <script>
            var $wpp =jQuery.noConflict();
            $wpp(document).ready(function() {
                    var count = <?php echo esc_js( $c ); ?>;
                    $wpp(".wpp-item-add.services").click(function() {
                            count = count + 1;
                            $wpp('#services_here').append('<div class="wpp-repeater-wrapper service">Item Title <input class="wpp-repeater-input service" type="text" name="service['+count+'][title]" value="" placeholder="" />Item Details <textarea class="wpp-repeater-input service" name="service['+count+'][service_item]" data-gramm_editor="false" value="" placeholder=""></textarea><span class="wpp-item-remove service">Remove</span></div>' );
                            return false;
                    });
                    $wpp("body").on('click', '.wpp-item-remove.service', function() {
                            $wpp(this).parent().remove();
                    });
            });
        </script>

    </div>
<?php }

/* When the post is saved, save our data */
function wpp_save_services_data( $post_id ) {
  if(defined("DOING_AJAX") AND DOING_AJAX)
      return;
      if(!current_user_can('edit_post', $post_id ))
      return;
	  if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'wpp_meta_box_nonce' ) ) return;
      $allowed_html = array (
          'a' => array(
              'href' => array()
      ) );
      $service = isset( $_POST['service'] ) ? (array) $_POST['service'] : array();
      update_post_meta( $post_id, 'wpp_service_title', wp_kses( $_POST['wpp_service_title'], $allowed_html ) );
      update_post_meta( $post_id, 'wpp_service_description', wp_kses( $_POST['wpp_service_description'], $allowed_html ) );
      update_post_meta ($post_id,'service',$service);
}
