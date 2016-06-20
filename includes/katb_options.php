<?php
/**
 * This file holds many of the functions used in for user options Testimonial Basics
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
/**
 * Get Testimonial Basics Plugin Options
 * 
 * Array that holds all of the defined values
 * for Testimonial Basics Plugin Options. If the user 
 * has not specified a value for a given Theme 
 * option, then the option's default value is
 * used instead.
 *
 * @uses	katb_get_option_defaults()	defined below
 * 
 * @return	array	$katb_options	current values for all Theme options
 */
 
function katb_get_options() {

	// Get the option defaults
	$katb_option_defaults = katb_get_option_defaults();
	// Globalize the variable that holds the Theme options
	global $katb_options;
	// Parse the stored options with the defaults
	$katb_options = wp_parse_args( get_option( 'katb_testimonial_basics_options', array() ), $katb_option_defaults );
	// Return the parsed array
	return $katb_options;
}

/**
 * Get Testimonial Basics Plugin Option Defaults
 * 
 * Array that holds all of the deault values
 * for Testimonial Basics Plugin Options. 
 *
 * @uses	katb_get_option_parameters()	defined below
 * 
 * 
 * @return	array	$katb_option_defaults	current default values for all Theme options
 */
function katb_get_option_defaults() {
	// Get the array that holds all
	// Theme option parameters
	$katb_option_parameters = katb_get_option_parameters();
	// Initialize the array to hold
	// the default values for all
	// Theme options
	$katb_option_defaults = array();
	// Loop through the option
	// parameters array
	foreach ( $katb_option_parameters as $katb_option_parameter ) {
		$name = $katb_option_parameter['name'];
		// Add an associative array key
		// to the defaults array for each
		// option in the parameters array
		$katb_option_defaults[$name] = $katb_option_parameter['default'];
	}
	// Return the defaults array
	return $katb_option_defaults;
}

/**
 * Get Testimonial Basics Plugin Option Parameters
 * 
 * Array that holds all of the parameters
 * for Testimonial Basics Plugin Options. 
 *
 * @return	array	$options	all elements for each option
 */
function katb_get_option_parameters() {
	global $katb_options;
	
	$options = array (
/* ------------------------- General -------------------------------------- */
		'katb_admin_access_level' => array(
			'name' => 'katb_admin_access_level',
			'title' => __('User role to edit testimonials','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Administrator", 
				"Editor"
			),
			'description' => __('default: Administrator','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 'Administrator',
			'class' => 'select'
		),
		'katb_contact_email' => array(
			'name' => 'katb_contact_email',
			'title' => __('Testimonial notify email address','testimonial-basics'),
			'type' => 'text',
			'description' => __('Leave blank to use admin email','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '',
			'class' => 'email'
		),
		'katb_custom_field_1_name' => array(
			'name' => 'katb_custom_field_1_name',
			'title' => __('Custom Field 1 Name','testimonial-basics'),
			'type' => 'text',
			'description' => __('Provide a Name for Custom Field 1','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => __('Custom1','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_custom_field_2_name' => array(
			'name' => 'katb_custom_field_2_name',
			'title' => __('Custom Field 2 Name','testimonial-basics'),
			'type' => 'text',
			'description' => __('Provide a Name for Custom Field 2','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => __('Custom2','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_remove_rtl_support' => array(
			'name' => 'katb_remove_rtl_support',
			'title' => __('Remove RTL Support','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Remove right-to-left language support and use a plugin','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_use_ratings' => array(
			'name' => 'katb_use_ratings',
			'title' => __('Use Ratings','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Use 5 star rating system','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_star_color' => array(
			'name' => 'katb_star_color',
			'title' => __('Star color for css stars','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #EACB1E, only used for css stars','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '#EACB1E',
			'class' => 'ka_color'
		),
		'katb_star_shadow_color' => array(
			'name' => 'katb_star_shadow_color',
			'title' => __('Shadow color for the css stars','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000, only used for css stars','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '#000000',
			'class' => 'ka_color'
		),
		'katb_enable_rotator' => array(
			'name' => 'katb_enable_rotator',
			'title' => __('Enable the testimonial rotator script','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: checked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_custom_css' => array(
			'name' => 'katb_custom_css',
			'title' => __('Custom CSS','testimonial-basics'),
			'type' => 'textarea',
			'description' => __('replace default css styles or add new ones ','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '',
			'class' => 'css'
		),
		'katb_excerpt_more_label' => array(
			'name' => 'katb_excerpt_more_label',
			'title' => __('Excerpt More Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Provide a custom label for the excerpt more link','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => __('more','testimonial-basics'),
			'class' => 'nohtml'
		),
		//Schema Markup
		'katb_use_schema' => array(
			'name' => 'katb_use_schema',
			'title' => __( 'Use schema markup' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Schema markup is used for Google Snippets to help SEO','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_company_name' => array(
			'name' => 'katb_schema_company_name',
			'title' => __('Schema Company Name','testimonial-basics'),
			'type' => 'text',
			'description' => __('Name of Company the testimonials are about.','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
		'katb_schema_company_url' => array(
			'name' => 'katb_schema_company_url',
			'title' => __('Schema Company Website Reference','testimonial-basics'),
			'type' => 'text',
			'description' => __('Company website address ','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'url'
		),
		'katb_schema_display_company' => array(
			'name' => 'katb_schema_display_company',
			'title' => __( 'Schema Display Company', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Display company name and website','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_display_aggregate' => array(
			'name' => 'katb_schema_display_aggregate',
			'title' => __( 'Schema Display Aggregate', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Display a summary of reviews','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_display_reviews' => array(
			'name' => 'katb_schema_display_reviews',
			'title' => __( 'Schema Display Reviews', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Select to display the individual reviews','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_group_name_for_aggregate' => array(
			'name' => 'katb_use_group_name_for_aggregate',
			'title' => __( 'Use Group Name for Aggregate Name', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Select to use the Group Name','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_custom_aggregate_review_name' => array(
			'name' => 'katb_custom_aggregate_review_name',
			'title' => __('Custom Aggregate Review Name','testimonial-basics'),
			'type' => 'text',
			'description' => __('Enter a name for the aggregate review','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
/* ------------------------- Input Form Options -------------------------------------- */
		'katb_auto_approve' => array(
			'name' => 'katb_auto_approve',
			'title' => __( 'Auto Approve Testimonials' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('CAUTION: Use at your own risk.','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_captcha' => array(
			'name' => 'katb_use_captcha',
			'title' => __( 'Use captcha on input forms' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include captcha.','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_color_captcha' => array(
			'name' => 'katb_use_color_captcha',
			'title' => __( 'Use color captcha option' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to use the color captcha option','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_color_captcha_2' => array(
			'name' => 'katb_use_color_captcha_2',
			'title' => __( 'Use Color Captcha Option 2' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Least secure but most compatible','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_exclude_testimonial_title_input' => array(
			'name' => 'katb_exclude_testimonial_title_input',
			'title' => __('Exclude Title for Testimonial in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_require_testimonial_title_input' => array(
			'name' => 'katb_require_testimonial_title_input',
			'title' => __('Require Title for Testimonial in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_exclude_website_input' => array(
			'name' => 'katb_exclude_website_input',
			'title' => __('Exclude Website in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_require_website_input' => array(
			'name' => 'katb_require_website_input',
			'title' => __('Require website input','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_exclude_location_input' => array(
			'name' => 'katb_exclude_location_input',
			'title' => __('Exclude Location in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_require_location_input' => array(
			'name' => 'katb_require_location_input',
			'title' => __('Require Location input','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_exclude_custom1_input' => array(
			'name' => 'katb_exclude_custom1_input',
			'title' => __('Exclude','testimonial-basics').' '.$katb_options['katb_custom_field_1_name'].' '.__('in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_require_custom1_input' => array(
			'name' => 'katb_require_custom1_input',
			'title' => __('Require','testimonial-basics').' '.$katb_options['katb_custom_field_1_name'].' '.__('input','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_exclude_custom2_input' => array(
			'name' => 'katb_exclude_custom2_input',
			'title' => __('Exclude','testimonial-basics').' '.$katb_options['katb_custom_field_2_name'].' '.__('in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_require_custom2_input' => array(
			'name' => 'katb_require_custom2_input',
			'title' => __('Require','testimonial-basics').' '.$katb_options['katb_custom_field_2_name'].' '.__('input','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
//Content Input Form
		'katb_include_email_note' => array(
			'name' => 'katb_include_email_note',
			'title' => __( 'Include email note' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_email_note' => array(
			'name' => 'katb_email_note',
			'title' => __('Email note','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default:Email is not published','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Email is not published',
			'class' => 'nohtml'
		),
		'katb_use_popup_message' => array(
			'name' => 'katb_use_popup_message',
			'title' => __( 'Use popup messages' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use popup messages for errors and thankyou','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_content_input_font_size' => array(
			'name' => 'katb_content_input_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_include_input_title' => array(
			'name' => 'katb_include_input_title',
			'title' => __( 'Include title on input form' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_input_title' => array(
			'name' => 'katb_input_title',
			'title' => __('Title for Input Form','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default:Add a Testimonial','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Add a Testimonial','testimonial-basics'),
			'class' => 'nohtml'
		),			
		'katb_show_html_content' => array(
			'name' => 'katb_show_html_content',
			'title' => __('Show html allowed strip in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: checked','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_show_gravatar_link' => array(
			'name' => 'katb_show_gravatar_link',
			'title' => __('Show gravatar link','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Allows users to set up Gravatar','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_show_labels_inside' => array(
			'name' => 'katb_show_labels_inside',
			'title' => __('Show labels inside input boxes','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('check to include','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_author_label' => array(
			'name' => 'katb_author_label',
			'title' => __('Author Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for author input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Author *','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_email_label' => array(
			'name' => 'katb_email_label',
			'title' => __('Email Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for email input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Email *','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_website_label' => array(
			'name' => 'katb_website_label',
			'title' => __('Website Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for website input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>__('Website','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_location_label' => array(
			'name' => 'katb_location_label',
			'title' => __('Location Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for location input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Location','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_custom1_label' => array(
			'name' => 'katb_custom1_label',
			'title' => $katb_options['katb_custom_field_1_name'].' '.__('Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label to appear on content form','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => $katb_options['katb_custom_field_1_name'],
			'class' => 'nohtml'
		),
		'katb_custom2_label' => array(
			'name' => 'katb_custom2_label',
			'title' => $katb_options['katb_custom_field_2_name'].' '.__('Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label to appear on content form','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => $katb_options['katb_custom_field_2_name'],
			'class' => 'nohtml'
		),
		'katb_rating_label' => array(
			'name' => 'katb_rating_label',
			'title' => __('Rating Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for rating input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Rating','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_testimonial_title_label' => array(
			'name' => 'katb_testimonial_title_label',
			'title' => __('Testimonial Title Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for title input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Title of Testimonial','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_testimonial_label' => array(
			'name' => 'katb_testimonial_label',
			'title' => __('Testimonial Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for testimonial input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Testimonial *','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_captcha_label' => array(
			'name' => 'katb_captcha_label',
			'title' => __('Captcha Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for captcha input','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Enter Captcha','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_submit_label' => array(
			'name' => 'katb_submit_label',
			'title' => __('Submit Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for submit button','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Submit','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_reset_label' => array(
			'name' => 'katb_reset_label',
			'title' => __('Reset Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for reset button','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('Reset','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_required_label' => array(
			'name' => 'katb_required_label',
			'title' => __('Required Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for required note','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => __('* Required','testimonial-basics'),
			'class' => 'nohtml'
		),
/* ------------------------- Widget Input Form -------------------------------------- */
		'katb_include_widget_email_note' => array(
			'name' => 'katb_include_widget_email_note',
			'title' => __( 'Include email note' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_email_note' => array(
			'name' => 'katb_widget_email_note',
			'title' => __('Email note','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default:Email is not published','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Email is not published','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_use_widget_popup_message' => array(
			'name' => 'katb_use_widget_popup_message',
			'title' => __( 'Use popup messages' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use popup messages for errors and thankyou','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_input_font_size' => array(
			'name' => 'katb_widget_input_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_show_html_widget' => array(
			'name' => 'katb_show_html_widget',
			'title' => __('Show html allowed strip in widget form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: not checked','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_show_widget_gravatar_link' => array(
			'name' => 'katb_show_widget_gravatar_link',
			'title' => __('Show gravatar link','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Allows users to set up Gravatar','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_widget_labels_above' => array(
			'name' => 'katb_widget_labels_above',
			'title' => __('Show input labels above input box','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: not checked or inside input box','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_widget_author_label' => array(
			'name' => 'katb_widget_author_label',
			'title' => __('Widget Author Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for author input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Author-Required','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_email_label' => array(
			'name' => 'katb_widget_email_label',
			'title' => __('Widget Email Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for email input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Email-Required','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_website_label' => array(
			'name' => 'katb_widget_website_label',
			'title' => __('Widget Website Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for website input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Website-Optional','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_location_label' => array(
			'name' => 'katb_widget_location_label',
			'title' => __('Widget Location Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for location input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Location-Optional','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_custom1_label' => array(
			'name' => 'katb_widget_custom1_label',
			'title' => $katb_options['katb_custom_field_1_name'].' '.__('Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label to appear on widget form','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => $katb_options['katb_custom_field_1_name'],
			'class' => 'nohtml'
		),
		'katb_widget_custom2_label' => array(
			'name' => 'katb_widget_custom2_label',
			'title' => $katb_options['katb_custom_field_2_name'].' '.__('Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label to appear on widget form','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => $katb_options['katb_custom_field_2_name'],
			'class' => 'nohtml'
		),
		'katb_widget_rating_label' => array(
			'name' => 'katb_widget_rating_label',
			'title' => __('Widget Rating Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for rating input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Rating','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_testimonial_title_label' => array(
			'name' => 'katb_widget_testimonial_title_label',
			'title' => __('Widget Testimonial Title Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for title input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Title of Testimonial','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_testimonial_label' => array(
			'name' => 'katb_widget_testimonial_label',
			'title' => __('Widget Testimonial Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for testimonial input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Testimonial-Required','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_captcha_label' => array(
			'name' => 'katb_widget_captcha_label',
			'title' => __('Widget Captcha Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for captcha input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Enter Captcha','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_submit_label' => array(
			'name' => 'katb_widget_submit_label',
			'title' => __('Widget Submit Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for submit button','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Submit','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_reset_label' => array(
			'name' => 'katb_widget_reset_label',
			'title' => __('Widget Reset Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for reset button','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => __('Reset','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_required_label' => array(
			'name' => 'katb_widget_required_label',
			'title' => __('Widget Required Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('label for required input','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => '',
			'class' => 'nohtml'
		),
// Content Display
		'katb_layout_option' => array(
			'name' => 'katb_layout_option',
			'title' => __('Layout Option','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'Top Meta',
				'Bottom Meta',
				'Side Meta',
				'Mosaic' 
			),
			'description' => __('Try them to see what you prefer','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => 'Bottom Meta',
			'class' => 'select'
		),
		'katb_content_font' => array(
			'name' => 'katb_content_font',
			'title' => __('Font for Content Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"default font", 
				"Georgia, serif",
				"Verdana, Geneva, sans-serif", 
				"Arial, Helvetica, sans-serif",
				"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
				"Cambria, Georgia, serif",
				"'Comic Sans MS', sans-serif",
				"Tahoma, Geneva, sans-serif",
				"'Times New Roman', Times, serif",
				"'Trebuchet MS', Helvetica, sans-serif"									
			),
			'description' => __('default is theme font','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => 'default font',
			'class' => 'select'
		),
		'katb_content_font_size' => array(
			'name' => 'katb_content_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_use_pagination' => array(
			'name' => 'katb_use_pagination',
			'title' => __( 'Use pagination' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include for ALL or ALL GROUP displays.','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_paginate_number' => array(
			'name' => 'katb_paginate_number',
			'title' => __('Testimonials per page','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"3",
				"5", 
				"10"
			),
			'description' => __('select 3, 5 or 10 per page','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '10',
			'class' => 'select'
		),
		'katb_use_excerpts' => array(
			'name' => 'katb_use_excerpts',
			'title' => __( 'Use excerpts in testimonial display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_excerpt_length' => array(
			'name' => 'katb_excerpt_length',
			'title' => __('Excerpt length in words','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: 80','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '80',
			'class' => 'nohtml'
		),
		'katb_show_title' => array(
			'name' => 'katb_show_title',
			'title' => __( 'Show title in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use a title in your testimonial display','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_title_fallback' => array(
			'name' => 'katb_title_fallback',
			'title' => __('Fallback Title','testimonial-basics'),
			'type' => 'text',
			'description' => __('Title to use if there is no title input or group name','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => __('Review','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_show_website' => array(
			'name' => 'katb_show_website',
			'title' => __( 'Show website in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include website','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_date' => array(
			'name' => 'katb_show_date',
			'title' => __( 'Show date in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include date','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_location' => array(
			'name' => 'katb_show_location',
			'title' => __( 'Show location in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include location','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_custom1' => array(
			'name' => 'katb_show_custom1',
			'title' => __( 'Show' , 'testimonial-basics' ).' '.$katb_options['katb_custom_field_1_name'].' '.__( 'in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_custom2' => array(
			'name' => 'katb_show_custom2',
			'title' => __( 'Show' , 'testimonial-basics' ).' '.$katb_options['katb_custom_field_2_name'].' '.__( 'in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_gravatars' => array(
			'name' => 'katb_use_gravatars',
			'title' => __( 'Use gravatars' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_round_images' => array(
			'name' => 'katb_use_round_images',
			'title' => __( 'Use round gravatars/images' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('All images will be round','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_gravatar_substitute' => array(
			'name' => 'katb_use_gravatar_substitute',
			'title' => __( 'Use gravatar substitute' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use substitute if gravatar unavailable','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_gravatar_size' => array(
			'name' => 'katb_gravatar_size',
			'title' => __('Gravatar size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'40',
				'50',
				'60',
				'70', 
				'80',
				'90',
				'100'
			),
			'description' => __('Select a size for the gravatar','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '80',
			'class' => 'select'
		),
		'katb_use_italic_style' => array(
			'name' => 'katb_use_italic_style',
			'title' => __( 'Use italic font style' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
//Rotator
		'katb_rotator_speed' => array(
			'name' => 'katb_rotator_speed',
			'title' => __('Time between slides','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'4000',
				'5000',
				'6000',
				'7000',
				'8000',
				'9000',
				'10000',
				'11000',
				'12000',
				'13000',
				'14000'
			),
			'description' => __('default: 7000 ms, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => '7000',
			'class' => 'select'
		),
		'katb_rotator_height' => array(
			'name' => 'katb_rotator_height',
			'title' => __('Rotator height in pixels','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'variable',
				'50',
				'75',
				'100',
				'125',
				'150',
				'175',
				'200',
				'225',
				'250',
				'275',
				'300',
				'325',
				'350',
				'400',
				'450',
				'500'
			),
			'description' => __('default: variable','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => 'variable',
			'class' => 'select'
		),
		'katb_rotator_transition' => array(
			'name' => 'katb_rotator_transition',
			'title' => __('Rotator transition effect','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'fade',
				'left to right',
				'right to left'
			),
			'description' => __('default: fade, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => 'fade',
			'class' => 'select'
		),
//Custom Display Options	
		'katb_use_formatted_display' => array(
			'name' => 'katb_use_formatted_display',
			'title' => __( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_background_wrap_color' => array(
			'name' => 'katb_background_wrap_color',
			'title' => __('Color Option 1','testimonial-basics'),
			'type' => 'text',
			'description' => __('wrap color: Top Meta,Bottom Meta, Meta box color: Side Meta','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#EDEDED',
			'class' => 'ka_color'
		),
		'katb_testimonial_box_color' => array(
			'name' => 'katb_testimonial_box_color',
			'title' => __('Color Option 2','testimonial-basics'),
			'type' => 'text',
			'description' => __('Content Box Color','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#DBDBDB',
			'class' => 'ka_color'
		),
		'katb_testimonial_box_font_color' => array(
			'name' => 'katb_testimonial_box_font_color',
			'title' => __('Testimonial Box Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),		
		'katb_author_location_color' => array(
			'name' => 'katb_author_location_color',
			'title' => __('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),		
		'katb_website_link_color' => array(
			'name' => 'katb_website_link_color',
			'title' => __('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #3384E8','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#3384E8',
			'class' => 'ka_color'
		),
		'katb_website_link_hover_color' => array(
			'name' => 'katb_website_link_hover_color',
			'title' => __('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #FFFFFF','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#FFFFFF',
			'class' => 'ka_color'
		),
//Widget
		'katb_widget_layout_option' => array(
			'name' => 'katb_widget_layout_option',
			'title' => __('Widget Layout Option','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Top Meta",
				"Bottom Meta",
				"Image & Meta Top",
				"Image & Meta Bottom",
				"Centered Image & Meta Top",
				"Centered Image & Meta Bottom"
			),
			'description' => __('Try them to see what you prefer','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => 'Bottom Meta',
			'class' => 'select'
		),
		'katb_widget_font' => array(
			'name' => 'katb_widget_font',
			'title' => __('Font for Widget Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"default font", 
				"Georgia, serif",				
				"Verdana, Geneva, sans-serif", 
				"Arial, Helvetica, sans-serif",
				"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
				"Cambria, Georgia, serif",
				"'Comic Sans MS', sans-serif",
				"Tahoma, Geneva, sans-serif",
				"'Times New Roman', Times, serif",
				"'Trebuchet MS', Helvetica, sans-serif"									
			),
			'description' => __('default is theme font','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => 'default font',
			'class' => 'select'
		),
		'katb_widget_font_size' => array(
			'name' => 'katb_widget_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_widget_use_excerpts' => array(
			'name' => 'katb_widget_use_excerpts',
			'title' => __( 'Use excerpts in widget testimonial display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_excerpt_length' => array(
			'name' => 'katb_widget_excerpt_length',
			'title' => __('Widget excerpt length in characters','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: 25','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '25',
			'class' => 'nohtml'
		),
		'katb_widget_show_title' => array(
			'name' => 'katb_widget_show_title',
			'title' => __( 'Show title in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('show title in testimonial','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_title_fallback' => array(
			'name' => 'katb_widget_title_fallback',
			'title' => __('Fallback Title','testimonial-basics'),
			'type' => 'text',
			'description' => __('Title to use if there is no title input or group name','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => __('Review','testimonial-basics'),
			'class' => 'nohtml'
		),
		'katb_widget_show_website' => array(
			'name' => 'katb_widget_show_website',
			'title' => __( 'Show website in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include website','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_date' => array(
			'name' => 'katb_widget_show_date',
			'title' => __( 'Show date in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include date','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_location' => array(
			'name' => 'katb_widget_show_location',
			'title' => __( 'Show location in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include location','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_custom1' => array(
			'name' => 'katb_widget_show_custom1',
			'title' => __( 'Show' , 'testimonial-basics' ).' '.$katb_options['katb_custom_field_1_name'].' '.__( 'in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_custom2' => array(
			'name' => 'katb_widget_show_custom2',
			'title' => __( 'Show' , 'testimonial-basics' ).' '.$katb_options['katb_custom_field_2_name'].' '.__( 'in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_gravatars' => array(
			'name' => 'katb_widget_use_gravatars',
			'title' => __( 'Use gravatars' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_round_images' => array(
			'name' => 'katb_widget_use_round_images',
			'title' => __( 'Use round gravatars/images' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('All images will be round','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_gravatar_substitute' => array(
			'name' => 'katb_widget_use_gravatar_substitute',
			'title' => __( 'Use gravatar substitute' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use substitute if Gravatar unavailable','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_gravatar_size' => array(
			'name' => 'katb_widget_gravatar_size',
			'title' => __('Gravatar size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'40',
				'50',
				'60',
				'70', 
				'80',
				'90',
				'100'
			),
			'description' => __('Select a size for the gravatar','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '60',
			'class' => 'select'
		),
		'katb_widget_use_italic_style' => array(
			'name' => 'katb_widget_use_italic_style',
			'title' => __( 'Use italic font style' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_rotator_speed' => array(
			'name' => 'katb_widget_rotator_speed',
			'title' => __('Widget time between slides','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'4000',
				'5000',
				'6000',
				'7000',
				'8000',
				'9000',
				'10000',
				'11000',
				'12000',
				'13000',
				'14000'
			),
			'description' => __('default: 7000 ms, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => '7000',
			'class' => 'select'
		),
		'katb_widget_rotator_height' => array(
			'name' => 'katb_widget_rotator_height',
			'title' => __('Widget rotator height in pixels','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'variable',
				'50',
				'75',
				'100',
				'125',
				'150',
				'175',
				'200',
				'225',
				'250',
				'275',
				'300',
				'325',
				'350',
				'400',
				'450',
				'500'
			),
			'description' => __('default: variable','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => 'variable',
			'class' => 'select'
		),
		'katb_widget_rotator_transition' => array(
			'name' => 'katb_widget_rotator_transition',
			'title' => __('Widget rotator transition effect','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'fade',
				'left to right',
				'right to left'
			),
			'description' => __('default: fade, IE9,IE10 uses default','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => 'fade',
			'class' => 'select'
		),
		'katb_widget_use_formatted_display' => array(
			'name' => 'katb_widget_use_formatted_display',
			'title' => __( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_widget_background_color' => array(
			'name' => 'katb_widget_background_color',
			'title' => __('Background Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #EDEDED','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#EDEDED',
			'class' => 'ka_color'
		),
		'katb_widget_divider_color' => array(
			'name' => 'katb_widget_divider_color',
			'title' => __('Divider Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #CECECE','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#CECECE',
			'class' => 'ka_color'
		),
		'katb_widget_font_color' => array(
			'name' => 'katb_widget_font_color',
			'title' => __('Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),
		'katb_widget_author_location_color' => array(
			'name' => 'katb_widget_author_location_color',
			'title' => __('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#000000',
			'class' => 'ka_color'
		),
		'katb_widget_website_link_color' => array(
			'name' => 'katb_widget_website_link_color',
			'title' => __('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #3384E8','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#3384E8',
			'class' => 'ka_color'
		),
		'katb_widget_website_link_hover_color' => array(
			'name' => 'katb_widget_website_link_hover_color',
			'title' => __('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #FFFFFF','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#FFFFFF',
			'class' => 'ka_color'
		),																																				
	);
		
    return apply_filters( 'katb_get_option_parameters', $options );
}
 
 
