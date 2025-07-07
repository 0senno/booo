<?php
require("system/config.php");

$page_info = array(
	'page'=> 'admin',
	'page_load'=> 'system/pages/admin/setting_dashboard.php',
	'page_menu'=> 1,
	'page_rank'=> 80,
	'page_nohome'=> 1,
);

// loading head tag element
include('control/head_load.php');

// load page header
include('control/header.php');

// create page menu
$side_menu  = '';
$side_menu .= pageMenu('admin/setting_dashboard.php', 'dashboard', $lang['dashboard'], 80);

// menu drop 1
	$drop1  = pageDropItem('admin/setting_main.php', $lang['main_settings'], 100);
	$drop1 .= pageDropItem('admin/setting_registration.php', $lang['registration'], 100);
	$drop1 .= pageDropItem('admin/setting_display.php', $lang['display'], 100);
	$drop1 .= pageDropItem('admin/setting_security.php', $lang['security'], 100);
	$drop1 .= pageDropItem('admin/setting_ai.php', $lang['ai'], 100);
	$drop1 .= pageDropItem('admin/setting_chat.php', $lang['chat_settings'], 100);
	$drop1 .= pageDropItem('admin/setting_email.php', $lang['email_settings'], 100);
	$drop1 .= pageDropItem('admin/setting_data.php', $lang['database_management'], 100);
	$drop1 .= pageDropItem('admin/setting_delays.php', $lang['delays'], 100);
	$drop1 .= pageDropItem('admin/setting_cache.php', $lang['cache'], 100);
$side_menu .= pageDropMenu('cogs', $lang['system_config'], $drop1, 100);

$side_menu .= pageMenu('admin/setting_members.php', 'users', $lang['manage_member'], 80);

// menu drop 2
	$drop2  = pageDropItem('admin/setting_limit.php', $lang['member_permission'], 100);
	$drop2 .= pageDropItem('admin/setting_staff.php', $lang['staff_permission'], 100);
	$drop2 .= pageDropItem('admin/setting_rstaff.php', $lang['room_permission'], 100);
$side_menu .= pageDropMenu('star', $lang['permission'], $drop2, min(100, 100));

// menu drop 3

	$drop3 	= pageDropItem('admin/setting_wallet.php', $lang['wallet_settings'], 100);
	$drop3 	.= pageDropItem('admin/setting_call.php', $lang['call_settings'], 100);
	$drop3 .= pageDropItem('admin/setting_level.php', $lang['level_settings'], 100);
	$drop3 .= pageDropItem('admin/setting_badge.php', $lang['badge_settings'], 100);
	$drop3 .= pageDropItem('admin/setting_gift.php', $lang['gift_settings'], 100);
	$drop3 .= pageDropItem('admin/setting_modules.php', $lang['other_module'], 100);
$side_menu .= pageDropMenu('cubes', $lang['manage_module'], $drop3, 100);

$side_menu .= pageMenu('admin/setting_action.php', 'legal', $lang['manage_action'], min($setting['can_kick'], $setting['can_ghost'], $setting['can_mute'], $setting['can_ban']));
$side_menu .= pageMenu('admin/setting_ip.php', 'ban', $lang['manage_ban'], $setting['can_mip']);
$side_menu .= pageMenu('admin/setting_rooms.php', 'home', $lang['manage_room'], $setting['can_mroom']);
$side_menu .= pageMenuNotify('admin/setting_contact.php', 'envelope', $lang['manage_contact'], 'contact_notify', $setting['can_mcontact']);
$side_menu .= pageMenu('admin/setting_addons.php', 'puzzle-piece', $lang['manage_addons'], $setting['can_maddons']);
$side_menu .= pageMenu('admin/setting_console.php', 'terminal', $lang['system_logs'], $setting['can_mlogs']);


// menu drop 4
	$drop4 	= pageDropItem('admin/setting_info.php', $lang['system_status'], 100);
	$drop4 .= pageDropItem('admin/setting_update.php', $lang['system_update'], 100);
$side_menu .= pageDropMenu('wrench', $lang['system_tools'], $drop4, min($setting['can_mlogs'], 100));


$side_menu .= pageMenu('admin/setting_filter.php', 'filter', $lang['manage_filter'], $setting['can_mfilter']);
$side_menu .= pageMenu('admin/setting_player.php', 'play-circle', $lang['manage_player'], $setting['can_mplay']);
$side_menu .= pageMenu('admin/setting_dj.php', 'music', $lang['manage_dj'], $setting['can_dj']);
$side_menu .= pageMenu('admin/setting_pages.php', 'file-text', $lang['manage_page'], 100);

// load page content
echo boomTemplate('element/base_page_menu', $side_menu);
 ?>
 <!-- load page script -->
<script data-cfasync="false" src="js/function_admin.js<?php echo $bbfv; ?>"></script>
<?php if(canManageContact()){ ?>
<script data-cfasync="false" src="js/function_contact_admin.js<?php echo $bbfv; ?>"></script>
<?php } ?>
<?php
// close page body
include('control/body_end.php');
?>

