<?php
require('../config_session.php');

if(isset($_POST['take_action'], $_POST['target'])){
	$action = escape($_POST['take_action']);
	$target = escape($_POST['target'], true);

	if($action == 'unban'){
		echo unbanAccount($target);
		die();
	}
	else if($action == 'unmute'){
		echo unmuteAccount($target);
		die();
	}
	else if($action == 'unghost'){
		echo unghostAccount($target);
		die();
	}
	else if($action == 'main_unmute'){
		echo unmuteAccountMain($target);
		die();
	}
	else if($action == 'private_unmute'){
		echo unmuteAccountPrivate($target);
		die();
	}
	else if($action == 'room_unblock'){
		echo unblockRoom($target);
		die();
	}
	else if($action == 'room_unmute'){
		echo unmuteRoom($target);
		die();
	}
	else if($action == 'unkick'){
		echo unkickAccount($target);
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['kick'], $_POST['reason'], $_POST['delay'])){
	$target = escape($_POST['kick'], true);
	$reason = escape($_POST['reason']);
	$delay = escape($_POST['delay'], true);
	echo kickAccount($target, $delay, $reason);
	die();
}
if(isset($_POST['mute'], $_POST['reason'], $_POST['delay'])){
	$target = escape($_POST['mute'], true);
	$reason = escape($_POST['reason']);
	$delay = escape($_POST['delay'], true);
	echo muteAccount($target, $delay, $reason);
	die();
}
if(isset($_POST['ghost'], $_POST['reason'], $_POST['delay'])){
	$target = escape($_POST['ghost'], true);
	$reason = escape($_POST['reason']);
	$delay = escape($_POST['delay'], true);
	echo ghostAccount($target, $delay, $reason);
	die();
}
if(isset($_POST['main_mute'], $_POST['reason'], $_POST['delay'])){
	$target = escape($_POST['main_mute'], true);
	$reason = escape($_POST['reason']);
	$delay = escape($_POST['delay'], true);
	echo muteAccountMain($target, $delay, $reason);
	die();
}
if(isset($_POST['private_mute'], $_POST['reason'], $_POST['delay'])){
	$target = escape($_POST['private_mute'], true);
	$reason = escape($_POST['reason']);
	$delay = escape($_POST['delay'], true);
	echo muteAccountPrivate($target, $delay, $reason);
	die();
}
if(isset($_POST['room_mute'], $_POST['reason'], $_POST['delay'])){
	$target = escape($_POST['room_mute'], true);
	$reason = escape($_POST['reason']);
	$delay = escape($_POST['delay'], true);
	echo muteRoom($target, $delay, $reason);
	die();
}
if(isset($_POST['room_block'], $_POST['reason'], $_POST['delay'])){
	$target = escape($_POST['room_block'], true);
	$reason = escape($_POST['reason']);
	$delay = escape($_POST['delay'], true);
	echo blockRoom($target, $delay, $reason);
	die();
}
if(isset($_POST['ban'], $_POST['reason'])){
	$target = escape($_POST['ban'], true);
	$reason = escape($_POST['reason']);
	echo banAccount($target, $reason);
	die();
}
if(isset($_POST['warn'], $_POST['reason'])){
	$target = escape($_POST['warn'], true);
	$reason = escape($_POST['reason']);
	echo warnAccount($target, $reason);
	die();
}
if(isset($_POST['remove_room_staff'], $_POST['target'])){
	$target = escape($_POST['target'], true);
	echo removeRoomStaff($target);
	die();
}
?>