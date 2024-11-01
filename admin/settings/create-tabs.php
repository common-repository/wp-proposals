<?php


// Create general tab
add_action( 'wpp_settings_tab', 'wpp_general_tab', 1 );
function wpp_general_tab(){
		global $wpp_active_tab; ?>
		<a class="nav-tab <?php echo $wpp_active_tab == 'general' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'edit.php?post_type=proposal&page=wpp-settings&tab=general' ); ?>"><?php _e( 'General', 'wpp' ); ?> </a>
<?php }


// Create design tab
add_action( 'wpp_settings_tab', 'wpp_design_tab', 1 );
function wpp_design_tab(){
		global $wpp_active_tab; ?>
		<a class="nav-tab <?php echo $wpp_active_tab == 'design' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'edit.php?post_type=proposal&page=wpp-settings&tab=design' ); ?>"><?php _e( 'Design', 'wpp' ); ?> </a>
<?php }


// Creates misc tab
add_action( 'wpp_settings_tab', 'wpp_misc_tab', 1 );
function wpp_misc_tab(){
		global $wpp_active_tab; ?>
		<a class="nav-tab <?php echo $wpp_active_tab == 'misc' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'edit.php?post_type=proposal&page=wpp-settings&tab=misc' ); ?>"><?php _e( 'Misc', 'wpp' ); ?> </a>
<?php }


// Creates language tab
add_action( 'wpp_settings_tab', 'wpp_language_tab', 1 );
function wpp_language_tab(){
		global $wpp_active_tab; ?>
		<a class="nav-tab <?php echo $wpp_active_tab == 'language' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'edit.php?post_type=proposal&page=wpp-settings&tab=language' ); ?>"><?php _e( 'Language', 'wpp' ); ?> </a>
<?php }
