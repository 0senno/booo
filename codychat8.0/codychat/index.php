<?php
$page_info = array(
	'page'=> 'home',
	'page_nohome'=> 1,
);
require("system/config.php");

if($chat_install != 1){
	include('builder/encoded/installer.php');
	die();
}

// loading head tag element
include('control/head_load.php');

// loading page content
$data['user_roomid'] = getRoomId();
if($data['user_roomid'] > 0){
	include('control/chat.php');
}
else {
	include('control/lobby.php');
}

// close page body
include('control/body_end.php');
?>