<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (get_option('catalog_mode') == 'on') return; if (get_option('checkout_steps') == 'on') { $steps_checkout = true; } else { $steps_checkout = false; }
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'plumtree' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

	<?php if ( is_user_logged_in() && $steps_checkout ) {

		$current_user = wp_get_current_user();

		echo '<div class="tab-pane active" id="authorization">';
		echo '<h3 class="pt-content-title">' . __( 'Welcome Back', 'plumtree' ) . '</h3>';
		echo '<p class="logged-in-as">' .
		sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'plumtree' ), admin_url( 'profile.php' ), $current_user->user_login, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) )
		. '</p>';
		echo '<p class="form-row form-row-last step-nav">
			<span class="pt-dark-button step-checkout" data-toggle="tab" data-show="billing">'.__('Continue to Billing Address', 'plumtree').'&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></span>
		</p>';
		echo '</div>';

	} else { ?>

	<?php if ( get_option('woocommerce_enable_checkout_login_reminder') != 'yes' ) : ?>

		<div class="tab-pane active" id="authorization">
			<h3 class="pt-content-title"><?php _e( 'Fill in the required fields', 'plumtree' ); ?></h3>
			<p class="guest-checkout"><?php _e('You may checkout as guest', 'plumtree'); ?></p>

			<?php if ($steps_checkout) {
					echo '<p class="form-row form-row-last step-nav guest-step">
							<span class="pt-dark-button step-checkout guest" data-toggle="tab" data-show="billing">'.__('Continue to Billing Address', 'plumtree').'&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></span>
						  </p>'; 
			}?>

		</div>
	<?php endif; 
	}
	?>

<form name="checkout" method="post" class="checkout woocommerce-checkout<?php if ($steps_checkout) { echo " tab-content"; }; ?>" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="<?php if ($steps_checkout) { echo "tab-pane"; }; ?>" id="billing" >

			<?php do_action( 'woocommerce_checkout_billing' ); ?>

		</div>

		<div class="<?php if ($steps_checkout) { echo "tab-pane"; }; ?>" id="shipping">

			<?php do_action( 'woocommerce_checkout_shipping' ); ?>

		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="<?php if ($steps_checkout) { echo "tab-pane"; }; ?>">

		<h3 class="pt-content-title" id="order_review_heading"><?php _e( 'Your order', 'plumtree' ); ?></h3>
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>

	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php if ($steps_checkout) { echo "</div><!-- Pane contents ends -->"; }; ?>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>


