<?php
/**
Plugin Name: Testimonial Basics Display Widget
Plugin URI: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Description: A plugin to display testimonials in a widget
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
 
 // use widgets_init action hook to execute custom function
 add_action ( 'widgets_init','katb_display_register_widget' );

//register our widget 
 function katb_display_register_widget() {
 	register_widget ( 'katb_display_testimonial_widget' );
 }
 
 //widget class
class katb_display_testimonial_widget extends WP_Widget {

    //process the new widget
    public function __construct() {
        $widget_ops = array( 
			'classname' => 'katb_display_widget_class', 
			'description' => __('Display Testimonials.','testimonial-basics') 
			); 
        parent::__construct( 'katb_display_testimonial_widget', __('Testimonial Display Widget','testimonial-basics'), $widget_ops );
    }
 	
 	// Form for widget setup
 	public function form ( $instance ) {
 		$katb_display_defaults = array(
			'katb_display_widget_title' => 'Testimonials',
			'katb_display_widget_group' => 'all',
			'katb_display_widget_number' => 'all',
			'katb_display_widget_by' => 'date',
			'katb_display_widget_ids' => '',
			'katb_display_widget_rotate' => 'no',
			'katb_display_widget_layout_override' => '',
			'katb_display_widget_schema_override' => 'default'
		);
		$instance = wp_parse_args( (array) $instance, $katb_display_defaults );
		$title = $instance['katb_display_widget_title'];
		$group = $instance['katb_display_widget_group'];
		$number = $instance['katb_display_widget_number'];
		$by = $instance['katb_display_widget_by'];
		$ids = $instance['katb_display_widget_ids'];
		$rotate = $instance['katb_display_widget_rotate'];
		$layout_override = $instance['katb_display_widget_layout_override'];
		$use_schema_override = $instance['katb_display_widget_schema_override'];
		?>
		
		<p><?php _e('Title : ','testimonial-basics'); ?><input class="widefat" id="<?php echo esc_attr( $this->get_field_id('katb_display_widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_title' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $title ); ?>" /></p>
		<p><?php _e('Group : ','testimonial-basics'); ?><input class="widefat" id="<?php echo esc_attr( $this->get_field_id('katb_display_widget_group' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_group' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $group ); ?>" /></p>
		<p><?php _e('Number : ','testimonial-basics'); ?><input class="widefat" id="<?php echo esc_attr( $this->get_field_id('katb_display_widget_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_number' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $number ); ?>" /></p>
		<p><?php _e('By : ','testimonial-basics'); ?>
			<select name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_by' ) ); ?>">
				<option value="date" <?php selected( $by, "date" ); ?>>date</option>
				<option value="order" <?php selected( $by, "order" ); ?>>order</option>
				<option value="random" <?php selected( $by, "random" ); ?>>random</option>
			</select> 
		</p>
		<p><?php _e('IDs : ','testimonial-basics'); ?><input class="widefat" id="<?php echo esc_attr( $this->get_field_id('katb_display_widget_ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('katb_display_widget_ids' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $ids ); ?>" /></p>
		<p><?php _e('Rotate : ','testimonial-basics'); ?>
			<select name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_rotate' ) ); ?>">
				<option value="no" <?php selected( $rotate, "no" ); ?>>no</option>
				<option value="yes" <?php selected( $rotate, "yes" ); ?>>yes</option>
			</select> 
		</p>
		<p><?php _e('Layout : ','testimonial-basics'); ?><br/>
			<select style="font-size:12px;" name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_layout_override' ) ); ?>">
				<option value="0" <?php selected( $layout_override, "0" ); ?>>default</option>
				<option value="1" <?php selected( $layout_override, "1" ); ?>>no format-meta top</option>
				<option value="2" <?php selected( $layout_override, "2" ); ?>>no format-meta bottom</option>
				<option value="3" <?php selected( $layout_override, "3" ); ?>>no format-image meta top</option>
				<option value="4" <?php selected( $layout_override, "4" ); ?>>no format-image meta bottom</option>
				<option value="5" <?php selected( $layout_override, "5" ); ?>>no format-centered image meta top</option>
				<option value="6" <?php selected( $layout_override, "6" ); ?>>no format-centered image meta bottom</option>
				<option value="7" <?php selected( $layout_override, "7" ); ?>>format-meta top</option>
				<option value="8" <?php selected( $layout_override, "8" ); ?>>format-meta bottom</option>
				<option value="9" <?php selected( $layout_override, "9" ); ?>>format-image meta top</option>
				<option value="10" <?php selected( $layout_override, "10" ); ?>>format-image meta bottom</option>
				<option value="11" <?php selected( $layout_override, "11" ); ?>>format-centered image meta top</option>
				<option value="12" <?php selected( $layout_override, "12" ); ?>>format-centered image meta bottom</option>
			</select> 
		</p>
		<p><?php _e('Use Schema : ','testimonial-basics'); ?>
			<select name="<?php echo esc_attr( $this->get_field_name( 'katb_display_widget_schema_override' ) ); ?>">
				<option value="default" <?php selected( $use_schema_override, "yes" ); ?>>use default</option>
				<option value="no" <?php selected( $use_schema_override, "no" ); ?>>no</option>
				<option value="yes" <?php selected( $use_schema_override, "yes" ); ?>>yes</option>
			</select> 
		</p>
		<?php	
	}
	
	//save the widget settings
	public function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['katb_display_widget_title'] = sanitize_text_field( $new_instance['katb_display_widget_title'] );
		$instance['katb_display_widget_group'] = sanitize_text_field( $new_instance['katb_display_widget_group'] );
		$instance['katb_display_widget_number'] = sanitize_text_field( $new_instance['katb_display_widget_number'] );
		$instance['katb_display_widget_by'] = strtolower(sanitize_text_field( $new_instance['katb_display_widget_by'] ));
		$instance['katb_display_widget_ids'] = sanitize_text_field( $new_instance['katb_display_widget_ids'] );
		$instance['katb_display_widget_rotate'] = strtolower(sanitize_text_field( $new_instance['katb_display_widget_rotate'] ));
		$instance['katb_display_widget_layout_override'] = sanitize_text_field( $new_instance['katb_display_widget_layout_override'] );
		$instance['katb_display_widget_schema_override'] = sanitize_text_field( $new_instance['katb_display_widget_schema_override'] );
		
		//rotate flag whitelist
		if( $instance['katb_display_widget_rotate'] != 'yes' ) $instance['katb_display_widget_rotate'] = 'no';
		
		// group validation/whitelist
		if( $instance['katb_display_widget_group'] == '' ) $instance['katb_display_widget_group'] = 'all';
		
		//number validation/whitelist
		if( $instance['katb_display_widget_number'] == '' ) $instance['katb_display_widget_number'] = 'all';
		if( $instance['katb_display_widget_number'] != 'all' ) {
			if( intval($instance['katb_display_widget_number']) < 1 ) {
				$instance['katb_display_widget_number'] = 1;
			} else {
				$instance['katb_display_widget_number'] = intval($instance['katb_display_widget_number']);
			}
		}
		
		//by whitelist
		if( $instance['katb_display_widget_by'] != 'date' && $instance['katb_display_widget_by'] != 'order') $instance['katb_display_widget_by'] = 'random';
		
		//layout option 1-12
		if( $instance['katb_display_widget_layout_override'] == '0' ) {
			//do nothing
		} elseif( intval($instance['katb_display_widget_layout_override'] ) < 1 ) {
			$instance['katb_display_widget_layout_override'] = '0';
		} elseif( intval($instance['katb_display_widget_layout_override'] ) > 12 ) {
			$instance['katb_display_widget_layout_override'] = '0';
		} else {
			$instance['katb_display_widget_layout_override'] = sanitize_text_field($instance['katb_display_widget_layout_override']);
		}
		
		//schema override
		if( $instance['katb_display_widget_schema_override'] == 'yes' ) {
			//do nothing
		} elseif( $instance['katb_display_widget_schema_override'] == 'no' ) {
			//do nothing
		} else {
			$instance['katb_display_widget_schema_override'] = 'default';
		}
		
		return $instance;
	}
	
	/**
	 * display the widget
	 * 
	 * 
	 * @param array $args
	 * @param $instance
	 * 
	 * @uses katb_get_options() user options from katb_functions.php
	 * @uses katb_widget_get_testimonials() from this file
	 * @uses katb_widget_schema_company_aggregate() from this file
	 * @uses katb_widget_display_testimonial () from this file
	 * 
	 */
    public function widget($args, $instance) {
    	
    	//get user options
    	global $katb_options;
    	$katb_options = katb_get_options();
		$company_name = sanitize_text_field( $katb_options['katb_schema_company_name'] );
		$company_website = esc_url( $katb_options['katb_schema_company_url'] );
		$use_aggregate_group_name = intval( $katb_options['katb_use_group_name_for_aggregate'] );
		$custom_aggregate_name = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
		$use_schema = intval( $katb_options['katb_use_schema'] );
		
		$katb_tdata_array = array();
    	extract ( $args);
		echo $before_widget;
		
		$title = apply_filters( 'widget_title', $instance['katb_display_widget_title'] );
		$group = sanitize_text_field($instance['katb_display_widget_group']);
		$number = sanitize_text_field($instance['katb_display_widget_number']);
		$by = sanitize_text_field($instance['katb_display_widget_by']);
		$rotate = sanitize_text_field($instance['katb_display_widget_rotate']);
		$ids = sanitize_text_field($instance['katb_display_widget_ids']);
		$layout_override = sanitize_text_field( $instance['katb_display_widget_layout_override'] );
		$schema_override = sanitize_text_field( $instance['katb_display_widget_schema_override'] );
		
		if( $rotate == 'yes' ) { $rotate = 1; }
		
		//schema override - change if yes or no do nothing if default
		if( $schema_override == 'yes' ){
			$use_schema = 1;
		}elseif ( $schema_override == 'no' ) {
			$use_schema = 0;
		}
		
		//display the title
		if ( !empty( $title ) ) { echo $before_title.$title.$after_title; }
		
		//OK let's start by getting the testimonial data from the database
		if( $ids != '' ) {
			$katb_tdata_array = katb_get_testimonials_from_ids( $ids );
		} else {
			$use_pagination = 0;
			$katb_tdata_array = katb_get_testimonials(  $group , $number, $by , $rotate , $use_pagination );
		}
		
		$katb_widget_tdata = $katb_tdata_array[0];
		
		$katb_widget_tnumber = $katb_tdata_array[1];

		$katb_widget_error = "";
				
		if ( $katb_widget_tnumber < 2 && $rotate == 1 ) {
			$katb_widget_error = __('You must have 2 approved testimonials to use a rotated display!','testimonial-basics');
		} elseif ( $katb_widget_tnumber == 0 ) {
			$katb_widget_error = __('There are no approved testimonials to display!','testimonial-basics');
		}

		// Database queried
		//Lets display the selected testimonial(s)

		if( $katb_widget_error != '') { ?>
			
			<div class="katb_display_widget_error"><?php echo esc_attr( $katb_widget_error ); ?></div>
			
		<?php } else {
			
			katb_widget_display_testimonial ( $use_schema, $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group, $layout_override );

		} ?>
		
		<br style="clear:both;" />
		
		<?php echo $after_widget; 

	}

}//close the class



/**
 * This function displays the testimonial.
 * 
 * @param array $katb_widget_tdata testimonial data
 * @param string $katb_widget_tnumber total number of testimonials
 * @param boolean $rotate 
 * @param string $group_name group name from widget data
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_validate_gravatar() check for gravatar from this file
 * @uses katb_widget_popup() set up popup  from this file
 * @uses katb_widget_testimonial_wrap_div() sets up main formatting div wrap from this file
 * @uses katb_meta_widget_top() html for top meta from this file
 * @uses katb_testimonial_excerpt_filter()  from this file
 * @uses katb_widget_insert_gravatar()  from this file
 * @uses katb_meta_widget_bottom() html for bottom meta from this file
 */
 
function katb_widget_display_testimonial ( $use_schema, $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group_name , $layout_override ) {
	
	//get user options
	global $katb_options;	
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	$use_excerpts = intval( $katb_options['katb_widget_use_excerpts'] );
	$use_gravatars = intval( $katb_options['katb_widget_use_gravatars'] );
	$use_round_images = intval( $katb_options['katb_widget_use_round_images'] );
	$use_gravatar_substitute = intval( $katb_options['katb_widget_use_gravatar_substitute'] );
	$gravatar_size = intval( $katb_options['katb_widget_gravatar_size'] );
	$layout = sanitize_text_field( $katb_options['katb_widget_layout_option'] );
	$use_formatted_display = intval( $katb_options['katb_widget_use_formatted_display'] );
	$katb_widget_height = intval( $katb_options['katb_widget_rotator_height'] );
	$katb_widget_speed = intval( $katb_options['katb_widget_rotator_speed'] );
	$katb_widget_transition = sanitize_text_field( $katb_options['katb_widget_rotator_transition'] );
	$company_name = sanitize_text_field( $katb_options['katb_schema_company_name'] );
	$company_website = esc_url( $katb_options['katb_schema_company_url'] );
	$use_aggregate_group_name = intval( $katb_options['katb_use_group_name_for_aggregate'] );
	$custom_aggregate_name = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
	$show_date = $katb_options['katb_widget_show_date'];
	$show_location = $katb_options['katb_widget_show_location'];
	$show_website = $katb_options['katb_widget_show_website'];
	$show_custom1 = $katb_options['katb_widget_show_custom1'];
	$show_custom2 = $katb_options['katb_widget_show_custom2'];
	$custom_title = $katb_options['katb_widget_title_fallback'];
	$use_title = $katb_options['katb_widget_show_title'];
	$length = intval( $katb_options['katb_widget_excerpt_length'] );
	
	//set up widget height restriction if any
	if( $katb_widget_height != 'variable') {
		$katb_widget_height_option = 'style="min-height:'.$katb_widget_height.'px;overflow:hidden;"';
		$katb_widget_height_outside = $katb_widget_height + 20;
		$katb_widget_height_option_outside = 'style="min-height:'.$katb_widget_height_outside.'px;overflow:hidden;"';
	} else {
		$katb_widget_height_option = '';
		$katb_widget_height_option_outside = '';
	}

	/* since 4.1.0 added layout override */
	if( $layout_override != '0' ) {
		if( $layout_override == '1' ){
			$layout = 'Top Meta';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '2' ){
			$layout = 'Bottom Meta';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '3' ){
			$layout = 'Image & Meta Top';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '4' ){
			$layout = 'Image & Meta Bottom';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '5' ){
			$layout = 'Centered Image & Meta Top';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '6' ){
			$layout = 'Centered Image & Meta Bottom';
			$use_formatted_display = '0';
		} elseif ( $layout_override == '7' ){
			$layout = 'Top Meta';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '8' ){
			$layout = 'Bottom Meta';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '9' ){
			$layout = 'Image & Meta Top';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '10' ){
			$layout = 'Image & Meta Bottom';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '11' ){
			$layout = 'Centered Image & Meta Top';
			$use_formatted_display = '1';
		} elseif ( $layout_override == '12' ){
			$layout = 'Centered Image & Meta Bottom';
			$use_formatted_display = '1';
		}
	}

	//use formatted display class add
	$use_formatted_display == 1 ? $format = '' : $format = '_basic';
		
	/* since ver 4.1.0 added Image & Meta Top and Image & Meta Bottom layouts
	   to allow independent styling will add the following classes when needed
	   note this is different from the content mods as an extra class was added 
	   rather then appending classes */
	if( $layout == 'Image & Meta Top' ) {
		$new_layout_class = ' img_meta_top';
	} elseif ( $layout == 'Image & Meta Bottom' ) {
		$new_layout_class = ' img_meta_bot';
	} else {
		$new_layout_class = '';
	}

	$use_schema == 1 ? $fileschema = '_schema' : $fileschema = '_noschema';
	
	$rotate == 1 ? $filerotate = '_rotate' : $filerotate = '_norotate';
	
	if( $layout == 'Top Meta' ){ $filelayout = '_top'; }
	elseif($layout == 'Bottom Meta'){ $filelayout = '_bottom'; }
	elseif($layout == 'Image & Meta Top'){ $filelayout = '_imagetop'; }
	elseif($layout == 'Image & Meta Bottom'){ $filelayout = '_imagebottom'; }
	elseif($layout == 'Centered Image & Meta Top'){ $filelayout = '_centerimagetop'; }
	elseif($layout == 'Centered Image & Meta Bottom'){ $filelayout = '_centerimagebottom'; }
	else{$filelayout = '_top';}
	
	//load the layout file
	require( dirname(__FILE__).'/template-parts-widget/widget'.$fileschema.$filerotate.$filelayout.'.php' );
	
	return;
}

/**
 * This function is called if the widget requires a schema aggregate set up.
 * It sets up the company name and website in meta tags, and does a aggregate 
 * average rating.
 * 
 * @param string $company_name user option
 * @param string $company_website user option
 * @param string $group_name user option
 * @param boolean $use_aggregate_group_name user option
 * @param string $custom_aggregate_name user option
 * 
 */
function katb_widget_schema_company_aggregate ( $company_name, $company_website, $group_name, $use_aggregate_group_name, $custom_aggregate_name ) {
	
	?>
	<!-- Company Name and Website -->
	<meta content="<?php echo stripcslashes( esc_attr( $company_name ) ); ?>" itemprop="name" />
	<meta content="<?php echo esc_url( $company_website ); ?>" itemprop="url" />
	<?php
	
	//Aggregate rating if ratings are being used
	
	global $wpdb,$tablename,$katb_options;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	
	if( $use_ratings == 1 ){
		//query database 
		if( $group_name != 'all' ) {
		
			$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group_name' ",ARRAY_A);
			$aggregate_total_approved = $wpdb->num_rows;
				
		} else {
			
			$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$aggregate_total_approved = $wpdb->num_rows;
							
		}
		
		//Get the average of the ratings				
		$count = 0;
		$sum = 0;
		for ( $j = 0 ; $j < $aggregate_total_approved; $j++ ) {
	
			$rating = (float) $aggregate_data[$j]['tb_rating'];
			if( $rating != '' && $rating > 0 ) {
				$count = $count + 1;
				$sum = $sum + (float)$aggregate_data[$j]['tb_rating'] ;
			}			
		}
	
		if( $count == 0 ) $count = 1;
		$avg_rating = round( $sum / $count, 1 );			
						
		?>
		
		<?php if( $count > 1 && $avg_rating > 0 ) { ?>
		
			<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
			
				<?php if( $custom_aggregate_name != '' ) { ?>
					<meta content="<?php echo stripcslashes( esc_attr( $custom_aggregate_name ) ); ?>" itemprop="itemreviewed" />
				<?php } else { ?>
					<meta content="<?php echo stripcslashes( esc_attr( $group_name ) ); ?>" itemprop="itemreviewed" />
				<?php }	?>
				
				<div itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
					<meta content="<?php echo $avg_rating; ?>" itemprop="average"/>
					<meta content="0" itemprop="worst" />
					<meta content="5" itemprop="best" />
				</div>
				<meta content="<?php echo $count; ?>" itemprop="votes" />
				<meta content="<?php echo $aggregate_total_approved; ?>" itemprop="count" />
				
			</div>
		
		<?php }
	}
}