<?php 
require('system/config_call.php');

if(!boomLogged()){
	die();
}

$bbfv = boomFileVersion();

if(!isset($_SESSION[BOOM_PREFIX  . 'call_id'], $_SESSION[BOOM_PREFIX  . 'call_password'])){
	die();
}

$call_type = 0;
$id = escape($_SESSION[BOOM_PREFIX  . 'call_id'], true);
$pass = escape($_SESSION[BOOM_PREFIX  . 'call_password']);

$call = groupCallDetails($id);

if(!empty($call)){
	$call_type = 1;
}

if(callBlocked($call['call_id'])){
	die();
}

if($call['call_password'] != '' && $pass != $call['call_password']){
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Call</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" type="text/css" href="css/awesome/css/all.min.css<?php echo $bbfv; ?>" />
    <link rel='stylesheet' type='text/css' media='screen' href='css/main.css<?php echo $bbfv; ?>'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/colors.css<?php echo $bbfv; ?>'>
	<link id="actual_theme" rel="stylesheet" type="text/css" href="css/themes/<?php echo getTheme(); ?><?php echo $bbfv; ?>" />
	<link rel="stylesheet" type="text/css" href="css/responsive.css<?php echo $bbfv; ?>" />
	<script data-cfasync="false" src="js/jquery-3.5.1.min.js<?php echo $bbfv; ?>"></script>
	<script data-cfasync="false">
		var utk = '<?php echo setToken(); ?>';
		var curPage = 'call';
	</script>
</head>
<body class="call_back">
	<?php
	if($call_type == 1){
		include('control/group_audio_call.php');
	}
	else {
		include('control/end_call.php');
	}
	?>
</body>
</html>