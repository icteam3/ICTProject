<?php

/*-------Woocommerce modifications----------*/

if ( class_exists('Woocommerce') ) {

// ----- Adding Style
if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}

if ( ! function_exists( 'pt_woo_custom_style' ) ) {
	function pt_woo_custom_style() {
		wp_register_style( 'pt-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', null, 1.0, 'screen' );
		wp_enqueue_style( 'pt-woocommerce' ); 
	}
}
add_action( 'wp_enqueue_scripts', 'pt_woo_custom_style' );

add_action( 'init', 'pt_price_filter_init' );

function pt_price_filter_init() {
	if (function_exists('WC')) {	
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '';

			wp_register_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );

			wp_localize_script( 'wc-price-slider', 'woocommerce_price_slider_params', array(
				'currency_symbol' 	=> get_woocommerce_currency_symbol(),
				'currency_pos'      => get_option( 'woocommerce_currency_pos' ),
				'min_price'			=> isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '',
				'max_price'			=> isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : ''
			) );

			//add_filter( 'loop_shop_post_in', array( $this, 'price_filter' ) );
		}
}

//DISABLE WOOCOMMERCE PRETTY PHOTO SCRIPTS
function pt_deregister_javascript() {
	wp_deregister_script( 'prettyPhoto' );
	wp_deregister_script( 'prettyPhoto-init' );
}
add_action( 'wp_print_scripts', 'pt_deregister_javascript', 1000 );

//DISABLE WOOCOMMERCE PRETTY PHOTO
function pt_deregister_styles() {
	wp_deregister_style( 'woocommerce_prettyPhoto_css' );
}
add_action( 'wp_print_styles', 'pt_deregister_styles', 100 );


// ----- Product columns filter
if ( ! function_exists( 'pt_loop_shop_columns' ) ) {
	function pt_loop_shop_columns(){
		if ( 'layout-one-col' == pt_show_layout() ) return 4;
		else return 3;
	}
}
add_filter('loop_shop_columns', 'pt_loop_shop_columns');


// ----- Default catalof order
add_filter('woocommerce_default_catalog_orderby', 'custom_default_catalog_orderby');
 
function custom_default_catalog_orderby() {
	return 'date'; // Can also use title and price
}

// ----- Products per page filter
if ( ! function_exists( 'pt_show_products_per_page' ) ) {
	function pt_show_products_per_page() {
		$qty = (get_option('store_per_page') != '') ? get_option('store_per_page') : '6';
		return $qty;
	}
}
add_filter('loop_shop_per_page', 'pt_show_products_per_page', 20 );


// ----- Woocommerce Main content wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function pt_theme_wrapper_start() {
    echo '<div class="span12 site-content">';
}

function pt_theme_wrapper_end() {
    echo '</div>';
}

add_action('woocommerce_before_main_content', 'pt_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'pt_theme_wrapper_end', 10);


// ----- Woocommerce Adding top sidebar to product listing
function pt_top_store_sidebar() {    
    if ( is_active_sidebar( 'top-store-page-widgets' ) ) : ?>
        <div class="row-fluid top-store-page-widgets">
            <?php dynamic_sidebar( 'top-store-page-widgets' ); ?>
        </div>
    <?php endif;
}
add_action('woocommerce_before_main_content', 'pt_top_store_sidebar', 5);


// ----- Modifying shop output
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );






add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 20 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 30);

if (get_option('catalog_mode') !== 'on'){
	if ( get_option('add_to_cart_position') == 'grouped' ) {
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
	} else {
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}
}



if ( (get_option('store_breadcrumbs')) === 'on' ) {
	add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 3 );
}
if( ( class_exists('YITH_Woocompare_Frontend') ) && ( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ) ) {
	remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link'), 20 );
	add_action( 'woocommerce_before_shop_loop_item_title', array( $yith_woocompare->obj, 'add_compare_link'), 30  );
}
if ( ( class_exists( 'YITH_WCWL_Shortcode' ) ) && ( get_option('yith_wcwl_enabled') == true ) ) {
	function new_wishlist_label() { return ''; };
	// add_filter( 'yith-wcwl-browse-wishlist-label', 'new_wishlist_label' );
}

// Adding bootstrap wrapper
add_action( 'woocommerce_before_main_content', 'pt_woocommerce_wrap', 6 );
function pt_woocommerce_wrap() {
    echo '<div class="container-fluid"><div class="row-fluid">';
}

// ----- Adding list/grid view switcher
if ( ! function_exists( 'pt_view_switcher' ) ) {
	function pt_view_switcher() {
		$html = '<div class="pt-view-switcher"><span>'.__('View:', 'plumtree').'</span>';
		$html .='<span class="pt-grid active" title="'.__('Grid View', 'plumtree').'"><i class="fa fa-th-large"></i></span>';
		$html .='<span class="pt-list" title="'.__('List View', 'plumtree').'"><i class="fa fa-th-list"></i></span></div>';
		echo $html;
	}
}
if ( (get_option('list_grid_switcher')) === 'on' ) {
	add_action( 'woocommerce_before_shop_loop', 'pt_view_switcher', 25 );
}

// ----- Modifying Single products view output
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 40);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 11);
    if (get_option('catalog_mode') !== 'on')  add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);
add_action('woocommerce_after_single_product_summary', 'pt_product_meta_wrapper_start', 21);
add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 22);
add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_sharing', 23);
add_action('woocommerce_after_single_product_summary', 'pt_product_meta_wrapper_end', 29);
add_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 30);
add_action('woocommerce_after_single_product_summary', 'pt_output_related_products', 40);
// Adding wrapper to single product title
function pt_product_title_wrapper_start() {
    echo '<div class="product-title-wrap">';
} 

function pt_product_title_wrapper_end() {
    echo '</div>';
}

function pt_product_meta_wrapper_start() {
    echo '<div class="product-meta-wrap">';
}

function pt_product_meta_wrapper_end() {
    echo '</div>';
}

function pt_output_related_products() {

	if ( 'layout-one-col' == pt_show_layout() ) { $per_page = 4; $cols = 4; }
	else { $per_page = 3; $cols = 3; }

	$args = array(
		'posts_per_page' => $per_page,
		'columns' => $cols,
		'orderby' => 'rand'
	);

	woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}

add_action('woocommerce_single_product_summary', 'pt_product_title_wrapper_start', 4);
add_action('woocommerce_single_product_summary', 'pt_product_title_wrapper_end', 10);

add_action('woocommerce_share','pt_share_icons');
function pt_share_icons(){
	if ( function_exists( 'pusoc_add_post_content' ) ) { pusoc_add_post_content(); }
	else return false;
}

if (get_option('checkout_steps') === "on") {

	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
	add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 30 );
	add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_custom_output', 29 );

	function woocommerce_checkout_custom_output() {
		echo '<h3 class="pt-content-title">' . __( 'Checkout Progress', 'plumtree' ) . '</h3>';

		echo '<ul class="checkout-nav nav-tabs">
				<li class="active"><a href="#authorization" ><span>1</span>'.__("Login", "plumtree").'</a></li>
				<li><a href="#billing" ><span>2</span>'.__('Billing Address', 'plumtree').'</a></li>
				<li><a href="#shipping" ><span>3</span>'.__('Shipping Address', 'plumtree').'</a></li>
				<li><a href="#order_review" ><span>4</span>'.__('Order Review', 'plumtree').'</a></li>
			</ul>';
			
		echo '<div class="tab-content login-register">';

	}
}


// Hook in
add_filter( 'woocommerce_default_address_fields' , 'pt_default_address_fields' );

// Our hooked in function - $address_fields is passed via the filter!
function pt_default_address_fields( $fields ) {
    $fields = array(
		'first_name' => array(
			'label'    => __( 'First Name', 'plumtree' ),
			'required' => true,
			'class'    => array( 'form-row-first' ),
		),
		'last_name' => array(
			'label'    => __( 'Last Name', 'plumtree' ),
			'required' => true,
			'class'    => array( 'form-row-last' ),
			'clear'    => true
		),
		'company' => array(
			'label' => __( 'Company Name', 'plumtree' ),
			'class' => array( 'form-row-wide' ),
		),
		'address_1' => array(
			'label'       => __( 'Address', 'plumtree' ),
			'placeholder' => _x( 'Street address', 'placeholder', 'plumtree' ),
			'required'    => true,
			'class'       => array( 'form-row-first', 'address-field' )
		),
		'address_2' => array(
			'label'       => __( 'Additional address info', 'plumtree' ),
			'placeholder' => _x( 'Apartment, suite, unit etc. (optional)', 'placeholder', 'plumtree' ),
			'class'       => array( 'form-row-last', 'address-field' ),
			'required'    => false,
			'clear'    	  => true
		),
		'country' => array(
			'type'     => 'country',
			'label'    => __( 'Country', 'plumtree' ),
			'required' => true,
			'class'    => array( 'form-row-first', 'address-field', 'update_totals_on_change' ),
		),
		'city' => array(
			'label'       => __( 'Town / City', 'plumtree' ),
			'placeholder' => __( 'Town / City', 'plumtree' ),
			'required'    => true,
			'class'       => array( 'form-row-last', 'address-field' )
		),
		'state' => array(
			'type'        => 'state',
			'label'       => __( 'State / County', 'plumtree' ),
			'placeholder' => __( 'State / County', 'plumtree' ),
			'required'    => true,
			'class'       => array( 'form-row-first', 'address-field' ),
			'validate'    => array( 'state' )
		),
		'postcode' => array(
			'label'       => __( 'Postcode / Zip', 'plumtree' ),
			'placeholder' => __( 'Postcode / Zip', 'plumtree' ),
			'required'    => true,
			'class'       => array( 'form-row-last', 'address-field' ),
			'clear'       => true,
			'validate'    => array( 'postcode' )
		)
	);
	return $fields;
}


// ----- Up-sells modification
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
 
if ( ! function_exists( 'pt_output_upsells' ) ) {
	function pt_output_upsells() {

		if ( 'layout-one-col' == pt_show_layout() ) { $per_page = 4; $cols = 4; }
		else { $per_page = 3; $cols = 3; }

		woocommerce_upsell_display( $per_page, $cols ); // Display $per_page products in $cols 
	}
}
add_action('woocommerce_after_single_product_summary', 'pt_output_upsells', 35);



// ----- Cross-sells modification
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');


// ----- Tabs modification
if ( ! function_exists( 'pt_custom_product_tabs' ) ) {
	function pt_custom_product_tabs( $tabs ) {

		global $post, $product;

		$product_content = $post->post_content;

		if ($product_content && $product_content!=='') {
			$tabs['description']['priority'] = 10;
		} else {
			unset( $tabs['description'] );
		}
		
		if( $product->has_attributes() || $product->has_dimensions() || $product->has_weight() ) { 
			$tabs['additional_information']['title'] = __( 'Product Data', 'plumtree' );
			$tabs['additional_information']['priority'] = 20; 
		} else {
			unset( $tabs['additional_information'] );
		}
	 
		return $tabs;

	}
}
add_filter( 'woocommerce_product_tabs', 'pt_custom_product_tabs', 98 );


// ----- Modifying output of sale-flash
add_filter('woocommerce_sale_flash', 'pt_custom_sale_flash', 10, 3);

function pt_custom_sale_flash($text, $post, $_product) {
	return '<span class="onsale-bg"></span><span class="onsale">'. __( 'Sale!', 'plumtree' ) .'</span>';
}





// ----- Store Banner Function

	add_action('woocommerce_before_main_content', 'pt_store_banner', 1);
	if ( ! function_exists( 'pt_store_banner' ) ) {
		function pt_store_banner() {
			if ( is_shop() ) {

                if ( (get_option('store_banner')) === 'on' ) {

                    $img_url = (get_option('store_banner_img') != '') ? get_option('store_banner_img') : '';
                    $img_position = (get_option('store_banner_img_position') != '') ? get_option('store_banner_img_position') : 'right';
                    $img_position_p = ( $img_position == 'right' ?  '100%' : '0%' ) ;
                    $title = (get_option('store_banner_title') != '') ? get_option('store_banner_title') : '';
                    $description = (get_option('store_banner_description') != '') ? get_option('store_banner_description') : '';
                    $url = (get_option('store_banner_url') != '') ? get_option('store_banner_url') : '#';
                    $button_text = (get_option('store_banner_button_text') != '') ? get_option('store_banner_button_text') : 'Learn more';
                    $text_position = (get_option('store_banner_text_position') != '') ? get_option('store_banner_text_position') : 'left';
                    $custom_bg = (get_option('store_banner_custom_bg') != '') ? get_option('store_banner_custom_bg') : '';

                    if ( $custom_bg != '') {
                        $html = '<div class="store-banner"  style="background: url('.$custom_bg.') transparent;" data-stellar-background-ratio="0.3" data-stellar-vertical-offset="-200">';
                    } else { $html = '<div class="store-banner" data-stellar-background-ratio="0.3" data-stellar-vertical-offset="-200">'; }

                    $html .= '<div class="container-fluid store-banner-inner" style="background: url('.$img_url.')  no-repeat transparent; background-position-x: '.$img_position_p.'!important; text-align:'.$text_position.';" data-stellar-vertical-offset="-160"  data-stellar-background-ratio="0.5">';
                    $html .= '<div class="row-fluid"><div class="span12" >';
                    $html .= '<h3 class="banner-title">'.$title.'</h3>';
                    $html .= '<p class="banner-description">'.$description.'</p>';
                    $html .= '<a href="'.$url.'" class="banner-button" title="Click to view all special products" rel="bookmark">'.$button_text.'</a>';
                    $html .= '</div></div><div class="vertical-helper"></div></div></div>';
                    echo $html;


                } else {
                    if ( (get_option('blog_spacer_bg_color') != '') && (get_option('blog_spacer_bg_color') != '#fff') ) {
                        $spacer_bg = 'style="background:'.get_option('blog_spacer_bg_color').';"';
                    } elseif ( get_option('blog_spacer_custom_pattern') != '' ) {
                        $spacer_bg = 'style="background: url('.get_option('blog_spacer_custom_pattern').') repeat;"';
                    } else {
                        $spacer_bg = 'style="background: url('.get_template_directory_uri().'/assets/spacer-'.get_option('blog_spacer_default_pattern').'.png) repeat;"';
                    }
                    ?>
                    <div class="spacer" <?php echo $spacer_bg; ?> data-stellar-background-ratio="0.5">
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <h1 class="spacer-title" data-stellar-ratio="0.93"><?php _e('Shop', 'plumtree') ?></h1>
                            </div>
                        </div>
                    </div>
                    <?php
                }
			}
		}
    }



 
// ----- Changing 'add to cart' buttons text  
if ( ! function_exists( 'pt_add_to_cart_text' ) ) {                  
	function pt_add_to_cart_text() {
		$text = __('View details', 'plumtree');
		return '<i class="fa fa-search"></i><span>'.$text.'</span>';
	}
}
if ( ! function_exists( 'pt_add_to_cart_default_text' ) ) {    
	function pt_add_to_cart_default_text() {
		$text = __('Add to cart', 'plumtree');
		return '<i class="fa fa-shopping-cart"></i><span>'.$text.'</span>';
	}
}
add_filter( 'variable_add_to_cart_text', 'pt_add_to_cart_text' );
add_filter( 'grouped_add_to_cart_text', 'pt_add_to_cart_text' );
add_filter( 'external_add_to_cart_text', 'pt_add_to_cart_text' );
add_filter( 'add_to_cart_text', 'pt_add_to_cart_default_text' );
add_filter( 'not_purchasable_text', 'pt_add_to_cart_text' );
add_filter( 'out_of_stock_add_to_cart_text', 'pt_add_to_cart_text' );


// ----- Adding new Availability container
/*if ( ! function_exists( 'pt_woocommerce_availability' ) ) { 
	function pt_woocommerce_availability() {
		global $woocommerce, $product;
		$availability = $product->get_availability();
		if ($availability['availability']) :
			echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
	    endif;
	}
}
add_action('woocommerce_after_single_product_summary', 'pt_woocommerce_availability', 5);*/


// ----- Adding single product pagination
if ( get_option('product_pagination') === 'on' ) {
	if ( ! function_exists( 'pt_single_product_pagi' ) ) { 
		function pt_single_product_pagi(){
			if(is_product()) : 
			?>	
				<div class="single-product-navi">
					<?php previous_post_link('%link', '<i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;'.__('Prev', 'plumtree').'<span class="separator">&nbsp;&nbsp;&nbsp;&frasl;&nbsp;&nbsp;</span>'); ?> 
					<?php next_post_link('%link', __('Next', 'plumtree').'&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>'); ?>
				</div>   
			<?php
			endif;
		}
	}
	add_action( 'woocommerce_before_main_content', 'pt_single_product_pagi', 4 );
}


// ----- Adding single product breadcrumbs wrapper
function pt_single_product_breadcrumbs_wrap_begin(){
	if(is_product() || ( is_archive() && !is_shop() ) ) : ?>
		<?php if ( (get_option('store_spacer_bg_color') != '') && (get_option('store_spacer_bg_color') != '#fff') ) {
			$spacer_bg = 'style="background:'.get_option('store_spacer_bg_color').';"';
		  } elseif ( get_option('store_spacer_custom_pattern') != '' ) {
			$spacer_bg = 'style="background: url('. get_option('store_spacer_custom_pattern') .') repeat;"';
		  } else {
			$spacer_bg = 'style="background: url('.get_template_directory_uri().'/assets/spacer-'.get_option('store_spacer_default_pattern').'.png) repeat;"';
		  }
		?>

		<div class="store-top stripes" <?php echo $spacer_bg; ?> data-stellar-background-ratio="0.5">
			<div class="container-fluid">
				<div class="row-fluid">

	<?php elseif (is_shop()) : ?>

		<div class="shop-breadcrumbs-wrapper">
			<div class="container-fluid">
				<div class="row-fluid">

	<?php endif;
}
add_action( 'woocommerce_before_main_content', 'pt_single_product_breadcrumbs_wrap_begin', 2 );

function pt_single_product_breadcrumbs_wrap_end(){
	if( is_product() || is_archive() ) : ?>	
		</div></div></div>

	<?php endif;
}

add_action( 'woocommerce_before_main_content', 'pt_single_product_breadcrumbs_wrap_end', 5 );



// ----- Add meta box for activating flip animation

add_action( 'add_meta_boxes', 'pt_product_flip_metabox' );                                                      
add_action( 'save_post', 'pt_product_flip_save' );

function pt_product_flip_metabox() {
    add_meta_box( 'product_flip', 'Flip Animation', 'pt_product_flip_call', 'product', 'side', 'default' );
}

function pt_product_flip_call($post) {
	global $post;
	wp_nonce_field( 'pt_product_flip_call', 'pt_product_flip_nonce' );
	// Get previous meta data
	$values = get_post_custom($post->ID);
	$check = isset( $values['pt_product_flip_animation'] ) ? esc_attr( $values['pt_product_flip_animation'][0] ) : 'off';
	?>
	<div class="product-flip">
		<label for="pt_product_flip_animation"><input type="checkbox" name="pt_product_flip_animation" id="pt_product_flip_animation" <?php checked( $check, 'on' ); ?> /><?php _e( 'Use flip animation for this product', 'plumtree' ) ?></label>
		<p><?php _e( 'Check the checkbox if you want to use flip animation for this product. The first image of the product gallery is going to be used for back.', 'plumtree'); ?></p>
	</div>
	<?php  
}

// When the post is saved, saves our custom data
function pt_product_flip_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return;

    if ( ( isset ( $_POST['pt_product_flip_nonce'] ) ) && ( ! wp_verify_nonce( $_POST['pt_product_flip_nonce'], 'pt_product_flip_call' ) ) )
            return;

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
    }

    // OK, we're authenticated: we need to find and save the data
    $chk = isset( $_POST['pt_product_flip_animation'] ) && $_POST['pt_product_flip_animation'] ? 'on' : 'off';
	update_post_meta( $post_id, 'pt_product_flip_animation', $chk );
}

}

add_filter('woocommerce_get_price_html','catalog_mode_price');
function catalog_mode_price($price){
    $mode = get_option('catalog_mode');
    if ($mode == 'on') return '';
    return $price;
}

function remove_loop_button(){
    $mode = get_option('catalog_mode');
    if ($mode == 'on') remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10 );
}

add_action('init','remove_loop_button');

function woocommerce_show_product_loop_new_badge() {
    $postdate 		= get_the_time( 'Y-m-d' );			// Post date
    $postdatestamp 	= strtotime( $postdate );			// Timestamped post date
    $newness 		= (int) get_option( 'new_product_days' ); 	// Newness in days as defined by option

    if ( get_option('new_badge') === 'on' ) {
        if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
            echo '<span class="pt-new-badge"><span class="pt-new-badge-text">' . __( 'New', 'plumtree' ) . '</span></span>';
        }
    }
}

add_action( 'woocommerce_animation_section_end',  'woocommerce_show_product_loop_new_badge', 30 );