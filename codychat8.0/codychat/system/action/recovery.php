<?php
require('../config.php');

function sendAccountRecovery(){
	global $mysqli;
	$email = escape($_POST['remail']);
	if(!isEmail($email)){
		return 3;
	}
	$getuser = $mysqli->query("SELECT * FROM boom_users WHERE user_email = '$email' AND user_bot = 0 LIMIT 1");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
		return sendRecovery($user);
	}
	else {
		return 2;
	}
}
function accountRecovery(){
	global $mysqli, $setting;
	$pass = escape($_POST['rpass']);
	$repeat = escape($_POST['rrepeat']);
	$k = escape($_POST['rk']);
	$v = escape($_POST['rv']);
	$t = escape($_POST['rt']);
	
	if($pass == '' || $repeat == ''){
		return 5;
	}
	if(!validRecovery($k, $t, $v)){
		return 99;
	}
	if(!boomSame($pass, $repeat)){
		return 2;
	}
	if(!validPassword($pass)){
		return 3;
	}
	$get_recovery = $mysqli->query("SELECT * FROM boom_temp WHERE temp_key = '$k'");
	if($get_recovery->num_rows < 1){
		return 99;
	}
	$recovery = $get_recovery->fetch_assoc();
	if($recovery['temp_date'] != $t){
		return 99;
	}
	if($recovery['temp_date'] < tempTimer()){
		return 99;
	}
	$user = userDetails($recovery['temp_user']);
	if(empty($user)){
		return 99;
	}
	$new_pass = encrypt($pass);
	$mysqli->query("UPDATE boom_users SET user_password = '$new_pass' WHERE user_id = '{$user['user_id']}'");
	$mysqli->query("DELETE FROM boom_temp WHERE temp_user = '{$user['user_id']}'");
	return 1;
}

if (isset($_POST["remail"])){
	echo sendAccountRecovery();
	die();
}
if (isset($_POST["rpass"], $_POST['rrepeat'], $_POST['rk'], $_POST['rv'], $_POST['rt'])){
	echo accountRecovery();
	die();
}
else {
	echo 99;
	die();
}
?>