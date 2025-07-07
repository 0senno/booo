<?php
require('../config_session.php');

if(!boomAllow(1)){
	die();
}
$flist = '';
$find_friend = $mysqli->query("SELECT boom_users.user_name, boom_users.user_id, boom_users.user_tumb, boom_users.user_color, boom_friends.* FROM boom_users, boom_friends 
WHERE hunter = '{$data['user_id']}' AND fstatus = '1' AND target = boom_users.user_id ORDER BY user_status ASC, user_name ASC");
$mysqli->query("UPDATE boom_friends SET viewed = '1' WHERE target = '{$data['user_id']}'");
if($find_friend->num_rows > 0){
	while($friend = $find_friend->fetch_assoc()){
		$flist .= '<div class="fmenu_item fmuser bhover brad5 friend_request">
						<div class="ulist_avatar get_info" data="' . $friend['user_id'] . '">
							<img src="' . myAvatar($friend['user_tumb']) . '"/>
						</div>
						<div class="fmenu_name">
							<p class="username ' . myColor($friend) . '">' . $friend["user_name"] . '</p>
						</div>
						<div onclick="declineFriend(this, ' . $friend['user_id'] . ');" class="fmenu_option">
							<i class="fa fa-times error"></i></button>
						</div>
						<div onclick="acceptFriend(this, ' . $friend['user_id'] . ');" class="fmenu_option">
							<i class="fa fa-check success"></i>
						</div>
					</div>';
	} 
}
else {
	$flist .= emptyZone($lang['no_friend_request'], array('size'=> 'reg_icon'));
}
echo $flist;
?>