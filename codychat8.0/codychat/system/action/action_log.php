<?php
require(__DIR__ . '/../config_session.php');

function chatMoreChat(){
	global $mysqli, $data;
	$last = escape($_POST['more_chat'], true);
	
	$clogs = [];
	if(!canHistory()){
		return boomCode(0, array("total" => 0, "clogs"=> $clogs));
	}
	$logs = getMoreChatHistory($last);
	return boomCode(0, array("total" => count($logs), "clogs"=> $logs ));
}
function privateMorePrivate(){
	global $mysqli, $data;
	
	$last = escape($_POST['more_private'], true);
	$priv = escape($_POST['target'], true);
	
	$plogs = getMorePrivateHistory($priv, $last);
	
	return boomCode(0, array("total" => count($plogs), "clogs"=> $plogs ));
}

// end of functions

if(isset($_POST['more_chat'])){
	echo chatMoreChat();
	die();
}
if(isset($_POST['more_private'], $_POST['target'])){
	echo privateMorePrivate();
	die();
}
die();
?>