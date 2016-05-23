/*
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
jQuery(document).ready(function(){
	
	jQuery('.katb_rotate').each(function(i, obj) {
		
		jQuery(this).attr('id','katb_rotator_'+i );
		
	});	

	if( jQuery( '#katb_rotator_0' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_0');
		try{
			var speed_0 = katb_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_0 = 7000;
		}
		var katb_rotate_interval_0 = setInterval( katb_rotate_testimonials_0, speed_0 );
		jQuery('#katb_rotator_0' ).hover(function() {
	   		clearInterval(katb_rotate_interval_0);
		}, function() {
			katb_rotate_interval_0 = setInterval( katb_rotate_testimonials_0, speed_0 );
		});
	}
	
	if( jQuery( '#katb_rotator_1' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_1');
		try{
			var speed_1 = katb_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_1 = 7000;
		}
		var katb_rotate_interval_1 = setInterval( katb_rotate_testimonials_1, speed_1 );
		jQuery('#katb_rotator_1' ).hover(function() {
	   		clearInterval(katb_rotate_interval_1);
		}, function() {
			katb_rotate_interval_1 = setInterval( katb_rotate_testimonials_1, speed_1 );
		});
	}
	
	if( jQuery( '#katb_rotator_2' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_2');
		try{
			var speed_2 = katb_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_2 = 7000;
		}
		var katb_rotate_interval_2 = setInterval( katb_rotate_testimonials_2, speed_2 );
		jQuery('#katb_rotator_2' ).hover(function() {
	   		clearInterval(katb_rotate_interval_2);
		}, function() {
			katb_rotate_interval_2 = setInterval( katb_rotate_testimonials_2, speed_2 );
		});
	}
	
	if( jQuery( '#katb_rotator_3' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_3');
		try{
			var speed_3 = katb_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_3 = 7000;
		}
		var katb_rotate_interval_3 = setInterval( katb_rotate_testimonials_3, speed_3 );
		jQuery('#katb_rotator_3' ).hover(function() {
	   		clearInterval(katb_rotate_interval_3);
		}, function() {
			katb_rotate_interval_3 = setInterval( katb_rotate_testimonials_3, speed_3 );
		});
	}
	
	if( jQuery( '#katb_rotator_4' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_4');
		try{
			var speed_4 = katb_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_4 = 7000;
		}
		var katb_rotate_interval_4 = setInterval( katb_rotate_testimonials_4, speed_4 );
		jQuery('#katb_rotator_4' ).hover(function() {
	   		clearInterval(katb_rotate_interval_4);
		}, function() {
			katb_rotate_interval_4 = setInterval( katb_rotate_testimonials_4, speed_4 );
		});
	}
    
    jQuery('.katb_widget_rotate').each(function(i, obj) {
		
		jQuery(this).attr('id','katb_widget_rotator_'+i );
		
	});
	
	if( jQuery( '#katb_widget_rotator_0').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_0');
		try{
			var speed_w_0 = katb_widget_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_w_0 = 7000;
		}
		var katb_widget_rotate_interval_0 = setInterval( katb_widget_rotate_testimonials_0, speed_w_0 );
		jQuery('#katb_widget_rotator_0' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_0);
		}, function() {
			katb_widget_rotate_interval_0 = setInterval( katb_widget_rotate_testimonials_0, speed_w_0 );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_1').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_1');
		try{
			var speed_w_1 = katb_widget_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_w_1 = 7000;
		}
		var katb_widget_rotate_interval_1 = setInterval( katb_widget_rotate_testimonials_1, speed_w_1 );
		jQuery('#katb_widget_rotator_1' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_1);
		}, function() {
			katb_widget_rotate_interval_1 = setInterval( katb_widget_rotate_testimonials_1, speed_w_1 );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_2').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_2');
		try{
			var speed_w_2 = katb_widget_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_w_2 = 7000;
		}
		var katb_widget_rotate_interval_2 = setInterval( katb_widget_rotate_testimonials_2, speed_w_2 );
		jQuery('#katb_widget_rotator_2' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_2);
		}, function() {
			katb_widget_rotate_interval_2 = setInterval( katb_widget_rotate_testimonials_2, speed_w_2 );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_3').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_3');
		try{
			var speed_w_3 = katb_widget_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_w_3 = 7000;
		}
		var katb_widget_rotate_interval_3 = setInterval( katb_widget_rotate_testimonials_3, speed_w_3 );
		jQuery('#katb_widget_rotator_3' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_3);
		}, function() {
			katb_widget_rotate_interval_3 = setInterval( katb_widget_rotate_testimonials_3, speed_w_3 );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_4').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_4');
		try{
			var speed_w_4 = katb_widget_rotate_options.dataset.katb_speed;
		}catch(e){
			var speed_w_4 = 7000;
		}
		var katb_widget_rotate_interval_4 = setInterval( katb_widget_rotate_testimonials_4, speed_w_4 );
		jQuery('#katb_widget_rotator_4' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_4);
		}, function() {
			katb_widget_rotate_interval_4 = setInterval( katb_widget_rotate_testimonials_4, speed_w_4 );
		});
	}
    
});

function katb_rotate_testimonials_0() {
	var katb_rotate_options = document.getElementById('katb_rotator_0');
	try{
		var transition = katb_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_rotator_0 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_0 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_0 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_1() {
	var katb_rotate_options = document.getElementById('katb_rotator_1');
	try{
		var transition = katb_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_rotator_1 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_1 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_1 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_2() {
	var katb_rotate_options = document.getElementById('katb_rotator_2');
	try{
		var transition = katb_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_rotator_2 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_2 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_2 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_3() {
	var katb_rotate_options = document.getElementById('katb_rotator_3');
	try{
		var transition = katb_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_rotator_3 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_3 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_3 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_4() {
	var katb_rotate_options = document.getElementById('katb_rotator_4');
	try{
		var transition = katb_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_rotator_4 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_4 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_4 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_0() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_0');
	try{
		var transition = katb_widget_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_widget_rotator_0 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_0 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_0 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_1() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_1');
	try{
		var transition = katb_widget_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_widget_rotator_1 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_1 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_1 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_2() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_2');
	try{
		var transition = katb_widget_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_widget_rotator_2 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_2 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_2 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_3() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_3');
	try{
		var transition = katb_widget_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_widget_rotator_3 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_3 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_3 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_4() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_4');
	try{
		var transition = katb_widget_rotate_options.dataset.katb_transition;
	}catch(e){
		var transition = 'fade';
	}
	var current = jQuery( '#katb_widget_rotator_4 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_4 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_4 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn(2000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};
