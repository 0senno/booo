<?php
require("../config_session.php");

if(privateBlocked()){
	die();
}

session_write_close();

if (!isset($_POST['target'], $_POST['content'], $_POST['quote'])){
	echo boomCode(0);
	die();
}

if(isTooLong($_POST['content'], $setting['max_private'])){
	echo boomCode(0);
	die();
}

$target = escape($_POST['target'], true);
$user = userRelationDetails($target);
if(!canSendPrivate($user)){
	echo boomCode(99);
	die();
}

$content = escape($_POST['content']);
$quote = escape($_POST['quote'], true);
$content = wordFilter($content);
$content = textFilter($content);

$result = userPostPrivate($user, $content, array('quote'=> $quote));

echo boomCode(1, array('log'=> $result));
die();
?>