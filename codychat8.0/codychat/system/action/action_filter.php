<?php
require(__DIR__ . '/../config_session.php');

function setWordAction(){
	global $mysqli, $data;
	if(!boomAllow(100)){
		return 0;
	}
	$action = escape($_POST['word_action'], true);
	$delay = escape($_POST['word_delay'], true);
	
	$mysqli->query("UPDATE boom_setting SET word_action = '$action', word_delay = '$delay' WHERE id = 1");
	boomSaveSettings();
	return 1;	
}
function setSpamAction(){
	global $mysqli, $data;
	if(!boomAllow(100)){
		return 0;
	}
	$action = escape($_POST['spam_action'], true);
	$delay = escape($_POST['spam_delay'], true);
	
	$mysqli->query("UPDATE boom_setting SET spam_action = '$action', spam_delay = '$delay' WHERE id = 1");
	boomSaveSettings();
	return 1;	
}
function setEmailFilter(){
	global $mysqli, $data;
	
	$action = escape($_POST['email_filter'], true);
	
	if(!boomAllow(100)){
		return 0;
	}
	$mysqli->query("UPDATE boom_setting SET email_filter = '$action' WHERE id = 1");
	boomSaveSettings();
	return 1;	
}
function staffDeleteWord(){
	global $mysqli, $setting;
	
	$word = escape($_POST['delete_word'], true);
	
	if(!boomAllow($setting['can_mfilter'])){
		return 0;
	}
	$mysqli->query("DELETE FROM boom_filter WHERE id = '$word'");
	return 1;
}
function staffAddWord(){
	global $mysqli, $setting;
	
	$word = escape($_POST['add_word']);
	$type = escape($_POST['type']);
	
	if(!boomAllow($setting['can_mfilter'])){
		return '';
	}
	$check_word = $mysqli->query("SELECT * FROM boom_filter WHERE word = '$word' AND word_type = '$type'");
	if($check_word->num_rows > 0){
		return 0;
	}
	if($word != ''){
		$mysqli->query("INSERT INTO boom_filter (word, word_type) VALUE ('$word', '$type')");
		$word_added['id'] = $mysqli->insert_id;
		$word_added['word'] = $word;
		return boomTemplate('element/word', $word_added);
	}
	else {
		return 2;
	}
}

// end of functions

if(isset($_POST['word_action'], $_POST['word_delay'])){
	echo setWordAction();
	die();
}
if(isset($_POST['spam_action'], $_POST['spam_delay'])){
	echo setSpamAction();
	die();
}
if(isset($_POST['email_filter'])){
	echo setEmailFilter();
	die();
}
if(isset($_POST['delete_word'])){
	echo staffDeleteWord();
	die();
}
if(isset($_POST['add_word'], $_POST['type'])){
	echo staffAddWord();
	die();
}
die();
?>