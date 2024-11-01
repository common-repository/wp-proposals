<?php


// Include settings page files
include( plugin_dir_path( __FILE__ ) . 'general.php');
include( plugin_dir_path( __FILE__ ) . 'design.php');
include( plugin_dir_path( __FILE__ ) . 'language.php');
include( plugin_dir_path( __FILE__ ) . 'misc.php');


// Create settings main layout
function wpp_settings() {
		global $wpp_active_tab;
		global $wpp_plugin_version;
		$wpp_active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general'; ?>


	  <div class="wrap wpp-settings-wrapper">

			  <div class="advanced-header">
						<img class="wpp-logo" style="padding-top: 4px;" src="<?php echo plugins_url( 'assets/invoice.png', __FILE__ ); ?>" alt="Advanced Sermons" height="45" width="45" />
				    <h1>WP Proposals<span class="wpp-developer">by WP Codeus. <?php echo $wpp_plugin_version; ?></span></h1>
			  </div>
				<h2 class="nav-tab-wrapper">
					 	<?php do_action( 'wpp_settings_tab' ); do_action( 'wpp_settings_content' ); ?>
			  </h2>

		<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#upload-btn').click(function(e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Logo',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open()
            .on('select', function(e){
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get('selection').first();
                // We convert uploaded_image to a JSON object to make accessing it easier
                // Output to the console uploaded_image
                console.log(uploaded_image);
                var image_url = uploaded_image.toJSON().url;
                // Let's assign the url value to the input field
                $('#image_url').val(image_url);
            });
        });
    });
		jQuery(document).ready(function($){
				$('#upload-btn-two').click(function(e) {
						e.preventDefault();
						var image = wp.media({
								title: 'Upload Image',
								// mutiple: true if you want to upload multiple files at once
								multiple: false
						}).open()
						.on('select', function(e){
								// This will return the selected image from the Media Uploader, the result is an object
								var uploaded_image = image.state().get('selection').first();
								// We convert uploaded_image to a JSON object to make accessing it easier
								// Output to the console uploaded_image
								console.log(uploaded_image);
								var image_url_two = uploaded_image.toJSON().url;
								// Let's assign the url value to the input field
								$('#image_url_two').val(image_url_two);
						});
				});
		});
		jQuery(document).ready(function($){
				$('#upload-btn-three').click(function(e) {
						e.preventDefault();
						var image = wp.media({
								title: 'Upload Image',
								// mutiple: true if you want to upload multiple files at once
								multiple: false
						}).open()
						.on('select', function(e){
								// This will return the selected image from the Media Uploader, the result is an object
								var uploaded_image = image.state().get('selection').first();
								// We convert uploaded_image to a JSON object to make accessing it easier
								// Output to the console uploaded_image
								console.log(uploaded_image);
								var image_url_three = uploaded_image.toJSON().url;
								// Let's assign the url value to the input field
								$('#image_url_three').val(image_url_three);
						});
				});
		});
		jQuery(document).ready(function($){
				$('#upload-btn-four').click(function(e) {
						e.preventDefault();
						var image = wp.media({
								title: 'Upload Image',
								// mutiple: true if you want to upload multiple files at once
								multiple: false
						}).open()
						.on('select', function(e){
								// This will return the selected image from the Media Uploader, the result is an object
								var uploaded_image = image.state().get('selection').first();
								// We convert uploaded_image to a JSON object to make accessing it easier
								// Output to the console uploaded_image
								console.log(uploaded_image);
								var image_url_four = uploaded_image.toJSON().url;
								// Let's assign the url value to the input field
								$('#image_url_four').val(image_url_four);
						});
				});
		});

		// Add color picker to input
		(function( $ ) {
				// Add Color Picker to all inputs that have 'color-field' class
				$(function() {
						$('.color-field').wpColorPicker();
				});
		})( jQuery );
		</script>

    <div class="wpp-footer">WP Proposals by <b><a href="https://wpcodeus.com/" target="_blank">WP Codeus.</a></b></div>

		</div>

<?php }
