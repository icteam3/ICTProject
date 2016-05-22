<?php global $post, $product, $woocommerce; ?>

<?php do_action( 'woocommerce_' . $product->product_type . '_add_to_cart'  ); ?>

<script>

<?php $assets_path = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/'; ?>

/* <![CDATA[ */
<?php 
$woocommerce_params = array(
	'countries'                        => json_encode( $woocommerce->countries->get_allowed_country_states() ),
	'plugin_url'                       => $woocommerce->plugin_url(),
	'ajax_url'                         => $woocommerce->ajax_url(),
	'ajax_loader_url'                  => apply_filters( 'woocommerce_ajax_loader_url', $woocommerce->plugin_url() . '/assets/images/ajax-loader@2x.gif' ),
	'i18n_select_state_text'           => esc_attr__( 'Select an option&hellip;', 'woocommerce' ),
	'i18n_required_rating_text'        => esc_attr__( 'Please select a rating', 'woocommerce' ),
	'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
	'i18n_required_text'               => esc_attr__( 'required', 'woocommerce' ),
	'i18n_view_cart'                   => esc_attr__( 'View Cart &rarr;', 'woocommerce' ),
	'review_rating_required'           => get_option( 'woocommerce_review_rating_required' ),
	'update_order_review_nonce'        => wp_create_nonce( "update-order-review" ),
	'apply_coupon_nonce'               => wp_create_nonce( "apply-coupon" ),
	'option_guest_checkout'            => get_option( 'woocommerce_enable_guest_checkout' ),
	'checkout_url'                     => add_query_arg( 'action', 'woocommerce-checkout', $woocommerce->ajax_url() ),
	'is_checkout'                      => is_page( woocommerce_get_page_id( 'checkout' ) ) ? 1 : 0,
	'update_shipping_method_nonce'     => wp_create_nonce( "update-shipping-method" ),
	'cart_url'                         => get_permalink( woocommerce_get_page_id( 'cart' ) ),
	'cart_redirect_after_add'          => get_option( 'woocommerce_cart_redirect_after_add' )
);
?>
var woocommerce_params = <?php echo json_encode($woocommerce_params); ?>;
/* ]]> */

<?php
$suffix               = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
$assets_path          = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/';
$frontend_script_path = $assets_path . 'js/frontend/';
?>

jQuery(document).ready(function($) {
	$.getScript("<?php echo $frontend_script_path . 'add-to-cart' . $suffix . '.js'; ?>");
	$.getScript("<?php echo $frontend_script_path . 'single-product' . $suffix . '.js'; ?>");
	$.getScript("<?php echo $frontend_script_path . 'woocommerce' . $suffix . '.js'; ?>");
	$.getScript("<?php echo $frontend_script_path . 'add-to-cart-variation' . $suffix . '.js'; ?>");
});
</script>