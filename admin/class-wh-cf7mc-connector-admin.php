<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.webheroes.it
 * @since      1.0.0
 *
 * @package    Wh_Cf7mc_Connector
 * @subpackage Wh_Cf7mc_Connector/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wh_Cf7mc_Connector
 * @subpackage Wh_Cf7mc_Connector/admin
 * @author     Web Heroes <info@webheroes.it>
 */
class Wh_Cf7mc_Connector_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	// public function enqueue_styles() {

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

	//	wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wh-cf7mc-connector-admin.css', array(), $this->version, 'all' );

//	}

	/**
	 * Register the JavaScript for the admin area.
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

	//	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wh-cf7mc-connector-admin.js', array( 'jquery' ), $this->version, false );

//	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
	 
	    $this->plugin_screen_hook_suffix = add_submenu_page(
	    'wpcf7', 
	    __( 'Web Heroes Contact Form 7 Mailchimp Connector', 'wh-cf7mc-connector' ), 
	    __( 'Mailchimp', 'wh-cf7mc-connector' ), 
	    'manage_options', 
	    $this->plugin_name, 
	    array( $this, 'display_options_page' ) );
	}
	
	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
	    include_once 'partials/wh-cf7mc-connector-admin-display.php';
	}
	
	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		// Add a General section
		add_settings_section(
		    $this->option_name . '_general',
		    __( 'General', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_general_cb' ),
		    $this->plugin_name
		);
		
		add_settings_field(
		    'api_key',
		    __( 'Mailchimp API key', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_api_key_cb' ),
		    $this->plugin_name,
		    $this->option_name . '_general',
		    array( 'label_for' => 'api_key' )
		);
		
		add_settings_field(
		    'list_id',
		    __( 'List ID', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_list_id_cb' ),
		    $this->plugin_name,
		    $this->option_name . '_general',
		    array( 'label_for' => 'list_id' )
		);
		
		add_settings_field(
		    'honeypot',
		    __( 'Honeypot', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_honeypot_cb' ),
		    $this->plugin_name,
		    $this->option_name . '_general',
			array( 'label_for' => 'honeypot' )
		);
		
		add_settings_field(
		    'debug',
		    __( 'Debug', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_debug_cb' ),
		    $this->plugin_name,
		    $this->option_name . '_general',
			array( 'label_for' => 'debug' )
		);

		register_setting( $this->plugin_name, 'api_key','strval' );
		register_setting( $this->plugin_name, 'list_id', array( $this, $this->option_name . '_sanitize_code' )  );
		register_setting( $this->plugin_name, 'honeypot', array( $this, $this->option_name . '_sanitize_code' )  );
		register_setting( $this->plugin_name, 'debug', array( $this, $this->option_name . '_sanitize_code' )  );

	//	register_setting( $this->plugin_name, $this->option_name . '_day', array( $this, $this->option_name . '_sanitize_position' ) );
	}
	
	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function wh_Cf7mc_Connector_general_cb() {
	    echo '<p>' . __( 'Insert code to be printed in the theme footer.', 'wh-hfcode' ) . '</p>';
	}
	
	/**
	 * Render the option fields
	 *
	 * @since  1.0.0
	 */
	public function wh_Cf7mc_Connector_api_key_cb() {
		$api_key = get_option( 'api_key' );
		?>
			<input style="width: 100%;" type="text" name="api_key" id="api_key" value="<?php echo $api_key; ?>" />
			<p><em>Generate an API Key inside your Mailchimp account settings page.</em></p>	
			
		<?php
	}
	
	public function wh_Cf7mc_Connector_list_id_cb() {
		
		function wh_get_mailchimp_lists() {
			$wh_api = get_option( 'api_key' );
			
			if ( ! empty( $wh_api ) ) {
				
				$api_key = trim( $wh_api );
		
				$lists = array();
				
				$api = new MCAPI( $api_key );
				$list_data = $api->lists();
				if ( $list_data ) {
					foreach ( $list_data['data'] as $key => $list ) {
						$lists[ $key ]['id']   = $list['id'];
						$lists[ $key ]['name'] = $list['name'];
					}
				}
				return $lists;
			}
			return false;
		}
		
		$lists = wh_get_mailchimp_lists();
		$list_id = get_option( 'list_id' );
		?>
			<select id="list_id" name="list_id">
				<?php
					if ( $lists ) :
						foreach ( $lists as $list ) :
							echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
						endforeach;
					else :
				?>
				<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
			<?php endif; ?>
			</select>
			<p><em>First save your API KEY! Then check if your lists show up.</em></p>
			
		<?php
	}
	
	public function wh_Cf7mc_Connector_honeypot_cb() {
		$honeypot = get_option( 'honeypot' );
		?>
			<input type="checkbox" name="honeypot" value="1" <?php checked( $honeypot , 1 ); ?> > <em>Will be generated an hidden field for spam prevention. <br><b>Put this shortcode in your forms:</b></em> <pre style ="display: inline-block;">[text honeypot class:honeypot]</pre>	
			
		<?php
	}
	
	public function wh_Cf7mc_Connector_debug_cb() {
		$debug = get_option( 'debug' );
		?>
			<input type="checkbox" name="debug" value="1" <?php checked( $debug , 1 ); ?> > <em>Will be generated a file called devlog.txt in the site root folder for debug purpose.</em>
			
		<?php
	}
	
	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $position $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function wh_Cf7mc_Connector_sanitize_code( $list_id ) {
		esc_attr( $list_id );
	    return $list_id;
	}
}
