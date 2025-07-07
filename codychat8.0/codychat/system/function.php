<?php
function setToken(){
	global $data;
	if(!empty($_SESSION[BOOM_PREFIX . 'token'])){
		$session = $_SESSION[BOOM_PREFIX . 'token'];
	}
	else {
		$session = md5(rand(000000,999999));
		$_SESSION[BOOM_PREFIX . 'token'] = $session;
	}
	return $session;
}
function sessionCleanup(){
	unset($_SESSION[BOOM_PREFIX . 'token']);
}
function closeSession(){
	session_write_close();
}
function checkToken(){
	if(!isset($_COOKIE[BOOM_PREFIX . 'userid'], $_COOKIE[BOOM_PREFIX . 'utk'], $_COOKIE[BOOM_PREFIX . 'ssid'])){
		return false;
	}
    if (!isset($_POST['token'], $_SESSION[BOOM_PREFIX . 'token'])) {
        return false;
    }
	if(empty($_SESSION[BOOM_PREFIX . 'token'])){
		return false;
	}
	if($_POST['token'] == $_SESSION[BOOM_PREFIX . 'token']){
		return true;
	}
}
function clearUserSession(){
	unsetBoomCookie();
	sessionCleanup();
}
function genSession(){
	return rand(1111, 9999) . rand(11111,99999);
}
function validSession(){
	global $data;
	if(isset($_COOKIE[BOOM_PREFIX . 'ssid']) && $data['session_id'] == $_COOKIE[BOOM_PREFIX . 'ssid']){
		return true;
	}
}
function updateUserSession($user, $c = false){
	global $mysqli;
	$new_session = genSession();
	$mysqli->query("UPDATE boom_users SET session_id = '$new_session' WHERE user_id = '{$user['user_id']}'");
	if($c == true){
		setBoomCookie($user, ['session'=> $new_session]);
	}
}
function validAjax(){
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		return true;
	}
}
function mainBlocked(){
	if(mainMuted() || checkFlood()){
		return true;
	}
}
function privateBlocked(){
	if(privateMuted() || checkFlood()){
		return true;
	}
}
function postBlocked(){
	if(muted() || checkFlood()){
		return true;
	}
}
function privCheck(){
	global $setting;
	if(!boomAllow($setting['allow_private'])){
		return 'fhide';
	}
}
function getIp(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $cloud =   @$_SERVER["HTTP_CF_CONNECTING_IP"];
    $remote  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($cloud, FILTER_VALIDATE_IP)) {
        $ip = $cloud;
    }
    else if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }
    else{
        $ip = $remote;
    }
    return escape($ip);
}
function createInfo($v){
	return '<i class="fa fa-question-circle theme_color infopop" data="' . $v . '"></i>';
}
function boomTemplate($getpage, $boom = '') {
	global $mysqli, $setting, $data, $lang;
    $page = BOOM_PATH . '/system/' . $getpage . '.php';
    $structure = '';
    ob_start();
    require($page);
    $structure = ob_get_clean();
    return $structure;
}
function boomAddonsTemplate($getpage, $boom = '') {
	global $mysqli, $setting, $data, $addons, $lang;
    $page = BOOM_PATH . '/system/' . $getpage . '.php';
    $structure = '';
    ob_start();
    require($page);
    $structure = ob_get_clean();
    return $structure;
}
function calHour($h){
	return time() - ($h * 3600);
}
function calWeek($w){
	return time() - ( 3600 * 24 * 7 * $w);
}
function calmonth($m){
	return time() - ( 3600 * 24 * 30 * $m);
}
function calDay($d){
	return time() - ($d * 86400);
}
function calSecond($sec){
	return time() - $sec;
}
function calMinutes($min){
	return time() - ($min * 60);
}
function calHourUp($h){
	return time() + ($h * 3600);
}
function calWeekUp($w){
	return time() + ( 3600 * 24 * 7 * $w);
}
function calmonthUp($m){
	return time() + ( 3600 * 24 * 30 * $m);
}
function calDayUp($d){
	return time() + ($d * 86400);
}
function calMinutesUp($min){
	return time() + ($min * 60);
}
function calSecondUp($sec){
	return time() + $sec;
}
function myColor($u){
	return $u['user_color'];
}
function myColorFont($u){
	return $u['user_color'] . ' ' . $u['user_font'];
}
function myTextColor($u){
	return $u['bccolor'] . ' ' . $u['bcbold'] . ' ' . $u['bcfont'];
}
function vCheck($val){
	if(strlen($val) == 36){
		return true;
	}
}
function boomFileVersion(){
	global $setting;
	if($setting['bbfv'] > 1.0){
		return '?v=' . $setting['bbfv'];
	}
	return '';
}
function checkAvatar($a){
	if(empty($a)){
		$a = 'default_avatar.png';
	}
	return myAvatar($a);
}
function checkUsername($n){
	if(empty($n)){
		$n = 'N/A';
	}
	return $n;
}
function myAvatar($a){
	if(defaultAvatar($a)){
		return 'default_images/avatar/' . $a;
	}
	return BOOM_DOMAIN . 'avatar/' . $a;
}
function imgLoader(){
	return 'default_images/misc/holder.png';
}
function defaultAvatar($a){
	if(stripos($a, 'default') !== false){
		return true;
	}
}
function myRoomIcon($a){
	if(defaultRoomIcon($a)){
		return 'default_images/rooms/' . $a;
	}
	return BOOM_DOMAIN . 'room_icon/' . $a;
}
function defaultRoomIcon($a){
	if(stripos($a, 'default') !== false){
		return true;
	}
}
function myCover($a){
	return BOOM_DOMAIN . 'cover/' . $a;
}
function getCover($user){
	if(userHaveCover($user)){
		return 'style="background-image: url(' . myCover($user['user_cover']) . ');"';
	}
}
function coverClass($user){
	if(userHaveCover($user)){
		return 'cover_size';
	}
}
function userHaveCover($user){
	if($user['user_cover'] != ''){
		return true;
	}
}

// mobile function

function getMobile() {
	$list = array('mobile','phone','iphone','ipad','ipod','android','silk','kindle','blackberry','opera Mini','opera Mobi','symb');
	foreach($list as $val){
		if(stripos($_SERVER['HTTP_USER_AGENT'], $val) !== false){
			return 1;
		}
	}
	return 0;
} 

function getIcon($icon, $c){
	return '<img class="' . $c . '" src="default_images/icons/' . $icon . boomFileVersion() . '"/>';
}
function boomCode($code, $custom = array()){
	$def = array('code'=> $code);
	$res = array_merge($def, $custom);
	return json_encode( $res, JSON_UNESCAPED_UNICODE);
}
function escape($t, $i = false){
	global $mysqli;
	if($i === true){
		return intval($t);
	}
	else {
		return $mysqli->real_escape_string(trim(htmlspecialchars($t, ENT_QUOTES)));
	}
}
function boomSanitize($t){
	global $mysqli;
	$t = str_replace(array('\\', '/', '.', '<', '>', '%', '#'), '', $t);
	return $mysqli->real_escape_string(trim(htmlspecialchars($t, ENT_QUOTES)));
}
function softEscape($t){
	global $mysqli;
	$atags = '<a><p><h1><h2><h3><h4><img><b><strong><br><ul><li><div><i><span><u><th><td><tr><table><strike><small><ol><hr><font><center><blink><audio><marquee><script><style>';
	$t = strip_tags($t, $atags);
	return $mysqli->real_escape_string(trim($t));
}
function systemReplace($text){
	global $lang;
	$text = str_replace('%bcjoin%', $lang['join_message'], $text);
	$text = str_replace('%bcclear%', $lang['clear_message'], $text);
	$text = str_replace('%spam%', $lang['spam_content'], $text);
	$text = str_replace('%bcname%', $lang['name_message'], $text);
	$text = str_replace('%bckick%', $lang['kick_message'], $text);
	$text = str_replace('%bcban%', $lang['ban_message'], $text);
	$text = str_replace('%bcmute%', $lang['mute_message'], $text);
	$text = str_replace('%bcblock%', $lang['block_message'], $text);
	return $text;
}
function textReplace($text){
	global $data;
	$text = str_replace('%user%', $data['user_name'], $text);
	return $text;
}
function systemSpecial($content, $type, $custom = array()){
	global $lang;
	$def = array(
		'content'=> $content,
		'type'=> $type,
		'delete'=> 1,
		'title'=> $lang['default_title'],
		'icon'=> 'default.svg',
	);
	$template = array_merge($def, $custom);
	return boomTemplate('element/system_log', $template);
}
function specialLogIcon($icon){
	return 'default_images/special/' . $icon . boomFileVersion();
}
function userShareAge($user){
	if($user['ashare'] > 0){
		return true;
	}
}
function userShareGender($user){
	if($user['sshare'] > 0){
		return true;
	}
}
function userShareLocation($user){
	if($user['country'] != '' && $user['country'] != 'ZZ' && $user['lshare'] > 0){
		return true;
	}
}
function userShareFriend($user){
	if(!isMember($user)){
		return false;
	}
	if($user['fshare'] > 0){
		return true;
	}
}
function userShareGift($user){
	if(!useGift() || isBot($user)){
		return false;
	}
	if($user['gshare'] > 0){
		return true;
	}
}
function getUserAge($age){
	global $lang;
	return $age . ' ' . $lang['years_old'];
}
function delExpired($d){
	if($d < calSecond(20)){
		return true;
	}
}
function chatAction($room){
	global $mysqli;
	$mysqli->query("UPDATE boom_rooms SET rcaction = rcaction + 1, room_action = '" . time() . "' WHERE room_id = '$room'");
	redisUpdateChat($room);
}
function useQuote(){
	global $setting;
	if($setting['allow_quote'] < 999){
		return true;
	}
}
function usePrivateQuote(){
	global $setting;
	if($setting['allow_pquote'] < 999){
		return true;
	}
}

// chat post functions

function systemPostChat($room, $content, $custom = array()){
	global $mysqli, $setting;
	$def = array(
		'type'=> 'system',
		'color'=> 'chat_system',
		'rank'=> 999,
		'system'=> 1,
	);
	$post = array_merge($def, $custom);
	$mysqli->query("INSERT INTO `boom_chat` (post_date, user_id, post_message, post_roomid, type, log_rank, tcolor, syslog) VALUES ('" . time() . "', '{$setting['system_id']}', '$content', '$room', '{$post['type']}', '{$post['rank']}', '{$post['color']}', '{$post['system']}')");
	chatAction($room);
	return true;
}

function convId($hunter, $target){
	return $hunter.'.'.$target;
}
function updateConv($hunter, $target){
	global $mysqli;
	$mysqli->query("
	INSERT INTO `boom_conversation` (`cid`, `hunter`, `target`, `unread`, `cdate`) VALUES ('" . convId($hunter, $target) . "','$hunter','$target',1,'" . time() . "') ON DUPLICATE KEY UPDATE `unread` = `unread` + 1, `cdate` = '" . time() . "'
	");
	redisUpdatePrivate($target);
}
function readConv($hunter, $target){
	global $mysqli;
	$mysqli->query("UPDATE boom_conversation SET unread = 0, cdate = '". time() . "' WHERE hunter = '$hunter' AND target = '$target'");
	redisUpdatePrivate($target);
}
function readAllConv($id){
	global $mysqli;
	$mysqli->query("UPDATE boom_conversation SET unread = 0, cdate = '". time() . "' WHERE target = '$id'");
	redisUpdatePrivate($id);
}
function descConv($hunter, $target){
	global $mysqli;
	$mysqli->query("UPDATE boom_conversation SET unread = unread - 1 WHERE hunter = '$hunter' AND target = '$target' AND unread > 0");
	redisUpdatePrivate($target);
}
function quoteDetails($id){
	global $mysqli;
	$log = [];
	if(($cache = redisGetObject('quote:' . $id))){
		return $cache;
	}
	$get_log = $mysqli->query("
		SELECT 
		boom_chat.post_id, boom_chat.post_roomid, boom_chat.user_id, boom_chat.post_message, boom_chat.pghost,
		boom_users.user_name, boom_users.user_tumb, boom_users.user_bot
		FROM boom_chat, boom_users
		WHERE boom_chat.post_id = '$id' AND boom_users.user_id = boom_chat.user_id
	");
	if($get_log->num_rows > 0){
		$log = $get_log->fetch_assoc();
		redisSetObject('quote:' . $id, $log, 30);
	}
	return $log;
}
function privateQuoteDetails($id){
	global $mysqli;
	$log = [];
	if(($cache = redisGetObject('pquote:' . $id))){
		return $cache;
	}
	$get_log = $mysqli->query("
		SELECT boom_private.id, boom_private.hunter, boom_private.target, boom_private.message
		FROM boom_private
		WHERE boom_private.id = '$id'
	");
	if($get_log->num_rows > 0){
		$log = $get_log->fetch_assoc();
		redisSetObject('pquote:' . $id, $log);
	}
	return $log;
}
function boomListNotify($list, $type, $custom = array()){
	global $mysqli, $setting, $data;
	if(!empty($list)){
		$values = '';
		foreach($list as $user){
			$def = array(
				'hunter'=> $setting['system_id'],
				'room'=> $data['user_roomid'],
				'rank'=> 0,
				'delay'=> 0,
				'reason'=> '',
				'source'=> 'system',
				'sourceid'=> 0,
				'custom' => '',
				'custom2' => '',
				'icon'=> '',
				'class'=> '',
				'data'=> '',
			);
			$c = array_merge($def, $custom);
			$values .= "('{$c['hunter']}', '$user', '$type', '" . time() . "', '{$c['source']}', '{$c['sourceid']}', '{$c['rank']}', '{$c['delay']}', '{$c['reason']}', '{$c['custom']}', '{$c['custom2']}', '{$c['icon']}', '{$c['class']}', '{$c['data']}'),";
		}
		$values = rtrim($values, ',');
		$mysqli->query("INSERT INTO boom_notification ( notifier, notified, notify_type, notify_date, notify_source, notify_id, notify_rank, notify_delay, notify_reason, notify_custom, notify_custom2, notify_icon, notify_class, notify_data) VALUES $values");
		updateListNotify($list);
	}
}
function boomNotify($type, $custom = array()){
	global $mysqli, $setting, $data;
	$def = array(
		'hunter'=> $setting['system_id'],
		'target'=> 0,
		'room'=> $data['user_roomid'],
		'rank'=> 0,
		'delay'=> 0,
		'reason'=> '',
		'source'=> 'system',
		'sourceid'=> 0,
		'custom' => '',
		'custom2' => '',
		'icon'=> '',
		'class'=> '',
		'data'=> '',
	);
	$c = array_merge($def, $custom);
	if($c['target'] == 0){
		return false;
	}
	$mysqli->query("INSERT INTO boom_notification ( notifier, notified, notify_type, notify_date, notify_source, notify_id, notify_rank, notify_delay, notify_reason, notify_custom, notify_custom2, notify_icon, notify_class, notify_data) 
	VALUE ('{$c['hunter']}', '{$c['target']}', '$type', '" . time() . "', '{$c['source']}', '{$c['sourceid']}', '{$c['rank']}', '{$c['delay']}', '{$c['reason']}', '{$c['custom']}', '{$c['custom2']}', '{$c['icon']}', '{$c['class']}', '{$c['data']}')");
	updateNotify($c['target']); 
}
function updateNotify($id){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_id = '$id'");
	redisUpdateNotify($id);
}
function updateListNotify($list){
	global $mysqli;
	if(empty($list)){
		return false;
	}
	$delay = getDelay();
	$ulist = implode(", ", $list);
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_id IN ($ulist) AND last_action > '$delay'");
	redisListNotify($list);
}
function updateStaffNotify(){
	global $mysqli;
	$delay = getDelay();
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_rank >= 70 AND last_action > '$delay'");
	redisUpdateStaffNotify();
}
function updateAllNotify(){
	global $mysqli;
	$delay = getDelay();
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE last_action > '$delay'");
	redisUpdateAllNotify();
}
function loadIgnore($id){
	global $mysqli, $data;
	$list = [];
	if(is_array($cache = redisGetObject('ignore:' . $id))){
		return $cache;
	}
	$get_ignore = $mysqli->query("SELECT ignored FROM boom_ignore WHERE ignorer = '{$data['user_id']}'");
	while($ignore = $get_ignore->fetch_assoc()){
		$list[] = (int) $ignore['ignored'];
	}
	redisSetObject('ignore:' . $id, $list);
	return $list;
}
function processQuoteMessage($message) {
	return mb_convert_encoding(systemReplace($message), 'UTF-8', 'auto');
}
function processChatMessage($post) {
	global $data;
	$post['post_message'] = ' '.$post['post_message'].' ';
	if($post['user_id'] != $data['user_id']){
		$post['post_message'] = str_ireplace(' '.$data['user_name'].' ', ' <span class="my_notice">' . $data['user_name'] . '</span> ', $post['post_message']);
	}
	return mb_convert_encoding(systemReplace($post['post_message']), 'UTF-8', 'auto');
}
function processPrivateMessage($post) {
	return mb_convert_encoding(systemReplace($post['message']), 'UTF-8', 'auto');
}
function spamText(){
	return '<div class="system_text">%spam%</div>';
}
function zalgoText(){
	return '<div class="system_text">****</div>';
}
function privDel(){
	if(canDeletePrivate()){
		return 1;
	}
	else {
		return 0;
	}
}
function chatDate($date){
	return date("j/m G:i", $date);
}
function displayDate($date){
	return date("j/m G:i", $date);
}
function longDate($date){
	return date("Y-m-d ", $date);
}
function longDateTime($date){
	return date("Y-m-d G:i ", $date);
}

function userTime($user){          
	$d = new DateTime(date("d F Y H:i:s",time()));
	$d->setTimezone(new DateTimeZone($user['user_timezone']));
	$r =$d->format('G:i');
	return $r;
}
function useLogs($val){
	global $setting;
	if(preg_match('@[' . $val . ']@i', $setting['use_logs'])){
		return true;
	}
}
function boomAllow($rank){
	global $data;
	if($data['user_rank'] >= $rank){
		return true;
	}
}
function boomRank($rank){
	global $data;
	if($data['user_rank'] == $rank){ 
		return true;
	}
}
function userBoomAllow($user, $val){
	if($user['user_rank'] >= $val){
		return true;
	}
}
function boomRole($role){
	global $data;
	if($data['user_role'] >= $role){
		return true;
	}
}
function haveRole($role){
	if($role > 0){
		return true;
	}
}
function isGreater($rank){
	global $data;
	if($data['user_rank'] > $rank){
		return true;
	}
}
function mySelf($id){
	global $data;
	if($id == $data['user_id']){
		return true;
	}
}
function isBot($user){
	if($user['user_bot'] > 0){
		return true;
	}
}
function systemBot($user){
	if($user == 9){
		return true;
	}
}
function isSystem($id){
	global $setting;
	if($id == $setting['system_id']){
		return true;
	}
}
function myElement($id, $c){
	if(mySelf($id)){
		return $c;
	}
}
function checkMute($data){
	$r = 'c';
	if(isMuted($data)){
		$r .= 'mws';
		if(!canPrivate()){
			$r .= 'p';
		}
		return $r;
	}
	if(!canPrivate()){
		$r .= 'p';
	}
	if(isMainMuted($data) || isRoomMuted($data) || !canMain()){
		$r .= 'm';
	}
	return $r;
}
function muted(){
	global $data;
	if(isMuted($data) || !inChat($data)){
		return true;
	}
}
function mainMuted(){
	global $data;
	if(isMuted($data) || isMainMuted($data) || !inChat($data) || isRoomMuted($data) || !canMain() || isWarned($data)){
		return true;
	}
}
function privateMuted(){
	global $data;
	if(isMuted($data) || !inChat($data) || !canPrivate() || isWarned($data)){
		return true;
	}
}
function isRoomMuted($user){
	if($user['room_mute'] > time()){
		return true;
	}
}
function isMuted($user){
	if($user['user_mute'] > time() || isRegmuted($user)){
		return true;
	}
}
function isMainMuted($user){
	if($user['user_mmute'] > time()){
		return true;
	}
}
function isPrivateMuted($user){
	if($user['user_pmute'] > time()){
		return true;
	}
}
function isBanned($user){
	if($user['user_banned'] > 0){
		return true;
	}
}
function isKicked($user){
	if($user['user_kick'] > time()){
		return true;
	}
}
function isGhosted($user){
	if($user['user_ghost'] > time()){
		return true;
	}
}
function isWarned($user){
	if(!empty($user['warn_msg'])){
		return true;
	}
}
function isRegmuted($user){
	if($user['user_rmute'] > time()){
		return true;
	}
}
function isOnAir($user){
	if($user['user_onair'] > 0){
		return true;
	}
}
function systemNameFilter($user){
	return '<span onclick="getProfile(' . $user['user_id'] . ')"; class="sysname bclick">' . $user['user_name'] . '</span>';
}
function moveMessage($user){
	if($user['user_move'] < calSecond(6)){
		return true;
	}
}
function joinMessage($user){
	global $data;
	if($user['user_move'] == 0 || $user['last_action'] < calMinutes(60)){
		return true;
	}
}
function joinRoomMessage($room){
	global $lang, $data;
	if(useLogs(1) && moveMessage($data) && isVisible($data)){
		$content = str_replace('%user%', systemNameFilter($data), $lang['system_join_room']);
		systemPostChat($room, $content, array('type'=> 'system__join'));
	}
}
function changeNameLog($user, $n){
	global $lang;
	nameRecord($user, $n);
	if(useLogs(2) && isVisible($user)){
		$content = str_replace('%user%', $user['user_name'], $lang['system_name_change']);
		$user['user_name'] = $n;
		$content = str_replace('%nname%', systemNameFilter($user), $content);
		systemPostChat($user['user_roomid'], $content, array('type'=> 'system__action'));
	}
}
function kickLog($user){
	global $lang;
	if(useLogs(3) && userInRoom($user)){
		$content = str_replace('%user%', systemNameFilter($user), $lang['system_kick']);
		systemPostChat($user['user_roomid'], $content, array('type'=> 'system__action'));
	}
}
function banLog($user){
	global $lang;
	if(useLogs(3) && userInRoom($user)){
		$content = str_replace('%user%', systemNameFilter($user), $lang['system_ban']);
		systemPostChat($user['user_roomid'], $content, array('type'=> 'system__action'));
	}
}
function muteLog($user){
	global $lang;
	if(useLogs(3) && userInRoom($user)){
		$content = str_replace('%user%', systemNameFilter($user), $lang['system_mute']);
		systemPostChat($user['user_roomid'], $content, array('type'=> 'system__action'));
	}
}
function blockLog($user){
	global $lang;
	if(useLogs(3) && userInRoom($user)){
		$content = str_replace('%user%', systemNameFilter($user), $lang['system_block']);
		systemPostChat($user['user_roomid'], $content, array('type'=> 'system__action'));
	}
}
function processUserData($t){
	global $data;
	return str_replace(array('%user%'), array($data['user_name']), $t);
}
function autoRoomStaff(){
	return true;
}
function roomStaff(){
	if(boomRole(4)){
		return true;
	}
}
function userRoomStaff($rank){
	if($rank >= 4){
		return true;
	}
}
function isVisible($user){
	if($user['user_status'] != 99){
		return true;
	}
}
function isSecure($user){
	if(isEmail($user['user_email'])){
		return true;
	}
}
function isMember($user){
	if(!isGuest($user) && !isBot($user)){
		return true;
	}
}
function isGuest($user){
	if($user['user_rank'] == 0){
		return true;
	}
}
function isPaidVip($user){
	if($user['user_rank'] == 50 && $user['vip_end'] > time()){
		return true;
	}
}
function guestForm(){
	global $setting;
	if($setting['guest_form'] == 1){
		return true;
	}
}
function userDj($user){
	if($user['user_dj'] == 1){
		return true;
	}
}
function boomRecaptcha(){
	global $setting;
	if($setting['use_recapt'] > 0){
		return true;
	}
}
function minCall(){
	global $setting;
	return min($setting['can_vcall'], $setting['can_acall']);
}

function encrypt($d){
	return sha1(str_rot13($d . BOOM_CRYPT));
}
function boomEncrypt($d, $encr){
	return sha1(str_rot13($d . $encr));
}
function getDelay(){
	return time() - 75;
}
function delDelay(){
	return calDayUp(7);
}
function getMinutes($t){
	return $t / 60;
}
function isOwner($user){
	if($user['user_rank'] == 100){
		return true;
	}
}
function isStaff($user){
	if($user['user_rank'] >= 70){
		return true;
	}
}
function isStaffRank($rank){
	if($rank >= 70){
		return true;
	}
}
function genKey(){
	return md5(rand(10000,99999) . rand(10000,99999));
}
function genCode(){
	return rand(111111,999999);
}
function randomKey($v){
	$text = 'abcdefghijklmnopqrstuvwxyz01234567890';
	$text = substr(str_shuffle($text), 0, $v);
	return $text;
}
function boomUnderClear($t){
	return str_replace('_', ' ', $t);
}
function allowGuest(){
	global $setting;
	if($setting['allow_guest'] == 1){
		return true;
	}
}
function clearNotifyAction($id, $type){
	global $mysqli;
	$mysqli->query("DELETE FROM boom_notification WHERE notified = '$id' AND notify_source = '$type'");
}
function clearNotifyType($id, $type){
	global $mysqli;
	$mysqli->query("DELETE FROM boom_notification WHERE notified = '$id' AND notify_type = '$type'");
}
function boomDuplicateIp($val){
	global $mysqli;
	$dupli = $mysqli->query("SELECT * FROM `boom_banned` WHERE `ip` = '$val'");
	if($dupli->num_rows > 0){
		return true;
	}
}

// sex and gender and status functions

function genderList(){
	return array(1,2,3);
}

function genderOption($current, $val){
	return '<option value="' . $val . '" ' . selCurrent($current, $val) . '>' . genderTitle($val) . '</option>';
}

function listGender($current){
	$gender = '';
	foreach(genderList() as $val){
		$gender .= genderOption($current, $val);
	}
	return $gender;
}
function validGender($sex){
	$gender = genderList();
	if(in_array($sex, $gender)){
		return true;
	}
}
function genderTitle($s){
	global $lang;
	switch($s){
		case 1:
			return $lang['male'];
		case 2:
			return $lang['female'];
		case 3:
			return $lang['other'];
		default:
			return $lang['other'];
	}
}

function genderBorder($s){
	global $setting;
	if($setting['use_gender'] > 0){
		switch($s){
			case 1:
				return 'avagen genmale';
			case 2:
				return 'avagen genfemale';
			case 3:
				return 'avagen genother';
			default:
				return 'avagen genother';
		}
	}
}

// card share data

function uGender($user){
	if(userShareGender($user)){
		return $user['user_sex'];
	}
	return 0;
}
function uAge($user){
	if(userShareAge($user)){
		return $user['user_age'];
	}
	return 0;
}

function uCountry($user){
	if(userShareLocation($user)){
		return $user['country'];
	}
	return 'ZZ';
}

/* main ranking functions */

function systemRank($rank, $type){
	return '<img src="default_images/rank/' . rankIcon($rank) . '" data-r="' . $rank . '" class="' . $type . '"/>';
}
function roomRank($rank, $type){
	if($rank > 0){
		return '<img src="default_images/rank/' . roomRankIcon($rank) . '" data-r="' . $rank . '" class="' . $type . '"/>';
	}
}
function chatRank($user, $type = 'chat_rank'){
	if(isBot($user)){
		return;
	}
	return systemRank($user['user_rank'], $type);
}
function jsonRankTitle(){
	$s = [];
	foreach(rankList() as $r){
		$s[$r] =  rankTitle($r);
	}
	return json_encode($s);
}
function jsonRankIcon(){
	$s = [];
	foreach(rankList() as $r){
		$s[$r] =  rankIcon($r);
	}
	return json_encode($s);
}
function jsonRoomRankIcon(){
	$s = [];
	foreach(roomRankList() as $r){
		$s[$r] =  roomRankIcon($r);
	}
	return json_encode($s);
}
function jsonRoomRankTitle(){
	$s = [];
	foreach(roomRankList() as $r){
		$s[$r] =  roomRankTitle($r);
	}
	return json_encode($s);
}
function jsonStatusIcon(){
	$s = [];
	foreach(statusList() as $r){
		$s[$r] =  statusIcon($r);
	}
	return json_encode($s);
}
function jsonStatusTitle(){
	$s = [];
	foreach(statusList() as $r){
		$s[$r] =  statusTitle($r);
	}
	return json_encode($s);
}
function jsonGenderTitle(){
	$s = [];
	foreach(genderList() as $r){
		$s[$r] =  genderTitle($r);
	}
	return json_encode($s, JSON_FORCE_OBJECT);
}

// blocked feature

function featureBlock($v){
	if($v == 1){
		return true;
	}
}

// permission functions

function canGhost(){
	global $setting;
	if(boomAllow($setting['can_ghost'])){
		return true;
	}
}
function canEditRoom(){
	global $setting;
	if(boomRole(6) || boomAllow($setting['can_raction'])){
		return true;
	}
}
function canPrivate(){
	global $setting, $data;
	if(boomAllow($setting['allow_private']) && !isPrivateMuted($data)){
		return true;
	}
}
function userCanPrivate($user){
	global $setting, $data;
	if(userBoomAllow($user, $setting['allow_private']) && !isPrivateMuted($user)){
		return true;
	}
}
function canMain(){
	global $setting;
	if(boomAllow($setting['allow_main'])){
		return true;
	}
}
function isActProof(){
	if(boomAllow(70)){
		return true;
	}
}
function isWordProof(){
	global $setting;
	if(boomAllow($setting['word_proof'])){
		return true;
	}
}
function canQuote(){
	global $setting;
	if(boomAllow($setting['allow_quote'])){
		return true;
	}
}
function canPrivateQuote(){
	global $setting;
	if(boomAllow($setting['allow_pquote'])){
		return true;
	}
}
function canViewInvisible(){
	if(boomAllow(100)){
		return true;
	}
}
function canViewWallet($user){
	global $setting;
	if(mySelf($user['user_id']) || isBot($user) || isGuest($user)){
		return false;
	}
	if(useWallet() && boomAllow($setting['can_vwallet'])){
		return true;
	}
}
function canDeleteSelfLog($p){
	global $setting, $data;
	if($p['user_id'] == $data['user_id'] && boomAllow($setting['allow_scontent'])){
		return true;
	}
}
function canDeleteContent(){
	global $setting;
	if(boomAllow($setting['can_content'])){
		return true;
	}
}
function canReport(){
	global $setting;
	if(boomAllow($setting['allow_report'])){
		return true;
	}
}
function canManageReport(){
	if(boomAllow(70)){
		return true;
	}
}
function canDeletePrivate(){
	global $setting;
	if(boomAllow($setting['allow_scontent'])){
		return true;
	}
}
function canDeleteRoomLog(){
	global $setting;
	if(boomRole($setting['can_rlogs'])){
		return true;
	}
}
function canClearRoom(){
	global $setting;
	if(boomAllow($setting['can_clear']) || boomRole($setting['can_rclear'])){
		return true;
	}
}
function canViewGhost(){
	global $setting;
	if(boomAllow($setting['can_vghost'])){
		return true;
	}
}

/* icons function */

function rubyIcon(){
	return 'default_images/icons/ruby.svg';
}
function goldIcon(){
	return 'default_images/icons/gold.svg';
}
function giftIcon(){
	return 'default_images/icons/gift.svg';
}
function levelIcon(){
	return 'default_images/icons/level.svg';
}
function likeIcon(){
	return 'default_images/icons/like.svg';
}
function xpIcon(){
	return 'default_images/icons/xp.svg';
}

/* feature */

function featureCost($a, $t){
	return $a . ' ' . walletTitle($t);
}

/* bank functions */

function useWallet(){
	global $setting;
	if($setting['use_wallet'] > 0){
		return true;
	}
}
function walletBalance($type, $amount){
	global $data;
	if($type == 1 && goldBalance($amount)){
		return true;
	}
	if($type == 2 && rubyBalance($amount)){
		return true;
	}
}
function removeWallet($user, $type, $amount){
	if($type == 1){
		removeGold($user, $amount);
	}
	else if($type == 2){
		removeRuby($user, $amount);
	}
}
function walletTitle($type){
	global $lang;
	switch($type){
		case 1:
			return $lang['gold'];
		case 2:
			return $lang['ruby'];
		default:
			return $lang['gold'];
	}
}
function canShareWallet($user){
	global $setting;
	if(!useWallet() || isBot($user) || ignored($user) || ignoring($user)){
		return false;
	}
	if(boomAllow($setting['can_swallet'])){
		return true;
	}
}
function walletIcon($type){
	switch($type){
		case 1:
			return goldIcon();
		case 2:
			return rubyIcon();
		default:
			return goldIcon();
	}
}
function canGoldReward(){
	global $setting, $data;
	if($setting['gold_base'] > 0 && boomAllow($setting['can_gold']) && $data['last_gold'] <= calMinutes($setting['gold_delay'])){
		return true;
	}
}
function canRubyReward(){
	global $setting, $data;
	if($setting['ruby_base'] > 0 && boomAllow($setting['can_ruby']) && $data['last_ruby'] <= calMinutes($setting['ruby_delay'])){
		return true;
	}
}
function canReceiveGold($user){
	global $setting;
	if(!isBot($user)){
		return true;
	}
}
function goldBalance($gold){
	global $data;
	if($data['user_gold'] >= $gold){
		return true;
	}
}
function rubyBalance($ruby){
	global $data;
	if($data['user_ruby'] >= $ruby){
		return true;
	}
}
function addRuby($user, $ruby){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_ruby = user_ruby + '$ruby' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function removeRuby($user, $ruby){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_ruby = user_ruby - '$ruby', user_sruby = user_sruby + '$ruby' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function addGold($user, $gold){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_gold = user_gold + '$gold' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function removeGold($user, $gold){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_gold = user_gold - '$gold', user_sgold = user_sgold + '$gold' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function minGold(){
	return 250;
}
function maxGold(){
	return 25000;
}
function minRuby(){
	return 20;
}
function maxRuby(){
	return 5000;
}
function validGold($n){
	if($n >= minGold() && $n <= maxGold()){
		return true;
	}
}
function validRuby($n){
	if($n >= minRuby() && $n <= maxRuby()){
		return true;
	}
}
function costTag($type, $amount, $class = ''){
	$tg = [
		'icon' 	=> walletIcon($type),
		'amount' => $amount,
		'class' => $class,
	];
	return boomTemplate('element/cost_tag', $tg);
}
function costTags($type, $amount, $args = array()){
	$tg = [
		'icon' 	=> walletIcon($type),
		'amount' => $amount,
		'class' => '',
		'text' => '',
	];
	$r = array_merge($tg, $args);
	return boomTemplate('element/cost_tags', $r);
}

/* gift functions */

function giftImage($i){
	return 'gift/' . $i;
}
function useGift(){
	global $setting;
	if(!useWallet()){
		return false;
	}
	if($setting['use_gift'] > 0){
		return true;
	}
}
function canSendGift($user){
	if(!useGift()){
		return false;
	}
	if(isBot($user)){
		return false;
	}
	if(ignored($user) || ignoring($user)){
		return false;
	}
	return true;
}
function giftDetails($id){
	global $mysqli;
	$gift = [];
	$get_gift = $mysqli->query("SELECT * FROM boom_gift WHERE id = '$id'");
	if($get_gift->num_rows > 0){
		$gift = $get_gift->fetch_assoc();
	}
	return $gift;
}
function giftRecord($user, $gift){
	global $mysqli;
	$check_gift = $mysqli->query("SELECT id FROM boom_users_gift WHERE target = '{$user['user_id']}' AND gift = '{$gift['id']}'");
	if($check_gift->num_rows > 0){
		$mysqli->query("UPDATE boom_users_gift SET gift_count = gift_count + 1, gift_date = '" . time() . "' WHERE target = '{$user['user_id']}' AND gift = '{$gift['id']}'");
	}
	else {
		$mysqli->query("INSERT INTO `boom_users_gift` (target, gift, gift_date) VALUES ('{$user['user_id']}','{$gift['id']}',".time().")");
	}
}

/* flood functions */

function checkFlood(){
	global $setting, $data;
	if(!isActProof()){
		if(!isset($_SESSION[BOOM_PREFIX . 'post_time'], $_SESSION[BOOM_PREFIX . 'post_count']) || $_SESSION[BOOM_PREFIX . 'post_time'] < (time() - 10)){
			$_SESSION[BOOM_PREFIX . 'post_time'] = time();
			$_SESSION[BOOM_PREFIX . 'post_count'] = 1;
			return false;
		}
		if($_SESSION[BOOM_PREFIX . 'post_count'] >= $setting['max_flood']){
			if($setting['flood_action'] == 1){
				systemFloodKick($data);
				return true;
			}
			else if($setting['flood_action'] == 2){
				systemFloodMute($data);
				return true;
			}
		}
		$_SESSION[BOOM_PREFIX . 'post_count']++;
	}
}

/* save db to cached file */

function boomSaveSettings(){
	global $mysqli;
	$mysqli->query("UPDATE boom_setting SET curset = curset + 1 WHERE id = 1");
	if(is_writable(BOOM_PATH . '/system/settings.php')){
		$q = $mysqli->query("SELECT * FROM boom_setting WHERE id = 1");
		$f = '';
		while($d = $q->fetch_assoc()){
			foreach($d as $key => $value){
				$f .= '$setting[\'' . $key . '\'] = \'' . addslashes($value) . '\';' . "\n";
			}
		}
		$g = "<?php\n$f?>";
		$f = fopen(BOOM_PATH . '/system/settings.php', "w+") or die();
		fwrite($f,$g);
		fclose($f);
	}
}
function reloadSettings(){
	global $setting;
	return [
		'avatarmax' => (int) $setting['max_avatar'],
		'covermax' => (int) $setting['max_cover'],
		'riconmax' => (int) $setting['max_ricon'],
		'filemax' => (int) $setting['file_weight'],
		'speed' => (int) $setting['speed'],
		'cancall'=> (int) minCall(),
		'usecall'=> (int) $setting['use_call'],
		'inout' => (int) $setting['act_delay'],
		'uquote' => (int) $setting['allow_quote'],
		'upquote' => (int) $setting['allow_pquote'],
		'primin' => (int) $setting['allow_private'],
		'canscontent' => (int) $setting['allow_scontent'],
		'cancontent' => (int) $setting['can_content'],
		'canrlogs' => (int) $setting['can_rlogs'],
		'canreport' => (int) $setting['allow_report'],
		'maxemo' => (int) $setting['max_emo'],
		'privload' => (int) $setting['privload'],
		'curset' => (int) $setting['curset'],
		'uselevel' => (int) $setting['use_level'],
		'usebadge' => (int) $setting['use_badge'],
	];
}

// element details functions

function userDetails($id){
	global $mysqli;
	$user = [];
	if(($cache = redisGetObject('user:' . $id))){
		return $cache;
	}
	$getuser = $mysqli->query("SELECT * FROM boom_users WHERE user_id = '$id'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
		redisSetObject('user:' . $id, $user);
	}
	return $user;
}
function userProfileDetails($id){
	global $mysqli;
	$user = userDetails($id);
	if(!empty($user)){
		$getuser = $mysqli->query("
			SELECT boom_users_data.*, boom_rooms.room_id, boom_rooms.room_name
			FROM boom_users_data
			LEFT JOIN boom_rooms ON boom_rooms.room_id = '{$user['user_roomid']}'
			WHERE uid = '{$user['user_id']}';
		");
		if($getuser->num_rows > 0){
			return array_merge($user, $getuser->fetch_assoc());
		}
	}
	return [];
}
function joinProfileDetails($user){
	global $mysqli;
	$getuser = $mysqli->query("SELECT boom_users_data.* FROM boom_users_data WHERE uid = '{$user['user_id']}'");
	if($getuser->num_rows > 0){
		return array_merge($user, $getuser->fetch_assoc());
	}
	return $user;
}
function userChatDetails($id){
	global $mysqli;
	$user = [];
	if(($cache = redisGetObject('cuser:' . $id))){
		return $cache;
	}
	$getuser = $mysqli->query("
	SELECT
	user_id, user_name, user_password, user_join, last_action, user_language, user_timezone, user_status, user_rank, user_level, user_roomid, session_id, pcount,
	pdel, pdeltime, user_news, user_ghost, user_mute, user_rmute, user_mmute, user_pmute, user_banned, user_kick, warn_msg, user_role, user_action, room_mute, naction, user_ruby, last_ruby, user_gold, last_gold, ucall,
	(SELECT count(*) FROM boom_conversation WHERE target = '$id' AND unread > 0) as private_count
	FROM boom_users WHERE user_id = '$id'
	");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
		redisSetObject('cuser:' . $id, $user);
	}
	return $user;
}
function userNameDetails($name){
	global $mysqli;
	$user = [];
	$getuser = $mysqli->query("SELECT * FROM boom_users WHERE user_name = '$name'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
	}
	return $user;
}
function userRoomDetails($id, $room = ''){
	global $mysqli, $data;
	if(empty($room)){
		$room = $data['user_roomid'];
	}
	$user = userDetails($id);
	if(!empty($user)){
		$getuser = $mysqli->query("
			SELECT
			IFNULL((SELECT action_muted FROM boom_room_action WHERE action_user = '$id' AND action_room = '$room'), 0) as room_muted,
			IFNULL((SELECT action_blocked FROM boom_room_action WHERE action_user = '$id' AND action_room = '$room'), 0) as room_blocked,
			IFNULL((SELECT room_rank FROM boom_room_staff WHERE room_staff = '$id' AND room_id = '$room'), 0) as room_ranking
		");
		if($getuser->num_rows > 0){
			return array_merge($user, $getuser->fetch_assoc());
		}
	}
	return [];
}
function userRelationDetails($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(!empty($user)){
		$getuser = $mysqli->query("
			SELECT
			IFNULL((SELECT fstatus FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id'), 0) as friendship,
			(SELECT count(ignore_id) FROM boom_ignore WHERE ignorer = '$id' AND ignored = '{$data['user_id']}' ) as ignored,
			(SELECT count(ignore_id) FROM boom_ignore WHERE ignorer = '{$data['user_id']}' AND ignored = '$id') as ignoring
		");
		if($getuser->num_rows > 0){
			return array_merge($user, $getuser->fetch_assoc());
		}
	}
	return [];
}
function userFullDetails($id, $room = ''){
	global $mysqli, $data;
	if($room == ''){
		$room = $data['user_roomid'];
	}
	$user = userDetails($id);
	if(!empty($user)){
		$getuser = $mysqli->query("
			SELECT
			IFNULL((SELECT fstatus FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id'), 0) as friendship,
			(SELECT count(ignore_id) FROM boom_ignore WHERE ignorer = '$id' AND ignored = '{$data['user_id']}' ) as ignored,
			(SELECT count(ignore_id) FROM boom_ignore WHERE ignorer = '{$data['user_id']}' AND ignored = '$id') as ignoring,
			IFNULL((SELECT action_muted FROM boom_room_action WHERE action_user = '$id' AND action_room = '$room'), 0) as room_muted,
			IFNULL((SELECT action_blocked FROM boom_room_action WHERE action_user = '$id' AND action_room = '$room'), 0) as room_blocked,
			IFNULL((SELECT room_rank FROM boom_room_staff WHERE room_staff = '$id' AND room_id = '$room'), 0) as room_ranking
		");
		if($getuser->num_rows > 0){
			return array_merge($user, $getuser->fetch_assoc());
		}
	}
	return [];
}
function userDataDetails($user, $key){
	global $mysqli;
	$d = '';
	if(redisCacheExist('data:' . $key . ':' . $user['user_id'])){
		return redisGetElement('data:' . $key . ':' . $user['user_id']);
	}
	else {
		$get_data = $mysqli->query("SELECT * FROM boom_data WHERE data_user = '{$user['user_id']}' AND data_key = '$key'");
		if($get_data->num_rows > 0){
			$dv = $get_data->fetch_assoc();
			$d = $dv['data_value'];
		}
		redisSetElement('data:' . $key . ':' . $user['user_id'], $d);
		return $d;
	}
}
function getUserData($user, $type){
	global $mysqli;
	$d = '';
	$get_data = $mysqli->query("SELECT $type FROM boom_users_data WHERE uid = '{$user['user_id']}'");
	if($get_data->num_rows > 0){
		$res = $get_data->fetch_assoc();
		$d = $res[$type];
	}
	return $d;
}
function myRoomDetails($r){
	global $mysqli, $data;
	$room = roomDetails($r);
	if(!empty($room)){
		$getroom = $mysqli->query("
			SELECT
			IFNULL((SELECT action_muted FROM boom_room_action WHERE action_user = '{$data['user_id']}' AND action_room = '$r'), 0) as room_muted,
			IFNULL((SELECT action_blocked FROM boom_room_action WHERE action_user = '{$data['user_id']}' AND action_room = '$r'), 0) as room_blocked,
			IFNULL((SELECT room_rank FROM boom_room_staff WHERE room_staff = '{$data['user_id']}' AND room_id = '$r'), 0) as room_ranking
		");
		if($getroom->num_rows > 0){
			return array_merge($room, $getroom->fetch_assoc());
		}
	}
	return [];
}
function roomDetails($id){
	global $mysqli;
	$room = [];
	if(($cache = redisGetObject('room:' . $id))){
		return $cache;
	}
	$get_room = $mysqli->query("SELECT * FROM boom_rooms WHERE room_id = '$id'");
	if($get_room->num_rows > 0){
		$room = $get_room->fetch_assoc();
		redisSetObject('room:' . $id, $room);
	}
	return $room;
}
function playerDetails($id){
	global $mysqli, $setting;
	$player['stream_url'] = '';
	$player['stream_title'] = '';
	if(usePlayer()){
		if($id == 0){
			$id = $setting['player_id'];
		}
		if(($cache = redisGetObject('player:' . $id))){
			return $cache;
		}
		$get_player = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id = '$id'");
		if($get_player->num_rows > 0){
			$player = $get_player->fetch_assoc();
			redisSetObject('player:' . $id, $player);
		}
	}
	return $player;
}
function settingDetails(){
	global $mysqli;
	$get_setting = $mysqli->query("SELECT * FROM boom_setting WHERE id = 1");
	$set = $get_setting->fetch_assoc();
	return $set;
}
function addonsDetails($name){
	global $mysqli;
	$addons = [];
	if(($cache = redisGetObject('addons:' . $name))){
		return $cache;
	}
	$geta = $mysqli->query("SELECT * FROM boom_addons WHERE addons = '$name'");
	if($geta->num_rows > 0){
		$addons = $geta->fetch_assoc();
		redisSetObject('addons:' . $name, $addons);
	}
	return $addons;
}
function notifyDetails($id){
	global $mysqli;
	$notify = [];
	$get_notify = $mysqli->query("SELECT * FROM boom_notification WHERE id = '$id'");
	if($get_notify->num_rows > 0){
		$notify = $get_notify->fetch_assoc();
	}
	return $notify;
}
function logDetails($id){
	global $mysqli;
	$log = [];
	$get_log = $mysqli->query("SELECT * FROM boom_chat WHERE post_id = '$id'");
	if($get_log->num_rows > 0){
		$log = $get_log->fetch_assoc();
	}
	return $log;
}
function privateLogDetails($id){
	global $mysqli;
	$log = [];
	$get_log = $mysqli->query("SELECT * FROM boom_private WHERE id = '$id'");
	if($get_log->num_rows > 0){
		$log = $get_log->fetch_assoc();
	}
	return $log;
}
function reportDetails($id){
	global $mysqli;
	$rep = [];
	$get_report = $mysqli->query("SELECT * FROM boom_report WHERE report_id = '$id'");
	if($get_report->num_rows > 0){
		$rep = $get_report->fetch_assoc();
	}
	return $rep;
}

// base config files functions

function getUserSession($ident, $pass){
	global $mysqli;
	$user = userDetails($ident);
	if(empty($user) || $user['user_password'] != $pass){
		return [];
	}
	return $user;
}

function getUserChatSession($ident, $pass){
	global $mysqli;
	$user = userChatDetails($ident);
	if(empty($user) || $user['user_password'] != $pass){
		return [];
	}
	return $user;
}

// user notification

function getNotification(){
	global $mysqli, $data;
	$rep = '';
	if(canManageReport()){
		$rep = '(SELECT count(*) FROM boom_report) as report_count,';
	}
	$get_notify = $mysqli->query("SELECT
	(SELECT count(*) FROM boom_friends WHERE target = '{$data['user_id']}' AND fstatus = '2' AND viewed = '0') as friend_count,
	(SELECT count(*) FROM boom_notification WHERE notified = '{$data['user_id']}' AND notify_view = '0') as notify_count, $rep
	(SELECT count(*) FROM boom_news WHERE news_date > '{$data['user_news']}') as news_count
	");
	$fetch = $get_notify->fetch_assoc();
	if(!canManageReport()){
		$fetch['report_count'] = 0;
	}
	return [
		'friends'=> (int) $fetch['friend_count'],
		'notify'=> (int) $fetch['notify_count'],
		'news'=> (int) $fetch['news_count'],
		'report'=> (int) $fetch['report_count'],
		'nnotif'=> (int) $data['naction'],
	];
}

// room data

function createRoomData($room){
	global $data;
	if(empty($room)){
		return [];
	}
	return [
		'room_id'=> (int) $room['room_id'], 
		'room_name'=> $room['room_name'],
		'room_icon'=> myRoomIcon($room['room_icon']),
		'room_topic'=> getTopic($room),
		'room_action'=> (int) $room['rcaction'],
		'room_role'=> (int) $data['user_role'],
		'room_logs'=> getChatHistory($room['room_id']),
	];
}

// save user data functions

function saveUserData($user, $key, $value){
	global $mysqli;
	$get_data = $mysqli->query("SELECT id FROM boom_data WHERE data_user = '{$user['user_id']}' AND data_key = '$key'");
	if($get_data->num_rows > 0){
		$mysqli->query("UPDATE boom_data SET data_value = '$value' WHERE data_user = '{$user['user_id']}' AND data_key = '$key'");
	}
	else {
		$mysqli->query("INSERT INTO boom_data (data_user, data_key, data_value) VALUES ('{$user['user_id']}', '$key', '$value')");
	}
	redisDel('data:' . $key . ':' . $user['user_id']);
}

// topic

function getTopic($room){
	global $lang;
	$topic = processUserData($room['topic']);
	if(!empty($topic)){
		return [
			'room'=> (int) $room['room_id'],
			'icon'=> specialLogIcon('topic.svg'), 
			'title'=> $lang['topic_title'],
			'content'=> $topic
		];
	}
	else {
		return [];
	}
}

// create logs

function createLog($log, $quote = []){
	global $data;
	if(isGhosted($data)){
		$log['pghost'] = 0;
	}
	if($log['qpost'] > 0 && empty($quote)){
		$quote = quoteDetails($log['qpost']);
	}
	if(empty($quote)){
		$quote_data = null;
	}
	else {
		$quote_data = [
			'qid'=> (int) $quote['post_id'],
			'quser'=> (int) $quote['user_id'],
			'qname'=> $quote['user_name'],
			'qtumb'=> $quote['user_tumb'],
			'qcontent'=> processQuoteMessage($quote['post_message']),
		];
	}
	return [
		'user_id'=> (int) $log['user_id'],
		'user_name'=> $log['user_name'],
		'user_rank'=> (int) $log['user_rank'],
		'user_level'=> (int) $log['user_level'],
		'user_tumb'=> $log['user_tumb'],
		'user_cover'=> $log['user_cover'],
		'user_color'=> myColorFont($log),
		'user_tcolor'=> $log['tcolor'],
		'user_bot'=> (int) $log['user_bot'],
		'user_gender'=> uGender($log),
		'gborder'=> genderBorder($log['user_sex']),
		'user_country'=> uCountry($log),
		'user_age'=> uAge($log),
		'user_roomid'=> (int) $log['post_roomid'],
		'log_id'=> (int) $log['post_id'],
		'log_type'=> $log['type'],
		'log_content'=> processChatMessage($log),
		'log_date'=> chatDate($log['post_date']),
		'log_rank'=> (int) $log['log_rank'],
		'log_sys'=> (int) $log['syslog'],
		'log_uid'=> (int) $log['log_uid'],
		'quote'=> $quote_data,
		'gpost'=> (int) $log['pghost'],
	];
}
function exportLogs($logs, $last = ''){
	$result = [];
	foreach($logs as $log){
		$result[] = createLog($log);
	}
	return $result;
}
function getChatLog($id){
	global $mysqli;
	$log = [];
	$get_log = $mysqli->query("
		SELECT boom_chat.*,
		boom_users.user_name, boom_users.user_color, boom_users.user_font, boom_users.user_rank, boom_users.user_level, boom_users.bccolor, boom_users.user_sex, boom_users.user_age, boom_users.user_tumb,
		boom_users.user_cover, boom_users.country, boom_users.user_bot, boom_users.ashare, boom_users.sshare, boom_users.lshare
		FROM boom_chat
		LEFT JOIN boom_users ON boom_users.user_id = boom_chat.user_id
		WHERE boom_chat.post_id = '$id'
	");
	if($get_log->num_rows == 1){
		$log = $get_log->fetch_assoc();
	}
	return $log;
}
function getChatLogs($room, $last){
	global $mysqli, $data;
	$history = 24;
	$add = '';
	if(!isGhosted($data) && !canViewGhost()){
		$add = 'AND pghost = 0';
	}
	$log = $mysqli->query("
	SELECT log.*, 
	boom_users.user_name, boom_users.user_color, boom_users.user_font, boom_users.user_rank, boom_users.user_level, boom_users.bccolor, boom_users.user_sex, boom_users.user_age, boom_users.user_tumb,
	boom_users.user_cover, boom_users.country, boom_users.user_bot, boom_users.ashare, boom_users.sshare, boom_users.lshare
	FROM ( SELECT * FROM `boom_chat` WHERE `post_roomid` = '$room' AND post_id > '$last' $add ORDER BY `post_id` DESC LIMIT $history) AS log
	LEFT JOIN boom_users ON log.user_id = boom_users.user_id
	ORDER BY `post_id` ASC
	");
	$logs = $log->fetch_all(MYSQLI_ASSOC);
	return exportLogs($logs);
}
function getChatHistory($room){
	global $mysqli, $data;
	$history = 20;
	$add = '';
	if(!isGhosted($data) && !canViewGhost()){
		$add = 'AND pghost = 0';
	}
	$log = $mysqli->query("
	SELECT log.*,
	boom_users.user_name, boom_users.user_color, boom_users.user_font, boom_users.user_rank, boom_users.user_level, boom_users.bccolor, boom_users.user_sex, boom_users.user_age, boom_users.user_tumb,
	boom_users.user_cover, boom_users.country, boom_users.user_bot, boom_users.ashare, boom_users.sshare, boom_users.lshare
	FROM ( SELECT * FROM `boom_chat` WHERE `post_roomid` = '$room' $add ORDER BY `post_id` DESC LIMIT $history) AS log
	LEFT JOIN boom_users ON log.user_id = boom_users.user_id
	ORDER BY `post_id` ASC
	");
	$logs = $log->fetch_all(MYSQLI_ASSOC);
	return exportLogs($logs);
}
function getMoreChatHistory($last){
	global $mysqli, $setting, $data;
	$history = 60;
	$add = '';
	if(!isGhosted($data) && !canViewGhost()){
		$add = 'AND pghost = 0';
	}
	$log = $mysqli->query("
	SELECT log.*, 
	boom_users.user_name, boom_users.user_color, boom_users.user_font, boom_users.user_rank, boom_users.user_level, boom_users.bccolor, boom_users.user_sex, boom_users.user_age, boom_users.user_tumb,
	boom_users.user_cover, boom_users.country, boom_users.user_bot, boom_users.ashare, boom_users.sshare, boom_users.lshare
	FROM ( SELECT * FROM `boom_chat` WHERE `post_roomid` = '{$data['user_roomid']}' AND post_id < '$last' AND user_id != '{$setting['system_id']}' $add ORDER BY `post_id` DESC LIMIT $history) AS log
	LEFT JOIN boom_users ON log.user_id = boom_users.user_id
	ORDER BY `post_id` ASC
	");
	$logs = $log->fetch_all(MYSQLI_ASSOC);
	return exportLogs($logs);
}

// private chat

function createPrivateLog($log, $quote = []){
	if($log['qpost'] > 0 && empty($quote)){
		$quote = privateQuoteDetails($log['qpost']);
	}
	if(empty($quote)){
		$quote_data = null;
	}
	else {
		$quote_data = [
			'qpost'=> (int) $quote['id'],
			'qcontent'=> processQuoteMessage($quote['message']),
		];
	}
	return [
		'user_id'=> (int) $log['user_id'],
		'user_name'=> $log['user_name'],
		'user_tumb'=> $log['user_tumb'],
		'log_id'=> (int) $log['id'],
		'log_content'=> processPrivateMessage($log),
		'log_date'=> chatDate($log['time']),
		'quote'=> $quote_data,
	];
}
function exportPrivateLogs($logs){
	$result = [];
	foreach($logs as $log){
		$result[] = createPrivateLog($log);
	}
	return $result;
}
function getPrivateLog($id){
	global $mysqli;
	$log = [];
	$get_log = $mysqli->query("
		SELECT boom_private.*, 
		boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot
		FROM boom_private
		LEFT JOIN boom_users ON boom_private.hunter = boom_users.user_id
		WHERE boom_private.id = '$id'
		
	");
	if($get_log->num_rows == 1){
		$log = $get_log->fetch_assoc();
	}
	return $log;
}
function getPrivateLogs($p, $l){
	global $mysqli, $data;
	$log = $mysqli->query("
	SELECT log.*, 
	boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot
	FROM ( SELECT * FROM `boom_private` WHERE  `hunter` = '$p' AND `target` = '{$data['user_id']}' AND id > '$l' OR hunter = '{$data['user_id']}' AND target = '$p' AND id > '$l' ORDER BY `id` DESC LIMIT 10) AS log 
	LEFT JOIN boom_users ON log.hunter = boom_users.user_id ORDER BY `id` ASC
	");
	if($log->num_rows > 0){
		readConv($p, $data['user_id']);
	}
	$logs = $log->fetch_all(MYSQLI_ASSOC);
	return exportPrivateLogs($logs);
}
function getPrivateHistory($p){
	global $mysqli, $data;
	$log = $mysqli->query("
	SELECT log.*, 	
	boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot
	FROM ( SELECT * FROM `boom_private` WHERE  `hunter` = '{$data['user_id']}' AND `target` = '$p'  OR `hunter` = '$p' AND `target` = '{$data['user_id']}' ORDER BY `id` DESC LIMIT 14) AS log 
	LEFT JOIN boom_users ON log.hunter = boom_users.user_id ORDER BY `id` ASC
	");
	$logs = $log->fetch_all(MYSQLI_ASSOC);
	readConv($p, $data['user_id']);
	return exportPrivateLogs($logs);
}
function getMorePrivateHistory($p, $l){
	global $mysqli, $data;
	$log = $mysqli->query("
	SELECT log.*, 	
	boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot
	FROM ( SELECT * FROM `boom_private` WHERE  `hunter` = '{$data['user_id']}' AND `target` = '$p' AND id < '$l' OR `hunter` = '$p' AND `target` = '{$data['user_id']}'  AND id < '$l' ORDER BY `id` DESC LIMIT 30) AS log 
	LEFT JOIN boom_users ON log.hunter = boom_users.user_id ORDER BY `id` ASC
	");
	$logs = $log->fetch_all(MYSQLI_ASSOC);
	return exportPrivateLogs($logs);
}
function countryFlag($country){
	switch($country){
		case '':
		case 'ZZ':
			return '';
		default:
			return 'system/location/flag/' . $country . '.png';
	}
}
function checkRateLimit(){
	global $setting;
	if($setting['use_rate'] == 1){
		if(isset($_SESSION[BOOM_PREFIX . 'fignore']) && $_SESSION[BOOM_PREFIX . 'fignore'] > time()){
			return true;
		}
		if(!isset($_SESSION[BOOM_PREFIX .'ftime']) || $_SESSION[BOOM_PREFIX . 'ftime'] < (time() - 20)){
			$_SESSION[BOOM_PREFIX . 'ftime'] = time();
			$_SESSION[BOOM_PREFIX . 'fcount'] = 1;
			return false;
		}
		else if($_SESSION[BOOM_PREFIX . 'fcount'] >= $setting['rate_limit']){
			$_SESSION[BOOM_PREFIX . 'fignore'] = (time() + 300);
			return true;
		}
		$_SESSION[BOOM_PREFIX . 'fcount']++;
	}
}
?>