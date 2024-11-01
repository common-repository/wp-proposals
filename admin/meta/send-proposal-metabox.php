<?php


// Send Proposal metabox
add_action( 'add_meta_boxes', 'wpp_send_proposal_box', 10, 3 );

// Do something with the data entered
add_action( 'save_post', 'wpp_save_send_proposal_data' );

// Adds a box to the main column on the Post and Page edit screens
function wpp_send_proposal_box() {
    global $post;

    if(!isset($post))
        return;

    if($post->post_status == 'publish') {
      add_meta_box(
          'wpp_send_proposal_box',
          __( 'Send Proposal', 'wp_proposal' ),
          'wpp_send_proposal_meta_box',
          'proposal',
          'test',
          'high');
    }
}


// Creates the send proposal meta box conent
function wpp_send_proposal_meta_box() {

    global $post;

    // get as an array
    wp_nonce_field( 'wpp_meta_box_nonce', 'meta_box_nonce' );
    $send_proposal = get_post_meta($post->ID,'send_proposal',false);
    $wpp_send_proposal_email = get_post_meta($post->ID, 'wpp_send_proposal_email', true);
    $wpp_send_proposal_subject = get_post_meta($post->ID, 'wpp_send_proposal_subject', true);
    $wpp_send_proposal_message = get_post_meta($post->ID, 'wpp_send_proposal_message', true);
    $wpp_send_proposal_time = get_post_meta($post->ID, 'wpp_send_proposal_time', true);

    // Get default send proposal data
    $wpp_general_send_proposal_subject = get_option( 'wpp_general_send_proposal_subject' );
    $wpp_general_send_proposal_message = get_option( 'wpp_general_send_proposal_message' );

    // Get selected client data
    $wpp_client_term_ids = wp_get_post_terms($post->ID, 'clients', array("fields" => "ids"));

    // Get client data if client has been assigned to proposal
    if (!empty($wpp_client_term_ids)) {
        $wpp_client_id = $wpp_client_term_ids[0];
        $wpp_client_meta = get_option( "taxonomy_$wpp_client_id" );
        $wpp_client_term_name = wp_get_post_terms($post->ID, 'clients', array("fields" => "names"));
        $wpp_client_name = $wpp_client_term_name[0];
    } else {
        $wpp_client_meta['client_email'] = '';
    }


    // Checks if custom proposal subject is empty. If is empty display default subject.
    if (empty($wpp_send_proposal_subject)) {
        $wpp_send_proposal_subject = $wpp_general_send_proposal_subject;
    }

    // Checks if custom proposal message is empty. If is empty display default message.
    if (empty($wpp_send_proposal_message)) {
        $wpp_send_proposal_message = $wpp_general_send_proposal_message;
    }

?>


<!-- Send Proposal Metabox HTML -->
<div id="wpp_meta_inner">
    <div>
        <div style="padding-top: 10px; padding-bottom: 15px; border-bottom: 1px solid #e3e3e3; margin-bottom: 10px;">Use this form to send the proposal directly to your client via email. The client will receive an email containing a link allowing them to view the proposal online.<br>Make sure your web server supports sending email (<code>php mail() / sendmail / postfix etc.</code>) otherwise this will not work.</div>

        <form id="send-proposal-form" action="<?php esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
            <div class="wpp-input-container">
                <label><?php esc_html_e( 'To Address', 'wp-proposals' ) ?></label>
                <input type="text" name="wpp_send_proposal_email" id="wpp_send_proposal_email" value="<?php echo $wpp_send_proposal_email ?: esc_attr( $wpp_client_meta['client_email'] ); ?>" />
                <p><?php esc_html_e( 'You can add multiple email addresses using a comma to separate. i.e. joe@example.com,sally@example.com', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container sidebar">
                <label><?php esc_html_e( 'Email Subject', 'wp-proposals' ) ?></label>
                <input type="text" name="wpp_send_proposal_subject" id="wpp_send_proposal_subject" value="<?php echo $wpp_send_proposal_subject; ?>" />
                <p><?php esc_html_e( 'The email subject line. Defaults to your settings.', 'wp-proposals' ) ?></p>
            </div>

            <div class="wpp-input-container">
                <label style="margin-bottom: -26px;"><?php esc_html_e( 'Email Message', 'wp-proposals' ) ?></label>
                <?php
                wp_editor( $wpp_send_proposal_message , 'wpp_send_proposal_message', array(
                    'wpautop'       => true,
                    'media_buttons' => false,
                    'textarea_name' => 'wpp_send_proposal_message',
                    'editor_class'  => 'wpp-editor-settings',
                    'textarea_rows' => 12,
                    'editor_height' => 140
                ) );
                ?>
            <p>The email message. Defaults to your settings.</p>
            </div>

            <div class="wpp-send-proposal-button-holder"><p><input type="submit" id="wpp-send-proposal" name="wpp-send-proposal" value="Send Proposal"></p></div>
        </form>


        <!-- Send proposal comfirmation message and timestamp -->
        <?php
        if (!empty($wpp_send_proposal_time) && !empty($wpp_send_proposal_email)) {
            echo "<div class='wpp-sent-comfirm-alert'>Proposal was successfully sent to $wpp_send_proposal_email at $wpp_send_proposal_time</div>";
        } elseif (!empty($wpp_send_proposal_time) && empty($wpp_send_proposal_email)) {
            echo "<div class='wpp-sent-failed-alert'>Proposal failed to send. Please make sure you have entered a valid to email address.</div>";
        } else {
            echo "";
        }
        ?>


      </div>
</div>
<?php }


// When the proposal is saved, save our data
function wpp_save_send_proposal_data( $post_id ) {

    global $post;

    if(!isset($post))
    return;

    if($post->post_status == 'publish') {
        if(defined("DOING_AJAX") AND DOING_AJAX)
            return;

        if(!current_user_can('edit_post', $post_id ))
            return;
        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'wpp_meta_box_nonce' ) ) return;
        $allowed_html = array(
                'a' => array(
                    'href' => array()
        ));

        // Update proposal data
        $send_proposal = isset( $_POST['send_proposal'] ) ? (array) $_POST['send_proposal'] : array();
        update_post_meta ($post_id, 'wpp_send_proposal_email', wp_kses( $_POST['wpp_send_proposal_email'], $allowed_html));
        update_post_meta ($post_id, 'wpp_send_proposal_subject', wp_kses( $_POST['wpp_send_proposal_subject'], $allowed_html));
        update_post_meta ($post_id, 'wpp_send_proposal_message', wp_kses( $_POST['wpp_send_proposal_message'], $allowed_html));
        update_post_meta($post_id,'send_proposal',$send_proposal);

        // Get proposal sent time
        if ( isset( $_POST['wpp-send-proposal'] ) ) {
            $blogtime = current_time( 'mysql' );
            update_post_meta($post_id,'wpp_send_proposal_time',"$blogtime");
        }

        // Ob start to send email notification
        ob_start();
            wpp_deliver_send_proposal_notification();
            wpp_send_proposal_meta_box();
        return ob_get_clean();
      }
}


// Moves the Send Proposal metabox to above the editor
function wpp_move_send_proposal() {
    # Get the globals:
    global $post, $wp_meta_boxes;

    # Output the "advanced" meta boxes:
    do_meta_boxes( get_current_screen(), 'test', $post );

    # Remove the initial "advanced" meta boxes:
    unset($wp_meta_boxes['post']['test']);
}
add_action('edit_form_after_title', 'wpp_move_send_proposal');


// Template for send proposal email notification
function wpp_deliver_send_proposal_notification() {

  	// if the submit button is clicked, send the email
  	if ( isset( $_POST['wpp-send-proposal'] ) ) {

        global $post;

    		// sanitize form values
        $wpp_company_name = get_option( 'wpp_general_company_name' );
        $admin_email = get_option('admin_email');
        $company_email = get_option('wpp_general_company_email');
        $company_website = get_option('wpp_general_company_website');
        $from_email = get_option('wpp_general_company_from_email');
        $wpp_company_logo_dark = get_option( 'wpp_general_company_logo_dark' );

        // Get custom sent proposal data
        $wpp_send_proposal_email = get_post_meta($post->ID, 'wpp_send_proposal_email', true);
        $wpp_send_proposal_subject = get_post_meta($post->ID, 'wpp_send_proposal_subject', true);
        $wpp_send_proposal_message = get_post_meta($post->ID, 'wpp_send_proposal_message', true);
        $wpp_client_term_name = wp_get_post_terms($post->ID, 'clients', array("fields" => "names"));
        if (!empty($wpp_client_term_name[0])) {
            $wpp_client_name = " $wpp_client_term_name[0]";
        } else {
            $wpp_client_name = "";
        }

        $approval_time = current_time( 'mysql' );
        list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( "([^0-9])", $approval_time );

        // Checks to see if a company email has been added. If not use WordPress admin email for notifications
        if (!empty($company_email)) { $wpp_notification_email = $company_email; } else { $wpp_notification_email = $admin_email; }

        // Checks to see if a from email has been added. If not use WordPress admin email for notifications
        if (!empty($from_email)) { $wpp_from_email = $from_email; } else { $wpp_from_email = $admin_email; }

    		// Send Proposal Email Template
        $to = $wpp_send_proposal_email;
        $subject = $wpp_send_proposal_subject;
        $body = "
        <html>
            <div class='email_header' style='text-align: center; background-color: #ffffff; border: 1px solid #ecedef; padding-top: 30px; padding-bottom: 8px;'>
                <div><img style='margin-top: 16px; width: auto; height: auto;' src='$wpp_company_logo_dark' alt='$wpp_company_name-logo' /></div>
                    <div class='email_container' style='text-align: left; background-color: #fff; max-width: 768px; margin: 0 auto; left: 50%; margin-bottom: 60px;'>
                    <div class='email-details' style='text-align: left; background-color: #ffffff; padding: 40px; padding-top: 25px; padding-bottom: 0px;'>
                        <p class='email_title welcome' style='font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; padding-bottom: 5px; font-size: 18px; color: #3a5057; line-height: 30px; font-weight: 400; margin: 0px; font-style: normal;'>Hello$wpp_client_name,</p>
                        <p class='email_title message' style='line-height: 29px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #53616a; font-size: 16.5px; margin-top: 10px; margin-bottom: 40px;'>$wpp_send_proposal_message</p>
            </div>

                <p style='text-align: center; line-height: 18px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #53616a; font-size: 13px;  text-transform: uppercase;'>Click to view proposal details</p>

            <div class='invoice-details' style='text-align: center; border-top: 0px solid #720af1; background-color: #f4f5f8; padding: 40px; padding-top: 25px; padding-bottom: 23px; max-width: 768px; margin: 0 auto; left: 50%; margin-bottom: 0px;'>
                <a href='" . get_permalink( $post->ID ) . "' style='font-size: 18px; line-height: 55px; margin-top: 25px; margin-bottom: 25px; display: inline-block; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #fff; background-color: #01c2aa; background: #01c2aa; padding-left: 45px; padding-right: 45px; text-align: center; text-decoration: none;'>View Proposal</a>
            </div>

            <div class='billed-details' style='text-align: center; border-top: 0px solid #0c2129; background-color: #0c2129; padding: 40px; padding-top: 10px; padding-bottom: 10px; max-width: 768px; margin: 0 auto; left: 50%; margin-bottom: 30px;'>
                <p class='email_title message' style='font-size: 15px; font-family: Roboto,RobotoDraft,Helvetica,Roboto,RobotoDraft,Helvetica,Arial,sans-serif,sans-serif; color: #ffffff;'>Proposal created by $wpp_company_name</p>
            </div>

                <p style='text-align: center; line-height: 17px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #6b6c72; font-size: 14px;'>Proposal sent from <a href='$company_website' target='_blank'>$company_website</a></p>

                </div>
            </div>
        </html>
        ";

        $headers = array("Content-Type: text/html; charset=UTF-8", "From: $wpp_company_name <$wpp_from_email>" . "\r\n");

        wp_mail( $to, $subject, $body, $headers );

  	}
}
