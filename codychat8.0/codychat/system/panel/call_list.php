<?php
require('../config_session.php');

if(!canGroupCall()){
	echo 0;
	die();
}

$cdelay = calMinutes($setting['max_gcall']);
$ddelay = calSecond(30);
$list = '';
$get_call = $mysqli->query("
	SELECT boom_group_call.*, boom_users.user_name,
	(SELECT COUNT(*) FROM boom_call_user WHERE croom = call_id AND cdate > '$ddelay') AS user_count
	FROM boom_group_call
	LEFT JOIN boom_users ON boom_users.user_id = boom_group_call.call_creator
	WHERE call_id > 0 AND call_date > '$cdelay';
");
if($get_call->num_rows > 0){
	while($call = $get_call->fetch_assoc()){
		$list .= boomTemplate('element/call_list_element', $call);
	}
}
else {
	$list = emptyZone($lang['empty']);
}
?>
<div class="chat_rlist pad15 left_keep">
	<div class="vpad5">
		<div class="rtl_elem">
			<?php if(canCreateGroupCall()){ ?>
			<button class="small_button theme_btn" onclick="openAddCall();"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
			<?php } ?>
		</div>
	</div>
	<div id="room_filter" class="room_filters tpad10">
		<div class="room_search bpad5">
			<input id="search_call_room" class="full_input hpad15" placeholder="<?php echo $lang['search']; ?>"/>
		</div>
	</div>
	<div id="call_listing" class="vpad15">
		<?php echo $list; ?>
	</div>
</div>