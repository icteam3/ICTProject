<?php
/**
 * PlumTree functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 */

/*------- Plumtree Setup & Init ----------*/

// ----- Setting width
if ( ! isset( $content_width ) )
	$content_width = 980;

if (!defined(__DIR__)) define ('__DIR__', dirname(__FILE__));


// ----- Setting 
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'shortcode-thumb', 520, 9999 );
    add_image_size( 'shortcode-thumb-short', 330, 330, true );
    add_image_size( 'grid-thumb', 350, 9999 );
	add_image_size( 'related-post-thumb', 520, 9999);
	add_image_size( 'woocommerce-widget-thumb', 520, 9999);
	add_image_size( 'cart-thumb', 70, 75, true);
	add_image_size( 'pt-portfolio-thumb', 720, 520, true);
	add_image_size( 'pt-gallery-thumb', 720, 9999);
}


// ----- Theme supports
function plumtree_setup() {

	load_theme_textdomain( 'plumtree', get_template_directory() . '/languages/' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'woocommerce' );

	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status', 'gallery', 'video', 'audio', 'chat' ) );

	register_nav_menu( 'primary-aside', __( 'Primary Menu (Aside Logo)', 'plumtree' ) );
	
	register_nav_menu( 'mobile', __( 'Mobile Menu', 'plumtree' ) );

	register_nav_menu( 'footer-navigation', __( 'Footer Menu', 'plumtree' ) );

	add_theme_support( 'custom-background', array(
		'default-color' => '000000',
	) );

	add_theme_support( 'post-thumbnails' );
	
	set_post_thumbnail_size( 9999, 9999 ); // Unlimited height & width, soft crop

	$pt_layouts = array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png'),
	);
	
	add_theme_support( 'plumtree-layouts', apply_filters( 'pt_default_layouts', $pt_layouts) ); 

	/* Disable sidebar widgets when layout is one column. */
	//add_filter( 'sidebars_widgets', 'pt_disable_sidebars' );
}

add_action( 'after_setup_theme', 'plumtree_setup' );

// ----- Adding scripts and styles
function plumtree_scripts_styles() {
	global $wp_styles;
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core', array('jquery'));
	wp_enqueue_script('jquery-ui-accordion', array('jquery'));
	wp_enqueue_script('jquery-ui-widget', array('jquery'));
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
	//----Load jQuery Easings----------
	wp_enqueue_script( 'plumtree-easings', get_template_directory_uri() . '/js/jquery.easing.js', array('jquery'), '1.3.0');	
	
	//----Load Bootsrap JS-------------
	wp_enqueue_script( 'plumtree-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.0');	
	wp_enqueue_script( 'plumtree-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0');

    //----Enqurie ---------------------
    wp_enqueue_script( 'enquire', get_template_directory_uri() . '/js/enquire.min.js', array('jquery'), '1.2' );

    //----Load Waypoints---------------
	wp_enqueue_script('plumtree-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'));
	wp_enqueue_script('plumtree-waypoints-sticky', get_template_directory_uri() . '/js/waypoints-sticky.min.js', array('jquery'));
	
	wp_enqueue_script('plumtree-img', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js');
		
	//----Load Hover Intent Plugin----------------
	wp_enqueue_script( 'plumtree-hoverintent', get_template_directory_uri() . '/js/hoverIntent.js', array('jquery'), '1.0');

    //----Load Validate Plugin----------------
    wp_enqueue_script( 'plumtree-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), '1.0');

	//----Load Theme JS Helper---------------------
	wp_enqueue_script( 'plumtree-helper', get_template_directory_uri() . '/js/helper.js', array('jquery'), '1.0', true);
	
	//----Shop Tooltips---------------------
	wp_enqueue_script( 'plumtree-shop-tooltips', get_template_directory_uri() . '/js/shop-tooltips.js', array('jquery'), '1.0', true);

	//----WooCommerce Checkout with form styler fix-----------
	//wp_enqueue_script('checkout-fix', get_template_directory_uri().'/js/country-select.js', array('jquery'), '1.0', true);
	

	//----Load CSS--------------------------------
	wp_enqueue_style( 'plumtree-bootstrap', get_template_directory_uri(). '/css/bootstrap.min.css' );
	wp_enqueue_style( 'plumtree-bootstrap-r', get_template_directory_uri(). '/css/bootstrap.r.min.css' );
	//wp_enqueue_style( 'plumtree-bootstrap-responsive', get_template_directory_uri(). '/css/bootstrap-responsive.min.css' );
	wp_enqueue_style( 'plumtree-awesome-fonts', get_template_directory_uri(). '/css/font-awesome.min.css' );
	wp_enqueue_style( 'plumtree-reset', get_template_directory_uri().'/css/reset.css' );
	//wp_enqueue_style( 'plumtree-layout', get_template_directory_uri().'/css/layout.css' );
	wp_enqueue_style( 'plumtree-animation', get_template_directory_uri().'/css/animation.css' );
	wp_enqueue_style( 'plumtree-specials', get_template_directory_uri().'/css/specials.css' );
	wp_enqueue_style( 'plumtree-basic', get_stylesheet_uri() );
	
	//---- Theme fonts -----------------------------------
	wp_enqueue_style( 'ptpanel-fonts', get_template_directory_uri().'/css/fonts.css' );


	//---- Theme Patterns -------------------------------
	wp_enqueue_style( 'plumtree-ie', get_template_directory_uri() . '/css/ie.css', array( 'plumtree-style' ), '20121010' );
	$wp_styles->add_data( 'plumtree-ie', 'conditional', 'lt IE 9' );



}

add_action( 'wp_enqueue_scripts', 'plumtree_scripts_styles' );


// ----- Plumtree Init Sidebars
function plumtree_widgets_init() {

	// Default Sidebars
	register_sidebar( array(
		'name' => __( 'Blog Sidebar', 'plumtree' ),
		'id' => 'sidebar-blog',
		'description' => __( 'Appears on single blog posts and on Blog Page', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Front Page Sidebar', 'plumtree' ),
		'id' => 'sidebar-front',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Pages Sidebar', 'plumtree' ),
		'id' => 'sidebar-pages',
		'description' => __( 'Appears on Pages', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Shop Page Sidebar', 'plumtree' ),
		'id' => 'sidebar-shop',
		'description' => __( 'Appears on Products page', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Single Product Page Sidebar', 'plumtree' ),
		'id' => 'sidebar-product',
		'description' => __( 'Appears on Single Products page', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


	
	register_sidebar( array(
		'name' => __( 'Header (Logo group) sidebar', 'plumtree' ),
		'id' => 'hgroup-sidebar',
		'description' => __( 'Located to the right from header', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="heading">',
		'after_title' => '</div>',
	) );
	


	// Custom Sidebars
	register_sidebar( array(
		'name' => __( 'Front Page Widget section', 'plumtree' ),
		'id' => 'front-page-widgets',
		'description' => __( 'Front Page Widget Area located at the bottom of site before footer', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s span3">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	/*register_sidebar( array(
		'name' => __( 'Top Store Page Widget section', 'plumtree' ),
		'id' => 'top-store-page-widgets',
		'description' => __( 'Store Page Widget Area located at the top of site before main content', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s span3">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );*/

	register_sidebar( array(
		'name' => __( 'Product Cart Widget section', 'plumtree' ),
		'id' => 'cart-widgets',
		'description' => __( 'Product Cart Widget Area located at the right side of cart contents', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Mobile Widget section', 'plumtree' ),
		'id' => 'mobile-sidebar',
		'description' => __( 'Widget Area located right to mobile menu on portable devices', 'plumtree' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s ">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="heading">',
		'after_title' => '</h3>',
	) );


    // Footer Sidebars
    register_sidebar( array(
        'name' => __( 'Footer Sidebar Col#1', 'plumtree' ),
        'id' => 'footer-sidebar-1',
        'description' => __( 'Located in the footer of the site', 'plumtree' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Sidebar Col#2', 'plumtree' ),
        'id' => 'footer-sidebar-2',
        'description' => __( 'Located in the footer of the site', 'plumtree' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Sidebar Col#3', 'plumtree' ),
        'id' => 'footer-sidebar-3',
        'description' => __( 'Located in the footer of the site', 'plumtree' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Sidebar Col#4', 'plumtree' ),
        'id' => 'footer-sidebar-4',
        'description' => __( 'Located in the footer of the site', 'plumtree' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

	
}
add_action( 'widgets_init', 'plumtree_widgets_init' );


/* Lanquage Settings for shop tooltips */
add_action( 'wp_footer', 'pt_shop_tooltips');

function pt_shop_tooltips() {
?>
<script type="text/javascript">

	msg_cart = '<?php _e('Add to Cart', 'plumtree') ?>';
	msg_details = '<?php _e('View Details', 'plumtree') ?>';
	msg_compare = '<?php _e('Compare', 'plumtree') ?>';
	msg_added = '<?php _e('Added', 'plumtree') ?>';
	msg_wish = '<?php _e('Add to wishlist', 'plumtree') ?>';
	msg_wish_details = '<?php _e('View wishlist', 'plumtree') ?>';

</script>
<?php
}



/*------- Including requiered libraries, admin panel ----------*/ 
require_once('inc/pt-menuwalker.php');
require_once('inc/pt-lib.php');
require_once('ptpanel/ptpanel.php');
require_once('inc/pt-admin.php');

/*-----Including widgets, special functions--------*/
require_once('widgets/class-pt-widget-contacts.php');
require_once('widgets/class-pt-widget-socials.php');
require_once('widgets/class-pt-widget-search.php');
require_once('widgets/class-pt-widget-most-viewed-posts.php');
require_once('widgets/class-pt-widget-recent-posts.php');
require_once('widgets/class-pt-widget-pay-icons.php');
require_once('inc/pt-theme-layouts.php');
require_once('inc/pt-contacts.php');
require_once('inc/pt-get-more.php');
require_once('inc/pt-posts-shortcode.php');
require_once('inc/pt-functions.php');
require_once('inc/pt-woo-modification.php');

if (class_exists('Woocommerce')) {
	require_once('widgets/class-pt-widget-cart.php');
	require_once('widgets/class-pt-widget-shop-filters.php');
}

/*-----Including addons--------*/
require_once('extensions/formstyler/formstyler.php');
require_once('extensions/iosslider/iosslider.php');
require_once('extensions/isotope/isotope.php');
require_once('extensions/magnific/magnific.php');
require_once('extensions/gmaps/gmaps.php');
require_once('extensions/resmenu/resmenu.php');
require_once('extensions/superfish/superfish.php');
require_once('extensions/tooltipster/tooltipster.php');
require_once('extensions/totop/totop.php');
require_once('extensions/mosaic/mosaic.php');
require_once('extensions/stellar/stellar.php');

/*---------Content Builder-----------*/

if (!defined('BOOTSTRAP_VERSION'))
	define('BOOTSTRAP_VERSION', '2');

if (class_exists('IG_Pb_Init')) {
    require_once('shortcodes/add_to_contentbuilder.php');
}

/*---------Content Builder End-----------*/

require_once('inc/pt-self-install.php');

function remove_protected_text($text){
	$text='%s';
	return $text;
}
add_filter('protected_title_format','remove_protected_text');

function woo_custom_class_for_categories_in_loop( $classes ){
    $classes[] = 'isotope-item';
  	return $classes;
}
add_filter( 'product_cat_class', 'woo_custom_class_for_categories_in_loop' );
















