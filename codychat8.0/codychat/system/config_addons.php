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

if(!isset($load_addons)){
	die();
}
define('BOOM_ADDONS', $load_addons);

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

$data = getUserSession($ident, $pass);

if(empty($data)){
	die();
}

if(!validSession()){
	die();
}

require("language/{$data['user_language']}/language.php");
date_default_timezone_set($data['user_timezone']);

$addons = addonsDetails(BOOM_ADDONS);
if(empty($addons)){
	die();
}
require(BOOM_PATH . "/addons/" . BOOM_ADDONS . "/system/addons_function.php");
require(addonsLang(BOOM_ADDONS));

if(isKicked($data) || isBanned($data) || isBot($data)){
	die();
}
?>