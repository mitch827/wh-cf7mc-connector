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
	 * Multilanguage variable used to check if forms are to be translated.
	 *
	 * @since    1.0.9a
	 * @access   private
	 * @var      bool    $multilang    Multilanguage yes/no.
	 */
	private $multilang;
	
	/**
	 * Languages used in this site.
	 *
	 * @since    1.0.9a
	 * @access   private
	 * @var      array    $languages    Languages of the contact forms.
	 */
	private $languages = array();

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
		
		$this->languages =  get_option( $this->option_name . '_lang' );

	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wh-cf7mc-connector-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wh-cf7mc-connector-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * This function provides simple check for the presence of WPML plugin.
	 * 
	 * @access public
	 * @return void
	 */
	public function wpml_check(){
		if (defined ( 'ICL_LANGUAGE_CODE' ) ){
			$wpml_check = ICL_LANGUAGE_CODE;
			if ( !empty( $wpml_check ) ){
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
	 
	    $this->plugin_screen_hook_suffix = add_submenu_page(
	    'web-heroes', 
	    __( 'Web Heroes CF7 - Mailchimp Connector', 'wh-cf7mc-connector' ), 
	    __( 'CF7 - Mailchimp', 'wh-cf7mc-connector' ), 
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
		$wpml = $this->wpml_check(); //check for the presence of WPML
		
		// Add sections
		add_settings_section(
		    $this->option_name . '_mailchimp_account',
		    __( 'General', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_general_cb' ),
		    $this->plugin_name . '_mailchimp_account'
		);
		
		add_settings_section(
		    $this->option_name . '_extra',
		    __( 'Extra', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_extra_cb' ),
		    $this->plugin_name . '_extra'
		);
		
		add_settings_section(
		    $this->option_name . '_form_data',
		    __( 'CF7 settings', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_form_data_cb' ),
		    $this->plugin_name . '_form_data'
		);
		
		//Add settings fields
		add_settings_field(
		    $this->option_name . '_api_key',
		    __( 'Mailchimp API key', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_api_key_cb' ),
		    $this->plugin_name . '_mailchimp_account',
		    $this->option_name . '_mailchimp_account',
		    array( 'label_for' => $this->option_name . '_api_key' )
		);
		
		if ( TRUE === $wpml ){
			add_settings_field(
			    $this->option_name . '_lang',
			    __( 'Languages', 'wh-cf7mc-connector' ),
			    array( $this, $this->option_name . '_lang_cb' ),
			    $this->plugin_name . '_mailchimp_account',
			    $this->option_name . '_mailchimp_account',
			    array( 'label_for' => $this->option_name . '_lang' )
			);
		
			if ( isset( $this->languages ) && !empty( $this->languages ) ){
				foreach ( $this->languages as $lang ){
					add_settings_field(
						$this->option_name . '_list_id_multi[ ' . $lang . ']',
						__( 'List ID', 'wh-cf7mc-connector'). ' '.  $lang,
						array( $this, $this->option_name . '_list_id_cb' ),
						$this->plugin_name . '_mailchimp_account',
						$this->option_name . '_mailchimp_account',
						$param = array( 
							'label_for' => $this->option_name . '_list_id_multi[ ' . $lang . ']',
							'language' 	=> $lang
						)
					);
					register_setting( $this->plugin_name . '_mailchimp_account', $this->option_name . '_list_id_multi' );
				}
			}
		} else {
			add_settings_field(
			     $this->option_name . '_list_id',
			    __( 'List ID', 'wh-cf7mc-connector' ),
			    array( $this, $this->option_name . '_list_id_cb' ),
			    $this->plugin_name . '_mailchimp_account',
			    $this->option_name . '_mailchimp_account',
			    $param = array( 
					'label_for' => $this->option_name . '_list_id',
					'language' 	=> FALSE
				)
			);
			register_setting( $this->plugin_name . '_mailchimp_account', $this->option_name . '_list_id' );
		}
			
		add_settings_field(
		    $this->option_name . '_nl',
		    __( 'Newsletter subscription form', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_checkbox_cb' ),
		    $this->plugin_name . '_form_data',
		    $this->option_name . '_form_data',
		    $param = array( 
		    	'label_for' => $this->option_name . '_nl',
		    	'type' 		=> 'nl'
		    )
		);
		
		add_settings_field(
		    $this->option_name . '_cf',
		    __( 'Complete contact form', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_checkbox_cb' ),
		    $this->plugin_name . '_form_data',
		    $this->option_name . '_form_data',
		    $param = array( 
		    	'label_for' => $this->option_name . '_cf',
		    	'type' 		=> 'cf'
		    )
		);
		
		add_settings_field(
		    $this->option_name . '_honeypot',
		    __( 'Honeypot', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_checkbox_cb' ),
		    $this->plugin_name . '_extra',
		    $this->option_name . '_extra',
			$param = array( 
				'label_for' => $this->option_name . '_honeypot',
				'type' 		=> 'honeypot'
			)
		);
		
		add_settings_field(
		    $this->option_name . '_debug',
		    __( 'Debug', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_checkbox_cb' ),
		    $this->plugin_name . '_extra',
		    $this->option_name . '_extra',
			$param = array( 
				'label_for' => $this->option_name . '_debug',
				'type' 		=> 'debug'
			)
		);

		register_setting( $this->plugin_name . '_mailchimp_account', $this->option_name . '_api_key','strval' );
		register_setting( $this->plugin_name . '_mailchimp_account', $this->option_name . '_list_id', array( $this, $this->option_name . '_sanitize_code' )  );
		register_setting( $this->plugin_name . '_mailchimp_account', $this->option_name . '_lang' );
		register_setting( $this->plugin_name . '_form_data', $this->option_name . '_nl' );
		register_setting( $this->plugin_name . '_form_data', $this->option_name . '_cf' );
		register_setting( $this->plugin_name . '_extra', $this->option_name . '_honeypot', array( $this, $this->option_name . '_sanitize_code' )  );
		register_setting( $this->plugin_name . '_extra', $this->option_name . '_debug', array( $this, $this->option_name . '_sanitize_code' )  );
	}
	
	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function wh_Cf7mc_Connector_general_cb() {
	    ?>
	    <div id ="welcome-panel" class="welcome-panel">
		    <div class="welcome-panel-content">
				<div class="welcome-panel-column" style="width: 50%;">
					<h4><?php _e("How to use", "wh-cf7mc-connector"); ?></h4>
					<p class="message">
						<?php _e( 'Remember to use this labels on Mailchimp, groupings: <ul><li>Group details: <strong>"Dal sito"</strong></li><li>Group names: <strong>CF7 form name</strong></li></ul>', 'wh-cf7mc-connector' ); ?>
					</p>
					<p class="message">
						<?php _e('Standard CF7 form names', 'wh-cf7mc-connector'); ?>: <code>Iscrizione newsletter</code>, <code>Contact form</code>
					</p>
				</div>
		    </div>
	    </div>
	    <?php
	}
	
	public function wh_Cf7mc_Connector_form_data_cb() {
	    ?>
	    <div id ="welcome-panel" class="welcome-panel">
		    <div class="welcome-panel-content">
			    <div class="welcome-panel-column" style="width: 50%;">
				    <h4><?php _e("How to use", "wh-cf7mc-connector"); ?></h4>
				    <p class="message">Use these contact forms:</p>
				    <p class="message"><strong>Form name: "Iscrizione Newsletter"</strong><br/>
					    <code>
						    [text honeypot class:honeypot]<br/>
						    [email* email-nl placeholder akismet:author_email "Indirizzo email.."]<br/>
						    [submit class:button class:tiny "Iscriviti"]
						</code>
					</p>
				</div>
			    <div class="welcome-panel-column" style="width: 50%;">
				    <p class="message"><strong>Form name: "Contact form"</strong><br/>
					    <code>
					    	[email* email-cf placeholder akismet:author_email "paolo@rossi.com"]<br/>
						    [textarea* textarea-cf placeholder "messaggio..."]<br/>
						    [checkbox* checkbox-privacy "Ho letto e accettato"] &lt;a href='privacy-e-note-legali' title='Informativa sulla privacy' target='_blank'&gt;l'informativa sulla Privacy&lt;/a&gt;<br/>
						    [checkbox mailchimp-optin default:1 "Desidero iscrivermi alla newsletter"]<br/>
							[text honeypot class:honeypot]<br/>
							[submit class:button class:right "Invia"]
						</code>
					</p>
			    </div>
		    </div>
	    </div>
	    
	    <?php
	}
	
	public function wh_Cf7mc_Connector_extra_cb() {
	    echo '<p>' . __( 'Antispam & debug options.', 'wh-cf7mc-connector' ) . '</p>';
	}
	 
	/**
	 * wh_Cf7mc_Connector_api_key_cb function.
	 * 
	 * Render an input field to enter the Mailchimp API key
	 *
	 * @access public
	 * @return void
	 */
	public function wh_Cf7mc_Connector_api_key_cb() {
		$api_key = get_option( $this->option_name . '_api_key' );
		?>
			<input style="width: 50%;" type="text" name="<?php echo $this->option_name . '_api_key'; ?>" id="api_key" value="<?php echo $api_key; ?>" />
			<p class="description">Generate an API Key inside your Mailchimp account settings page.</p>
		<?php
	}
	
	/**
	 * wh_Cf7mc_Connector_lang_cb function.
	 * 
	 * Render a multiselect field based on the languages active on the site.
	 *
	 * @access public
	 * @return void
	 */
	public function wh_Cf7mc_Connector_lang_cb() {
		$wpml = $this->wpml_check();
		if ( TRUE === $wpml ){
			$lang_code = apply_filters( 'wpml_active_languages', NULL ); //get current installed languages
			?>
			
			<select id="lang" name="<?php echo $this->option_name . '_lang[]'; ?>" multiple="multiple" style="width: 200px; height:200px;">
				<?php 
					foreach ( $lang_code as $lang_name ) :
						echo '<option value="' . $lang_name['language_code'] . '"' . (( ! $this->languages )? '' : selected( true, in_array($lang_name['language_code'], $this->languages), false ) ) . '>' . $lang_name['translated_name'] . '</option>';
					endforeach;
				?>
			</select>
			<p class="description">Select languages and <strong>save the form</strong>. You'll be able to selects different list ids for the languages chosen.</p>
			
			<?php
		}		
	}
	
	/**
	 * wh_get_mailchimp_lists function.
	 *
	 * Helper method to retrive list from Mailchimp.
	 * 
	 * @access public
	 * @return void
	 */
	public function wh_get_mailchimp_lists() {
		$api_key = get_option( $this->option_name . '_api_key' );
		
		if ( ! empty( $api_key ) ) {
			
			$api_key = trim( $api_key );
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
	
	/**
	 * wh_Cf7mc_Connector_list_id_cb function.
	 *
	 * this function creates a select Mailchimp list ID for every language selected
	 * 
	 * @access public
	 * @param mixed $param -> languages code.
	 * @return void
	 */
	public function wh_Cf7mc_Connector_list_id_cb( $param ) {
		$lists = $this->wh_get_mailchimp_lists(); 					//get mailchimp lists
		$lang = $param['language'];									//function parameter
		
		if ( false !== $lang ){
			$list_id = get_option( $this->option_name . '_list_id_multi' );	//get selected list IDs
			?>
				<select id="<?php echo 'list_id_' . $lang; ?>" name="<?php echo $this->option_name . '_list_id_multi[' . $lang . ']'; ?>">
					<?php
						if ( $lists ) :
							foreach ( $lists as $list ) :
								echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id[ $lang ], $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
							endforeach;
						else :
					?>
					<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
				<?php endif; ?>
				</select>
				
			<?php
		} else {
			$list_id = get_option( $this->option_name . '_list_id' );	//get selected list IDs
			?>
				<select id="list_id" name="<?php echo $this->option_name . '_list_id'; ?>">
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
				<p class="description">First <strong>save your API KEY!</strong> Then check if your lists show up.</p>
				
			<?php
		}
	}
	
	
	public function wh_Cf7mc_Connector_checkbox_cb( $param ) {
		$type = $param['type'];
		$check = get_option( $this->option_name . '_' . $type );
		?>
			<label>
				<input type="checkbox" name="<?php echo $this->option_name . '_' . $type; ?>" value="1" <?php checked( $check , 1 ); ?> > 
				<?php
					if ( $type === 'nl' )
						_e( 'Using newsletter subscription form', 'wh-mailchimp-cf7-connector' );
					if ( $type === 'cf' )
						_e( 'Using complete contact form', 'wh-mailchimp-cf7-connector' );
					if ( $type === 'honeypot' )
						_e( 'Use honeypot', 'wh-mailchimp-cf7-connector' );
					if ( $type === 'debug' )
						_e( 'Debug activated', 'wh-mailchimp-cf7-connector' );
				?>
			</label>
			<p class="description">
				<?php
					if ( $type === 'nl' )
						_e( 'Email field: <strong>"email-nl"</strong>.', 'wh-mailchimp-cf7-connector' );
					if ( $type === 'cf' )
						_e( 'Email field: <strong>"email-cf"</strong>. Newsletter subscription: <strong>"mailchimp-optin"</strong>', 'wh-mailchimp-cf7-connector' );
					if ( $type === 'honeypot' )
						_e( 'Insert an hidden field for spam prevention. <b>Put this shortcode in your forms:</b> <code>[text honeypot class:honeypot]</code>', 'wh-mailchimp-cf7-connector' );
					if ( $type === 'debug' )
						_e( 'Generate a file called <code>devlog.txt</code> in the site root folder for debug purpose.', 'wh-mailchimp-cf7-connector' );
				?>
			</p>
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
