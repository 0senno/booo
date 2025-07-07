<?php
require('../config_admin.php');

if(!boomAllow(100)){
	die();
}

function reloadCall(){
	return listAdminCall();
}
function reloadGroupCall(){
	return listAdminGroupCall();
}
function adminCancelCall(){
	global $mysqli, $setting, $data;
	$id = escape($_POST['admin_cancel'], true);
	$call = callDetails($id);
	if(empty($call)){
		return 0;
	}
	endCall($call, 8);
	$call['call_status'] = 2;
	return boomTemplate('element/admin_call', $call);
}

if(isset($_POST['admin_cancel'])){
	echo adminCancelCall();
	die();
}
if(isset($_POST['reload_call'])){
	echo reloadCall();
	die();
}
if(isset($_POST['reload_group_call'])){
	echo reloadGroupCall();
	die();
}
?>