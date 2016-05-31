<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function h5ab_custom_styling_site() {

    $allowedHTML = wp_kses_allowed_html( 'post' );

    $wholeSiteExternal = ( isset ( $_POST['h5ab-whole-site-custom-external'] ) ) ? $_POST['h5ab-whole-site-custom-external'] : null;
    $wholeSiteExternal = str_replace("'",'"',$wholeSiteExternal);

    $wholeSiteStyling = ( isset ( $_POST['h5ab-whole-site-custom-styling'] ) ) ? $_POST['h5ab-whole-site-custom-styling'] : null;

    $wholeSiteExternalKSES = wp_kses(stripslashes($wholeSiteExternal), H5AB_Custom_Styling::$h5ab_custom_styling_kses);
    $wholeSiteStylingKSES = wp_kses(stripslashes($wholeSiteStyling), $allowedHTML);

    $h5abCustomCSSTheme = ( isset ( $_POST['h5ab-css-custom-theme'] ) ) ? trim(strip_tags($_POST['h5ab-css-custom-theme'])) : null;

    $updatedExternal = update_option( 'h5abCustomExternal', $wholeSiteExternalKSES);
	$updatedStyling = update_option( 'h5abCustomStyling', $wholeSiteStylingKSES);

    $h5abCustomCSSTheme = sanitize_text_field($h5abCustomCSSTheme);
    $updatedTheme = update_option('h5abCustomStylingTheme', $h5abCustomCSSTheme);

    $success = (($updatedExternal || $updatedStyling || $updatedTheme) || ($updatedExternal && $updatedTheme) || ($updatedTheme && $updatedStyling) || ($updatedExternal && $updatedStyling && $updatedTheme)) ? true : false;
    $message= ($success) ? 'Settings successfully saved' : 'Settings could not be saved';

    $response = array('success' => $success, 'message' => esc_attr($message));

    return $response;

}

?>
