<?php
require("database.php");
require("controller.php");
require("function.php");
require("function_all.php");
require('function_sranking.php');
require('settings.php');
require('redis.php');

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(BOOM_DHOST, BOOM_DUSER, BOOM_DPASS, BOOM_DNAME);
if (mysqli_connect_errno()){
	die();
}
if(isset($load_addons)){
	define('BOOM_ADDONS', $load_addons);
	$addons = addonsDetails(BOOM_ADDONS);
	if(empty($addons)){
		die();
	}
}

require("language/{$setting['language']}/language.php");
date_default_timezone_set($setting['timezone']);
if(isset($load_addons)){
	require(BOOM_PATH . "/addons/" . BOOM_ADDONS . "/system/addons_function.php");
	require(addonsLangCron(BOOM_ADDONS));
}
?>