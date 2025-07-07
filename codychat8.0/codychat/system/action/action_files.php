<?php
require(__DIR__ . '/../config_session.php');

if (isset($_POST['remove_uploaded_file']) && boomAllow(1)){
	$toremove = escape($_POST["remove_uploaded_file"]);
	$get_file = $mysqli->query("SELECT * FROM boom_upload WHERE file_key = '$toremove' AND file_user = '{$data['user_id']}' AND file_complete = '0'");
	if($get_file->num_rows > 0){
		$file = $get_file->fetch_assoc();
		unlinkUpload($file['file_zone'], $file['file_name']);
		$mysqli->query("DELETE FROM boom_upload WHERE file_key = '$toremove' AND file_user = '{$data['user_id']}' AND file_complete = '0'");
	}
	die();
}
?>