<?php


// Proposal pricing meta box

add_action( 'add_meta_boxes', 'wpp_proposal_pricing_box', 10, 4 );

/* Do something with the data entered */
add_action( 'save_post', 'wpp_save_pricing_data' );

/* Adds a box to the main column on the Post and Page edit screens */
function wpp_proposal_pricing_box() {
    add_meta_box(
        'wpp_proposal_pricing_box',
        __( 'Your Investment', 'wp_proposal' ),
        'wpp_proposal_pricing_meta_box',
        'proposal',
        'normal',
        'high');
}

/* Creates Services box conent */
function wpp_proposal_pricing_meta_box() {
    global $post;

    // Use nonce for verification
    wp_nonce_field( 'wpp_meta_box_nonce', 'meta_box_nonce' );
    $pricing = get_post_meta($post->ID,'pricing',false);
    $pricing_title = get_post_meta($post->ID, 'wpp_pricing_title', true);
    $pricing_description = get_post_meta($post->ID, 'wpp_pricing_description', true);
    $pricing_total = get_post_meta($post->ID, 'wpp_pricing_total', true);
    $pricing_footer = get_post_meta($post->ID, 'wpp_pricing_footer', true);
    $wpp_currency = get_option('wpp_misc_currency');

    // Set default currency to US dollars if settings is empty
    if (!empty($wpp_currency)) {
        $wpp_currency = $wpp_currency;
    } else {
        $wpp_currency = '$';
    }
    if ($wpp_currency == '-') {
        // Hide currency symbol
        $wpp_currency = '';
    }

    ?>

    <div id="wpp_meta_inner">
    <div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Section Title', 'wp-proposals' ) ?></label>
                <input type="text" name="wpp_pricing_title" placeholder="Your Investment" id="wpp_pricing_title" value="<?php echo esc_attr( $pricing_title ); ?>" />
                <p><?php esc_html_e( 'Create a custom title for the timeline section. Will display default title "Your Investment" if empty.', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Description', 'wp-proposals' ) ?></label>
                <textarea rows="3" cols="200" class="wpp-meta-description" name="wpp_pricing_description" id="wpp_pricing_description" value="<?php echo esc_attr( $pricing_description ); ?>" ><?php echo esc_attr( $pricing_description ); ?></textarea>
                <p><?php esc_html_e( 'Create a custom description for the investment section.', 'wp-proposals' ) ?></p>
            </div>

              <div class="wpp-input-container">
                  <label class="wpp-label-repeater wpp-row-title"><?php esc_html_e( 'Add Pricing Item(s)', 'wp-proposals' ) ?></label>
                  <?php
                          $c = 0;
                          if ( count( $pricing ) > 0 ) {
                              if(!empty($pricing)) {
                                  foreach( $pricing as $pricing_item_val ) {
                                     if (!empty($pricing_item_val)) {
                                      foreach( $pricing_item_val as $pricing_item ) {
                                          if ( isset( $pricing_item['title'] ) || isset( $pricing_item['pricing_item'] ) ) {
                                              printf( '<div class="wpp-repeater-wrapper">' .
                                                  'Item Title <input class="wpp-repeater-input" type="text" name="pricing[%1$s][title]" value="%2$s" />' .
                                                  'Amount <input class="wpp-repeater-input amount" id="wpp-amount-value" type="text" name="pricing[%1$s][pricing_item]" value="%3$s" onblur="calculate()" /><span class="wpp-item-remove timeline">%4$s</span>' .
                                                  '</div>',
                                                  esc_attr( $c ),
                                                  esc_html( $pricing_item['title'] ),
                                                  esc_textarea( $pricing_item['pricing_item'] ),
                                                  esc_html( __( 'Remove', 'wp_proposal' ) )
                                              );
                                              $c = $c +1;
                                          }
                                      }
                                    }
                                  }
                              }
                          }
                  ?>
                  <span id="pricing_here"></span>
                  <div class="wpp-item-add pricing" style="visibility: hidden; margin-bottom: -20px;"><?php esc_html_e( 'Add Item', 'wp-proposals' ); ?></div>
                  <div class="wpp-item-add pricing add-button"><?php esc_html_e( 'Add Item', 'wp-proposals' ); ?></div>
                  </div>

                  <div class="wpp-input-container">
                      <label><?php esc_html_e( 'Total', 'wp-proposals' ) ?></label>
                      <div class="wpp-inline-currency-total"><div class="wpp-inline-currency"><?php echo $wpp_currency ?></div><input type="text" name="wpp_pricing_total" id="wpp_pricing_total" value="<?php if (empty($pricing_total)) { echo "0.00"; } else { echo $pricing_total; } ?>" /></div>
                  </div>

              <div class="wpp-input-container" style="margin-top: 6px;">
                  <label><?php esc_html_e( 'Footer Text', 'wp-proposals' ) ?></label>
                  <textarea style="height: 55px!important;" rows="3" cols="200" name="wpp_pricing_footer" id="wpp_pricing_footer" value="<?php echo $pricing_footer; ?>" /><?php echo $pricing_footer; ?></textarea>
                  <p><?php esc_html_e( 'Add special terms or text to display under the pricing table.', 'wp-proposals' ) ?></p>
              </div>

        </div>

        <script>
        var $wpp =jQuery.noConflict();
        $wpp(document).ready(function() {
            var count = <?php echo esc_js( $c ); ?>;
            $wpp(".wpp-item-add.pricing").click(function() {
                count = count + 1;
                $wpp('#pricing_here').append('<div class="wpp-repeater-wrapper">Item Title <input class="wpp-repeater-input" type="text" name="pricing['+count+'][title]" value="" placeholder="Web Design" />Amount <input class="wpp-repeater-input amount" type="text" name="pricing['+count+'][pricing_item]" value="0.00" onblur="calculate()" placeholder="" /><span class="wpp-item-remove pricing">Remove</span></div>' );
                return false;
            });
            $wpp("body").on('click', '.wpp-item-remove.pricing', function() {
                $wpp(this).parent().remove();
                calculate(1, false);
            });
            $wpp("body").on('click', '.wpp-item-remove.timeline', function() {
                calculate(1, false);
            });
        });
        calculate = function(){
            var total = 0;
            $wpp('.wpp-repeater-input.amount').each(function () {
                total += parseFloat($wpp(this).val());
            });

            total = parseFloat(total).toFixed(2);
            document.getElementById('wpp_pricing_total').value = parseFloat(total);
        }
        </script>

    </div>

<?php }

/* When the post is saved, save our data */
function wpp_save_pricing_data( $post_id ) {
    if(defined("DOING_AJAX") AND DOING_AJAX)
        return;
        if(!current_user_can('edit_post', $post_id ))
        return;
        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'wpp_meta_box_nonce' ) ) return;
        $allowed_html = array(
                'a' => array(
                    'href' => array()
                ));
        $pricing = isset( $_POST['pricing'] ) ? (array) $_POST['pricing'] : array();
        update_post_meta ($post_id, 'wpp_pricing_title', wp_kses( $_POST['wpp_pricing_title'], $allowed_html));
        update_post_meta ($post_id, 'wpp_pricing_description', wp_kses( $_POST['wpp_pricing_description'], $allowed_html));
        update_post_meta ($post_id, 'wpp_pricing_total', wp_kses( $_POST['wpp_pricing_total'], $allowed_html));
        update_post_meta ($post_id, 'wpp_pricing_footer', wp_kses( $_POST['wpp_pricing_footer'], $allowed_html));
        update_post_meta($post_id,'pricing',$pricing);
}
