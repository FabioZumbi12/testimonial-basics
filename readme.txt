=== Testimonial Basics ===
Contributors: kevinhaig
Donate link: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Tags: testimonials,ratings,reviews
Requires at least: 4.3
Tested up to: 4.5.3
Stable tag: 4.3.1
License: GPLv3
License URI: http://www.gnu.org/licenses/quick-guide-gplv3.html

Testimonial Basics is an awesome full featured plugin for managing testimonials on your site. No paid upgrades offered or required. There are extensive options to collect and display testimonials for your business.

== Description ==

Testimonial Basics is a full featured testimonial management plugin. 

* backup and restore testimonials
* setup input forms in content or widget areas
* Author,Email,Testimonial are required input fields
* Testimonial Title,Location,Website are optional input fields
* two additional customizable input fields
* show testimonials in content or widget areas
* group testimonials for separate display
* use 5 star rating system
* use sliders and excerpts
* optionally use schema/google snippet markup
* black and white or color captcha built in
* customize text color and background color
* 4 layouts for content display, 6 for widget
* use one of nine web friendly fonts
* include gravatars
* easily edit and approve testimonials in the admin panel
* pagination available in 3, 5, or 10 testimonials per page
* help available in admin panels
* translations : French, Dutch, German, Spanish
* RTL compatible

== Upgrade Notice ==
* This is a major Upgrade for Testimonial Basics.
* Backup your database and testimonials before upgrading.
* go through your site to ensure all testimonials and input forms are being displayed.
* Check that your widgets are working and re install if there are problems.
* Take the time to go through the options, there are new features you may want to use.

== Installation ==

1. Upload Testimonial Basics to the plugin directory 
   (wp-content/plugins/testimonial-basics) of your wordpress setup. 
2. Ensure all sub directories are maintained. 
3. Activate the theme through the Wordpress Admin panel under "Plugins".

== Frequently Asked Questions ==

= Is there documentation for the plugin?

Yes. Detailed documentation is available at http://kevinsspace.ca/testimonial-basics-user-documentation/

= Page load speeds are slow =

If your page load speed is slow it will likely be because you are using Gravatars and you are not using a cache plugin. It is recommended that you use a cache plugin for any site, whether or not you are using Gravatars for Testimonial Basics. I use WP Super Cache.

= My testimonial is not showing? =

Ensure it is approved.

= I just approved a testimonial and it is not showing? =

If you have a cache plugin installed such as WP Super Cache, the page you use to display your testimonials may be cached. Simply edit the page and update it or wait and the cached files will eventually be deleted and refreshed.

= When I input a color number in the cell the color won't change? =

Hit the enter key.

= Why can't users upload photos? =

Users are not allowed to upload photos because it is a security issue. Use of gravatars is highly recommended. Administrators have the ability to add images in the Edit Testimonials admin panel.

== Screenshots ==

1. Option Panel

2. Edit Panel

3. Content Display Layouts

4. Content Display Mosaic

5. Widjet Display Layouts

6. Input forms

== Licensing ==
* Copyright (C) 2016 kevinhaig kevinsspace.ca
* Testimonial Basics is licensed and distributed under the terms of the GNU GPLv3
* License URI: [http://www.gnu.org/licenses/quick-guide-gplv3.html](http://www.gnu.org/licenses/quick-guide-gplv3.html)

    Testimonial Basics is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Testimonial Basics is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.


== Changelog ==

= 4.3.1 =
* fixed translation bug that caused css problems with the edit testimonials panel

= 4.3.0 =
* added RTL support
* added titles to testimonials
* added two additional custom fields
* added mosaic layout to content display
* removed rateit.js and associated code, only the css system is now available
* fixed bug in katb_email_notification() added global $katb_options
* moved content and widget layout options to separate templates
* Switched to standard functions for widget and content display
* modified popups to minimize function use
* removed all unnecessary functions
* modified html/css for content input form
* re wrote the content area input form code
* added in box labels to content input form
* improved responsiveness of the content input form at less than 600 px width
* improved translation by fixing bugs and changing css.
* The "use group name" and "custom individual review name" options have been removed from the Schema Options section under the General Options tab. This is because a testimonial title has been added. If the user chooses to display a title, the testimonial title will be used if not blank, then the Group Name will be used if not blank, then the fall back will be used.
* fixed issue of using custom pagination colors when custom color options are not being used
* Use meta for titles schema so if titles are not shown the meta is available for Google
* Removed rating aggregate from meta in widget display if user is not using ratings
* Fixed date format to display WordPress setting even when schema is used
* Modified captcha generation system to exclude loading php files which caused problems with some security plugins. To do this the image generation is now handled in functions and uses base64 encoding.
* Fixed duplicate id errors for multiple entry forms
* Removed backticks from database set up to reduce errors on upgarde
* Updated Export/Import for the 3 additional fields
* Updated contextual help documentation
* Fixed popups so they are not set up if not required
* fixed bug in Edit Testimonials Panel for deleting single testimonials
* Fixed bug in popup becoming popunder in themes that use postion:relative styles. This was fixed by adding a script that moves all pupup sections to after the body tag.
* Updated Translations


= 4.2.3 =
* Fixed data valdiation for rating adding '0.0' if not used. This was causing the insert to fail in the shortcode. Fixed the widget as well.
* Set up notification email function, fixed html problem, translation problem, and removed download link in order to get wp_mail to work. There was a number of problems with emails not being sent….one of theme being a login link which had to be removed.
* Changed .katb_right_box {width: calc(100% - 120px);} to width:auto; to avoid a css break in Safari.
* Updated translations

= 4.2.2 =
* Added support for WordPress Smiley's
* Added support for Emoji's
* Fixed bug in website required checks
* Improved security

= 4.2.1 =
* Changed schema format for individual reviews
* Added css box
* Changed custom styles to load using wp_add_inline_style() so they load after katb_user_styles.css
* Removed katb_custom_styles.php and code associated with the file load
* Improved security

= 4.2.0 =
* fixed critical error on esc_html function

= 4.1.9 =
* Escaped all translations
* Added third Captcha Option, which is very simple but least secure, hopefully will avoid bots.
* modified widgets to __construct()

= 4.1.8 =
* fixed validation hexcolor to ka_color

= 4.1.7 =
* 4.1.6 svn upload was done incorrectly

= 4.1.6 =
* color picker stopped working after WordPress 4.2 upgrade, had to change the option class to ka_color because hexcolor was causing problems with the jQuery selector

= 4.1.5 =
* added height: auto; to avatar styles.
* Revamped schema for the new set up and tested every layout for the content and widgets with the structured data testing tool
* Modified the content display code separating the ratings display from within the title block to its own function and block
* Added some slight css changes to accommodate the content display changes
* Updated copyright to 2015

= 4.1.4 =
* fixed css bug carrying formatted title color to unformatted display in the widget rotator display
* Added help comment about widget labels inside or above widget input boxes
* Added font-family:"fontello-katb"!important; to .icon-katb-star:before, .icon-katb-star-empty:before, and .icon-katb-star-half-alt:before to improve compatibility
* Added && isset($katb_paginate_setup) to line 305  katb_shortcodes.php , had Notice error for undefined variable
* Passed $use_ratings variable called in line 541 katb_widget_display_testimonial() to katb_widget_insert_title(), because there was a Notice: katb_display_testimonial_widget.php:823 - Undefined variable: use_ratings
* Improved database update code to remove plugin activation errors
* In katb_custom_style.php wrapped in conditional if ( function_exists ('katb_get_options')){} because it was causing a php fatal error on reactivation of plugin

= 4.1.3 =
* Fixed katb_insert_content, did not pass $use_schema variable
* Added isset conditional to $_SESSION['katb_form_submitted']
* Removed hatom because it was causing problems with theme specific css
* Modified css for meta in widgets and content
* Fixed css styling for popup
* simplified header styling for content area

= 4.1.2 =
* fixed drop down rating for input forms
* changed one of the screenshots
* Fixed theme specific formats for .post author class by adding .katb class and style

= 4.1.1 =
* minor update to re-upload and delete old css files

= 4.1.0 =
* Fixed database issues by upgrading everyone to database 1.4
* Added backup/restore panel. Users can now backup their testimonials to an xml file and restore them later
* Added Side Meta layout option in content display
* Modified css for Top Meta and Bottom Meta layouts
* Fixed company div wrap to be inside conditional
* Modified ratings to show nothing if rating is 0
* Combined all custom styles to one file and load all styles regardless
* Added layout and schema overrides to shortcode and widgets
* Forced YYYY-MM-DD date format when using schema
* Moved katb_input_style div to wrap title and email note
* Modified css in edit panel so displayed testimonials reflect a better visual presentation
* Added 4 more layout options to widgets, image and meta top or bottom, and centered image and meta top or bottom
* Added round images
* Changed excerpt filtering to a word count based system
* Made many code and css improvements.
* Changed layout on the displayed testimonials in Edit Panel
* Changed Paypal button to donate

= 4.0.8 =
* Bug fix, modified height settings for slider in the content display 
  and in the widget display to prevent jerking of the display window.
* Added position: inherit; to Gravatar styles

= 4.0.7 =
* Bug fix, removed redirect from input widget
* Added isset conditional for custom email address

= 4.0.6 =
* User can now have more that one input form on a page 
* Improved error messaging by having either popup or on page, 
  and allowing the user to select either option for both content 
  and input widget forms.
* Added bulk delete to admin panel
* Fixed rateit.js warning
* Added optional widget input form labels above inputs
* Modified email note to make it optional in both the content and widget input forms
* Added widget required label
* Changed fadeIn on rotator from 'slow' to 2000ms
* Added option for user to select jQuery star rating system or css system
* Added option to select star color and star shadow color
* Removed farbtastc reference in doc ready script.
* Bug fix aggregate ratings will not be displayed if ratings are disabled.
* Bug fix, validation on website and location
* Removed group label option for widget as it was not being used
* Improved Edit Panel to prevent page reload double entry and to remove bulk deleted 
  testimonials from the display, done without page redirect
* Changed tb_url and tb_pic_url to 150 characters
* Added option to change captcha label
* Fixed cursor inside popup to be a pointer
* Modified katb_testimonial_basics_input_in_code() to include form number.

= 4.0.5 =
* forgot to include function to display the input form in code, was in another 
  working copy

= 4.0.4 =
* fixed bug where wpautop was adding line breaks to rating html causing it to break
* added function to display the input form in code

= 4.0.3 =
* added option to use javascript alert message that testimonial was submitted
* added German translation, Thankyou Frank!

= 4.0.2 =
* fixed bug for loading excerpt script when only the widget one is checked
* changed rotator and excerpt scripts to load in the footer
* modified slider jquery for IE9&10 compatibility and independant speed variables
* removed padding from katb_error
* updated katb_list_testimonials() , initialized critical arrays for
  repeated use
  
= 4.0.1 =
* bug fix - Testimonials were not being added to the database in Windows Servers
* improvement - Spanish Translation added
* bug fix - css in rateit.css, all widget testimonials were showing 5 stars

= 4.0 =
* bug fix - changed $pend-count to $total in katb_add_unapproved_count()
* bug fix - removed action="#" from input forms and pagination form

= 3.32.9 =
* bug fix - fixed custom font css for the widget and widget popup display
* improvement moved ... in excerpt to before close tags
* improvement - set metabox styling in popup
* bug fix - fixed popup to show title if use schema selected
* bug fix - syntax error in rating input html content form
* bug fix - fixed itallic setting for basic widget display
* bug fix - fixed custom formatting to include rotator divs in widget
* improvement - added option for auto approval

= 3.31.8 =
* bug fix - fixed the custom text color option on the widget display author strip
* bug fix - fixed the divide by zero error, when schema is selected and there are no ratings
* Testimonial aggregate display will not be shown (including meta) unless there are 2 or more ratings 
  and the average rating is greater than 0.
* bug fix, input forms were sometimes submitting nothing for rating
  solved by switching from select input box to HTML5 range input

= 3.30.7 =
* Added optional 5 star rating system
* Added optional schema mark up
* Improved edit testimonials view panel
* Changed Options panel to tabbed for better organization
* Set up photo upload button in admin Edit Testimonials panel
* Added minimum height option to slider
* Added option to use gravatar substitute
* Changed slide hover icon to a pause icon
* Updated slider options to include fade, slide-left, and slide-right, and time
* Added font size option for input forms and display
* bug fix, formatting in the widget popup was not working for paragraphs.
* bug fix, excerpt filter was not leaving &lt;br /&gt; in, and when I put it in I had to fix the open &lt;br problem
* Fixed testimonials with no html. Line feeds were not being carried through to display. Did this by adding wpautop() to text elements.
* Changed color captcha art
* Added photo url and rating to database
* Increased Group name to 100 characters
* Added bubble count for unapproved testimonials
* Added option to size gravatars
* Modified slider for inside wrapper rotation
* Added optional Title to displays
* Added meta location option to top or bottom
* Code optimization

= 3.20.6 =
* Optimized pagination code
* Made the website and location input optional
* Set up form label options for both the content input form and the 
  widget input form
* Added testimonial rotator and reduced testimonial display shortcodes to one
* Added testimonial rotator and reduced testimonial display widgets to one
* Added sections to options panel
* Removed <!-- katb_input_form --> filter.
* General bug Fixes and code clean-up

= 3.12.5 =
* no code changes 
* had problems with the svn

= 3.12.1 =
* added a color option for captcha
* added link tag to allowed html for user submissions
* updated html allowed on admin page to wp_kses_post, giving full access 
  to post html tags
* added strict image formatting
* added pagination to edit testimonials admin panel
* added pagination option for displaying all or grouped testimonials 
  by date or order
* changed date display format to the default selected in the 
  Settings => General Tab
* updated output data validation
* Minor bug fixes and code clean-up
* added Dutch translation
* modified code to allow gravatars in excerpt pop-ups
* testimonials in the admin edit panel are now displayed most 
  recent first

= 3.0.0 =
* added multiple testimonial widget
* added random shortcode for main area displays
* added excerpt for widgets, main area and function 
  testimonials displays
* added email for contact about submitted testimonials
* set up captcha text input to be fully selected on click
* changed coding of the main area input form to a shortcode 
  format to minimize potential plugin conflicts and duplicate 
  entry issues
* modified captcha coding letter selection, and variable names 
  to minimize potential conflicts
* added option to allow WordPress editor levels to edit testimonials
* html tags allowed p,br,i,em,strong,q,h1-h6
* html strip now displayed as an option
* Fixed \ problem in emails
* Corrected blogBox references in validate function
* Table encoding issue resolved with a table set up modification 
  for new installs and a blog post on updating existing tables.
* When using order to display testimonials they are now displayed 
  in ascending order.
* incorporated new color picker with fallback to color wheel for older 
  versions of WordPress

= 2.10.6 =
* fixed bug for uploading testimonials
* fixed bug for loading gravatar logo

= 2.8.4,2.8.5 =
* allowed paragraph and line break tags in in comments
* added default font to custom styling
* added option for italic style both in basic and in custom styling
* added groups so users can group testimonials and display them in 
  separate pages.
* added an option to use gravatars if present.
* modified Edit Testimonials Panel to accomodate Groups and e-mail
* removed user documentation from plugin, available at plugin site
* website link now opens a new tab
* optimized css styling
* fixed strip slashes bug in input title and e-mail note

= 2.0.0 =
* added user options for input forms
* added user options for content testimonial display
* added user options for widget testimonial display
* re-coded e-mail validation
* widget display box height adjusts to 12 em max
* increased captcha width
* fixed bugs in e-mail send
* fixed minor bug in activation function
* fixed undefined variable bug in display scripts
* fixed zero and one testimonial display bug
* fixed esc_url() php warning bug
* changed link to plugin page
* fixed type bug on widget testimonial display

= 1.0.7 =
* Initial Release

== Upgrade Notice ==

= 4.3.0 =
* This version is a major update
* The code and css styles have been essentially re-writen
* Please check all your input forms and display pages to ensure everything is working.

= 4.2.3 =
* This update fixes problems with saving testimonials in the database and sending email notifications
* Users that are using widgets for input forms should reset them by removing the old ones and installing the ones from this update

= 4.2.2 =
* not considered critical

= 4.2.1 =
* this update is not considered critical

= 4.2.0 =
* fixed critical error on esc_html function
* critical update

= 4.1.9 =
* important update

= 4.1.8 =
* important update

= 4.1.7 =
* critical update

= 4.1.6 =
* color picker stopped working after WordPress 4.2 upgrade, had to change the option class to ka_color because hexcolor was causing problems with the jQuery selector

= 4.1.5 =
* added height: auto; to avatar styles.
* Revamped schema for the new set up and tested every layout for the content and widgets with the structured data testing tool
* Modified the content display code separating the ratings display from within the title block to its own function and block
* Added some slight css changes to accommodate the content display changes
* Updated copyright to 2015

= 4.1.4 =
* medium critical update, but there should not be any adjustments 
  necessary after install

= 4.1.3 =
* medium critical update
* should fix broken css on certain installations

= 4.1.2 =
* minor update

= 4.1.0 & 4.1.1 =
* this is a major update
* all users double check your input form and display setups to 
  make sure changes are not required
* the excerpt filter has been improved, but was switched to a 
  word count system....check your excerpt settings
  
= 4.0.8 =
* minor bug fixes

= 4.0.7 =
* minor bug fixes

= 4.0.6 =
* this is a major update
* all users double check your input form and display setups to 
  make sure changes are not required 

= 4.0.5 =
* only critival to those using the input form in code function

= 4.0.4 =
* non critical

= 4.0.3 =
* non critical

= 4.0.2 =
* should provide better compatibility with IE

= 4.0.1 =
* please update

= 4.0 =
* This update fixes a couple of minor bugs

= 3.32.9 =
* This is an intermediate upgrade, non-critical

= 3.31.8 =
* This is an intermediate upgrade with three bug fixes and one improvement

= 3.30.7 =
* This is a major upgrade, check your site after the upgrade as you may have to reset your widgets

= 3.20.6 =
* Testimonials are now displayed in the main content area with a 
  single shortcode. You will likely have to make adjustments to 
  your shortcode.
* A single widget is now used to display testimonials in widgetized 
  areas. You will likely have to reset your widgets.
* the <!-- katb_input_form --> tags for the input form are no longer 
  allowed use [katb_input_testimonials] instead

= 2.10.6 =
* gravatar logo was not loading properly
* Testimonial was not updating in the database for Windows 
  server setups
* These two issues should now be fixed
* Thanks for the feed back, it lets me fix the problems.

= 2.8.4, 2.8.5 = Release
* please ensure your database is backed up before you upgrade
* your database will be updated adding a Group column and a 
  E-mail column
* there should be no problem with the database but back-up to 
  be safe
* advanced function in code users must adjust the parameters 
  in the function call
* detailed documentation must now be obtained from the 
  plugin site

= 2.0.0 = Release
* when you install this update you will start with the basic 
  display format
* go to the new options panel to get the formatted display back
* this is a major upgrade to the initial version
* a number of bugs were fixed
* a complete new options section has been added

= 1.0.7 =
* Initial Release