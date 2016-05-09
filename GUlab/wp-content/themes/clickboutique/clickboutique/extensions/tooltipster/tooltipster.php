<?php 

class PT_Tooltipster{
	
	private static $instance;
	
	private function __construct(){
		$this->init();
	}
	
	public static function getInstance(){
		
		if(self::$instance == null) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	public function init(){
		add_action( 'wp_enqueue_scripts', array(&$this, 'print_scripts_styles'));
		add_action( 'wp_footer', array(&$this, 'tooltipster_init'));			
	}
	
	public function print_scripts_styles(){
		wp_enqueue_style( 'tooltipster', get_template_directory_uri() .'/extensions/tooltipster/css/tooltipster.css');
		wp_enqueue_style( 'tooltipster-themes', get_template_directory_uri() .'/extensions/tooltipster/css/themes/tooltipster-punk.css');
		wp_enqueue_script( 'tooltipster', get_template_directory_uri() .'/extensions/tooltipster/js/jquery.tooltipster.min.js', array('jquery'), '1.0', true);
	}
	
	public function tooltipster_init(){
		echo '<script>
		jQuery(document).ready(function() {
            jQuery(\'.tooltipster\').tooltipster({
            	animation: \'fall\',
            	 theme: \'.tooltipster-punk\'
            });
        });
		</script>';
	}
	
	
}

$pt_tooltips = PT_Tooltipster::getInstance();