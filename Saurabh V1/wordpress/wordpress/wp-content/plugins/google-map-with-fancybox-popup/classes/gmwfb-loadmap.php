<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class gmwfb_loadmap
{
	public static function gmwfb_widget($arr)
	{
		$hl = "";
		$geocode = "";
		
		if ( ! is_array( $arr ) )
		{
			return '';
		}
		
		$id = isset($arr['id']) ? $arr['id'] : '0';
		$data = array();
		$data = gmwfb_dbquery::gmwfb_select($id);
		if( count($data) > 0 )
		{
			$form = array(
				'gmwfb_id' => $data[0]['gmwfb_id'],
				'gmwfb_heading' => $data[0]['gmwfb_heading'],
				'gmwfb_address' => $data[0]['gmwfb_address'],
				'gmwfb_latitude' => $data[0]['gmwfb_latitude'],
				'gmwfb_longitude' => $data[0]['gmwfb_longitude'],
				'gmwfb_message' => $data[0]['gmwfb_message'],
				'gmwfb_draggable' => $data[0]['gmwfb_draggable'],
				'gmwfb_width' => $data[0]['gmwfb_width'],
				'gmwfb_height' => $data[0]['gmwfb_height'],
				'gmwfb_zoom' => $data[0]['gmwfb_zoom'],
				'gmwfb_maptype' => $data[0]['gmwfb_maptype'],
				'gmwfb_turnoffscrolling' => $data[0]['gmwfb_turnoffscrolling'],
				'gmwfb_enablevisualrefresh' => $data[0]['gmwfb_enablevisualrefresh'],
				'gmwfb_imagery' => $data[0]['gmwfb_imagery'],
				'gmwfb_layers' => $data[0]['gmwfb_layers'],
				'gmwfb_turnoffpan' => $data[0]['gmwfb_turnoffpan'],
				'gmwfb_turnoffzoom' => $data[0]['gmwfb_turnoffzoom'],
				'gmwfb_turnoffmaptype' => $data[0]['gmwfb_turnoffmaptype'],
				'gmwfb_turnoffscale' => $data[0]['gmwfb_turnoffscale'],
				'gmwfb_turnoffstreetview' => $data[0]['gmwfb_turnoffstreetview'],
				'gmwfb_turnoffoverviewmap' => $data[0]['gmwfb_turnoffoverviewmap'],
				'gmwfb_streetview' => $data[0]['gmwfb_streetview']
			);
			
			$mapurl = "http://maps.google.com/?output=embed&amp;f=q&amp;";
			
			// “hl” stands for “host language”.
			if($hl <> "")
			{
				$mapurl = $mapurl . "hl=".$hl."&amp;";
			}
			
			// “geocode” is a concatination of “geocode” encoded values for waypoints used in directions.
			if($geocode <> "")
			{
				$mapurl = $mapurl . "geocode=".$geocode."&amp;";
			}
			
			// “q” stands for “query” and anything passed in this parameter is treated as if it had been typed into the query box on the maps.google.com page.
			if($form['gmwfb_address'] <> "")
			{
				$mapurl = $mapurl . "q=".$form['gmwfb_address']."&amp;";
			}
			
			// 	“ll” stands for Latitude,longitude of a Google Map center – Note that the order has to be latitude first, then longitude and it has to be in decimal format.
			if($form['gmwfb_latitude'] <> "" && $form['gmwfb_longitude'] <> "")
			{
				$mapurl = $mapurl . "ll=".$form['gmwfb_latitude'].",".$form['gmwfb_longitude']."&amp;";
			}
		
			// 	“layer” Activates overlay. Current option is “t” traffic.
			if($form['gmwfb_layers']  <> "")
			{
				if ($form['gmwfb_layers'] == "TrafficLayer")
				{
					$mapurl = $mapurl . "layer=t&amp;";
				}
				elseif($form['gmwfb_layers'] == "TransitLayer")
				{
					$mapurl = $mapurl . "layer=t&amp;";
				}
				elseif($form['gmwfb_layers'] == "BicyclingLayer")
				{
					$mapurl = $mapurl . "layer=t&amp;";
				}
				elseif($form['gmwfb_layers'] == "PanoramioLayer")
				{
					$mapurl = $mapurl . "layer=t&amp;";
				}
				else
				{
					$mapurl = $mapurl . "layer=t&amp;";
				}
			}
			
			// heading
			if($form['gmwfb_heading'] <> "")
			{
				$mapurl = $mapurl . "hq=".$form['gmwfb_heading']."&amp;";
			}
			
			// “radius” localizes results to a certain radius. Requires “sll” or similar center point to work.
			//$mapurl = $mapurl . "radius=15000&amp;";
			
			// “t” is Map Type. The available options are “m” map, “k” satellite, “h” hybrid, “p” terrain.
			if($form['gmwfb_maptype'] <> "")
			{
				if ($form['gmwfb_maptype'] == "ROADMAP")
				{
					$mapurl = $mapurl . "t=m&amp;";
				}
				elseif($form['gmwfb_maptype'] == "SATELLITE")
				{
					$mapurl = $mapurl . "t=k&amp;";
				}
				elseif($form['gmwfb_maptype'] == "HYBRID")
				{
					$mapurl = $mapurl . "t=h&amp;";
				}
				elseif($form['gmwfb_maptype'] == "TERRAIN")
				{
					$mapurl = $mapurl . "t=p&amp;";
				}
				else
				{
					$mapurl = $mapurl . "t=m&amp;";
				}
			}
			
			// 	“z” sets the zoom level.
			if($form['gmwfb_zoom'] <> "")
			{
				$mapurl = $mapurl . "z=".$form['gmwfb_zoom']."&amp;";
			}
			$mapid = "google-map-fb-popup".$form['gmwfb_id'];
			
			$gmwfb = "";
			$gmwfb = $gmwfb.'<script type="text/javascript"> ';
			$gmwfb = $gmwfb.' jQuery(document).ready(function() { ';
				$gmwfb = $gmwfb.' jQuery(".'.$mapid.'").fancybox({ ';
				$gmwfb = $gmwfb." 'width': '".$form['gmwfb_width']."', ";
				$gmwfb = $gmwfb." 'height': '".$form['gmwfb_height']."', ";
				$gmwfb = $gmwfb." 'transitionIn': 'fade', ";
				$gmwfb = $gmwfb." 'transitionOut': 'fade', ";
				$gmwfb = $gmwfb." 'autoScale': true, ";
				$gmwfb = $gmwfb." 'centerOnScroll': true, ";
				$gmwfb = $gmwfb." 'overlayColor': '#666', ";
				$gmwfb = $gmwfb." 'titleShow': true ";
				$gmwfb = $gmwfb." });";
			$gmwfb = $gmwfb." }); ";
			$gmwfb = $gmwfb."</script> ";
			$gmwfb = $gmwfb.'<a href="'.$mapurl.'" title="'.esc_html(stripslashes($form['gmwfb_message'])).'" class="'.$mapid.' iframe">';
			$gmwfb = $gmwfb.esc_html(stripslashes($form['gmwfb_heading']));
			$gmwfb = $gmwfb."</a>";
			return $gmwfb;
		}
	}
}
?>