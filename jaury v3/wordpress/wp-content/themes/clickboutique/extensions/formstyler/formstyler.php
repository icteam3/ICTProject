<?php 

class PT_Formstyler{
	
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
		wp_enqueue_script( 'formstyler', get_template_directory_uri() .'/extensions/formstyler/js/jquery.formstyler.min.js', array('jquery'), true);
		wp_enqueue_script( 'formstyler-helper', get_template_directory_uri() .'/extensions/formstyler/js/helper.js', array('jquery'), '1.0', true);
		wp_enqueue_style( 'formstyler', get_template_directory_uri() .'/extensions/formstyler/css/jquery.formstyler.css', true);
	}	

}

$pt_formstyler = PT_Formstyler::getInstance();