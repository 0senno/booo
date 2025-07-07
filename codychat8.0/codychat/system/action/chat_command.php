<?php
require("../config_session.php");

if(mainBlocked()){
	die();
}

session_write_close();

if (!isset($_POST['content'])){
	echo boomCode(99);
}
if(isTooLong($_POST['content'], $setting['max_main'])){
	echo boomCode(99);
	die();
}

$content = escape($_POST['content']);
$content = wordFilter($content, 1);
$content = textFilter($content);
$command = explode(' ',trim($content));

if(empty($content) && $content !== '0' || !inRoom()){
	echo boomCode(4);
	die();
}

if(substr($command[0], 0, 1) !== '/'){
	echo boomCode(200);
	die();
}	
else if( $command[0] == '/topic' && canTopic()){
	$topic = trimCommand($content, '/topic');
	changeTopic($topic);
	$room = roomDetails($data['user_roomid']);
	if(!empty($room)){
		echo boomCode(14, array('data'=> getTopic($room)));
	}
	else {
		echo boomCode(4);
	}
	die();
}
else if ( $command[0] == '/clear' && canClearRoom()){
	clearRoom($data['user_roomid']);
	echo boomCode(99);
	die();
}

else if ( $command[0] == '/logout' && boomAllow(100)){
	$u = trimCommand($content, '/logout');
	$user = userNameDetails($u);
	if(!empty($user)){
		if(canEditUser($user, 100)){
			updateUserSession($user);
			echo boomCode(1);
			die();
		}
	}
	echo boomCode(200);
	die();
}
else if($command[0] == '/clearcache' && boomAllow(100)){
	boomCacheUpdate();
	echo boomCode(1);
	die();
}
else {
	echo boomCode(200);
	die();
}
?>