<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="woocommerce-shipping-fields">
	<?php if ( WC()->cart->needs_shipping_address() === true ) : ?>

		<?php
			if ( empty( $_POST ) ) {

				$ship_to_different_address = get_option( 'woocommerce_ship_to_billing' ) == 'no' ? 1 : 0;
				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

			} else {

				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

			}
		?>

		<h3 class="pt-content-title"><?php _e( 'Shipping Address', 'plumtree' ); ?></h3>

		<p class="form-row form-row-wide" id="ship-to-different-address">
			<input class="input-checkbox" id="ship-to-different-address-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <label for="ship-to-different-address-checkbox" class="checkbox"><?php _e( 'Ship to a different address?', 'plumtree' ); ?></label>
		</p>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<?php foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : ?>

				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

			<?php endforeach; ?>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional Information', 'plumtree' ); ?></h3>

		<?php endif; ?>

		<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>

<?php if ( get_option('checkout_steps') === "on" ) { ?>
	<p class="form-row form-row-first step-nav">
		<span class="pt-dark-button step-checkout" data-show="billing" data-toggle="tab"><i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?php _e('Back', 'plumtree');?></span>
	</p>
	<p class="form-row form-row-last step-nav">
		<span class="pt-dark-button step-checkout" data-toggle="tab" data-show="order_review"><?php _e('Continue to Order Review', 'plumtree');?>&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></span>
	</p>
<?php } ?>