<?php

// set header type
header('Content-type: text/css');

// include wp loader
$root = realpath(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"]))))));

if (file_exists($root.'/wp-load.php')) {
    // WP 2.6
    require_once($root.'/wp-load.php');
} else {
    // Before 2.6
    require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( SYG_PATH . 'engine/SygPlugin.php');
require_once( SYG_PATH . 'engine/SygUtil.php');

$syg = SygPlugin::getInstance();
$id = $_GET['id'];
$option = $syg->getGallerySettings($id);

extract ($option);
$pluginOpt = $syg->getOptions();
extract ($pluginOpt);

$heightRatio = ceil($syg_thumbnail_height*2.8);

$jollyColor = SygUtil::getJollyColor($syg_thumbnail_bordercolor, $syg_description_fontcolor);

if (!empty($_GET['params'])) {
    $params = $_GET['params'];

    parse_str(str_replace("|", "&", $params), $params);

    // extract dynamic css
    extract($params);
}
?>
