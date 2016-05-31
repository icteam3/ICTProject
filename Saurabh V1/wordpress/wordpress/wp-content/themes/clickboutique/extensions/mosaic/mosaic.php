<?php 

class PT_Mosaic{
	
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
		wp_enqueue_script( 'mosaic-helper', get_template_directory_uri() .'/extensions/mosaic/js/helper.js', '1.0', array('jquery'), true );
		wp_enqueue_style( 'mosaic', get_template_directory_uri() .'/extensions/mosaic/css/styles.css' );
	}
	
}

$pt_mosaic = PT_Mosaic::getInstance();