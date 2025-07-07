<?php
require('../config_session.php');

function userFriendList($user){
	global $mysqli, $lang;
	$friend_list = [];
	$find_friend = $mysqli->query("
		SELECT boom_users.user_name, boom_users.user_id, boom_users.user_tumb, boom_users.user_color, boom_users.last_action,
		boom_users.user_status, boom_users.user_rank, boom_friends.*
		FROM boom_users, boom_friends 
		WHERE hunter = '{$user['user_id']}' AND fstatus = '3' AND target = boom_users.user_id 
		ORDER BY last_action DESC, user_name ASC
	");
	if($find_friend->num_rows > 0){
		while($find = $find_friend->fetch_assoc()){
			if(isVisible($find)){
				$friend_list[] = boomTemplate('element/user_square', $find);
			}
		}
	}
	return createPag($friend_list, 24, array('menu'=> 'centered_element', 'style'=> 'arrow'));
}

if(!isset($_POST['target'])){
	echo 0;
	die();
}
$target = escape($_POST['target'], true);
if(mySelf($target)){
	$user = $data;
}
else {
	$user = userDetails($target);
}
if(empty($user)){
	echo 0;
	die();
}
if(!userShareFriend($user)){
	echo 0;
	die();
}
?>
<div id="view_gift_box">
	<?php echo userFriendList($user); ?>
</div>
<div id="view_friend_template" class="hidden">
	<div class="modal_content">
		<div class="centered_element tpad25">
			<div class="bpad3">
				<img id="view_friend_avatar" class="vfavatar" src=""/>
			</div>
			<div class="tpad15 bpad5">
				<div id="view_friend_name" class="text_xmed bold">
				</div>
			</div>
		</div>
	</div>
	<div class="modal_control centered_element">
		<button id="view_friend_id" data="" class="reg_button ok_btn get_finfo"><?php echo $lang['info']; ?></button>
		<button class="reg_button default_btn close_over"><?php echo $lang['close']; ?></button>
	</div>
</div>