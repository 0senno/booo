<?php
session_start();
require("database.php");
require("controller.php");
require("function.php");
require("function_all.php");
require("function_admin.php");
require('function_sranking.php');
require('settings.php');

if(!checkToken()){
	die();
}

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(BOOM_DHOST, BOOM_DUSER, BOOM_DPASS, BOOM_DNAME);
if (mysqli_connect_errno()){
	die();
}

$pass = escape($_COOKIE[BOOM_PREFIX . 'utk']);
$ident = escape($_COOKIE[BOOM_PREFIX . 'userid'], true);

$get_data = $mysqli->query("SELECT * FROM boom_users WHERE user_id = '$ident' AND user_password = '$pass'");
if($get_data->num_rows > 0){
	$data = $get_data->fetch_assoc();
}
else {
	die();
}

if(!validSession()){
	die();
}

$setting = settingDetails();
require('redis.php');

require("language/{$data['user_language']}/language.php");
date_default_timezone_set($data['user_timezone']);

if(isKicked($data) || isBanned($data) || isBot($data)){
	die();
}
?>