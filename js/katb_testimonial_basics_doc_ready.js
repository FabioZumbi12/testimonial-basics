/*
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
jQuery(document).ready(function(){

	//call to use colorpicker
	jQuery( '.hexcolor' ).wpColorPicker();

	/*
	 * This script enhances the error message used in the theme options section.
	 */
	var error_msg = jQuery("#message p[class='setting-error-message']");  
    // look for admin messages with the "setting-error-message" error class  
    if (error_msg.length != 0) {  
        // get the title  
        var error_setting = error_msg.attr('title');  
  
        // look for the label with the "for" attribute=setting title and give it an "error" class (style this in the css file!)  
        jQuery("label[for='" + error_setting + "']").addClass('error');  
  
        // look for the input with id=setting title and add a red border to it.  
        jQuery("input[id='" + error_setting + "']").attr('style', 'border-color: red'); 
    }
 
 	// Upload a photo within testimonial basic admin
    var custom_uploader;
 
 
    jQuery('#katb_upload_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('#katb_upload_image').val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
  
	});

});