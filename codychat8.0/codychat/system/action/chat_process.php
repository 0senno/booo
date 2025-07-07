<?php
require("../config_session.php");

if(mainBlocked()){
	die();
}

if (!isset($_POST['content'], $_POST['quote'])){
	echo boomCode(0);
	die();
}
if(isTooLong($_POST['content'], $setting['max_main'])){
	echo boomCode(0);
	die();
}

$quote = escape($_POST['quote'], true);
$content = escape($_POST['content']);
$content = wordFilter($content, 1);
$content = textFilter($content);

if(empty($content) && $content !== '0' || !inRoom()){
	echo boomCode(0);
	die();
}

$result = userPostChat($content, array('quote'=> $quote));

echo boomCode(1, array('log'=> $result));
?>



