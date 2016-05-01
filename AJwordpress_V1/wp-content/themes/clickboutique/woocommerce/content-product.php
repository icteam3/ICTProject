<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $post;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Ensure visibility
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
$classes[] = $woocommerce_loop['columns'];
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

// Adding extra data for isotope filtering
$attributes = $product->get_attributes();
if ($attributes) {
	foreach ( $attributes as $attribute ) {
		if ( $attribute['is_taxonomy'] ) {
			$values = woocommerce_get_product_terms( $product->id, $attribute['name'], 'names' );
			$result = implode( ', ', $values );
		} else {
			$values = array_map( 'trim', explode( '|', $attribute['value'] ) );
			$result = implode( ', ', $values );
		}
		$arr[] = strtolower($result);
	}
	$attr = implode(', ', $arr);
}

// Adding extra featured img if exists
$attachment_ids = $product->get_gallery_attachment_ids();
$flip = get_post_meta( $post->ID, 'pt_product_flip_animation' ); 
$flip_class = '';
$image = false;

if ( $attachment_ids && ($flip[0] == 'on') ) {
	$attachment_id = $attachment_ids['0'];

	$image = wp_get_attachment_image( $attachment_id, 'shop_catalog' ) ;
	/*$tmp = $product->post;
	$product_link = $tmp->guid;
	$product_title = $tmp->post_title;
	$second_img_output = '<a href="'.$product_link.'" class="back-img" title="Click to learn more about '.$product_title.'"  rel="">'.$image.'</a>';*/
	$flip_class = 'flip-enabled';
}
?>

<li <?php post_class( $classes ); ?> data-element="<?php echo $attr; ?>">

	<div class="product-wrapper <?php echo $flip_class; ?> <?php echo get_option('product_hover');?>">

		<div class="animation-section" data-product-link="<?php the_permalink(); ?>">

			<div class="product-img-wrapper flip-container">

				<div class="flipper">

					<div class="front img-wrap">
						<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
					</div>

					<?php if ( $attachment_ids && $image && ($flip[0] == 'on') ) : ?>

						<div class="back img-wrap">
							<?php echo $image; ?>
						</div>

					<?php endif; ?>

				</div>

			</div>
            <?php do_action( 'woocommerce_animation_section_end' ); ?>

            <div class="product-controls-wrapper" data-product-link="<?php the_permalink(); ?>">

				<div class="buttons-wrapper">

					<?php 
					// woocommerce_before_shop_loop_item_title hook
					do_action( 'woocommerce_before_shop_loop_item_title' );

					// add to wishlist button
					if ( ( class_exists( 'YITH_WCWL_Shortcode' ) ) && ( get_option('yith_wcwl_enabled') == true ) ) {
						$atts = array(
			                'per_page' => 10,
			                'pagination' => 'no', 
			            	);
						echo YITH_WCWL_Shortcode::add_to_wishlist($atts);
					}
					?>

					<span class="product-tooltip"></span>

				</div>

				<div class="vertical-helper"></div>

			</div>

		</div><!-- .animation-section ends -->

		<div class="product-description-wrapper">

			<?php $product_title = strip_tags( get_the_title( $post->ID ) ); ?>

			<a class="product-title" href="<?php the_permalink(); ?>" title="Click to learn more about <?php echo $product_title; ?>">
				<h3><?php the_title(); ?></h3>
			</a>

			<?php if ( $post->post_excerpt ) : ?>
				<div itemprop="description" class="entry-content">
					<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
				</div>
			<?php endif; ?>

			<div class="product-price-wrapper">
				<?php
				// woocommerce_after_shop_loop_item_title hook
				do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
			</div>

			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

		</div>

	</div><!-- .product-wrapper ends -->

</li>