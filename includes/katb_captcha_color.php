<?php
/**
 * This file is called when users selects to use the color captcha.
 *
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (C) 2016 Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
?>
<?php
	//Start session if not already started
	if(!isset($_SESSION)) session_start();
	
	// Set some important CAPTCHA constants
	$number_characters = 5; // number of characters in pass-phrase
	$captcha_width = 120; // width of image
	$captcha_height = 24; // height of image
  
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
		$letter_img = imagecreatefrompng('captcha_images/'.$characters[$position].'.png');
		imagecopy($katb_img,$letter_img,$xpos,$ypos,0,0,24,24);
		$xpos = $xpos + 24;
	}
  
	// Store the encrypted pass-phrase in a session variable
	$_SESSION['katb_pass_phrase'] = SHA1($pass_phrase);

	// Output the image as a PNG using a header  
	header("Content-type: image/png");  
	imagepng($katb_img);
	//echo imagepng($katb_img);

	// Clean up
	imagedestroy($letter_img);
	imagedestroy($katb_img);