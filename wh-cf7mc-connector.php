<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.webheroes.it
 * @since             1.0.0a
 * @package           Wh_Cf7mc_Connector
 *
 * @wordpress-plugin
 * Plugin Name:       WH CF7 Mailchimp connector
 * Plugin URI:        http://www.webheroes.it
 * Description:       This plugin connect Contact Form 7 with Mailchimp using MCAPI v1.3. Superpowered by <strong>Web Heroes.</strong>
 * Version:           1.0.1a
 * Author:            Web Heroes
 * Author URI:        http://www.webheroes.it
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wh-cf7mc-connector
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wh-cf7mc-connector-activator.php
 */
function activate_wh_cf7mc_connector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wh-cf7mc-connector-activator.php';
	Wh_Cf7mc_Connector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wh-cf7mc-connector-deactivator.php
 */
function deactivate_wh_cf7mc_connector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wh-cf7mc-connector-deactivator.php';
	Wh_Cf7mc_Connector_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wh_cf7mc_connector' );
register_deactivation_hook( __FILE__, 'deactivate_wh_cf7mc_connector' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wh-cf7mc-connector.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wh_cf7mc_connector() {

	$plugin = new Wh_Cf7mc_Connector();
	$plugin->run();

}
run_wh_cf7mc_connector();

function wh_cf7mc_connector_github_updater_init() {
	include_once plugin_dir_path( __FILE__ ) .'includes/updater.php';
	define( 'WP_GITHUB_FORCE_UPDATE', true );

	if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'wh-hfcode',
			'api_url' => 'https://api.github.com/repos/mitch827/wh-hfcode',
			'raw_url' => 'https://raw.github.com/mitch827/wh-hfcode/master',
			'github_url' => 'https://github.com/mitch827/wh-hfcode',
			'zip_url' => 'https://github.com/mitch827/wh-hfcode/archive/master.zip',
			'sslverify' => true,
			'requires' => '4.0.0',
			'tested' => '4.2.3',
			'readme' => 'README.md',
			'access_token' => '',
		);
		new WP_GitHub_Updater( $config );
	}

}
add_action( 'init', 'wh_cf7mc_connector_github_updater_init' );
