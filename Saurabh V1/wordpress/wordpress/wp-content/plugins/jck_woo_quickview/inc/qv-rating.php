<?php global $post, $product, $woocommerce; ?>

<?php do_action($this->slug.'-before-rating'); ?>

<?php
if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;

$count   = $product->get_rating_count();
$average = $product->get_average_rating();

if ( $count > 0 ) : ?>

	<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
			<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
				<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?>
			</span>
		</div>
		<div class="text-rating">(<?php printf( _n( '%s rating', '%s ratings', $count, 'woocommerce' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?>)</div>
	</div>

<?php endif; ?>

<?php do_action($this->slug.'-after-rating'); ?>