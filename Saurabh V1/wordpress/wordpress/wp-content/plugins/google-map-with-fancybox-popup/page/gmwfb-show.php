<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'gmwfb-show-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_gmwfb_display']) && $_POST['frm_gmwfb_display'] == 'yes')
{
	$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$gmwfb_success = '';
	$gmwfb_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = gmwfb_dbquery::gmwfb_count($did);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'google-map-with-fancybox-popup'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('gmwfb_form_show');
			
			//	Delete selected record from the table
			gmwfb_dbquery::gmwfb_delete($did);
			
			//	Set success message
			$gmwfb_success_msg = TRUE;
			$gmwfb_success = __('Selected record was successfully deleted.', 'google-map-with-fancybox-popup');
		}
	}
	
	if ($gmwfb_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $gmwfb_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(GMWFB_PLUGIN_DISPLAY, 'google-map-with-fancybox-popup'); ?>
	<a class="add-new-h2" href="<?php echo GMWFB_ADMINURL; ?>&ac=add"><?php _e('Add New', 'google-map-with-fancybox-popup'); ?></a></h2>
    <div class="tool-box">
	<?php
		$myData = array();
		$myData = gmwfb_dbquery::gmwfb_select(0);
		?>
		<script language="JavaScript" src="<?php echo GMWFB_URL; ?>page/gmwfb-setting.js"></script>
		<form name="frm_gmwfb_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('Map Id', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Heading', 'google-map-with-fancybox-popup'); ?></th>
            <th scope="col"><?php _e('Short Code', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Latitude', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Longitude', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Width', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Height', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Map Type', 'google-map-with-fancybox-popup'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('Map Id', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Heading', 'google-map-with-fancybox-popup'); ?></th>
            <th scope="col"><?php _e('Short Code', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Latitude', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Longitude', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Width', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Height', 'google-map-with-fancybox-popup'); ?></th>
			<th scope="col"><?php _e('Map Type', 'google-map-with-fancybox-popup'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td><?php echo $data['gmwfb_id']; ?></td>
						<td><?php echo esc_html(stripslashes($data['gmwfb_heading'])); ?>
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo GMWFB_ADMINURL; ?>&ac=edit&amp;did=<?php echo $data['gmwfb_id']; ?>"><?php _e('Edit', 'google-map-with-fancybox-popup'); ?></a> | </span>
						<span class="trash">
						<a onClick="javascript:_gmwfb_delete('<?php echo $data['gmwfb_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'google-map-with-fancybox-popup'); ?></a></span> 
						</div>
						</td>
						<td>[google-map-fb-popup id="<?php echo $data['gmwfb_id']; ?>"]</td>
						<td><?php echo $data['gmwfb_latitude']; ?></td>
						<td><?php echo $data['gmwfb_longitude']; ?></td>
						<td><?php echo $data['gmwfb_width']; ?></td>
						<td><?php echo $data['gmwfb_height']; ?></td>
						<td><?php echo $data['gmwfb_maptype']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="8" align="center"><?php _e('No records available.', 'google-map-with-fancybox-popup'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('gmwfb_form_show'); ?>
		<input type="hidden" name="frm_gmwfb_display" value="yes"/>
		<input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'gmwfb-show-nonce' ); ?>"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo GMWFB_ADMINURL; ?>&amp;ac=add"><?php _e('Add New', 'google-map-with-fancybox-popup'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo GMWFB_FAV; ?>"><?php _e('Help', 'google-map-with-fancybox-popup'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<p class="description"><?php echo GMWFB_OFFICIAL; ?></p>
	</div>
</div>