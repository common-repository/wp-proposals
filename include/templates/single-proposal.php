<?php
/*
Template Name: Proposal Single
*/

wpp_setProposalViews(get_the_ID());
global $wpp_image;
    // Get proposal settings options
    $wpp_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
    $wpp_main_title = $wp_query->post->post_title;
    $wpp_company_name = get_option( 'wpp_general_company_name' );
    $wpp_company_website = get_option( 'wpp_general_company_website' );
    $wpp_company_logo = get_option( 'wpp_general_company_logo' );
    $wpp_company_logo_dark = get_option( 'wpp_general_company_logo_dark' );
    $wpp_title_background = get_option( 'wpp_design_title_background' );
    $wpp_general_company_about = get_option( 'wpp_general_company_about' );
    $wpp_general_company_terms = get_option( 'wpp_general_company_terms' );
    $wpp_lang_presented_by = get_option( 'wpp_lang_presented_by' );
    $wpp_lang_scope_services = get_option( 'wpp_lang_scope_services' );
    $wpp_lang_recommendations = get_option( 'wpp_lang_recommendations' );
    $wpp_lang_timeline = get_option( 'wpp_lang_timeline' );
    $wpp_lang_investment = get_option( 'wpp_lang_investment' );
    $wpp_lang_approve_proposal = get_option( 'wpp_lang_approve_proposal' );
    $wpp_lang_approve_proposal_details = get_option( 'wpp_lang_approve_proposal_details' );
    $wpp_lang_terms = get_option( 'wpp_lang_terms' );
    $wpp_misc_custom_css = get_option( 'wpp_misc_custom_css' );
    $wpp_misc_share_proposal = get_option('wpp_misc_share_proposal');
    $wpp_currency = get_option('wpp_misc_currency');
    $wpp_design_hide_print = get_option('wpp_design_hide_print');
    $wpp_design_hide_share = get_option('wpp_design_hide_share');

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

<html>
    <head>
        <!-- Meta Data -->
        <meta name="robots" content="noindex">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $wpp_main_title; ?></title>
        <meta name="description" content="">

        <!-- Link Stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Arimo|Lato|Merriweather|Montserrat|Muli|Noto+Sans|Open+Sans|Oswald|PT+Sans|Poppins|Raleway|Roboto|Rubik|Source+Sans+Pro|Ubuntu" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <style type="text/css">

        <?php echo $wpp_misc_custom_css; ?>

        </style>
    </head>

    <body>

        <?php get_header(); ?>

            <div class="proposal-container">
            <?php if (have_posts()) : while (have_posts()) : the_post();

            // Proposal meta box values
            $service_title = get_post_meta($post->ID, 'wpp_service_title', true);
            $service_description = get_post_meta($post->ID, 'wpp_service_description', true);
            $service = get_post_meta($post->ID,'service',true);
            $recommendation_title = get_post_meta($post->ID, 'wpp_recommendation_title', true);
            $recommendation_description = get_post_meta($post->ID, 'wpp_recommendation_description', true);
            $recommendation = get_post_meta($post->ID,'recommendation',true);
            $timeline_title = get_post_meta($post->ID, 'wpp_timeline_title', true);
            $timeline_description = get_post_meta($post->ID, 'wpp_timeline_description', true);
            $timeline_date = get_post_meta($post->ID, 'wpp_timeline_date', true);
            $timeline_footer = get_post_meta($post->ID, 'wpp_timeline_footer', true);
            $timeline = get_post_meta($post->ID,'timeline',true);
            $pricing_title = get_post_meta($post->ID, 'wpp_pricing_title', true);
            $pricing_description = get_post_meta($post->ID, 'wpp_pricing_description', true);
            $pricing = get_post_meta($post->ID,'pricing',true);
            $pricing_total = get_post_meta($post->ID, 'wpp_pricing_total', true);
            $pricing_footer = get_post_meta($post->ID, 'wpp_pricing_footer', true);

            ?>

                <!-- Proposal Title -->
                <div class="proposal-title-wrapper" style="">
                    <div class="wpp-title-overlay">
                        <div class="proposal-title-content">
                        <?php if(!empty($wpp_company_logo)) { ?><?php if (!empty($wpp_company_website)) { ?><a href="<?php echo $wpp_company_website; ?>" target="_blank"><img class="wpp-company-logo" src="<?php echo $wpp_company_logo; ?>"></a><?php } else { ?><img class="wpp-company-logo" src="<?php echo $wpp_company_logo; ?>"><?php } } else { ?><div class="wpp-company-logo-empty"></div><?php } ?>
                        <h1><?php echo $wpp_main_title;  ?></h1>
                        <?php if (!empty($wpp_company_name)) { ?><h3><?php if (empty($wpp_lang_presented_by)) { ?>Proposal presented by<?php } else { echo $wpp_lang_presented_by; ?><?php } ?>: <?php echo $wpp_company_name; ?></h3><?php } ?>
                        </div>
                    </div>
                </div>


                <!-- Proposal Content -->
                <div class="proposal-content-wrapper">


                      <!-- Signature Approval Success Message -->
                      <?php  if ( isset( $_POST['wpp-approved'] ) ) { ?>
                      <div class="wpp-success-message"><p><?php echo do_shortcode("[wpp_approval_form_success]"); ?></p></div>
                    <?php } ?>


                      <!-- Introduction Section -->
                      <?php $thecontent = get_the_content(); ?>
                          <div class='wpp-section introduction'>
                              <div class='wpp-section-content'>
                                  <?php the_content(); ?>
                              </div>
                          </div>

                      <!-- Check if proposal is password protected -->
                      <?php if ( ! post_password_required() ) { ?>


                      <!-- Services Section -->
                      <?php if(!empty($service)) { ?>
                      <div class='wpp-section services'>
                          <div class='wpp-section-content'>
                          <h2><?php if (empty($service_title)) { if (empty($wpp_lang_scope_services)) { echo esc_html_e( 'Scope of Services', 'wp-proposals' ); } else { echo esc_html_e( "$wpp_lang_scope_services", 'wp-proposals' ); } } else { echo esc_attr( $service_title ); } ?></h2>
                          <?php if(!empty($service_description)) { ?><p div class="wpp-section-description"><?php echo esc_attr( $service_description ); ?></p><?php } ?>

                              <div class="list">
                                    <?php if(!empty($service)) { ?>
                                    <?php foreach ( $service as $service_field ) { ?>
                                    <div class="row">
                                        <?php if($service_field['title'] != '') echo '<h3 class="wpp-item-title">'. esc_attr( $service_field['title'] ) . '</h3>'; ?>
                                        <?php if($service_field['service_item'] != '') echo '<p class="wpp-item-desc">'. esc_attr( $service_field['service_item'] ) . '</p>'; ?>
                                    </div>
                                    <?php } } ?>
                              </div>

                          </div>
                      </div>
                      <?php } ?>


                      <!-- Additional Recommendations Section -->
                      <?php if(!empty($recommendation)) { ?>
                      <div class='wpp-section recommendations'>
                          <div class='wpp-section-content'>
                          <h2><?php if (empty($recommendation_title)) { if (empty($wpp_lang_recommendations)) { echo esc_html_e( 'Additional Recommendations', 'wp-proposals' ); } else { echo esc_html_e( "$wpp_lang_recommendations", 'wp-proposals' ); } } else { echo esc_attr( $recommendation_title ); } ?></h2>
                          <?php if(!empty($recommendation_description)) { ?><p div class="wpp-section-description"><?php echo esc_attr( $recommendation_description ); ?></p><?php } ?>

                              <div class="list">
                                  <?php if(!empty($recommendation)) { ?>
                                  <?php foreach ( $recommendation as $recommendation_field ) { ?>
                                  <div class="row">
                                      <?php if($recommendation_field['title'] != '') echo '<h3 class="wpp-item-title">'. esc_attr( $recommendation_field['title'] ) . '</h3>'; ?>
                                      <?php if($recommendation_field['recommendation_item'] != '') echo '<p class="wpp-item-desc">'. esc_attr( $recommendation_field['recommendation_item'] ) . '</p>'; ?>
                                  </div>
                                  <?php } } ?>
                              </div>

                          </div>
                      </div>
                      <?php } ?>


                      <!-- Timline Section -->
                      <?php if(!empty($timeline)) { ?>
                      <div class='wpp-section timeline'>
                          <div class='wpp-section-content'>
                          <h2><?php if (empty($timeline_title)) { if (empty($wpp_lang_timeline)) { echo esc_html_e( 'Timeline', 'wp-proposals' ); } else { echo esc_html_e( "$wpp_lang_timeline", 'wp-proposals' ); } } else { echo esc_attr( $timeline_title ); } ?></h2>
                          <?php if(!empty($timeline_description)) { ?><p div class="wpp-section-description"><?php echo esc_attr( $timeline_description ); ?></p><?php } ?>

                              <div class="wpp-pricing-table">
                                  <div class="wpp-pt-header wpp-apt-row">
                                        <h4 class="wpp-pt-header-title estimated"><?php echo esc_html_e( 'Estimated Timeline:', 'wp-proposals' );?></h4>
                                        <h4 class="wpp-pt-header-title et-dates"><?php echo esc_attr( $timeline_date ); ?></h4>
                                  </div>

                                      <div class="wpp-pt-list">
                                          <?php if(!empty($timeline)) { ?>
                                          <?php foreach ( $timeline as $timeline_field ) { ?>
                                              <div class="wpp-pt-items wpp-apt-row">
                                                  <?php if($timeline_field['title'] != '') echo '<div class="wpp-pt-item-title">'. esc_attr( $timeline_field['title'] ) . '</div>'; ?>
                                                  <?php if($timeline_field['timeline_item'] != '') echo '<div class="wpp-pt-item-date">'. esc_attr( $timeline_field['timeline_item'] ) . '</div>'; ?>
                                              </div>
                                          <?php } } ?>
                                      </div>
                              </div>
                              <?php if(!empty($timeline_footer)) { ?><p div class="wpp-section-footer"><?php echo esc_attr( $timeline_footer ); ?></p><?php } ?>

                          </div>
                      </div>
                      <?php } ?>


                      <!-- Pricing Section -->
                      <?php if(!empty($pricing)) { ?>
                      <div class='wpp-section pricing'>
                          <div class='wpp-section-content'>
                          <h2><?php if (empty($pricing_title)) {  if (empty($wpp_lang_investment)) { echo esc_html_e( 'Your Investment', 'wp-proposals' ); } else { echo esc_html_e( "$wpp_lang_investment", 'wp-proposals' ); } } else { echo esc_attr( $pricing_title ); } ?></h2>
                          <?php if(!empty($pricing_description)) { ?><p div class="wpp-section-description"><?php echo esc_attr( $pricing_description ); ?></p><?php } ?>

                              <div class="wpp-pricing-table investment">

                                      <div class="wpp-pt-list">
                                          <?php if(!empty($pricing)) { ?>
                                          <?php foreach ( $pricing as $pricing_field ) { ?>
                                              <div class="wpp-pt-items wpp-apt-row">
                                                  <?php if($pricing_field['title'] != '') echo '<div class="wpp-pt-item-title">'. esc_attr( $pricing_field['title'] ) . '</div>'; ?>
                                                  <?php if($pricing_field['pricing_item'] != '') echo "<div class='wpp-pt-item-date'> $wpp_currency". esc_attr( $pricing_field['pricing_item'] ) . "</div>"; ?>
                                              </div>
                                          <?php } } ?>
                                      </div>

                                      <div class="wpp-pt-header wpp-apt-row pricing">
                                            <h4 class="wpp-pt-header-title pricing-total"><div><?php echo esc_html_e( 'Total:', 'wp-proposals' ); ?> <?php echo "$wpp_currency"; ?><?php echo esc_attr( $pricing_total ); ?></h4>
                                      </div>

                              </div>
                              <?php if(!empty($pricing_footer)) { ?><p div class="wpp-section-footer"><?php echo esc_attr( $pricing_footer ); ?></p><?php } ?>

                          </div>
                      </div>
                      <?php } ?>


                      <!-- Approve Section -->
                      <div class='wpp-section approve' id="approve" name="approve">
                          <div class='wpp-section-content'>
                          <h2><?php if (empty($wpp_lang_approve_proposal)) { echo esc_html_e( 'Approve Proposal', 'wp-proposals' ); } else { echo esc_html_e( "$wpp_lang_approve_proposal", 'wp-proposals' ); } ?></h2>
                          <p div class="wpp-section-description"><?php if (empty($wpp_lang_approve_proposal_details)) { echo esc_html_e( 'If you would like to join us and become a client then we’d be delighted to have you.', 'wp-proposals' ); } else { echo $wpp_lang_approve_proposal_details; } ?></p>

                          <div class="wpp-approval-form-holder"><?php echo do_shortcode("[wpp_signature_form]"); ?></div>
                          </div>
                      </div>

                </div>

            <?php } ?>

            <?php endwhile; endif; ?>

            <!-- Check if proposal is password protected -->
            <?php if ( ! post_password_required() ) { ?>


                <!-- About Section -->
                <?php if(!empty($wpp_general_company_about)) { ?>
                <div class='wpp-section company-about'>
                    <div class='wpp-section-content'>
                          <?php if(!empty($wpp_company_logo_dark)) { ?><div class="wpp-about-logo-holder"><?php if (!empty($wpp_company_website)) { ?><a href="<?php echo $wpp_company_website; ?>" target="_blank"><img class="wpp-about-logo" src="<?php echo $wpp_company_logo_dark; ?>"></a><?php } else { ?><img class="wpp-about-logo" src="<?php echo $wpp_company_logo_dark; ?>"><?php } } ?></div>
                          <?php echo $wpp_general_company_about; ?>
                    </div>
                </div>
                <?php } ?>


                <?php if(!empty($wpp_general_company_terms)) { ?>
                <div class="wpp-collapse-terms-wrapper">


                    <div class="wpp-wrap-collabsible">
                        <input id="wpp-collapsible" class="wpp-toggle" type="checkbox">
                        <label for="wpp-collapsible" class="wpp-lbl-toggle"><?php if (empty($wpp_lang_terms)) { echo esc_html_e( 'Terms and Conditions', 'wp-proposals' ); } else { echo esc_html_e( "$wpp_lang_terms", 'wp-proposals' ); } ?></label>
                        <div class="wpp-collapsible-content">
                              <div class="wpp-collapse-inner">
                                  <div class="wpp-terms-text">
                                    <p><?php if(!empty($wpp_general_company_terms)) { echo $wpp_general_company_terms; } ?></p>
                                  </div>
                              </div>
                        </div>
                    </div>

                </div>

              <?php } ?>

                <script>

                let myLabels = document.querySelectorAll('.wpp-lbl-toggle');

                Array.from(myLabels).forEach(label => {
                  label.addEventListener('keydown', e => {
                    // 32 === spacebar
                    // 13 === enter
                    if (e.which === 32 || e.which === 13) {
                      e.preventDefault();
                      label.click();
                    };
                  });
                });

                </script>


                <!-- Proposal Footer -->
                <div class="wpp-footer">
                    <?php if(empty($wpp_design_hide_print)) {
                          echo do_shortcode("<div class='print-quote'>[print_button]</div>");
                     } ?>
                    <?php if (empty($wpp_design_hide_share)) { ?>
                    <div class="wpp-share-email">
                        <p><?php _e('Want to share with a colleague?', 'wp-proposals') ?></p>
                        <a href="mailto:?subject= Proposal by <?php echo $wpp_company_name ?>&amp;body=I wanted to share a proposal with you for you to look over. Use this link to view the proposal online: <?php echo get_permalink(); ?>." title="Share">Share</a>
                    </div>
                    <?php } ?>
                    <a class="approve-float anchor" href="#approve"><?php _e('Accept', 'wp-proposals') ?></a>
                </div>
            </div>

            <?php } ?>


            <!-- Get Footer -->
            <?php get_footer(); ?>

      </body>
</html>
