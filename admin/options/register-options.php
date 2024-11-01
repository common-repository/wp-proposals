<?php


// Register options hook
add_action( 'wpp_create_options', 'wpp_register_options', 1 );
function wpp_register_options() {


// Register General Settings Fields
register_setting( 'wpp-general-settings', 'wpp_general_company_name' );
register_setting( 'wpp-general-settings', 'wpp_general_company_logo' );
register_setting( 'wpp-general-settings', 'wpp_general_company_logo_dark' );
register_setting( 'wpp-general-settings', 'wpp_general_company_website' );
register_setting( 'wpp-general-settings', 'wpp_general_company_phone' );
register_setting( 'wpp-general-settings', 'wpp_general_company_email' );
register_setting( 'wpp-general-settings', 'wpp_general_company_from_email' );
register_setting( 'wpp-general-settings', 'wpp_general_company_address' );
register_setting( 'wpp-general-settings', 'wpp_general_company_about' );
register_setting( 'wpp-general-settings', 'wpp_general_company_terms' );
register_setting( 'wpp-general-settings', 'wpp_general_comfirmation_message' );
register_setting( 'wpp-general-settings', 'wpp_general_send_proposal_from_email' );
register_setting( 'wpp-general-settings', 'wpp_general_send_proposal_subject' );
register_setting( 'wpp-general-settings', 'wpp_general_send_proposal_message' );


// Register Design Settings Fields
register_setting( 'wpp-design-settings', 'wpp_design_title_background' );
register_setting( 'wpp-design-settings', 'wpp_design_title_overlay' );
register_setting( 'wpp-design-settings', 'wpp_design_title_overlay_opacity' );
register_setting( 'wpp-design-settings', 'wpp_design_title_text_color' );
register_setting( 'wpp-design-settings', 'wpp_design_font_family' );
register_setting( 'wpp-design-settings', 'wpp_design_content_width' );
register_setting( 'wpp-design-settings', 'wpp_design_content_editor_width' );
register_setting( 'wpp-design-settings', 'wpp_design_section_padding' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h2_color' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h2_size' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h2_height' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h2_weight' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h3_color' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h3_size' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h3_height' );
register_setting( 'wpp-design-settings', 'wpp_design_heading_h3_weight' );
register_setting( 'wpp-design-settings', 'wpp_design_text_color' );
register_setting( 'wpp-design-settings', 'wpp_design_text_size' );
register_setting( 'wpp-design-settings', 'wpp_design_text_height' );
register_setting( 'wpp-design-settings', 'wpp_design_text_weight' );
register_setting( 'wpp-design-settings', 'wpp_design_hide_print' );
register_setting( 'wpp-design-settings', 'wpp_design_hide_share' );


// Register Language Settings Fieldss
register_setting( 'wpp-lang-settings', 'wpp_lang_presented_by');
register_setting( 'wpp-lang-settings', 'wpp_lang_scope_services');
register_setting( 'wpp-lang-settings', 'wpp_lang_recommendations');
register_setting( 'wpp-lang-settings', 'wpp_lang_timeline');
register_setting( 'wpp-lang-settings', 'wpp_lang_investment');
register_setting( 'wpp-lang-settings', 'wpp_lang_approve_proposal');
register_setting( 'wpp-lang-settings', 'wpp_lang_approve_proposal_details');
register_setting( 'wpp-lang-settings', 'wpp_lang_terms');


// Register Misc Settings Fields
register_setting( 'wpp-misc-settings', 'wpp_misc_hide_reminder');
register_setting( 'wpp-misc-settings', 'wpp_misc_view_count');
register_setting( 'wpp-misc-settings', 'wpp_misc_invoice_url');
register_setting( 'wpp-misc-settings', 'wpp_misc_display_footer');
register_setting( 'wpp-misc-settings', 'wpp_misc_hide_footer');
register_setting( 'wpp-misc-settings', 'wpp_misc_custom_css');
register_setting( 'wpp-misc-settings', 'wpp_misc_currency');
register_setting( 'wpp-misc-settings', 'wpp_misc_share_proposal');

}
