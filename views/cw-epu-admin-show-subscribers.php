<?php
/**
 * Represents the view for the page with subscribers list
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

<div class="wrap cw-epu-wrap-admin">

	<?php screen_icon('epu-admin'); ?>
	<h2 class="cw-epu-no-print"><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<h2 class="cw-epu-print-only">Subscribers List</h2>

  <div class="postbox-container main-admin-container">
    <div class="metabox-holder">	
 <?php
      // get some stats for subscibers
      $epu_emails = $wpdb->get_results(
        "
  SELECT * 
  FROM `$epu_table_name`
	order by `date_added` asc
  ",
        ARRAY_A
      );
      if($epu_emails){?>
					<div class="fieldset-wrapper cw-epu-no-print">
						<fieldset>
							<legend>Actions</legend>
							<a class="button-secondary" href="javascript:window.print()" rel="nofollow" target="_blank">PRINT</a>	 <span class="descr">Print Subscribers List</span>
						</fieldset>
					</div>
          <table class="epu-table widefat cw-epu-print-ready">
            <thead>
            <tr>
              <th>Email</th>
              <th>List Name (Refer)</th>
              <th>Date Subscribed</th>
            </tr>
            </thead>
            <tfoot class="cw-epu-no-print">
            <tr>
              <th>Email</th>
              <th>List Name (Refer)</th>
              <th>Date Subscribed</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            foreach($epu_emails as $epu_email){     ?>
              <tr>
                <td><?php echo $epu_email['email']; ?></td>
                <td><?php echo $epu_email['refer']; ?></td>
                <td><?php echo date('F j, Y g:i A',strtotime($epu_email['date_added'])); ?></td>
              </tr>
            <?php }?>
            </tbody>
          </table>		
      <?php }else{?>
			Sorry, there is no subscribers
			<?php } ?>

		</div>			
	</div>	

<?php include_once( 'includes/admin-sidebar-right.php' );?>

	
</div>	