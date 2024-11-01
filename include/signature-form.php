<?php

// Template for approval form
function wpp_signature_form() {
    if ( has_term('Pending','proposal_status' ) ) {
      	echo '<form id="approval-form" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
      	echo '<p class="wpp-form-label"><p class="wpp-form-label">';
      	echo  _e('<p>To Accept, Type Your Full Name Below</p>', 'wp-proposals');
      	echo '<input type="text" name="wpp-signature" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["wpp-signature"] ) ? esc_attr( $_POST["wpp-signature"] ) : '' ) . '" />';
      	echo '</p>';
      	echo '<div class="wpp-approval-button-holder"><p><input type="submit" id="wpp-approved" name="wpp-approved" value="Accept"></p></div>';
      	echo '</form>';
    } else if ( has_term('Approved','proposal_status' ) ) {
    		echo "<div class='wpp-approved-message'><p>This proposal has already been approved!</p></div>";
    }
}


// Template for approval email notification
function wpp_deliver_notification() {

  	// if the submit button is clicked, send the email
  	if ( isset( $_POST['wpp-approved'] ) ) {

        global $post;
    		// sanitize form values
    		$name    = sanitize_text_field( $_POST["wpp-signature"] );
        $wpp_company_name = get_option( 'wpp_general_company_name' );
        $admin_email = get_option('admin_email');
        $company_email = get_option('wpp_general_company_email');
        $from_email = get_option('wpp_general_company_from_email');
        $wpp_comfirmation_message = get_option('wpp_general_comfirmation_message');
        $pricing_total = get_post_meta($post->ID, 'wpp_pricing_total', true);
        $wpp_company_logo_dark = get_option( 'wpp_general_company_logo_dark' );
        $wpp_currency = get_option('wpp_misc_currency');

        $approval_time = current_time( 'mysql' );
        list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( "([^0-9])", $approval_time );

        // Checks to see if a company email has been added. If not use WordPress admin email for notifications
        if (!empty($company_email)) { $wpp_notification_email = $company_email; } else { $wpp_notification_email = $admin_email; }

        // Checks to see if a from email has been added. If not use WordPress admin email for notifications
        if (!empty($from_email)) { $wpp_from_email = $from_email; } else { $wpp_from_email = $admin_email; }

    		// get the blog administrator's email address
        $to = $wpp_notification_email;
        $subject = "Proposal approved by: $name | $wpp_company_name";
        $body = "<html><div class='email_header' style='text-align: center; background-color: #ffffff; border: 1px solid #ecedef; padding-top: 30px; padding-bottom: 8px;'>
        <div><img style='margin-top: 16px; width: auto; height: auto;' src='$wpp_company_logo_dark' alt='$wpp_company_name-logo' /></div>
        <div class='email_container' style='text-align: left; background-color: #fff; max-width: 768px; margin: 0 auto; left: 50%; margin-bottom: 60px;'>
        <div class='email-details' style='text-align: left; background-color: #ffffff; padding: 40px; padding-top: 25px; padding-bottom: 0px;'>
        <p class='email_title welcome' style='font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; padding-bottom: 5px; font-size: 18px; color: #3a5057; line-height: 30px; font-weight: 400; margin: 0px; font-style: normal;'>Hello $wpp_company_name,</p>
        <p class='email_title title' style='font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 18px; color: #720af1; line-height: 30px; font-weight: 400; margin: 0px; margin-top: -4px; padding-bottom: 10px; font-style: normal;'>Proposal Status: <strong style='font-weight: 600px;'>Approved</strong></p>
        <p class='email_title message' style='line-height: 29px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #53616a; font-size: 16.5px; margin-top: 10px; margin-bottom: 40px;'>Congratulations! Your proposal has been approved by $name. For more information about this proposal view the proposal details below.</p>

        </div>
        <p style='text-align: center; line-height: 18px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #53616a; font-size: 13px;'>PROPOSAL DETAILS</p>

        <div class='invoice-details' style='text-align: center; border-top: 0px solid #720af1; background-color: #f4f5f8; padding: 40px; padding-top: 35px; padding-bottom: 23px; max-width: 768px; margin: 0 auto; left: 50%; margin-bottom: 0px;'>
        <p class='email_title message' style='font-size: 15px; font-family: Roboto,RobotoDraft,Helvetica,Roboto,RobotoDraft,Helvetica,Arial,sans-serif,sans-serif; color: #393a3d; text-transform: uppercase; font-weight: bold;'>Proposal Signed at $hour:$minute  on $today_month/$today_day/$today_year</p>
        <p class='email_title message' style='font-size: 45px; line-height: 0px; padding-bottom: 5px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #393a3d;'>$wpp_currency$pricing_total</p>

        </div>
        <div class='billed-details' style='text-align: center; border-top: 0px solid #0c2129; background-color: #0c2129; padding: 40px; padding-top: 10px; padding-bottom: 10px; max-width: 768px; margin: 0 auto; left: 50%; margin-bottom: 30px;'>
        <p class='email_title message' style='font-size: 15px; font-family: Roboto,RobotoDraft,Helvetica,Roboto,RobotoDraft,Helvetica,Arial,sans-serif,sans-serif; color: #ffffff;'>Proposal signed by $name</p>

        </div>
        <p style='text-align: center; line-height: 17px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; color: #6b6c72; font-size: 14px;'>Proposal created by $wpp_company_name</p>

        </div>
        </div>
        </html>";

        $headers = array("Content-Type: text/html; charset=UTF-8", "From: $wpp_company_name <$wpp_from_email>" . "\r\n");

        wp_mail( $to, $subject, $body, $headers );

  	}
}


// Set proposal to Approved status once e-signature has been captured
function wpp_approval_status() {
    // if the submit button is clicked, send the email
    if ( isset( $_POST['wpp-approved'] ) ) {
    		global $post;
        // Check if the proposal is set to Pending taxonomy
        if(is_object_in_term( 'Pending', 'proposal_status', $post->ID )){
            // Assign Approved term to the proposal
            wp_set_object_terms( $post->ID, 'Approved', 'proposal_status', false );
        }
    }
}


// Create approval form shortcode
function wpp_signature_form_shortcode() {
  	ob_start();
    wpp_deliver_notification();
    wpp_signature_form();
  	wpp_approval_status();

  	return ob_get_clean();
}
add_shortcode( 'wpp_signature_form', 'wpp_signature_form_shortcode' );


// Create approval form success message shortcode
function wpp_approval_form_success_shortcode() {
    global $post;
    $wpp_comfirmation_message = get_option('wpp_general_comfirmation_message');
    $wpp_misc_invoice_url = get_option('wpp_misc_invoice_url');
      	if ( isset( $_POST['wpp-approved'] ) ) {
          	if ( has_term('Pending','proposal_status' ) ) {
                if (!empty($wpp_comfirmation_message)) {
                    echo "<div class='wpp-top-success-message'><p>$wpp_comfirmation_message</p></div>";
                } else {
                echo "<div class='wpp-top-success-message'><p>We are honored to get the pleasure to work with you. We’ll be in touch with you about your invoice details and the next steps to begin.</p></div>";
                }

                // Redirect to Invoice URl if not empty
                $wpp_invoice_url = get_the_terms( $post->ID, 'proposal_invoice');
                if (is_array($wpp_invoice_url) && !empty($wpp_invoice_url)) {
                    if (empty($wpp_misc_invoice_url)) {
                        $wpp_invoice_url = array_shift( $wpp_invoice_url );
                        echo "<script type='text/javascript'>
                              	setTimeout(function() {
                              	   window.location = '$wpp_invoice_url->name';
                              	}, 1000); // 1 second delay
                              </script>";
                    }
                } else {
                    // Do nothing
                }
          	}
      	}
}
add_shortcode( 'wpp_approval_form_success', 'wpp_approval_form_success_shortcode' );
