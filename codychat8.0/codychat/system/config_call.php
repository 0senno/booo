<?php
session_start();
require("database.php");
require("controller.php");
require("function.php");
require("function_all.php");
require('function_sranking.php');
require('settings.php');
require('redis.php');

if(checkRateLimit()){
	die();
}

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(BOOM_DHOST, BOOM_DUSER, BOOM_DPASS, BOOM_DNAME);
if (mysqli_connect_errno() || BOOM_INSTALL != 1) {
	die();
}
else{
	if(isset($_COOKIE[BOOM_PREFIX . 'userid'], $_COOKIE[BOOM_PREFIX . 'utk'])){
		$ident = escape($_COOKIE[BOOM_PREFIX . 'userid'], true);
		$pass = escape($_COOKIE[BOOM_PREFIX . 'utk']);
		$data = getUserSession($ident, $pass);
		if(empty($data)){
			die();
		}
	}
	else {
		die();
	}
	define('BOOM_LANG', getLanguage());
	require("language/" . BOOM_LANG . "/language.php");
}
date_default_timezone_set("{$setting['timezone']}");

?>