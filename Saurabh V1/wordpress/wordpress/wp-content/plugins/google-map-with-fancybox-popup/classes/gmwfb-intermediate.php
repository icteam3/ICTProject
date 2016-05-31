<?php
class gmwfb_intermediate
{
	public static function gmwfb_admin()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(GMWFB_DIR.'page'.DIRECTORY_SEPARATOR.'gmwfb-add.php');
				break;
			case 'edit':
				require_once(GMWFB_DIR.'page'.DIRECTORY_SEPARATOR.'gmwfb-edit.php');
				break;
			default:
				require_once(GMWFB_DIR.'page'.DIRECTORY_SEPARATOR.'gmwfb-show.php');
				break;
		}
	}
}
?>