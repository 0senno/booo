<?php
require('../config_session.php');

if(isset($_POST['logout_from_system'])){
	clearUserSession();
	$mysqli->query("UPDATE `boom_users` SET `user_roomid` = '0', user_move = '" . time() . "', user_role = '0' WHERE `user_id` = '{$data["user_id"]}'");
	if(isGuest($data)){
		softGuestDelete($data);
	}
	redisUpdateUser($data['user_id']);
	echo 1;
	die();	
}
if(isset($_POST['overwrite'])){
	clearUserSession();
	redisUpdateUser($data['user_id']);
	die();
}
if(isset($_POST['other_logout'])){
	updateUserSession($data, true);
	redisUpdateUser($data['user_id']);
	echo 1;
	die();
}
?>