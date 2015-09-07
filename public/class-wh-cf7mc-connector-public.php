<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.webheroes.it
 * @since      1.0.0
 *
 * @package    Wh_Cf7mc_Connector
 * @subpackage Wh_Cf7mc_Connector/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wh_Cf7mc_Connector
 * @subpackage Wh_Cf7mc_Connector/public
 * @author     Web Heroes <info@webheroes.it>
 */
class Wh_Cf7mc_Connector_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	
	/**
	 * The options name to be used in this plugin
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string      $option_name    Option name of this plugin
	 */
	private $option_name = 'wh_Cf7mc_Connector';

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	//public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wh_Cf7mc_Connector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wh_Cf7mc_Connector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	//	wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wh-cf7mc-connector-public.css', array(), $this->version, 'all' );

	//}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	//public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wh_Cf7mc_Connector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wh_Cf7mc_Connector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	//	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wh-cf7mc-connector-public.js', array( 'jquery' ), $this->version, false );

	//}
	
	/**
	 * wh_mailchimp_cf7_connect function.
	 * 
	 * @access public
	 * @param mixed $cfdata
	 * @return void
	 */
	public function wh_mailchimp_cf7_connect($cfdata) {
		
		/**
		 * data_for_mailchimp function.
		 * 
		 * @access public
		 * @param mixed $formtitle
		 * @param mixed $posted_data
		 * @return $retMCdata
		 */
		function data_for_mailchimp( $formtitle, $posted_data, $args ){
			
			if (!$args['nl'] && !$args['cf']){
				return;
			}
			if ($args['nl']){
	
				$mergeVars = array(
					'GROUPINGS'=>array( 
						array('name'=>'Dal sito', 'groups'=>$formtitle)
					)
				);		
				$send_this_email = $posted_data['email-nl'];
			}
			if ($args['cf']){
				//Mailchimp optin
				if( $posted_data['mailchimp-optin'] ){
					
					$mergeVars = array(			
						'GROUPINGS'=>array( 
			 				array('name'=>'Dal sito', 'groups'=>$formtitle)
			 			)
		 			);
		 			$send_this_email = $posted_data['email-cf'];
				}			
			}
			
			$retMCdata = array(
				'send_this_email' => $send_this_email,
				'mergeData' => $mergeVars
			);
			 
			return $retMCdata;
		}
		
		$args = array(
				'nl' => (bool) get_option( $this->option_name . '_nl' ),
				'cf' => (bool) get_option( $this->option_name . '_cf' )
		);
	
		$formtitle = $cfdata->title;
		$submission = WPCF7_Submission::get_instance();
		$mailchimp_api_key = get_option( 'api_key' );
		$multilang = (bool) get_option( $this->option_name . '_multilanguage');
		if ( ! $multilang ){
			$mailchimp_list_id = get_option( 'list_id' );
		} else {
			$languages = get_option( $this->option_name . '_lang');
			foreach( $languages as $lang){
				$mailchimp_multilang_list_id[]= get_option( $this->option_name . '_list_id_' . $lang);
			}
		}
		$mailchimp_debug = get_option( 'debug' );
		$honeypot_opt = get_option( 'honeypot' );
		
	
		// grab an API Key from http://admin.mailchimp.com/account/api/
		$api = new MCAPI($mailchimp_api_key);
	 
		if ( $submission ) {
		    $posted_data = $submission->get_posted_data();
		    $honeypot = $posted_data['honeypot'];
		}
	
		if ( $honeypot_opt == 1){
			if (strlen($honeypot) == 0){
			  	$data = data_for_mailchimp( $formtitle, $posted_data, $args);
			} else {
				
				return false;
			}
		} else {
			$data = data_for_mailchimp( $formtitle, $posted_data, $args);
		}
		
		// Send the form content to MailChimp List without double opt-in
		if ( ! $multilang ){
			$retval = $api->listSubscribe($mailchimp_list_id, $data['send_this_email'], $data['mergeData']);
		} else {
			if ( defined( 'ICL_LANGUAGE_CODE' ) ){
				switch (ICL_LANGUAGE_CODE){
					case 'en':
						$retval = $api->listSubscribe($mailchimp_multilang_list_id['en'], $data['send_this_email'], $data['mergeData']);
						break;
					case 'fr':
						$retval = $api->listSubscribe($mailchimp_multilang_list_id['fr'], $data['send_this_email'], $data['mergeData']);
						break;
					case 'de':
						$retval = $api->listSubscribe($mailchimp_multilang_list_id['de'], $data['send_this_email'], $data['mergeData']);
						break;
					case 'it':
						$retval = $api->listSubscribe($mailchimp_multilang_list_id['it'], $data['send_this_email'], $data['mergeData']);
						break;
					case 'pt':
						$retval = $api->listSubscribe($mailchimp_multilang_list_id['pt'], $data['send_this_email'], $data['mergeData']);
						break;
					case 'es':
						$retval = $api->listSubscribe($mailchimp_multilang_list_id['es'], $data['send_this_email'], $data['mergeData']);
						break;
					default:
						$retval = $api->listSubscribe($mailchimp_list_id, $data['send_this_email'], $data['mergeData']);
						break;
				}
			} else {
				wp_die("For multilanguage forms you have to download and install WPML plugin.<br><br>Go back to <a href='" . get_admin_url(null, 'plugins.php') . "'>plugins page</a>.");
			}
		}
		
		if ( $mailchimp_debug == 1 ){
			//this is for debug purposes
		    $debug = array(
		    'time' => date('Y.m.d H:i:s e P'),
		    'Control args' => $args,
		    'Api key' => $mailchimp_api_key,
		    'List id' => $mailchimp_list_id,
		    'formtitle' => $formtitle,
		    'formdata' => $posted_data,
		    'email' => $data['send_this_email'],
		    'mergevars' => $data['mergeData'],
		    'result' => $retval,
		    'WPML' => defined( 'ICL_LANGUAGE_CODE' ) ? 'yes' : 'no',
		    'languages' => array()
		    );
		    foreach ( $languages as $lang ){
			    $debug['languages'][] = $lang;
		    }
		    $test_file = fopen('devlog.txt', 'a');
		    $test_result = fwrite($test_file, print_r($debug, TRUE));
		}
	  	   	
	}

}
