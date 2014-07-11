<?php
if ( !defined('ABSPATH') ) {
/** Load WordPress Bootstrap */
//include "../../../../../wp-load.php"; // for _e() function
}
?>
<style>
	.cw_epu_popup_form{overflow:hidden!important;}
	.cw_epu_popup_form #TB_ajaxContent{overflow-y:scroll!important;}
  .cw-epu-popup-form-wrapper{}
  .cw-epu-popup-form-wrapper .fieldset-wrapper{margin-bottom:10px;}	
  .cw-epu-popup-form-wrapper label{display:block;float:left;width:130px;line-height: 23px;}
  .cw-epu-popup-form-wrapper label.simple{display:inline;float:none;}
  .cw-epu-popup-form-wrapper a{color:#21759b !important;}
  .cw-epu-popup-form-wrapper a:hover{color:#333 !important;text-decoration: none !important;}
  .cw-epu-popup-form-wrapper fieldset{padding:4px 9px 7px 9px;border:1px solid #ccc;}
  .cw-epu-popup-form-wrapper .field-row{margin:7px 0px;}
  .cw-epu-popup-form-wrapper .field-help{font-size:0.8em}
  .cw-epu-popup-form-wrapper .field-descr{font-size:0.9em}
</style>
<div id="cw-epu-popup-wrapper">
  <h2>Insert Email Pickup Form</h2>
  <div class="cw-epu-popup-form-wrapper">
    <p class="field-descr">
      You can insert email pickup shortcode using form below. No options are required. </br>
      <a href="http://circlewaves.com/products/plugins/email-pick-up/" target="_blank">Visit official plugin page to learn more &gt;</a>
    </p>
    <form id="cw-epu-popup-form">
      <div class="fieldset-wrapper">
          <fieldset>
            <legend>Label</legend>
            <div class="field-row"><input type="checkbox" id="cw-epu-hide-label" name="cw_epu_hide_label" /> <label class="simple" for="cw-epu-hide-label">Hide input label</label></div>
            <div class="field-row"><label for="cw-epu-label-text">Label Text:</label><input id="cw-epu-label-text" name="cw_epu_label_text" type="text" /> <span class="field-help">Default is "Your E-mail"</span></div>
          </fieldset>
      </div>
      <div class="fieldset-wrapper">
        <fieldset>
          <legend>Messages</legend>
          <div class="field-row"><label for="cw-epu-success-message">Success Messages:</label><input id="cw-epu-success-message" name="cw_epu_success_message" type="text" /> <span class="field-help">Default is "Thank you!"</span></div>
          <div class="field-row"><label for="cw-epu-error-message">Error Messages:</label><input id="cw-epu-error-message" name="cw_epu_error_message" type="text" /> <span class="field-help">Default is "Please enter your email"</span></div>
        </fieldset>
      </div>
      <div class="fieldset-wrapper">
        <fieldset>
          <legend>INinbox integration</legend>
            <div class="field-row"><input type="checkbox" id="cw-epu-api-name" name="cw_epu_api_name" /> <label class="simple" for="cw-epu-api-name">Integrate with <a href="http://www.ininbox.com/" target="_blank" title="Learn more">INinbox</a></label></div>
            <div class="field-row"><label for="cw-epu-api-key">API Key:</label><input id="cw-epu-api-key" name="cw_epu_api_key" type="text" /> <span class="field-help"><a href="http://www.ininbox.com/api" target="_blank" title="Learn more">Learn more</a></span></div>
            <div class="field-row"><label for="cw-epu-api-list">API List:</label><input id="cw-epu-api-list" name="cw_epu_api_list" type="text" /> <span class="field-help">Comma-separated Lists IDs</span></div>
        </fieldset>
      </div>			
      <div class="fieldset-wrapper">
        <fieldset>
          <legend>Other Options</legend>
          <div class="field-row"><label for="cw-epu-placeholder">Input Placeholder:</label><input id="cw-epu-placeholder" name="cw_epu_placeholder" type="text" /> <span class="field-help">Default is empty</span></div>
          <div class="field-row"><label for="cw-epu-button-text">Submit Button Text:</label><input id="cw-epu-button-text" name="cw_epu_button_text" type="text" /> <span class="field-help">Default is "Submit"</span></div>
          <div class="field-row"><label for="cw-epu-refer">Subscriber List:</label><input id="cw-epu-refer" name="cw_epu_refer" type="text" /> <span class="field-help">Default is "Main List"</span></div>
          <div class="field-row"><label for="cw-epu-redirect">Redirect Page:</label><input id="cw-epu-redirect" name="cw_epu_redirect" type="text" /> <span class="field-help">Default is empty</span></div>
        </fieldset>
      </div>
      <div class="fieldset-wrapper">
        <fieldset>
          <legend>Styling | <a class="field-descr" href="http://circlewaves.com/products/plugins/email-pick-up/" target="_blank">See Showcases &gt;</a></legend>
          <div class="field-row"><label for="cw-epu-css-class">Custom CSS Class:</label><input id="cw-epu-css-class" name="cw_epu_css_class" type="text" /> <span class="field-help">Default is empty</span></div>
        </fieldset>
      </div>
      <div class="submit">
        <input type="button" id="cw-epu-submit" class="button-primary" value="Insert Form" name="submit" />
      </div>
    </form>
  </div>
</div>