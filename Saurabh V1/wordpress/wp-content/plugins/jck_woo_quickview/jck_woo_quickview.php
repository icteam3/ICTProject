<?php
/*
Plugin Name: WooCommerce Quickview
Plugin URI: http://www.jckemp.com
Description: Quickview plugin for WooCommerce
Version: 3.1.0
Author: James Kemp
Author Email: support@jckemp.com  
*/

class jckqv {

/* =============================
    // !Constants 
    ============================= */    

    public $name = 'WooCommerce Quickview';
    public $shortname = 'Quickview';
    public $slug = 'jckqv';
    public $version = "3.1.0";
    public $plugin_path;
    public $plugin_url;
    public $settings;
    public $woo_version;
    
/*  =============================
    // !Constructor 
    ============================= */
       
    public function __construct() {
        
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url = plugin_dir_url( __FILE__ );
        $this->woo_version = $this->get_woo_version_number();
        
        // register an activation hook for the plugin
        register_activation_hook( __FILE__, array( &$this, 'install' ) );

        // Hook up to the init action
        add_action( 'init', array( &$this, 'before_initiate' ), 0 );
        add_action( 'init', array( &$this, 'initiate' ) );
    }
  
/*  =============================
    // !Runs when the plugin is activated 
    ============================= */  
       
    public function install() {
        // do not generate any output here
    }
  
/*  =============================
    // !Runs when the plugin is initialized 
    ============================= */
       
       public function before_initiate(){
       add_filter('wcml_multi_currency_is_ajax',array($this,'add_ajax_action'));
    }
       
    public function initiate() {
        // Setup localization
        load_plugin_textdomain( $this->slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
        
    /*  =============================
        // !Framework 
        ============================= */
           
        require_once( $this->plugin_path .'/assets/options/jck-settings-framework/jck-settings-framework.php' );
        $this->settings = new JckSettingsFramework( $this->plugin_path .'/assets/options/jckqv_settings.php', 'woocommerce_page_'.$this->slug );
        
        add_filter( 'jckqvsettings_settings_validate', array( &$this, 'sanitize_settings' ), 10, 1 );
        
    /*  =============================
        // !Trigger Functions on Init 
        ============================= */
           
        $this->register_scripts_and_styles();
    
        if ( is_admin() ) {
            //this will run when in the WordPress admin
        } else {
            //this will run when on the frontend
        }

    /*  =============================
        // !Actions and Filters 
        ============================= */
           
        $theSettings = $this->settings->__getSettings();
           
        // !Admin Actions
        add_action( 'admin_menu', array( &$this, 'admin_page' ) );  
           
        // !Frontend Actions
         
        /* Show Button */
        if($theSettings['trigger_position_autoinsert'] == 1){
            if($theSettings['trigger_position_position'] == 'beforeitem'){
                add_action( 'woocommerce_before_shop_loop_item', array( &$this, 'displayBtn' ) );
            } elseif($theSettings['trigger_position_position'] == 'beforetitle') {
                add_action( 'woocommerce_before_shop_loop_item_title', array( &$this, 'displayBtn' ) );
            } elseif($theSettings['trigger_position_position'] == 'aftertitle') {
                add_action( 'woocommerce_after_shop_loop_item_title', array( &$this, 'displayBtn' ) );
            } elseif($theSettings['trigger_position_position'] == 'afteritem') {
                add_action( 'woocommerce_after_shop_loop_item', array( &$this, 'displayBtn' ) );
            }
        }
           
        /* Ajax */
        add_action( 'wp_ajax_jckqv', array( &$this, 'quickviewModal' ) );
        add_action( 'wp_ajax_nopriv_jckqv', array( &$this, 'quickviewModal' ) );
        add_action( 'wp_ajax_jckqv_add_to_cart', array( &$this, 'addToCart' ) );
        add_action( 'wp_ajax_nopriv_jckqv_add_to_cart', array( &$this, 'addToCart' ) );

    }
    
/** =============================
    *
    * Add Ajax Action
    *
    * Adds 'jckqv' and 'jckqv_add_to_cart' actions in 'wcml_multi_currency_is_ajax' 
    * to apply multi-currency filters (to convert prices to current currency)
    *
    * @param array $actions
    * @return array
    *
    ============================= */

    public function add_ajax_action($actions)
    {
        $actions[] = 'jckqv';
        $actions[] = 'jckqv_add_to_cart';
        return $actions;
    }
    
    function sanitize_settings($settings){

        // Validate Margins
        $i = 0; foreach($settings['trigger_position_margins'] as $marVal){
            $settings['trigger_position_margins'][$i] = ($marVal != "") ? preg_replace('/[^\d-]+/', '', $marVal) : 0;
        $i++; }
        
        return $settings;
    }

/*  =============================
    // !Action and Filter Functions
    ============================= */
       
    /* === Admin Function ===  */
       
    // !Admin Page

    public function admin_page() {
        add_submenu_page( 'woocommerce', $this->name, $this->shortname, 'manage_options', $this->slug, array( &$this, 'admin_page_options' ) );
    }
    
    public function admin_page_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.', $this->slug ) );
        }
        
        settings_errors();
        
        echo '<div class="wrap">';
            $this->settings->displaySettings();
        echo '</div>';
    }

    /* === Frontend Function === */

    // !Display the Button

    public function displayBtn($prodId = false){
        global $post;
        $prodId = ($prodId) ? $prodId : $post->ID;
        
        $theSettings = $this->settings->__getSettings();
        
        if($prodId){
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $prodId ), 'medium' );
            echo '<span data-jckqvpid="'.$prodId.'" class="'.$this->slug.'Btn">'.($theSettings['trigger_styling_icon'] != 'none' ? '<i class="jckqv-icon-'.$theSettings['trigger_styling_icon'].'"></i>' : '').' '.$theSettings['trigger_styling_text'].'</span>';
        }
    }    
    
    //! Modal Contents
    
    public function quickviewModal(){
        check_ajax_referer( 'jckqv', 'nonce' );
        
        global $post, $product, $woocommerce;
        
        $post = get_post($_REQUEST['pid']); setup_postdata($post);
        $product = get_product( $_REQUEST['pid'] );
        
        $theSettings = $this->settings->__getSettings();
        
        echo '<div id="'.$this->slug.'" class="cf">';
            
            include($this->plugin_path.'/inc/qv-styles.php');        
            include($this->plugin_path.'/inc/qv-images.php');
            
            echo '<div id="'.$this->slug.'_summary">';
            
                if($theSettings['popup_content_showbanner']) include($this->plugin_path.'/inc/qv-sale-flash.php');            
                if($theSettings['popup_content_showtitle']) include($this->plugin_path.'/inc/qv-title.php');        
                if($theSettings['popup_content_showrating']) include($this->plugin_path.'/inc/qv-rating.php');        
                if($theSettings['popup_content_showprice']) include($this->plugin_path.'/inc/qv-price.php');
                if($theSettings['popup_content_showdesc'] != 'no') include($this->plugin_path.'/inc/qv-desc.php');
                if($theSettings['popup_content_showatc'] && $this->woo_version >= 2.1) include($this->plugin_path.'/inc/qv-add-to-cart.php');
                if($theSettings['popup_content_showatc'] && $this->woo_version < 2.1) include($this->plugin_path.'/inc/qv-add-to-cart-old.php');                    
                if($theSettings['popup_content_showmeta']) include($this->plugin_path.'/inc/qv-meta.php');
            
            echo '</div>';
            
            echo '<button title="Close (Esc)" type="button" class="mfp-close">×</button>';
            
            echo '<div id="addingToCart"><div><i class="jckqv-icon-cw animate-spin"></i> <span>'.__('Adding to Cart...', $this->slug).'</span></div></div>';
        echo '</div>';
        
        wp_reset_postdata();
        
        die;
    }
    
    /* === AJAX Functions === */
    
    public function addToCart(){
        check_ajax_referer( 'jckqv', 'nonce' );
            
        global $woocommerce;
    
        $varId = (isset($_GET['variation_id'])) ? $_GET['variation_id'] : ''; 
        $_GET['quantity'] = (isset($_GET['quantity'])) ? $_GET['quantity'] : 1;
        
        $variations = array();
        
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 10) == "attribute_") {
                  $variations[$key] = $value;          
            }
        }
        
        if(is_array($_GET['quantity']))
        {
            foreach($_GET['quantity'] as $prodId => $prodQty)
            {
                if($prodQty > 0)
                {
                    $atc = $woocommerce->cart->add_to_cart($prodId, $prodQty, $varId, $variations);
                    if($atc) { continue; } else { break; }    
                }
            }
        }
        else
        {
            $atc = $woocommerce->cart->add_to_cart($_GET['product_id'], $_GET['quantity'], $varId, $variations);
        }
            
        if($atc){
            $woocommerce->cart->maybe_set_cart_cookies();
            $wc_ajax = new WC_AJAX();        
            $wc_ajax->get_refreshed_fragments();
        }
        else
        {
            header('Content-Type: application/json');
            
            $soldIndv = get_post_meta($_GET['product_id'], '_sold_individually', true);
            
            if($soldIndv == "yes")
            {
                $response = array('result' => 'individual');
                $response['message'] = __('Sorry, that item can only be added once.', $this->slug);
            }
            else
            {
                $response = array('result' => 'fail');
                $response['message'] = __('Sorry, something went wrong. Please try again.', $this->slug);
            }
            
            $response['get'] = $_GET;
            
            echo json_encode($response);
        }
        
        die;
    }
  
/*  =============================
    // !Frontend Scripts and Styles 
    ============================= */
       
    public function register_scripts_and_styles() {
        
        $theSettings = $this->settings->__getSettings();
        
        if ( !is_admin() ) {
            
            wp_enqueue_script( 'jquery-ui-spinner' );
            
            $this->load_file( $this->slug . '-script', '/assets/frontend/js/jckqv-scripts.min.js', true );            
            $this->load_file( $this->slug . '-minstyles', '/assets/frontend/css/jckqv-styles.min.css' );
            
            $imgsizes = array();
            $imgsizes['catalog'] = get_option( 'shop_catalog_image_size' );
            $imgsizes['single'] = get_option( 'shop_single_image_size' );
            $imgsizes['thumbnail'] = get_option( 'shop_thumbnail_image_size' );
            
            $scriptVars = array( 
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( "jckqv" ),
                'settings' => $theSettings,
                'imgsizes' => $imgsizes,
                'url' => get_bloginfo('url'),
                'text' => array(
                    'added' => __('Added!', $this->slug),
                    'adding' => __('Adding to Cart...', $this->slug)
                )
            );
            
            wp_localize_script( $this->slug . '-script', $this->slug, $scriptVars );
            
            add_action( 'wp_head', array( $this, 'dynamic_css' ) );
            
        } // end if/else
    } // end register_scripts_and_styles

/**	=============================
    *
    * Dynamic CSS
    *
    ============================= */
    
    public function dynamic_css() {
        include($this->plugin_path.'/inc/qv-button-styles.php');
    }
    
/*  =============================
    Helper function for registering and enqueueing scripts and styles.
    @name:             The ID to register with WordPress
    @file_path:     The path to the actual file
    @is_script:        Optional argument for if the incoming file_path is a JavaScript source file.
    @deps:            Array of dependancies
    @inFooter:        Whther to load this script in the footer
    ============================= */
    
    private function load_file( $name, $file_path, $is_script = false, $deps = array('jquery'), $inFooter = true ) {

        $url = plugins_url($file_path, __FILE__);
        $file = plugin_dir_path(__FILE__) . $file_path;

        if( file_exists( $file ) ) {
            if( $is_script ) {
                wp_register_script( $name, $url, $deps, false, $inFooter ); //depends on jquery
                wp_enqueue_script( $name );
            } else {
                wp_register_style( $name, $url );
                wp_enqueue_style( $name );
            } // end if
        } // end if

    } // end load_file
    
    public function get_woo_version_number() {
        // If get_plugins() isn't available, require it
        if ( ! function_exists( 'get_plugins' ) )
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        
            // Create the plugins folder and file variables
        $plugin_folder = get_plugins( '/' . 'woocommerce' );
        $plugin_file = 'woocommerce.php';
        
        // If the plugin version number is set, return it 
        if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
            return $plugin_folder[$plugin_file]['Version'];
    
        } else {
        // Otherwise return null
            return NULL;
        }
    }
  
} // end class

$jckqv = new jckqv();