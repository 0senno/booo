<?php
require('../config_session.php');

if(!isset($_POST['call_id'])){
	echo 0;
	die();
}
$cid = escape($_POST['call_id'], true);
$call = groupCallDetails($cid);
if(empty($call)){
	echo 0;
	die();
}
if(expiredCall($call)){
	echo 0;
	die();
}
function listCallUsers($c){
	global $mysqli;
	$delay = calSecond(30);
	$ulist = '';
	$get_users = $mysqli->query("
		SELECT 
		boom_call_user.cuser, 
		boom_users.user_name, 
		boom_users.user_tumb 
		FROM boom_call_user
		JOIN boom_users ON boom_users.user_id = boom_call_user.cuser
		WHERE boom_call_user.croom = '{$c}' 
		AND boom_call_user.cdate >= '{$delay}'
	");
	if($get_users->num_rows > 0){
		while($user = $get_users->fetch_assoc()){
			$ulist .= '<img title="' . $user['user_name'] . '" class="incall_user" src="' . myAvatar($user['user_tumb']) . '"/>';
		}
	}
	return $ulist;
}

$list = listCallUsers($call['call_id']);
?>
<div class="centered_element">
	<div class="modal_content">
		<div class="pad10">
			<p class="text_large bold"><?php echo $lang['join_call']; ?></p>
			<p><?php echo $call['call_name']; ?></p>
		</div>
		<?php if(!empty($list)){ ?>
		<div class="pad10">
			<?php echo $list; ?>
		</div>
		<?php } ?>
		<?php if($call['call_password'] != ''){ ?>
		<div class="setting_element">
			<p class="label"><?php echo $lang['password']; ?></p>
			<input id="call_password" class="full_input centered_element" autocomplete="off"/>
		</div>
		<?php } ?>
	</div>
	<div class="modal_control">
		<button onclick="joinGroupCall(<?php echo $cid; ?>, <?php echo $call['call_access']; ?>);" id="access_room" class="reg_button theme_btn"><?php echo $lang['join']; ?></button>
		<button class="cancel_over reg_button default_btn"><?php echo $lang['cancel']; ?></button>
		<?php if(useCallBalance()){ ?>
		<div class="tpad15">
			<div class="bpad3">
			<?php echo costTags($setting['call_method'], $setting['call_cost'], array('text'=> $lang['call_cost'])); ?>
			</div>
		</div>
		<?php } ?>
		<?php if(canEditCall($call)){ ?>
		<div class="tmargin10 text_small sub_text blinking" onclick="editGroupCall(<?php echo $call['call_id']; ?>);">
			<?php echo $lang['edit_call']; ?>
		</div>
		<?php } ?>
	</div>
</div>