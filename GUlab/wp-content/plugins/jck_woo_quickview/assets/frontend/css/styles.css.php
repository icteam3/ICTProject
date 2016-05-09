<?php header('Content-type: text/css'); ?>
	
/* QV Button */

.jckqvBtn {
	<?php 
	$btnDisplay = 'table';
	if($theSettings['trigger_position_align'] == 'none') $btnDisplay = 'block';
	?>
	display: <?php echo $btnDisplay; ?>;
	<?php if($theSettings['trigger_styling_autohide']){ ?>
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
		filter: alpha(opacity=0);
		-moz-opacity: 0;
		-khtml-opacity: 0;
		opacity: 0;
		visibility: hidden;
	<?php } ?>
	float: <?php echo ($theSettings['trigger_position_align'] == 'left' || $theSettings['trigger_position_align'] == 'right') ? $theSettings['trigger_position_align'] : "none"; ?>;
	<?php $margins = array($theSettings['trigger_position_margins'][0].'px', $theSettings['trigger_position_margins'][1].'px', $theSettings['trigger_position_margins'][2].'px', $theSettings['trigger_position_margins'][3].'px'); ?>
	margin: <?php echo implode(' ', $margins); ?>;
	<?php $padding = array($theSettings['trigger_styling_padding'][0].'px', $theSettings['trigger_styling_padding'][1].'px', $theSettings['trigger_styling_padding'][2].'px', $theSettings['trigger_styling_padding'][3].'px'); ?>
	padding: <?php echo implode(' ', $padding); ?>;
	<?php if($theSettings['trigger_position_align'] == 'center') { ?>
	margin-left: auto;
	margin-right: auto;
	<?php } ?>
	<?php if($theSettings['trigger_styling_btnstyle'] != 'none') { ?>
		<?php if($theSettings['trigger_styling_btnstyle'] == 'flat') { ?>
			background: <?php echo $theSettings['trigger_styling_btncolour']; ?>;
		<?php } else { ?>
			border: 1px solid #fff;
			border-color: <?php echo $theSettings['trigger_styling_btncolour']; ?>;
		<?php } ?>
		color: <?php echo $theSettings['trigger_styling_btntextcolour']; ?>;
	<?php } ?>
	-moz-border-radius-topleft: <?php echo $theSettings['trigger_styling_borderradius'][0]; ?>px;
	-webkit-border-top-left-radius: <?php echo $theSettings['trigger_styling_borderradius'][0]; ?>px;
	 border-top-left-radius: <?php echo $theSettings['trigger_styling_borderradius'][0]; ?>px;
	-moz-border-radius-topright: <?php echo $theSettings['trigger_styling_borderradius'][1]; ?>px;
	-webkit-border-top-right-radius: <?php echo $theSettings['trigger_styling_borderradius'][1]; ?>px;
	border-top-right-radius: <?php echo $theSettings['trigger_styling_borderradius'][1]; ?>px;
	-moz-border-radius-bottomright: <?php echo $theSettings['trigger_styling_borderradius'][2]; ?>px;
	-webkit-border-bottom-right-radius: <?php echo $theSettings['trigger_styling_borderradius'][2]; ?>px;
	border-bottom-right-radius: <?php echo $theSettings['trigger_styling_borderradius'][2]; ?>px;
	-moz-border-radius-bottomleft: <?php echo $theSettings['trigger_styling_borderradius'][3]; ?>px;
	-webkit-border-bottom-left-radius: <?php echo $theSettings['trigger_styling_borderradius'][3]; ?>px;
	border-bottom-left-radius: <?php echo $theSettings['trigger_styling_borderradius'][3]; ?>px;
}

.jckqvBtn:hover {
	<?php if($theSettings['trigger_styling_btnstyle'] != 'none') { ?>
		<?php if($theSettings['trigger_styling_btnstyle'] == 'flat') { ?>
			background: <?php echo $theSettings['trigger_styling_btnhovcolour']; ?>;
		<?php } else { ?>
			border-color: <?php echo $theSettings['trigger_styling_btnhovcolour']; ?>;
		<?php } ?>
		color: <?php echo $theSettings['trigger_styling_btntexthovcolour']; ?>;
	<?php } ?>		
}

/* Magnific Specific */

.mfp-bg {
	background: <?php echo $theSettings['popup_general_overlaycolour']; ?>;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $theSettings['popup_general_overlayopacity']*10; ?>)";
	filter: alpha(opacity=<?php echo $theSettings['popup_general_overlayopacity']*10; ?>);
	-moz-opacity: <?php echo $theSettings['popup_general_overlayopacity']; ?>;
	-khtml-opacity: <?php echo $theSettings['popup_general_overlayopacity']; ?>;
	opacity: <?php echo $theSettings['popup_general_overlayopacity']; ?>;
}
	
/* Images */
	
		#jckqv .rsMinW .rsThumbsHor {
			height: <?php echo $imgsizes['thumbnail']['height']; ?>px; /* thumbnail Height */
		}
			#jckqv .rsMinW, 
			#jckqv .rsMinW .rsOverflow, 
			#jckqv .rsMinW .rsSlide, 
			#jckqv .rsMinW .rsVideoFrameHolder, 
			#jckqv .rsMinW .rsThumbs {
				background: <?php echo $theSettings['popup_imagery_bgcolour']; ?>; /* Slide BG Colour */
			}
			#jckqv .rsMinW .rsThumb {
				width: <?php echo $imgsizes['thumbnail']['width']; ?>px; /* thumbnail Width */
				height: <?php echo $imgsizes['thumbnail']['height']; ?>px; /* thumbnail Height */
			}

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