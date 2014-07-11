<?php
/**
 * Email Pick Up
 *
 * @package   CW_Email_Pick_Up
 * @author    circlewaves-team <support@circlewaves.com>
 * @license   GPL-2.0+
 * @link      http://circlewaves.com
 * @copyright 2013 CircleWaves (support@circlewaves.com)
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * @package CW_Email_Pick_Up
 * @author  circlewaves-team <support@circlewaves.com>
 */
class CW_Email_Pick_Up {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.3.0';


  /**
   * Plugin version option name, used for store current plugin version in database
   *
   * @since   1.0.0
   *
   * @var     string
   */
  const OPTION_VERSION = 'cw_epu_version';


	/**
	 * Unique identifier for your plugin.
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'email-pick-up';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );


    add_action( 'init', array( $this, 'cw_epu_tinymce_buttons' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 *@return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}


    //create plugin tables
    if (get_site_option( self::OPTION_VERSION ) != self::VERSION) {
      self::setup_database();
    }

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		//Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		//Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}




  /**
   * Create table cw_epu_subscribers in database
   *
   * @since    1.0.0
   */
  private function setup_database(){

    global $wpdb;

    $epu_table_name = $wpdb->prefix . "cw_epu_subscribers";

    $sql = "CREATE TABLE IF NOT EXISTS $epu_table_name (
  `id` int(11) not null primary key auto_increment,
  `email` varchar(255) null,
  `date_added` datetime null,
  `refer` varchar(255) null
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    update_option( self::OPTION_VERSION, self::VERSION );

  }


  /**
   * Add buttons to TinyMCE and register TinyMCE plugin, see /js/
   *
   * @since    1.0.0
   */
  function cw_epu_tinymce_buttons() {
    add_filter( 'mce_external_plugins', array( $this, 'cw_epu_tinymce_add_buttons' ) );
    add_filter( 'mce_buttons', array( $this, 'cw_epu_tinymce_register_buttons' ) );
  }
  public function cw_epu_tinymce_add_buttons($plugin_array) {
    $plugin_array['cw_epu_btns'] = plugins_url( 'js/tinymce-plugins/cw-epu-plugin.js', __FILE__ );
    return $plugin_array;
  }
  function cw_epu_tinymce_register_buttons($buttons) {
    array_push( $buttons, 'cw_epu_form' );
    return $buttons;
  }


  /**
   * @var form_prefix_id Form counter on the page, used in cw_epu_form_shortcode()
   */
  public $form_prefix_id;

  /**
   * Generate form and handle form data.
   *
   * @since    1.0.0
   */
  public static function cw_epu_form_shortcode($atts=null) {

    global $wpdb;

    global $form_prefix_id;

    //increment form id for each form on same page.
    $form_prefix_id++;

    $hasError=null;
    $hasSuccess=null;
    $formdata=null;

    extract(shortcode_atts(array(
      "hide_label" => 'no',
      "label_text" => 'Your E-mail',
      "placeholder" => '',
      "button_text" => 'Submit',
      "error_message" => 'Please enter your email',
      "success_message" => 'Thank you!',
      "refer" => 'Main List',
      "css_class"=>'',
      "redirect"=>'',
      "api_name"=>'',
      "api_key"=>'',
      "api_list"=>''
    ), $atts));

    $hide_label=strtolower($hide_label);
    $api_name=strtolower($api_name);

    if (((!empty($_SERVER['REQUEST_METHOD']))&&($_SERVER['REQUEST_METHOD'] == 'POST'))&&(!empty( $_POST['cw_epu_nonce_field'] ) && wp_verify_nonce($_POST['cw_epu_nonce_field'],'cw-epu-form-submitted'))&&($_POST['cw_epu_form_prefix_id']==$form_prefix_id)) {



      $formdata=array(
        'cw_epu_email' => esc_attr( $_POST['cw_epu_email_'.$form_prefix_id] )
      );

      if( !$formdata['cw_epu_email'] ){
        $error=$error_message;
        $hasError=true;
      }


      if(!$hasError){
        if( !is_email($formdata['cw_epu_email']) ){
          $error='Please enter a valid email address';
          $hasError=true;
        }
      }

      if(!$hasError){

        $epu_table_name = $wpdb->prefix . "cw_epu_subscribers";

        $wpdb->insert(
          $epu_table_name,
          array(
            'email'=>$formdata['cw_epu_email'],
            'refer'=>$refer,
            'date_added'=>date('Y-m-d H:i:s')
          )
        );
				
				/*
				*	INinbox Integration
				*/
				
				if($api_name=='ininbox'){
					if($api_key && $api_list){

						$api_lists=explode(',',$api_list);
						require_once( plugin_dir_path( __FILE__ ) . 'api/InInboxApiLib/InInboxBase.php' );
						$ininbox=new InInboxBase($api_key);
						$result = $ininbox->contactAdd($formdata['cw_epu_email'], $api_lists);		
					}
				}
				/*
				*	INinbox END
				*/
				
        $success.=$success_message;
        $hasSuccess=true;
      }

      unset($_SERVER['REQUEST_METHOD']);
      unset($_POST);
      $_POST=null;
		
			//redirect if option "redirect" is exist
			if($redirect!=""){
				return '<script type="text/javascript">
				<!--
				window.location = "'.$redirect.'"
				//-->
				</script>';
			}

    }



    $emailpickup_form="";
    $emailpickup_form.='
    <div class="cw-epu-wrapper '.$css_class.'">
    ';
    if($hasSuccess){
      $emailpickup_form.='
        <div class="cw-epu-msg-success">'.translate($success).'</div>
      ';
    }else{
      if($hasError){
        $emailpickup_form.='
          <div class="cw-epu-msg-error">'.translate($error).'</div>
        ';
      }
      $emailpickup_form.='
        <div class="cw-epu-form-wrapper">
          <form class="cw-epu-form" name="cw_epu_form_'.$form_prefix_id.'" id="cw-epu-form-'.$form_prefix_id.'" method="post" action="">
            <input type="hidden" name="cw_epu_form_prefix_id" value="'.$form_prefix_id.'" />
        ';
        if($hide_label!='yes'){
          $emailpickup_form.='
            <label class="cw-epu-label" for="cw-epu-email_'.$form_prefix_id.'">'.translate($label_text).':</label>
          ';
        }
        $emailpickup_form.='
            <input class="cw-epu-input-text" id="cw-epu-email-'.$form_prefix_id.'" type="text" name="cw_epu_email_'.$form_prefix_id.'" size="50" maxlength="50" placeholder="'.translate($placeholder).'" value="'.$formdata['cw_epu_email'].'" />
        ';
        $emailpickup_form.=wp_nonce_field('cw-epu-form-submitted','cw_epu_nonce_field');
        $emailpickup_form.='
            <input class="cw-epu-input-submit" id="cw-epu-submit-'.$form_prefix_id.'" type="submit" name="submit" value="'.translate($button_text).'"  />
          </form>
        </div>
        ';
    }
    $emailpickup_form.='
		</div>
	';

  return $emailpickup_form;

  }

}

//Register shortcode [emailpickup]
add_shortcode('emailpickup', array( 'CW_Email_Pick_Up','cw_epu_form_shortcode'));