<?php 

ini_set('display_errors', 0);

header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: application/json");

// include wp loader
$root = realpath(dirname(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"])))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once ('../SygPlugin.php');
require_once ('../SygConstant.php');
require_once ('../SygDao.php');
require_once ('../SygGallery.php');
require_once ('../SygUtil.php');

$plugin = SygPlugin::getInstance();
if ($plugin->verifyAuthToken($_SESSION['request_token'])) {
	if($_GET['page_number']) {
		$page_number = $_GET['page_number'];
		$current_page = $page_number;
		$page_number -= 1;
			
		$per_page = SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED; // Per page records
			
		$previous_btn = true;
		$next_btn = true;
		$first_btn = true;
		$last_btn = true;
			
		$start = $page_number * $per_page;
			
		$dao = new SygDao();
		$galleries = $dao->getAllSyg('OBJECT', $start, $per_page);
		
		$gallery_to_json = array();	
		
		foreach ($galleries as $gallery) {
			/*$gallery->setUserProfile ($youtube_service->getUserProfile($gallery->getYtUsername()));
			var_dump ($gallery->getUserProfile()->getThumbnail()->getUrl());
			die();*/
			array_push($gallery_to_json, $gallery->getJsonData());
		}
		
		echo json_encode ($gallery_to_json);
		die();
		
		// $this->render('pagination');
			
		/* -----Total count--- */
		/*$query_pag_num = "SELECT COUNT(*) AS count FROM messages"; // Total records
		 $result_pag_num = mysql_query($query_pag_num);
		$row = mysql_fetch_array($result_pag_num);
		$count = $row['count'];
			
		$no_of_paginations = ceil($count / $per_page);
		/* -----Calculating the starting and endign values for the loop----- */
	}
}
?>