<?php
require(__DIR__ . '/../config_session.php');
require(__DIR__ . '/gen.php');

function makeWallReport(){
	global $mysqli, $data;
	if(!canSendReport()){
		return 3;
	}
	$post = escape($_POST['report'], true);
	$reason = escape($_POST['reason'], true);
	if(!validReport($reason)){
		return 5;
	}
	if(!canPostAction($post)){
		return 0;
	}
	$check_report = $mysqli->query("SELECT * FROM boom_report WHERE report_post = '$post' AND report_type = 2");
	if($check_report->num_rows > 0){
		return 1;
	}
	else {
		$valid_post = $mysqli->query("SELECT post_id, post_user FROM boom_post WHERE post_id = '$post'");
		if($valid_post->num_rows > 0){
			$wall = $valid_post->fetch_assoc();
			$mysqli->query("INSERT INTO boom_report (report_type, report_user, report_target, report_post, report_reason, report_date, report_room) VALUES (2, '{$data['user_id']}', '{$wall['post_user']}', '$post', '$reason', '" . time() . "', 0)");
			updateStaffNotify();
			return 1;
		}
		else {
			return 0;
		}
	}
}
function makeNewsReport(){
	global $mysqli, $data;
	if(!canSendReport()){
		return 3;
	}
	$post = escape($_POST['report'], true);
	$reason = escape($_POST['reason'], true);
	if(!validReport($reason)){
		return 5;
	}
	$check_report = $mysqli->query("SELECT * FROM boom_report WHERE report_post = '$post' AND report_type = 5");
	if($check_report->num_rows > 0){
		return 1;
	}
	else {
		$valid_post = $mysqli->query("SELECT id, news_poster FROM boom_news WHERE id = '$post'");
		if($valid_post->num_rows > 0){
			$news = $valid_post->fetch_assoc();
			$mysqli->query("INSERT INTO boom_report (report_type, report_user, report_target, report_post, report_reason, report_date, report_room) VALUES (5, '{$data['user_id']}', '{$news['news_poster']}', '$post', '$reason', '" . time() . "', 0)");
			updateStaffNotify();
			return 1;
		}
		else {
			return 0;
		}
	}
}
function makeChatReport(){
	global $mysqli, $data;
	if(!canSendReport()){
		return 3;
	}
	$post = escape($_POST['report'], true);
	$reason = escape($_POST['reason'], true);
	if(!validReport($reason)){
		return 5;
	}
	$check_report = $mysqli->query("SELECT * FROM boom_report WHERE report_post = '$post' AND report_type = 1");
	if($check_report->num_rows > 0){
		return 1;
	}
	else {
		$log = logDetails($post);
		if(!empty($log)){
			$mysqli->query("INSERT INTO boom_report (report_type, report_user, report_target, report_post, report_reason, report_date, report_room) VALUES (1, '{$data['user_id']}', '{$log['user_id']}', '$post', '$reason', '" . time() . "', '{$data['user_roomid']}')");
			updateStaffNotify();
			return 1;
		}
		else {
			return 0;
		}
	}
}
function makeProfileReport(){
	global $mysqli, $data;
	if(!canSendReport()){
		return 3;
	}
	$id = escape($_POST['report'], true);
	$reason = escape($_POST['reason'], true);
	if(mySelf($id)){
		return 3;
	}
	if(!validReport($reason)){
		return 5;
	}
	$check_report = $mysqli->query("SELECT * FROM boom_report WHERE report_target = '$id' AND report_type = 4");
	if($check_report->num_rows > 0){
		return 1;
	}
	$user = userDetails($id);
	if(empty($user)){
		return 0;
	}
	if(isBot($user)){
		return 3;
	}
	$mysqli->query("INSERT INTO boom_report (report_type, report_user, report_target, report_reason, report_date) VALUES (4, '{$data['user_id']}', '{$user['user_id']}', '$reason', '" . time() . "')");
	updateStaffNotify();
	return 1;
}
function makePrivateReport(){
	global $mysqli, $data;
	
	$target = escape($_POST['report'], true);
	$reason = escape($_POST['reason'], true);

	if(!canSendReport()){
		return 3;
	}
	$user = userDetails($target);
	if(empty($user)){
		return 0;
	}
	if(!validReport($reason)){
		return 5;
	}
	$check_private = $mysqli->query("SELECT hunter FROM boom_private WHERE hunter = '{$data['user_id']}' AND target = '$target' || hunter = '$target' AND target = '{$data['user_id']}' LIMIT 1");
	if($check_private->num_rows < 1){
		return 76;
	}
	$check_report = $mysqli->query("SELECT * FROM boom_report WHERE report_user = '{$data['user_id']}' AND report_target = '$target' AND report_type = 3");
	if($check_report->num_rows > 0){
		return 1;
	}
	$mysqli->query("INSERT INTO boom_report (report_type, report_user, report_target, report_reason, report_date, report_room) VALUES ('3', '{$data['user_id']}', '$target', '$reason', '" . time() . "', '0')");
	updateStaffNotify();
	return 1;
}

// end of functions

if(isset($_POST['send_report'], $_POST['type'], $_POST['report'], $_POST['reason'])){
	$type = escape($_POST['type'], true);
	if($type == 1){
		echo makeChatReport();
		die();
	}
	else if($type == 2){
		echo makeWallReport();
		die();
	}
	else if($type == 3){
		echo makePrivateReport();
		die();
	}
	else if($type == 4){
		echo makeProfileReport();
		die();
	}
	else if($type == 5){
		echo makeNewsReport();
		die();
	}
	else {
		die();
	}
}
die();
?>