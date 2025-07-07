<?php
session_start();
require("database.php");
require("controller.php");
require("function.php");
require('function_sranking.php');
require('settings.php');
require('redis.php');

if(checkRateLimit()){
	die();
}

if(!checkToken()){
	echo json_encode( array("check" => 99));
	die();
}
$mysqli = @new mysqli(BOOM_DHOST, BOOM_DUSER, BOOM_DPASS, BOOM_DNAME);
if (mysqli_connect_errno()){
	echo json_encode( array("check" => 199));
	die();
}
$pass = escape($_COOKIE[BOOM_PREFIX . 'utk']);
$ident = escape($_COOKIE[BOOM_PREFIX . 'userid'], true);
	
$data = getUserChatSession($ident, $pass);
if(empty($data)){
	echo json_encode( array("check" => 99));
	die();
}

if(!validSession()){
	echo json_encode( array("check" => 99));
	die();
}

$room = roomDetails($data['user_roomid']);
if(empty($room)){
	echo json_encode( array("check" => 99));
	die();
}

require("language/{$data['user_language']}/language.php");
date_default_timezone_set($data['user_timezone']);
if(isKicked($data) || isBanned($data)){
	echo json_encode( array("check" => 99));
	die();
}
session_write_close();
?>