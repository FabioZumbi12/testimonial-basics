<?php
/**
 * This file is the layout code for displaying testimonials in the content area using 
 * the shortcode. It uses no schema, rotation, side meta, and custom or basic formats.
 * 
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
?>

<div <?php echo $katb_height_option_outside; ?> class="katb_test_wrap<?php echo $format; ?>_side_meta katb_rotate" data-katb_speed="<?php echo esc_attr( $katb_speed ); ?>" data-katb_transition="<?php echo esc_attr( $katb_transition ); ?>">
	
	<?php
		global $katb_excerpt_required;
		//no schema switch
		$use_schema = 0;
		//source is required for setting up excerpts if they are being used
		$source = 'content';
		//Display Individual Testimonials
		for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
		
			//get the gravatar or photo html
			$gravatar_or_photo = katb_insert_gravatar( $katb_tdata[$i]['tb_pic_url'] , $gravatar_size , $use_gravatars, $use_round_images , $use_gravatar_substitute , $katb_tdata[$i]['tb_email'] );	
			
			if( $i == 0 ) { 
				$show_noshow = "katb_rotate_show";
			}else{
				$show_noshow = "katb_rotate_noshow";
			} ?>
			<div class="katb_side_meta_block <?php echo $show_noshow; ?>">
				<div <?php echo $katb_height_option; ?> class="katb_test_box<?php echo $format; ?>_side_meta">
					<div class="katb_left_box">
						<?php if( $gravatar_or_photo != '' ) { ?>
							<div class="katb_side_gravatar">
								<?php echo $gravatar_or_photo; ?>
							</div>
						<?php } ?>
					
						<div class="katb_meta_side">
							<?php
								katb_get_author_html( $use_schema , $katb_tdata[$i]['tb_name']  , $divider='' );
								katb_get_date_html( $use_schema , $katb_options['katb_show_date'] , $katb_tdata[$i]['tb_date'] , $divider='' );
								katb_get_location_html( $katb_options['katb_show_location'] , $katb_tdata[$i]['tb_location'] , $divider='' );
								katb_get_custom1_html( $katb_options['katb_show_custom1'] , $katb_tdata[$i]['tb_custom1'] , $divider='' );
								katb_get_custom2_html( $katb_options['katb_show_custom2'] , $katb_tdata[$i]['tb_custom2'] , $divider='' );
								katb_get_website_html( $katb_options['katb_show_website'] , $katb_tdata[$i]['tb_url'] );
							?>
						</div><!-- close katb_meta_side -->
					</div><!-- close katb_left_box -->
					<div class="katb_right_box">
						<div class="katb_title_rating_wrap">
							<?php 
								katb_get_title_html( $use_title , $use_schema , $katb_tdata[$i]['tb_group'] , $katb_tdata[$i]['tb_title'] , $custom_title );
								katb_get_rating_html( $use_ratings, $use_schema , $katb_tdata[$i]['tb_rating'] );
							?>
						</div>
						<div class="katb_testimonial_wrap">
							<?php
								katb_get_content_html( $use_schema , $format , $use_excerpts , $length , $gravatar_or_photo = '' , $katb_tdata[$i]['tb_testimonial'] , $katb_tdata[$i]['tb_id'] , $source );
							?>
						</div>
					</div><!-- close katb_right_box div -->
				</div><!-- close katb_test_box_basic_side_meta div -->
			</div><!-- close katb_side_meta_block katb div -->
			
			<?php 
			
			//set up hidden popup if excerpt is used and required
			if ( $use_excerpts == 1 && $katb_excerpt_required != false ) { katb_setup_popup( $i, $katb_tdata, $gravatar_or_photo , 'content'  ); }

		}//close for loop
	?>
	
</div><!-- close katb_test_wrap_basic div -->
<div class="katb_clear_fix"></div>