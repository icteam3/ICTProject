<?php

class PT_Iosslider{

	private static $instance;
	
	private function __construct(){
		$this->init();
	}
	
	static function getInstance(){
	
		if (self::$instance == null) { 
			self::$instance = new self();
		} 
	
		return self::$instance;
	
	}
	
	function init(){
		add_action('wp_enqueue_scripts', array(&$this, 'print_scripts_styles'));
		add_shortcode( 'slider', array(&$this, 'slider_short') );
		add_shortcode( 'slideritem', array(&$this, 'item_short') );	
	}
	
	function print_scripts_styles(){
		wp_enqueue_script('iosslider', get_template_directory_uri() .'/extensions/iosslider/js/jquery.iosslider.min.js', array('jquery'), '1.2.25', true);
		wp_enqueue_script('iosslider-helper', get_template_directory_uri() .'/extensions/iosslider/js/helper.js', array('jquery'), '1.0', true);
		wp_enqueue_style('iosslider', get_template_directory_uri() .'/extensions/iosslider/css/styles.css');
	}
	
	function slider_short($atts, $content=""){
		
		extract(shortcode_atts( array(
			'mode' => 'horizontal'
 		), $atts ) );
		
		$html = '';
		
		if (empty($content)) return null;
		
		$html .= '<div data-slider="ios">';
		$html .= do_shortcode($content);
		$html .= '</div>';
		
		return $html;
		
	}
	
	function item_short($atts, $content=""){
		extract(shortcode_atts( array(
			'mode' => 'horizontal'
 		), $atts ) );
 		
 		$html = '';
 		
 		$html .= '<div data-item="ios">';
 		$html .= do_shortcode($content);
 		$html .= '</div>';
 		
 		return $html;
	}
	
}

$pt_iosslider = PT_Iosslider::getInstance();
