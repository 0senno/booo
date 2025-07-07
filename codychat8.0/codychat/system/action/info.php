<?php
require(__DIR__ . '/../database.php');
require(__DIR__ . '/../controller.php');
date_default_timezone_set("America/Montreal");
$yes = 'installed';
$no = 'not installed';

$gd = $yes;
$curl = $yes;
$mysq = $yes;
$zip = $yes;
$mail = $yes;
$mbs = $yes;

if(!function_exists('mysqli_connect')) {
  $mysq = $no;
}
if(!extension_loaded('gd') && !function_exists('gd_info')) {
	$gd = $no;
}
if (!function_exists('curl_init')) {
	$curl = $no;
}
if (!extension_loaded('zip')) {
	$zip = $no;
}
if(!function_exists('mail')){
	$mail = $no;
}
if(!extension_loaded('mbstring')){
	$mbs = $no;
}
?>
<p>Mysqli: <?php echo $mysq; ?></p>
<p>Server host: <?php echo $_SERVER['SERVER_NAME']; ?></p>
<p>Php version: <?php echo phpVersion(); ?></p>
<p>Curl is on : <?php echo $curl; ?></p>
<p>Gd library : <?php echo $gd; ?></p>
<p>Zip : <?php echo $zip; ?></p>
<p>Mail : <?php echo $mail; ?></p>
<?php 
if($mysq == $yes && !mysqli_connect_errno()){
	$mysqli = @new mysqli(BOOM_DHOST, BOOM_DUSER, BOOM_DPASS, BOOM_DNAME);
	$get_data = $mysqli->query("SELECT * FROM boom_setting WHERE id = '1'");
	if($get_data->num_rows > 0){
		$setting = $get_data->fetch_assoc();
		echo '<p>Index path : ' . BOOM_DOMAIN . '</p>';
		echo '<p>Version : ' . $setting['version'] . '</p>';
		echo '<p>Registered : ' . substr($setting['boom'], 0,12) . '</p>';
	}
	else {
		die();
	}
}
else {
	die();
}
?>