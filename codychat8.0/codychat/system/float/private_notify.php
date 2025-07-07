<?php
require("../config_session.php");

if(!canPrivate()){
	return emptyZone($lang['no_unread_private'], array('size'=> 'reg_icon'));
	die();
}
function privateNotification($p){
	$add_count = '';
	if($p['unread'] > 0){
		$add_count = '<div class="ulist_notify"><span class="pm_notify private_count bnotify">' . $p['unread'] . '</span></div>';
	}
	return '<div class="fmenu_item fmuser bhover brad5 priv_mess">
				<div class="fmenu_avatar">
					<img class="lazy" data-src="' . myAvatar($p['user_tumb']) . '" src="' . imgLoader() . '"/>
				</div>
				<div class="fmenu_name gprivate" data="' . $p['user_id'] . '" value="' . $p['user_name'] . '" data-av="' . myAvatar($p['user_tumb']) . '">
					<p class="username ' . myColor($p) . '">' . $p["user_name"] . '</p>
				</div>
				' . $add_count . '
				<div data="' . $p['hunter'] . '" class="fmenu_option delete_private">
					<i class="fa fa-times"></i>
				</div>
			</div>';
}

$notify_limit = 50;
$private_list = '';
$priv = 0;

$private = $mysqli->query("
	SELECT boom_conversation.*, boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb 
	FROM boom_conversation 
	LEFT JOIN boom_users 
	ON boom_conversation.hunter = boom_users.user_id 
	WHERE boom_conversation.target = {$data['user_id']} AND boom_conversation.unread > 0
	ORDER BY boom_conversation.cdate DESC
");

if ($private->num_rows > 0){
	while ($my_private= $private->fetch_assoc()){
		$private_list .=  privateNotification($my_private);
		$priv++;
	}
}
if($priv < $notify_limit){
	$new_limit = $notify_limit - $priv;
	$get_other = $mysqli->query("
		SELECT boom_conversation.*, boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb 
		FROM boom_conversation 
		LEFT JOIN boom_users 
		ON boom_conversation.hunter = boom_users.user_id 
		WHERE boom_conversation.target = {$data['user_id']} AND boom_conversation.unread = 0
		ORDER BY boom_conversation.cdate DESC LIMIT $new_limit
	");

	if($get_other->num_rows > 0){
		while ($other_private= $get_other->fetch_assoc()){
			$private_list .= privateNotification($other_private);
			$priv++;
		}
	}
}
if($private_list == '') {
	$private_list .= emptyZone($lang['no_unread_private'], array('size'=> 'reg_icon'));
}
echo $private_list;
?>
