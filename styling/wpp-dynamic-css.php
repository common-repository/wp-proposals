<?php

// Dynamic Proposal CSS Stlying Frontend
function wpp_dynamic_css_frontend() {
    global $wpp_image;
    global $post;
    $wpp_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
    $title_overlay = get_option('wpp_design_title_overlay');
    $title_overlay_opacity = get_option('wpp_design_title_overlay_opacity');
    $wpp_title_background = get_option( 'wpp_design_title_background' );
    $wpp_design_title_text_color = get_option('wpp_design_title_text_color');
    $wpp_design_font_family = get_option('wpp_design_font_family');
    $wpp_design_content_width = get_option('wpp_design_content_width');
    $wpp_design_content_editor_width = get_option('wpp_design_content_editor_width');
    $wpp_design_section_padding = get_option('wpp_design_section_padding');
    $wpp_design_heading_h2_color = get_option('wpp_design_heading_h2_color');
    $wpp_design_heading_h2_size = get_option('wpp_design_heading_h2_size');
    $wpp_design_heading_h2_height = get_option('wpp_design_heading_h2_height');
    $wpp_design_heading_h2_weight = get_option('wpp_design_heading_h2_weight');
    $wpp_design_heading_h3_color = get_option('wpp_design_heading_h3_color');
    $wpp_design_heading_h3_size = get_option('wpp_design_heading_h3_size');
    $wpp_design_heading_h3_height = get_option('wpp_design_heading_h3_height');
    $wpp_design_heading_h3_weight = get_option('wpp_design_heading_h3_weight');
    $wpp_design_text_color = get_option('wpp_design_text_color');
    $wpp_design_text_size = get_option('wpp_design_text_size');
    $wpp_design_text_height = get_option('wpp_design_text_height');
    $wpp_design_text_weight = get_option('wpp_design_text_weight');
    $wpp_misc_hide_footer = get_option('wpp_misc_hide_footer');
    $wpp_display_footer = get_option( 'wpp_misc_display_footer' );

?>

    <style type="text/css">

        /* Title Overlay */
        .wpp-title-overlay {
            <?php if (!empty($title_overlay)) { ?> background-color: <?php echo $title_overlay; ?>; <?php } else { ?> background-color: #333; <?php } ?>
        }
        .wpp-title-overlay:before {
            background-image: url('<?php if (!empty($wpp_image)) { echo $wpp_image[0]; } else { echo $wpp_title_background; } ?>')!important;
        }
        .wpp-title-overlay:after {
            <?php if (!empty($title_overlay)) { ?> background-color: <?php echo $title_overlay; ?>; <?php } else { ?> background-color: #333; <?php } ?>
            <?php if (!empty($title_overlay_opacity)) { ?> opacity: <?php echo $title_overlay_opacity; ?>; <?php } else { ?> opacity: 0.8; <?php } ?>
        }
        .single-proposal .approve-float:before, .single-proposal .proposal-container a:hover {
            color: #333!important;
        }
        <?php if (!empty($title_overlay)) { ?>
        .single-proposal .approve-float:before, .single-proposal .proposal-container a:hover {
            color: <?php echo $title_overlay; ?>!important;
        }
        .single-proposal .wpp-approval-form-holder #wpp-approved, .wpp-approved-message p, .wpp-success-message, .wpp-bottom-success-message p {
            background-color: <?php echo $title_overlay; ?>!important;
        }
        <?php } ?>
        .single-proposal .wpp-approval-form-holder #wpp-approved, .wpp-approved-message p, .wpp-success-message, .wpp-bottom-success-message p {
            background-color: #333;
        }

        /* Font Family */
        <?php if($wpp_design_font_family !== "Theme Default") { ?>
        .proposal-container h1, .proposal-container h2, .proposal-container h3, .proposal-container h4, .proposal-container h5, .proposal-container h6, .proposal-container a, .proposal-container p, .proposal-containers span, .single-proposal .approve-float, .wpp-wrap-collabsible .wpp-lbl-toggle, .single-proposal .wpp-pt-item-title, .single-proposal .wpp-pt-item-title:before, .single-proposal .wpp-pt-item-date {
            font-family: 'Roboto', sans-serif;
            <?php if (!empty($wpp_design_font_family)) { ?>font-family: '<?php echo $wpp_design_font_family; ?>', sans-serif!important;<?php } ?>
        }
        .proposal-container h2, .proposal-container .h2, .proposal-container h2 a {
            color: #303030;
            font-size: 38px;
            line-height: 43px;
            font-style: normal;
            font-weight: 400;
            letter-spacing: 0px;
            text-transform: none;
        }
        .proposal-container p {
            color: #828282;
            font-size: 14.5px;
            line-height: 26px;
            font-style: normal;
            font-weight: 400;
        }
        .proposal-container h3, .proposal-container .h3, .proposal-container h3 a {
            color: #303030;
            font-size: 23px;
            line-height: 33px;
            font-style: normal;
            font-weight: 400;
            letter-spacing: 0px;
            text-transform: none;
        }
        label.wpp-lbl-toggle {
            font-size: 16.25px!important;
            font-weight: 600!important;
        }
        .proposal-title-wrapper h1 {
            font-size: 36px;
            font-weight: 400;
        }
        .single-proposal .approve-float {
            font-weight: 500;
        }
        <?php } ?>

        /* Content Width */
        <?php if (!empty($wpp_design_content_width)) { ?>
        .single-proposal .wpp-section-content, .wpp-wrap-collabsible .wpp-collapsible-content, .wpp-section-content .section_inner.clearfix, .wpp-section-content .elementor-section.elementor-section-boxed > .elementor-container  {
            max-width: <?php echo $wpp_design_content_width; ?>!important;
        }
        @media print {
        .wpp-section-content .section_inner.clearfix, .wpp-section-content .elementor-section.elementor-section-boxed > .elementor-container {
            margin-left: -35px!important;
        }
        }
        @media (max-width: <?php echo $wpp_design_content_width; ?> ) {
        .single-proposal .wpp-section-content, .wpp-wrap-collabsible .wpp-collapsible-content, .wpp-section-content .section_inner.clearfix, .wpp-section-content .elementor-section.elementor-section-boxed > .elementor-container  {
            padding-left: 50px!important;
            padding-right: 50px!important;
        }
        }
        <?php } ?>

        /* Section Padding */
        <?php if (!empty($wpp_design_section_padding)) { ?>
        .single-proposal .wpp-section {
            padding-top: <?php echo $wpp_design_section_padding; ?>px!important;
            padding-bottom: <?php echo $wpp_design_section_padding; ?>px!important;
        }
        <?php } ?>

        /* Headings H2 Style */
        <?php if (!empty($wpp_design_heading_h2_color)) { ?>
        .single-proposal .proposal-container h2 {
            color: <?php echo $wpp_design_heading_h2_color; ?>!important;
        }
        <?php } ?>
        .single-proposal .proposal-container h2 {
            <?php if (!empty($wpp_design_heading_h2_size)) { ?> font-size: <?php echo $wpp_design_heading_h3_size; ?>px!important; <?php } ?>
            <?php if (!empty($wpp_design_heading_h2_height)) { ?> line-height: <?php echo $wpp_design_heading_h2_height; ?>px!important; <?php } ?>
            <?php if (!empty($wpp_design_heading_h2_weight)) { ?> font-weight: <?php echo $wpp_design_heading_h2_weight; ?>!important; <?php } ?>
        }

        /* Headings H3 Style */
        <?php if (!empty($wpp_design_heading_h3_color)) { ?>
        .single-proposal .proposal-container h3 {
            color: <?php echo $wpp_design_heading_h3_color; ?>!important;
        }
        <?php } ?>
        .single-proposal .proposal-container h3 {
            <?php if (!empty($wpp_design_heading_h3_size)) { ?> font-size: <?php echo $wpp_design_heading_h3_size; ?>px!important; <?php } ?>
            <?php if (!empty($wpp_design_heading_h3_height)) { ?> line-height: <?php echo $wpp_design_heading_h3_height; ?>px!important; <?php } ?>
            <?php if (!empty($wpp_design_heading_h3_weight)) { ?> font-weight: <?php echo $wpp_design_heading_h3_weight; ?>!important; <?php } ?>
        }

        /* Text Color */
        <?php if (!empty($wpp_design_text_color)) { ?>
        .single-proposal .proposal-container p, .single-proposal .proposal-container span, .single-proposal .proposal-container b, .single-proposal .proposal-container strong, .single-proposal .approve-float {
            color: <?php echo $wpp_design_text_color; ?>!important;
        }
        <?php } ?>
        .single-proposal .proposal-container p, .single-proposal .proposal-container span, .single-proposal .proposal-container b, .single-proposal .proposal-container strong, .single-proposal .approve-float{
            <?php if (!empty($wpp_design_text_size)) { ?> font-size: <?php echo $wpp_design_text_size; ?>px!important; <?php } ?>
            <?php if (!empty($wpp_design_text_height)) { ?> line-height: <?php echo $wpp_design_text_height; ?>px!important; <?php } ?>
            <?php if (!empty($wpp_design_text_weight)) { ?> font-weight: <?php echo $wpp_design_text_weight; ?>!important; <?php } ?>
        }

        /* Title Color */
        <?php if (empty($wpp_design_title_text_color)) { ?>
        .proposal-title-content h1, .proposal-title-content h3, .wpp-approved-message p, .wpp-top-success-message p, .wpp-bottom-success-message p {
            color: #fff!important;
        }
        <?php } else { ?>
        .proposal-title-content h1, .proposal-title-content h3, .wpp-approved-message p, .wpp-top-success-message p, .wpp-bottom-success-message p {
            color: <?php echo $wpp_design_title_text_color; ?>;
        }
        <?php } ?>

        /* Hide Footer */
        <?php if (!empty($wpp_misc_hide_footer)) { ?>
        .single-proposal <?php echo $wpp_misc_hide_footer; ?> {
            display: none!important;
        }
        <?php } ?>

        /* Display Footer */
        <?php if (empty($wpp_display_footer)) { ?>
        .single-proposal footer {
            display: none!important;
        }
        <?php } ?>

        /* Content Editor Full Width */
        <?php if (!empty($wpp_design_content_editor_width)) { ?>
        .wpp-section.introduction .wpp-section-content {
            max-width: 100%!important;
        }
        <?php } ?>

    </style>

<?php }
add_action( 'wp_head', 'wpp_dynamic_css_frontend' );


// Dynamic Proposal CSS Stlying Backend
function wpp_dynamic_css_backend() {
    $wpp_misc_invoice_url = get_option('wpp_misc_invoice_url');

?>

    <style type="text/css">

        /* Hide Invoice URL */
        <?php if (!empty($wpp_misc_invoice_url)) { ?>
        #tagsdiv-proposal_invoice {
            display: none;
        }
        <?php } ?>

    </style>

<?php }
add_action( 'admin_head', 'wpp_dynamic_css_backend' );
