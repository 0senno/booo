<?php
require(__DIR__ . '/../config_session.php');

function addUserDj(){
	global $mysqli, $setting, $data;
	$target = escape($_POST['add_dj']);
	$user = userNameDetails($target);
	if(empty($user)){
		return boomCode(3);
	}
	if(userDj($user)){
		return boomCode(4);
	}
	if(canEditUser($user, $setting['can_dj'], 1) || canManageDj() && mySelf($user['user_id'])){
		$mysqli->query("UPDATE boom_users SET user_dj = 1 WHERE user_id = '{$user['user_id']}'");
		$user['user_dj'] = 1;
		redisUpdateUser($user['user_id']);
		return boomCode(1, array('data'=> boomTemplate('element/admin_dj', $user)));
	}
	else {
		return boomCode(2);
	}
}
function removeUserDj(){
	global $mysqli, $setting, $data;
	$target = escape($_POST['remove_dj'], true);
	$user = userDetails($target);
	if(empty($user)){
		return 3;
	}
	if(canEditUser($user, $setting['can_dj'], 1) || canManageDj() && mySelf($user['user_id'])){
		$mysqli->query("UPDATE boom_users SET user_dj = 0, user_onair = 0 WHERE user_id = '{$user['user_id']}'");
		redisUpdateUser($user['user_id']);
		return 1;
	}
	else {
		return 2;
	}
}

function setUserOnAir(){
	global $mysqli, $setting, $data;
	$id = escape($_POST['admin_onair'], true);
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(canManageDj() && canEditUser($user, $setting['can_dj']) && userDj($user)){
		if(isOnAir($user)){
			$mysqli->query("UPDATE boom_users SET user_onair = '0' WHERE user_id = '{$user['user_id']}'");
			redisUpdateUser($user['user_id']);
			return 0;
		}
		else {
			$mysqli->query("UPDATE boom_users SET user_onair = '1' WHERE user_id = '{$user['user_id']}'");
			redisUpdateUser($user['user_id']);
			return 1;
		}
	}
	else {
		return 2;
	}
}
function setOnAir(){
	global $mysqli, $data;
	$onair = escape($_POST['user_onair'], true);
	if(!userDj($data)){
		return 0;
	}
	$mysqli->query("UPDATE boom_users SET user_onair = '$onair' WHERE user_id = '{$data['user_id']}'");
	redisUpdateUser($data['user_id']);
	return 1;
}	

// end of functions

if(isset($_POST["admin_onair"])){
	echo setUserOnAir();
	die();
}
if(isset($_POST["user_onair"])){
	echo setOnAir();
	die();
}
if(isset($_POST["add_dj"])){
	echo addUserDj();
	die();
}
if(isset($_POST['remove_dj'])){
	echo removeUserDj();
	die();
}
die();
?>