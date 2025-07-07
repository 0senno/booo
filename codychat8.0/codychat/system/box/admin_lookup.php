<?php
require('../config_session.php');

function listOtherAccount($user){
	global $mysqli, $lang;
	$getsame = $mysqli->query("SELECT user_id, user_name FROM boom_users WHERE user_ip = '{$user['user_ip']}' AND user_id != '{$user['user_id']}' AND user_bot = 0 ORDER BY user_id DESC LIMIT 50");
	$same = '';
	if($getsame->num_rows > 0){
		while($usame = $getsame->fetch_assoc()){
			$same .= boomTemplate('element/bub_user', $usame);
		}
		return $same;
	}
	else {
		return boomTemplate('element/bub_text', $lang['no_data']);
	}
}
function listOldName($user){
	global $mysqli, $lang;
	$getname = $mysqli->query("SELECT uname FROM boom_name WHERE uid = '{$user['user_id']}' ORDER BY uname ASC LIMIT 50");
	$old = '';
	if($getname->num_rows > 0){
		while($p = $getname->fetch_assoc()){
			$old .= boomTemplate('element/bub_text', $p['uname']);
		}
		return $old;
	}
	else {
		return $old .= boomTemplate('element/bub_text', $lang['no_data']);
	}
}

$target = escape($_POST['target'], true);
$user = userDetails($target);

if(!isStaff($data)){
	echo 0;
	die();
}
if(empty($user)){
	echo 0;
	die();
}
if(!canLookup($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="tpad10">
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['join_chat']; ?></div>
			<div class="sub_text tpad3"><?php echo longDate($user['user_join']); ?></div>
		</div>
		<?php if(isVisible($user) && !isBot($user)){ ?>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['last_seen']; ?></div>
			<div class="sub_text tpad3"><?php echo longDateTime($user['last_action']); ?></div>
		</div>
		<?php } ?>
		<?php if(canViewEmail($user)){ ?>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['email']; ?></div>
			<div class="sub_text tpad3"><?php echo $user['user_email']; ?></div>
		</div>
		<?php } ?>
		<?php if(canViewIp($user)){ ?>
		<div class="pad15 blist">
			<div class="btable">
				<div class="bcell_mid">
					<div class="bold"><?php echo $lang['ip']; ?></div>
					<div class="sub_text tpad3"><?php echo $user['user_ip']; ?></div>
				</div>
				<?php if(useLookup()){ ?>
				<div id="scanbtn" class="bcell_mid scanbtn" onclick="getIpDetails(<?php echo $user['user_id']; ?>);">
					<i class="fa fa-search"></i>
				</div>
				<?php } ?>
			</div>
			<div id="ip_details" class="vpad10 hidden">
			</div>
		</div>
		<?php } ?>
		<?php if(canViewOther($user)){ ?>
		<div class="pad15 blist">
			<div class="btable">
				<div class="bcell_mid">
					<div class="bold"><?php echo $lang['other_account']; ?></div>
				</div>
			</div>
			<div id="other_result" class="vpad10 sub_text">
				<?php echo listOtherAccount($user); ?>
			</div>
		</div>
		<?php } ?>
		<?php if(canViewName($user)){ ?>
		<div class="pad15 blist">
			<div class="btable">
				<div class="bcell_mid">
					<div class="bold"><?php echo $lang['old_username']; ?></div>
				</div>
			</div>
			<div id="oldname_result" class="vpad10 sub_text">
				<?php echo listOldName($user); ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>