<?php global $post, $product, $woocommerce; ?>

<?php if($product->product_type == "grouped") { ?>
    
    <a href="<?php echo get_the_permalink($product->ID); ?>" rel="nofollow" class="button  product_type_grouped"><?php _e('View products','woocommerce'); ?></a>
    
<?php } else { ?>

    <?php do_action($this->slug.'-before-addtocart'); ?>
    
    <?php do_action( 'woocommerce_' . $product->product_type . '_add_to_cart'  ); ?>
    
    <?php do_action($this->slug.'-after-addtocart'); ?>
    
    <script>
    
    <?php $assets_path = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/'; ?>
    
    /* <![CDATA[ */
    <?php
    $wc_add_to_cart_params = apply_filters( 'wc_add_to_cart_params', array(
    	'ajax_url'                => $woocommerce->ajax_url(),
    	'ajax_loader_url'         => apply_filters( 'woocommerce_ajax_loader_url', $assets_path . 'images/ajax-loader@2x.gif' ),
    	'i18n_view_cart'          => esc_attr__( 'View Cart', 'woocommerce' ),
    	'cart_url'                => get_permalink( wc_get_page_id( 'cart' ) ),
    	'is_cart'                 => is_cart(),
    	'cart_redirect_after_add' => get_option( 'woocommerce_cart_redirect_after_add' )
    ) );
    ?>
    var wc_add_to_cart_params = <?php echo json_encode($wc_add_to_cart_params); ?>;
    
    <?php 
    $wc_single_product_params = apply_filters( 'wc_single_product_params', array(
    	'i18n_required_rating_text' => esc_attr__( 'Please select a rating', 'woocommerce' ),
    	'review_rating_required'    => get_option( 'woocommerce_review_rating_required' ),
    ) );
    ?>
    var wc_single_product_params = <?php echo json_encode($wc_single_product_params); ?>;
    
    <?php 
    $woocommerce_params = apply_filters( 'woocommerce_params', array(
    	'ajax_url'        => $woocommerce->ajax_url(),
    	'ajax_loader_url' => apply_filters( 'woocommerce_ajax_loader_url', $assets_path . 'images/ajax-loader@2x.gif' ),
    ) );
    ?>
    var woocommerce_params = <?php echo json_encode($wc_add_to_cart_params); ?>;
    
    <?php 
    $wc_cart_fragments_params = apply_filters( 'wc_cart_fragments_params', array(
    	'ajax_url'      => $woocommerce->ajax_url(),
    	'fragment_name' => apply_filters( 'woocommerce_cart_fragment_name', 'wc_fragments' )
    ) );
    ?>
    var wc_cart_fragments_params = <?php echo json_encode($wc_add_to_cart_params); ?>;
    
    <?php 
    $wc_add_to_cart_variation_params = apply_filters( 'wc_add_to_cart_variation_params', array(
    	'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
    	'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ),
    ) );
    ?>
    var wc_add_to_cart_variation_params = <?php echo json_encode($wc_add_to_cart_params); ?>;
    /* ]]> */
    
    // add +/- buttons to qty
    
    jQuery( '#jckqv div.quantity:not(.buttons_added), #jckqv td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<div class="<?php echo $this->slug; ?>-qty-spinners"><input type="button" value="+" data-dir="plus" class="<?php echo $this->slug; ?>-qty-spinner <?php echo $this->slug; ?>-qty-spinners__plus" /><input type="button" value="-" data-dir="minus" class="<?php echo $this->slug; ?>-qty-spinner <?php echo $this->slug; ?>-qty-spinners__minus" /></div>' );
    
    // Add variable add to cart script to head
    
    <?php
    $suffix                             = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $assets_path                        = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/';
    $frontend_script_path               = $assets_path . 'js/frontend/';
    $add_to_cart_variation_script_id    = $this->slug."-add-to-cart-variation";
    ?>
    
    // remove script from previous modal
    
    jQuery('#<?php echo $add_to_cart_variation_script_id; ?>').remove();
    
    // add script again
    // needs to be added every time of it doesn't work effectively
    
    var add_to_cart_variation_script    = document.createElement("script");
    add_to_cart_variation_script.type   = "text/javascript";
    add_to_cart_variation_script.src    = "<?php echo $frontend_script_path . 'add-to-cart-variation' . $suffix . '.js'; ?>";
    add_to_cart_variation_script.id     = "<?php echo $add_to_cart_variation_script_id; ?>";
    
    jQuery("head").append(add_to_cart_variation_script);
    
    </script>

<?php } ?>