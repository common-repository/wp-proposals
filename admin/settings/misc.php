<?php


// Render misc settings page
add_action( 'wpp_settings_content', 'wpp_render_misc_page' );

function wpp_render_misc_page() {
		global $wpp_active_tab;
				if ( '' || 'misc' != $wpp_active_tab )
				return;
?>

	 <h3><?php _e( 'Misc Settings', 'wpp' ); ?></h3>

	 <form action="options.php" method="post">

			 <?php
	     settings_fields('wpp-misc-settings');
			 do_settings_sections( 'wpp-misc-settings' );
		   ?>

					 <!-- Misc settings options -->
					 <div class="wpp-form-message"><?php settings_errors('wpp-notices'); ?></div>

					 <div class="wpp-inner-wrapper">

							 <table class="form-table">
									 <tbody>


                       <tr>
                       <th>Currency</th>
                       <td>
                           <select name="wpp_misc_currency">
                           			<option value="$" <?php selected(get_option('wpp_misc_currency'), "$"); ?>>United States (US) dollar ($)</option>
                              	<option value="€" <?php selected(get_option('wpp_misc_currency'), "€"); ?>>Euro (€)</option>
																<option value="-" <?php selected(get_option('wpp_misc_currency'), "-"); ?>>Hide Currency Symbol</option>
                           </select>
                       <p>This controls what currency prices are listed as on proposals and emails.</p>
                       </td>
                       </tr>

											 <tr>
											 <th>Hide Reminder</th>
											 <td><label class="wpp-switch"><input type="checkbox" name="wpp_misc_hide_reminder" value="wpp_misc_hide_reminder" <?php checked( 'wpp_misc_hide_reminder', get_option( 'wpp_misc_hide_reminder' ) ); ?> /><span class="wpp-slider round"></span></label>Hide
											 <p>Click ON to hide the custom proposal sections reminder on the edit proposal page.</p>
											 </td>
											 </tr>

											 <tr>
											 <th>Disable View Count</th>
											 <td><label class="wpp-switch"><input type="checkbox" name="wpp_misc_view_count" value="wpp_misc_view_count" <?php checked( 'wpp_misc_view_count', get_option( 'wpp_misc_view_count' ) ); ?> /><span class="wpp-slider round"></span></label>Disable
											 <p>Click ON to disable the proposal view count.</p>
											 </td>
											 </tr>

											 <tr>
											 <th>Disable Invoice URL</th>
											 <td><label class="wpp-switch"><input type="checkbox" name="wpp_misc_invoice_url" value="wpp_misc_invoice_url" <?php checked( 'wpp_misc_invoice_url', get_option( 'wpp_misc_invoice_url' ) ); ?> /><span class="wpp-slider round"></span></label>Disable
											 <p>If you will not be using the Invoice URL feature, you can click ON here to disable it.</p>
											 </td>
											 </tr>

											 <tr>
											 <th>Disable Share Proposal</th>
											 <td><label class="wpp-switch"><input type="checkbox" name="wpp_misc_share_proposal" value="wpp_misc_share_proposal" <?php checked( 'wpp_misc_share_proposal', get_option( 'wpp_misc_share_proposal' ) ); ?> /><span class="wpp-slider round"></span></label>Disable
											 <p>If you want to disable the share proposal section on the bottom of the proposals, click ON here.</p>
											 </td>
											 </tr>

											 <tr>
											 <th>Display Footer</th>
											 <td><label class="wpp-switch"><input type="checkbox" name="wpp_misc_display_footer" value="wpp_misc_display_footer" <?php checked( 'wpp_misc_display_footer', get_option( 'wpp_misc_display_footer' ) ); ?> /><span class="wpp-slider round"></span></label>Enable
											 <p>Click ON to display your websites footer on proposals.</p>
											 </td>
											 </tr>

											 <tr>
	 										 <th>Hide Footer Section</th>
	 									   <td><input type="text" placeholder="Example: .footer_top" name="wpp_misc_hide_footer" value="<?php echo esc_attr( get_option('wpp_misc_hide_footer') ); ?>" size="50" >
											 <p>If you have the footer enabled enter the footer CSS class name to hide a specific footer section from proposals. We took this approach since every theme is different, and it allows you to keep certain sections like the .footer_bottom for example. To add multiple class names seperate by comma.</p>
											 </td>
	 										 </tr>

											 <tr>
                       <th>Proposal Custom CSS:
                       <p>Enter your custom frontend CSS here.</p>
                       </th>
                       <td><textarea rows="14" cols="100" type="textarea" placeholder="" name="wpp_misc_custom_css" value="<?php echo esc_attr( get_option('wpp_misc_custom_css') ); ?>" /><?php echo esc_attr( get_option('wpp_misc_custom_css') ); ?></textarea>
                       <p>In case if you need to overwrite any CSS, you can add !important at the end of the CSS property. eg: color: #da2234!important;</p>
                       </td>
                       </tr>

									 <tr>
									 <th class="wpp-save-section">
									 <?php submit_button(); ?>
									 </th>
									 </tr>

									 </tbody>
							 </table>
					</div>
		</form>
<?php }
