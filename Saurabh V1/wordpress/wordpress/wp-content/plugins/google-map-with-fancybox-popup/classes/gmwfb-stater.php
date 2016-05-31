<?php
$iframepop_plugin_name = 'google-map-with-fancybox-popup';
$iframepop_current_folder = dirname(dirname(__FILE__));
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('GMWFB_TDOMAIN')) define('GMWFB_TDOMAIN', $iframepop_plugin_name);
if(!defined('GMWFB_PLUGIN_NAME')) define('GMWFB_PLUGIN_NAME', $iframepop_plugin_name);
if(!defined('GMWFB_PLUGIN_DISPLAY')) define('GMWFB_PLUGIN_DISPLAY', "Google Map With FancyBox");
if(!defined('GMWFB_DIR')) define('GMWFB_DIR', $iframepop_current_folder.DS);
if(!defined('GMWFB_URL')) define('GMWFB_URL',plugins_url().'/'.strtolower('google-map-with-fancybox-popup').'/');
define('GMWFB_FILE',GMWFB_DIR.'google-map-with-fancybox-popup.php');
if(!defined('GMWFB_FAV')) define('GMWFB_FAV', 'http://www.gopiplus.com/work/2014/04/26/google-map-with-fancybox-popup-wordpress-plugin/');
define('GMWFB_OFFICIAL', 'Check official website for more information <a target="_blank" href="'.GMWFB_FAV.'">click here</a>');
if(!defined('GMWFB_ADMINURL')) define('GMWFB_ADMINURL', get_option('siteurl') . '/wp-admin/options-general.php?page=google-map-with-fancybox-popup');
require_once(GMWFB_DIR.'classes'.DIRECTORY_SEPARATOR.'gmwfb-register.php');
require_once(GMWFB_DIR.'classes'.DIRECTORY_SEPARATOR.'gmwfb-intermediate.php');
require_once(GMWFB_DIR.'classes'.DIRECTORY_SEPARATOR.'gmwfb-loadmap.php');
require_once(GMWFB_DIR.'classes'.DIRECTORY_SEPARATOR.'gmwfb-query.php');
?>