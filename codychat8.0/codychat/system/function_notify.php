<?php
function renderNotification($notify){
	global $data, $nlang, $lang;
	$ntext = $nlang[$notify['notify_type']];
	$ntext = str_replace('%custom%', $notify['notify_custom'], $ntext);
	$ntext = str_replace('%rank%', rankTitle($notify['notify_rank']), $ntext);
	$ntext = str_replace('%roomrank%', roomRankTitle($notify['notify_rank']), $ntext);
	$ntext = str_replace('%delay%', boomRenderMinutes($notify['notify_delay']), $ntext);
	$ntext = str_replace('%data%', $notify['notify_custom'], $ntext);
	$ntext = str_replace('%data2%', $notify['notify_custom2'], $ntext);
	return $ntext;
}
function notifyLikeBase($type){
	switch($type){
		case 1: 	return 'like.svg';
		case 2: 	return 'dislike.svg';
		case 3: 	return 'love.svg';
		case 4: 	return 'funny.svg';
		default:	return 'default.svg';
	}
}
function notifyIconBase($n){
	switch($n['notify_icon']){
		case 'plike':		return 'proliked.svg';
		case 'like':		return 'like.svg';
		case 'dislike':		return 'dislike.svg';
		case 'love':		return 'love.svg';
		case 'fun':			return 'funny.svg';
		case 'gold':		return 'gold.svg';
		case 'ruby':		return 'ruby.svg';
		case 'action':		return 'action.svg';
		case 'raction':		return 'raction.svg';
		case 'reply':		return 'reply.svg';
		case 'post':		return 'post.svg';
		case 'friend':		return 'friend.svg';
		case 'account':		return 'account.svg';
		case 'setting':		return 'setting.svg';
		case 'gift':		return 'gift.svg';
		case 'bookmark':	return 'bookmark.svg';
		case 'star':		return 'star.svg';
		case 'announce':	return 'announce.svg';
		case 'flag':		return 'flag.svg';
		case 'mail':		return 'mail.svg';
		case 'vip':			return 'vip.svg';
		case 'call':		return 'call.svg';
		case 'badge':		return 'badge.svg';
		case 'level':		return 'level.svg';
		case 'preact':		return notifyLikeBase($n['notify_custom']);
		default:			return 'default.svg';
	}
}
function notifyIcon($n){
	return '<img class="notify_icon" src="default_images/notification/' . notifyIconBase($n) .'"/>';
}
function notifyView($n){
	if($n == 0){
		return '<i class="fa fa-circle theme_color"></i>';
	}
}
?>