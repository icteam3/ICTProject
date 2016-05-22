<?php

class PT_Superfish{
	
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
		add_action( 'wp_enqueue_scripts', array(&$this, 'print_scripts_styles'));		
	}
	
	function print_scripts_styles(){
		wp_enqueue_script( 'superfish', get_template_directory_uri() .'/extensions/superfish/js/superfish.js', array('jquery'), '1.7.4', true);
		wp_enqueue_script( 'superfish-helper', get_template_directory_uri() .'/extensions/superfish/js/helper.js', array('jquery'), '1.0', true);
		wp_enqueue_style( 'superfish', get_template_directory_uri() .'/extensions/superfish/css/superfish.css', true);
	}
	
}

$pt_superfish = PT_Superfish::getInstance();