<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.webheroes.it
 * @since      1.0.0
 *
 * @package    Wh_Cf7mc_Connector
 * @subpackage Wh_Cf7mc_Connector/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    
    <?php
	    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_options';
		if( isset( $_GET[ 'tab' ] ) ) {
		    $active_tab = $_GET[ 'tab' ];
		} // end if
	?>
	
    <?php if( isset( $_GET['settings-updated'] ) ) : ?>
		<div id="message" class="updated">
			<p><strong><?php _e( 'Settings saved.' ) ?></strong></p>
		</div>
	<?php endif; ?>
	
	<h3 class="nav-tab-wrapper">
    	<a href="?page=wh-cf7mc-connector&tab=mailchimp_account" class="nav-tab <?php echo $active_tab == 'mailchimp_account' ? 'nav-tab-active' : ''; ?>"><?php _e('Mailchimp Account', 'wh-cf7mc-connector'); ?></a>
		<a href="?page=wh-cf7mc-connector&tab=form_data" class="nav-tab <?php echo $active_tab == 'form_data' ? 'nav-tab-active' : ''; ?>"><?php _e('Data Setup', 'wh-cf7mc-connector'); ?></a>
		<a href="?page=wh-cf7mc-connector&tab=extra" class="nav-tab <?php echo $active_tab == 'extra' ? 'nav-tab-active' : ''; ?>"><?php _e('Extra', 'wh-cf7mc-connector'); ?></a>
	</h3>
	
    <form action="options.php" method="post">
        <?php
	        if( $active_tab == 'mailchimp_account' ) {
            	settings_fields( $this->plugin_name . '_mailchimp_account' );
				do_settings_sections( $this->plugin_name . '_mailchimp_account' );
				submit_button();
			}
			
			if( $active_tab == 'form_data' ) {
				settings_fields( $this->plugin_name . '_form_data' );
				do_settings_sections( $this->plugin_name . '_form_data' );
				submit_button();
			}
			
			if ($active_tab == 'extra' ){
				settings_fields( $this->plugin_name . '_extra' );
				do_settings_sections( $this->plugin_name . '_extra' );
				submit_button();
			}
        ?>
    </form>
</div>
