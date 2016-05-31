<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$mode = get_option('catalog_mode');

?>

<?php if ( $mode !== 'on' ) : ?>

	<?php
		$link = array(
			'url'   => '',
			'label' => '',
			'class' => ''
		);

		$handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );

		switch ( $handler ) {
			case "variable" :
				$link['label'] 	= apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'plumtree' ) );
				$link['class']  = 'add_to_cart_button button product_type_variable';
			break;
			case "grouped" :
				$link['label'] 	= apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'plumtree' ) );
				$link['class']  = 'add_to_cart_button button product_type_grouped';
			break;
			case "external" :
				$link['label'] 	= apply_filters( 'external_add_to_cart_text', __( 'Read More', 'plumtree' ) );
				$link['class']  = 'add_to_cart_button button product_type_external';
			break;
			default :
				if ( $product->is_purchasable() ) {
					$link['label'] 	= apply_filters( 'add_to_cart_text', __( 'Add to cart', 'plumtree' ) );
					$link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button button' );
				} else {
					$link['label'] 	= apply_filters( 'not_purchasable_text', __( 'Read More', 'plumtree' ) );
					$link['class']  = 'button';
				}
			break;
		}

		echo apply_filters( 'woocommerce_loop_add_to_cart_link', 
				sprintf('<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>', 
						esc_url( $product->add_to_cart_url() ), 
						esc_attr( isset( $quantity ) ? $quantity : 1 ),
						esc_attr( $product->id ), 
						esc_attr( $product->get_sku() ), 
						esc_attr( isset( $link['class'] ) ? $link['class'] : 'button' ), 
						$link['label']
						), 
				$product, $link );

	?>

<?php endif; ?>
