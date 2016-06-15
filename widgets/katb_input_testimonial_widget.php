<?php
/**
Plugin Name: Testimonial Basics Input Widget
Plugin URI: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Description: A plugin to input a testimonial
Version: 4.3.0
Author: Kevin Archibald
Author URI: http://kevinsspace.ca/
License: GPLv3
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
*/
/** ------------- Register Widget ---------------------------------------
 *
 * The widget is registered using the widgets_init action hook that fires 
 * after all default widgets have been registered.
 * katb_input_testimonial_widget is the Class for the widget, all widgets 
 * must be created using the WP_Widget Class
 * 
 * ------------------------------------------------------------------------ */ 
function katb_input_register_register_widget() {
 	register_widget ( 'katb_input_testimonial_widget' );
 }
add_action ( 'widgets_init','katb_input_register_register_widget' );

/** -------------- katb_input_testimonial_widget Class -------------------------
 * 
 * Define Testimonial Basics Input Widget  
 * 
 * ------------------------------------------------------------------------------ */
class katb_input_testimonial_widget extends WP_Widget {

    /** The first function is required to process the widget
	 * It sets up an array to store widget options
	 * 'classname' - added to <li class="classnamne"> of the widget html
	 * 'description' - displays under Appearance => Widgets ...your widget 
	 * WP_Widget(widget list item ID,Widget Name to be shown on grag bar, options array)
	 */ 
    public function __construct() {
        $widget_ops = array( 
			'classname' => 'katb_input_widget_class', 
			'description' => __('Allow a user to input a testimonial.','testimonial-basics') 
			); 
        parent::__construct( 'katb_input_testimonial_widget', __('Testimonial Input Widget','testimonial-basics'), $widget_ops );
    }
 	
	/** The second function creates the widget setting form.
	 * Each widget has a table in the Options database for it's options
	 * The array of options is $instance. The first thing we do is check to see
	 * if the title instance exists, if so use it otherwise load the default.
	 * The second part displays the title in the widget.
	 */
 	public function form ( $instance ) {
 		
 		$katb_input_defaults = array(
			'katb_input_widget_title' => 'Add a Testimonial',
			'katb_input_widget_group' => 'All',
			'katb_input_widget_form_no' => '1'
		);
		
		$instance = wp_parse_args( (array) $instance, $katb_input_defaults );
		$title = $instance['katb_input_widget_title'];
		$group = $instance['katb_input_widget_group'];
		$form = $instance['katb_input_widget_form_no'];
		?>
		
		<p><?php _e('Title :','testimonial-basics'); ?><input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'katb_input_widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'katb_input_widget_title' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $title ); ?>" /></p>
		<p><?php _e('Group :','testimonial-basics'); ?><input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'katb_input_widget_group' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'katb_input_widget_group' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $group ); ?>" /></p>
		<p><?php _e('Form No :','testimonial-basics'); ?><input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'katb_input_widget_form_no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'katb_input_widget_form_no' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $form ); ?>" /></p>
		<?php
	}

	/** The third function saves the widget settings. */	
	public function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['katb_input_widget_title'] = sanitize_text_field( $new_instance['katb_input_widget_title'] );
		$instance['katb_input_widget_group'] = sanitize_text_field( $new_instance['katb_input_widget_group'] );
		$instance['katb_input_widget_form_no'] = sanitize_text_field( $new_instance['katb_input_widget_form_no'] );
		
		// group validation/whitelist
		if( $instance['katb_input_widget_group'] == '' ) $instance['katb_input_widget_group'] = 'All';
		
		// form validation/whitelist
		if( $instance['katb_input_widget_form_no'] == '' ) $instance['katb_input_widget_form_no'] = '1';
		
		return $instance;
	}
	
	/** ------------------- Display Widget -------------------------------------------
	 * The input form for the testimonial widget is loaded. The visitor inputs a testimonial
	 * and clicks the submit button and the testimonial is submitted to the database 
	 * and the admin user is notified by email that they have a testimonial to review
	 * and approve. If admin user can specify if a captcha is used to help in validation.
	 * 
	 * @param array $arg array of global theme values
	 * @param array $instance array of widget form values
	 * 
	 * @uses katb_get_options user options from /includes/katb_functions.php
	 * @uses katb_allowed_html() for allowed tags from /includes/katb_functions.php
	 * 
	 *-------------------------------------------------------------------------------- */
   public function widget($args, $instance) {
    	
    	//Get user options
		$katb_options = katb_get_options();
		$include_widget_email_note = $katb_options[ 'katb_include_widget_email_note' ];
		$widget_email_note = $katb_options[ 'katb_widget_email_note' ];
		$author_label_widget = $katb_options[ 'katb_widget_author_label' ];
		$email_label_widget = $katb_options[ 'katb_widget_email_label' ];
		$website_label_widget = $katb_options[ 'katb_widget_website_label' ];
		$location_label_widget = $katb_options[ 'katb_widget_location_label' ];
		$custom1_label_widget = $katb_options[ 'katb_widget_custom1_label' ];
		$custom2_label_widget = $katb_options[ 'katb_widget_custom2_label' ];
		$testimonial_title_label_widget = $katb_options[ 'katb_widget_testimonial_title_label' ];
		$rating_label_widget =  $katb_options[ 'katb_widget_rating_label' ];
		$testimonial_label_widget = $katb_options[ 'katb_widget_testimonial_label' ];
		$widget_captcha_label = $katb_options[ 'katb_widget_captcha_label' ];
		$submit_label_widget = $katb_options[ 'katb_widget_submit_label' ];
		$reset_label_widget = $katb_options[ 'katb_widget_reset_label' ];
		$exclude_website = $katb_options[ 'katb_exclude_website_input' ];
		$require_website = $katb_options[ 'katb_require_website_input' ];
		$exclude_location = $katb_options[ 'katb_exclude_location_input' ];
		$require_location = $katb_options[ 'katb_require_location_input' ];
		$exclude_custom1 = $katb_options[ 'katb_exclude_custom1_input' ];
		$require_custom1 = $katb_options[ 'katb_require_custom1_input' ];
		$exclude_custom2 = $katb_options[ 'katb_exclude_custom2_input' ];
		$require_custom2 = $katb_options[ 'katb_require_custom2_input' ];
		$exclude_testimonial_title = $katb_options[ 'katb_exclude_testimonial_title_input' ];
		$require_testimonial_title = $katb_options[ 'katb_require_testimonial_title_input' ];
		$use_ratings = $katb_options[ 'katb_use_ratings' ];
		$auto_approve = $katb_options[ 'katb_auto_approve' ];
		$use_widget_popup = $katb_options[ 'katb_use_widget_popup_message' ];
		$labels_above = $katb_options[ 'katb_widget_labels_above' ];
		$widget_required_label = $katb_options[ 'katb_widget_required_label' ];
		$katb_widget_rating = '0.0';
		
		//Get the widget title and display
    	extract ( $args);
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['katb_input_widget_title'] );
		if ( !empty( $title )) { echo $before_title.esc_html($title).$after_title;}
		
		//Set up database table name for use later
		global $wpdb,$tablename;
		$tablename = $wpdb->prefix.'testimonial_basics';
		
		//Initialize Variables
		if( $labels_above != 1 ) {
			
			$katb_widget_author = $author_label_widget;
			$katb_widget_email = $email_label_widget;
			$katb_widget_website = $website_label_widget;
			$katb_widget_location = $location_label_widget;
			$katb_widget_custom1 = $custom1_label_widget;
			$katb_widget_custom2 = $custom2_label_widget;
			$katb_widget_testimonial_title = $testimonial_title_label_widget;
			$katb_widget_testimonial = $testimonial_label_widget;
			
		} else {

			$katb_widget_author = '';
			$katb_widget_email = '';
			$katb_widget_website = '';
			$katb_widget_location = '';
			$katb_widget_custom1 = '';
			$katb_widget_custom2 = '';
			$katb_widget_testimonial_title = '';
			$katb_widget_testimonial = '';
		}
		
		$katb_allowed_html = katb_allowed_html();
		
		$katb_widget_input_group = esc_attr($instance['katb_input_widget_group']);
		if( $katb_widget_input_group == '' ) {
			$katb_widget_input_group = 'All';
		}
		
		$katb_widget_input_form_no = sanitize_text_field($instance['katb_input_widget_form_no']);
		if( $katb_widget_input_form_no == '' ) {
			$katb_widget_input_form_no = '1';
		}
		
		$post_name = 'widget_submitted'.$katb_widget_input_form_no;
		$reset_name = 'widget_reset'.$katb_widget_input_form_no;
		
		//Process input form
		if ( isset($_POST[$post_name]) && wp_verify_nonce( $_POST['katb_widget_form_nonce'.$katb_widget_input_form_no],'katb_nonce_2')) {
			//Validate Input
			//initialize error string
			$katb_widget_html_error = '';
			$katb_widget_popup_error = '';
			//Set default variables
			$katb_widget_order = "";
			
			if( $auto_approve == 1 ) {
				$katb_widget_approved = 1;
			} else {
				$katb_widget_approved = 0;
			}
			
			$katb_widget_datetime = current_time('mysql');
			
			//validate author
			$katb_widget_author = sanitize_text_field($_POST['tb_author']);
			if ( $katb_widget_author == $author_label_widget || $katb_widget_author == '' ) {
				
				$katb_widget_html_error .= '<br/> - '.__('Author required','testimonial-basics');
				$katb_widget_popup_error .= '\n - '.__('Author required','testimonial-basics');
				if( $labels_above == 1 ) {
					$katb_widget_author = '';
				} else {
					$katb_widget_author = $author_label_widget;
				}
				
			}
			
			//validate email
			$katb_widget_email = sanitize_email($_POST['tb_email']);
			if (!is_email($katb_widget_email)) {
				
				$katb_widget_html_error .= '<br/> - '.__('Valid email required ','testimonial-basics');
				$katb_widget_popup_error .= '\n - '.__('Valid email required ','testimonial-basics');
				if( $labels_above == 1 ) {
					$katb_widget_email = '';
				} else {
					$katb_widget_email = $email_label_widget;
				}
				
			}
			
			//validate website
			if( $exclude_website != 1 ){
				$katb_widget_website = trim($_POST['tb_website']);
				if( $katb_widget_website != '' && $katb_widget_website != 'http://'.$website_label_widget ) {
					$katb_widget_website = esc_url( $katb_widget_website );
				} else {
					if( $require_website == 1 ) {
						$katb_widget_html_error .= '<br/> - '.__('Website required ','testimonial-basics');
						$katb_widget_popup_error .= '\n - '.__('Website required ','testimonial-basics');	
					}
					$katb_widget_website = $website_label_widget;
				}
			} else {
				$katb_widget_website = '';
			}
			
			//validate location
			if( $exclude_location != 1 ){
				$katb_widget_location = trim($_POST['tb_location']);
				if( $katb_widget_location != '' && $katb_widget_location != $location_label_widget ) {
					$katb_widget_location = sanitize_text_field( $katb_widget_location );
				} else {
					if( $require_location == 1 ) {
						$katb_widget_html_error .= '<br/> - '.__('Location required ','testimonial-basics');
						$katb_widget_popup_error .= '\n - '.__('Location required ','testimonial-basics');	
					}
					$katb_widget_location = $location_label_widget;
				}
			} else {
				$katb_widget_location = '';
			}
			
			//validate custom1
			if( $exclude_custom1 != 1 ){
				$katb_widget_custom1 = trim($_POST['tb_custom1']);
				if( $katb_widget_custom1 != '' && $katb_widget_custom1 != $custom1_label_widget ) {
					$katb_widget_custom1 = sanitize_text_field( $katb_widget_custom1 );
				} else {
					if( $require_custom1 == 1 ) {
						$katb_widget_html_error .= '<br/> - '.$custom1_label_widget.' '.__('required ','testimonial-basics');
						$katb_widget_popup_error .= '\n - '.$custom1_label_widget.' '.__('required ','testimonial-basics');	
					}
					$katb_widget_custom1 = $custom1_label_widget;
				}
			} else {
				$katb_widget_custom1 = '';
			}
			
			//validate custom2
			if( $exclude_custom2 != 1 ){
				$katb_widget_custom2 = trim($_POST['tb_custom2']);
				if( $katb_widget_custom2 != '' && $katb_widget_custom2 != $custom2_label_widget ) {
					$katb_widget_custom2 = sanitize_text_field( $katb_widget_custom2 );
				} else {
					if( $require_custom2 == 1 ) {
						$katb_widget_html_error .= '<br/> - '.$custom2_label_widget.' '.__('required ','testimonial-basics');
						$katb_widget_popup_error .= '\n - '.$custom2_label_widget.' '.__('required ','testimonial-basics');	
					}
					$katb_widget_custom2 = $custom2_label_widget;
				}
			} else {
				$katb_widget_custom2 = '';
			}
			
			//validate rating
			if( $use_ratings == 1 ) {			
				$katb_widget_rating = sanitize_text_field($_POST['tb_rating_widget']);
				if( $katb_widget_rating == '' ) $katb_widget_rating = '0.0';
				if( $katb_widget_rating == '1') $katb_widget_rating = '1.0';
				if( $katb_widget_rating == '2') $katb_widget_rating = '2.0';
				if( $katb_widget_rating == '3') $katb_widget_rating = '3.0';
				if( $katb_widget_rating == '4') $katb_widget_rating = '4.0';
				if( $katb_widget_rating == '5') $katb_widget_rating = '5.0';
				if( $katb_widget_rating == '0') $katb_widget_rating = '0.0';
			} else {
				$katb_widget_rating = '0.0';
			}
			
			//Captcha Validation
			if ($katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
				$katb_captcha_entered = sanitize_text_field($_POST['verify']);
				if ($_SESSION[ 'katb_pass_phrase_widget' . $katb_widget_input_form_no ] !== sha1($katb_captcha_entered)){
					$katb_widget_html_error .= '<br/> - '.__('Captcha invalid','testimonial-basics');
					$katb_widget_popup_error .= '\n - '.__('Captcha invalid','testimonial-basics');
				}
			}
			
			//validate testimonial_title
			if( $exclude_testimonial_title != 1 ){
				$katb_widget_testimonial_title = trim($_POST['tb_title']);
				if( $katb_widget_testimonial_title != '' && $katb_widget_testimonial_title != $testimonial_title_label_widget ) {
					$katb_widget_testimonial_title = sanitize_text_field( $katb_widget_testimonial_title );
				} else {
					if( $require_testimonial_title == 1 ) {
						$katb_widget_html_error .= '<br/> - '.$testimonial_title_label_widget.' '.__('required ','testimonial-basics');
						$katb_widget_popup_error .= '\n - '.$testimonial_title_label_widget.' '.__('required ','testimonial-basics');	
					}
					$katb_widget_testimonial_title = $testimonial_title_label_widget;
				}
			} else {
				$katb_widget_testimonial_title = '';
			}
			
			//Validate Testimonial
			//check for error before processing to avoid html encoding until all is good.
			//premature encoding causes wp_kses to remove smiley images on second pass
			if( $katb_widget_html_error == '' ) {
				//Sanitize first
				$katb_sanitize_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
				//add WordPress Smiley support
				$katb_fix_emoticons = convert_smilies( $katb_sanitize_testimonial );
				//if emoji present convert to html entities
				$katb_widget_testimonial = wp_encode_emoji( $katb_fix_emoticons );
			} else {
				$katb_widget_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
			}
			if ( $katb_widget_testimonial == $testimonial_label_widget || $katb_widget_testimonial == "" ) {
				$katb_widget_html_error .= '<br/> - '.__('Testimonial required','testimonial-basics');
				$katb_widget_popup_error .= '\n - '.__('Testimonial required','testimonial-basics');
				if( $labels_above !=1 ) {
					$katb_widget_testimonial = $testimonial_label_widget;
				} else {
					$katb_widget_testimonial = '';
				}
			}
			
			//Validation complete
			if( $katb_widget_html_error == '' && $katb_widget_popup_error == '') {
				if( $katb_widget_website == $website_label_widget ) $katb_widget_website = '';
				if( $katb_widget_location == $location_label_widget ) $katb_widget_location ='';
				//OK $error is empty so let's update the database
				$values = array(
				'tb_date' => $katb_widget_datetime,
				'tb_order' => $katb_widget_order,
				'tb_approved' => $katb_widget_approved,
				'tb_group' => $katb_widget_input_group,
				'tb_name' => $katb_widget_author,
				'tb_email' => $katb_widget_email,
				'tb_location' => $katb_widget_location,
				'tb_custom1' => $katb_widget_custom1,
				'tb_custom2' => $katb_widget_custom2,
				'tb_url' => $katb_widget_website,
				'tb_pic_url' => '',
				'tb_rating' => $katb_widget_rating,
				'tb_title' => $katb_widget_testimonial_title,
				'tb_testimonial' => $katb_widget_testimonial
				);
				$formats_values = array('%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
				$wpdb->insert($tablename,$values,$formats_values);

				//send notification email 
				katb_email_notification($katb_widget_author, $katb_widget_email, $katb_widget_testimonial );
								
				//Optional supmitted popup message
				if( $use_widget_popup == 1 ){ ?>
					<script type="text/javascript"><?php echo 'alert("'.__("Testimonial Submitted - Thank You!","testimonial-basics").'")'; ?></script>
				<?php } else {
					echo '<div class="katb_widget_sent">'.__('Testimonial Submitted - Thank You!','testimonial-basics').'</div>';
				}
			
				//Initialize Variables
				if( $labels_above != 1 ) {
					
					$katb_widget_author = $author_label_widget;
					$katb_widget_email = $email_label_widget;
					$katb_widget_website = $website_label_widget;
					$katb_widget_location = $location_label_widget;
					$katb_widget_custom1 = $custom1_label_widget;
					$katb_widget_custom2 = $custom2_label_widget;
					$katb_widget_testimonial_title = $testimonial_title_label_widget;
					$katb_widget_testimonial = $testimonial_label_widget;
					
				} else {
		
					$katb_widget_author = '';
					$katb_widget_email = '';
					$katb_widget_website = '';
					$katb_widget_location = '';
					$katb_widget_custom1 = '';
					$katb_widget_custom2 = '';
					$katb_widget_testimonial_title = '';
					$katb_widget_testimonial = '';
					
				}
				
				$katb_widget_rating = '0.0';
				
			} else {
				
				if( $use_widget_popup == 1 ){
					$widget_error_message = __('There were errors so the testimonial was not added: ','testimonial-basics').'\n'.$katb_widget_popup_error;
					?><script>alert('<?php echo $widget_error_message; ?>')</script>
				<?php } else {
					echo '<div class="katb_widget_error">'.__('Error','testimonial-basics').$katb_widget_html_error.'</div>';
				}
				
				if ( $katb_widget_website == '' ) $katb_widget_website = $website_label_widget;
				if ( $katb_widget_location == '' ) $katb_widget_location = $location_label_widget;
				
			}
		}
	/* ---------- Reset button is clicked ---------------- */
	if(isset($_POST[$reset_name])) {
		$katb_widget_author =  $author_label_widget;
		$katb_widget_email = $email_label_widget;
		$katb_widget_website = $website_label_widget;
		$katb_widget_location = $location_label_widget;
		$katb_widget_testimonial = $testimonial_label_widget;
		$katb_widget_rating = '0.0';
	}
		?>
		<div class="katb_widget_form">
			
			<?php if( $include_widget_email_note == 1) { ?>
				<p><?php echo esc_attr(stripslashes( $widget_email_note )); ?></p>
			<?php } ?>
			
			<form method="POST">
				
				<?php wp_nonce_field('katb_nonce_2','katb_widget_form_nonce'.$katb_widget_input_form_no); ?>
				
				<?php if( $labels_above == 1 ){ echo '<label class="katb_widget_input_label">'.sanitize_text_field($author_label_widget).'</label>'; } ?>
				<input  class="katb_input" type="text" name="tb_author" value="<?php echo esc_attr( $katb_widget_author ); ?>" />
			
				<?php if( $labels_above == 1 ){ echo '<label class="katb_widget_input_label">'.sanitize_text_field($email_label_widget).'</label>'; } ?>
				<input  class="katb_input" type="text" name="tb_email" value="<?php echo sanitize_text_field( $katb_widget_email ); ?>" />
			
				<?php if( $exclude_website != 1 ) { ?>
					<?php if( $labels_above == 1 ){ echo '<label class="katb_widget_input_label">'.sanitize_text_field($website_label_widget).'</label>'; } ?>
					<?php if( $katb_widget_website == $website_label_widget || $katb_widget_website == '' ){ ?>
						<input  class="katb_input" type="text" name="tb_website" value="<?php echo esc_html( $katb_widget_website ); ?>" />
					<?php }else{ ?>
						<input  class="katb_input" type="text" name="tb_website" value="<?php echo esc_url( $katb_widget_website ); ?>" />
					<?php }
				}
				
				if ( $exclude_location != 1 ) { ?>
					<?php if( $labels_above == 1 ){ echo '<label class="katb_widget_input_label">'.sanitize_text_field($location_label_widget).'</label>'; } ?>
					<input  class="katb_input" type="text" name="tb_location" value="<?php echo sanitize_text_field( $katb_widget_location ); ?>" />
				<?php }
				
				if ( $exclude_custom1 != 1 ) { ?>
					<?php if( $labels_above == 1 ){ echo '<label class="katb_widget_input_label">'.sanitize_text_field($custom1_label_widget).'</label>'; } ?>
					<input  class="katb_input" type="text" name="tb_custom1" value="<?php echo sanitize_text_field( $katb_widget_custom1 ); ?>" />
				<?php }
				
				if ( $exclude_custom2 != 1 ) { ?>
					<?php if( $labels_above == 1 ){ echo '<label class="katb_widget_input_label">'.sanitize_text_field($custom2_label_widget).'</label>'; } ?>
					<input  class="katb_input" type="text" name="tb_custom2" value="<?php echo sanitize_text_field( $katb_widget_custom2 ); ?>" />
				<?php }
				
				if( $use_ratings == 1 ) { ?>
					
					<label class="katb_widget_input_label"><?php echo sanitize_text_field( $rating_label_widget ); ?></label>
					
					<select name="tb_rating_widget" class="katb_css_rating_select_widget">
						<option <?php selected( esc_attr( $katb_widget_rating ) ); ?> value="<?php echo esc_attr( $katb_widget_rating ); ?>"><?php echo sanitize_text_field( $katb_widget_rating ); ?></option>
						<option value="0.0" <?php selected( esc_attr( $katb_widget_rating ) , "0.0" ); ?>>0.0</option>
						<option value="0.5" <?php selected( esc_attr( $katb_widget_rating ) , "0.5" ); ?>>0.5</option>
						<option value="1.0" <?php selected( esc_attr( $katb_widget_rating ) , "1.0" ); ?>>1.0</option>
						<option value="1.5" <?php selected( esc_attr( $katb_widget_rating ) , "1.5" ); ?>>1.5</option>
						<option value="2.0" <?php selected( esc_attr( $katb_widget_rating ) , "2.0" ); ?>>2.0</option>
						<option value="2.5" <?php selected( esc_attr( $katb_widget_rating ) , "2.5" ); ?>>2.5</option>
						<option value="3.0" <?php selected( esc_attr( $katb_widget_rating ) , "3.0" ); ?>>3.0</option>
						<option value="3.5" <?php selected( esc_attr( $katb_widget_rating ) , "3.5" ); ?>>3.5</option>
						<option value="4.0" <?php selected( esc_attr( $katb_widget_rating ) , "4.0" ); ?>>4.0</option>
						<option value="4.5" <?php selected( esc_attr( $katb_widget_rating ) , "4.5" ); ?>>4.5</option>
						<option value="5.0" <?php selected( esc_attr( $katb_widget_rating ) , "5.0" ); ?>>5.0</option>
					</select>
					
				<?php }

				if ( $exclude_testimonial_title != 1 ) { ?>
					<?php if( $labels_above == 1 ){ echo '<label class="katb_widget_input_label">'.sanitize_text_field($testimonial_title_label_widget).'</label>'; } ?>
					<input  class="katb_input" type="text" name="tb_title" value="<?php echo sanitize_text_field( $katb_widget_testimonial_title ); ?>" />
				<?php } ?>
				
				<?php if( $labels_above == 1 ){ echo '<br/><label class="katb_widget_input_label">'.sanitize_text_field( $testimonial_label_widget ).'</label>'; } ?>
				<textarea name="tb_testimonial" rows="5" ><?php echo wp_kses_post( $katb_widget_testimonial ); ?></textarea>
				

				<?php if ( $katb_options['katb_show_html_widget'] == TRUE || $katb_options['katb_show_html_widget'] == 1 ) { 
					echo '<p>HTML: <code>a p br i em strong q h1-h6</code></p>';
				}
					
				if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) { ?>
					
					<div class="katb_widget_captcha">
						<?php if ( $katb_options['katb_use_color_captcha_2'] == TRUE || $katb_options['katb_use_color_captcha_2'] == 1 ) {
							echo katb_color_captcha_2( 'widget' , $katb_widget_input_form_no );
						} elseif ( $katb_options['katb_use_color_captcha'] == TRUE || $katb_options['katb_use_color_captcha'] == 1 ) {
							echo katb_color_captcha( 'widget' , $katb_widget_input_form_no );
						} else {
							 echo katb_bw_captcha( 'widget' , $katb_widget_input_form_no );
						} ?>
						<input class="katb_captcha_widget_input" type="text" id="verify_widget_<?php echo $katb_widget_input_form_no; ?>" name="verify" value="<?php echo $widget_captcha_label; ?>" onclick="this.select();" /><br/>
					</div>
					
				<?php } ?>
				
				<input class="katb_widget_submit" type="submit" name="<?php echo esc_attr( $post_name ); ?>" value="<?php echo sanitize_text_field( $submit_label_widget ); ?>" />
				
				<input class="katb_widget_reset" type="submit" name="<?php echo esc_attr( $reset_name ); ?>" value="<?php echo sanitize_text_field( $reset_label_widget ); ?>" />
			
			</form>
			
			<?php if( $widget_required_label != '' ) { echo'<div class="katb_clear_fix"></div><p>'.sanitize_text_field( $widget_required_label ).'</p>'; } ?>
			
			<div class="katb_clear_fix"></div>
			
			<?php if ($katb_options['katb_show_widget_gravatar_link'] == 1 ) { ?>
				<span class="katb_use_gravatar_wrap">
					<span class="use_gravatar"><?php _e('Add a Photo? ','testimonial-basics'); ?></span>
					<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" >
						<img class="gravatar_logo" src="<?php echo plugins_url(); ?>/testimonial-basics/includes/Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" />
					</a>
				</span>
				
			<?php } ?>
			
		</div>
		
		<?php
		
		echo '<br style="clear:both;" />';
		
		echo $after_widget;
		
    }
}