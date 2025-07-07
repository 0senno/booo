<?php
require('../config_session.php');

if(!isset($_POST['id'], $_POST['cp'])){
	die();
}
$id = escape($_POST['id'], true);
$curpage = escape($_POST['cp']);

if(isStaff($data) || (boomAllow($setting['can_raction']) || roomStaff())){
	$user = userFullDetails($id);
}
else {
	$user = userRelationDetails($id);
}
if(empty($user)){
	echo 0;
	die();
}
if(mySelf($user['user_id']) || isBot($user)){
	echo 1;
	die();
}
$m = 0;
$r = 0;
$main_actions = '';
$room_actions = '';
$user['cpage'] = $curpage;
$glob_actions = trim(boomTemplate('element/glob_actions', $user));
if($glob_actions == ''){
	$glob_actions = emptyZone($lang['empty']);
}
if(isStaff($data)){
	$main_actions = trim(boomTemplate('element/main_actions', $user));
	if($main_actions != ''){
		$m = 1;
	}
}
if($curpage == 'chat' && (boomAllow($setting['can_raction']) || roomStaff())){
	$room_actions = trim(boomTemplate('element/room_actions', $user));
	if($room_actions != ''){
		$r = 1;
	}
}
?>
<div class="modal_user btable">
	<div class="modal_user_avatar bcell_mid">
		<img src="<?php echo myAvatar($user['user_tumb']); ?>"/>
	</div>
	<div class="modal_user_name bcell_mid hpad5">
		<p class=" text_med bold"><?php echo $user['user_name']; ?></p>
	</div>
</div>
<div class="modal_content">
	<?php if($m == 1 || $r == 1){ ?>
	<div class="modal_menu modal_mborder bmargin10">
		<ul>
			<li class="modal_menu_item modal_selected" data="mmainaction" data-z="glob_actions"><?php echo $lang['global']; ?></li>
			<?php if($m == 1){ ?>
			<li class="modal_menu_item" data="mmainaction" data-z="main_actions"><?php echo $lang['main_action']; ?></li>
			<?php } ?>
			<?php if($r == 1){ ?>
			<li class="modal_menu_item" data="mmainaction" data-z="room_actions"><?php echo $lang['room_action']; ?></li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
	<div id="mmainaction">
		<div class="modal_zone tpad10 <?php if($m == 0 && $r == 0){ echo 'tpad25'; } ?>" id="glob_actions">
			<?php echo $glob_actions; ?>
		</div>
		<?php if($m == 1){ ?>
		<div class="hide_zone modal_zone tpad10" id="main_actions">
			<?php echo $main_actions; ?>
		</div>
		<?php } ?>
		<?php if($r == 1){ ?>
		<div class="hide_zone modal_zone tpad10" id="room_actions">
			<?php echo $room_actions; ?>
		</div>
		<?php } ?>
	</div>
</div>