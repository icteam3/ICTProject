<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if (get_option('catalog_mode') == 'on') return;
wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>
<div class="product-cart-wrap">
<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="row-fluid" method="post">
<div class="span12">
<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Item Description', 'plumtree' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'plumtree' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'plumtree' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Subtotal', 'plumtree' ); ?></th>
		</tr>


	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							
					<!-- Item Description -->
					<td class="item-description">

						<div class="product-details">

							<?php //Thumbnail
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() ) {
								echo '<div class="thumb-wrapper">';
								echo $thumbnail;
								echo '</div>'; 
							} else {
								echo '<div class="thumb-wrapper">';
								printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
								echo '</div>'; 
							}
							?>
								
							<div class="title-wrap">
							<?php
								if ( ! $_product->is_visible() )
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ). '&nbsp;';
								else
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

	               				// Backorder notification
	               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
	               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'plumtree' ) . '</p>';
							?>
							</div>

							<?php
							echo '<div class="remove-wrap">';
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s"><span class="icon"></span>'.__('Remove', 'plumtree').'</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'plumtree' ) ), $cart_item_key );
							echo '</div>';
							?>
								
						</div>

					</td>

					<!-- Product price -->
					<td class="product-price">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<!-- Quantity inputs -->
					<td class="product-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</td>

					<!-- Product subtotal -->
					<td class="product-subtotal">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon">

						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon Code', 'plumtree' ); ?>" /> <input type="submit" class="button coupon-submit" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'plumtree' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>

						<input type="submit" class="button pt-light-button update" name="update_cart" value="<?php _e( 'Update Cart', 'plumtree' ); ?>" />

						<?php 
						$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
						if ($shop_page_url) {
							echo '<a class="pt-light-button go-shop" rel="bookmark" href="' . $shop_page_url . '">' . __('Continue Shopping', 'plumtree') . '</a>';
						}?>

					</div>
				<?php } ?>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>
</div>
</form>
<div class="row-fluid">
	<div class="cart-collaterals span9">

		<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	</div>
	<?php if ( is_active_sidebar( 'cart-widgets' ) ) : ?>
		<div id="sidebar-cart" class="widget-area cart-sidebar span3" role="complementary">
			<div class="row-fluid">
			<?php dynamic_sidebar( 'cart-widgets' ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
