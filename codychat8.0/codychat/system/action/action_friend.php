<?php
require(__DIR__ . '/../config_session.php');

function removeFriend(){
	global $mysqli, $data;
	$id = escape($_POST['remove_friend'], true);
	if(!isMember($data)){
		return 1;
	}
	$list = [];
	$mysqli->query("DELETE FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id' OR hunter = '$id' AND target = '{$data['user_id']}'");
	$mysqli->query("DELETE FROM boom_notification WHERE notifier = '$id' AND notified = '{$data['user_id']}' OR notifier = '{$data['user_id']}' AND notified = '$id'");
	updateListNotify(array($id, $data['user_id']));
	return 1;
}
function addFriend(){
	global $mysqli, $data;
	$id = escape($_POST['add_friend'], true);
	$user = userRelationDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!isMember($user) || !isMember($data)){
		return 0;
	}
	if(ignored($user) || mySelf($user['user_id'])){
		return 0;
	}
	if($user['friendship'] == 0){
		if(friendLimit()){
			return 4;
		}
		if(!userAcceptFriend($user)){
			return 0;
		}
		$mysqli->query("INSERT INTO boom_friends (hunter, target, fstatus) VALUES ('{$data['user_id']}', '{$user['user_id']}', '2'), ('{$user['user_id']}', '{$data['user_id']}', '1')");
		updateNotify($user['user_id']);
		return 1;
	}
	if($user['friendship'] == 1){
		$mysqli->query("UPDATE boom_friends SET fstatus = 3 WHERE hunter = '{$data['user_id']}' AND target = '{$user['user_id']}' OR hunter = '{$user['user_id']}' AND target = '{$data['user_id']}'");
		boomNotify('accept_friend', array('hunter'=> $data['user_id'], 'target'=> $user['user_id'], 'icon'=> 'friend', 'class'=> 'get_info', 'data'=> $data['user_id']));
		updateNotify($data['user_id']);
		return 1;
	}
	if($user['friendship'] > 1){
		return 1;
	}
}

// end of functions

if(isset($_POST['add_friend'])){
	echo addFriend();
	die();
}
if(isset($_POST['remove_friend'])){
	echo removeFriend();
	die();
}
die();
?>
