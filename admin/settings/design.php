<?php


// Welcome Page Content
add_action( 'wpp_settings_content', 'wpp_render_design_page' );

function wpp_render_design_page() {
global $wpp_active_tab;
		if ( '' || 'design' != $wpp_active_tab )
		return;
?>

	 <h3><?php _e( 'Fonts & Colors', 'wpp' ); ?></h3>

	 <form action="options.php" method="post">

			 <?php
	     settings_fields('wpp-design-settings');
			 do_settings_sections( 'wpp-design-settings' );
		   ?>

			     <!-- Design settings options -->
					 <div class="wpp-form-message"><?php settings_errors('wpp-notices'); ?></div>

					 <div class="wpp-inner-wrapper">


							 <table class="form-table">
									 <tbody>

												<tr>
												<th>Font Family</th>
												<td><select name="wpp_design_font_family">
												<option value="Roboto" <?php selected(get_option('wpp_design_font_family'), "Roboto"); ?>>Roboto</option>
												<option value="Lato" <?php selected(get_option('wpp_design_font_family'), "Lato"); ?>>Lato</option>
												<option value="Montserrat" <?php selected(get_option('wpp_design_font_family'), "Montserrat"); ?>>Montserrat</option>
												<option value="Muli" <?php selected(get_option('wpp_design_font_family'), "Muli"); ?>>Muli</option>
												<option value="Open Sans" <?php selected(get_option('wpp_design_font_family'), "Open Sans"); ?>>Open Sans</option>
												<option value="Oswald" <?php selected(get_option('wpp_design_font_family'), "Oswald"); ?>>Oswald</option>
												<option value="Poppins" <?php selected(get_option('wpp_design_font_family'), "Poppins"); ?>>Poppins</option>
												<option value="Raleway" <?php selected(get_option('wpp_design_font_family'), "Raleway"); ?>>Raleway</option>
												<option value="Ubuntu" <?php selected(get_option('wpp_design_font_family'), "Ubuntu"); ?>>Ubuntu</option>
												<option value="Source Sans Pro" <?php selected(get_option('wpp_design_font_family'), "Source Sans Pro"); ?>>Source Sans Pro</option>
												<option value="Merriweather" <?php selected(get_option('wpp_design_font_family'), "Merriweather"); ?>>Merriweather</option>
												<option value="PT Sans" <?php selected(get_option('wpp_design_font_family'), "PT Sans"); ?>>PT Sans</option>
												<option value="Noto Sans" <?php selected(get_option('wpp_design_font_family'), "Noto Sans"); ?>>Noto Sans</option>
												<option value="Rubik" <?php selected(get_option('wpp_design_font_family'), "Rubik"); ?>>Rubik</option>
												<option value="Arimo" <?php selected(get_option('wpp_design_font_family'), "Arimo"); ?>>Arimo</option>
												<option value="Theme Default" <?php selected(get_option('wpp_design_font_family'), "Theme Default"); ?>>Theme Default</option>
												</select>
												<p>Choose a font family for the proposals.</p>
												</td>
												</tr>

												<tr>
												<th>Featured Image Overlay Color
												</th>
												<td><input type="text" placeholder="" class="color-field" name="wpp_design_title_overlay" value="<?php echo esc_attr( get_option('wpp_design_title_overlay') ); ?>" size="50" />
												<p>Choose the proposal featured image overlay color.</p>
												</td>
												</tr>

												<tr>
												<th>Featured Image Overlay Opacity</th>
												<td>
												<input type="text" placeholder="" name="wpp_design_title_overlay_opacity" value="<?php echo esc_attr( get_option('wpp_design_title_overlay_opacity') ); ?>" size="8" />
												<p>
												Change the opacity of the overlay. 0 is hidden 1 is a solid color. (default 0.8)
												</p>
												</td>
												</tr>

												<tr>
												<th>Featured Image Text Color
												</th>
												<td><input type="text" placeholder="" class="color-field" name="wpp_design_title_text_color" value="<?php echo esc_attr( get_option('wpp_design_title_text_color') ); ?>" size="50" />
												<p>Define color for the featured image heading and intro text.</p>
												</td>
												</tr>

                        <tr>
												<th>H2 Style
												<p>Define style for H2 heading</p>
												</th>
												<td>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" class="color-field" name="wpp_design_heading_h2_color" value="<?php echo esc_attr( get_option('wpp_design_heading_h2_color') ); ?>" size="50" />
												<p>Text Color</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_heading_h2_size" value="<?php echo esc_attr( get_option('wpp_design_heading_h2_size') ); ?>" size="9" />
												<p>Font Size (px)</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_heading_h2_height" value="<?php echo esc_attr( get_option('wpp_design_heading_h2_height') ); ?>" size="9" />
												<p>Line Height (px)</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_heading_h2_weight" value="<?php echo esc_attr( get_option('wpp_design_heading_h2_weight') ); ?>" size="9" />
												<p>Font Weight</p>
												</div>
												</td>
												</tr>

												<tr>
												<th>H3 Style
												<p>Define style for H3 heading</p>
												</th>
												<td>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" class="color-field" name="wpp_design_heading_h3_color" value="<?php echo esc_attr( get_option('wpp_design_heading_h3_color') ); ?>" size="50" />
												<p>Text Color</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_heading_h3_size" value="<?php echo esc_attr( get_option('wpp_design_heading_h3_size') ); ?>" size="9" />
												<p>Font Size (px)</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_heading_h3_height" value="<?php echo esc_attr( get_option('wpp_design_heading_h3_height') ); ?>" size="9" />
												<p>Line Height (px)</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_heading_h3_weight" value="<?php echo esc_attr( get_option('wpp_design_heading_h3_weight') ); ?>" size="9" />
												<p>Font Weight</p>
												</div>
												</td>
												</tr>

                        <tr>
												<th>Paragraph Text
												<p>Define style for paragraph text</p>
												</th>
												<td>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" class="color-field" name="wpp_design_text_color" value="<?php echo esc_attr( get_option('wpp_design_text_color') ); ?>" size="50" />
												<p>Text Color</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_text_size" value="<?php echo esc_attr( get_option('wpp_design_text_size') ); ?>" size="9" />
												<p>Font Size (px)</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_text_height" value="<?php echo esc_attr( get_option('wpp_design_text_height') ); ?>" size="9" />
												<p>Line Height (px)</p>
												</div>
												<div class="wpp-inline-option">
												<input type="text" placeholder="" name="wpp_design_text_weight" value="<?php echo esc_attr( get_option('wpp_design_text_weight') ); ?>" size="9" />
												<p>Font Weight</p>
												</div>
												</td>
												</tr>

									 <tr class="wpp-title-holder">
									 <th><h2 class="wpp-inner-title">Layout</h2></th>
									 </tr>

									 <tr>
									 <th>Default Featured Image</th>
									 <td>
											 <div>
													 <input type="text" name="wpp_design_title_background" id="image_url_two" value="<?php echo esc_attr( get_option('wpp_design_title_background') ); ?>" size="50" >
													 <input type="button" name="upload-btn-two" id="upload-btn-two" class="button-secondary" value="Upload Image">
											 </div>
                   <p>Choose a default featured image for the proposals.</p>
									 </td>
									 </tr>

                   <tr>
                   <th>Initial Width of Content</th>
                   <td>
                       <select name="wpp_design_content_width">
												 		<option value="Default" <?php selected(get_option('wpp_design_content_width'), "Default"); ?>>Default</option>
                           <option value="700px" <?php selected(get_option('wpp_design_content_width'), "700px"); ?>>700px</option>
                           <option value="800px" <?php selected(get_option('wpp_design_content_width'), "800px"); ?>>800px</option>
                           <option value="900px" <?php selected(get_option('wpp_design_content_width'), "900px"); ?>>900px</option>
                           <option value="1000px" <?php selected(get_option('wpp_design_content_width'), "1000px"); ?>>1000px</option>
                       </select>
                   <p>Choose the initial width of content which is in grid. (default 800px)</p>
                   </td>
                   </tr>

									 <tr>
									 <th>Content Editor Full Width</th>
									 <td><label class="wpp-switch"><input type="checkbox" name="wpp_design_content_editor_width" value="wpp_design_content_editor_width" <?php checked( 'wpp_design_content_editor_width', get_option( 'wpp_design_content_editor_width' ) ); ?> /><span class="wpp-slider round"></span></label>Enable
									 <p>Click ON to make the conent editor section full width. This is useful if you're using a page builder for custom sections.</p>
									 </td>
									 </tr>

                   <tr>
                   <th>Section Padding</th>
                   <td>
                   <input type="text" placeholder="" name="wpp_design_section_padding" value="<?php echo esc_attr( get_option('wpp_design_section_padding') ?: '85' ); ?>" size="8" /><span> px</span>
                   <p>Change the section top and bottom padding for the proposals. (default 85px)</p>
                   </td>
                   </tr>

                   <tr>
                   <th>Hide Print Section</th>
                   <td><label class="wpp-switch"><input type="checkbox" name="wpp_design_hide_print" value="wpp_design_hide_print" <?php checked( 'wpp_design_hide_print', get_option( 'wpp_design_hide_print' ) ); ?> /><span class="wpp-slider round"></span></label>Enable
                   <p>If you wish to not allow your clients to print their proposals, toggle on to hide the print section from the proposal template.</p>
                   </td>
                   </tr>

                   <tr>
                   <th>Hide Share Section</th>
                   <td><label class="wpp-switch"><input type="checkbox" name="wpp_design_hide_share" value="wpp_design_hide_share" <?php checked( 'wpp_design_hide_share', get_option( 'wpp_design_hide_share' ) ); ?> /><span class="wpp-slider round"></span></label>Enable
                   <p>If you wish to not allow your clients to share their proposals, toggle on to hide the share section from the proposal template.</p>
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
