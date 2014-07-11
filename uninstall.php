<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   CW_Email_Pick_Up
 * @author    circlewaves-team <support@circlewaves.com>
 * @license   GPL-2.0+
 * @link      http://circlewaves.com
 * @copyright 2013 CircleWaves (support@circlewaves.com)
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;
$cw_epu_option_version = 'cw_epu_version';
$cw_epu_table = $wpdb->prefix."cw_epu_subscribers";

// For Single site
if ( !is_multisite() )
{
  delete_option( $cw_epu_option_version );
}
// For Multisite
else
{
  $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
  $original_blog_id = get_current_blog_id();
  foreach ( $blog_ids as $blog_id )
  {
    switch_to_blog( $blog_id );
    delete_site_option( $cw_epu_option_version );
  }
  switch_to_blog( $original_blog_id );
}

//Delete table
//$wpdb->query("DROP TABLE IF EXISTS $cw_epu_table");