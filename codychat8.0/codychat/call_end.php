<?php 
require('system/config_call.php');
$bbfv = boomFileVersion();

if(!boomLogged()){
	die();
}

$end = 1;
if(isset($_GET['end'])){
	$end = escape($_GET['end'], true);
}
switch($end){
	case 1:
		$reason = $lang['call_error'];
		break;
	case 2:
		$reason = $lang['call_left'];
		break;
	case 3:
		$reason = $lang['call_fund'];
		break;
	case 4:
		$reason = $lang['call_expired'];
		break;
	case 5:
		$reason = $lang['call_banned'];
		break;
	default:
		$reason = $lang['call_error'];
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
</head>
<body class="call_back">
<div class="out_page_container">
	<div class="out_page_content">
		<div class="out_page_box">
			<div class="pad_box">
				<p class="text_med bold bpad5"><?php echo $lang['call_ended']; ?></p>
				<p><?php echo $reason; ?></p>
				<button onclick="closeIframe();" class="reg_button delete_btn tmargin15"><?php echo $lang['close']; ?></button>
			</div>
		</div>
	</div>
</div>
<script>
let closeIframe = () => {
	window.parent.postMessage("endCall", window.location.origin);
}
</script>
</body>
</html>