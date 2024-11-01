<?php


// Proposal Additional Recommendations metabox
add_action( 'add_meta_boxes', 'wpp_proposal_recommendation_box', 10, 2 );

/* Do something with the data entered */
add_action( 'save_post', 'wpp_save_recommendation_data' );

/* Adds a box to the main column on the Post and Page edit screens */
function wpp_proposal_recommendation_box() {
    add_meta_box(
        'wpp_proposal_recommendation_box',
        __( 'Additional Recommendations', 'wp_proposal' ),
        'wpp_proposal_recommendation_meta_box',
        'proposal',
        'normal',
        'high');
}

/* Creates Services box conent */
function wpp_proposal_recommendation_meta_box() {
    global $post;

    // Use nonce for verification
    wp_nonce_field( 'wpp_meta_box_nonce', 'meta_box_nonce' );
    $recommendation_title = get_post_meta($post->ID, 'wpp_recommendation_title', true);
    $recommendation_description = get_post_meta($post->ID, 'wpp_recommendation_description', true);
    $recommendation = get_post_meta($post->ID,'recommendation',false); // get as an array ?>

    <div id="wpp_meta_inner">
    <div>
            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Section Title', 'wp-proposals' ) ?></label>
                <input type="text" name="wpp_recommendation_title" placeholder="Additional Recommendations" id="wpp_recommendation_title" value="<?php echo esc_attr( $recommendation_title ); ?>" />
                <p><?php esc_html_e( 'Create a custom title for the recommendations section. Will display default title "Additional Recommendations" if empty.', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Description', 'wp-proposals' ) ?></label>
                <textarea  rows="3" cols="200" class="wpp-meta-description" name="wpp_recommendation_description" id="wpp_recommendation_description" value="<?php echo esc_attr( $recommendation_description ); ?>" ><?php echo esc_attr( $recommendation_description ); ?></textarea>
                <p><?php esc_html_e( 'Create a custom description for the recommendations section.', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label class="wpp-label-repeater wpp-row-title"><?php esc_html_e( 'Add Recommended Item(s)', 'wp-proposals' ) ?></label>
                <?php
                    $c = 0;
                    if ( count( $recommendation ) > 0 ) {
                        if ( ! empty( $recommendation ) ) {
                            foreach( $recommendation as $recommendation_item_val ) {
                               if (!empty($recommendation_item_val)) {
                                  foreach( $recommendation_item_val as $recommendation_item ) {
                                      if ( isset( $recommendation_item['title'] ) || isset( $recommendation_item['recommendation_item'] ) ) {
                                          printf(
                                              '<div class="wpp-repeater-wrapper service">' .
                                                  'Item Title <input class="wpp-repeater-input service" type="text" name="recommendation[%1$s][title]" value="%2$s" />' .
                                                  'Item Details <textarea class="wpp-repeater-input service" name="recommendation[%1$s][recommendation_item]" data-gramm_editor="false" value="">%3$s</textarea><span class="wpp-item-remove service">%4$s</span>' .
                                              '</div>',
                                              esc_attr( $c ),
                                              esc_html( $recommendation_item['title'] ),
                                              esc_textarea( $recommendation_item['recommendation_item'] ),
                                              esc_html( __( 'Remove', 'wp_proposal' ) )
                                          );
                                          $c += 1;
                                      }
                                  }
                               }
                            }
                        }
                    }
                ?>
                <span id="recommendations_here"></span>
                <div class="wpp-item-add recommendation" style="visibility: hidden; margin-bottom: -20px;"><?php esc_html_e( 'Add Item', 'wp-proposals' ); ?></div>
                <div class="wpp-item-add recommendation add-button"><?php esc_html_e( 'Add Item', 'wp-proposals' ); ?></div>
            </div>
        </div>

        <script>
            var $wpp =jQuery.noConflict();
            $wpp(document).ready(function() {
                    var count = <?php echo esc_js( $c ); ?>;
                    $wpp(".wpp-item-add.recommendation").click(function() {
                            count = count + 1;
                            $wpp('#recommendations_here').append('<div class="wpp-repeater-wrapper service">Item Title <input class="wpp-repeater-input service" type="text" name="recommendation['+count+'][title]" value="" placeholder="" />Item Details <textarea class="wpp-repeater-input service" name="recommendation['+count+'][recommendation_item]" data-gramm_editor="false" value="" placeholder=""></textarea><span class="wpp-item-remove recommendation">Remove</span></div>' );
                            return false;
                    });
                    $wpp("body").on('click', '.wpp-item-remove.recommendation', function() {
                            $wpp(this).parent().remove();
                    });
            });
        </script>

    </div>

<?php }

/* When the post is saved, save our data */
function wpp_save_recommendation_data( $post_id ) {
  if(defined("DOING_AJAX") AND DOING_AJAX)
      return;
      if(!current_user_can('edit_post', $post_id ))
      return;
	  if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'wpp_meta_box_nonce' ) ) return;
      $allowed_html = array (
          'a' => array(
              'href' => array()
      ) );
      $recommendation = isset( $_POST['recommendation'] ) ? (array) $_POST['recommendation'] : array();
      update_post_meta( $post_id, 'wpp_recommendation_title', wp_kses( $_POST['wpp_recommendation_title'], $allowed_html ) );
      update_post_meta( $post_id, 'wpp_recommendation_description', wp_kses( $_POST['wpp_recommendation_description'], $allowed_html ) );
      update_post_meta($post_id,'recommendation',$recommendation);
}
