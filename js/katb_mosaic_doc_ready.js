/*
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
jQuery(document).ready(function(){
		if( jQuery( '.katb_two_col_1' ).length > 0 ) {
		
		var viewPort = katb_viewport();
		var windowSize = viewPort['width'];
		if (windowSize < 800) {
			katb_unwrap_grid_two();
		} else {
			katb_wrap_grid_two();
		}
		
		jQuery(window).resize(function(event){
			
			var viewPort = katb_viewport();
			var windowSize = viewPort['width'];
			if (windowSize < 800) {
				katb_unwrap_grid_two();
			} else {
				katb_wrap_grid_two();
			}
			
		});
	
	}
	
	function katb_unwrap_grid_two(){
		jQuery('.katb_two_wrap_all').unwrap();
		jQuery('.katb_two_wrap_all').wrapAll('<div class="katb_two_col_1"></div>');
		var $wrapper =	jQuery('.katb_two_col_1');
		$wrapper.find('.katb_two_wrap_all').sort(function (a, b) {
			return +a.dataset.order - +b.dataset.order;
		})
		.appendTo( $wrapper );
	}
	
	function katb_wrap_grid_two(){
		jQuery('.katb_two_wrap_all').unwrap();
		jQuery('.katb_two_wrap_1').wrapAll('<div class="katb_two_col_1"></div>');
		jQuery('.katb_two_wrap_2').wrapAll('<div class="katb_two_col_2"></div>');
		
	}
	
	function katb_viewport() {
	    var e = window, a = 'inner';
	    if (!('innerWidth' in window )) {
	        a = 'client';
	        e = document.documentElement || document.body;
	    }
	    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
	}
	
});