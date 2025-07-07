<?php
require("database.php");
require("controller.php");
require("function_bridge.php");
require('function_sranking.php');

mysqli_report(MYSQLI_REPORT_OFF);
$bmysqli = @new mysqli(BOOM_DHOST, BOOM_DUSER, BOOM_DPASS, BOOM_DNAME);
if (mysqli_connect_errno() || BOOM_INSTALL != 1) {
	die();
}

$bget_data = $bmysqli->query("SELECT boom_setting.* FROM boom_setting WHERE boom_setting.id = '1'");
if($bget_data->num_rows > 0){
	$bdata = $bget_data->fetch_assoc();
	$boom_version = bridgeVersion();
}
else {
	die();
}
date_default_timezone_set("{$bdata['timezone']}");
?>