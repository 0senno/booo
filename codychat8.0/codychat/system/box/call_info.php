<?php
require('../config_session.php');

if(!boomAllow(100)){
	echo 0;
	die();
}

if(!isset($_POST['call_id'])){
	echo 0;
	die();
}

$id = escape($_POST['call_id'], true);

$get_call = $mysqli->query("
	SELECT c.*, h.user_name as hunter,  t.user_name as target
	FROM boom_call c
	LEFT JOIN boom_users h ON c.call_hunter = h.user_id
	LEFT JOIN boom_users t ON c.call_target = t.user_id
	WHERE c.call_id = '$id'
");

if($get_call->num_rows < 1){
	echo 0;
	die();
}
$call = $get_call->fetch_assoc();
?>
<div class="modal_content">
	<div class="tpad10">
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['id']; ?></div>
			<div class="sub_text tpad3"><?php echo $call['call_room']; ?></div>
		</div>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['type']; ?></div>
			<div class="sub_text tpad3"><?php echo callType($call['call_type']); ?></div>
		</div>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['initiator']; ?></div>
			<div class="sub_text tpad3" onclick="getProfile(<?php echo $call['call_hunter']; ?>);"><?php echo $call['hunter']; ?></div>
		</div>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['participant']; ?></div>
			<div class="sub_text tpad3" onclick="getProfile(<?php echo $call['call_target']; ?>);"><?php echo $call['target']; ?></div>
		</div>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['start_time']; ?></div>
			<div class="sub_text tpad3"><?php echo displayDate($call['call_time']); ?></div>
		</div>
		<?php if(!callActive($call)){ ?>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['end_time']; ?></div>
			<div class="sub_text tpad3"><?php echo displayDate($call['call_active']); ?></div>
		</div>
		<?php } ?>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['duration']; ?></div>
			<div class="sub_text tpad3"><?php echo boomRenderSeconds($call['call_active'] - $call['call_time']); ?></div>
		</div>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['paid']; ?></div>
			<div class="sub_text tpad3"><?php echo $call['call_paid']; ?> <?php echo walletTitle($call['call_method']); ?></div>
		</div>
	</div>
</div>
<?php if(callActive($call)){ ?>
<div class="modal_control hpad10">
	<button onclick="adminCancelCall(<?php echo $call['call_id']; ?>);" class="button delete_btn"><?php echo $lang['end_call']; ?></button>
</div>
<?php } ?>