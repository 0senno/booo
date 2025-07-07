<?php
require(__DIR__ . '/../config_session.php');

function unsetReport(){
	global $mysqli, $setting;
	$report = escape($_POST['unset_report'], true);
	$type = escape($_POST['type'], true);
	if(!canManageReport()){
		return 0;
	}

	$mysqli->query("DELETE FROM boom_report WHERE report_id = '$report' AND report_type = '$type'");
	updateStaffNotify();
	return 1;
}
function removeChatReport(){
	global $mysqli, $setting;
	$report = escape($_POST['report'], true);
	if(!canManageReport()){
		return 0;
	}
	
	$get_report = $mysqli->query("SELECT boom_report.*, boom_rooms.* FROM boom_report, boom_rooms WHERE report_id = '$report' AND report_type = 1 AND boom_rooms.room_id = boom_report.report_room LIMIT 1");
	if($get_report->num_rows > 0){
		$rep = $get_report->fetch_assoc();
		$mysqli->query("DELETE FROM boom_chat WHERE post_id = '{$rep['report_post']}'");
		if(!delExpired($rep['rltime'])){
			$mysqli->query("UPDATE boom_rooms SET rldelete = CONCAT(rldelete, ', '{$rep['report_post']}'), rltime = '" . time() . "' WHERE room_id = '{$rep['room_id']}'");
		}
		else {
			$mysqli->query("UPDATE boom_rooms SET rldelete = '{$rep['report_post']}', rltime = '" . time() . "' WHERE room_id = '{$rep['room_id']}'");
		}
		redisUpdateRoom($rep['room_id']);
	}
	$mysqli->query("DELETE FROM boom_report WHERE report_id = '$report' AND report_type = 1");
	updateStaffNotify();
	chatAction($rep['room_id']);
	return 1;
}
function removeWallReport(){
	global $mysqli, $data;
	$report = escape($_POST['report'], true);
	if(!canManageReport()){
		return 0;
	}
	$get_report = $mysqli->query("SELECT * FROM boom_report WHERE report_id = '$report' AND report_type = 2 LIMIT 1");
	if($get_report->num_rows > 0){
		$rep = $get_report->fetch_assoc();
		$mysqli->query("DELETE FROM boom_post WHERE `post_id` = '{$rep['report_post']}'");
		$mysqli->query("DELETE FROM `boom_post_reply` WHERE `parent_id` = '{$rep['report_post']}'");
		$mysqli->query("DELETE FROM `boom_notification` WHERE `notify_id` = '{$rep['report_post']}'");
		$mysqli->query("DELETE FROM `boom_post_like` WHERE `like_post` = '{$rep['report_post']}'");
		$mysqli->query("DELETE FROM boom_report WHERE report_post = '{$rep['report_post']}' AND report_type = 2");
	}
	$mysqli->query("DELETE FROM boom_report WHERE report_id = '$report' AND report_type = 2");
	updateStaffNotify();
	return 1;
}
function removeNewsReport(){
	global $mysqli, $data;
	$report = escape($_POST['report'], true);
	if(!canManageReport()){
		return 0;
	}
	$get_report = $mysqli->query("SELECT * FROM boom_report WHERE report_id = '$report' AND report_type = 5 LIMIT 1");
	if($get_report->num_rows > 0){
		$rep = $get_report->fetch_assoc();
		$mysqli->query("DELETE FROM boom_news WHERE `id` = '{$rep['report_post']}'");
		$mysqli->query("DELETE FROM `boom_news_reply` WHERE `parent_id` = '{$rep['report_post']}'");
		$mysqli->query("DELETE FROM `boom_news_like` WHERE `like_post` = '{$rep['report_post']}'");
		$mysqli->query("DELETE FROM boom_report WHERE report_post = '{$rep['report_post']}' AND report_type = 5");
	}
	$mysqli->query("DELETE FROM boom_report WHERE report_id = '$report' AND report_type = 5");
	updateStaffNotify();
	return 1;
}
function removePrivateReport(){
	global $mysqli, $data;
	$report = escape($_POST['report'], true);
	if(!canManageReport()){
		return 0;
	}
	$get_report = $mysqli->query("SELECT * FROM boom_report WHERE report_id = '$report' AND report_type = 3 LIMIT 1");
	if($get_report->num_rows > 0){
		$rep = $get_report->fetch_assoc();
		clearPrivate($rep['report_user'], $rep['report_target']);
	}
	$mysqli->query("DELETE FROM boom_report WHERE report_id = '$report' AND report_type = 3");
	updateStaffNotify();
	return 1;
}

// end of functions

if(isset($_POST['unset_report'], $_POST['type'])){
	echo unsetReport();
	die();
}
if(isset($_POST['remove_report'], $_POST['type'], $_POST['report'])){
	$type = escape($_POST['type'], true);
	if($type == 1){
		echo removeChatReport();
		die();
	}
	else if($type == 2){
		echo removeWallReport();
		die();
	}
	else if($type == 3){
		echo removePrivateReport();
		die();
	}
	else if($type == 5){
		echo removeNewsReport();
		die();
	}
	else {
		die();
	}
}
die();
?>