<?php
/*
Plugin Name: Google Map with FancyBox Popup
Plugin URI: http://www.gopiplus.com/work/2014/04/26/google-map-with-fancybox-popup-wordpress-plugin/
Description: Google Map With FancyBox Popup plugin allows you to add a Google Map into popup window. This is a great plugin to display your business location in a Google map or, just your personal address in Google Map.
Version: 1.6
Author: Gopi Ramasamy
Donate link: http://www.gopiplus.com/work/2014/04/26/google-map-with-fancybox-popup-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2014/04/26/google-map-with-fancybox-popup-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: google-map-with-fancybox-popup
Domain Path: /languages
*/

/*  
Copyright 2016  Google Map with FancyBox Popup (www.gopiplus.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'gmwfb-stater.php');
add_action('admin_menu', array( 'gmwfb_registerhook', 'gmwfb_adminmenu' ));
register_activation_hook(GMWFB_FILE, array( 'gmwfb_registerhook', 'gmwfb_activation' ));
register_deactivation_hook(GMWFB_FILE, array( 'gmwfb_registerhook', 'gmwfb_deactivation' ));
add_action( 'widgets_init', array( 'gmwfb_registerhook', 'gmwfb_widget_loading' ));
add_shortcode( 'google-map-fb-popup', 'gmwfb_shortcode' );
add_action('wp_enqueue_scripts', 'gmwfb_add_javascript_files');
add_action('admin_head', 'gmwfb_js_admin_head');

function gmwfb_textdomain() 
{
	  load_plugin_textdomain( 'google-map-with-fancybox-popup' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'gmwfb_textdomain');
?>