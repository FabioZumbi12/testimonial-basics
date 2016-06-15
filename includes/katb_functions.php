<?php
/**
 * This file holds many of the functions used in Testimonial Basics
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
 
/* ====================================================================================
 * Function Index
 * ------------------------------------------------------------------------------------ 
 * Content Area Display Functions
 *   katb_content_display()----------------------------------------------- ~   90
 *   katb_insert_gravatar()----------------------------------------------- ~  162
 *   katb_validate_gravatar()--------------------------------------------- ~  194
 *   katb_get_title_html()------------------------------------------------ ~  211
 *   katb_get_rating_html()----------------------------------------------- ~  233
 *   katb_get_content_html()---------------------------------------------- ~  256
 *   katb_get_author_html()----------------------------------------------- ~  284
 *   katb_get_location_html()--------------------------------------------- ~  304
 *   katb_get_date_html()------------------------------------------------- ~  317
 *   katb_get_custom1_html()---------------------------------------------- ~  335
 *   katb_get_custom2_html()---------------------------------------------- ~  349
 *   katb_get_website_html()---------------------------------------------- ~  363
 * Excerpts and Popups
 *   katb_setup_popup()--------------------------------------------------- ~  393
 *   katb_testimonial_excerpt_filter()------------------------------------ ~  460
 *   katb_testimonial_excerpt_filter()------------------------------------ ~  533
 * Schema Functions
 *   katb_company_aggregate_display()------------------------------------- ~  587
 *   katb_schema_aggregate_markup----------------------------------------- ~  671
 * Database Retrieval Functions()
 *   katb_get_testimonials_from_ids()------------------------------------- ~  869
 *   katb_get_testimonials()---------------------------------------------- ~  921
 * Page Navigation Functions
 *   katb_setup_pagination()---------------------------------------------- ~ 1078
 *   katb_display_pagination ()------------------------------------------- ~ 1163
 *   katb_get_display_pagination_string()--------------------------------- ~ 1210
 *   katb_offset_setup ()------------------------------------------------- ~ 1264
 * Style Functions
 *   katb_css_rating()---------------------------------------------------- ~ 1336
 *   katb_hex_to_rgba()--------------------------------------------------- ~ 1441
 *   katb_custom_css()---------------------------------------------------- ~ 1469
 * Email Functions
 *   katb_email_notification()-------------------------------------------- ~ 1646
 *   katb_wp_mail_content_type()------------------------------------------ ~ 1684
 * Captcha Functions
 *   katb_bw_captcha()---------------------------------------------------- ~ 1697
 *   katb_color_captcha()------------------------------------------------- ~ 1767
 *   katb_color_captcha_2()----------------------------------------------- ~ 1824
 * Display/Input in code
 *   katb_testimonial_basics_display_in_code()---------------------------- ~ 1918
 *   katb_testimonial_basics_input_in_code()------------------------------ ~ 1979
 * Other Functions
 *   katb_allowed_html()-------------------------------------------------- ~ 2009
 *   katb_current_page_url()---------------------------------------------- ~ 2041
 * 
 * ============================================= End Function Index =================== */
 
/* ====================================================================================
 *                         Content Area Display Functions
 * ==================================================================================== */ 
 
/**
 * This is the initial function call to display the testimonials in the content area.
 * 
 * @param boolean $use_formatted_display yes or no
 * @param boolean $use_schema yes or no
 * @param string $katb_tnumber total number of testimonials
 * @param array $katb_tdata array of testimonial data
 * @param boolean $katb_rotate yes or no
 * @param string $layout top meta or bottom meta
 * @param string $group_name group name from shortcode
 * 
 * @uses katb_get_options() user options for plugin from katb_functions.php
 * @uses katb_company_aggregate_display() displays summary of testimonials from this file
 * @uses katb_validate_gravatar() checks for valid gravatar from katb_functions.php
 * @uses katb_setup_popup() setups the popup from this file
 * @uses katb_testimonial_wrap_div() sets up div wrap for options from this file
 * @uses katb_meta_top() supplies top meta string if required from this file
 * @uses katb_insert_gravatar () returns gravatar set up from this file
 * @uses katb_testimonial_excerpt_filter() excerpt for testimonial from katb_functions.php
 * @uses katb_meta_bottom () returns the bottom meta strip from this file
 * 
 * @return $html html string with content
 */

function katb_content_display( $use_formatted_display , $use_schema, $katb_tnumber, $katb_tdata, $katb_rotate, $layout, $group_name ) {
	
	//get user options
	global $katb_options;
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	$use_excerpts = intval( $katb_options['katb_use_excerpts'] );
	$use_title = intval( $katb_options['katb_show_title'] );
	$use_gravatars = intval( $katb_options['katb_use_gravatars'] );
	$use_round_images = intval( $katb_options['katb_use_round_images'] );
	$use_gravatar_substitute = intval( $katb_options['katb_use_gravatar_substitute'] );
	$gravatar_size = intval( $katb_options['katb_gravatar_size'] );
	$company_name = sanitize_text_field( $katb_options['katb_schema_company_name'] );
	$company_website = esc_url( $katb_options['katb_schema_company_url'] );
	$display_company = intval( $katb_options['katb_schema_display_company'] );
	$display_aggregate = intval( $katb_options['katb_schema_display_aggregate'] );
	$display_reviews = intval( $katb_options['katb_schema_display_reviews'] );
	$use_group_name_for_aggregate = intval( $katb_options['katb_use_group_name_for_aggregate'] );
	$custom_aggregate_name = sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
	$custom_title = sanitize_text_field( $katb_options['katb_title_fallback'] );
	$katb_height = intval( $katb_options['katb_rotator_height'] );
	$katb_speed = intval( $katb_options['katb_rotator_speed'] );
	$katb_transition = sanitize_text_field( $katb_options['katb_rotator_transition'] );
	$length = intval( $katb_options['katb_excerpt_length']);
	$use_formatted_display == 1 ? $format = '' : $format = '_basic';
	
	//set up constant height option for rotated testimonials
	if( $katb_rotate == 1 && $katb_height != 'variable') {
		$katb_height_option = 'style="min-height:'.esc_attr( $katb_height ).'px;overflow:hidden;"';
		$katb_height_outside = $katb_height + 20;
		$katb_height_option_outside = 'style="min-height:'.esc_attr( $katb_height_outside ).'px;overflow:hidden;"';
	} else {
		$katb_height_option = '';
		$katb_height_option_outside = '';
	}
	
	//If we are not displaying anything turn off the schema
	if( $display_company == 0 && $display_aggregate == 0 && $display_reviews == 0 ){$use_schema = 0;}
	
	$use_schema == 1 ? $fileschema = '_schema' : $fileschema = '_noschema';
	if( $layout == 'Mosaic' ) {
		$filerotate = '';
	} else {
		$katb_rotate == 1 ? $filerotate = '_rotate' : $filerotate = '_norotate';
	}
	
	if($layout == 'Side Meta'){
		$filelayout = '_side'; 
	}elseif( $layout == 'Bottom Meta'){
		$filelayout = '_bottom'; 
	}elseif( $layout == 'Mosaic'){
		$filelayout = '_mosaic'; 
	}else{ $filelayout = '_top'; }
	
	//load the layout file
	require( dirname(__FILE__).'/template-parts-content/content'.$fileschema.$filerotate.$filelayout.'.php' );
	
	return;
			
 }

/**
 * This function is a helper function to inset a gravatar/image if one exists
 * 
 * @param string $image_url if uploaded image, this is the url
 * @param string $gravatar_size user option
 * @param boolean $use_gravatars user option 
 * @param boolean $use_gravatar_substitute user option
 * @param boolean $has_valid_avatar result of avatar check 
 * @param string $email address of author
 * 
 * @return $html gravatar insert html
 */
 function katb_insert_gravatar( $image_url , $gravatar_size , $use_gravatars , $use_round_images , $use_gravatar_substitute, $email ){
 	
	//If uploaded photo use that, else use gravatar if selected and available
	if( $use_round_images == 1 ){ $round_class = '_round_image'; } else { $round_class = ''; }
	
	//if gravatars are enabled, check for valid avatar
	if ( $use_gravatars == 1 && $use_gravatar_substitute != 1 ) {
		 $has_valid_avatar = katb_validate_gravatar( $email ); 
	} else {
		$has_valid_avatar = 0;
	}
	
	$html = '';
	
	if ( $image_url != '' )  {
		$html .= '<span class="katb_avatar'.$round_class.'" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" ><img class="avatar" src="'.esc_url( $image_url ).'" alt="Author Picture" /></span>';
	} elseif ( $use_gravatars == 1 && $has_valid_avatar == 1 ) {
		$html .= '<span class="katb_avatar'.$round_class.'" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	} elseif ( $use_gravatars == 1 && $use_gravatar_substitute == 1 ) {
		$html .= '<span class="katb_avatar'.$round_class.'" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	}
	
	return $html;
}
 
 /**
 * Test if gravatar exists for a given email
 * 
 * source : http://codex.wordpress.org/Using_Gravatars
 *
 * @return	boolean	$has_valid_avatar
 */
function katb_validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5( strtolower( trim( $email ) ) );
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers( $uri );
	if ( !preg_match( "|200|" , $headers[0] ) ) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}

/**
 * Helper function to display the title of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_title_html( $use_title , $use_schema , $individual_group_name , $testimonial_title , $custom_title ) {
	if( $testimonial_title != '' ) { $name_to_use = $testimonial_title;
		} elseif( $individual_group_name != '') { $name_to_use = $individual_group_name; 
		} else { $name_to_use = $custom_title; } 
	if( $use_title == 1 ) {	?>
		<span class="katb_title">
			<?php echo stripcslashes( esc_attr( $name_to_use ) ); ?>
			&nbsp;
		</span>
	<?php }
	if ( $use_schema == 1 ) { ?>
		<div class = "katb_title" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
			<meta itemprop="name" content="<?php echo stripcslashes( esc_attr( $name_to_use ) ); ?>">
		</div>
	<?php }
	return;
}

/**
 * Helper function to display the rating of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_rating_html( $use_ratings, $use_schema , $rating ) {
	if( $use_ratings == 1 ) {
		if( $rating == '' ) { $rating = 0; }
		if( $rating > 0 ){ ?>
			<span class="katb_css_rating">
				<?php echo katb_css_rating( $rating ); ?>
			</span>
			<?php if( $use_schema == 1 ) { ?>
				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
					<meta itemprop="worstRating" content="0" />
					<meta itemprop="ratingValue" content="<?php echo esc_attr( $rating ); ?>" />
					<meta itemprop="bestRating" content="5" />
				</div>
			<?php }
		}
	}
	return;
}

/**
 * Helper function to display the content of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_content_html( $use_schema , $format , $use_excerpts , $length ,$gravatar_or_photo , $content , $id , $source ) {
	if( $use_schema == 1 ){ $schema_markup = 'itemprop="reviewBody"'; }else{ $schema_markup = ''; }
	if ( $use_excerpts == 1 ) {
		$text = wpautop( wp_kses_post( stripcslashes( $content ) ) );
		$classID = 'katb_'.$source.'_'.sanitize_text_field( $id );
		$text = katb_testimonial_excerpt_filter( $length , $text , $classID ); ?>
		<div class="katb_test_text<?php echo $format; ?>" <?php echo $schema_markup; ?>>
			<?php
				echo $gravatar_or_photo;
				echo $text;
			?>
		</div>
	<?php } else {
		$text = wpautop( wp_kses_post( stripcslashes( $content ) ) ); ?>
		<div class="katb_test_text<?php echo $format; ?>" <?php echo $schema_markup; ?>>
			<?php
				echo $gravatar_or_photo;
				echo $text;
			?>
		</div>
	<?php }
	return;
}

/**
 * Helper function to display the author of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_author_html( $use_schema , $author_name , $divider ) {
	if( $use_schema == 1 ) { ?>
		<div itemprop="author" itemscope itemtype="http://schema.org/Person">
			<span class="katb_author" itemprop="name">
				<?php echo sanitize_text_field( stripcslashes( $author_name ) ); ?>
				<?php echo $divider; ?>
			</span>
		</div>
	<?php }else { ?>
		<span class="katb_author">
			<?php echo sanitize_text_field( stripcslashes( $author_name ) ); ?>
			<?php echo $divider; ?>
		</span>
	<?php }
}

/**
 * Helper function to display the location of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_location_html( $show_location , $location , $divider ) {
	if ( $show_location == 1 && $location != '' ) { ?>
		<span class="katb_location">
			<?php echo sanitize_text_field( stripcslashes($location ) ); ?>
			<?php echo $divider; ?>
		</span>
	<?php }
}

/**
 * Helper function to display the date of the testimonial.
 * Used by content and widget display templates.
 */ 
function katb_get_date_html( $use_schema , $show_date , $date , $divider ) {
	if ( $show_date == 1 ) {
		$date = sanitize_text_field( $date ); ?>
		<span class="katb_date">
			<?php echo mysql2date(get_option( 'date_format' ), $date ); ?>
			<?php echo $divider; ?>
			<?php if( $use_schema == 1 ) { ?>
				<meta itemprop="datePublished" content="<?php echo mysql2date( 'Y-m-d' , $date ); ?>">
			<?php } ?>
		</span>
	<?php }
	return;
}

/**
 * Helper function to display the custom1 of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_custom1_html( $show_custom1 , $custom1 , $divider ) {
	if ( $show_custom1 == 1 && $custom1 != '' ) { ?>
		<span class="katb_custom1">
			<?php echo sanitize_text_field( stripcslashes( $custom1 ) ); ?>
			<?php echo $divider; ?>
		</span>
	<?php }
	return;
}

/**
 * Helper function to display the custom2 of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_custom2_html( $show_custom2 , $custom2 , $divider ) {
	if ( $show_custom2 == 1 && $custom2 != '' ) { ?>
		<span class="katb_custom2">
			<?php echo sanitize_text_field( stripcslashes( $custom2 ) ); ?>
			<?php echo $divider; ?>
		</span>
	<?php }
	return;
}

/**
 * Helper function to display the website of the testimonial.
 * Used by content and widget display templates.
 */
function katb_get_website_html( $show_website , $website ){
	if ( $show_website == 1 && $website != '' ) { ?>
		<span class="katb_website">
			<a href="<?php echo esc_url( $website ); ?>" title="<?php esc_url( $website ); ?>" target="_blank" ><?php _e('Website','testimonial-basics'); ?></a>
			&nbsp;&nbsp;
		</span>
	<?php }
} 
 
/* ===============================================================================================
 *               Excerpts and Popups
 * =============================================================================================== */

/**
 * This function sets up the html string for the popup testimonial if called.
 * 
 * All popups are displayed the same, using the content display, no schema, top meta.
 * 
 * @param string $i testimonial counter
 * @param array $katb_tdata testimonial data
 * @param boolean $has_valid_avatar result of avatar check
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_meta_top() top meta string from this file
 * @uses katb_meta_bottom() bottom meta string from this file
 * @uses katb_insert_gravatar() 
 * 
 * @return $popup_html string of testimonial used for popup
 */
/* ------------------------------------------------------------------- new function -------------------- */
function katb_setup_popup ( $i, $katb_tdata, $gravatar_or_photo, $source ) {

	global $katb_options;
	if( $source == 'content' ) {
		$use_title = intval( $katb_options['katb_show_title'] );
		$custom_title = sanitize_text_field( $katb_options['katb_title_fallback'] );
		$group_name = sanitize_text_field( $katb_tdata[$i]['tb_group'] );
	}else{
		$use_title =  intval( $katb_options['katb_widget_show_title'] );
		$custom_title = sanitize_text_field( $katb_options['katb_widget_title_fallback'] );
	}
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	$use_schema = 0;
	$use_excerpts = 0;
	$format = '_basic';
	$length = 1000;//just to be sure take excerpts out of the display
	
	?>
	<div id="popwrap_katb_<?php echo $source; ?>_<?php echo sanitize_text_field( $katb_tdata[$i]['tb_id'] ); ?>">
	<div class="katb_topopup" id="katb_<?php echo $source; ?>_<?php echo sanitize_text_field( $katb_tdata[$i]['tb_id'] ); ?>">
	
		<div class="katb_close"></div>
		
		<div class="katb_popup_wrap katb_<?php echo $source; ?>">
		
			<div class="katb_title_rating_wrap">
				<?php 
					katb_get_title_html( $use_title , $use_schema , $katb_tdata[$i]['tb_group'] , $katb_tdata[$i]['tb_title'] , $custom_title );
					katb_get_rating_html( $use_ratings, $use_schema , $katb_tdata[$i]['tb_rating'] );
				?>
			</div>
			<div class="katb_meta_top">
				<?php
					katb_get_author_html( $use_schema , $katb_tdata[$i]['tb_name']  , $divider='&nbsp;&nbsp;' );
					if( $source == 'content' ){
						katb_get_date_html( $use_schema , $katb_options['katb_show_date'] , $katb_tdata[$i]['tb_date'] , $divider='&nbsp;&nbsp;' );
						katb_get_location_html( $katb_options['katb_show_location'] , $katb_tdata[$i]['tb_location'] , $divider='&nbsp;&nbsp;' );
						katb_get_custom1_html( $katb_options['katb_show_custom1'] , $katb_tdata[$i]['tb_custom1'] , $divider='&nbsp;&nbsp;' );
						katb_get_custom2_html( $katb_options['katb_show_custom2'] , $katb_tdata[$i]['tb_custom2'] , $divider='&nbsp;&nbsp;' );
						katb_get_website_html( $katb_options['katb_show_website'] , $katb_tdata[$i]['tb_url'] );
					}else{
						katb_get_date_html( $use_schema , $katb_options['katb_widget_show_date'] , $katb_tdata[$i]['tb_date'] , $divider='&nbsp;&nbsp;' );
						katb_get_location_html( $katb_options['katb_widget_show_location'] , $katb_tdata[$i]['tb_location'] , $divider='&nbsp;&nbsp;' );
						katb_get_custom1_html( $katb_options['katb_widget_show_custom1'] , $katb_tdata[$i]['tb_custom1'] , $divider='&nbsp;&nbsp;' );
						katb_get_custom2_html( $katb_options['katb_widget_show_custom2'] , $katb_tdata[$i]['tb_custom2'] , $divider='&nbsp;&nbsp;' );
						katb_get_website_html( $katb_options['katb_widget_show_website'] , $katb_tdata[$i]['tb_url'] );
					}
					
				?>						
			</div>
			<div class="katb_testimonial_wrap">
				<?php
					katb_get_content_html( $use_schema , $format , $use_excerpts , $length , $gravatar_or_photo , $katb_tdata[$i]['tb_testimonial'] , $katb_tdata[$i]['tb_id'], $source );
				?>
			</div>
	
		</div><!-- close katb_popup_wrap -->
		
	</div><!-- close katb_topopup -->	
		
	<div class="katb_loader"></div>
	
	<div class="katb_excerpt_popup_bg" id="katb_<?php echo $source; ?>_<?php echo sanitize_text_field( $katb_tdata[$i]['tb_id'] ); ?>_bg"></div>
	</div>
	<?php return;	
}
add_action('katb_popup_html','katb_setup_popup');

/** EXCERPT FILTER
 * @Author: Boutros AbiChedid
 * @Date:   June 20, 2011
 * @Websites: http://bacsoftwareconsulting.com/ ; http://blueoliveonline.com/
 * @Description: Preserves HTML formating to the automatically generated Excerpt.
 * Also Code modifies the default excerpt_length and excerpt_more filters.
 * http://bacsoftwareconsulting.com/blog/index.php/wordpress-cat/how-to-preserve-html-tags-in-wordpress-excerpt-without-a-plugin/
 * Modified by 
 * @Author: Kevin Archibald
 */
function katb_testimonial_excerpt_filter( $length , $text , $classID ) {
	
	global $katb_options,$katb_excerpt_required;
	
	$katb_excerpt_required = false;
	
	$more_label = $katb_options['katb_excerpt_more_label'];
	
	//initiate some variables
	$more_requested = false;
	$number_of_words = 0;

	$katb_excerpt = strip_shortcodes( $text );

	//Set the excerpt word count and only break after sentence is complete.
	$excerpt_word_count = $length;
	$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
	$tokens = array();
	$excerptOutput = '';
	$count = 0;

	// Divide the string into tokens; HTML tags, or words, followed by any whitespace
	preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $katb_excerpt, $tokens);

	foreach ($tokens[0] as $token) { 

		if ($count >= $excerpt_word_count && preg_match('/[\,\;\?\.\!]\s*$/uS', $token) && $token != '' ) { 
			// Limit reached, continue until , ; ? . or !occur at the end
			$excerptOutput .= trim($token);
			$number_of_words = $count;
			break;
		}

		// Add words to complete sentence
		$count++;

		// Append what's left of the token
		$excerptOutput .= $token;
		
	}

    $katb_excerpt = trim(force_balance_tags($excerptOutput));
	
	$excerpt_end = '<a href="#" class="katb_excerpt_more" data-id="'.$classID.'" > ...'.$more_label.'</a>';

	if( $number_of_words >= $excerpt_word_count || $more_requested == true ){
		// After the content
		$katb_excerpt .= $excerpt_end; /*Add read more in new paragraph */
		$katb_excerpt_required = true;
	}

	return $katb_excerpt;

}

/**
 * Check if popup is required
 * 
 * This function is used exclusively for the mosaic pages because popups are not integral with the testimonial.
 * That is all popups are set up in one go.
 * The function checks to see if a popup is required.
 * 
 */
function katb_popup_required ( $length , $text ){
	global $katb_options;
	
	//initiate some variables
	$number_of_words = 0;

	$katb_excerpt = strip_shortcodes( $text );

	//Set the excerpt word count and only break after sentence is complete.
	$excerpt_word_count = $length;
	$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
	$tokens = array();
	$count = 0;

	// Divide the string into tokens; HTML tags, or words, followed by any whitespace
	preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $katb_excerpt, $tokens);

	foreach ($tokens[0] as $token) { 

		if ($count >= $excerpt_word_count && preg_match('/[\,\;\?\.\!]\s*$/uS', $token) && $token != '' ) { 
			// Limit reached, continue until , ; ? . or !occur at the end
			$number_of_words = $count;
			break;
		}

		// Add words to complete sentence
		$count++;

	}
	
	if( $number_of_words >= $excerpt_word_count ){
		$katb_is_popup_required = true;
	}else{
		$katb_is_popup_required = false;
	}

	return $katb_is_popup_required;
}

/* =============================================================================================
 *               Schema Functions
 * ============================================================================================= */

/**
 * This function sets up the company and aggregate display and is only used for 
 * if schema is selected and if the user wants to display them.
 * 
 * @param boolean $use_formatted_display 
 * @param string $group_name group name to use for search of testimonials
 * 
 * @uses katb_get_options() from katb_functions.php
 * @uses katb_schema_aggregate_markup() from this file
 * 
 */
function katb_company_aggregate_display( $use_formatted_display , $group_name , $layout ) {
 	
	//get user options
	global $katb_options;
	//$katb_options = katb_get_options();
	$company_name = sanitize_text_field( $katb_options['katb_schema_company_name'] );
	$company_website = esc_url( $katb_options['katb_schema_company_url'] );
	$display_company = intval( $katb_options['katb_schema_display_company'] );
	$display_aggregate = intval( $katb_options['katb_schema_display_aggregate'] );
	$display_reviews = intval( $katb_options['katb_schema_display_reviews'] );
	$use_group_name_for_aggregate = intval( $katb_options['katb_use_group_name_for_aggregate'] );
	$custom_aggregate_name =  sanitize_text_field( $katb_options['katb_custom_aggregate_review_name'] );
	$use_ratings = intval( $katb_options['katb_use_ratings'] );
	
	$html = '';
	
	if( $layout == "Side Meta" || $layout == "Mosaic" ) { $side_meta_class = '_side_meta'; } else { $side_meta_class = ''; }
	
	if( $display_company != 1 && $display_aggregate != 1 ) {
			
			//if company and aggregate info are not displayed use dummy classes to elimate css formatting
			$html .= '<div class="katb_no_display_wrap">';
				$html .= '<div class="katb_no_display_box">';
			
	} else {
				
		if( $use_formatted_display == 1 ) {
			
			$html .= '<div class="katb_schema_summary_wrap'.$side_meta_class.'">';
				$html .= '<div class="katb_schema_summary_box'.$side_meta_class.'">';
		
		} else {
			
			$html .= '<div class="katb_schema_summary_wrap_basic'.$side_meta_class.'">';
				$html .= '<div class="katb_schema_summary_box_basic'.$side_meta_class.'">';
							
		}
				
	}

					if( $display_company != 1 ) {
						$html .= '<meta content="'.stripcslashes( esc_attr( $company_name ) ).'" itemprop="name" />';
						$html .= '<meta content="'.stripcslashes( esc_url($company_website) ).'" itemprop="url" />';
					} else {
						$html .= '<div class="katb_schema_company_wrap'.$side_meta_class.'">';
							if( is_rtl() && $katb_options['katb_remove_rtl_support'] == 0 ){
								$html .= '<span class="katb_company_name" itemprop="name">'.stripcslashes( esc_attr( $company_name ) ).' : '.__('Company','testimonial-basics').'</span><br/>';
								$html .= '<span class="katb_company_website"><a class="company_website" href="'.stripcslashes( esc_url( $company_website ) ).'" title="Company Website" target="_blank" itemprop="url">'.$company_website.'</a> : '.__('Website','testimonial-basics').'</span>';
							}else{
								$html .= '<span class="katb_company_name" itemprop="name">'.__('Company','testimonial-basics').' : '.stripcslashes( esc_attr( $company_name ) ).'</span><br/>';
								$html .= '<span class="katb_company_website">'.__('Website','testimonial-basics').' : <a class="company_website" href="'.stripcslashes( esc_url( $company_website ) ).'" title="Company Website" target="_blank" itemprop="url">'.$company_website.'</a></span>';
							}
							
						$html .= '</div>';	
					}

					if( $use_ratings == 1 ){
						//Call function to display the aggregate rating
						$html .= katb_schema_aggregate_markup( $display_aggregate , $group_name, $use_group_name_for_aggregate , $custom_aggregate_name , $layout );
					}
					
			
				$html .= '</div>';
			$html .= '</div>';
			
	return $html;
			
 }

/**
 * This function sets up the html string for the aggregate markup
 * 
 * The database is queried for the group name to get the average rating, the 
 * review count with ratings and the total review count. It then sets up the 
 * return string based on whether or not the summary is to be dispayed or hidden with
 * meta tags
 * 
 * @param boolean $display_aggregate
 * @param string $group_name
 * @param boolean $use_group_name_for_aggregate
 * @param string $custom_aggregate_name
 * 
 * @return $agg_html string of html
 */
function katb_schema_aggregate_markup ( $display_aggregate , $group_name, $use_group_name_for_aggregate , $custom_aggregate_name , $layout ) {

	//setup database table
	global $wpdb,$tablename, $katb_options;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	if( $layout == "Side Meta" || $layout == "Mosaic" ){ $side_meta_class =  "_side_meta"; } else { $side_meta_class = ''; }
	
	$agg_html = '';
	
	//query database 
	if( $group_name != 'all' ) {
	
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group_name' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
			
	} else {
		
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
						
	}
		
	$count = 0;
	$sum = 0;
	for ( $j = 0 ; $j < $aggregate_total_approved; $j++ ) {
		$rating = (float) $aggregate_data[$j]['tb_rating'];
		if( $rating != '' && $rating > 0 ) {
			$count = $count + 1;
			$sum = $sum + (float)$aggregate_data[$j]['tb_rating'] ;
		}			
	}
	$total_votes = $count;
	
	if( $count == 0 ) {
		$avg_rating = 0;
	} else {
		$avg_rating = round( $sum / $count, 1 );
	}
	
	if( $avg_rating == 0 ) {
		
		$rounded_avg_rating = 0;
		
	} else {
		
		//round to nearest 0.5 out of 5
		if( $avg_rating >= ceil( $avg_rating ) - 0.25 ) {
			$rounded_avg_rating = ceil( $avg_rating );
		} elseif( $avg_rating >= ceil( $avg_rating ) - 0.75 ) {
			$rounded_avg_rating = ceil( $avg_rating ) - 0.50;
		} else {
			$rounded_avg_rating = floor( $avg_rating );
		}
		
	}
	
	if( $count > 1 && $avg_rating > 0 && $rounded_avg_rating > 0 ) {
		
		if( $display_aggregate != 1 ) {
					
			$agg_html .= '<div class="katb_no_display" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
				
				if( $use_group_name_for_aggregate == 1 && $group_name != 'all' ) {
					$agg_html .= '<meta content="'.stripcslashes( esc_attr( $group_name ) ).'" itemprop="itemreviewed" />';
				} else if( $use_group_name_for_aggregate != 1 && $custom_aggregate_name != '' ) {
					$agg_html .= '<meta content="'.stripcslashes( esc_attr( $custom_aggregate_name ) ).'" itemprop="itemreviewed" />';
				} else {
					$agg_html .= '<meta content="'.__('All Reviews','testimonial-basics').'" itemprop="itemreviewed" />';
				}
			
				$agg_html .= '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
					$agg_html .= '<meta content="'.stripcslashes( esc_attr( $avg_rating ) ).'" itemprop="average" />';
					$agg_html .= '<meta content="0" itemprop="worst" />';
					$agg_html .= '<meta content="5" itemprop="best" />';
				$agg_html .= '</span>';
				$agg_html .= '<meta content="'.stripcslashes( esc_attr( $total_votes ) ).'" itemprop="votes" />';
				$agg_html .= '<meta content="'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'" itemprop="count" />';
					  		
			$agg_html .= '</div>';
			
		} else {
			
			$agg_html .= '<div class="katb_aggregate_wrap'.$side_meta_class.'" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
				
				$agg_html .= '<span class="katb_aggregate_source">';
					if( is_rtl() && $katb_options['katb_remove_rtl_support'] == 0 ) {
						if( $side_meta_class == '') $agg_html .= '<span class="aggregate_review_label">'.__( 'Aggregate Review','testimonial-basics' ).'&nbsp;:</span>';
						if( $use_group_name_for_aggregate == 1 && $group_name != 'all' ) {
							$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.stripcslashes( esc_attr( $group_name ) ).'</span>';
						} else if( $use_group_name_for_aggregate != 1 && $custom_aggregate_name != '' ) {
							$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.stripcslashes( esc_attr( $custom_aggregate_name ) ).'</span>';
						} else {
							$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.__('All Reviews','testimonial-basics').'</span>';	
						}
						if( $side_meta_class != '') $agg_html .= '&nbsp;:&nbsp;<span class="aggregate_review_label">'.__( 'Aggregate Review','testimonial-basics' ).'</span>';
					}else{
						$agg_html .= '<span class="aggregate_review_label">'.__( 'Aggregate Review','testimonial-basics' ).' :</span> ';
						if( $use_group_name_for_aggregate == 1 && $group_name != 'all' ) {
							$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.stripcslashes( esc_attr( $group_name ) ).'</span>';
						} else if( $use_group_name_for_aggregate != 1 && $custom_aggregate_name != '' ) {
							$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.stripcslashes( esc_attr( $custom_aggregate_name ) ).'</span>';
						} else {
							$agg_html .= '<span class="aggregate_itemreviewed" itemprop="itemreviewed">'.__('All Reviews','testimonial-basics').'</span>';	
						}
					}
					
				$agg_html .= '</span>';
				
				$agg_html .= '<span class="katb_aggregate_results">';
				
					if( is_rtl() && $katb_options['katb_remove_rtl_support'] == 0 ){
						
						$agg_html .= '<span class="katb_css_rating katb_aggy">';
							$agg_html .= katb_css_rating( $rounded_avg_rating );
						$agg_html .= '&nbsp;</span>';
						
						$agg_html .= '<span class="katb_aggregate_data" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
							$agg_html .= '<span class="best" itemprop="best">5</span>';
							$agg_html .= '<span class="out_of">&nbsp;'.__('out of','testimonial-basics').'&nbsp;</span>';
							$agg_html .= '<span class="average_number" itemprop="average">'.stripcslashes( esc_attr( $avg_rating ) ).'&nbsp;,&nbsp;</span>';
						$agg_html .= '</span>';
						
						if( $total_votes == 1 ) {
							$agg_html .= '<span class="votes_label">'.__('vote','testimonial-basics').'&nbsp;</span>';
							$agg_html .= '<span class="total_votes" itemprop="votes">'.stripcslashes( esc_attr( $total_votes ) ).'&nbsp;,&nbsp;</span>';		
						} else if ( $total_votes == 0 ) {
							$agg_html .= '<span class="votes_label">'.__('not rated','testimonial-basics').'&nbsp;,&nbsp;</span>';
						} else {
							$agg_html .= '<span class="votes_label">'.__('votes','testimonial-basics').'&nbsp;</span>';
							$agg_html .= '<span class="total_votes" itemprop="votes">'.stripcslashes( esc_attr( $total_votes ) ).'&nbsp;,&nbsp;</span>';
						}
						
						if( $aggregate_total_approved == 0 ) {
							$agg_html .= '<span class="reviews_label">'.__('no reviews yet','testimonial-basics').'</span>';
						} elseif( $aggregate_total_approved == 1 ) {
							$agg_html .= '<span class="reviews_label">'.__('review','testimonial-basics').'&nbsp;</span>';
							$agg_html .= '<span class="total_reviews">'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'&nbsp;</span>';
						} else {
							$agg_html .= '<span class="reviews_label">'.__('reviews','testimonial-basics').'&nbsp;</span>';
							$agg_html .= '<span class="total_reviews">'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'&nbsp;</span>';
						}

					}else{
						$agg_html .= '<span class="katb_css_rating katb_aggy">';
						$agg_html .= katb_css_rating( $rounded_avg_rating );
						$agg_html .= '&nbsp;</span>';
						
						$agg_html .= '<span class="katb_aggregate_data" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
							$agg_html .= '<span class="average_number" itemprop="average">'.stripcslashes( esc_attr( $avg_rating ) ).'</span>';
							$agg_html .= '<span class="out_of">&nbsp;'.__('out of','testimonial-basics').'&nbsp;</span>';
							$agg_html .= '<span class="best" itemprop="best">5&nbsp;,&nbsp;</span>';
						$agg_html .= '</span>';
						
						if( $total_votes == 1 ) {
							$agg_html .= '<span class="total_votes" itemprop="votes">'.stripcslashes( esc_attr( $total_votes ) ).'&nbsp;</span>';
							$agg_html .= '<span class="votes_label">'.__('vote','testimonial-basics').'&nbsp;,&nbsp;</span>';
						} else if ( $total_votes == 0 ) {
							$agg_html .= '<span class="votes_label">'.__('not rated','testimonial-basics').'&nbsp;,&nbsp;</span>';
						} else {
							$agg_html .= '<span class="total_votes" itemprop="votes">'.stripcslashes( esc_attr( $total_votes ) ).'&nbsp;</span>';
							$agg_html .= '<span class="votes_label">'.__('votes','testimonial-basics').'&nbsp;,&nbsp;</span>';
						}
						
						if( $aggregate_total_approved == 0 ) {
							$agg_html .= '<span class="reviews_label">'.__('no reviews yet','testimonial-basics').'</span>';
						} elseif( $aggregate_total_approved == 1 ) {
							$agg_html .= '<span class="total_reviews">'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'&nbsp;</span>';
							$agg_html .= '<span class="reviews_label">'.__('review','testimonial-basics').'</span>';	
						} else {
							$agg_html .= '<span class="total_reviews">'.stripcslashes( esc_attr( $aggregate_total_approved ) ).'&nbsp;</span>';
							$agg_html .= '<span class="reviews_label">'.__('reviews','testimonial-basics').'</span>';
						}
					}

				$agg_html .= '</span>';

			$agg_html .= '</div>';
			
		}
	}
	
	return $agg_html;
	
}

/* ================================================================================================
 *         Database Retrieval Functions
 * ================================================================================================ */

/**
 * This function takes a string of id's and returns the testimonials and count
 * for the testimonial
 * 
 * @param string $id is string of id's
 * 
 * @return array $katb_tdata_array testimonials and count
 */
function katb_get_testimonials_from_ids( $id ){
	
	global $wpdb , $tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
		
	
	$id_picks = array();
	$id_picks_processed = array();
	$id_picks = '';
	$id_picks_processed ='';
	$id_picks = explode( ',', $id );
	$katb_tdata_array = array();
	$katb_tdata_array ='';
		
	$counter = 0;
	foreach( $id_picks as $pick ) {
		$id_picks_processed[$counter] = intval( $id_picks[$counter] );
		if( $id_picks_processed[$counter] < 1 ) $id_picks_processed[$counter] = 1;
		$counter++;
	}
	
	$count = 0;
	$count2 = 0;
	foreach( $id_picks_processed as $pick ) {
		$pick_id = $id_picks_processed[$count];
		$tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = '$pick_id' ",ARRAY_A);
		$tnumber = $wpdb->num_rows;
		if( $tnumber == 1 ) {
			$katb_tdata[ $count2 ] = $tdata[0];
			$count2++;
		}
		$count++;					
	}
	
	$katb_tnumber = $count2;
	
	$katb_tdata_array[0] = $katb_tdata;
	$katb_tdata_array[1] = $count2;
	return $katb_tdata_array;
}

/**
 * This function retrieves the testimonials and the number of testimomials 
 * for all cases except when id's are input in the shortcode.
 * 
 * @param string $group is the grouping name for the testimonials
 * @param string $number is the number of testimonials to display
 * @param string $by is the method of testimonial selection
 * @param string $rotate a switch to rotate testimonials in a simple slider
 * 
 * @return array $katb_tdata_array testimonials and count
 */
function katb_get_testimonials( $group , $number, $by , $rotate, $use_pagination ){
	global $wpdb , $tablename, $katb_options;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$katb_tdata_array = array();
	$katb_tdata_array ='';
	$katb_offset_name = home_url().'katb_offset';
	
	if ( $group == 'all' && $number == 'all' && $by == 'date' ) {
			
		if ( isset( $use_pagination ) && $use_pagination == 1 && $rotate == 'no' ) {
			//Setup Pagination
			//Get Pagination items per page
			$katb_items_per_page = intval($katb_options['katb_paginate_number']);
			//Get total entries
			$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$total_entries = $results[0]['COUNT(1)'];
			//check for offset
			if( isset ( $_POST['ka_paginate_post'] ) ) {
				$ka_paginate_action = $_POST['ka_paginate_post'];
				katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			//Pagination
			$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
			$katb_offset = $katb_paginate_setup['offset'];
			if ($katb_offset < 0 ) { $katb_offset = 0; }
			//get results
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
		}
		
		$katb_tnumber = $wpdb->num_rows;
		//wp_die($katb_tnumber);
			
	} elseif ( $group == 'all' && $number == 'all' && $by == 'order' ) {
		
		if ( isset( $use_pagination ) && $use_pagination == 1 && $rotate == 'no' ) {	
			//Setup Pagination
			//Get Pagination items per page
			$katb_items_per_page = intval($katb_options['katb_paginate_number']);
			//Get total entries
			$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$total_entries = $results[0]['COUNT(1)'];
			//check for offset
			if( isset ( $_POST['ka_paginate_post'] ) ) {
				$ka_paginate_action = $_POST['ka_paginate_post'];
				katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			//Pagination
			$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
			$katb_offset = $katb_paginate_setup['offset'];
			if ($katb_offset < 0 ) { $katb_offset = 0; }
			//get results
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC ",ARRAY_A);
		}
		
		$katb_tnumber = $wpdb->num_rows;
		
	} elseif ( $group == 'all' && $number == 'all' && $by == 'random' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( $group == 'all' && $number != 'all' && $by == 'date' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( $group == 'all' && $number != 'all' && $by == 'order' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( $group == 'all' && $number != 'all' && $by == 'random' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( $group != 'all' && $number == 'all' && $by == 'date' ) {
		
		if ( isset( $use_pagination ) && $use_pagination == 1 && $rotate == 'no' ) {
			//Setup Pagination
			//Get Pagination items per page
			$katb_items_per_page = intval($katb_options['katb_paginate_number']);
			//Get total entries
			$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$total_entries = $results[0]['COUNT(1)'];
			//check for offset
			if( isset ( $_POST['ka_paginate_post'] ) ) {
				$ka_paginate_action = $_POST['ka_paginate_post'];
				katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			//Pagination
			$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
			$katb_offset = $katb_paginate_setup['offset'];
			if ($katb_offset < 0 ) { $katb_offset = 0; }		
			//get results
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
		}
		
		$katb_tnumber = $wpdb->num_rows;
		
	} elseif ( $group != 'all' && $number == 'all' && $by == 'order' ) {
		
		if ( isset( $use_pagination ) && $use_pagination == 1 && $rotate == 'no' ) {
			//Setup Pagination
			//Get Pagination items per page
			$katb_items_per_page = intval($katb_options['katb_paginate_number']);
			//Get total entries
			$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$total_entries = $results[0]['COUNT(1)'];
			//check for offset
			if( isset ( $_POST['ka_paginate_post'] ) ) {
				$ka_paginate_action = $_POST['ka_paginate_post'];
				katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
			}
			//Pagination
			$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
			$katb_offset = $katb_paginate_setup['offset'];
			if ($katb_offset < 0 ) { $katb_offset = 0; }
			//get results
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC ",ARRAY_A);		
		}
		
		$katb_tnumber = $wpdb->num_rows;
		
	} elseif ( $group != 'all' && $number == 'all' && $by == 'random' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() ",ARRAY_A);	
		$katb_tnumber = $wpdb->num_rows;	
	} elseif ( $group != 'all' && $number != 'all' && $by == 'date' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( $group != 'all' && $number != 'all' && $by == 'order' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( $group != 'all' && $number != 'all' && $by == 'random' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	}
	
	$katb_tdata_array[0] = $katb_tdata;
	$katb_tdata_array[1] = $katb_tnumber;
	if(isset($katb_paginate_setup))$katb_tdata_array[2] = $katb_paginate_setup;
	//$katb_tdata_array[3] = $katb_offset;
	return $katb_tdata_array;
} 

/*=====================================================================================================
 *                           Page Navigation Functions
 * ==================================================================================================== */
 
/**
 * This function sets up the array $setup for use by the katb_display_pagination() function
 * @param $offset_name : string, name of session variable that stores the offset
 * @param $span : int, number of entries to display on each page.
 * @param $total_entries : string, total number of testimonials
 * 
 * @return $setup : array, contains the setup variables passed to  katb_display_pagination()
 */
function katb_setup_pagination( $offset_name, $span, $total_entries ){
	
	$paginate_setup = array();

	//prevent divide by 0
	if( $span == '' || $span == 0 ) { $span = 10; }
	
	//Check for offset and set to 0 if not there
	if ( isset( $_SESSION[$offset_name] ) ) {
		$offset = $_SESSION[$offset_name];
	} else {
		$offset = 0;
	}
	
	//Calculate display pages required given the span
	$pages_decimal = $total_entries/$span;
	$pages = ceil( $pages_decimal );
	
	//calculate the page selected based on the offset
	$page_selected = intval( $offset/$span + 1 );
	
	//Safety Checks
	if ( $page_selected > $pages ) {
		$offset = 0;
		$_SESSION[$offset_name] = $offset;
		$page_selected = 1;
	}
	if ( $page_selected < 1 ) $page_selected = 1;
			
	//Figure out the pages to list
	$max_page_buttons = 5;
	//Figure out $page_a
	$j = $max_page_buttons;
	while( $page_selected > $j ){ $j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	
	//Set up display configuration
	//only display the first button if there are a lot of downloads
	$pages > ($max_page_buttons * 2)? $first = 'yes' : $first = 'no';
	
	//only display the previous button if more than 1 set
	$pages > $max_page_buttons?	$previous = 'yes': $previous = 'no';
	
	//set up remaining page buttons
	( $page_a + 1 ) < ( $pages + 1 )? $page_b = $page_a + 1: $page_b = 'no';
	( $page_a + 2 ) < ( $pages + 1 )? $page_c = $page_a + 2: $page_c = 'no';
	( $page_a + 3 ) < ( $pages + 1 )? $page_d = $page_a + 3: $page_d = 'no';
	( $page_a + 4 ) < ( $pages + 1 )? $page_e = $page_a + 4: $page_e = 'no';
	
	//only display middle button for large number of downloads
	$pages > ( $max_page_buttons * 2 )? $middle = 'yes': $middle = 'no';
	
	//only display the next button if more than 1 set
	$pages > $max_page_buttons? $next = 'yes': $next = 'no';
	
	//only display the last button if there are a lot of downloads
	$pages > ( $max_page_buttons * 2 )? $last = 'yes': $last = 'no';
	
	$setup = array(
		'offset' => $offset,
		'pages' => $pages,
		'page_selected' => $page_selected,
		'first' => $first,
		'previous' => $previous,
		'page_a' => $page_a,
		'page_b' => $page_b,
		'page_c' => $page_c,
		'page_d' => $page_d,
		'page_e' => $page_e,
		'middle' => $middle,
		'next' => $next,
		'last' => $last
	);
	
	return $setup;
}

/**
 * This function displays the pagination buttons.
 * It is used by katb_testimonial_basics_edit_page() in katb_testimonial_basics_admin.php, 
 * to provide pagination in the Edit Testimonials panel
 * 
 * @param $setup array : supplied by katb_setup_pagination()
 * 
 */
function katb_display_pagination ( $setup ) {
	echo '<form class="katb-pagination" method="POST">';
	if ( $setup['pages'] > 1 ) {
		echo '<input type="button" class="ka_pages" value="Page '.$setup['page_selected'].' / '.$setup['pages'].'">';
		if ( $setup['first'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_paginate" />';
			if ( $setup['previous'] != 'no') echo '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_paginate" />';
			if ( $setup['page_a'] == $setup['page_selected'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_paginate_selected"  />';
			} else {
				echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_paginate"  />';
			}
			if ( $setup['page_b'] == $setup['page_selected'] ) {
				if ( $setup['page_b'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_b'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_paginate" />';
			}
			if ( $setup['page_c'] == $setup['page_selected'] ) {
				if ( $setup['page_c'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_c'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_paginate" />';
			}
			if ( $setup['page_d'] == $setup['page_selected'] ) {
				if ( $setup['page_d'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_d'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_paginate" />';
			}
			if ( $setup['page_e'] == $setup['page_selected'] ) {
				if ( $setup['page_e'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_e'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_paginate" />';
			}
			if ( $setup['middle'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_paginate" />';
			if ( $setup['next'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_paginate" />';
			if ( $setup['last'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_paginate" />';
		}
	echo '</form>';
}

/**
 * This function sets up the displays the pagination buttons html in a string.
 * It is called by katb_list_testimonials() in katb_shortcodes.php
 * 
 * @param $setup array : supplied by katb_setup_pagination()
 * 
 * @return $html_return - the return string to display the pagination
 * 
 */
function katb_get_display_pagination_string ($setup , $use_formatted_display ) {
		
	If( $use_formatted_display == 1 ){ $format = ' format';} else { $format = ''; }

	$html_return = '';
	$html_return .= '<form method="POST" class="katb_paginate'.$format.'">';
	if ( $setup['pages'] > 1 ) {
		$html_return .= '<input type="button" class="ka_display_paginate_summary" value="Page '.$setup['page_selected'].' / '.$setup['pages'].'">';
		if ( $setup['first'] != 'no' ) $html_return .= '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_display_paginate" />';
			if ( $setup['previous'] != 'no') $html_return .=  '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_display_paginate" />';
			if ( $setup['page_a'] == $setup['page_selected'] ) {
				$html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_display_paginate_selected"  />';
			} else {
				$html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_display_paginate"  />';
			}
			if ( $setup['page_b'] == $setup['page_selected'] ) {
				if ( $setup['page_b'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_b'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_c'] == $setup['page_selected'] ) {
				if ( $setup['page_c'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_c'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_d'] == $setup['page_selected'] ) {
				if ( $setup['page_d'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_d'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_e'] == $setup['page_selected'] ) {
				if ( $setup['page_e'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_e'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_display_paginate" />';
			}
			if ( $setup['middle'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_display_paginate" />';
			if ( $setup['next'] != 'no' ) $html_return .=  '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_display_paginate" />';
			if ( $setup['last'] != 'no' ) $html_return .=  '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_display_paginate" />';
		}
	$html_return .=  '</form>';
	return $html_return;
}

/**
 * This function sets up the offset depending which pagination button is clicked
 * Note : $offset is the last testimonial in the previous page and it is stored in
 * a session variable. It is the variable used to determine where the pagination is at.
 * 
 * @param $offset_name : string, name of session variable that stores the offset
 * @param $span : int, number of entries to display on each page.
 * @param $action : string, the value of the button that was clicked
 * @param $total_entries : string, total number of testimonials
 * 
 */
function katb_offset_setup ( $offset_name, $span, $action, $total_entries ) {
	
	//Start by getting offset
	if ( isset( $_SESSION[$offset_name] ) ) {
		$offset = $_SESSION[$offset_name];
	} else {
		$offset = 0;
	}
	
	//prevent divide by 0
	if( $span == '' || $span == 0 ) { $span = 10; }
	
	//Calculate total pages
	$pages_decimal = $total_entries/$span;
	$pages = ceil( $pages_decimal );
	$page_selected = ( $offset/$span + 1 );
	
	//Safety Checks
	if ( $page_selected > $pages ) {
		$offset = 0;
		$_SESSION[$offset_name] = $offset;
		$page_selected = 1;
	}
	if ( $page_selected < 1 ) { $page_selected = 1; }
	
	$max_page_buttons = 5;
	
	//Figure out $page_a
	$j = 5;
	while( $page_selected > $j ){ $j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	
	//Now that we know where we are at, figure out where we are going :)
	if ( $action == '<<' ) {
		$_SESSION[$offset_name] = 0;
	} elseif ( $action == '<' ) {
		if ( $page_a - $max_page_buttons < 1 ) {
			$_SESSION[$offset_name] = 0;
		} else {
			$offset = ( $page_a - $max_page_buttons - 1 ) * $span;
			$_SESSION[$offset_name] = $offset;
		}
	} elseif ( $action == '^' ) {
		$offset = (floor($pages/2) - 1) * $span;
		$_SESSION[$offset_name] = $offset;
	} elseif ( $action == '>' ) {
		if ( $page_a + $max_page_buttons <= $pages ) {
			$offset = ( $page_a + $max_page_buttons - 1 ) * $span;
			$_SESSION[$offset_name] = $offset;
		}
	} elseif ( $action == '>>' ) {
		$offset = ($pages - 1) * $span;
		$_SESSION[$offset_name] = $offset;
	} else {
		$page_no = intval($action);
		$offset = ( $page_no - 1 ) * $span;
		$_SESSION[$offset_name] = $offset;
	}
	
}

/* =================================================================================================
 *              Style Functions
 * ================================================================================================= */

/**
 * This function provides the html for the css rating system
 * 
 * @param $rating is the rating
 * 
 * @return $rating html string 
 */
function katb_css_rating( $rating ){
	$css_rating = '';
	
	switch ( $rating ) {
		
		case 0.0:
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 0.5:
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 1.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 1.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 2.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 2.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 3.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 3.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 4.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-empty"></i>';
			break;
			
		case 4.5:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star-half-alt"></i>';
			break;
			
		case 5.0:
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			$css_rating .= '<i class="icon-katb-star"></i>';
			break;
	}
	
	return $css_rating;
	
}

/**
 * This function hex colors to rgba colors
 * 
 * @param $hex is the hex color string
 * 
 * @return $rgb is the array with trhe rgb values
 */
function katb_hex_to_rgba( $hex ){
	
	 $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

/**
 * add  custom styles
 * Enqueues front-end CSS
 * modified from Twenty Fifteen 1.0
 * @see wp_add_inline_style() to use this function to append the 
 * custom styles to style.css
 * 
 * bring your options into this function to set up your conditional css
 * 
 */
function katb_custom_css() {
	
	$katb_options = katb_get_options();
	$use_formatted_display =  intval( $katb_options['katb_use_formatted_display'] );
	$use_formatted_display_widget = intval( $katb_options['katb_widget_use_formatted_display'] );
	 
	$katb_css = '';
	$katb_css .= '/* ==== Testimonial Basics Custom Styles  ==== */';
	//Content Custom Styles
	if ( $katb_options['katb_use_italic_style'] == 1 ) {
		$katb_css .= '.katb_test_box .katb_test_text,.katb_test_box_basic .katb_test_text_basic,';
		$katb_css .= '.katb_right_box .katb_test_text,.katb_right_box .katb_test_text_basic';
		$katb_css .= '{font-style: italic;}';
	}
	$katb_css .= '.katb_test_box,.katb_test_box_basic,';
	$katb_css .= '.katb_test_box_side_meta,.katb_test_box_basic_side_meta,';
	$katb_css .= '.katb_schema_summary_box_basic,.katb_schema_summary_box_basic_side_meta,';
	$katb_css .= '.katb_schema_summary_box,.katb_schema_summary_box_side_meta,';
	$katb_css .= '.katb_paginate';
	$katb_css .= '{ font-size: '.esc_html( $katb_options['katb_content_font_size'] ).'; }';
	
	if ($katb_options['katb_content_font'] != 'default font') {
		$katb_css .= '.katb_test_wrap *,.katb_test_wrap_basic *,';
		$katb_css .= '.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,';
		$katb_css .= '.katb_popup_wrap.katb_content *,.katb_paginate *,';
		$katb_css .= '.katb_schema_summary_wrap *,.katb_schema_summary_wrap_basic *,';
		$katb_css .= '.katb_schema_summary_wrap_side_meta *,.katb_schema_summary_wrap_basic_side_meta *,';
		$katb_css .= '.katb_grid_wrap *,.katb_grid_wrap_basic *';
		$katb_css .= '{ font-family: '.sanitize_text_field( $katb_options['katb_content_font'] ).';}';
	} else {
		$katb_css .= '.katb_test_wrap *,.katb_test_wrap_basic *,';
		$katb_css .= '.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,';
		$katb_css .= '.katb_popup_wrap.katb_content *,.katb_paginate *,';
		$katb_css .= '.katb_schema_summary_wrap *,.katb_schema_summary_wrap_basic *,';
		$katb_css .= '.katb_schema_summary_wrap_side_meta *,.katb_schema_summary_wrap_basic_side_meta *,';
		$katb_css .= '.katb_grid_wrap *,.katb_grid_wrap_basic *';
		$katb_css .= '{ font-family: inherit; }';
	}
	
	$katb_css .= '.katb_test_wrap,.katb_schema_summary_wrap,';
	$katb_css .= '.katb_test_wrap_side_meta .katb_left_box,';
	$katb_css .= '.katb_schema_summary_box_side_meta .katb_schema_company_wrap_side_meta';
	$katb_css .= '{ background-color: '.esc_html( $katb_options['katb_background_wrap_color'] ).';';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_testimonial_box_font_color'] ).';}';
	
	$katb_css .= '.katb_test_wrap .katb_test_box,.katb_schema_summary_box,';
	$katb_css .= '.katb_test_wrap_side_meta .katb_right_box,';
	$katb_css .= '.katb_schema_summary_box_side_meta .katb_aggregate_wrap_side_meta,';
	$katb_css .= '.katb_test_wrap .katb_test_text *';
	$katb_css .= '{background-color: '.esc_html( $katb_options['katb_testimonial_box_color'] ).';';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_testimonial_box_font_color'] ).'!important; }';
	
	$katb_css .= '/*author,location, and date custom colors */';
	$katb_css .= '.katb_test_box .katb_author,.katb_test_box_side_meta .katb_author,';
	$katb_css .= '.katb_test_box .katb_date,.katb_test_box_side_meta .katb_date,';
	$katb_css .= '.katb_test_box .katb_location,.katb_test_box_side_meta .katb_location,';
	$katb_css .= '.katb_test_box .katb_custom1,.katb_test_box_side_meta .katb_custom1,';
	$katb_css .= '.katb_test_box .katb_custom2,.katb_test_box_side_meta .katb_custom2';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_author_location_color'] ).'!important; }';
	
	$katb_css .= '.katb_test_box a,.katb_schema_summary_box a,.katb_test_box_side_meta a,';
	$katb_css .= '.katb_schema_summary_box_side_meta a,.katb_test_box .katb_test_text .katb_excerpt_more';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_website_link_color'] ).'!important;}';
	
	$katb_css .= '.katb_test_box a:hover,.katb_schema_summary_box a:hover ,.katb_test_box_side_meta a:hover,';
	$katb_css .= '.katb_schema_summary_box_side_meta a:hover,.katb_test_box .katb_test_text .katb_excerpt_more:hover';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_website_link_hover_color'] ).'!important; }';

	$katb_css .= '.katb_paginate.format input {';
	$katb_css .= 'background-color: '.esc_html( $katb_options['katb_testimonial_box_color'] ).'!important;';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_testimonial_box_font_color'] ).'!important;}';

	$katb_css .= '.katb_paginate input {';
	$katb_css .= 'font-size: '.esc_html( $katb_options['katb_content_font_size'] ).'!important; }';
	
	$katb_css .= '.katb_input_style ';
	$katb_css .= '{font-size: '.esc_html( $katb_options['katb_content_input_font_size'] ).'!important; }';
	
	//grid custom styles
	$katb_css .= '.katb_grid_wrap .katb_two_wrap_all {';
	$katb_css .= 'border: 1px solid '.esc_html( $katb_options['katb_testimonial_box_color'] ).'!important;}';

	$katb_css .= '.katb_two_wrap_all .katb_test_box .katb_title_rating_wrap,';
	$katb_css .= '.katb_two_wrap_all .katb_test_box .katb_meta_bottom';
	$katb_css .= '{ background-color: '.esc_html( $katb_options['katb_testimonial_box_color'] ).'!important;}';
	
	$katb_css .= '.katb_two_wrap_all .katb_test_box .katb_test_text';
	$katb_css .= '{ background-color: '.esc_html( $katb_options['katb_background_wrap_color'] ).'!important;}';

	
	// Widget Display Custom Styles

	if ( $katb_options['katb_widget_use_italic_style'] == 1 ) {
		$katb_css .= '.katb_widget_box .katb_test_text,.katb_widget_box_basic .katb_test_text_basic,';
		$katb_css .= '.katb_widget_rotator_box .katb_testimonial_wrap,.katb_widget_rotator_box_basic .katb_testimonial_wrap';
		$katb_css .= '{font-style: italic;}';
	}
		
	$katb_css .= '.katb_widget_box,.katb_widget_box_basic,';
	$katb_css .= '.katb_widget_rotator_box,.katb_widget_rotator_box_basic';
	$katb_css .= '{ font-size: '.esc_html( $katb_options['katb_widget_font_size'] ).' }';
	
	if ( $katb_options['katb_widget_font'] != 'default font' ) {
		$katb_css .= '.katb_widget_wrap *,.katb_widget_wrap_basic *,';
		$katb_css .= '.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,';
		$katb_css .= '.katb_popup_wrap.katb_widget *';
		$katb_css .= '{ font-family: '.sanitize_text_field( $katb_options['katb_widget_font'] ).'; }';
	} else {
		$katb_css .= '.katb_widget_wrap *,.katb_widget_wrap_basic *,';
		$katb_css .= '.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,';
		$katb_css .= '.katb_popup_wrap.katb_widget *';
		$katb_css .= '{ font-family: inherit; }';
	}
	
	$katb_css .= '.katb_widget_rotator_wrap,.katb_widget_box {';
	$katb_css .= 'background-color: '.esc_html( $katb_options['katb_widget_background_color'] ).'; }';
	
	$katb_css .= '.katb_widget_box .katb_title_rating_wrap,';
	$katb_css .= '.katb_widget_box .katb_testimonial_wrap *,';
	$katb_css .= '.katb_widget_rotator_box .katb_title_rating_wrap,';
	$katb_css .= '.katb_widget_rotator_box .katb_testimonial_wrap';
	//$katb_css .= '.katb_widget_wrap .katb_title_rating_wrap';
	$katb_css .= '{	color: '.esc_html( $katb_options['katb_widget_font_color'] ).'!important;}';
		
	$katb_css .= '.katb_widget_box .widget_meta,.katb_widget_rotator_box .widget_meta';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_widget_author_location_color'] ).';}';
	
	$katb_css .= '.katb_widget_box a,.katb_widget_rotator_box a,';
	$katb_css .= '.katb_widget_box a.katb_excerpt_more,.katb_widget_rotator_box a.katb_excerpt_more';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_widget_website_link_color'] ).'!important;}';
	
	$katb_css .= '.katb_widget_box a:hover,.katb_widget_rotator_box a:hover ';
	$katb_css .= '{color: '.esc_html( $katb_options['katb_widget_website_link_hover_color'] ).'!important;}';
	
	$katb_css .= '.katb_widget_box .katb_image_meta_bottom,';
	$katb_css .= '.katb_widget_rotator_box .katb_image_meta_bottom,';
	$katb_css .= '.katb_widget_box .katb_centered_image_meta_bottom,';
	$katb_css .= '.katb_widget_rotator_box .katb_centered_image_meta_bottom';
	$katb_css .= '{ border-top: 1px solid '.esc_html( $katb_options['katb_widget_divider_color'] ).'; }';
	
	$katb_css .= '.katb_widget_box .katb_title_rating_wrap.center,';
	$katb_css .= '.katb_widget_rotator_box .katb_title_rating_wrap.center';
	$katb_css .= '{ border-bottom: 1px solid '.esc_html( $katb_options['katb_widget_divider_color'] ).'; }';
	
	$katb_css .= '.katb_widget_box .katb_image_meta_top,';
	$katb_css .= '.katb_widget_rotator_box .katb_image_meta_top,';
	$katb_css .= '.katb_widget_box .katb_centered_image_meta_top,';
	$katb_css .= '.katb_widget_rotator_box .katb_centered_image_meta_top';
	$katb_css .= '{border-bottom: 1px solid '.esc_html( $katb_options['katb_widget_divider_color'] ).'; }';
	
	//* Widget Input Form

	$katb_css .= '.katb_widget_form {';
	$katb_css .= 'font-size: '.esc_html( $katb_options['katb_widget_input_font_size'] ).'!important; }';
	
	//Other Custom Styles
	$shadow_color = katb_hex_to_rgba( esc_html( $katb_options[ 'katb_star_shadow_color'] ) );
	$katb_css .= '.katb_css_rating i { ';
	$katb_css .= 'color: '.esc_html( $katb_options['katb_star_color'] ).'!important;';
	$katb_css .= 'text-shadow: 2px 2px 2px rgba( '.$shadow_color[0].','.$shadow_color[1].','.$shadow_color[2].',0.5 )!important;}';
		
	$katb_css .= wp_filter_nohtml_kses( $katb_options['katb_custom_css'] );
		
	return $katb_css;
}

/* ======================================================================================================
 *              Email Functions
 * ====================================================================================================== */


/**
 * This function sends the email notification after the testimonial has been input
 * @param string $author name of author
 * @param string $author_email author's email address
 * @param string $testimonial html testimonial string
 */
function katb_email_notification($author, $author_email, $testimonial ){
	
	global $katb_options;
	
	//add filter to use html in contact area
	add_filter( 'wp_mail_content_type', 'katb_wp_mail_content_type' );
	
	//get email address
	if ( isset( $katb_options['katb_contact_email'] ) && $katb_options['katb_contact_email'] != '' ) {
		$emailto = is_email( $katb_options['katb_contact_email'] );
	} else {
		$emailto = is_email( get_option('admin_email') );
	}
	
	$subject_trans = __('You have received a testimonial!','testimonial-basics');
	$subject = $subject_trans;
	
	$body_trans = __('Name: ','testimonial-basics').' '.esc_html( $author )."<br/><br/>"
			.__('Email: ','testimonial-basics').' '.is_email($author_email)."<br/><br/>"
			.__('Comments: ','testimonial-basics')."<br/><br/>"
			.wp_kses_post($testimonial)."<br/><br/>"
			.__('Log in to approve or view it.','testimonial-basics');
	$body = $body_trans;
	
	$headers_trans = __('From: ','testimonial-basics').esc_html( $author ).' <'.is_email($author_email).'>';
	$headers = $headers_trans;
	
	//send email
	wp_mail( $emailto, $subject, $body, $headers );
	
	// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
	remove_filter( 'wp_mail_content_type', 'katb_wp_mail_content_type' );
}
 
/**
 * This function sets up wp_mail() to use html
 * 
 */
function katb_wp_mail_content_type(){
	return 'text/html';	
}

/* ====================================================================================================
 *                     Captcha Functions
 * ==================================================================================================== */

/**
 * This function sets up a black and white captcha for the input form, 
 * returning a string of html for the captcha image
 * 
 */
function katb_bw_captcha( $form_source, $form_no ){

	// Set some important CAPTCHA constants
	$number_characters = 6; // number of characters in pass-phrase
	$captcha_height = 26; // height of image
  
  	$image_return_string = '';
  
	// Generate the random pass-phrase
	$pass_phrase = "";
	$characters = 'abcdefghijklmnopqrstuvwxyz';
	for ($i = 0; $i < $number_characters; $i++) {
		$position = mt_rand( 0, strlen($characters) - 1 );
		$pass_phrase .= $characters[$position];
	}
	
	$font_file_url = dirname(__FILE__).'/Vera.ttf';
	
	$textbox_size = imagettfbbox( 16, 0, $font_file_url, $pass_phrase );
	$text_width = $textbox_size[2] - $textbox_size[0];
	$captcha_width = $text_width + 10; // width of image
	
	$form_id = $form_source.$form_no;
	  
    // Store the encrypted pass-phrase in a session variable
	$_SESSION[ 'katb_pass_phrase_' . $form_id ] = SHA1($pass_phrase);

	// Create the image  
	$katb_img = imagecreatetruecolor($captcha_width, $captcha_height);  
	// Set a white background with black text and gray graphics  
	$bg_color = imagecolorallocate($katb_img, 255, 255, 255);		// white  
	$text_color = imagecolorallocate($katb_img, 0, 0, 0);   		// black  
	$graphic_color = imagecolorallocate($katb_img, 64, 64, 64);   	// dark gray

	// Fill the background
	imagefilledrectangle($katb_img, 0, 0, $captcha_width, $captcha_height, $bg_color);
	// Draw some random lines
	for ($i = 0; $i < 5; $i++) {
		imageline($katb_img, 0, rand() % $captcha_height, $captcha_width, rand() % $captcha_height, $graphic_color);
	}

	// Sprinkle in some random dots
	for ($i = 0; $i < 50; $i++) {
		imagesetpixel($katb_img, rand() % $captcha_width, rand() % $captcha_height, $graphic_color);
	}
	// Draw the pass-phrase string
	imagettftext($katb_img, 16, 0, 5, $captcha_height - 5, $text_color, $font_file_url, $pass_phrase);
	
	ob_start();
	  imagepng($katb_img);
	  $contents = ob_get_contents();
	ob_end_clean();
	
	$string = 'data:image/png;base64,'.base64_encode($contents);
	
	// Clean up
	imagedestroy($katb_img);
	
	$img_return_string = '<img src="'.$string.'" alt="Verification Captcha" />';

	return $img_return_string;
}

/**
 * This function sets up a color captcha for the input form, 
 * returning a string of html for the captcha image
 * 
 */
function katb_color_captcha( $form_source, $form_no ){
	
	// Set some important CAPTCHA constants
	$number_characters = 5; // number of characters in pass-phrase
	$captcha_width = 120; // width of image
	$captcha_height = 24; // height of image
	
	$image_return_string = '';

	// Create the image  
	$katb_img = imagecreatetruecolor($captcha_width, $captcha_height);  

	// Generate the random pass-phrase
	$pass_phrase = "";
	$characters = 'abcdefghijklmnopqrstuvwxyz';
	$xpos=0;
	$ypos=0;
	for ($i = 0; $i < $number_characters; $i++) {
		$position = mt_rand( 0, strlen($characters) - 1 );
		$pass_phrase .= $characters[$position];
		$letter_img = imagecreatefrompng(dirname(__FILE__).'/captcha_images/'.$characters[$position].'.png');
		imagecopy($katb_img,$letter_img,$xpos,$ypos,0,0,24,24);
		$xpos = $xpos + 24;
	}
   
   // Store the encrypted pass-phrase in a session variable
  	$form_id = $form_source.$form_no;
	$_SESSION[ 'katb_pass_phrase_' . $form_id ] = SHA1($pass_phrase);

	ob_start();
	  imagepng($katb_img);
	  $contents = ob_get_contents();
	ob_end_clean();
	
	$string = 'data:image/png;base64,'.base64_encode($contents);

	// Clean up
	imagedestroy($letter_img);
	imagedestroy($katb_img);
	
	$img_return_string = '<img src="'.$string.'" alt="Verification Captcha" />';

	return $img_return_string;
}

/**
 * This function provides the html and session password for the color option 2 captcha
 * 
 * @param $form_source - either 'widget' or 'content
 * @param $form_no - if more than one widget form on a page they should have different form numbers
 * 
 * @return $return_html - html representing the captcha
 * 
 */
function katb_color_captcha_2( $form_source, $form_no ){
	
	$katb_code_key = array (
		'sIcv1CnLJ6k6',
		'63m1IUWRUjjn',
		'lajBgRjQblvW',
		'Ri0DDNEVbWDX',
		'xSoOfznHgmJp',
		'67WoNF2iAZHR',
		'XxgBqRl4fqXz',
		'YseePGIyWDiG',
		'rWviQrABe1Dj',
		'lnuVuHfVdjal',
		'dZORncMtSOAk',
		'Mg6Ey0TYNFAd',
		'7kLYp8Fp8PnZ',
		'PZfYWIoauaTL',
		'BBDS9jzpsbKG',
		'6UE09Ek8wVYf',
		'Gv4xHuDWPRfs',
		'w3H5BSWnLKpq',
		'KYfeiGkWJowT',
		'Hyt367nHpaL6',
		'4WDPNRqZdJS3',
		'zFi53Wz1l65c',
		'ENM15Ul1bpUh',
		'EQrxJi6CR8zF',
		'cBlPfQ5FaODL',
		'xPxckkMz2uQz',
	);
	$katb_captcha_key = array (
		'sIcv1CnLJ6k6'=>'a',
		'63m1IUWRUjjn'=>'b',
		'lajBgRjQblvW'=>'c',
		'Ri0DDNEVbWDX'=>'d',
		'xSoOfznHgmJp'=>'e',
		'67WoNF2iAZHR'=>'f',
		'XxgBqRl4fqXz'=>'g',
		'YseePGIyWDiG'=>'h',
		'rWviQrABe1Dj'=>'i',
		'lnuVuHfVdjal'=>'j',
		'dZORncMtSOAk'=>'k',
		'Mg6Ey0TYNFAd'=>'l',
		'7kLYp8Fp8PnZ'=>'m',
		'PZfYWIoauaTL'=>'n',
		'BBDS9jzpsbKG'=>'o',
		'6UE09Ek8wVYf'=>'p',
		'Gv4xHuDWPRfs'=>'q',
		'w3H5BSWnLKpq'=>'r',
		'KYfeiGkWJowT'=>'s',
		'Hyt367nHpaL6'=>'t',
		'4WDPNRqZdJS3'=>'u',
		'zFi53Wz1l65c'=>'v',
		'ENM15Ul1bpUh'=>'w',
		'EQrxJi6CR8zF'=>'x',
		'cBlPfQ5FaODL'=>'y',
		'xPxckkMz2uQz'=>'z',
	);
	
	$pass_phrase = '';
	$return_html = '';
	shuffle( $katb_code_key );
	for( $i=0; $i < 5; $i++ ){
		$pass_phrase .= $katb_captcha_key[$katb_code_key[$i]];
		$return_html .= '<img class="single-letter" src="'.plugin_dir_url(__FILE__).'captcha_images/'.$katb_code_key[$i].'.png" alt="captcha" />';
	}
	
	// Store the encrypted pass-phrase in a session variable
	$_SESSION['katb_pass_phrase_'.$form_source.$form_no] = SHA1( $pass_phrase );
	return $return_html;

}

/* =============================================================================================
 *              Display/Input in code
 * ============================================================================================= */

/** katb_testimonial_basics_display_in_code()
 * 
 * This function allows you to use display testimonials in code
 * 
 * It accepts arguments just like in the shortcode and displays accordingly
 *
 * @param string $group group used in database
 * @param string $number: all or a number
 * @param string $by: order or date or random
 * @param string $id: blank or id's of the testimonial separated by a comma
 * @param string $rotate: 'yes' or 'no' used to rotate testimonials
 * @param string $layout: '0','1','2','3','4','5', or '6'
 * @param string $schema: 'default','yes', or 'no'
 * 
 * @uses katb_list_testimonials ( $atts ) in katb_shortcodes.php
 * 
 */
 function katb_testimonial_basics_display_in_code( $group='all', $number='all', $by='random', $id='', $rotate='no', $layout="0", $schema="default" ){
	
	$group = sanitize_text_field( $group );
	$number = strtolower( sanitize_text_field( $number ));
	$by = strtolower( sanitize_text_field( $by ));
	$id = sanitize_text_field($id);
	$rotate = strtolower( sanitize_text_field( $rotate ));
	$layout = sanitize_text_field($layout);
	$schema = sanitize_text_field($schema);
	
	//whitelist rotate
	if( $rotate != 'yes' ) { $rotate = 'no'; }
	
	//white list group
	if( $group == '' || $group == 'All' ) { $group = 'all'; }
	
	//number validation/whitelist
	if( $number == '' || $number == 'All' ) { $number = 'all'; }
	if( $number != 'all' ) {
		if( intval( $number ) < 1 ) {
			$number = 1;
		} else {
			$number = intval( $number );
		}
	}
	
	//Validate $by
	if ( $by != 'date' && $by != 'order') { $by = 'random'; }
	
	//white list layout
	if( $layout == '0' || $layout == '1' || $layout == '2' || $layout == '3' || $layout == '4' || $layout == '5' || $layout == '6' ) {/*do nothing*/}else{ $layout = '0'; }
	
	//white list schema
	if( $schema == 'yes' || $schema == 'no' ){/*do nothing*/}else{$schema = 'default';}
	

	$atts = array(
		'group' => $group,
		'number' => $number,
		'by' => $by,
		'id' => $id,
		'rotate' => $rotate,
		'layout' => $layout,
		'schema' => $schema
	);
	
	echo katb_list_testimonials ( $atts );

}

/** katb_testimonial_basics_input_in_code()
 * 
 * This function allows you to set up the input testimonials form in code
 * 
 * It accepts arguments just like in the shortcode and displays accordingly
 *
 * @param string $group group used in database
 * 
 * @uses katb_display_input_form( $atts ) in katb_shortcodes.php
 * 
 */
 function katb_testimonial_basics_input_in_code( $group='All', $form='1' ){
	
	$group = sanitize_text_field( $group );
	$form = sanitize_text_field( $form );

	//white list group
	if( $group == '' || $group == 'All' || $group == 'all' ) { $group = 'all'; }
	//validate form
	if( $form == '' ){ $form = '1' ;}
	
	$atts = array(
		'group' => $group,
		'form' => $form
	);
	
	echo katb_display_input_form($atts);

}
 
/* ====================================================================================
 *                Other Functions
 * ==================================================================================== */
/**
 * Supplies array of filter parameters for wp_kses($text,$allowed_html)
 * Only this html will be allowed in testimonials submitted by visitors
 * used in katb_check_for_submitted_testimonial()
 * and in katb_input_testimonial_widget.php function widget
 * 
 * @return	array	$allowed_html 
 */
function katb_allowed_html() {
	
	$allowed_html = array (
		'p' => array(),
    	'br' => array(),
		'i' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'em' => array(),
		'strong' => array(),
		'q' => array(),
		'a' => array(
					'href' => array(),
					'title' => array(),
					'target' => array()
					),
		//'img' => array(),
	);
		
    return apply_filters( 'katb_allowed_html', $allowed_html );
}

/** ================ Currently Not Used ===================
 * Gets the current page url for use in a redirect after the testimonial has been submitted
 * Taken from the WordPress.org Forum / search: current url
 * 
 * @return string $pageURL
 */ 
function katb_current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= '://';
	
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	return $pageURL;
}