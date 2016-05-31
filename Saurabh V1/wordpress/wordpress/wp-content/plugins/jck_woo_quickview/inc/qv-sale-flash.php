<?php global $post, $product, $woocommerce; ?>

<?php
if ( $product->is_on_sale() ) :
	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
endif;