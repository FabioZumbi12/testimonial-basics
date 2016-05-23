<?php
/**
 * This file contains the shortcodes for displaying the testimonial in a content area.
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

/** ------------------ display testimonials shortcode ---------------------------------
 * useage : [katb_testimonial group="all" number="all" by="date" id="" rotate="no" layout="0" schema="default"] 
 * group : "all" or "group" where group is the identifier in the testimonial
 * by : "date" or "order" or "random"
 * number : "all" or input the number you want to display
 * id : "" or ids of testimonials
 * rotate : "no" do not rotate, "yes" rotate testimonials
 * layout : 0-default,1-no format top meta, 2-no format bottom meta, 3-no format side meta,
 *          4-format top meta, 5-format bottom meta, 6-format side meta, 7-no format mosaic, 8-format mosaic
 * schema : default-whatever is set up in the General Options Panel, yes-override to yes, no-override to no
 * 
 * @param array $atts contains the shortcode parameters
 * @uses katb_get_options() function to get plugin options found in katb_functions.php
 * @uses katb_offset_setup() for pagination found in katb_functions.php
 * @uses katb_setup_pagination for pagination  found in katb_functions.php
 * @uses katb_content_display sets up the testimonial display found in katb_functions.php
 * @uses katb_get_display_pagination_string displays pagination  found in katb_functions.php
 * 
 * @return string $katb_html containging the html of the testimonial display request
 * ------------------------------------------------------------------------- */

function katb_list_testimonials ( $atts ) {

	//get options
	global $katb_options;
	
	//initialize main testimonial arrays
	$katb_tdata = array();
	$katb_tdata = '';
	$katb_tnumber = '';

	$use_schema = intval( $katb_options['katb_use_schema'] );
	$display_reviews = intval( $katb_options['katb_schema_display_reviews'] );
	
	//get shortcode variables
	extract(shortcode_atts(array(
		'group' 	=> 'all',
		'number' 	=> 'all',
	    'by' 		=> 'random',
	    'id' 		=> '',
	    'rotate' 	=> 'no',
	    'layout' 	=> '0',
	    'schema'	=> 'default'
    ), $atts));
	 
	//Sanitize data

	$group = sanitize_text_field( $group );
	$number = strtolower( sanitize_text_field( $number ));
	$by = strtolower( sanitize_text_field( $by ));
	$id = sanitize_text_field($id);
	$rotate = strtolower( sanitize_text_field( $rotate ));
	$layout_override = sanitize_text_field( $layout );
	$use_schema_override = sanitize_text_field( $schema );

	//white list rotate
	if( $rotate != 'yes' ) { $rotate = 'no'; }
	
	//white list group
	if( $group == '' ) { $group = 'all'; }
	
	//number validation/whitelist
	if( $number == '' ) { $number = 'all'; }
	if( $number != 'all' ) {
		if( intval( $number ) < 1 ) {
			$number = 1;
		} else {
			$number = intval( $number );
		}
	}
	
	//white list $by
	if ($by != 'date' && $by != 'order') { $by = 'random'; }
	
	//white list layout
	if( $layout_override == '0' || $layout_override == '1' || $layout_override == '2' || $layout_override == '3' || $layout_override == '4' || $layout_override == '5' || $layout_override == '6' || $layout_override == '7' || $layout_override == '8' ) {/*do nothing*/}else{ $layout_override = '0'; }
	
	//apply layout overide if applicable
	if ( $layout_override == '1' ) {
		$content_layout = 'Top Meta';
		$use_formatted_display = '0';
	} elseif( $layout_override == '2' ) {
		$content_layout = 'Bottom Meta';
		$use_formatted_display = '0';
	} elseif( $layout_override == '3' ) {
		$content_layout = 'Side Meta';
		$use_formatted_display = '0';
	} elseif( $layout_override == '4' ) {
		$content_layout = 'Top Meta';
		$use_formatted_display = '1';
	} elseif( $layout_override == '5' ) {
		$content_layout = 'Bottom Meta';
		$use_formatted_display = '1';
	} elseif( $layout_override == '6' ) {
		$content_layout = 'Side Meta';
		$use_formatted_display = '1';
	} elseif( $layout_override == '7' ) {
		$content_layout = 'Mosaic';
		$use_formatted_display = '0';
	} elseif( $layout_override == '8' ) {
		$content_layout = 'Mosaic';
		$use_formatted_display = '1';
	} else {
		$content_layout = sanitize_text_field( $katb_options['katb_layout_option'] );
		$use_formatted_display =  intval( $katb_options['katb_use_formatted_display'] );
	}
	
	//white list schema
	if( $use_schema_override == 'yes' || $use_schema_override == 'no' ){/*do nothing*/}else{$use_schema_override = 'default';}
	
	//check use schema override, note that $use_schema is not changed if set to 'default'
	if( $use_schema_override == 'yes' ){
		$use_schema = 1;
	} elseif ( $use_schema_override == 'no' ){
		$use_schema = 0;
	}
	
	//OK let's start by getting the testimonial data from the database
	if( $id != '' ) {
		//get the testimonials
		$katb_tdata_array = katb_get_testimonials_from_ids( $id );
		$katb_tdata = $katb_tdata_array[0];	
		$katb_tnumber = $katb_tdata_array[1];
	} else {
		//get the testimonials
		$use_pagination = $katb_options['katb_use_pagination'];
		$katb_tdata_array = katb_get_testimonials(  $group , $number, $by , $rotate , $use_pagination );
		$katb_tdata = $katb_tdata_array[0];
		$katb_tnumber = $katb_tdata_array[1];
		if(isset($katb_tdata_array[2]))$katb_paginate_setup = $katb_tdata_array[2];
	}
	
	$katb_error = '';
			
	if ( $katb_tnumber < 2 && $rotate == 'yes' ) {
		$katb_error = __('You must have 2 approved testimonials to use a rotated display!','testimonial-basics');
	} elseif ( $katb_tnumber == 0 ) {
		$katb_error = __('There are no approved testimonials to display!','testimonial-basics');
	}

	$rotate == 'yes'? $katb_rotate = 1 : $katb_rotate = 0 ;
	
	ob_start();
	
	if( $katb_error != '') {
				
		echo '<div class="katb_error">'.$katb_error.'</div>';
		
	} else {
			
		katb_content_display( $use_formatted_display , $use_schema , $katb_tnumber , $katb_tdata , $katb_rotate , $content_layout , $group );

	}
	
	//Pagination
	
	if( $use_schema == 1 && $display_reviews == 0 ) {
		//don't display pagination
	} else {
		if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && isset($katb_paginate_setup)) {
			echo katb_get_display_pagination_string( $katb_paginate_setup , $use_formatted_display );
		}
	}
	
	return ob_get_clean();
}
add_shortcode('katb_testimonial', 'katb_list_testimonials');

/** ------------- display testimonial input form shortcode -------------------------------------
 * displays the testimonial input form
 * useage : [katb_input_testimonials group="All" form="1"] 
 * 
 * @param array $atts array of shortcode parameters, in this case only the group and form number
 * 
 * @uses katb_get_options() array of plugin user options
 * 
 * @return string $input_html which is the html string for the form
 * --------------------------------------------------------------------------------------------- */
function katb_display_input_form($atts) {
	
	$katb_options = katb_get_options();
	$author_label = $katb_options[ 'katb_author_label' ];
	$email_label = $katb_options[ 'katb_email_label' ];
	$website_label = $katb_options[ 'katb_website_label' ];
	$location_label = $katb_options[ 'katb_location_label' ];
	$custom1_label = $katb_options[ 'katb_custom1_label' ];
	$custom2_label = $katb_options[ 'katb_custom2_label' ];
	$rating_label =  $katb_options[ 'katb_rating_label' ];
	$title_label = $katb_options[ 'katb_testimonial_title_label' ];
	$testimonial_label = $katb_options[ 'katb_testimonial_label' ];
	$captcha_label = $katb_options[ 'katb_captcha_label' ];
	$submit_label = $katb_options[ 'katb_submit_label' ];
	$reset_label = $katb_options[ 'katb_reset_label' ];
	$required_label = $katb_options[ 'katb_required_label' ];
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
	$use_popup = $katb_options[ 'katb_use_popup_message' ];
	$auto_approve = $katb_options[ 'katb_auto_approve' ];
	$labels_inside = $katb_options[ 'katb_show_labels_inside' ];
	$katb_allowed_html = katb_allowed_html();
	
	//Initialize Variables
	if( $labels_inside == 1 ) {
		$katb_author = $author_label;
		$katb_email = $email_label;
		$katb_website = $website_label;
		$katb_location = $location_label;
		$katb_custom1 = $custom1_label;
		$katb_custom2 = $custom2_label;
		$katb_title = $title_label;
		$katb_testimonial = $testimonial_label;
		$katb_rating = 0.0;
	} else {
		$katb_author = '';
		$katb_email = '';
		$katb_website = '';
		$katb_location = '';
		$katb_custom1 = '';
		$katb_custom2 = '';
		$katb_title = '';
		$katb_testimonial = '';
		$katb_rating = 0.0;
	}
	
	//initiate return string
	$input_html = '';
	
	global $wpdb,$tablename,$katb_options;
	
	//Set up table name for dtatbase updates
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	//get shortcode variables
	extract(shortcode_atts(array(
		'group' => 'All',
		'form' => '1'
    ), $atts));
	
	$katb_group = sanitize_text_field($group);
	$katb_input_form_no = sanitize_text_field($form);

	if ( isset ( $_POST['katb_submitted'.$katb_input_form_no] ) && wp_verify_nonce( $_POST['katb_main_form_nonce'.$katb_input_form_no],'katb_nonce_1' ) ) {
		
		//Initialize error message
		$katb_input_error = '';

		/* --------------- Validate-Sanitize Input ----------------- */
		
		//Order is set in admin
		$katb_order = "";
		
		//auto approve	
		if( $auto_approve == 1 ) {
			$katb_approved = 1;
		} else {
			$katb_approved = 0;
		}
			
		//$katb_group = "";
		//$katb_group = sanitize_text_field($_POST['tb_group']);
	
	
		$katb_datetime = current_time('mysql');
		
		//Validate-Sanitize Author
		$katb_author = sanitize_text_field($_POST['tb_author']);
		if ( $katb_author == '' || $katb_author == $author_label ) {
			if( $use_popup == 1 ) {
				$katb_input_error .= '\n - '.__('Author is required','testimonial-basics');
			} else {
				$katb_input_error .= '<br/> - '.__('Author is required','testimonial-basics');
			}
			$labels_inside == 1 ? $katb_author = $author_label: $katb_author = '';
		}

		//Validate-Sanitize E-mail, note: label will not be an email
		$katb_email = sanitize_email($_POST['tb_email']);
		if( !is_email($katb_email) ) {
			if( $use_popup == 1 ) {
				$katb_input_error .= '\n - '.__('Valid email is required','testimonial-basics');
			} else {
				$katb_input_error .= '<br/> - '.__('Valid email is required','testimonial-basics');
			}
			if( $labels_inside == 1 && $katb_email == '' )$katb_email = $email_label;
		}
		
		//Validate-Sanitize Website
		if( $exclude_website != 1 ) {
			$katb_website = trim($_POST['tb_website']);
			if( $katb_website != '' && $katb_website != $website_label ) {
				$katb_website = esc_url($katb_website);
			} else {
				if( $require_website == 1 ) {
					if( $use_popup == 1 ) {
						$katb_input_error .= '\n - '.__('Website is required','testimonial-basics');
					} else {
						$katb_input_error .= '<br/> - '.__('Website is required','testimonial-basics');
					}
				}
				if( $labels_inside == 1 )$katb_website = $website_label;
			}
		} else {
			$katb_website = '';
		}
		
		//Validate Location
		if( $exclude_location != 1 ) {
			$katb_location = trim($_POST['tb_location']);
			if( $katb_location != '' && $katb_location != $location_label ) {
				$katb_location = sanitize_text_field($_POST['tb_location']);
			} else {
				if( $require_location == 1 ) {
					if( $use_popup == 1 ) {
						$katb_input_error .= '\n - '.__('Location is required','testimonial-basics');
					} else {
						$katb_input_error .= '<br/> - '.__('Location is required','testimonial-basics');
					}
				}
				$labels_inside == 1 ? $katb_location = $location_label : $katb_location = '';
			}
		} else {
			$katb_location = '';
		}
		
		//Validate custom1
		if( $exclude_custom1 != 1 ) {
			$katb_custom1 = trim($_POST['tb_custom1']);
			if( $katb_custom1 != '' && $katb_custom1 != $custom1_label ) {
				$katb_custom1 = sanitize_text_field($_POST['tb_custom1']);
			} else {
				if( $require_custom1 == 1 ) {
					if( $use_popup == 1 ) {
						$katb_input_error .= '\n - '.esc_html($custom1_label).' '.__('is required','testimonial-basics');
					} else {
						$katb_input_error .= '<br/> - '.esc_html($custom1_label).' '.__('is required','testimonial-basics');
					}
				}
				$labels_inside == 1 ? $katb_custom1 = $custom1_label : $katb_custom1 = '' ;
			}
		} else {
			$katb_custom1 = '';
		}
		
		//Validate custom2
		if( $exclude_custom2 != 1 ) {
			$katb_custom2 = trim($_POST['tb_custom2']);
			if( $katb_custom2 != '' && $katb_custom2 != $custom2_label ) {
				$katb_custom2 = sanitize_text_field($_POST['tb_custom2']);
			} else {
				if( $require_custom2 == 1 ) {
					if( $use_popup == 1 ) {
						$katb_input_error .= '\n - '.esc_html($custom2_label).' '.__('is required','testimonial-basics');
					} else {
						$katb_input_error .= '<br/> - '.esc_html($custom2_label).' '.__('is required','testimonial-basics');
					}
				}
				$labels_inside == 1 ? $katb_custom2 = $custom2_label : $katb_custom2 = '';
			}
		} else {
			$katb_custom2 = '';
		}

		//validate rating
		if( $use_ratings == 1 ) {
			$katb_rating = sanitize_text_field($_POST['tb_rating']);
			if( $katb_rating == '' ) $katb_rating = '0.0';
			if( $katb_rating == '0') $katb_rating = '0.0';
			if( $katb_rating == '1') $katb_rating = '1.0';
			if( $katb_rating == '2') $katb_rating = '2.0';
			if( $katb_rating == '3') $katb_rating = '3.0';
			if( $katb_rating == '4') $katb_rating = '4.0';
			if( $katb_rating == '5') $katb_rating = '5.0';
		}else{
			$katb_rating = '0.0';
		}
		
		//Captcha Check
		if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
			$katb_captcha_entered = sanitize_text_field( $_POST['verify'] );
			if ( $_SESSION[ 'katb_pass_phrase_content' . $katb_input_form_no ] !== sha1( $katb_captcha_entered ) ) {
				if( $use_popup == 1 ) {
					$katb_input_error .= '\n - '.__('Captcha is invalid - please try again','testimonial-basics');
				} else {
					$katb_input_error .= '<br/> - '.__('Captcha is invalid - please try again','testimonial-basics');
				}
			}
		}
		
		//Validate testimonial_title
		if( $exclude_testimonial_title != 1 ) {
			$katb_title = trim($_POST['tb_title']);
			if( $katb_title != '' && $katb_title != $title_label ) {
				$katb_title = sanitize_text_field($_POST['tb_title']);
			} else {
				if( $require_testimonial_title == 1 ) {
					if( $use_popup == 1 ) {
						$katb_input_error .= '\n - '.__('Testimonial title is required','testimonial-basics');
					} else {
						$katb_input_error .= '<br/> - '.__('Testimonial title is required','testimonial-basics');
					}
				}
				$labels_inside == 1 ? $katb_title = $title_label : $katb_title = '';
			}
		} else {
			$katb_title = '';
		}
		
		//Validate Testimonial
		//check for error before processing to avoid html encoding until all is good.
		//premature encoding causes wp_kses to remove smiley images on second pass
		if( $katb_input_error == '' ) {
			//Sanitize first
			$katb_sanitize_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
			//add WordPress Smiley support
			$katb_fix_emoticons = convert_smilies( $katb_sanitize_testimonial );
			//if emoji present convert to html entities
			$katb_testimonial = wp_encode_emoji( $katb_fix_emoticons );
		} else {
			$katb_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
		}
		if ( $katb_testimonial == "" || $katb_testimonial == $testimonial_label ) {
			if( $use_popup == 1 ) {
				$katb_input_error .= '\n - '.__('Testimonial is required','testimonial-basics');
			} else {
				$katb_input_error .= '<br/> - '.__('Testimonial is required','testimonial-basics');
			}
			$labels_inside == 1 ? $katb_testimonial = $testimonial_label : $katb_testimonial = '';
		}
		
		//Validation complete
		if($katb_input_error == "") {
			//OK $katb_input_error is empty so let's update the database
			//first remove label entries if they exist
			if( $katb_location == $location_label ) $katb_location = '';
			if( $katb_website == $website_label ) $katb_website = '';
			if( $katb_custom1 == $custom1_label ) $katb_custom1 = '';
			if( $katb_custom2 == $custom2_label ) $katb_custom2 = '';
			if( $katb_title == $title_label ) $katb_title = '';
			
			$values = array(
				'tb_date' => $katb_datetime,
				'tb_order' => $katb_order,
				'tb_approved' => $katb_approved,
				'tb_group' => $katb_group,
				'tb_name' => $katb_author,
				'tb_email' => $katb_email,
				'tb_location' => $katb_location,
				'tb_custom1' => $katb_custom1,
				'tb_custom2' => $katb_custom2,
				'tb_url' => $katb_website,
				'tb_pic_url' => '',
				'tb_rating' => $katb_rating,
				'tb_title' => $katb_title,
				'tb_testimonial' => $katb_testimonial
			);
			$formats_values = array('%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
			$wpdb->insert($tablename,$values,$formats_values);
			
			//send notification email 
			katb_email_notification($katb_author, $katb_email, $katb_testimonial );
			
			//success message
			if( $use_popup == 1 ){ ?>
				<script><?php echo 'alert("'.__("Testimonial Submitted - Thank You!","testimonial-basics").'")'; ?></script>
			<?php } else {
				$input_html .= '<span class="katb_test_sent">'.__('Testimonial Submitted - Thank You!','testimonial-basics').'</span>';
			}	
			
			//reset the variables
			if( $labels_inside == 1 ) {
				$katb_author = $author_label;
				$katb_email = $email_label;
				$katb_website = $website_label;
				$katb_location = $location_label;
				$katb_custom1 = $custom1_label;
				$katb_custom2 = $custom2_label;
				$katb_title = $title_label;
				$katb_testimonial = $testimonial_label;
			} else {
				$katb_author = '';
				$katb_email = '';
				$katb_website = '';
				$katb_location = '';
				$katb_custom1 = '';
				$katb_custom2 = '';
				$katb_title = '';
				$katb_testimonial = '';
			}
			
		} else {

			// there is an error somewhere
			if( $use_popup == 1 ){
				$error_message = __('There were errors so the testimonial was not added: ','testimonial-basics').$katb_input_error;
				?> <script>alert('<?php echo $error_message; ?>')</script>
			<?php } else {
				$input_html .= '<span class="katb_error">'.__('There were errors so the testimonial was not added: ','testimonial-basics').$katb_input_error.'</span>';
			}
			
		}
	}
	
	/* ---------- Reset button is clicked ---------------- */
	if( isset($_POST['katb_reset'] ) ) {
		//Initialize Variables
		if( $labels_inside == 1 ) {
			$katb_author = $author_label;
			$katb_email = $email_label;
			$katb_website = $website_label;
			$katb_location = $location_label;
			$katb_custom1 = $custom1_label;
			$katb_custom2 = $custom2_label;
			$katb_title = $testimonial_title_label;
			$katb_testimonial = $testimonial_label;
		} else {
			$katb_author = '';
			$katb_email = '';
			$katb_website = '';
			$katb_location = '';
			$katb_custom1 = '';
			$katb_custom2 = '';
			$katb_title = '';
			$katb_testimonial = '';
		}
		//other variables
		$katb_id = "";
		$katb_order = "";
		$katb_approved = "";
		$katb_date = "";
		$katb_time = "";
		$katb_rating = "0.0";
	}
	
	$input_html .= '<div class="katb_input_style">';
			
		if ($katb_options['katb_include_input_title'] == 1) {
			$input_html .= '<h1 class="katb_content_input_title">'.esc_html( stripcslashes( $katb_options['katb_input_title'] ) ).'</h1>';
		}

		if ($katb_options['katb_include_email_note'] == 1) {
			$input_html .= '<span class="katb_email_note">'.esc_html( stripcslashes( $katb_options['katb_email_note'] ) ).'</span>';
		}
	
		$input_html .= '<form method="POST">';
			
			//$input_html .= '<input type="hidden"  name="tb_group" value="'.esc_html( stripcslashes( $katb_group ) ).'" />';
			
			if($labels_inside != 1 ){ $input_html .= '<label class="katb_input_label1">'.esc_html( $author_label ).'</label>'; }
			$input_html .= '<input type="text"  maxlength="100" name="tb_author" value="'.esc_attr( stripcslashes( $katb_author ) ).'" /><br/>';

			if($labels_inside != 1 ){ $input_html .= '<label class="katb_input_label1">'.esc_html( $email_label ).'</label>'; }
			$input_html .= '<input type="text"  maxlength="100" name="tb_email" value="'.esc_attr( stripcslashes( $katb_email ) ).'" /><br/>';
						
			if( $exclude_website != 1 ) {
				if($labels_inside != 1 ){
					$input_html .= '<label class="katb_input_label1">'.esc_html( $website_label ).'</label>';
					if( $katb_website == '' || $katb_website == $widget_label || $katb_website == 'http://'.$widget_label ){
						$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="" /><br/>';
					} else {
						$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="'.esc_url( stripcslashes( $katb_website ) ).'" /><br/>';
					}
				} else {
					if( $katb_website == '' || $katb_website == $website_label || $katb_website == 'http://'.$website_label ){
						$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="'.$website_label.'" /><br/>';
					} else {
						$input_html .= '<input type="text"  maxlength="100" name="tb_website" value="'.esc_url( stripcslashes( $katb_website ) ).'" /><br/>';
					}
				}
			}

			if( $exclude_location != 1 ) {
				if($labels_inside != 1 ){ $input_html .= '<label class="katb_input_label1">'.esc_html( $location_label ).'</label>'; }
				$input_html .= '<input type="text"  maxlength="100" name="tb_location" value="'.esc_attr( stripcslashes( $katb_location ) ).'" /><br/>';
			}
			
			if( $exclude_custom1 != 1 ) {
				if($labels_inside != 1 ){ $input_html .= '<label class="katb_input_label1">'.esc_html( $custom1_label ).'</label>'; }
				$input_html .= '<input type="text"  maxlength="100" name="tb_custom1" value="'.esc_attr( stripcslashes( $katb_custom1 ) ).'" /><br/>';
			}
			
			if( $exclude_custom2 != 1 ) {
				if($labels_inside != 1 ){ $input_html .= '<label class="katb_input_label1">'.esc_html( $custom2_label ).'</label>'; }
				$input_html .= '<input type="text"  maxlength="100" name="tb_custom2" value="'.esc_attr( stripcslashes( $katb_custom2 ) ).'" /><br/>';
			}

			if( $use_ratings == 1 ) {
				//if( $correct_form == true ) {
					if( $katb_rating == '' ) $katb_rating = '0.0';
				//} else {
				//	$katb_rating = '0.0';
				//}
				$input_html .= '<span class="katb_input_rating">';
				$input_html .= '<label class="katb_input_label1">'.esc_attr( $rating_label ).'</label>';
				$input_html .= '<select name="tb_rating" class="katb_css_rating_select">';
				$input_html .= '<option value="0.0" '.selected( esc_attr( $katb_rating ),"0.0",false ).'>0.0</option>';
				$input_html .= '<option value="0.5" '.selected( esc_attr( $katb_rating ),"0.5",false ).'>0.5</option>';
				$input_html .= '<option value="1.0" '.selected( esc_attr( $katb_rating ),"1.0",false ).'>1.0</option>';
				$input_html .= '<option value="1.5" '.selected( esc_attr( $katb_rating ),"1.5",false ).'>1.5</option>';
				$input_html .= '<option value="2.0" '.selected( esc_attr( $katb_rating ),"2.0",false ).'>2.0</option>';
				$input_html .= '<option value="2.5" '.selected( esc_attr( $katb_rating ),"2.5",false ).'>2.5</option>';
				$input_html .= '<option value="3.0" '.selected( esc_attr( $katb_rating ),"3.0",false ).'>3.0</option>';
				$input_html .= '<option value="3.5" '.selected( esc_attr( $katb_rating ),"3.5",false ).'>3.5</option>';
				$input_html .= '<option value="4.0" '.selected( esc_attr( $katb_rating ),"4.0",false ).'>4.0</option>';
				$input_html .= '<option value="4.5" '.selected( esc_attr( $katb_rating ),"4.5",false ).'>4.5</option>';
				$input_html .= '<option value="5.0" '.selected( esc_attr( $katb_rating ),"5.0",false ).'>5.0</option>';
				$input_html .= '</select>';
				$input_html .= '</span>';
			}

			if( $exclude_testimonial_title != 1 ) { if($labels_inside != 1 ){ $input_html .= '<label class="katb_input_label2">'.esc_html( $title_label ).'</label>'; }
				$input_html .= '<input class="katb_title_input" type="text"  name="tb_title" value="'.esc_attr( stripcslashes( $katb_title ) ).'" /><br/>';
			}
			
			if($labels_inside != 1 ){ $input_html .= '<label class="katb_input_label2">'.esc_attr( $testimonial_label ).'</label><br/>'; }
			$input_html .= '<textarea rows="5" name="tb_testimonial" >'.wp_kses_post( stripcslashes( $katb_testimonial ) ).'</textarea>';

			if ( $katb_options['katb_show_html_content'] == TRUE || $katb_options['katb_show_html_content'] == 1 ) {
				$input_html .= '<span class="katb_content_html_allowed">HTML '.__('Allowed','testimonial-basics').' : <code>a p br i em strong q h1-h6</code></span>';
			}
	
			if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
				$input_html .= '<div class="katb_captcha">';
					if( $katb_options['katb_use_color_captcha_2'] == TRUE || $katb_options['katb_use_color_captcha_2'] == 1 ) {
						$input_html .= katb_color_captcha_2( 'content' , $katb_input_form_no );
					} elseif ( $katb_options['katb_use_color_captcha'] == TRUE || $katb_options['katb_use_color_captcha'] == 1 ) {
						$input_html .= katb_color_captcha( 'content' , $katb_input_form_no );
					} else {
						$input_html .= katb_bw_captcha( 'content' , $katb_input_form_no );
					}
					$input_html .= '<input type="text" id="verify_'.$katb_input_form_no.'" name="verify" value="'.$captcha_label.'" onclick="this.select();" />';
				$input_html .= '</div>';
			}

		$input_html .= '<span class="katb_submit_reset">';
		$input_html .= '<input type="hidden" name="katb_form_no" value="'.$katb_input_form_no.'">';
		$input_html .= '<input class="katb_submit" type="submit" name="katb_submitted'.$katb_input_form_no.'" value="'.esc_attr( $submit_label ).'" />';
		$input_html .= '<input class="katb_reset" type="submit" name="katb_reset" value="'.esc_attr( $reset_label ).'" />';
		$input_html .= wp_nonce_field('katb_nonce_1','katb_main_form_nonce'.$katb_input_form_no,false,false);
		$input_html .= '</span>';
		
		$input_html .= '</form>';
		
		$input_html .= '<span class="katb_required_label">'.esc_attr( $required_label ).'</span>';
		
		if ( $katb_options['katb_show_gravatar_link'] == 1 ) {
			$input_html .= '<span class="katb_add_photo">'.__('Add a photo? ','testimonial-basics');
				$input_html .= '<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" >';
					$input_html .= '<img class="gravatar_logo" src="'.plugin_dir_url(__FILE__).'Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" />';
				$input_html .= '</a>';
			$input_html .= '</span>';
		}
	$input_html .= '</div>';

	return $input_html;
}
add_shortcode('katb_input_testimonials', 'katb_display_input_form');