<?php global $post, $product, $woocommerce; ?>

<?php do_action($this->slug.'-before-price'); ?>

<?php echo '<p class="price">'. $product->get_price_html() .'</p>'; ?>

<?php do_action($this->slug.'-after-price'); ?>