<style>
    
<?php $theSettings = $this->settings->__getSettings(); ?>

/* Add to Cart */
	
	#jckqv .quantity {
		display: <?php echo ($theSettings['popup_content_showqty'] == 1) ? 'inline' : 'none !important'; ?>;
	}
	
	<?php if($theSettings['popup_content_themebtn'] != 1){ ?>	
	
		#jckqv .button {
			background: <?php echo $theSettings['popup_content_btncolour']; ?>;
			color: <?php echo $theSettings['popup_content_btntextcolour']; ?>;
		}
		
			#jckqv .button:hover {
				background: <?php echo $theSettings['popup_content_btnhovcolour']; ?>;
				color: <?php echo $theSettings['popup_content_btntexthovcolour']; ?>;
			}
	
	<?php } ?>

</style>