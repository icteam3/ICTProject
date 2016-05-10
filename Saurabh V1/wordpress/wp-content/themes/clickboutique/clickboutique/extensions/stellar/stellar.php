<?php

class PT_Stellar{
	
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
	
	private function init(){
		add_action( 'wp_enqueue_scripts', array(&$this, 'print_scripts_styles'));
	}
	
	function print_scripts_styles(){
		
		wp_enqueue_script( 'stellar', get_template_directory_uri() .'/extensions/stellar/js/jquery.stellar.min.js', array('jquery'), '1.5', true);
		wp_enqueue_script( 'stellar-init', get_template_directory_uri() .'/extensions/stellar/js/helper.js', array('jquery'), '1.0', true);
		//wp_enqueue_style( 'isotope', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/css/style.css' );
	
	}
	
		
		
}

$pt_stellar = PT_Stellar::getInstance();

