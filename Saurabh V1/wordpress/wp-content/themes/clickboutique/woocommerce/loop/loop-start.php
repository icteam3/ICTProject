<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<?php $filter_class = ''; if( is_shop() || is_product_category() ) { $filter_class = 'data-isotope="container" data-layout="fitrows"'; }; ?>
<ul class="products grid-layout" <?php echo $filter_class; ?> >