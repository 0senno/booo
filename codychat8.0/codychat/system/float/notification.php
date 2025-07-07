<?php
require('../config_session.php');
require('../function_notify.php');
require(BOOM_PATH . '/system/language/' . $data['user_language'] . '/notification.php');

$find_notify = $mysqli->query("
	SELECT boom_notification.*, boom_users.user_name, boom_users.user_tumb, boom_users.user_color
	FROM boom_notification
	LEFT JOIN boom_users
	ON boom_notification.notifier = boom_users.user_id
	WHERE boom_notification.notified = '{$data['user_id']}'
	ORDER BY boom_notification.notify_date DESC LIMIT 20
");

$notify_list = '';
if($find_notify->num_rows > 0){
	while($notify = $find_notify->fetch_assoc()){
		$notify_list .= '<div data-id="' . $notify['id'] . '" data="' . $notify['notify_data'] . '" class="' . $notify['notify_class'] . ' notify_item brad5 bhover fmenu_item">
							<div class="notify_avatar">
								<img src="' . myAvatar($notify['user_tumb']) . '"/>
								' . notifyIcon($notify) . '
							</div>
							<div class="notify_details">
								<p class="hnotify username ' . myColor($notify) . '">' . $notify['user_name'] . '</p>
								<p class="sub_text notify_text" >' . renderNotification($notify) . '</p>
								<p class="text_micro sub_date date_notify">' . displayDate($notify['notify_date']) . '</p>
							</div>
							<div class="notify_status">
								' . notifyView($notify['notify_view']) . '
							</div>
						</div>';
	}
	$mysqli->query("UPDATE boom_notification SET notify_view = 1 WHERE notified = '{$data['user_id']}'");
}
else {
	$notify_list .= emptyZone($lang['no_notify'], array('size'=> 'reg_icon'));
}
echo $notify_list;
?>