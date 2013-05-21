<?php
// Turn off all error reporting
error_reporting(0);

header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT' );
header('Cache-Control: no-cache, must-revalidate' );
header('Pragma: no-cache' );
header('Content-type: application/json; charset=utf-8');

// include wp loader
$root = realpath(dirname(dirname(dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// include plugin files
require_once ('../SygYouTube.php');
require_once ('../SygDao.php');
require_once ('../SygUtil.php');
require_once ('../SygValidate.php');

// construct objects
$dao = new SygDao();
$youtube = new SygYouTube();

$data = $_GET;
$response = array();

try {
	switch ($_GET['what']) {
		case 'style':
			$checkOptions = (bool) SygValidate::validateStyle(serialize($_GET));
			break;
		case 'gallery':
			$checkOptions = (bool) SygValidate::validateGallery(serialize($_GET));
			break;
		case 'settings':
			$checkOptions = (bool) SygValidate::validateSettings(serialize($_GET));
			break;
		default:
			NULL;
			break;
	}
} catch (SygValidateException $ex) {
	// set the error
	$response['exception'] = true;
	$response['exception_message'] = $ex->getMessage();
	$response['exception_detail'] = $ex->getProblems();
} catch (Exception $ex) {
	// set the error
	$response['exception'] = true;
	$response['exception_message'] = $ex->getMessage();
}

echo json_encode($response);
?>