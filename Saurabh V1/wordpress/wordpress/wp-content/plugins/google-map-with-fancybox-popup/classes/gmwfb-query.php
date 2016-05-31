<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class gmwfb_dbquery
{
	public static function gmwfb_count($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS `count` FROM `".$prefix."gmwfb_mapdetails` WHERE `gmwfb_id` = %d", array($id));
		}
		else
		{
			$sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."gmwfb_mapdetails`";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function gmwfb_select($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."gmwfb_mapdetails` where gmwfb_id = %d", array($id));
		}
		else
		{
			$sSql = "SELECT * FROM `".$prefix."gmwfb_mapdetails` order by gmwfb_id desc";
		}
		//echo $sSql;
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function gmwfb_delete($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("DELETE FROM `".$prefix."gmwfb_mapdetails` WHERE `gmwfb_id` = %d LIMIT 1", $id);
		$wpdb->query($sSql);
		return true;
	}
	
	public static function gmwfb_act($data = array(), $action = "ins")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		if($action == "ins")
		{
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."gmwfb_mapdetails` 
			(`gmwfb_heading`, `gmwfb_address`, `gmwfb_latitude`, `gmwfb_longitude`, `gmwfb_message`, `gmwfb_draggable`, `gmwfb_width`, 
			`gmwfb_height`, `gmwfb_zoom`, `gmwfb_maptype`, `gmwfb_turnoffscrolling`, `gmwfb_enablevisualrefresh`, `gmwfb_imagery`, 
			`gmwfb_layers`, `gmwfb_turnoffpan`, `gmwfb_turnoffzoom`, `gmwfb_turnoffmaptype`, `gmwfb_turnoffscale`, `gmwfb_turnoffstreetview`, 
			`gmwfb_turnoffoverviewmap`, `gmwfb_streetview`)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", 
			array($data["gmwfb_heading"], $data["gmwfb_address"], $data["gmwfb_latitude"], $data["gmwfb_longitude"], $data["gmwfb_message"], 
			$data["gmwfb_draggable"], $data["gmwfb_width"], $data["gmwfb_height"], $data["gmwfb_zoom"], $data["gmwfb_maptype"], 
			$data["gmwfb_turnoffscrolling"], $data["gmwfb_enablevisualrefresh"], $data["gmwfb_imagery"], $data["gmwfb_layers"], 
			$data["gmwfb_turnoffpan"], $data["gmwfb_turnoffzoom"], $data["gmwfb_turnoffmaptype"], $data["gmwfb_turnoffscale"], 
			$data["gmwfb_turnoffstreetview"], $data["gmwfb_turnoffoverviewmap"], $data["gmwfb_streetview"] ));
			$wpdb->query($sql);
			//echo $sql;
			return "sus";
		}
		elseif($action == "ups")
		{
			$sql = $wpdb->prepare("UPDATE `".$prefix."gmwfb_mapdetails` SET `gmwfb_heading` = %s, `gmwfb_address` = %s, 
			`gmwfb_latitude` = %s, `gmwfb_longitude` = %s, `gmwfb_message` = %s, `gmwfb_width` = %s, `gmwfb_height` = %s, 
			`gmwfb_zoom` = %s, `gmwfb_maptype` = %s, `gmwfb_layers` = %s WHERE gmwfb_id = %d LIMIT 1", 
			array($data["gmwfb_heading"], $data["gmwfb_address"], $data["gmwfb_latitude"], $data["gmwfb_longitude"], 
			$data["gmwfb_message"], $data["gmwfb_width"], $data["gmwfb_height"], $data["gmwfb_zoom"], 
			$data["gmwfb_maptype"], $data["gmwfb_layers"], $data["gmwfb_id"]));
			$wpdb->query($sql);
			return "sus";
		}
		else
		{
			return "err";
		}
	}
	
	public static function gmwfb_default()
	{
		$form = array();
		$form['gmwfb_heading'] = 'Singapore flyer';
		$form['gmwfb_address'] = 'Singapore flyer';
		$form['gmwfb_latitude'] = '1.2892783';
		$form['gmwfb_longitude'] = '103.86313889999997';
		$form['gmwfb_message'] = 'Singapore flyer';
		$form['gmwfb_width'] = '75%';
		$form['gmwfb_height'] = '75%';
		$form['gmwfb_zoom'] = '15';
		$form['gmwfb_maptype'] = 'ROADMAP';
		$form['gmwfb_turnoffscrolling'] = '';
		$form['gmwfb_enablevisualrefresh'] = '';
		$form['gmwfb_imagery'] = '';
		$form['gmwfb_draggable'] = '';
		$form['gmwfb_layers'] = 'TrafficLayer';
		$form['gmwfb_turnoffpan'] = '';
		$form['gmwfb_turnoffzoom'] = '';
		$form['gmwfb_turnoffmaptype'] = '';
		$form['gmwfb_turnoffscale'] = '';
		$form['gmwfb_turnoffstreetview'] = '';
		$form['gmwfb_turnoffoverviewmap'] = '';
		$form['gmwfb_streetview'] = '';
		gmwfb_dbquery::gmwfb_act($form, "ins");
		return true;
	}
}
?>