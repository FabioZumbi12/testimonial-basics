<?php
/*
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
   /* This is uninstall.php for the plugin testimonial-basics */
   // If uninstall not called from WordPress exit this function
   if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
   // Delete Options
   delete_option( 'katb_testimonial_basics_options' );
   delete_option( 'widget_katb_display_testimonial_widget');
   delete_option('widget_katb_input_testimonial_widget');
   delete_option('katb_database_version');
   // remove any additionsl options and database tables not removed above
 	global $wpdb;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$wpdb->query("DROP TABLE IF EXISTS $tablename");