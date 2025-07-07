<?php
require("system/config.php");

$page_info = array(
	'page'=> 'rules',
	'page_out'=> 1,
);

// loading head tag element
include('control/head_load.php');

// load page header
include('control/header.php');

// load page content
echo boomTemplate('element/base_page_no_menu', boomTemplate('pages/rules/rules_container'));
echo boomTemplate('element/page_footer');

// close page body
include('control/body_end.php');
?>