<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'gmwfb-edit-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = '0';
$result = gmwfb_dbquery::gmwfb_count($did);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'google-map-with-fancybox-popup'); ?></strong></p></div><?php
}
else
{
	$gmwfb_errors = array();
	$gmwfb_success = '';
	$gmwfb_error_found = FALSE;
	
	$data = array();
	$data = gmwfb_dbquery::gmwfb_select($did);
	
	// Preset the form fields
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
}
// Form submitted, check the data
if (isset($_POST['gmwfb_form_submit']) && $_POST['gmwfb_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('gmwfb_form_add');
	
	$form['gmwfb_heading'] = isset($_POST['gmwfb_heading']) ? sanitize_text_field($_POST['gmwfb_heading']) : '';
	if ($form['gmwfb_heading'] == '')
	{
		$gmwfb_errors[] = __('Enter heading for your google map.', 'google-map-with-fancybox-popup');
		$gmwfb_error_found = TRUE;
	}
	
	$form['gmwfb_address'] = isset($_POST['googlemap_address']) ? sanitize_text_field($_POST['googlemap_address']) : '';
	if ($form['gmwfb_address'] == '')
	{
		$gmwfb_errors[] = __('Enter map address. Google auto suggest helps you to choose one.', 'google-map-with-fancybox-popup');
		$gmwfb_error_found = TRUE;
	}

	$form['gmwfb_latitude'] = isset($_POST['googlemap_latitude']) ? sanitize_text_field($_POST['googlemap_latitude']) : '';
	if ($form['gmwfb_latitude'] == '')
	{
		$gmwfb_errors[] = __('Enter map latitude (Or) Click Geocode button to get latitude.', 'google-map-with-fancybox-popup');
		$gmwfb_error_found = TRUE;
	}
	
	$form['gmwfb_longitude'] = isset($_POST['googlemap_longitude']) ? sanitize_text_field($_POST['googlemap_longitude']) : '';
	if ($form['gmwfb_longitude'] == '')
	{
		$gmwfb_errors[] = __('Enter map longitude (Or) Click Geocode button to get longitude.', 'google-map-with-fancybox-popup');
		$gmwfb_error_found = TRUE;
	}
	
	$form['gmwfb_message'] = isset($_POST['gmwfb_message']) ? sanitize_text_field($_POST['gmwfb_message']) : '';
	$form['gmwfb_width'] = isset($_POST['gmwfb_width']) ? sanitize_text_field($_POST['gmwfb_width']) : '';
	$form['gmwfb_height'] = isset($_POST['gmwfb_height']) ? sanitize_text_field($_POST['gmwfb_height']) : '';
	$form['gmwfb_zoom'] = isset($_POST['gmwfb_zoom']) ? sanitize_text_field($_POST['gmwfb_zoom']) : '';
	$form['gmwfb_maptype'] = isset($_POST['gmwfb_maptype']) ? sanitize_text_field($_POST['gmwfb_maptype']) : '';
	$form['gmwfb_turnoffscrolling'] = '';
	$form['gmwfb_enablevisualrefresh'] = '';
	$form['gmwfb_imagery'] = '';
	$form['gmwfb_draggable'] = '';
	$form['gmwfb_layers'] = isset($_POST['gmwfb_layers']) ? sanitize_text_field($_POST['gmwfb_layers']) : '';
	$form['gmwfb_turnoffpan'] = '';
	$form['gmwfb_turnoffzoom'] = '';
	$form['gmwfb_turnoffmaptype'] = '';
	$form['gmwfb_turnoffscale'] = '';
	$form['gmwfb_turnoffstreetview'] = '';
	$form['gmwfb_turnoffoverviewmap'] = '';
	$form['gmwfb_streetview'] = '';
	$form['gmwfb_id'] = isset($_POST['gmwfb_id']) ? sanitize_text_field($_POST['gmwfb_id']) : '';;

	//	No errors found, we can add this Group to the table
	if ($gmwfb_error_found == FALSE)
	{	
		$action = gmwfb_dbquery::gmwfb_act($form, "ups");
		if($action == "sus")
		{
			$gmwfb_success = __('Details was successfully updated.', 'google-map-with-fancybox-popup');
		}
		elseif($action == "err")
		{
			$gmwfb_success = __('Oops unexpected error occurred.', 'google-map-with-fancybox-popup');
			$gmwfb_error_found = TRUE;
		}
	}
}

if ($gmwfb_error_found == TRUE && isset($gmwfb_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $gmwfb_errors[0]; ?></strong></p></div><?php
}
if ($gmwfb_error_found == FALSE && strlen($gmwfb_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $gmwfb_success; ?> 
		<a href="<?php echo GMWFB_ADMINURL; ?>"><?php _e('Click here', 'google-map-with-fancybox-popup'); ?></a> 
		<?php _e('to view the details', 'google-map-with-fancybox-popup'); ?></strong></p>
	</div>
	<?php
}

$googlemap_address = isset($_POST['googlemap_address']) ? $_POST['googlemap_address'] : $form['gmwfb_address'];
$googlemap_latitude = isset($_POST['googlemap_address']) ? $_POST['googlemap_latitude'] : $form['gmwfb_latitude'];
$googlemap_longitude = isset($_POST['googlemap_longitude']) ? $_POST['googlemap_longitude'] : $form['gmwfb_longitude'];
?>
<script language="JavaScript" src="<?php echo GMWFB_URL; ?>page/gmwfb-setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(GMWFB_PLUGIN_DISPLAY, 'google-map-with-fancybox-popup'); ?></h2>
	<form name="gmwfb_form" method="post" action="#" onsubmit="return _gmwfb_submit()"  >
      <h3><?php _e('Add details', 'google-map-with-fancybox-popup'); ?></h3>
      
	  	<label for="tag"><?php _e('Location Heading', 'google-map-with-fancybox-popup'); ?></label>
		<input name="gmwfb_heading" type="text" id="gmwfb_heading" value="<?php echo esc_html(stripslashes($form['gmwfb_heading'])); ?>" size="70" maxlength="255" />
		<p><?php _e('Enter heading for your google map.', 'google-map-with-fancybox-popup'); ?></p>
		
		<label for="tag"><?php _e('Map Address', 'google-map-with-fancybox-popup'); ?></label>
		<input type="text" name="googlemap_address" id="googlemap_address" size="60" value="<?php echo esc_html(stripslashes($googlemap_address)); ?>" />
		<input type="button" value="<?php _e('Geocode', 'wpgmp_google_map')?>" onclick="geocodeaddress()" class="btn btn-sm btn-primary">
		<p><?php _e('Enter the map address. Google auto suggest helps you to choose one.', 'google-map-with-fancybox-popup'); ?></p>
		
		<input type="text" name="googlemap_latitude" id="googlemap_latitude" placeholder="<?php _e('Latitude', 'google-map-with-fancybox-popup')?>"  value="<?php echo $googlemap_latitude; ?>" />
		<input type="text" name="googlemap_longitude" id="googlemap_longitude" placeholder="<?php _e('Longitude', 'google-map-with-fancybox-popup')?>"   value="<?php echo $googlemap_longitude; ?>" />
		<div id="map" style="width:100%; height: 400px;margin: 0.6em;"></div>
		<p><?php _e('Enter the location latitude. ', 'google-map-with-fancybox-popup'); ?></p>
		
		<label for="tag"><?php _e('Short Message', 'google-map-with-fancybox-popup'); ?></label>
		<input name="gmwfb_message" type="text" id="gmwfb_message" value="<?php echo esc_html(stripslashes($form['gmwfb_message'])); ?>" size="40" maxlength="255" />
		<p><?php _e('Enter short message for this address.', 'google-map-with-fancybox-popup'); ?></p>

		<label for="tag-a"><?php _e('Width', 'google-map-with-fancybox-popup'); ?></label>
		<select name="gmwfb_width" id="gmwfb_width">
			<option value='30%' <?php if($form['gmwfb_width'] == '30%') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35%' <?php if($form['gmwfb_width'] == '35%') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40%' <?php if($form['gmwfb_width'] == '40%') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45%' <?php if($form['gmwfb_width'] == '45%') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50%' <?php if($form['gmwfb_width'] == '50%') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55%' <?php if($form['gmwfb_width'] == '55%') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60%' <?php if($form['gmwfb_width'] == '60%') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65%' <?php if($form['gmwfb_width'] == '65%') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70%' <?php if($form['gmwfb_width'] == '70%') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75%' <?php if($form['gmwfb_width'] == '75%') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80%' <?php if($form['gmwfb_width'] == '80%') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85%' <?php if($form['gmwfb_width'] == '85%') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90%' <?php if($form['gmwfb_width'] == '90%') { echo "selected='selected'" ; } ?>>90%</option>
		</select>
		<p><?php _e('Select your width percentage for the map.', 'google-map-with-fancybox-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Height', 'google-map-with-fancybox-popup'); ?></label>
		<select name="gmwfb_height" id="gmwfb_height">
			<option value='30%' <?php if($form['gmwfb_height'] == '30%') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35%' <?php if($form['gmwfb_height'] == '35%') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40%' <?php if($form['gmwfb_height'] == '40%') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45%' <?php if($form['gmwfb_height'] == '45%') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50%' <?php if($form['gmwfb_height'] == '50%') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55%' <?php if($form['gmwfb_height'] == '55%') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60%' <?php if($form['gmwfb_height'] == '60%') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65%' <?php if($form['gmwfb_height'] == '65%') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70%' <?php if($form['gmwfb_height'] == '70%') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75%' <?php if($form['gmwfb_height'] == '75%') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80%' <?php if($form['gmwfb_height'] == '80%') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85%' <?php if($form['gmwfb_height'] == '85%') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90%' <?php if($form['gmwfb_height'] == '90%') { echo "selected='selected'" ; } ?>>90%</option>
		</select>
		<p><?php _e('Select your height percentage for the map.', 'google-map-with-fancybox-popup'); ?></p>

		<label for="tag-a"><?php _e('Map Zoom Level', 'google-map-with-fancybox-popup'); ?></label>
		<select name="gmwfb_zoom" id="gmwfb_zoom">
			<?php
			$thisselected = "";
			for($i=18; $i > 1; $i--)
			{
				if($i == $form['gmwfb_zoom']) 
				{ 
					$thisselected = "selected='selected'" ; 
				}
				?>
				<option value='<?php echo $i; ?>' <?php echo $thisselected; ?>><?php echo $i; ?></option>
				<?php
				$thisselected = "";
			}
			?>
		</select>
		<p><?php _e('Select your zoom level for the map.', 'google-map-with-fancybox-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Map Type', 'google-map-with-fancybox-popup'); ?></label>
		<select name="gmwfb_maptype" id="gmwfb_maptype">
			<option value='ROADMAP' <?php if($form['gmwfb_maptype']=='ROADMAP') { echo 'selected' ; } ?>>ROADMAP</option>
			<option value='SATELLITE' <?php if($form['gmwfb_maptype']=='SATELLITE') { echo 'selected' ; } ?>>SATELLITE</option>
			<option value='HYBRID' <?php if($form['gmwfb_maptype']=='HYBRID') { echo 'selected' ; } ?>>HYBRID</option>
			<option value='TERRAIN' <?php if($form['gmwfb_maptype']=='TERRAIN') { echo 'selected' ; } ?>>TERRAIN</option>
		</select>
		<p><?php _e('Select your map type for the map.', 'google-map-with-fancybox-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Select Layers', 'google-map-with-fancybox-popup'); ?></label>
		<select name="gmwfb_layers" id="gmwfb_layers">
			<option value='TrafficLayer' <?php if($form['gmwfb_layers']=='TrafficLayer') { echo 'selected' ; } ?>>Traffic Layers</option>
			<option value='TransitLayer' <?php if($form['gmwfb_layers']=='TransitLayer') { echo 'selected' ; } ?>>Transit Layers</option>
			<option value='BicyclingLayer' <?php if($form['gmwfb_layers']=='BicyclingLayer') { echo 'selected' ; } ?>>Bicycling Layers</option>
			<option value='PanoramioLayer' <?php if($form['gmwfb_layers']=='PanoramioLayer') { echo 'selected' ; } ?>>Panoramio Layers</option>
		</select>
		<p><?php _e('Select layer for the map.', 'google-map-with-fancybox-popup'); ?></p>
		
      <input name="gmwfb_id" id="gmwfb_id" type="hidden" value="<?php echo $form['gmwfb_id']; ?>">
      <input type="hidden" name="gmwfb_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', 'google-map-with-fancybox-popup'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_gmwfb_redirect()" value="<?php _e('Cancel', 'google-map-with-fancybox-popup'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_gmwfb_help()" value="<?php _e('Help', 'google-map-with-fancybox-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('gmwfb_form_add'); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'gmwfb-edit-nonce' ); ?>"/>
    </form>
</div>
<p class="description"><?php echo GMWFB_OFFICIAL; ?></p>
</div>