<?php
/**
 * @package   CW_Email_Pick_Up
 * @author    circlewaves-team <support@circlewaves.com>
 * @license   GPL-2.0+
 * @link      http://circlewaves.com
 * @copyright 2013 CircleWaves (support@circlewaves.com)
 *
 * @wordpress-plugin
 * Plugin Name:       Email Pick Up
 * Plugin URI:        http://circlewaves.com/products/plugins/email-pick-up/
 * Description:       Capture email addresses, useful for landing pages, insert opt-in form into post or page using shortcode, create multiple lists, export emails to CSV
 * Version:           1.0.1
 * Author:            Circlewaves
 * Author URI:        http://circlewaves.com
 * Text Domain:       cw-epu-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


require_once( plugin_dir_path( __FILE__ ) . 'cw-email-pick-up.php' );
require_once( plugin_dir_path( __FILE__ ) . 'cw-email-pick-up-admin.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'CW_Email_Pick_Up', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'CW_Email_Pick_Up', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'CW_Email_Pick_Up', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'CW_Email_Pick_Up_Admin', 'get_instance' ) );