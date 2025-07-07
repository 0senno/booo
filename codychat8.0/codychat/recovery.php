<?php
require("system/config.php");

$page_info = array(
	'page'=> 'recovery',
	'page_out'=> 1,
);

// loading head tag element
include('control/head_load.php');

// load page header
include('control/header.php');

// load page content
echo boomTemplate('element/base_page_no_menu', boomTemplate('pages/recovery/recovery'));
echo boomTemplate('element/page_footer');

include('control/body_end.php');
?>