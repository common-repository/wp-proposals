<?php


// Welcome Page Content

add_action( 'wpp_settings_content', 'wpp_render_language_page' );

function wpp_render_language_page() {
	global $wpp_active_tab;
	if ( '' || 'language' != $wpp_active_tab )
		return;
	?>

	 <h3><?php _e( 'Language Settings', 'wpp' ); ?></h3>

   <form action="options.php" method="post">

   <?php
      settings_fields('wpp-lang-settings');
			do_settings_sections( 'wpp-lang-settings' );
    ?>

		<!-- Dashboard Styling Option Section -->
		 <div class="wpp-form-message"><?php settings_errors('wpp-notices'); ?></div>

		 <div class="wpp-inner-wrapper">
     <p class="wpp-settings-desc">If you would like to customize the default verbage of the proposals you can do so here. You also have the ability to customize most of these options on a per proposal basis.</p>

		 <!-- <p>The dashboard styling option makes it easy for you to brand the Wordpress dashboard to match your website. You can also white label Wordpress by removing any Wordpress reference.</p> -->
		 <table class="form-table">
					 <tbody>


              <tr>
              <th>Proposal presented by</th>
              <td><input type="text" placeholder="" name="wpp_lang_presented_by" value="<?php echo esc_attr( get_option('wpp_lang_presented_by') ); ?>" size="50" >
              </td>
              </tr>

							<tr>
							<th>Scope of Services</th>
							<td><input type="text" placeholder="" name="wpp_lang_scope_services" value="<?php echo esc_attr( get_option('wpp_lang_scope_services') ); ?>" size="50" >
							</td>
							</tr>

              <tr>
							<th>Additional Recommendations</th>
							<td><input type="text" placeholder="" name="wpp_lang_recommendations" value="<?php echo esc_attr( get_option('wpp_lang_recommendations') ); ?>" size="50" >
							</td>
							</tr>

              <tr>
							<th>Timeline</th>
							<td><input type="text" placeholder="" name="wpp_lang_timeline" value="<?php echo esc_attr( get_option('wpp_lang_timeline') ); ?>" size="50" >
							</td>
							</tr>

              <tr>
							<th>Your Investment</th>
							<td><input type="text" placeholder="" name="wpp_lang_investment" value="<?php echo esc_attr( get_option('wpp_lang_investment') ); ?>" size="50" >
							</td>
							</tr>

              <tr>
							<th>Approve Proposal</th>
							<td><input type="text" placeholder="" name="wpp_lang_approve_proposal" value="<?php echo esc_attr( get_option('wpp_lang_approve_proposal') ); ?>" size="50" >
							</td>
							</tr>

              <tr>
							<th>Terms and Conditions</th>
							<td><input type="text" placeholder="" name="wpp_lang_terms" value="<?php echo esc_attr( get_option('wpp_lang_terms') ); ?>" size="50" >
							</td>
							</tr>

							<tr>
							<th>Approve Proposal Details
							<p>If you would like to join us and become a client then we’d be delighted to have you.</p></th>
							<td><textarea rows="2" cols="100" type="textarea" placeholder="" name="wpp_lang_approve_proposal_details" value="<?php echo esc_attr( get_option('wpp_lang_approve_proposal_details') ); ?>" /><?php echo esc_attr( get_option('wpp_lang_approve_proposal_details') ); ?></textarea>
							</td>
							</tr>

							<tr>
							<th class="wpp-save-section dashboard">
							<?php submit_button(); ?>
							</th>
							</tr>

				   </table>

    </div>
    </form>

	<?php
}
