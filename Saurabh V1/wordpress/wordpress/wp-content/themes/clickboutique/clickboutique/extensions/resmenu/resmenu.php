<?php 

class PT_Resmenu{
	
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
		wp_enqueue_style( 'resmenu-component', get_template_directory_uri() .'/extensions/resmenu/css/component.css', array(), '1.0');
		wp_enqueue_script( 'modernizer', get_template_directory_uri() .'/extensions/resmenu/js/modernizr.custom.js', 'jquery', true );
		wp_enqueue_script( 'resmenu', get_template_directory_uri() .'/extensions/resmenu/js/jquery.dlmenu.js', 'jquery', true );
	}
	
}

$pt_resmenu = PT_Resmenu::getInstance();