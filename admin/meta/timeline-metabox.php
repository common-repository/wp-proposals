<?php


// Timeline metabox
add_action( 'add_meta_boxes', 'wpp_timeline_box', 10, 3 );

/* Do something with the data entered */
add_action( 'save_post', 'wpp_save_timeline_data' );

/* Adds a box to the main column on the Post and Page edit screens */
function wpp_timeline_box() {
    add_meta_box(
        'wpp_timeline_box',
        __( 'Timeline', 'wp_proposal' ),
        'wpp_timeline_meta_box',
        'proposal',
        'normal',
        'high');
}

/* Creates timeline meta box conent */
function wpp_timeline_meta_box() {
    global $post;

    // get as an array
    wp_nonce_field( 'wpp_meta_box_nonce', 'meta_box_nonce' );
    $timeline = get_post_meta($post->ID,'timeline',false);
    $timeline_title = get_post_meta($post->ID, 'wpp_timeline_title', true);
    $timeline_description = get_post_meta($post->ID, 'wpp_timeline_description', true);
    $timeline_date = get_post_meta($post->ID, 'wpp_timeline_date', true);
    $timeline_footer = get_post_meta($post->ID, 'wpp_timeline_footer', true);

    ?>

    <div id="wpp_meta_inner">
    <div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Section Title', 'wp-proposals' ) ?></label>
                <input type="text" name="wpp_timeline_title" placeholder="Timeline" id="wpp_timeline_title" value="<?php echo $timeline_title; ?>" />
                <p><?php esc_html_e( 'Create a custom title for the timeline section. Will display default title "Timeline" if empty.', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Description', 'wp-proposals' ) ?></label>
                <textarea  rows="3" cols="200" class="wpp-meta-description" name="wpp_timeline_description" id="wpp_timeline_description" value="<?php echo esc_attr( $timeline_description ); ?>" ><?php echo esc_attr( $timeline_description ); ?></textarea>
                <p><?php esc_html_e( 'Create a custom description for the timeline section.', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Estimated Timeline', 'wp-proposals' ) ?></label>
                <input type="text" name="wpp_timeline_date" id="wpp_timeline_date" placeholder="November - December" value="<?php echo $timeline_date; ?>" />
                <p><?php esc_html_e( '', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label class="wpp-label-repeater wpp-row-title"><?php esc_html_e( 'Add Timeline Item(s)', 'wp-proposals' ) ?></label>
                <?php
                    $c = 0;
                    if ( count( $timeline ) > 0 ) {
                        if(!empty($timeline)) {
                            foreach( $timeline as $timeline_item_val ) {
                                if (!empty($timeline_item_val)) {
                                    foreach( $timeline_item_val as $timeline_item ) {
                                        if ( isset( $timeline_item['title'] ) || isset( $timeline_item['timeline_item'] ) ) {
                                            printf(
                                                '<div class="wpp-repeater-wrapper">' .
                                                    'Item Title <input class="wpp-repeater-input" type="text" name="timeline[%1$s][title]" value="%2$s" />' .
                                                    'Length <input class="wpp-repeater-input" type="text" name="timeline[%1$s][timeline_item]" value="%3$s" /><span class="wpp-item-remove timeline">%4$s</span>' .
                                                    '</div>',
                                                    esc_attr( $c ),
                                                    esc_html( $timeline_item['title'] ),
                                                    esc_textarea( $timeline_item['timeline_item'] ),
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
                <span id="timeline_here"></span>
                    <div class="wpp-item-add timeline" style="visibility: hidden; margin-bottom: -20px;"><?php esc_html_e('Add Item'); ?></div>
                    <div class="wpp-item-add timeline add-button"><?php esc_html_e( 'Add Item', 'wp-proposals' ); ?></div>
                </div>

            <div class="wpp-input-container">
                <label><?php esc_html_e( 'Footer Text', 'wp-proposals' ) ?></label>
                <textarea style="height: 55px!important;" rows="3" cols="200" name="wpp_timeline_footer" id="wpp_timeline_footer" value="<?php echo $timeline_footer; ?>" /><?php echo $timeline_footer; ?></textarea>
                <p><?php esc_html_e( 'Add special terms or text to display under the timeline table.', 'wp-proposals' ) ?></p>
            </div>
    </div>

    <script>
        var $wpp =jQuery.noConflict();
        $wpp(document).ready(function() {
                var count = <?php echo $c; ?>;
                $wpp(".wpp-item-add.timeline").click(function() {
                    count = count + 1;
                    $wpp('#timeline_here').append('<div class="wpp-repeater-wrapper">Item Title <input class="wpp-repeater-input" type="text" name="timeline['+count+'][title]" value="" placeholder="Web Design" />Length <input class="wpp-repeater-input" type="text" name="timeline['+count+'][timeline_item]" value="" placeholder="1 - 2 weeks" /><span class="wpp-item-remove timeline">Remove</span></div>' );
                    return false;
                });
                $wpp("body").on('click', '.wpp-item-remove.timeline', function() {
                    $wpp(this).parent().remove();
                });
        });
    </script>

</div>

<?php }

/* When the post is saved, save our data */
function wpp_save_timeline_data( $post_id ) {
  if(defined("DOING_AJAX") AND DOING_AJAX)
      return;
      if(!current_user_can('edit_post', $post_id ))
      return;
	    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'wpp_meta_box_nonce' ) ) return;
      $allowed_html = array(
              'a' => array(
                  'href' => array()
              ));
      $timeline = isset( $_POST['timeline'] ) ? (array) $_POST['timeline'] : array();
      update_post_meta ($post_id, 'wpp_timeline_title', wp_kses( $_POST['wpp_timeline_title'], $allowed_html));
      update_post_meta ($post_id, 'wpp_timeline_description', wp_kses( $_POST['wpp_timeline_description'], $allowed_html));
      update_post_meta ($post_id, 'wpp_timeline_date', wp_kses( $_POST['wpp_timeline_date'], $allowed_html));
      update_post_meta ($post_id, 'wpp_timeline_footer', wp_kses( $_POST['wpp_timeline_footer'], $allowed_html));
      update_post_meta($post_id,'timeline',$timeline);
}
