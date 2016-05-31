<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

$use_slider = (get_option('use_product_image_gallery') == 'on') ? true : false ;

$main_thumb = '';

if ( has_post_thumbnail() ) {

	$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' ) );
	$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
	$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
	$attachment_count   = count( $product->get_gallery_attachment_ids() );

	if ( $attachment_count > 0 ) {
		$gallery = '[product-gallery]';
	} else {
		$gallery = '';
	}

	$main_thumb = apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image item first" title="%s" >%s</a>', $image_link, $image_title, $image ), $post->ID );

} else {

	$main_thumb = apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );

}

if ( $attachment_ids ) { 
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
?>

	<div class="thumbnails <?php echo ($use_slider) ? ' iosthumbs ' : ''  ?> <?php echo 'columns-' . $columns; ?>" >

		<?php		
		if ($use_slider) { 
		 	echo $main_thumb;
		 	$loop++;
		}
		
		foreach ( $attachment_ids as $attachment_id ) {

			$classes = ($use_slider) ? array( 'item' ) : array( 'zoom' ) ;

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$image_class = esc_attr( implode( ' ', $classes ) );
			$image_title = esc_attr( get_the_title( $attachment_id ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}
		?>

	</div>

<?php }