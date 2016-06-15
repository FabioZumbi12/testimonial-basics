/*
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
jQuery(document).ready(function(){
	
	jQuery("a.katb_excerpt_more").each(function(i, obj) {
		var movElement = '';
		var navID = jQuery(this).data("id");
		movElement = '#'+ 'popwrap_'+navID;
		//alert(movElement);
		jQuery( movElement ).prependTo( jQuery( "body" ) );
	});	
		
	jQuery(function(jQuery) {
		//alert("loading");
		var element = '';
		var element2 = '';
		jQuery("a.katb_excerpt_more").click(function() {
			var navID = jQuery(this).data("id");
			element = '#'+navID+'.katb_topopup';
			element2 = '#'+navID+'_bg.katb_excerpt_popup_bg';
			setTimeout(function(){ // then show popup, delay in .5 second
				loadPopup(element); // function show popup
			}, 500); // .5 second
		return false;
		});
	
		/* event for close the popup */
		jQuery("div.katb_close").hover(
			function() {
				jQuery("span.ecs_tooltip").show();
			},
			function () {
				jQuery("span.ecs_tooltip").hide();
			}
		);
	
		jQuery("div.katb_close").click(function() {
			disablePopup();  // function close pop up
		});
	
		jQuery(this).keyup(function(event) {
			if (event.which == 27) { // 27 is 'Ecs' in the keyboard
				disablePopup();  // function close pop up
			}
		});
	
		 /************** start: functions. **************/
		var popupStatus = 0; // set value
	
		function loadPopup(element) {
			if(popupStatus == 0) { // if value is 0, show popup
				jQuery(element).fadeIn(0500); // fadein popup div
				jQuery(element2).css("opacity", "0.7"); // css opacity, supports IE7, IE8
				jQuery(element2).fadeIn(0001);
				popupStatus = 1; // and set value to 1
			}
		}
	
		function disablePopup() {
			if(popupStatus == 1) { // if value is 1, close popup
				jQuery(element).fadeOut("normal");
				jQuery(element2).fadeOut("normal");
				popupStatus = 0;  // and set value to 0
			}
		}
		/************** end: functions. **************/
	}); // jQuery End

});