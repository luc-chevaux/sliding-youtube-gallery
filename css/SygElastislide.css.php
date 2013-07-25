<?php
require_once('./inc/cssIf.php');
?>

a.sygVideo-<?php echo $id; ?> {
    display: block;
    position:relative;
    text-decoration: none;
}

img.elastislide-img-item {
    box-shadow: none !important;
}

span.video_duration-<?php echo $id; ?> {
    border: 0;
    display: block;
    visibility:visible;
    position:absolute;
    right: 6%;
    bottom: 8%;
    line-height: 1;
    margin: 0;
    width: auto;
    padding: 3px;
    color: white;
    background-color: #000;
}