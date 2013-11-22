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

  <div class="postbox-container right-sidebar cw-epu-no-print">
    <div class="metabox-holder"><div class="meta-box-sortables">
        <div id="cw-epu-supportus" class="postbox">
          <h3 class="hndle"><span><?php  _e('Help us to make it better');?></span></h3>
          <div class="inside">
           <p class="descr">Don't hesitate to leave your feedback, it helps us moving forward!</p>
            <ul>
              <li>
                <a href="http://wordpress.org/plugins/email-pick-up/" target="_blank" title="Rate this plugin">Rate this plugin</a><br />
                <span class="descr-small">We don't ask you for 5 stars feedback, rate it as you wish</span>
               </li>
              <li>
                <a href="http://circlewaves.com/support/suggest-feature/" target="_blank" title="Suggest feature">Suggest feature</a><br />
                <span class="descr-small">Have a great idea? Let us know!</span>
              </li>
              <li>
                <a href="http://circlewaves.com/support/report-bug/" target="_blank" title="Report bug">Report bug</a><br />
                <span class="descr-small">Find a bug? Let us take care!</span>
               </li>
              <li>
                <a href="http://circlewaves.com/products/plugins/email-pick-up/" target="_blank" title="See plugin FAQ">See plugin FAQ</a><br />
                <span class="descr-small">Want to learn more? Visit official plugin page</span>
              </li>
            </ul>
            <p class="descr">Our related stuff:</p>
            <ul>
              <li>
                <a href="http://circlewaves.com/blog/boxi-html-email-template/" target="_blank" title="Boxi – HTML Email Template">Boxi – HTML Email Template</a><br />
                <span class="descr-small">Use this cute free template for your newsletters</span>
              </li>
            </ul>
            <div class="cw-admin-footer">
              <div class="left-col"><a href="http://circlewaves.com/" title="circlewaves.com" target="_blank"><img src="<?php echo plugins_url( '/img/logo_cw.png', dirname(__FILE__) );?>" /></a></div>
              <div class="right-col">Developed by <a href="http://circlewaves.com/" title="circlewaves.com" target="_blank">circlewaves.com</a> <br /> <a href="http://twitter.com/CircleWavesLLC" target="_blank" title="Twitter">Twitter</a> | <a href="http://www.facebook.com/CircleWavesLLC" target="_blank" title="Facebook">Facebook</a> | <a href="http://circlewaves.com/hire-us/" target="_blank" title="Hire Us">Hire Us</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

	
</div>	