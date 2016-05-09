<?php global $post, $product, $woocommerce; ?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php $theSettings = $this->settings->__getSettings(); ?>

<?php do_action($this->slug.'-before-images'); ?>

<?php
		
$prod_imgs = array();

if ( has_post_thumbnail() ) {
	
	$img_id = get_post_thumbnail_id();
	$img_src = wp_get_attachment_image_src(get_post_thumbnail_id(), apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
    $img_thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
	    
	$prod_imgs[$img_id]['slideId'][] = '-0-';
	$prod_imgs[$img_id]['img_src'] = $img_src[0];
	$prod_imgs[$img_id]['img_width'] = $img_src[1];
	$prod_imgs[$img_id]['img_height'] = $img_src[2];
	$prod_imgs[$img_id]['img_thumb_src'] = $img_thumb_src[0];

} else {
	
	$prod_imgs[0]['slideId'][] = '-0-';
	$prod_imgs[0]['img_src'] = woocommerce_placeholder_img_src();
	$prod_imgs[0]['img_width'] = 800;
	$prod_imgs[0]['img_height'] = 800;
	$prod_imgs[0]['img_thumb_src'] = woocommerce_placeholder_img_src();

}

// Additional Images

$attachIds = $product->get_gallery_attachment_ids();
$attachment_count = count( $attachIds );

if(!empty($attachIds)):
	foreach($attachIds as $attachId):
	
	    $img_src = wp_get_attachment_image_src( $attachId, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
	    $img_thumb_src = wp_get_attachment_image_src( $attachId, 'thumbnail' );
		
		$prod_imgs[$attachId]['slideId'][] = '-0-';
		$prod_imgs[$attachId]['img_src'] = $img_src[0];
		$prod_imgs[$attachId]['img_width'] = $img_src[1];
        $prod_imgs[$attachId]['img_height'] = $img_src[2];
		$prod_imgs[$attachId]['img_thumb_src'] = $img_thumb_src[0];
		
	endforeach;
endif;

// !If is Varibale product

if ( $product->product_type == 'variable' ) :
	$prodVars = $product->get_available_variations();
	if(!empty($prodVars)):
		foreach($prodVars as $prodVar):
		
			if( has_post_thumbnail( $prodVar['variation_id'] ) ):
				
				$varThumbId = get_post_thumbnail_id($prodVar['variation_id']);
				$img_src = wp_get_attachment_image_src($varThumbId, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
                $img_thumb_src = wp_get_attachment_image_src($varThumbId, 'thumbnail');
				
				$prod_imgs[$varThumbId]['slideId'][] = '-'.$prodVar['variation_id'].'-';
				$prod_imgs[$varThumbId]['img_src'] = $img_src[0];
				$prod_imgs[$varThumbId]['img_width'] = $img_src[1];
                $prod_imgs[$varThumbId]['img_height'] = $img_src[2];
				$prod_imgs[$varThumbId]['img_thumb_src'] = $img_thumb_src[0];
				
			endif;
			
		endforeach;
	endif;
endif;

?>

<div id="<?php echo $this->slug.'_images_wrap'; ?>">
    <?php if(!empty($prod_imgs)): ?>
        
        <?php $prod_imgsCount = count($prod_imgs); ?>
        
        <div id="<?php echo $this->slug.'_images'; ?>" class="jckqv_slider">
        	
        	<?php $i = 0; foreach($prod_imgs as $img_id => $imgData): ?>
        		
        		<img src="<?php echo $imgData['img_src']; ?>" data-<?php echo $this->slug; ?>="<?php echo implode(' ', $imgData['slideId']); ?>" class="<?php echo $this->slug; ?>_image" width="<?php echo $imgData['img_width']; ?>" height="<?php echo $imgData['img_height']; ?>">
        		
        	<?php $i++; endforeach; ?>
        	
        </div>
        
        <?php if( $prod_imgsCount > 1 && $theSettings['popup_imagery_thumbnails'] == 'thumbnails' ): ?>
        
            <div id="<?php echo $this->slug.'_thumbs'; ?>" class="jckqv_slider">
                
                <?php $i = 0; foreach($prod_imgs as $img_id => $imgData): ?>
            		
            		<?php 
                    $classes = array();
                    if($i==0) $classes[] = "slick-main-active";
                    ?>
            		
            		<div data-index="<?php echo $i; ?>" class="<?php echo implode(' ', $classes); ?>"><img src="<?php echo $imgData['img_thumb_src']; ?>" data-<?php echo $this->slug; ?>="<?php echo implode(' ', $imgData['slideId']); ?>" class="<?php echo $this->slug; ?>_thumb"></div>
            		
            	<?php $i++; endforeach; ?>
                
            </div>
        
        <?php endif; ?>
        
    <?php endif; ?>
</div>

<?php do_action($this->slug.'-after-images'); ?>