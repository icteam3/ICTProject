<?php // Plumtree Layouts for Themes

add_action( 'add_meta_boxes', 'pt_layouts_metabox' );

add_action( 'save_post', 'pt_layouts_save' );

function pt_layouts_metabox() {
	$screens = array( 'post', 'page' );
    foreach ($screens as $screen) {
        add_meta_box(
            'layout_id',
            __( 'Layout Settings', 'plumtree' ),
            'pt_layout_metabox_contents',
            $screen,
            'side'
        );
    }
}

function pt_layout_metabox_contents($post) {
	wp_nonce_field( basename( __FILE__ ), 'pt_layout_nonce' );
	// Get theme-supported theme layouts
	$post_layouts = pt_get_default_layouts();

  	// Use get_post_meta to retrieve an existing value from the database and use the value for the form
  	$current_layout = pt_get_post_layout( $post->ID );
  	$admin_page = get_template_directory_uri() . 'ptpanel/ptpanel.php';
  	?>
	<div class="post-layout">
		<p><?php __( 'Specify a custom page layout for this content.', 'plumtree' ) ?></p>
		<input type="radio" name="pt_post_layout" id="post-layout-default" value="default" <?php checked( $current_layout, "default" )?> />
		<label for="post_layout_default"><?php echo __( 'Default Set in Plumtree Theme Options','plumtree') ?></label><br /><br />
			<?php foreach ( $post_layouts as $layout => $key ) { ?>
			<div class="collection">
				<label for="post-layout-<?php echo esc_attr( $key['value'] ); ?>">
					<input class="collection_field" type="radio" name="pt_post_layout" id="post-layout" value="<?php echo esc_attr( $key['value'] ); ?>" <?php checked( $current_layout, $key['value'] ); ?> />
					<span class="layout_image" title="<?php echo esc_attr( $key['label'] ); ?>">
						<img src="<?php echo esc_url( $key['icon'] ); ?>" alt="<?php echo esc_attr( $key['label'] ); ?>"  width="39" height="39"/>
					<span>
				</label>
			</div>
	<?php } 
	echo '</div>';
	echo '<script>jQuery(document).ready(function($) { $("#post-layout-default, #post-layout").styler(); });</script>';
};

function pt_layouts_save ( $post_id) {

	/* Verify the nonce for the post formats meta box. */
	if ( !isset( $_POST['pt_layout_nonce'] ) || !wp_verify_nonce( $_POST['pt_layout_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	if ('page' == $_POST['post_type']) {  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
    } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    };  

    $old_layout = pt_get_post_layout( $post_id );
    $new_layout = esc_attr( $_POST["pt_post_layout"]);

    if ($new_layout && $new_layout != $old_layout) {  
            update_post_meta( $post_id, '-pt-layout', $new_layout ); } 

};

function pt_get_default_layouts() {

	$layouts = get_theme_support( 'plumtree-layouts' );

	if (isset( $layouts[0] )){
		return $layouts[0];
	} else {
		__('Specify some layouts first!', 'plumtree');};
};

function pt_get_post_layout( $post_id ) {
	/* Get the post layout. */
	$layout = get_post_meta( $post_id, '-pt-layout', true );
	/* Return the layout if one is found.  Otherwise, return 'default'. */
	return ( !empty( $layout ) ? $layout : 'default' );
		return $layout;
}

function pt_show_layout() {
	global $wp_query;

	/* Set the layout to default. */
	$layout = 'one-col'; 

	/* If viewing a front page, check if a layout has been specified. */
	if ( is_front_page() || is_page_template('front-page.php') ) {

		$global_front_layout = (get_option('front_layout') != '') ? get_option('front_layout') : 'one-col';
		$post_id = $wp_query->get_queried_object_id();
		$post_layout = pt_get_post_layout( $post_id );

		if ( isset($global_front_layout) && $global_front_layout == $post_layout ) { 
			$layout = $global_front_layout;
		} elseif ( isset($global_front_layout) && $post_layout === 'default' ) {
			$layout = $global_front_layout;
		} else {
			$layout = $post_layout;
		}
	} else

	/* If viewing a page, check if a layout has been specified. */
	if ( is_page() ) {

		$global_page_layout = (get_option('page_layout') != '') ? get_option('page_layout') : 'one-col';
		$post_id = $wp_query->get_queried_object_id();
		$post_layout = pt_get_post_layout( $post_id );

		if ( isset($global_page_layout) && $global_page_layout == $post_layout ) { 
			$layout = $global_page_layout;
		} elseif ( isset($global_page_layout) && $post_layout === 'default' ) {
			$layout = $global_page_layout;
		} else {
			$layout = $post_layout;
		}

	} else

	/* If viewing a blog page, check if a layout has been specified. */
	if ( is_home() ) {

		$global_blog_layout = (get_option('blog_layout') != '') ? get_option('blog_layout') : 'one-col';
		$layout = $global_blog_layout;

	} else

	/* If viewing a singular post, check if a layout has been specified. */
	if ( is_single() ) {

		$global_single_layout = (get_option('single_layout') != '') ? get_option('single_layout') : 'one-col';
		$layout = $global_single_layout;

	} else
	
	/* If viewing a taxonomy, check if a layout has been specified */
	if ( is_category() || is_tag() || is_tax() || is_archive() || is_search()  ) {

		$global_archive_layout = (get_option('archive_layout') != '') ? get_option('archive_layout') : 'one-col';
		$layout = $global_archive_layout;

	} 

    if ( class_exists('Woocommerce') ) {

        /* If viewing a products page, check if a layout has been specified */
        if ( is_shop() ) {

            $global_shop_layout = (get_option('shop_layout') != '') ? get_option('shop_layout') : 'one-col';
            $post_id = $wp_query->get_queried_object_id();
            $post_layout = pt_get_post_layout( $post_id );

            if ( isset($global_shop_layout) && $global_shop_layout == $post_layout ) {
                $layout = $global_shop_layout;
            } elseif ( isset($global_shop_layout) && $post_layout === 'default' ) {
                $layout = $global_shop_layout;
            } else {
                $layout = $post_layout;
            }

            if ( isset($_GET['layout']) ) $layout = $_GET['layout'];

        } else

        /* If viewing a single product page, check if a layout has been specified */
        if ( is_product() ) {

            $global_product_layout = (get_option('product_layout') != '') ? get_option('product_layout') : 'one-col';
            $layout = $global_product_layout;

        }
    }
	/* Return the layout and allow plugin/theme developers to override it. */
	return esc_attr( apply_filters( 'get_theme_layout', "layout-{$layout}" ) );
}

function pt_layout_body_class( $classes ) {

	/* Adds the layout to array of body classes. */
	$classes[] = sanitize_html_class( pt_show_layout() );

	/* Return the $classes array. */
	return $classes;
}
add_filter( 'body_class', 'pt_layout_body_class' );


function pt_script_enqueue_post($hook) {
    if( 'post.php' != $hook )
        return;
    	wp_enqueue_style('ptpanel-formstyler-css', get_template_directory_uri() . '/ptpanel/css/formstyler.css');
		wp_enqueue_script('ptpanel-formstyler-js', get_template_directory_uri() . '/ptpanel/js/formstyler.min.js', array('jquery'));
}
add_action( 'admin_enqueue_scripts', 'pt_script_enqueue_post' );

function pt_script_enqueue_new_post($hook) {
    if( 'post-new.php' != $hook )
        return;
    	wp_enqueue_style('ptpanel-formstyler-css', get_template_directory_uri() . '/ptpanel/css/formstyler.css');
		wp_enqueue_script('ptpanel-formstyler-js', get_template_directory_uri() . '/ptpanel/js/formstyler.min.js', array('jquery'));
}
add_action( 'admin_enqueue_scripts', 'pt_script_enqueue_new_post' );

// Plumtree Sidebar disable function
function pt_disable_sidebars( $sidebars_widgets ) {
	global $wp_query, $wp_customize;

	if ( current_theme_supports( 'plumtree-layouts' ) && !is_admin() ) {
		if ( ! isset( $wp_customize ) ) {
			if ( 'layout-one-col' == pt_show_layout() ) {
				$sidebars_widgets['sidebar-front'] = false;
				$sidebars_widgets['sidebar-pages'] = false;
				$sidebars_widgets['sidebar-shop'] = false;
				$sidebars_widgets['sidebar-blog'] = false;
				$sidebars_widgets['sidebar-product'] = false;
			}
		}
	}

	return $sidebars_widgets;
}


