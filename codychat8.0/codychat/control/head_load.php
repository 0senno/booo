<?php
if(!defined('BOOM')){
	die();
}
if($chat_install != 1){
	header('location: ./');
	die();
}
$page = getPageData($page_info);
$bbfv = boomFileVersion();
$brtl = 0;
if(isRtl(BOOM_LANG) && $page['page_rtl'] == 1){
	$brtl = 1;
}
if(boomLogged() && !boomAllow($page['page_rank'])){
	header('location: ' . $setting['domain']);
	die();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title><?php echo $page['page_title']; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $page['page_description']; ?>">
<meta name="keywords" content="<?php echo $page['page_keyword']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link id="siteicon" rel="shortcut icon" type="image/png" href="default_images/icon.png<?php echo $bbfv; ?>"/>
<link rel="stylesheet" type="text/css" href="js/fancy/jquery.fancybox.css<?php echo $bbfv; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="css/awesome/css/all.min.css<?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="css/selectboxit.css<?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="js/jqueryui/jquery-ui.min.css<?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="css/main.css<?php echo $bbfv; ?>" />
<?php if(!boomLogged()){ ?>
<link rel="stylesheet" type="text/css" href="control/login/<?php echo getLoginPage(); ?>/login.css<?php echo $bbfv; ?>" />
<?php } ?>
<link id="gradient_sheet" rel="stylesheet" type="text/css" href="css/colors.css<?php echo $bbfv; ?>" />
<link id="actual_theme" rel="stylesheet" type="text/css" href="css/themes/<?php echo getTheme(); ?><?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="css/responsive.css<?php echo $bbfv; ?>" />
<script data-cfasync="false" src="js/jquery-3.5.1.min.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="system/language/<?php echo BOOM_LANG; ?>/language.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/fancy/jquery.fancybox.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/jqueryui/jquery-ui.min.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/jqueryui/jquery_ui_punch.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/global.min.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/function_split.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/yall/yall.js<?php echo $bbfv; ?>"></script>
<?php if(boomLogged() && useApp()){ ?>
<link rel="manifest" href="js/pwa/manifest.json<?php echo $bbfv; ?>">
<script data-cfasync="false" src="js/pwa/pw.js<?php echo $bbfv; ?>"></script>
<link rel="apple-touch-icon" href="default_images/pwa/icon_96.png<?php echo $bbfv; ?>">
<link rel="apple-touch-icon" href="default_images/pwa/icon_128.png<?php echo $bbfv; ?>">
<link rel="apple-touch-icon" href="default_images/pwa/icon_192.png<?php echo $bbfv; ?>">
<link rel="apple-touch-icon" href="default_images/pwa/icon_512.png<?php echo $bbfv; ?>">
<meta name="mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar" content="black-translucent">
<meta name="theme-color" content="#000000">
<script>
document.addEventListener('DOMContentLoaded', () => {
  if ('serviceWorker' in navigator) {
	navigator.serviceWorker.register('<?php echo $setting['domain']; ?>/service_worker.js')
	  .then((registration) => {
		console.log('Service Worker registered with scope:', registration.scope);
	  })
	  .catch((error) => {
		console.error('Service Worker registration failed:', error);
	  });
  }
});
</script>
<?php } ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
	yall({
		observeChanges: true
	});
});
</script>
<?php if(boomLogged()){ ?>
<script data-cfasync="false" src="js/function_logged.js<?php echo $bbfv; ?>"></script>
<?php } ?>
<?php if(boomLogged() && isStaff($data)){ ?>
<script data-cfasync="false" src="js/function_staff.js<?php echo $bbfv; ?>"></script>
<?php } ?>
<?php if($brtl == 1){ ?>
<link rel="stylesheet" type="text/css" href="css/rtl.css<?php echo $bbfv; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="css/custom.css<?php echo $bbfv; ?>" />
<script data-cfasync="false">
	var pageEmbed = <?php echo embedCode(); ?>;
	var pageRoom = <?php echo $page['page_room']; ?>;
	var curPage = '<?php echo $page['page']; ?>';
	var loadPage = '<?php echo $page['page_load']; ?>';
	var bbfv = '<?php echo $bbfv; ?>';
	var rtlMode = '<?php echo $brtl; ?>';
</script>
<?php if(!boomLogged()){ ?>
<script data-cfasync="false">
	var logged = 0;
	var utk = '0';
</script>
<?php } ?>
<?php if(boomLogged()){ ?>
<script data-cfasync="false">
	var user_rank = <?php echo $data["user_rank"]; ?>;
	var user_id = <?php echo $data["user_id"]; ?>;
	var uSound = '<?php echo $data['user_sound']; ?>';
	var utk = '<?php echo setToken(); ?>';
	var logged = 1;
</script>
<script data-cfasync="false">
	var avatarMax = <?php echo $setting['max_avatar']; ?>;
	var coverMax = <?php echo $setting['max_cover']; ?>;
	var riconMax = <?php echo $setting['max_ricon']; ?>;
	var fileMax = <?php echo $setting['file_weight']; ?>;
	var speed = <?php echo $setting['speed']; ?>;
	var canCall = <?php echo minCall(); ?>;
	var useCall = <?php echo $setting['use_call']; ?>;
	var useLevel = <?php echo $setting['use_level']; ?>;
	var useBadge = <?php echo $setting['use_level']; ?>;
	var inOut = <?php echo $setting['act_delay']; ?>;
	var uQuote = <?php echo $setting['allow_quote']; ?>;
	var upQuote = <?php echo $setting['allow_pquote']; ?>;
	var priMin = <?php echo $setting['allow_private']; ?>;
	var canScontent = <?php echo $setting['allow_scontent']; ?>;
	var canContent = <?php echo $setting['can_content']; ?>;
	var canRoomLogs = <?php echo $setting['can_rlogs']; ?>;
	var canReport = <?php echo $setting['allow_report']; ?>;
	var maxEmo = '<?php echo $setting['max_emo']; ?>';
	var privLoad = <?php echo $setting['privload']; ?>;
	var curSet = <?php echo $setting['curset']; ?>;
	var systemLoaded = 0;
</script>
<?php } ?>
</head>
<body>
<?php
if(checkBan()){
	include('banned.php');
	include('body_end.php');
	die();
}
if(checkKick()){
	include('kicked.php');
	include('body_end.php');
	die();
}
if(mustVerify()){
	include('verification.php');
	include('body_end.php');
	die();
}
if(maintMode()){
	include('maintenance.php');
	include('body_end.php');
	die();
}
if(!boomLogged() && $page['page_out'] == 0){
	include('control/login/' . getLoginPage() . '/login.php');
	include('control/captcha.php');
	include('body_end.php');
	die();
}
?>