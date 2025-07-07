<?php
require('../config_out.php');

function kickStatus(){
	global $mysqli, $data;
	if(!isKicked($data)){
		if($data['user_kick'] > 0){
			$mysqli->query("UPDATE boom_users SET user_kick = 0 WHERE user_id = '{$data['user_id']}'");
			redisUpdateUser($data['user_id']);
		}
		return 1;
	}
	return 0;
}
function maintenanceStatus(){
	global $setting;
	if($setting['maint_mode'] == 0){
		return 1;
	}
	return 0;
}


if(isset($_POST['check_kick'])){
	echo kickStatus();
	die();
}
if(isset($_POST['check_maintenance'])){
	echo maintenanceStatus();
	die();
}
?>