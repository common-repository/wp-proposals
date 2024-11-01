<?php


// Welcome Page Content
add_action( 'wpp_settings_content', 'wpp_render_general_page' );

function wpp_render_general_page() {
global $wpp_active_tab;
		if ( '' || 'general' != $wpp_active_tab )
			return;
?>

		<h3><?php _e( 'Company Details', 'wpp' ); ?></h3>

		<form action="options.php" method="post">

				<?php
				settings_fields('wpp-general-settings');
				do_settings_sections( 'wpp-general-settings' );
				$wpp_general_company_about = get_option( 'wpp_general_company_about' );
				$wpp_general_company_terms = get_option( 'wpp_general_company_terms' );
				$wpp_general_send_proposal_message = get_option( 'wpp_general_send_proposal_message' );
				$admin_email = get_option('admin_email');
				$blogname = get_option('blogname');
				$blog_url = get_site_url();

				// Set default value is option is empty
				if (empty($wpp_general_send_proposal_message)) {
						$wpp_general_send_proposal_message = 'Thank you for the opportunity to be a partner in this exciting new adventure of yours. We are very excited to see your vision become a reality and I would be grateful to be a part of the process. Click below to view the proposal we have put together for you.';
				}


				?>

						<!-- General settings options -->
						<div class="wpp-form-message"><?php settings_errors('wpp-notices'); ?></div>

						<div class="wpp-inner-wrapper">
						<p class="wpp-settings-desc">To get started, fill in your companies information below which will be used to brand and personalize your proposals.</p>


								<table class="form-table">
										<tbody>

										<tr>
										<th>Company Name</th>
										<td><input type="text" placeholder="" name="wpp_general_company_name" value="<?php echo esc_attr( get_option('wpp_general_company_name') ?: $blogname ); ?>" size="50" >
										</td>
										</tr>

										<tr>
										<th>Website URL</th>
										<td><input type="text" placeholder="" name="wpp_general_company_website" value="<?php echo esc_attr( get_option('wpp_general_company_website') ?: $blog_url ); ?>" size="50" >
										</td>
										</tr>

										<tr>
										<th>Light Logo</th>
										<td>
												<div>
														<input type="text" name="wpp_general_company_logo" id="image_url" value="<?php echo esc_attr( get_option('wpp_general_company_logo') ); ?>" size="50" >
														<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
												</div>
                    <p>Upload a "light" logo to display on the proposal featured image section.</p>
										</td>
										</tr>

										<tr>
										<th>Dark Logo</th>
										<td>
												<div>
														<input type="text" name="wpp_general_company_logo_dark" id="image_url_three" value="<?php echo esc_attr( get_option('wpp_general_company_logo_dark') ); ?>" size="50" >
														<input type="button" name="upload-btn-three" id="upload-btn-three" class="button-secondary" value="Upload Image">
												</div>
                    <p>Upload a "dark" logo to display on the about section of proposals, and email notifications.</p>
										</td>
										</tr>

										<tr>
										<th>
										About Information
										<p>Want to showcase your business? Write an about us section to display at the bottom of your proposals.</p>
								    </th>

										<td class="wpp-custom-content">
										<?php
										wp_editor( $wpp_general_company_about , 'wpp_general_company_about', array(
												'wpautop'       => true,
												'media_buttons' => true,
												'textarea_name' => 'wpp_general_company_about',
												'editor_class'  => 'wpp-editor-settings',
												'textarea_rows' => 12
										) );
										?>
										</td>
										</tr>


										<tr>
										<th>
										Terms and Conditions
										<p>Add your terms and conditions to your proposals. This will be displayed in an expanded tab so add as much information as you need.</p>
								    </th>

										<td class="wpp-custom-content">
										<?php
										wp_editor( $wpp_general_company_terms , 'wpp_general_company_terms', array(
												'wpautop'       => true,
												'media_buttons' => true,
												'textarea_name' => 'wpp_general_company_terms',
												'editor_class'  => 'wpp-editor-settings',
												'textarea_rows' => 12
										) );
										?>
										</td>
										</tr>


									 <tr class="wpp-title-holder">
 									 <th><h2 class="wpp-inner-title">Send Proposal Email</h2></th>
 									 </tr>

 									 <tr>
 									 <th>From Email</th>
 									 <td><input type="text" placeholder="" name="wpp_general_send_proposal_from_email" value="<?php echo esc_attr( get_option('wpp_general_send_proposal_from_email') ?: "$admin_email" ); ?>" size="50" >
 									 <p>Default sets to the main WordPress admin email. Change if email provider is flagging or junking emails.</p>
 									 </td>
 									 </tr>

 									 <tr>
 									 <th>Default Subject</th>
 									 <td><input type="text" placeholder="" name="wpp_general_send_proposal_subject" value="<?php echo esc_attr( get_option('wpp_general_send_proposal_subject') ?: "Proposal by $blogname" ); ?>" size="50" >
 									 <p>Create a default subject when sending proposals to a client.</p>
 									 </td>
 									 </tr>

                   <tr>
                   <th>
                   Default Message
                   <p>The email message your client will recieve when you send them their proposal to view online. You can create a custom message for each individual proposal on the edit proposal page.</p>
                   </th>

                   <td class="wpp-custom-content">
                   <?php
                   wp_editor( $wpp_general_send_proposal_message , 'wpp_general_send_proposal_message', array(
                       'wpautop'       => true,
                       'media_buttons' => true,
                       'textarea_name' => 'wpp_general_send_proposal_message',
                       'editor_class'  => 'wpp-editor-settings',
                       'textarea_rows' => 12
                   ) );
                   ?>
                   </td>
                   </tr>


									 <tr class="wpp-title-holder">
 									 <th><h2 class="wpp-inner-title">Approval Notification</h2></th>
 									 </tr>

									 <tr>
									 <th>Send to Email</th>
									 <td><input type="text" placeholder="" name="wpp_general_company_email" value="<?php echo esc_attr( get_option('wpp_general_company_email') ?: "$admin_email" ); ?>" size="50" >
									 <p>Email address the approval notifications should be sent to. Seperate multiple email's with a comma.</p>
								 	 </td>
									 </tr>

									 <tr>
									 <th>From Email</th>
									 <td><input type="text" placeholder="" name="wpp_general_company_from_email" value="<?php echo esc_attr( get_option('wpp_general_company_from_email') ?: "$admin_email" ); ?>" size="50" >
									 <p>Default sets to the main WordPress admin email. Change if email provider is flagging or junking notifications.</p>
								 	 </td>
									 </tr>

									 <tr>
									 <th>Approval Comfirmation Message</th>
									 <td><textarea rows="2" cols="100" type="textarea" placeholder="" name="wpp_general_comfirmation_message" value="<?php echo esc_attr( get_option('wpp_general_comfirmation_message') ); ?>" /><?php echo esc_attr( get_option('wpp_general_comfirmation_message') ?: 'We are honored to get the pleasure to work with you. We’ll be in touch with you about your invoice details and the next steps to begin.' ); ?></textarea>
									 <p>Customize the approval form comfirmation message once a proposal has been approved.</p>
									 </td>
									 </tr>

										<tr>
										<th class="wpp-save-section dashboard">
										<?php submit_button(); ?>
										</th>
										</tr>

										</tbody>
						 		</table>
					</div>
    </form>
<?php }
