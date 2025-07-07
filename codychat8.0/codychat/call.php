<?php 
require('system/config_call.php');

if(!boomLogged()){
	die();
}

$bbfv = boomFileVersion();

if(!isset($_SESSION[BOOM_PREFIX  . 'call_id'])){
	die();
}

$id = escape($_SESSION[BOOM_PREFIX  . 'call_id'], true);

$call = callDetails($id);

if(empty($call)){
	die();
}

if(!mySelf($call['call_hunter']) && !mySelf($call['call_target'])){
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
	if($call['call_type'] == 1){
		include('control/video_call.php');
	}
	else if($call['call_type'] == 2){
		include('control/audio_call.php');
	}
	else {
		die();
	}
	?>
</body>
</html>