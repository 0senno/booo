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
    SELECT boom_group_call.*, boom_users.user_name
    FROM boom_group_call
    LEFT JOIN boom_users ON boom_group_call.call_creator = boom_users.user_id
    WHERE boom_group_call.call_id = $id
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
			<div class="sub_text tpad3" onclick="getProfile(<?php echo $call['call_creator']; ?>);"><?php echo $call['user_name']; ?></div>
		</div>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['start_time']; ?></div>
			<div class="sub_text tpad3"><?php echo displayDate($call['call_date']); ?></div>
		</div>
		<?php if(!groupCallActive($call)){ ?>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['end_time']; ?></div>
			<div class="sub_text tpad3"><?php echo displayDate($call['call_active']); ?></div>
		</div>
		<?php } ?>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['duration']; ?></div>
			<div class="sub_text tpad3"><?php echo boomRenderSeconds($call['call_time']); ?></div>
		</div>
		<div class="pad15 blist">
			<div class="bold"><?php echo $lang['paid']; ?></div>
			<div class="sub_text tpad3"><?php echo $call['call_paid']; ?> <?php echo walletTitle($call['call_method']); ?></div>
		</div>
	</div>
</div>
<div class="modal_control hpad10">
	<button type="button" class="cancel_modal default_btn reg_button">Close</button>
</div>