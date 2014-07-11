<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   CW_Email_Pick_Up_Admin
 * @author    circlewaves-team <support@circlewaves.com>
 * @license   GPL-2.0+
 * @link      http://circlewaves.com
 * @copyright 2013 CircleWaves (support@circlewaves.com)
 */
?>

<?php

//Notice
$statusMsg=""; //message
$statusType=""; //updated or error

/**
 * Handle export to csv functional
*/
if ( ($_SERVER['REQUEST_METHOD']=='POST') && (!empty( $_POST['cw_epu_nonce_export'] ) && wp_verify_nonce($_POST['cw_epu_nonce_export'],'cw-epu-admin-export')) && is_user_logged_in()) {


// get the $wpdb variable into scope so you may use it
$result = $wpdb->get_results(
"
SELECT `email` as `Email`, `date_added` as `Date Added`, `refer` as `Refer`
FROM `$epu_table_name`
"
, ARRAY_A);
if ($wpdb->num_rows){
// clear out the buffer
  ob_clean();
$date = new DateTime();
$ts = $date->format("Y-m-d-G-i-s");
$filename = "email-pickup-list-$ts.csv";
header( 'Content-Type: text/csv' );
header( 'Content-Disposition: attachment;filename='.$filename);
header("Pragma: no-cache");
header("Expires: 0");

$fp = fopen('php://output', 'w');
$headrow = $result[0];
fputcsv($fp, array_keys($headrow));
foreach ($result as $data) {
fputcsv($fp, $data);
}
fclose($fp);
$contLength = ob_get_length();



header( 'Content-Length: '.$contLength);
exit();
}

}


/**
 * Clear table
 */
if ( ($_SERVER['REQUEST_METHOD']=='POST') && (!empty( $_POST['cw_epu_nonce_clear_table'] ) && wp_verify_nonce($_POST['cw_epu_nonce_clear_table'],'cw-epu-admin-clear-table')) && is_user_logged_in()) {
  $wpdb->query("TRUNCATE TABLE `$epu_table_name`");

  //Notice
  $statusMsg="Table has been cleared successfully"; //message
  $statusType="updated"; //updated or error
}
?>

<div class="wrap cw-epu-wrap-admin">

	<?php screen_icon('epu-admin'); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<?php
if($statusMsg){?>
  <div class="<?php echo ($statusType)?$statusType:'updated';?>"><p><?php _e($statusMsg);?></p></div>
<?php } ?>

  <div class="postbox-container main-admin-container">
    <div class="metabox-holder">


      <div class="fieldset-wrapper">
        <fieldset>
          <legend>How to use</legend>
          <div class="help-descr">
             <div>
             You can insert Email Pick Up form into posts and pages using button <img src="<?php echo plugins_url( '/img/help_btn_pic.png', dirname(__FILE__) );?>" /> in WordPress Visual Editor
             <br />
             or by adding shortcode <strong>[emailpickup]</strong> <br />
             <span class="cw-epu-help-btn descr" id="cw-epu-admin-help-descr-btn">Learn more</span>
             </div>
             <div class="cw-epu-help-wrapper descr" id="cw-epu-admin-help-descr">
             You can customize each form using shortcode options. <br />
              For example, hide input label and add input placeholder: <br />
               <strong>[emailpickup hide_label="yes" placeholder="Enter your email"]</strong>
             <br /><br />
             List of all options:<br />
              <strong>hide_label</strong> - yes/no, default 'no' <br />
              <strong>label_text</strong> - text, default 'Your E-mail' <br />
              <strong>placeholder</strong> - text, default empty <br />
              <strong>button_text</strong> - text, default 'Submit' <br />
              <strong>error_message</strong> - text, default 'Please enter your email' <br />
              <strong>success_message</strong> - text, default 'Thank you!' <br />
              <strong>refer</strong> - text, default 'Main List' <br />
              <strong>css_class</strong> - text, default '' <br />
              <strong>redirect</strong> - text, default '' <br />
							<br />
							<strong>Integration with <a href="http://www.ininbox.com/" target="_blank" title="INinbox">INinbox</a></strong><br />
							Just add following options to the Email Pick Up shortcode: <br />
							 <strong>api_name="INinbox"</strong><br /> 
							 <strong>api_key="YOUR_ININBOX_API_KEY"</strong><br /> 
							 <strong>api_list="your-ininbox-list-id-1,your-ininbox-list-id-2,your-ininbox-list-id-3..etc"</strong><br />
							 For example: <br />
							 <strong>[emailpickup hide_label="yes" placeholder="Enter your email" api_name="INinbox" api_key="xxxxxxxxxxxxxxxxx" api_list="your-ininbox-list-id-1"]</strong><br />or<br />
							 <strong>[emailpickup hide_label="yes" placeholder="Enter your email" api_name="INinbox" api_key="xxxxxxxxxxxxxxxxx" api_list="your-ininbox-list-id-1,your-ininbox-list-id-2"]</strong>
             <br /><br />
               <a href="http://circlewaves.com/products/plugins/email-pick-up/" target="_blank" title="Visit official plugin page to learn more">Visit official plugin page to learn more</a>
            </div>
          </div>
        </fieldset>
      </div>

      <div class="fieldset-wrapper">
        <fieldset>
          <legend>Actions</legend>
            <div class="fieldset-wrapper">
							<a href="admin.php?page=<?php echo $this->plugin_slug.'-view-subscribers-list';?>" title="View Subscribers List" class="thickbox button-secondary">View Subscribers List</a>	 <span class="descr">View/Print Subscribers List</span>
						</div>
            <div class="fieldset-wrapper">
              <form method="post" action="<?php the_permalink(); ?>">
              <?php
              /**
               * Disable buttons if subscribers list is empty
               */
              $email_count = $wpdb->get_var( "SELECT COUNT(id) FROM `$epu_table_name`" );
              ?>
                <input type='submit' value='<?php _e('Export'); ?>' class='button-secondary' <?php echo ($email_count<1)?'disabled':'';?> /> <span class="descr">Export subscribers list to CSV file</span>
                <?php wp_nonce_field('cw-epu-admin-export','cw_epu_nonce_export');?>
              </form>
            </div>
            <div>
              <form method="post" action="<?php the_permalink(); ?>">
                <input type='submit' value='<?php _e('Clear Table'); ?>' class='button-secondary' <?php echo ($email_count<1)?'disabled':'';?> onclick="return confirm('Are you sure that you want to clear table?');" /> <span class="descr">Delete all subscribers</span>
              <?php wp_nonce_field('cw-epu-admin-clear-table','cw_epu_nonce_clear_table');?>
              </form>
            </div>
        </fieldset>
      </div>


      <?php
      // get some stats for subscibers
      $epu_emails = $wpdb->get_results(
        "
  SELECT count(id) as email_count,max(date_added) as last_updated,refer
  FROM `$epu_table_name`
  GROUP BY `refer`
  ",
        ARRAY_A
      );
      if($epu_emails){?>
      <div class="fieldset-wrapper">
        <fieldset>
          <legend>Statistics</legend>
          <table class="epu-table widefat">
            <thead>
            <tr>
              <th>List Name (Refer)</th>
              <th>Subscribers Count</th>
              <th>Last Subscribed</th>
            </tr>
            </thead>
            <tfoot>
          <?php
          $epu_total = $wpdb->get_row("SELECT count(id) as email_count,max(date_added) as last_updated FROM `$epu_table_name`", ARRAY_A);
            if($epu_total){ ?>
            <tr class="total_row">
              <td>TOTAL</td>
              <td><?php echo $epu_total['email_count']?></td>
              <td><?php echo date('F j, Y g:i A',strtotime($epu_total['last_updated'])); ?></td>
            </tr>
          <?php } ?>
            <tr>
              <th>List Name (Refer)</th>
              <th>Subscribers Count</th>
              <th>Last Subscribed</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            foreach($epu_emails as $epu_email){     ?>
              <tr>
                <td><?php echo $epu_email['refer']; ?></td>
                <td><?php echo $epu_email['email_count']; ?></td>
                <td><?php echo date('F j, Y g:i A',strtotime($epu_email['last_updated'])); ?></td>
              </tr>
            <?php }?>
            </tbody>
          </table>
        </fieldset>
      </div>
      <?php }?>



    </div>
  </div>



<?php include_once( 'includes/admin-sidebar-right.php' );?>


</div>
