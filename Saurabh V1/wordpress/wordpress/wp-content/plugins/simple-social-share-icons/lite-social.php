<?php 
/*
Plugin Name: Lite Social Buttons
Plugin URI: http://pressupinc.com/plugins/lite-social-buttons/
Description: Simple font-based social sharing buttons
Author: Press Up
Version: 0.5
Author URI: http://pressupinc.com/
*/

include ('lite-social-buttons.class.php');

function pusoc_add_post_content() {
	if (!is_feed() && !is_home()) {
		$my_buttons = new LiteSocialButtons;
		$out = $my_buttons->getAll();
	}
	echo $out;
}


function pusoc_styles()  
{ 
  // Register the style like this for a theme:  
  // (First the unique name for the style (custom-style) then the src, 
  // then dependencies and ver no. and media type)
  wp_register_style( 'pusoc-style', plugins_url('style.css', __FILE__ ) );
  // enqueing:
  wp_enqueue_style( 'pusoc-style' );
}
add_action('wp_enqueue_scripts', 'pusoc_styles');
