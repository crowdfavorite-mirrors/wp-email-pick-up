(function() {
    tinymce.create('tinymce.plugins.CW_Email_Pick_Up', {


        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            // executes this when the DOM is ready
            jQuery(function(){

                function cw_epu_popup_insert_shortcode(){

                    //default shortocode options
                    var default_options = {
                        'hide_label' : 'no',
                        'label_text' : 'Your E-mail',
                        'placeholder' : '',
                        'button_text' : 'Submit',
                        'error_message' : 'Please enter your email',
                        'success_message' : 'Thank you!',
                        'refer' : 'Main List',
                        'css_class' : ''
                    };

                    // get form id
                    var form_id = jQuery('#cw-epu-popup-form');


                    var shortcode = '[emailpickup';

                    for(var key in default_options) {
                        //get default value
                        var val_default=default_options[key];
                        //get value for same option from form, additional check for checkbox
                        if(key=='hide_label'){
                            var val_new = jQuery("[name='cw_epu_"+key+"']", form_id).is(':checked');
                            val_new=val_new?'yes':'no';
                        }else{
                            var val_new = jQuery("[name='cw_epu_"+key+"']", form_id).val();
                        }
                        //if new value from form isn't the same as default value - insert it into shortcode
                        if((val_new!='')&&(val_new!=val_default)){
                            shortcode += ' ' + key + '="' + val_new + '"';
                        }
                    }

                    shortcode += ']';

                    // inserts the shortcode into the active editor
                    ed.execCommand('mceInsertContent', 0, shortcode);

                    // closes Thickbox
                    tb_remove();
                }

                jQuery.ajax({
                    url: url+"/cw-epu-form.php",
                    success: function (data) {
                        jQuery(data).appendTo('body').hide();
                        jQuery('#cw-epu-submit').bind('click',cw_epu_popup_insert_shortcode);
                    },
                    dataType: 'html'
                });
            });
            ed.addCommand('cw_epu_form', function() {

                //reset popup form to default input values
                jQuery('#cw-epu-popup-form')[0].reset();

                // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 84;
                tb_show( 'Email Pickup Form', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=cw-epu-popup-wrapper' );


            });


            ed.addButton('cw_epu_form', {
                title : 'Add email pickup form shortcode',
                cmd : 'cw_epu_form',
                image : url + '/pickup-form-btn.png'
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                    longname : 'Email Pick Up Buttons',
                    author : 'Circlewaves Team',
                    authorurl : 'http://cirlewaves.com',
                    infourl : 'http://wiki.moxiecode.com/',
                    version : "1.0"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('cw_epu_btns', tinymce.plugins.CW_Email_Pick_Up);

})();