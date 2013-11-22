<?php
/**
 * Plugin Name.
 *
 * @package   CW_Email_Pick_Up_Admin
 * @author    circlewaves-team <support@circlewaves.com>
 * @license   GPL-2.0+
 * @link      http://circlewaves.com
 * @copyright 2013 CircleWaves (support@circlewaves.com)
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 *
 * @package CW_Email_Pick_Up_Admin
 * @author  circlewaves-team <support@circlewaves.com>
 */
class CW_Email_Pick_Up_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	protected $plugin_screen_hook_suffix_view_subscribers_list = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 */
		$plugin = CW_Email_Pick_Up::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		
		//Add submenu
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_submenu' ) );

		/*
		 * Add an action link pointing to the options page.
		 *
		 */
		$plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) . 'email-pick-up.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
/*
    add_action( 'TODO', array( $this, 'action_method_name' ) );
		add_filter( 'TODO', array( $this, 'filter_method_name' ) );
*/

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

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ($this->plugin_screen_hook_suffix == $screen->id)||($this->plugin_screen_hook_suffix_view_subscribers_list == $screen->id) ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), CW_Email_Pick_Up::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), CW_Email_Pick_Up::VERSION );
			
			//add custom variables to admin.js, use cw_epu_js_var.var_name
			$cw_epu_js_var = array( 'plugin_url' => plugins_url('', __FILE__ ) );
			wp_localize_script( $this->plugin_slug . '-admin-script', 'cw_epu_js_var', $cw_epu_js_var );			
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {


		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Email Pick Up', $this->plugin_slug ),
			__( 'Email Pick Up', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' ),
      plugins_url( 'img/menu_icon.png', __FILE__)
		);
		

	}
	
	/**
	 * Register the administration submenu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.1
	 */
	public function add_plugin_admin_submenu() {


		$this->plugin_screen_hook_suffix_view_subscribers_list = add_submenu_page(
			$this->plugin_slug,
			__( 'View Subscribers List', $this->plugin_slug ),
			__( 'View Subscribers List', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug.'-view-subscribers-list',
			array( $this, 'display_plugin_admin_subpage_subscribers_list' )
		);
		

	}	

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
    global $wpdb;
    $epu_table_name = $wpdb->prefix . "cw_epu_subscribers";
		include_once( 'views/admin.php' );
	}

	/**
	 * Render the View Subscribers page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_subpage_subscribers_list() {
    global $wpdb;
    $epu_table_name = $wpdb->prefix . "cw_epu_subscribers";
		include_once( 'views/cw-epu-admin-show-subscribers.php' );
	}	
	
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}




}