<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.webheroes.it
 * @since      1.0.0
 *
 * @package    Wh_Cf7mc_Connector
 * @subpackage Wh_Cf7mc_Connector/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wh_Cf7mc_Connector
 * @subpackage Wh_Cf7mc_Connector/includes
 * @author     Web Heroes <info@webheroes.it>
 */
class Wh_Cf7mc_Connector_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate($plugin_base) {
		
		if ( ! is_plugin_active( "web-heroes/web-heroes.php" ) ){
			deactivate_plugins( $plugin_base );
			wp_die( "<a href='https://github.com/mitch827/web-heroes'><b>Web Heroes Enhancements plugin</b></a> is required.<br><br>Go back to <a href='" . get_admin_url(null, 'plugins.php') . "'>plugins page</a>." );
     	}
	}
}
