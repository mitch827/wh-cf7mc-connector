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
	private $languages;

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
		$this->multilang = (bool) get_option( $this->option_name . '_multilanguage' );
		$this->languages =  get_option( $this->option_name . '_lang' );

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
		
		// Add a General section
		add_settings_section(
		    $this->option_name . '_general',
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
		
		add_settings_field(
		    'api_key',
		    __( 'Mailchimp API key', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_api_key_cb' ),
		    $this->plugin_name . '_mailchimp_account',
		    $this->option_name . '_general',
		    array( 'label_for' => 'api_key' )
		);
		
		if( ! $this->multilang ){
			add_settings_field(
			    'list_id',
			    __( 'List ID', 'wh-cf7mc-connector' ),
			    array( $this, $this->option_name . '_list_id_cb' ),
			    $this->plugin_name . '_mailchimp_account',
			    $this->option_name . '_general',
			    array( 'label_for' => 'list_id' )
			);
		}
		if( $this->multilang ){
			add_settings_field(
			    $this->option_name . '_lang',
			    __( 'Languages', 'wh-cf7mc-connector' ),
			    array( $this, $this->option_name . '_lang_cb' ),
			    $this->plugin_name . '_mailchimp_account',
			    $this->option_name . '_general',
			    array( 'label_for' => $this->option_name . '_lang' )
			);
		}
		if( $this->multilang ){
			if( $this->languages ){
				foreach ( $this->languages as $lang ){
					add_settings_field(
						$this->option_name . '_list_id_' . $lang,
						__( 'List ID', 'wh-cf7mc-connector'). ' '.  $lang,
						array( $this, $this->option_name . '_multilang_list_id_cb_'. $lang ),
						$this->plugin_name . '_mailchimp_account',
						$this->option_name . '_general',
						array( 'label_for' => 'list_id_'. $lang )
					);
				}
			}
		}
			
		add_settings_field(
		    $this->option_name . '_nl',
		    __( 'Newsletter subscription form', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_nl_cb' ),
		    $this->plugin_name . '_form_data',
		    $this->option_name . '_form_data',
		    array( 'label_for' => $this->option_name . '_nl' )
		);
		
		add_settings_field(
		    $this->option_name . '_cf',
		    __( 'Complete contact form', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_cf_cb' ),
		    $this->plugin_name . '_form_data',
		    $this->option_name . '_form_data',
		    array( 'label_for' => $this->option_name . '_cf' )
		);
		
		add_settings_field(
			$this->option_name . "_multilanguage",
			__( "Multilanguage forms", "wh-cf7mc-connector" ),
			array( $this, $this->option_name . "_multilanguage_cb"),
			$this->plugin_name . "_form_data",
			$this->option_name . '_form_data',
			array( 'label_for' => $this->option_name . "_multilanguage" )
			
		);
		
		add_settings_field(
		    'honeypot',
		    __( 'Honeypot', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_honeypot_cb' ),
		    $this->plugin_name . '_extra',
		    $this->option_name . '_extra',
			array( 'label_for' => 'honeypot' )
		);
		
		add_settings_field(
		    'debug',
		    __( 'Debug', 'wh-cf7mc-connector' ),
		    array( $this, $this->option_name . '_debug_cb' ),
		    $this->plugin_name . '_extra',
		    $this->option_name . '_extra',
			array( 'label_for' => 'debug' )
		);

		register_setting( $this->plugin_name . '_mailchimp_account', 'api_key','strval' );
		register_setting( $this->plugin_name . '_mailchimp_account', 'list_id', array( $this, $this->option_name . '_sanitize_code' )  );
		register_setting( $this->plugin_name . '_mailchimp_account', $this->option_name . '_lang' );
		foreach( $this->languages as $lang ) :
			register_setting( $this->plugin_name . '_mailchimp_account', $this->option_name . '_list_id_' . $lang);
		endforeach;
		register_setting( $this->plugin_name . '_form_data', $this->option_name . '_nl' );
		register_setting( $this->plugin_name . '_form_data', $this->option_name . '_cf' );
		register_setting( $this->plugin_name . '_form_data', $this->option_name . '_multilanguage' );
		register_setting( $this->plugin_name . '_extra', 'honeypot', array( $this, $this->option_name . '_sanitize_code' )  );
		register_setting( $this->plugin_name . '_extra', 'debug', array( $this, $this->option_name . '_sanitize_code' )  );

	//	register_setting( $this->plugin_name, $this->option_name . '_day', array( $this, $this->option_name . '_sanitize_position' ) );
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
						Standard CF7 form names: <code>Iscrizione newsletter</code>, <code>Contact form</code>
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
	 * Render the option fields
	 *
	 * @since  1.0.0
	 */
	public function wh_Cf7mc_Connector_api_key_cb() {
		$api_key = get_option( 'api_key' );
		?>
			<input style="width: 50%;" type="text" name="api_key" id="api_key" value="<?php echo $api_key; ?>" />
			<p class="description">Generate an API Key inside your Mailchimp account settings page.</p>
			
		<?php
	}
	
	public function wh_Cf7mc_Connector_multilanguage_cb() {
		?>
			<label>
			<input type="checkbox" name="<?php echo $this->option_name . '_multilanguage'; ?>" value="1" <?php checked( $this->multilang , 1 ); ?> > Multilanguage site
			</label>
			<p class="description">Checking this, you'll be able to select <strong> the languages</strong>for different list IDs. Save the form to see the languages.</p>
		<?php
	}
	
	public function wh_get_mailchimp_lists() {
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
	
	public function wh_Cf7mc_Connector_list_id_cb() {
		
		$lists = $this->wh_get_mailchimp_lists();
		$list_id = get_option( 'list_id' );
		
		if( ! $this->multilang ){
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
				<p class="description">First <strong>save your API KEY!</strong> Then check if your lists show up.</p>
				
			<?php
		}
	}
	
	public function wh_Cf7mc_Connector_multilang_list_id_cb_en() {
		
		$lists = $this->wh_get_mailchimp_lists();
		$list_id_en = get_option( $this->option_name . '_list_id_en' );
		
		if( $this->multilang ){
			?>
				<select id="list_id_en" name="<?php echo $this->option_name . '_list_id_en'; ?>">
					<?php
						if ( $lists ) :
							foreach ( $lists as $list ) :
								echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id_en, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
							endforeach;
						else :
					?>
					<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
				<?php endif; ?>
				</select>
				
			<?php
		}
	}
	
	public function wh_Cf7mc_Connector_multilang_list_id_cb_fr() {
		
		$lists = $this->wh_get_mailchimp_lists();
		$list_id_fr = get_option( $this->option_name . '_list_id_fr' );
		
		if( $this->multilang ){
			?>
				<select id="list_id_fr" name="<?php echo $this->option_name . '_list_id_fr'; ?>">
					<?php
						if ( $lists ) :
							foreach ( $lists as $list ) :
								echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id_fr, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
							endforeach;
						else :
					?>
					<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
				<?php endif; ?>
				</select>
				
			<?php
		}
	}
	
	public function wh_Cf7mc_Connector_multilang_list_id_cb_de() {
		
		$lists = $this->wh_get_mailchimp_lists();
		$list_id_de = get_option( $this->option_name . '_list_id_de' );
		
		if( $this->multilang ){
			?>
				<select id="list_id_de" name="<?php echo $this->option_name . '_list_id_de'; ?>">
					<?php
						if ( $lists ) :
							foreach ( $lists as $list ) :
								echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id_de, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
							endforeach;
						else :
					?>
					<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
				<?php endif; ?>
				</select>
				
			<?php 
		}
	}
	
	public function wh_Cf7mc_Connector_multilang_list_id_cb_it() {
		
		$lists = $this->wh_get_mailchimp_lists();
		$list_id_it = get_option( $this->option_name . '_list_id_it' );
		
		if( $this->multilang ){
			?>
				<select id="list_id_it" name="<?php echo $this->option_name . '_list_id_it'; ?>">
					<?php
						if ( $lists ) :
							foreach ( $lists as $list ) :
								echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id_it, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
							endforeach;
						else :
					?>
					<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
				<?php endif; ?>
				</select>
				
			<?php
		}
	}
	
	public function wh_Cf7mc_Connector_multilang_list_id_cb_pt() {
		
		$lists = $this->wh_get_mailchimp_lists();
		$list_id_pt = get_option( $this->option_name . '_list_id_pt' );
		
		if( $this->multilang ){
			?>
				<select id="list_id_pt" name="<?php echo $this->option_name . '_list_id_pt'; ?>">
					<?php
						if ( $lists ) :
							foreach ( $lists as $list ) :
								echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id_pt, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
							endforeach;
						else :
					?>
					<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
				<?php endif; ?>
				</select>
				
			<?php
		}
	}
	
	public function wh_Cf7mc_Connector_multilang_list_id_cb_es() {
		
		$lists = $this->wh_get_mailchimp_lists();
		$list_id_es = get_option( $this->option_name . '_list_id_es' );
		
		if( $this->multilang ){
			?>
				<select id="list_id_es" name="<?php echo $this->option_name . '_list_id_es'; ?>">
					<?php
						if ( $lists ) :
							foreach ( $lists as $list ) :
								echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $list_id_es, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
							endforeach;
						else :
					?>
					<option value="no list"><?php _e( 'no lists', 'wh-mailchimp-cf7-connector' ); ?></option>
				<?php endif; ?>
				</select>
				
			<?php
		}
	}
	
	public function wh_Cf7mc_Connector_lang_cb() {
		
		if( $this->multilang ){
			$lang_code = array(
				"English" 		=> "en",
				"French" 		=> "fr",
				"German" 		=> "de",
				"Italian" 		=> "it",
				"Portuguese" 	=> "pt",
				"Spanish" 		=> "es"
			);
			?>
			
			<select id="lang" name="<?php echo $this->option_name . '_lang[]'; ?>" multiple="multiple" style="width: 200px; height:200px;">
				<?php 
					foreach ( $lang_code as $code_name => $code ) :
						echo '<option value="' . $code . '"' . selected( true, in_array($code, $this->languages), false ) . '>' . $code_name . '</option>';
					endforeach;
				?>
			</select>
			<p class="description">Select languages and <strong>save the form</strong>. You'll be able to selects different list ids for the languages chosen.</p>
			<?php
		}
			
	}
	
	public function wh_Cf7mc_Connector_nl_cb() {
		$nl = get_option( $this->option_name . '_nl' );
		?>
			<label>
			<input type="checkbox" name="<?php echo $this->option_name . '_nl'; ?>" value="1" <?php checked( $nl , 1 ); ?> > Using newsletter subscription form
			</label>
			<p class="description">Email field: <strong>"email-nl"</strong>.</p>
		<?php
	}
	
	public function wh_Cf7mc_Connector_cf_cb() {
		$cf = get_option( $this->option_name . '_cf' );
		?>
			<label>
			<input type="checkbox" name="<?php echo $this->option_name . '_cf'; ?>" value="1" <?php checked( $cf , 1 ); ?> > Using complete contact form
			</label>
			<p class="description">Email field: <strong>"email-cf"</strong>. Newsletter subscription: <strong>"mailchimp-optin"</strong>.</p>
		<?php
	}
	
	public function wh_Cf7mc_Connector_honeypot_cb() {
		$honeypot = get_option( 'honeypot' );
		?>	
			<label>
			<input type="checkbox" name="honeypot" value="1" <?php checked( $honeypot , 1 ); ?> > Use honeypot
			</label>
			<p class="description">Insert an hidden field for spam prevention. <b>Put this shortcode in your forms:</b> <code>[text honeypot class:honeypot]</code></p>
			
		<?php
	}
	
	public function wh_Cf7mc_Connector_debug_cb() {
		$debug = get_option( 'debug' );
		?>	
			<label>
			<input type="checkbox" name="debug" value="1" <?php checked( $debug , 1 ); ?> > Debug activated
			</label> 
			<p class="description">Generate a file called <code>devlog.txt</code> in the site root folder for debug purpose.</p>
			
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
