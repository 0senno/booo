<?php
require('../config_session.php');
if(!isMember($data)){
	echo 0;
	die();
}
function myFriendList(){
	global $mysqli, $lang, $data;
	$friend_list = '';
	$find_friend = $mysqli->query("SELECT boom_users.user_name, boom_users.user_id, boom_users.user_tumb, boom_users.user_color, boom_users.last_action, boom_users.user_rank, boom_friends.* FROM boom_users, boom_friends 
	WHERE hunter = '{$data['user_id']}' AND fstatus > 1 AND target = boom_users.user_id ORDER BY fstatus DESC, user_name ASC");
	if($find_friend->num_rows > 0){
		while($find = $find_friend->fetch_assoc()){
			$friend_list .= boomTemplate('element/friend_element', $find);
		}
	}
	else {
		$friend_list .= emptyZone($lang['no_friend']);
	}
	return $friend_list;
}
?>
<div class="modal_content tpad15">
	<div class="ulist_container">
		<div class="friends_listing">
			<?php echo myFriendList(); ?>
		</div>
	</div>
</div>