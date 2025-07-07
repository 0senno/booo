<?php
function boomLogged(){
	global $data;
	if(isset($data['user_id'])){
		return true;
	}
}

// misc function

function boomActive($feature){
	if($feature <= 100){
		return true;
	}
}
function boomFormat($txt){
	$count = substr_count($txt, "\n" );
	if($count > 20){
		return $txt;
	}
	else {
		return nl2br($txt);
	}
}
function boomCacheUpdate(){
	global $mysqli;
	$mysqli->query("UPDATE boom_setting SET bbfv = bbfv + 0.01 WHERE id > 0");
	boomSaveSettings();
}
function embedMode(){
	if(isset($_GET['embed'])){
		return true;
	}
}
function embedCode(){
	if(isset($_GET['embed'])){
		return 1;
	}
	else {
		return 0;
	}
}
function emoprocess($string) {
	$string = str_replace(array(':)',':P',':D',':(',':-O'),array(':smile:',':tongue:',':smileface:',':sad:',':omg:'), $string);
	return $string;
}
function normalise($text, $a){
	$count = substr_count($text,"http");
	if($count > $a){
		return false;
	}
	return true;
}
function burl(){
	$ht = 'http';
	if(isset($_SERVER['HTTPS'])){
		$ht = 'https';
	}
	$burl = $ht . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $burl;
}
function inRoom(){
	global $data;
	if($data['user_roomid'] != '0'){
		return true;
	}
}
function userInRoom($user){
	if($user['user_roomid'] != '0'){
		return true;
	}
}
function myRoom($room){
	global $data;
	if($data['user_roomid'] == $room){
		return true;
	}
}
function mustVerify(){
	global $data;
	if(boomLogged() && !verified($data)){
		return true;
	}
}
function verified($user){
	global $setting;
	if($user['user_verify'] == 0 || $setting['activation'] == 0 || isGuest($user) || isStaff($user) || isBot($user)){
		return true;
	}
}
function authUser($user){
	if($user['user_auth'] > 0){
		return true;
	}
}
function usePlayer(){
	global $setting;
	if($setting['player_id'] != 0){
		return true;
	}
}
function useApp(){
	global $setting;
	if($setting['use_app'] > 0){
		return true;
	}
}
function maintMode(){
	global $setting;
	if(boomLogged()){
		if($setting['maint_mode'] > 0 && !boomAllow(70)){
			return true;
		}
	}
}
function boomThisText($text){
	global $data;
	$text = str_replace(
	array(
		'%email%',
		'%user%', 
		'%cemail%',
	),
	array(
		$data['user_email'],
		$data['user_name'],
		'<span class="theme_color">' . $data['user_email'] . '</span>',
	),
	$text);
	return $text;
}
function isBoomJson($res){
	if(is_string($res) && is_array(json_decode($res, true)) && (json_last_error() == JSON_ERROR_NONE)){
		return true;
	}
}
function isBoomObject($res){
	if(is_object($res)){
		return true;
	}
}
function getUserTheme($theme){
	global $setting;
	if($theme == 'system'){
		return $setting['default_theme'];
	}
	else {
		return $theme;
	}
}
function pageMenu($load, $icon, $txt, $rank = 0){
	if(okMenu($rank)){
		$menu = array(
			'load'=> $load,
			'icon'=> $icon,
			'txt'=> $txt,
		);
		return boomTemplate('element/page_menu', $menu);
	}
}
function pageMenuNotify($load, $icon, $txt, $id, $rank = 0){
	if(okMenu($rank)){
		$menu = array(
			'id'=> $id,
			'load'=> $load,
			'icon'=> $icon,
			'txt'=> $txt,
		);
		return boomTemplate('element/page_menu_notify', $menu);
	}
}
function pageMenuFunction($load, $icon, $txt, $rank = 0){
	if(okMenu($rank)){
		$menu = array(
			'load'=> $load,
			'icon'=> $icon,
			'txt'=> $txt, 
		);
		return boomTemplate('element/page_menu_function', $menu);
	}
}
function pageDropMenu($icon, $txt, $drop, $rank = 0){
	if(okMenu($rank)){
		$menu = array(
			'icon'=> $icon,
			'txt'=> $txt,
			'drop'=> $drop,
		);
		return boomTemplate('element/page_drop_menu', $menu);
	}
}
function pageDropItem($load, $txt, $rank = 0){
	if(okMenu($rank)){
		$menu = array(
			'load'=> $load,
			'txt'=> $txt
		);
		return boomTemplate('element/page_drop_item', $menu);
	}
}
function okMenu($rank){
	if($rank == 0){
		return true;
	}
	if(boomLogged() && boomAllow($rank)){
		return true;
	}
}
function bannedIp($ip){
	global $mysqli;
	$getip = $mysqli->query("SELECT * FROM boom_banned WHERE ip = '$ip'");
	if($getip->num_rows > 0){
		return true;
	}
}
function checkBan(){
	global $mysqli, $data;
	$ip = getIp();
	if(boomLogged()){
		if(isBanned($data)){
			if(boomAllow(100)){
				removeAllAction($data);
			}
			else {
				return true;
			}
		}
		else {
			$getip = $mysqli->query("SELECT * FROM boom_banned WHERE ip = '$ip'");
			if($getip->num_rows > 0){
				return true;
			}
		}
	}
}
function checkKick(){
	global $mysqli, $data;
	if(boomLogged()){
		if(isKicked($data)){
			if(boomAllow(100)){
				removeAllAction($data);
			}
			else {
				return true;
			}
		}
	}
}
function removeAllAction($user){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_kick = 0, user_mute = 0, user_rmute = 0, user_mmute = 0, user_banned = 0 WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function useLobby(){
	global $setting;
	if($setting['use_lobby'] == 1){
		return true;
	}
}
function useFont(){
	global $setting;
	if(boomActive($setting['allow_font']) || boomActive($setting['allow_name_font'])){
		return true;
	}
}
function clearConv($hunter, $target){
	global $mysqli;
	$mysqli->query("DELETE FROM boom_conversation WHERE hunter = '$hunter' AND target = '$target' OR hunter = '$target' AND target = '$hunter'");
	redisUpdateNotify($hunter);
	redisUpdateNotify($target);
}
function delConv($hunter, $target){
	global $mysqli;
	$mysqli->query("DELETE FROM boom_conversation WHERE hunter = '$hunter' AND target = '$target'");
	redisUpdateNotify($target);
}
function clearPrivate($hunter, $target){
	global $mysqli;
	$mysqli->query("DELETE FROM boom_private WHERE hunter = '$hunter' AND target = '$target' OR hunter = '$target' AND target = '$hunter'");
	clearConv($hunter, $target);
}
function _isCurl(){
    return function_exists('curl_version');
}
function optionCount($sel, $min, $max, $divider, $alias = ''){
	$val = '';
	for ($n = $min; $n <= $max; $n+=$divider) {
		$val .= '<option value="' . $n . '" ' . selCurrent($sel, $n) . '>' . $n . ' ' . $alias . '</option>';
	}
	return $val;
}
function optionMinutes($sel, $list = array()){
	$val = '';
	foreach($list as $n) {
		$val .= '<option value="' . $n . '" ' . selCurrent($sel, $n) . '>' . boomRenderMinutes($n) . '</option>';
	}
	return $val;
}
function optionSeconds($sel, $list = array()){
	$val = '';
	foreach($list as $n) {
		$val .= '<option value="' . $n . '" ' . selCurrent($sel, $n) . '>' . boomRenderSeconds($n) . '</option>';
	}
	return $val;
}
function bridgeMode($type){
	global $setting;
	if($setting['use_bridge'] == $type){
		return true;
	}
}
function minText($val){
	global $lang;
	return str_replace('%number%', $val, $lang['min_text']);
}
function trimContent($text){
	$text = str_ireplace(array('****', 'system__', 'public__', 'my_notice', '%bcclear%', '%bcjoin%', '%bckick%', '%bcban%', '%bcmute%', '%bcblock%', '%bcname%', '%spam%'), '*****', $text);
	return $text;
}
function boomFileSpace($f){
	return str_replace(' ', '_', $f);
}
function registerBlock($ip){
	global $mysqli;
	if(bannedIp($ip)){
		return true;
	}
	$check = $mysqli->query("SELECT user_kick, user_banned, user_mute FROM boom_users WHERE user_ip = '$ip' AND ( user_kick > " . time() . " OR user_banned > 0 OR user_mute > " . time() . ")");
	if($check->num_rows > 0){
		while($user = $check->fetch_assoc()){
			if(isBanned($user) || isKicked($user) || isMuted($user)){
				return true;
			}
		}
	}
}
function registerMax($ip, $max, $type = 0){
	global $mysqli;
	$rd = calDay(1);
	$add_query = '';
	if($type == 1){
		$add_query = "AND user_rank = 0";
	}
	$accounts = $mysqli->query("SELECT user_id FROM boom_users WHERE user_ip = '$ip' AND user_join >= '$rd' $add_query");
	if($accounts->num_rows >= $max){
		return true;
	}
}
function boomOkRegister($ip){
	global $mysqli, $setting;
	$good = 0;
	$counting = 0;
	if(registerBlock($ip)){
		return false;
	}
	if(registerMax($ip, $setting['max_reg'])){
		return false;
	}
	return true;
}
function guestCanRegister(){
	global $data;
	if(isGuest($data) && registration()){
		return true;
	}
}
function okGuest($ip){
	global $mysqli, $setting;
	if(registerBlock($ip)){
		return false;
	}
	if(registerMax($ip, $setting['max_greg'], 1)){
		return false;
	}
	return true;
}
function smiliesType(){
	return array('.png', '.svg', '.gif', '.webp');
}
function listSmilies($type){
	$supported = smiliesType();
	switch($type){
		case 1:
			$emo_act = 'memot';
			break;
		case 2:
			$emo_act = 'pemot';
			break;
		case 3:
			$emo_act = 'wemot';
			break;
		case 4:
			$emo_act = 'nemot';
			break;
	}
	$files = scandir(BOOM_PATH . '/emoticon');
	foreach ($files as $file){
		if ($file != "." && $file != ".."){
			$smile = preg_replace('/\.[^.]*$/', '', $file);
			foreach($supported as $sup){
				if(strpos($file, $sup)){
					echo '<div class="emoticon"><img  class="lazy ' . $emo_act . '" data=":' . $smile . ':" title=":' . $smile . ':" data-src="emoticon/' . $smile . $sup . '" src="' . imgLoader() . '"/></div>';
				}
			}
		}
	}
}
function insertUpload($zone, $file, $type, $rel){
	global $mysqli, $data;
	$mysqli->query("INSERT INTO `boom_upload` (file_name, date_sent, file_user, file_zone, file_type, relative_post) VALUES ('$file', '" . time() . "', '{$data['user_id']}', '$zone', '$type', '$rel')");
}
function boomMoveFile($source){
	move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), BOOM_PATH . '/' . $source);
}
function boomMoveImageFile($source, $type){
	$clear = true;
	$path = BOOM_PATH . '/' . $source;
	move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), $path);
	if($clear && $type == 'image/jpeg'){
		$img = imagecreatefromjpeg ($path);
		imagejpeg ($img, $path, 80);
		imagedestroy ($img);
	}
}
function validImageData($source){
	$i = getimagesize(BOOM_PATH . '/' . $source);
	if($i !== false){
		return true;
	}
}
function sourceExist($source){
	if(file_exists(BOOM_PATH . '/' . $source)){
		return true;
	}
}
function createTumbnail($source, $path, $type, $width, $height, $sizew, $sizeh) {
	$dst    = @imagecreatetruecolor($sizew, $sizeh);
	switch ($type) {
		case 'image/gif':
			$src = @imagecreatefromgif(BOOM_PATH . '/' . $source);
			break;
		case 'image/png':
			$src = @imagecreatefrompng(BOOM_PATH . '/' . $source);
			break;
		case 'image/jpeg':
			$src = @imagecreatefromjpeg(BOOM_PATH . '/' . $source);
			break;
		case 'image/webp':
			$src = @imagecreatefromwebp(BOOM_PATH . '/' . $source);
			break;
		default:
			return false;
			break;
	}
	$new_width  = $height * $sizew / $sizeh;
	$new_height = $width * $sizeh / $sizew;
	if ($new_width > $width) {
		$h = (($height - $new_height) / 2);
		@imagecopyresampled($dst, $src, 0, 0, 0, $h, $sizew, $sizeh, $width, $new_height);
	} else {
		$w = (($width - $new_width) / 2);
		@imagecopyresampled($dst, $src, 0, 0, $w, 0, $sizew, $sizeh, $new_width, $height);
	}
	switch ($type) {
		case 'image/gif':
			@imagegif($dst, BOOM_PATH . '/' . $path);
			break;
		case 'image/png':
			@imagejpeg($dst, BOOM_PATH . '/' . $path, 80);
			break;
		case 'image/jpeg':
			@imagejpeg($dst, BOOM_PATH . '/' . $path, 80);
			break;
		case 'image/webp':
			@imagewebp($dst, BOOM_PATH . '/' . $path, 80);
			break;
		default:
			return false;
			break;
	}
	if ($dst)
		@imagedestroy($dst);
	if ($src)
		@imagedestroy($src);
}
function imageTumb($source, $path, $type, $size) {
	$dst = '';
	switch ($type) {
		case 'image/png':
			$src = @imagecreatefrompng(BOOM_PATH . '/' . $source);
			break;
		case 'image/jpeg':
			$src = @imagecreatefromjpeg(BOOM_PATH . '/' . $source);
			break;
		default:
			return false;
			break;
	}
    $width = imagesx($src);
    $height = imagesy($src);
    $new_width = floor($width * ($size / $height));
    $new_height = $size;
	if($height > $size){
		$dst = @imagecreatetruecolor($new_width, $new_height);
		if($type == 'image/png'){
			@imagecolortransparent($dst, imagecolorallocate($dst, 0, 0, 0));
			@imagealphablending( $dst, false );
			@imagesavealpha( $dst, true );
		}
		@imagecopyresized($dst, $src, 0,0,0,0,$new_width,$new_height,$width,$height);
		switch ($type) {
			case 'image/png':
				@imagepng($dst, BOOM_PATH . '/' . $path);
				break;
			case 'image/jpeg':
				@imagejpeg($dst, BOOM_PATH . '/' . $path);
				break;
			default:
				return false;
				break;
		}
	}
	if($dst != ''){
		@imagedestroy($dst);
	}
	if($src){
		@imagedestroy($src);
	}
}
function imageTumbGif($source, $path, $type, $size) {
	$dst = '';
	switch ($type) {
		case 'image/gif':
			$src = @imagecreatefromgif(BOOM_PATH . '/' . $source);
			break;
		case 'image/png':
			$src = @imagecreatefrompng(BOOM_PATH . '/' . $source);
			break;
		case 'image/jpeg':
			$src = @imagecreatefromjpeg(BOOM_PATH . '/' . $source);
			break;
		default:
			return false;
			break;
	}
    $width = imagesx($src);
    $height = imagesy($src);
	if($height > $size){
		$new_width = floor($width * ($size / $height));
		$new_height = $size;
	}
	else {
		$new_width = $width;
		$new_height = $height;
	}
	$dst = @imagecreatetruecolor($new_width, $new_height);
	if($type == 'image/png'){
		@imagecolortransparent($dst, imagecolorallocate($dst, 0, 0, 0));
		@imagealphablending( $dst, false );
		@imagesavealpha( $dst, true );
	}
	@imagecopyresized($dst, $src, 0,0,0,0,$new_width,$new_height,$width,$height);
	switch ($type) {
		case 'image/gif':
			@imagegif($dst, BOOM_PATH . '/' . $path);
			break;
		case 'image/png':
			@imagepng($dst, BOOM_PATH . '/' . $path);
			break;
		case 'image/jpeg':
			@imagejpeg($dst, BOOM_PATH . '/' . $path);
			break;
		default:
			return false;
			break;
	}
	if($dst != ''){
		@imagedestroy($dst);
	}
	if($src){
		@imagedestroy($src);
	}
}
/* openai */

function useImageModeration(){
	global $setting;
	if($setting['openai_key'] == '' || $setting['img_mod'] == 0){
		return false;
	}
	return true;
}

function blockedImage($i){
	global $setting;
	if(!useImageModeration()){
		return false;
	}
	$apikey = $setting['openai_key'];
	$url = 'https://api.openai.com/v1/moderations';
	$data = [
		'model' => 'omni-moderation-latest',
		'input' => [
			[ 'type' => 'image_url', 'image_url' => [ 'url' => $setting['domain'] . '/' . $i ] ]
		]
	];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Authorization: Bearer ' . $apikey
	]);
	$response = curl_exec($ch);
	if ($response === false) {
		return false;
	}
	curl_close($ch);
	$responseData = json_decode($response, true);
    if (!isset($responseData['results']) || !is_array($responseData['results'])) {
        return false;
    }
	$mc = arrayThisList($setting['mod_cat']);
	foreach ($responseData['results'] as $result) {
		if ($result['flagged']) {
			foreach ($result['categories'] as $category => $flagged) {
				if ($flagged) {
					if(!in_array($category, $mc)){
						deleteFile($i);
						return true;
					}
				}
			}
		}
	}
}
function moderateImageLink($t){
	if(!useImageModeration()){
		return $t;
	}
	if(normalise($t, 1)){
		$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
		if (preg_match('@https?:\/\/([-\w\.]+[-\w])+(:\d+)?\/[' . $regex . ']+\.(png|gif|jpg|jpeg|webp)((\?\S+)?[^\.\s])?@i', $t, $match)) {
			$link = $match[0];
			if(blockedImage($link, true)){
				$t = 'Blocked content that do not meet our guidelines';
			}
		}
	}
	return $t;
}

function validIp($ip){
	if(filter_var($ip, FILTER_VALIDATE_IP)){
		return true;
	}
}
function validName($name){
	global $mysqli, $setting;
	$lowname = mb_strtolower($name);
	$reserved = array('system__', 'public__', 'my_notice');
	foreach ($reserved as $sreserve){
		if(stripos($lowname,mb_strtolower($sreserve)) !== FALSE){
			return false;
		}
	}
	$get_name = $mysqli->query("SELECT word FROM boom_filter WHERE word_type != 'email'");
	if($get_name->num_rows > 0){
		while($reject = $get_name->fetch_assoc()){
			if (stripos($lowname, mb_strtolower($reject['word'])) !== FALSE) {
				return false;
			}
		}
	}
	$regex = 'a-zA-Z0-9\p{Arabic}\p{Cyrillic}\p{Latin}\p{Han}\p{Katakana}\p{Hiragana}\p{Hebrew}';
	if(preg_match('/^[' . $regex . ']{1,}([\-\_ ]{1})?([' . $regex . ']{1,})?$/ui', $name) && mb_strlen($name, 'UTF-8') <= $setting['max_username'] && !ctype_digit($name) && mb_strlen($name, 'UTF-8') >= 2){
		return true;
	}
	return false;
}
function doCurl($url, $f = array()){
	$result = '';
	if(function_exists('curl_init')){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		if(!empty($f)){
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $f);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_REFERER, @$_SERVER['HTTP_HOST']);
		$result = curl_exec($curl);
		if(curl_errno($curl)){
			$result = '';
		}
		curl_close($curl);
	}
	return $result;
}
function trimCommand($text, $trim){
	return trim(str_replace($trim, '', $text));
}
function encodeFile($ext){
	global $data;
	$file_name = md5(microtime());
	$file_name = substr($file_name, 0, 12);
	return 'user' . $data['user_id'] . '_' . $file_name . "." . $ext;
}
function encodeFileTumb($ext, $user){
	$file_name = md5(microtime());
	$file_name = substr($file_name, 0, 12);
	$fname['full'] = 'user' . $user['user_id'] . '_' . $file_name . '.' . $ext;
	$fname['tumb'] = 'user' . $user['user_id'] . '_' . $file_name . '_tumb.'. $ext;
	return $fname;
}
function randomFileTumb($ext, $user, $px = 'file'){
	$file_name = md5(microtime());
	$file_name = substr($file_name, 0, 12);
	$fname['full'] = $px . $user['user_id'] . '_' . $file_name . '.' . $ext;
	$fname['tumb'] = $px . $user['user_id'] . '_' . $file_name . '_tumb.'. $ext;
	return $fname;
}
function listAge($current, $type = 0){
	global $lang;
	$age = '';
	if($type == 1){
		$age .= '<option value="0" class="placeholder" selected disabled>' . $lang['age'] . '</option>';
	}
	for($value = 5; $value <= 99; $value++){
		$age .=  '<option value="' . $value . '" ' . selCurrent($current, $value) . '>' . $value . '</option>';
	}
	return $age;
}
function listDay($current){
	$day = '';
	for($value = 1; $value <= 31; $value++){
		$day .=  '<option value="' . $value . '" ' . selCurrent($current, $value) . '>' . $value . '</option>';
	}
	return $day;
}
function listMonth($current){
	global $lang;
	$day = '';
	for($value = 1; $value <= 12; $value++){
		$day .=  '<option value="' . $value . '" ' . selCurrent($current, $value) . '>' . $lang['month'.$value] . '</option>';
	}
	return $day;
}
function listYear($current){
	$day = '';
	for($value = 1905; $value <= date('Y'); $value++){
		$day .=  '<option value="' . $value . '" ' . selCurrent($current, $value) . '>' . $value . '</option>';
	}
	return $day;
}
function yesNo($value){
	global $lang;
	$menu = '';
	$menu .= '<option value="1" ' . selCurrent($value, 1) . '>' . $lang['yes'] . '</option>';
	$menu .= '<option value="0" ' . selCurrent($value, 0) . '>' . $lang['no'] . '</option>';
	return $menu;
}
function onOff($value){
	global $lang;
	$menu = '';
	$menu .= '<option value="1" ' . selCurrent($value, 1) . '>' . $lang['on'] . '</option>';
	$menu .= '<option value="0" ' . selCurrent($value, 0) . '>' . $lang['off'] . '</option>';
	return $menu;
}
function playerList(){
	global $mysqli, $data;
	$playlist = '';
	$play_list = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id > 0");
	if($play_list->num_rows > 0){
		while($player = $play_list->fetch_assoc()){
			$playlist .= '<div class="radio_item brad5 bbackhover sub_list_item" data="' . $player['stream_url'] . '"><div class="sub_list_name">' . $player['stream_alias'] . '</div></div>';
		}
	}
	echo $playlist;
}
function adminPlayer($curr, $type){
	global $mysqli, $lang;
	$playlist = '';
	if($type == 1){
		$playlist .= '<option value="0">' . $lang['option_default'] . '</option>';
	}
	if($type == 2){
		$playlist .= '<option value="0">' . $lang['no_default'] . '</option>';
	}
	$play_list = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id > 0");
	if($play_list->num_rows > 0){
		while($player = $play_list->fetch_assoc()){
			$playlist .= '<option  value="' . $player['id'] . '" ' . selCurrent($curr, $player['id']) . '>' . $player['stream_alias'] . '</option>';
		}
	}	
	return $playlist;
}
function introLanguage(){
	$language_list = '';
	$dir = glob(BOOM_PATH . '/system/language/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$language = str_replace(BOOM_PATH . '/system/language/', '', $dirnew);
		$language_list .= boomTemplate('element/language', $language);
	}
	return $language_list;
}
function listLanguage($lang){
	$language_list = '';
	$dir = glob(BOOM_PATH . '/system/language/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$language = str_replace(BOOM_PATH . '/system/language/', '', $dirnew);
		$language_list .= '<option ' . selCurrent($lang, $language) . ' value="' . $language . '">' . $language . '</option>';
	}
	return $language_list;
}
function listTheme($th, $type){
	global $lang;
	$theme_list = '';
	if($type == 2){
		$theme_list .= '<option ' . selCurrent($th, 'system') . ' value="system">' . $lang['system_theme'] . '</option>';
	}
	$dir = glob(BOOM_PATH . '/css/themes/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$theme = str_replace(BOOM_PATH . '/css/themes/', '', $dirnew);
		$theme_list .= '<option ' . selCurrent($th, $theme) . ' value="' . $theme . '">' . $theme . '</option>';
	}
	return $theme_list;
}
function smailProcess($email) {
	if(!strstr($email, '@')){
		return '';
	}
	$s = explode('@', $email);
	if(strtolower($s[1]) == 'gmail.com' || strtolower($s[1]) == 'googlemail.com') {
		$s[0] = str_replace('.', '', $s[0]);
		return $s[0] . '@' . $s[1];
	}
	else if(stripos($s[1], 'yahoo') !== false){
		if(!strstr($s[0], '-')){
			return $s[0] . '@' . $s[1];
		}
		else {
			$y = explode('-', $s[0]);
			return $y[0] . '@' . $s[1];
		}
	}
	else {
		return '';
	}
}
function checkEmail($email){
	global $mysqli;
	$check_email = $mysqli->query("SELECT user_id FROM `boom_users` WHERE LOWER(`user_email`) = LOWER('$email')");
	if($check_email->num_rows < 1){
		return true;
	}
}
function checkSmail($email){
	global $mysqli;
	$smail = smailProcess($email);
	if($smail == ''){
		return true;
	}
	else {
		$check_smail = $mysqli->query("SELECT user_id FROM `boom_users` WHERE LOWER(`user_smail`) = LOWER('$smail')");
		if($check_smail->num_rows < 1){
			return true;
		}
	}
}
function boomSame($val1, $val2){
	if(mb_strtolower($val1) == mb_strtolower($val2)){
		return true;
	}
}
function roomActive($w){
	if($w['room_action'] < calWeekUp(1)){
		return 'rinnact';
	}
}
function getPostData($id){
	global $mysqli;
	$user = [];
	$get_post = $mysqli->query("SELECT * FROM boom_post WHERE post_id = '$id'");
	if($get_post->num_rows > 0){
		$user = $get_post->fetch_assoc();
	}
	return $user;
}
function unlinkAvatar($file){
	if(!defaultAvatar($file)){
		$delete =  BOOM_PATH. '/avatar/' . $file;
		if(file_exists($delete)){
			unlink($delete);
		}
	}
	return true;
}
function unlinkRoomIcon($file){
	if(!defaultRoomIcon($file)){
		$delete =  BOOM_PATH. '/room_icon/' . $file;
		if(file_exists($delete)){
			unlink($delete);
		}
	}
	return true;
}
function unlinkCover($file){
	$file = trim(str_replace(array('/', '..'), '', $file));
	if($file == '' || empty($file)){
		return false;
	}
	$delete =  BOOM_PATH . '/cover/' . $file;
	if(file_exists($delete)){
		unlink($delete);
	}
}
function selCurrent($cur, $val){
	if($cur == $val){
		return 'selected';
	}
}
function getTimezone($zone){
	$list_zone = '';
	require BOOM_PATH . '/system/location/timezone.php';
	foreach ($timezone as $line) {
		$list_zone .= '<option value="' . $line . '" ' . selCurrent($zone, $line) . '>' . $line . '</option>';
	}
	return $list_zone;
}
function roomExist($name, $id){
	global $mysqli;
	$check_room = $mysqli->query("SELECT room_name FROM boom_rooms WHERE room_name = '$name' AND room_id != '$id'");
	if($check_room->num_rows > 0){
		return true;
	}
}
function bValid($val){
    if(preg_match('/^[a-f0-9\-]{36}$/', $val)){
		return 1;
	}
	return 0;
}
function validValue($v, $a){
	if(in_array($v, $a)){
		return true;
	}
}
function insideChat($p){
	if($p == 'chat'){
		return true;
	}
}
function inChat($user){
	if($user['user_roomid'] > 0){
		return true;
	}
}
function nameRecord($user, $new){
	global $mysqli;
	if(!isBot($user)){
		$mysqli->query("DELETE FROM boom_name WHERE uid = '{$user['user_id']}' AND uname = '$new'");
		$check = $mysqli->query("SELECT id FROM boom_name WHERE uid = '{$user['user_id']}' AND uname = '{$user['user_name']}'");
		if($check->num_rows < 1){
			$mysqli->query("INSERT INTO boom_name (uid, uname, udate) VALUES ('{$user['user_id']}', '{$user['user_name']}', '" . time() . "')");
		}
	}
}
function freeUsername($user, $id){
	global $mysqli;
	$getuser = $mysqli->query("SELECT user_name FROM boom_users WHERE user_name = '$user' AND user_id != '$id'");
	if($getuser->num_rows < 1){
		return true;
	}
}
function validNameColor($color){
	if($color == 'user'){
		return true;
	}
	if(canNameColor() && preg_match('/^bcolor[0-9]{1,2}$/', $color)){
		return true;
	}
	if(canNameGrad() && preg_match('/^bgrad[0-9]{1,2}$/', $color)){
		return true;
	}
	if(canNameNeon() && preg_match('/^bneon[0-9]{1,2}$/', $color)){
		return true;
	}
}
function validTextColor($color){
	if($color == ''){
		return true;
	}
	if(canColor() && preg_match('/^bcolor[0-9]{1,2}$/', $color)){
		return true;
	}
	if(canGrad() && preg_match('/^bgrad[0-9]{1,2}$/', $color)){
		return true;
	}
	if(canNeon() && preg_match('/^bneon[0-9]{1,2}$/', $color)){
		return true;
	}
}
function validTextFont($font){
	if($font == ''){
		return true;
	}
	if(canFont() && preg_match('/^bfont[0-9]{1,2}$/', $font)){
		return true;
	}
}
function validNameFont($font){
	if($font == ''){
		return true;
	}
	if(canNameFont() && preg_match('/^bnfont[0-9]{1,2}$/', $font)){
		return true;
	}
}
function validTextWeight($f){
	$val = array('', 'ital', 'bold', 'boldital', 'heavybold', 'heavyital');
	if(in_array($f, $val)){
		return true;
	}
}
function listFontStyle($v){
	return boomTemplate('element/font_style', $v);
}
function listFont($v){
	return boomTemplate('element/font_text', $v);
}
function listNameFont($v){
	return boomTemplate('element/font_name', $v);
}
function unlinkUpload($path, $file){
	$delete =  BOOM_PATH . '/upload/' . $path . '/' . $file;
	if(file_exists($delete)){
		unlink($delete);
	}
}
function deleteFile($path){
	$delete =  BOOM_PATH . '/' . $path;
	if(file_exists($delete)){
		unlink($delete);
	}
}
function resetAvatar($user){
	global $mysqli;
	$unlink_tumb = unlinkAvatar($user['user_tumb']);
	if(isBot($user)){
		switch($user['user_bot']){
			case 1:
				$av = 'default_bot.png';
				break;
			case 9:
				$av = 'default_system.png';
				break;
			default:
				$av = 'default_bot.png';
		}
	}
	else {
		switch($user['user_rank']){
			case 0:
				$av = 'default_guest.png';
				break;
			default:
				$av = genderAvatar($user['user_sex']);
		}
	}
	$mysqli->query("UPDATE boom_users SET user_tumb = '$av' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
	return $av;
}
function genderAvatar($s){
	switch($s){
		case 1:
			return 'default_male.png';
		case 2:
			return 'default_female.png';
		default:
			return 'default_avatar.png';
	}
}
function resetCover($user){
	global $mysqli;
	$unlink_cover = unlinkCover($user['user_cover']);
	$mysqli->query("UPDATE boom_users SET user_cover = '' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function userReset($user, $rank){
	global $mysqli, $setting;
	$color = '';
	$mood = '';
	$name = '';
	$theme = '';
	$cover = '';
	$visible = '';
	$font = '';
	$tfont = '';
	$vip = '';
	
	if($rank < $setting['allow_colors']){
		$color = ", bccolor = '', bcbold = ''";
	}
	else if($rank < $setting['allow_grad'] && preg_match('/^bgrad[0-9]{1,2}$/', $user['bccolor'])){
		$color = ", bccolor = ''";
	}
	else if($rank < $setting['allow_neon'] && preg_match('/^bneon[0-9]{1,2}$/', $user['bccolor'])){
		$color = ", bccolor = ''";
	}
	if($rank < $setting['allow_font'] && preg_match('/^bfont[0-9]{1,2}$/', $user['bcfont'])){
		$tfont = ", bcfont = ''";
	}
	if($rank < $setting['allow_name_color']){
		$name = ", user_color = 'user'";
	}
	else if($rank < $setting['allow_name_grad'] && preg_match('/^bgrad[0-9]{1,2}$/', $user['user_color'])){
		$name = ", user_color = 'user'";
	}
	else if($rank < $setting['allow_name_neon'] && preg_match('/^bneon[0-9]{1,2}$/', $user['user_color'])){
		$name = ", user_color = 'user'";
	}
	if($rank < $setting['allow_name_font'] && preg_match('/^bnfont[0-9]{1,2}$/', $user['user_font'])){
		$font = ", user_font = ''";
	}
	if($rank < $setting['allow_mood']){
		$mood = ", user_mood = ''";
	}
	if($rank < $setting['allow_theme']){
		$theme = ", user_theme = 'system'";
	}
	if($rank < $setting['allow_cover']){
		$cover = ", user_cover = ''";
		unlinkCover($user['user_cover']);
	}
	if($user['user_rank'] > $rank && !isVisible($user)){
		$visible = ", user_status = 1";
	}
	
	clearNotifyAction($user['user_id'], 'rank_change');
	$mysqli->query("UPDATE boom_users SET user_rank = '$rank', user_action = user_action + 1, pcount = pcount + 1, naction = naction + 1, vip_end = 0 $color $tfont $name $font $mood $theme $cover $visible $vip WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
	if($rank < $setting['allow_room']){
		$get_room = $mysqli->query("SELECT * FROM boom_rooms WHERE room_creator = '{$user['user_id']}' AND room_system = 0");
		if($get_room->num_rows > 0){
			while($room = $get_room->fetch_assoc()){
				deleteRoom($room['room_id']);
			}
		}
	}
}
function muteAccount($id, $delay, $reason = ''){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canMuteUser($user)){
		return 0;
	}
	if(isMuted($user)){
		return 2;
	}
	if(!validMute($delay)){
		return 0;
	}
	systemMute($user, $delay);
	boomNotify('mute', array('target'=> $user['user_id'], 'source'=> 'mute', 'reason'=> $reason, 'delay'=> $delay, 'icon'=> 'action'));
	boomHistory('mute', array('target'=> $user['user_id'], 'delay'=> $delay, 'reason'=> $reason));
	boomConsole('mute', array('target'=> $user['user_id'], 'reason'=>$reason, 'delay'=> $delay));
	return 1;
}
function unmuteAccount($id){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canMuteUser($user)){
		return 0;
	}
	if(!isMuted($user)){
		return 2;
	}
	systemUnmute($user);
	boomNotify('unmute', array('target'=> $user['user_id'], 'source'=> 'mute', 'icon'=> 'raction'));
	boomConsole('unmute', array('target'=> $user['user_id']));
	return 1;
}
function ghostAccount($id, $delay, $reason = ''){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canGhostUser($user)){
		return 0;
	}
	if(isGhosted($user)){
		return 2;
	}
	if(!validGhost($delay)){
		return 0;
	}
	systemGhost($user, $delay);
	boomHistory('ghost', array('target'=> $user['user_id'], 'delay'=> $delay, 'reason'=> $reason));
	boomConsole('ghost', array('target'=> $user['user_id'], 'reason'=>$reason, 'delay'=> $delay));
	return 1;
}
function unghostAccount($id){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canGhostUser($user)){
		return 0;
	}
	if(!isGhosted($user)){
		return 2;
	}
	systemUnghost($user);
	boomConsole('unghost', array('target'=> $user['user_id']));
	return 1;
}
function muteAccountMain($id, $delay, $reason = ''){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canMuteUser($user)){
		return 0;
	}
	if(isMuted($user) || isMainMuted($user)){
		return 2;
	}
	systemMainMute($user, $delay);
	boomNotify('main_mute', array('target'=> $user['user_id'], 'source'=> 'mute', 'reason'=> $reason, 'delay'=> $delay, 'icon'=> 'action'));
	boomHistory('main_mute', array('target'=> $user['user_id'], 'delay'=> $delay, 'reason'=> $reason));
	boomConsole('main_mute', array('target'=> $user['user_id'], 'reason'=>$reason, 'delay'=> $delay));
	return 1;
}
function muteAccountPrivate($id, $delay, $reason = ''){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canMuteUser($user)){
		return 0;
	}
	if(isMuted($user) || isPrivateMuted($user)){
		return 2;
	}
	systemPrivateMute($user, $delay);
	boomNotify('private_mute', array('target'=> $user['user_id'], 'source'=> 'mute', 'reason'=> $reason, 'delay'=> $delay, 'icon'=> 'action'));
	boomHistory('private_mute', array('target'=> $user['user_id'], 'delay'=> $delay, 'reason'=> $reason));
	boomConsole('private_mute', array('target'=> $user['user_id'], 'reason'=>$reason, 'delay'=> $delay));
	return 1;
}
function unmuteAccountMain($id){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canMuteUser($user)){
		return 0;
	}
	if(!isMainMuted($user)){
		return 2;
	}
	systemMainUnmute($user);
	boomNotify('main_unmute', array('target'=> $user['user_id'], 'source'=> 'mute', 'icon'=> 'raction'));
	boomConsole('main_unmute', array('target'=> $user['user_id']));
	return 1;
}
function unmuteAccountPrivate($id){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canMuteUser($user)){
		return 0;
	}
	if(!isPrivateMuted($user)){
		return 2;
	}
	systemPrivateUnmute($user);
	boomNotify('private_unmute', array('target'=> $user['user_id'], 'source'=> 'mute', 'icon'=> 'raction'));
	boomConsole('private_unmute', array('target'=> $user['user_id']));
	return 1;
}
function kickAccount($id, $delay, $reason = ''){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canKickUser($user)){
		return 0;
	}
	if(isKicked($user)){
		return 2;
	}
	if(!validKick($delay)){
		return 0;
	}
	systemKick($user, $delay, $reason);
	boomConsole('kick', array('target'=> $user['user_id'], 'reason'=>$reason, 'delay'=> $delay));
	boomHistory('kick', array('target'=> $user['user_id'], 'delay'=> $delay, 'reason'=> $reason));
	return 1;
}
function unkickAccount($id){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canKickUser($user)){
		return 0;
	}
	if(!isKicked($user)){
		return 2;
	}
	systemUnkick($user);
	boomConsole('unkick', array('target'=> $user['user_id']));
	return 1;
}
function warnAccount($id, $reason = ''){
	global $mysqli;
	$user = userDetails($id);
	if(!canWarnUser($user)){
		return 0;
	}
	if(isWarned($user)){
		return 2;
	}
	systemWarn($user, $reason);
	boomConsole('warn', array('target'=> $user['user_id'], 'reason'=> $reason));
	boomHistory('warn', array('target'=> $user['user_id'], 'reason'=> $reason));
	return 1;
}
function banAccount($id, $reason = ''){
	global $mysqli;
	$user = userDetails($id);
	if(!canBanUser($user)){
		return 0;
	}
	if(isBanned($user)){
		return 2;
	}
	systemBan($user, $reason);
	boomConsole('ban', array('target'=> $user['user_id'], 'custom'=>$user['user_ip'], 'reason'=> $reason));
	boomHistory('ban', array('target'=> $user['user_id'], 'reason'=> $reason));
	return 1;
}
function unbanAccount($id){
	$user = userDetails($id);
	if(!canBanUser($user)){
		return 0;
	}
	if(!isBanned($user)){
		return 2;
	}
	systemUnban($user);
	boomConsole('unban', array('target'=> $user['user_id'], 'custom'=> $user['user_ip']));
	return 1;
}
function kickValues(){
	return array(2,5,10,15,30,60,120,180,360,1440,2880,4320,5760,7200,8640,10080,20160,43200,86400,129600, 525600);
}
function muteValues(){
	return array(2,5,10,15,30,60,120,180,360,1440,2880,4320,5760,7200,8640,10080,20160,43200,86400,129600,259200,525600);
}
function blockValues(){
	return array(2,5,10,15,30,60,120,180,360,1440,2880,4320,5760,7200,8640,10080,20160,43200,86400,129600,259200,525600);
}
function ghostValues(){
	return array(2,5,10,15,30,60,120,180,360,1440,2880,4320,5760,7200,8640,10080,20160,43200,86400,129600);
}
function validKick($val){
	if(in_array($val, kickValues())){
		return true;
	}
}
function validMute($val){
	if(in_array($val, muteValues())){
		return true;
	}
}
function validBlock($val){
	if(in_array($val, blockValues())){
		return true;
	}
}
function validGhost($val){
	if(in_array($val, ghostValues())){
		return true;
	}
}
function systemWarn($user, $reason = ''){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET warn_msg = '$reason' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemBan($user, $reason = ''){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_banned = '" . time() . "', ban_msg = '$reason', user_action = user_action + 1, user_roomid = '0' WHERE user_id = '{$user['user_id']}'");
	if(!boomDuplicateIp($user['user_ip'])){
		$mysqli->query("INSERT INTO boom_banned (ip, ban_user) VALUES ('{$user['user_ip']}', '{$user['user_id']}')");
	}
	banLog($user);
	redisUpdateUser($user['user_id']);
}
function systemUnban($user){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_banned = 0, ban_msg = '', user_action = user_action + 1 WHERE user_id = '{$user['user_id']}'");
	$mysqli->query("DELETE FROM boom_banned WHERE ip = '{$user['user_ip']}' OR ban_user = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemMute($user, $delay){
	global $mysqli;
	$mute_end = max($user['user_mute'], calMinutesUp($delay));
	$mysqli->query("UPDATE boom_users SET user_mute = '$mute_end', user_rmute = 0, user_mmute = 0, user_pmute = 0 WHERE user_id = '{$user['user_id']}'");
	clearNotifyAction($user['user_id'], 'mute');
	muteLog($user);
	redisUpdateUser($user['user_id']);
}
function systemUnmute($user){
	global $mysqli;
	clearNotifyAction($user['user_id'], 'mute');
	$mysqli->query("UPDATE boom_users SET user_mute = 0, user_rmute = 0, user_mmute = 0, user_pmute = 0 WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemMainMute($user, $delay){
	global $mysqli;
	$mute_end = max($user['user_mmute'], calMinutesUp($delay));
	$mysqli->query("UPDATE boom_users SET user_mmute = '$mute_end' WHERE user_id = '{$user['user_id']}'");
	clearNotifyAction($user['user_id'], 'mute');
	muteLog($user);
	redisUpdateUser($user['user_id']);
}
function systemMainUnmute($user){
	global $mysqli;
	clearNotifyAction($user['user_id'], 'mute');
	$mysqli->query("UPDATE boom_users SET user_mmute = 0 WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemPrivateMute($user, $delay){
	global $mysqli;
	$mute_end = max($user['user_mmute'], calMinutesUp($delay));
	$mysqli->query("UPDATE boom_users SET user_pmute = '$mute_end' WHERE user_id = '{$user['user_id']}'");
	clearNotifyAction($user['user_id'], 'mute');
	redisUpdateUser($user['user_id']);
}
function systemPrivateUnmute($user){
	global $mysqli;
	clearNotifyAction($user['user_id'], 'mute');
	$mysqli->query("UPDATE boom_users SET user_pmute = 0 WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemGhost($user, $delay){
	global $mysqli;
	$ghost_end = max($user['user_ghost'], calMinutesUp($delay));
	$mysqli->query("UPDATE boom_users SET user_ghost = '$ghost_end' WHERE user_id = '{$user['user_id']}'");	
	redisUpdateUser($user['user_id']);
}
function systemUnghost($user){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_ghost = '0' WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemKick($user, $delay, $reason = ''){
	global $mysqli;
	$this_delay = max($user['user_kick'], calMinutesUp($delay));
	$mysqli->query("UPDATE boom_users SET user_kick = '$this_delay', kick_msg = '$reason', user_action = user_action + 1 WHERE user_id = '{$user['user_id']}'");
	kickLog($user);
	redisUpdateUser($user['user_id']);
}
function systemSoftKick($user, $delay, $reason = ''){
	global $mysqli;
	$this_delay = max($user['user_kick'], calMinutesUp($delay));
	$mysqli->query("UPDATE boom_users SET user_kick = '$this_delay', kick_msg = '$reason', user_action = user_action + 1 WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemUnkick($user){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET user_kick = '0', kick_msg = '', user_action = user_action + 1 WHERE user_id = '{$user['user_id']}'");
	redisUpdateUser($user['user_id']);
}
function systemVpnKick($user){
	global $setting;
	if(isKicked($user)){
		return false;
	}
	systemSoftKick($user, $setting['flood_delay'], 'vpn');
	boomHistory('vpn_kick', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['vpn_delay']));
	boomConsole('vpn_kick', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['vpn_delay']));
}
function systemFloodMute($user){
	global $setting;
	if(isMuted($user)){
		return false;
	}
	systemMute($user, $setting['flood_delay']);
	boomNotify('flood_mute', array('target'=> $user['user_id'], 'source'=> 'mute', 'delay'=> $setting['flood_delay'], 'icon'=> 'action'));
	boomHistory('flood_mute', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['flood_delay']));
	boomConsole('flood_mute', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['flood_delay']));
}
function systemFloodKick($user){
	global $setting;
	if(isKicked($user)){
		return false;
	}
	systemKick($user, $setting['flood_delay'], 'flood');
	boomHistory('flood_kick', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['flood_delay']));
	boomConsole('flood_kick', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['flood_delay']));
}
function systemSpamMute($user, $custom = ''){
	global $setting;
	if(isMuted($user)){
		return false;
	}
	if(!isStaff($user) && !isBot($user)){
		systemMute($user, $setting['spam_delay']);
		boomNotify('spam_mute', array('target'=> $user['user_id'], 'source'=> 'mute', 'delay'=> $setting['spam_delay'], 'icon'=> 'action'));
		boomHistory('spam_mute', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['spam_delay'], 'reason'=> $custom));
		boomConsole('spam_mute', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'reason'=> $custom, 'delay'=> $setting['spam_delay']));
	}
}
function systemSpamGhost($user, $custom = ''){
	global $setting;
	if(isGhosted($user)){
		return false;
	}
	if(!isStaff($user) && !isBot($user)){
		systemGhost($user, $setting['spam_delay']);
		boomHistory('spam_ghost', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['spam_delay'], 'reason'=> $custom));
		boomConsole('spam_ghost', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'reason'=> $custom, 'delay'=> $setting['spam_delay']));
	}
}
function systemSpamBan($user, $custom = ''){
	global $setting;
	if(isBanned($user)){
		return false;
	}
	if(!isStaff($user) && !isBot($user)){
		systemBan($user, 'spam');
		boomHistory('spam_ban', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'reason'=> $custom));
		boomConsole('spam_ban', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'reason'=>$custom));
	}
}
function systemWordKick($user, $custom = ''){
	global $setting;
	if(isKicked($user)){
		return false;
	}
	if(!isStaff($user) && !isBot($user)){
		systemKick($user, $setting['word_delay'], 'badword');
		boomHistory('word_kick', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['word_delay'], 'reason'=> $custom));
		boomConsole('word_kick', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'reason'=>$custom, 'delay'=> $setting['word_delay']));
	}
}
function systemWordMute($user, $custom = ''){
	global $setting;
	if(isMuted($user)){
		return false;
	}
	if(!isStaff($user) && !isBot($user)){
		systemMute($user, $setting['word_delay']);
		boomNotify('word_mute', array('target'=> $user['user_id'], 'source'=> 'mute', 'delay'=> $setting['word_delay'], 'icon'=> 'action'));
		boomHistory('word_mute', array('hunter'=> $setting['system_id'], 'target'=> $user['user_id'], 'delay'=> $setting['word_delay'], 'reason'=> $custom));
		boomConsole('word_mute', array('hunter'=>$setting['system_id'], 'target'=> $user['user_id'], 'reason'=>$custom, 'delay'=> $setting['word_delay']));
	}
}
function userIsGuest($id){
	global $mysqli;
	$get_user = $mysqli->query("SELECT user_rank FROM boom_users WHERE user_id = '$id'");
	if($get_user->num_rows > 0){
		$user = $get_user->fetch_assoc();
		if($user['user_rank'] == 0){
			return true;
		}
	}
}
function userIsFriend($id){
	global $mysqli, $data;
	$get_friend = $mysqli->query("SELECT fstatus FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id'");
	if($get_friend->num_rows > 0){
		$friend = $get_friend->fetch_assoc();
		if($friend['fstatus'] == 3){
			return true;
		}
	}
}
function userIsGhosted($id){
	global $mysqli;
	$get_user = $mysqli->query("SELECT user_ghost FROM boom_users WHERE user_id = '$id'");
	if($get_user->num_rows > 0){
		$user = $get_user->fetch_assoc();
		if(isGhosted($user)){
			return true;
		}
	}
}
function blockRoom($id, $delay, $reason = ''){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 5, 2)){
		return 0;
	}
	if(!validBlock($delay)){
		return 0;
	}
	$endblock = calMinutesUp($delay);
	$mysqli->query("UPDATE boom_users SET user_action = user_action + 1, user_roomid = '0' WHERE user_id = '$id' AND user_roomid = '{$data['user_roomid']}'");
	$checkroom = $mysqli->query("SELECT * FROM boom_room_action WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id'");
	if($checkroom->num_rows > 0){
		$mysqli->query("UPDATE boom_room_action SET action_blocked = '$endblock' WHERE action_user = '$id' AND action_room = '{$data['user_roomid']}'");
	}
	else {
		$mysqli->query("INSERT INTO boom_room_action ( action_room , action_user, action_blocked ) VALUES ('{$data['user_roomid']}', '$id', '$endblock')");
	}
	boomConsole('room_block', array('target'=> $user['user_id'], 'delay'=> $delay, 'reason'=> $reason));
	$user['user_roomid'] = $data['user_roomid'];
	blockLog($user);
	redisUpdateUser($user['user_id']);
	return 1;
}
function muteRoom($id, $delay, $reason = ''){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 4, 2)){
		return 0;
	}
	if(!validMute($delay)){
		return 0;
	}
	$endmute = calMinutesUp($delay);
	$mysqli->query("UPDATE boom_users SET room_mute = '$endmute' WHERE user_id = '$id' AND user_roomid = '{$data['user_roomid']}'");
	$checkroom = $mysqli->query("SELECT * FROM boom_room_action WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id'");
	if($checkroom->num_rows > 0){
		$mysqli->query("UPDATE boom_room_action SET action_muted = '$endmute' WHERE action_user = '$id' AND action_room = '{$data['user_roomid']}'");
	}
	else {
		$mysqli->query("INSERT INTO boom_room_action ( action_room , action_user, action_muted ) VALUES ('{$data['user_roomid']}', '$id', '$endmute')");
	}
	boomConsole('room_mute', array('target'=> $user['user_id'], 'delay'=> $delay, 'reason'=> $reason));
	$user['user_roomid'] = $data['user_roomid'];
	muteLog($user);
	redisUpdateUser($user['user_id']);
	return 1;
}
function unmuteRoom($id){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 4, 2)){
		return 0;
	}
	else{
		$mysqli->query("UPDATE boom_users SET room_mute = 0 WHERE user_id = '$id' AND user_roomid = '{$data['user_roomid']}'");
		$mysqli->query("UPDATE boom_room_action SET action_muted = '0' WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id'");
		boomConsole('room_unmute', array('target'=> $user['user_id']));
		redisUpdateUser($user['user_id']);
		return 1;
	}
}
function removeRoomStaff($target){
	global $mysqli, $setting, $data;
	$user = userRoomDetails($target);
	if(!canEditRoom()){
		return 0;
	}
	if(!betterRole($user['room_ranking']) && !boomAllow($setting['can_raction'])){
		return 2;
	}
	$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '{$user['user_id']}' AND room_id = '{$data['user_roomid']}'");
	$mysqli->query("UPDATE boom_users SET user_role = 0 WHERE user_id = '{$user['user_id']}' AND user_roomid = '{$data['user_roomid']}'");
	boomConsole('change_room_rank', array('target'=> $user['user_id'], 'rank'=>0));
	redisUpdateUser($user['user_id']);
	return 1;
}
function unblockRoom($id){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 5, 2)){
		return 0;
	}
	$mysqli->query("UPDATE boom_room_action SET action_blocked = '0' WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id'");
	boomConsole('room_unblock', array('target'=> $user['user_id']));
	return 1;
}
function canSendReport(){
	global $mysqli, $data;
	$max_report = 3;
	if(!canReport()){
		return false;
	}
	$get_report = $mysqli->query("SELECT report_id FROM boom_report WHERE report_user = '{$data['user_id']}'");
	if($get_report->num_rows < $max_report){
		return true;
	}
}
function canRoomAction($user, $role, $type = 1){
	global $mysqli, $setting;
	if(empty($user)){
		return false;
	}
	if(mySelf($user['user_id'])){
		return false;
	}
	if(!boomRole($role) && !boomAllow($setting['can_raction'])){
		return false;
	}
	if(isStaff($user) || isBot($user)){
		return false;
	}
	if(!betterRole($user['room_ranking']) && !boomAllow($setting['can_raction'])){
		return false;
	}
	if($type == 2 && userRoomStaff($user['room_ranking'])){
		return false;
	}
	return true;
}
function ignored($user){
	if($user['ignored'] > 0){
		return true;
	}
}
function ignoring($user){
	if($user['ignoring'] > 0){
		return true;
	}
}
function haveFriendship($user){
	if($user['friendship'] == 3){
		return true;
	}
}
function canFriend($user){
	if($user['friendship'] < 2){
		return true;
	}
}
function userAcceptFriend($user){
	if($user['ufriend'] > 0){
		return true;
	}
}
function canIgnore($user){
	if(!isBot($user) && !mySelf($user['user_id']) && !isStaff($user)){
		return true;
	}
}
function boomDat($val, $res = 0){
	if($val != '' || !empty($val)){
		$res = 1;
	}
	return $res;
}
function betterRole($rank){
	global $data;
	if($data['user_role'] > $rank){
		return true;
	}
}
function checkMod($id){
	global $data, $mysqli;
	$checkmod = $mysqli->query("SELECT * FROM boom_room_staff WHERE room_id = '{$data['user_roomid']}' AND room_staff = '$id'");
	if($checkmod->num_rows < 1){
		return true;
	}
}
function addonsLang($name){
	global $data;
	$load_lang = BOOM_PATH . '/addons/' . $name . '/language/' . $data['user_language'] . '.php';
	if(file_exists($load_lang)){
		return $load_lang;
	}
	else {
		return BOOM_PATH . '/addons/' . $name . '/language/Default.php';
	}
}
function addonsLangCron($name){
	global $setting;
	$load_lang = BOOM_PATH . '/addons/' . $name . '/language/' . $setting['language'] . '.php';
	if(file_exists($load_lang)){
		return $load_lang;
	}
	else {
		return BOOM_PATH . '/addons/' . $name . '/language/Default.php';
	}
}
function randomPass(){
	$text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890++--@@@___';
	$text = substr(str_shuffle($text), 0, 10);
	return encrypt($text);
}
function alphaClear($s){
	return preg_replace('@[a-zA-Z-]@', '', $s);
}
function numsClear($s){
	return preg_replace('@[0-9-]@', '', $s);
}
function elementTitle($title, $backcall = ''){
	$top_it = array(
		'title'=> $title,
		'backcall'=> $backcall
	);
	return boomTemplate('element/page_top', $top_it);
}
function pageTitle($title, $icon = 'circle'){
	$top = array(
		'title'=> $title,
		'icon'=> $icon
	);
	return boomTemplate('element/page_title', $top);
}
function canPostAction($id){
	global $mysqli, $data;
	$get_post = $mysqli->query("
		SELECT boom_post.post_user,
		(SELECT fstatus FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = boom_post.post_user) as friendship
		FROM boom_post WHERE boom_post.post_id = '$id'
	");
	if($get_post->num_rows < 1){
		return false;
	}
	$result = $get_post->fetch_assoc();
	if(haveFriendship($result) || mySelf($result['post_user'])){
		return true;
	}
}
function showWallPost($postid, $type = 0){
	global $data, $mysqli, $lang;
	$wall_post = $mysqli->query("SELECT boom_post.*, boom_users.*,
	(SELECT count( parent_id ) FROM boom_post_reply WHERE parent_id = boom_post.post_id ) as reply_count,
	(SELECT like_type FROM boom_post_like WHERE uid = '{$data['user_id']}' AND like_post = boom_post.post_id) as liked
	FROM  boom_post, boom_users 
	WHERE (boom_post.post_user = boom_users.user_id AND post_id = '$postid')
	ORDER BY boom_post.post_actual DESC LIMIT 1");

	if($wall_post->num_rows > 0){
		$wall = $wall_post->fetch_assoc();
		return boomTemplate('element/wall_post',$wall);
	}
	else { 
		return emptyZone($lang['wall_empty']);
	}
}
function newsReplyCount($id){
	global $mysqli;
	$get_count = $mysqli->query("SELECT count(reply_id) as total FROM boom_news_reply WHERE parent_id = '$id'");
	$t = $get_count->fetch_assoc();
	return $t['total'];
}
function wallReplyCount($id){
	global $mysqli;
	$get_count = $mysqli->query("SELECT count(reply_id) as total FROM boom_post_reply WHERE parent_id = '$id'");
	$t = $get_count->fetch_assoc();
	return $t['total'];
}
function allowNewsComment($n){
	if($n['news_comment'] > 0){
		return true;
	}
}
function allowNewsLikes($n){
	if($n['news_like'] > 0){
		return true;
	}
}
function allowWallComment($n){
	if($n['post_comment'] > 0){
		return true;
	}
}
function allowWallLikes($n){
	if($n['post_like'] > 0){
		return true;
	}
}
function showNewsPost($id){
	global $mysqli, $data;
	$news_content = '';
	$get_news = $mysqli->query("
		SELECT boom_news.*, boom_users.*,
		(SELECT count( parent_id ) FROM boom_news_reply WHERE parent_id = boom_news.id ) as reply_count,
		(SELECT like_type FROM boom_news_like WHERE uid = '{$data['user_id']}' AND like_post = boom_news.id) as liked
		FROM boom_news, boom_users
		WHERE boom_news.news_poster = boom_users.user_id AND boom_news.id = '$id'
		ORDER BY news_date DESC LIMIT 1
	");
	while ($news = $get_news->fetch_assoc()){
		$news_content .= boomTemplate('element/news', $news);
	}
	return $news_content;
}
function newsDetails($id){
	global $mysqli;
	$news = [];
	$get_news = $mysqli->query("SELECT * FROM boom_news WHERE id = '$id'");
	if($get_news->num_rows > 0){
		$news = $get_news->fetch_assoc();
	}
	return $news;
}
function wallDetails($id){
	global $mysqli;
	$wall = [];
	$get_wall = $mysqli->query("SELECT * FROM boom_post WHERE post_id = '$id'");
	if($get_wall->num_rows > 0){
		$wall = $get_wall->fetch_assoc();
	}
	return $wall;
}
function currentUserRoom($user){
	if(!is_null($user['room_name']) && isVisible($user) && canViewRoom()){
		return $user['room_name'];
	}
	return 'N/A';
}
function wordFilter($text, $type = 0){
	global $mysqli;
	$text2 = trimContent($text);
	$text = trimContent($text);
	$text_trim = mb_strtolower(str_replace(array(' '), '', $text));
	$word_action = 0;
	$spam_action = 0;
	
	if(zalgoFilter($text)){
		return '****';
	}
	
	if(!isWordProof()){
		$words = $mysqli->query("SELECT * FROM `boom_filter` WHERE word_type = 'word' OR word_type = 'spam'");
		if ($words->num_rows > 0){
			while($filter = $words->fetch_assoc()){
				if($filter['word_type'] == 'word'){
					if(stripos($text, $filter['word']) !== false){
						$text = str_ireplace($filter['word'], '****',$text);
						$text2 = processFilterReason($filter['word'], $text2);
						$word_action++;
					}
				}
				else if($filter['word_type'] == 'spam'){
					if(stripos($text_trim, $filter['word']) !== false){
						$text2 = processFilterReason($filter['word'], $text2);
						$spam_action++;
					}
				}
			}
		}
		if($word_action > 0 && $type == 1 && $spam_action == 0){
			wordAction($text2);
		}
		if($spam_action > 0){
			$text = spamText();
			spamAction($text2);
		}
	}
	return $text;
}
function wordAction($t){
	global $data, $setting;
	switch($setting['word_action']){
		case 2:
			systemWordMute($data, $t);
			break;
		case 3:
			systemWordKick($data, $t);
			break;
	}
}
function spamAction($t){
	global $data, $setting;
	switch($setting['spam_action']){
		case 1:
			systemSpamMute($data, $t);
			break;
		case 2:
			systemSpamBan($data, $t);
			break;
		case 3:
			systemSpamGhost($data, $t);
			break;
	}
}
function zalgoFilter($text){
	if(preg_match('/[\xCC\xCD]/', $text)){
		return true;
	}
}
function processFilterReason($word, $text){
	$rep = preg_quote($word, '/');
	return preg_replace("/($rep)/i", '$1', $text);
}
function isBadText($text){
	global $mysqli;
	$text = trimContent($text);
	$text_trim = mb_strtolower(str_replace(array(' '), '', $text));
	if(zalgoFilter($text)){
		return true;
	}
	if(!isWordProof()){
		$words = $mysqli->query("SELECT * FROM `boom_filter` WHERE word_type = 'word' OR word_type = 'spam'");
		if ($words->num_rows > 0){
			while($filter = $words->fetch_assoc()){
				if($filter['word_type'] == 'word'){
					if(stripos($text, $filter['word']) !== false){
						return true;
					}
				}
				else if($filter['word_type'] == 'spam'){
					if(stripos($text_trim, $filter['word']) !== false){
						return true;
					}
				}
			}
		}
	}
}
function isTooLong($text, $max){
	if(mb_strlen($text, 'UTF-8') > $max){
		return true;
	}
}
function isTooShort($text, $min){
	if(mb_strlen($text, 'UTF-8') < $min){
		return true;
	}
}
function getFileExtension(){
	return 'gif,jpeg,jpg,JPG,PNG,png,x-png,pjpeg,zip,pdf,ZIP,PDF,mp3,webp';
}
function isImage($ext){
	$ext = strtolower($ext);
	$img = array( 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/JPG', 'image/webp' );
	$img_ext = array( 'gif', 'jpeg', 'jpg', 'JPG', 'PNG', 'png', 'x-png', 'pjpeg', 'webp' );
	if( in_array($_FILES["file"]["type"], $img) && in_array($ext, $img_ext)){
		return true;
	}
}
function isFile($ext){
	$ext = strtolower($ext);
	$f = array( 'application/zip', 'application/x-zip-compressed', 'application/pdf', 'application/octet-stream', 'application/x-zip-compressed' );
	$f_ext = array( 'zip', 'pdf', 'ZIP', 'PDF' );
	if( in_array($_FILES["file"]["type"], $f) && in_array($ext, $f_ext)){
		return true;
	}
}
function isMusic($ext){
	$ext = strtolower($ext);
	$f = array( 'audio/mpeg', 'audio/mp3', 'audio/x-mpeg', 'audio/x-mp3', 'audio/mpeg3',
	'audio/x-mpeg3', 'audio/mpg', 'audio/x-mpg', 'audio/x-mpegaudio' );
	$f_ext = array( 'mp3' );
	if( in_array($_FILES["file"]["type"], $f) && in_array($ext, $f_ext)){
		return true;
	}
}
function isVideo($ext){
	$ext = strtolower($ext);
	$f = array( 'video/mp4', 'video/webm' );
	$f_ext = array( 'mp4', 'webm' );
	if( in_array($_FILES["file"]["type"], $f) && in_array($ext, $f_ext)){
		return true;
	}
}
function isCoverImage($ext){
	$ext = strtolower($ext);
	$img = array( 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/JPG', 'image/webp' );
	$img_ext = array( 'gif', 'jpeg', 'jpg', 'JPG', 'PNG', 'png', 'x-png', 'pjpeg', 'webp' );
	if( in_array($_FILES["file"]["type"], $img) && in_array($ext, $img_ext)){
		return true;
	}
}
function fileError($type = 1){
	global $setting;
	$size = $setting['file_weight'];
	if($type == 2){
		$size = $setting['max_avatar'];
	}
	else if($type == 3){
		$size = $setting['max_cover'];
	}
	else if($type == 4){
		$size = $setting['max_ricon'];
	}
	if($_FILES["file"]["error"] > 0 || (($_FILES["file"]["size"] / 1024)/1024) > $size ){
		return true;
	}
}
function boomIndexing($tab, $key){
	global $mysqli;
	$get_index = $mysqli->query("SHOW INDEX FROM $tab WHERE Column_name = '$key'");
	if($get_index->num_rows < 1){
		$mysqli->query("ALTER TABLE `$tab` ADD INDEX($key)");
	}
}
function boomRemoveIndex($tab, $key){
	global $mysqli;
	$get_index = $mysqli->query("SHOW INDEX FROM $tab WHERE Column_name = '$key'");
	if($get_index->num_rows > 0){
		$mysqli->query("ALTER TABLE `$tab` DROP INDEX `$key`");
	}
}
function targetExist($id){
	global $mysqli;
	$get_target = $mysqli->query("SELECT user_id FROM boom_users WHERE user_id = '$id'");
	if($get_target->num_rows > 0){
		return true;
	}
}
function removeRelatedFile($id, $zone){
	global $mysqli;
	$get_file = $mysqli->query("SELECT * FROM boom_upload WHERE relative_post = '$id' AND file_zone = '$zone'");
	if($get_file->num_rows > 0){
		while ($file = $get_file->fetch_assoc()){
			unlinkUpload($zone, $file['file_name']);
		}
		$mysqli->query("DELETE FROM boom_upload WHERE relative_post = '$id' AND file_zone = '$zone'");
	}	
}
function getRoomMuted($r){
	global $mysqli, $lang;
	$muted_list = '';
	$get_muted = $mysqli->query("SELECT boom_room_action.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_id
				FROM boom_room_action
				LEFT JOIN boom_users
				ON boom_room_action.action_user = boom_users.user_id
				WHERE action_room = '$r' AND action_muted > '" . time() . "'
				ORDER BY  boom_users.user_name ASC");
	if($get_muted->num_rows > 0){
		while($muted = $get_muted->fetch_assoc()){
			$muted['action'] = 'room_unmute';
			$muted['timer'] = $muted['action_muted'];
			$muted_list .= boomTemplate('element/room_action_user', $muted);
		}
	}
	else{
		$muted_list .= emptyZone($lang['no_data']);
	}
	return $muted_list;
}
function getRoomBlocked($r){
	global $mysqli, $lang;
	$blocked_list = '';
	$get_blocked = $mysqli->query("SELECT boom_room_action.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_id
				FROM boom_room_action
				LEFT JOIN boom_users
				ON boom_room_action.action_user = boom_users.user_id
				WHERE action_room = '$r' AND action_blocked > '" . time() . "'
				ORDER BY  boom_users.user_name ASC");
	if($get_blocked->num_rows > 0){
		while($blocked = $get_blocked->fetch_assoc()){
			$blocked['action'] = 'room_unblock';
			$blocked['timer'] = $blocked['action_blocked'];
			$blocked_list .= boomTemplate('element/room_action_user', $blocked);
		}
	}
	else{
		$blocked_list .= emptyZone($lang['no_data']);
	}
	return $blocked_list;
}
function getRoomStaff($r, $rank){
	global $mysqli, $lang;
	$staff_list = '';
	$get_staff = $mysqli->query("SELECT boom_room_staff.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_id
					FROM boom_room_staff
					LEFT JOIN boom_users
					ON boom_room_staff.room_staff = boom_users.user_id
					WHERE room_id = '$r' AND room_rank = $rank
					ORDER BY  boom_users.user_name ASC");
	if($get_staff->num_rows > 0){
		while($staff = $get_staff->fetch_assoc()){
			$staff['room_rank'] = $rank;
			$staff_list .= boomTemplate('element/room_staff', $staff);
		}
	}
	return $staff_list;
}
function tempKey(){
	$temp = '';
	$len = rand(32,40);
	$chain = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_';
	for($i=0; $i <= $len; $i++){
		$temp .= $chain[rand(0,strlen(substr($chain,0,strlen($chain)-1)))];
	}
	return $temp;
}
function tempLink($key, $time){
	global $setting;
	return $setting['domain'] . '/recovery.php?k=' . $key . '&t=' . $time . '&v=' . encrypt($key . $time);
}
function tempTimer(){
	return calMinutes(30);
}
function validRecovery($k, $t, $v){
	if($t < tempTimer()){
		return false;
	}
	if($v != encrypt($k . $t)){
		return false;
	}
	if(!preg_match('/^[0-9a-zA-Z_]{32,40}$/', $k)){
		return false;
	}
	if(!preg_match('/^[0-9a-f]{40}$/', $v)){
		return false;
	}
	if(!preg_match('/^[0-9]{10}$/', $t)){
		return false;
	}
	return true;
}
function insertRecovery($user, $key, $time){
	global $mysqli;
	$delay = tempTimer();
	$mysqli->query("INSERT INTO boom_temp (temp_user, temp_key, temp_date) VALUES ('{$user['user_id']}', '$key', '$time')");
}
function sendRecovery($user){
	global $mysqli, $setting, $lang;
	$temp_key = tempKey();
	$time = time();
	if(!canSendMail($user, 'recovery', 4)){
		return 0;
	}
	$c = array(
		'username'=> $user['user_name'],
		'data'=> tempLink($temp_key, $time),
	);
	$content = boomTemplate('element/mail_recovery', $c);
	$send_mail = boomMail($user['user_email'], $lang['recovery_title'], $content);
	if($send_mail == 1){
		insertMail($user, 'recovery');
		insertRecovery($user, $temp_key, $time);
	}
	return $send_mail;
}
function sendActivation($user){
	global $mysqli, $lang;
	$key = $user['valid_key'];
	if(!is_numeric($user['valid_key']) || $user['valid_key'] == ''){
		$key = genCode();
	}
	$c = array(
		'username'=> $user['user_name'],
		'data'=> $key
	);
	$content = boomTemplate('element/mail_activation', $c);
	$send_mail = boomMail($user['user_email'], $lang['activation_title'], $content);
	if($send_mail == 1){
		$mysqli->query("UPDATE boom_users SET valid_key = '$key' WHERE user_id = '{$user['user_id']}'");
		redisUpdateUser($user['user_id']);
		insertMail($user, 'verify');
	}
	return $send_mail;
}
function sendContact($email, $reply, $message){
	global $mysqli, $data, $lang;
	if(empty($reply)){
		return 0;
	}
	$c = array(
		'content'=> nl2br(linkingLink($reply)),
		'signed'=> $data['user_name'],
		'content2'=> nl2br(linkingLink($message)),
	);
	$content = boomTemplate('element/mail_contact', $c);
	$send_mail = boomMail($email, $lang['contact_title'], $content);	
	return $send_mail;
}
function boomMail($to, $subject, $content){
	global $setting;
	require BOOM_PATH . '/system/mailer/autoload.php';
	$mail = new PHPMailer\PHPMailer\PHPMailer;
	if(!isEmail($to) || empty($content) || empty($subject)){
		return 0;
	}
	$content = boomTemplate('element/mail_template', $content);
	if($setting['mail_type'] == 'smtp'){
		$mail->isSMTP();
		$mail->Host = $setting['smtp_host'];
		$mail->SMTPAuth = true;
		$mail->Username = $setting['smtp_username'];
		$mail->Password = $setting['smtp_password'];
		$mail->SMTPSecure = $setting['smtp_type'];
		$mail->Port = $setting['smtp_port'];
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
	}
	else {
		$mail->IsMail();
	}
	$mail->setFrom($setting['site_email'], $setting['email_from']);
	$mail->addAddress($to);
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->Subject = $subject;
	$mail->MsgHTML($content);
	if(!$mail->send()) {
	   return 0;
	} 
	else {
		return 1;
	}
}
function okVerify(){
	global $data;
	$max_verify = 3;
	if(canSendMail($data, 'verify', $max_verify)){
		return true;
	}
}
function getCritera($c){
	if(is_numeric($c)){
		return "user_rank = '$c' AND user_bot = 0";
	}
	else {
		switch($c){
			case 'bot':
				return "user_bot > 0";
			case 'invisible':
				return "user_status = 99 AND user_bot = 0";
			default:
				return "user_rank < 0";
		}
	}	
}
function cleanSearch($search){
	return str_replace('%', '|', $search);
}
function boomUsername($name){
	global $mysqli;
	$user = userNameDetails($name);
	if(empty($user)){
		return true;
	}
	else {
		if(isGuest($user) && $user['last_action'] < calMinutes(30)){
			softGuestDelete($user);
			return true;
		}
	}
}
function registration(){
	global $setting;
	if($setting['registration'] == 1){
		return true;
	}
}
function roomSelect($r){
	global $mysqli;
	$menu = '';
	$get_rooms = $mysqli->query("SELECT * FROM boom_rooms WHERE room_id > 0");
	while($room = $get_rooms->fetch_assoc()){
		$menu .= '<option value="' . $room['room_id'] . '" ' . selCurrent($r, $room['room_id']) . '>' . $room['room_name'] . '</option>';
	}
	return $menu;
}
function getChatPath(){
	return basename(dirname(__DIR__));
}
function deleteFiles($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK);
        foreach($files as $file){
            deleteFiles($file);      
        }
        rmdir( $target );
    } 
	elseif(is_file($target)){
        unlink($target);  
    }
}
function boomEmbed(){
	if(isset($_GET['embed'])){
		return true;
	}
}
function boomInsertUser($pro, $type = 0){
	global $mysqli, $setting;
	$user = [];
	$regmute = 0;
	$regghost = 0;
	if(!isset($pro['name'], $pro['password'], $pro['email'])){
		return $user;
	}
	$def = array(
		'gender' => 3,
		'age' => 99,
		'ip' => '0.0.0.0',
		'language' => $setting['language'],
		'avatar' => 'default_avatar.png',
		'color' => 'user',
		'rank' => 1,
		'verify' => $setting['activation'],
		'cookie' => 1,
		'email' => '',
	);
	if($setting['reg_act'] == 1){
		$regmute = calMinutesUp($setting['reg_delay']);
	}
	if($setting['reg_act'] == 2){
		$regghost = calMinutesUp($setting['reg_delay']);
	}
	$u = array_merge($def, $pro);
	$u['smail'] = smailProcess($u['email']);
	$mysqli->query("INSERT INTO `boom_users` 
	( user_name, user_password, user_ip, user_email, user_smail, user_rank, user_roomid, user_theme,
	user_join, last_action, user_language, user_timezone, user_verify, user_color,
	user_sex, user_age, user_news, user_tumb, user_ghost, user_rmute, last_gold)
	VALUES 
	('{$u['name']}', '{$u['password']}', '{$u['ip']}', '{$u['email']}', '{$u['smail']}', '{$u['rank']}', '0', 'system',
	'" . time() . "', '" . time() . "', '{$u['language']}', '{$setting['timezone']}', '{$u['verify']}', '{$u['color']}',
	'{$u['gender']}', '{$u['age']}', '" . time() . "', '{$u['avatar']}', '$regghost', '$regmute', '" . time() . "')");
	
	$newid = $mysqli->insert_id;
	$user = userDetails($newid);
	if(!empty($user)){
		$mysqli->query("INSERT INTO boom_exp (uid) VALUES ($newid)");
		$mysqli->query("INSERT INTO boom_users_data (uid) VALUES ($newid)");
	}
	
	if($u['cookie'] == 1 && !empty($user)){
		setBoomCookie($user);
	}
	if($u['verify'] == 1 && !empty($user)){
		$send_mail = sendActivation($user);
	}
	return $user;
}
function checkGeo(){
	global $setting, $data;
	if($data['country'] == '' && $setting['use_geo'] == 1){
		return true;
	}
}
function textFilter($c){
	if(canDirect()){
		$c = linking($c);
	}
	else {
		$c = linkingReg($c);
	}
	if(canEmo()){
		$c = emoticon(emoprocess($c));
	}
	else {
		$c = regEmoticon(emoprocess($c));
	}
	return $c;
}
function pinnedRoom($room){
	if($room['pinned'] > 0){
		return true;
	}
}
function emptyZone($text, $args = array()){
	$def = array(
		'text'=> $text,
		'icon'=> 'nodata.svg',
		'size'=> '',
	);
	$zone = array_merge($def, $args);
	return boomTemplate('element/empty_zone', $zone);	
}
function useWall(){
	global $setting;
	if($setting['use_wall'] == 1){
		return true;
	}
}
function validPassword($pass){
	if(strlen($pass) < 6 || strlen($pass) > 24){
		return false;
	}
	return true;
}
function validRoomName($name){
	if(!isTooLong($name, 30) && !isTooShort($name, 4) && preg_match("/^[a-zA-Z0-9 _\-\p{Arabic}\p{Cyrillic}\p{Latin}\p{Han}\p{Katakana}\p{Hiragana}\p{Hebrew}]{4,}$/ui", $name)){
		return true;
	}
}
function validRoomPass($pass){
	if(!isTooLong($pass, 20)){
		return true; 
	}
}
function validRoomDesc($desc){
	if(!isTooLong($desc, 150)){
		return true;
	}
}
function clearBreak($text){
	$text = preg_replace("/[\r\n]{2,}/", "\n\n", $text);
	return $text;
}
function removeBreak($text){
	$text = preg_replace( "/(\r|\n)/", " ", $text );
	return $text;
}
function emoItem($type){
	switch($type){
		case 1:
			$emoclass = 'emo_menu_item';
			break;
		case 2:
			$emoclass = 'emo_menu_item_priv';
			break;
	}
	$emo = '';
	$dir = glob('emoticon/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$emoitem = str_replace('emoticon/', '', $dirnew);
		$emo .= '<div data="' . $emoitem . '" class="emo_menu ' . $emoclass . '"><img class="emo_select" src="emoticon_icon/' . $emoitem . '.png"/></div>';
	}
	return $emo;
}
function userHaveEmail($user){
	if(isEmail($user['user_email'])){
		return true;
	}
}
function isEmail($email){
	if(filter_var($email, FILTER_VALIDATE_EMAIL) && !strstr($email, '+')){
		return true;
	}
}
function validEmail($email){
	global $mysqli, $setting;
	if(!isEmail($email)){
		return false;
	}
	if($setting['email_filter'] == 1){
		$get_end = explode('@', $email);
		$allowed = $get_end[1];
		$get_email = $mysqli->query("SELECT word FROM boom_filter WHERE word_type = 'email' AND word = '$allowed'");
		if($get_email->num_rows < 1){
			return false;
		}
	}
	return true;
}
function userPassword($pass){
	global $data;
	if(encrypt($pass) == $data['user_password']){
		return true;
	}
}
function userDelete($user){
	if($user['user_delete'] > 0){
		return true;
	}
}
function canEditUser($user, $rank, $type = 0){
	global $data;
	if($type == 1 && isBot($user)){
		return false;
	}
	if(mySelf($user['user_id'])){
		return false;
	}
	if(boomAllow($rank) && isGreater($user['user_rank']) && !isBot($user)){
		return true;
	}
	if(isOwner($data) && !isOwner($user)){
		return true;
	}
}
function useCoppa(){
	global $setting;
	if($setting['coppa'] == 1){
		return true;
	}
}
function checkCoppa(){
	if(useCoppa() && isset($_COOKIE[BOOM_PREFIX . 'cop'])){
		return true;
	}
}
function checkCoppaAge($age){
	if(useCoppa() && $age < 13){
		setBoomCoppa();
		return true;
	}
}
function emptyAge($age){
	if($age == '' || $age == 0){
		return true;
	}
}
function validAge($age){
	global $setting;
	if($age >= $setting['min_age'] && $age != '' && $age < 100){
		return true;
	}
}
function validCountry($country){
	require BOOM_PATH . '/system/location/country_list.php';
	if(array_key_exists($country, $country_list)){
		return true;
	}
}
function validColor($c) {
    if (preg_match('/^#[0-9A-Fa-f]{6}$/', $c)) {
        return true;
    }
}
function getLanguage(){
	global $mysqli, $setting, $data;
	$l = $setting['language'];
	if(boomLogged()){
		if(file_exists(BOOM_PATH . '/system/language/' . $data['user_language'] . '/language.php')){
			$l = $data['user_language'];
		}
		else {
			$mysqli->query("UPDATE boom_users SET user_language = '{$setting['language']}' WHERE user_id = '{$data['user_id']}'");
			redisUpdateUser($data['user_id']);
		}
	}
	else {
		if(isset($_COOKIE[BOOM_PREFIX . 'lang'])){
			$lang = boomSanitize($_COOKIE[BOOM_PREFIX . 'lang']);
			if(file_exists(BOOM_PATH . '/system/language/' . $lang . '/language.php')){
				$l = $lang;
			}
		}
	}
	return $l;
}
function isRtl($l){
	$rtl_list = array('Arabic','Persian','Farsi','Aramaic','Azeri','Hebrew','Dhivehi','Maldivian','Kurdish','Sorani','Urdu');
	if(in_array($l, $rtl_list)){
		return true;
	}
}
function getTheme(){
	global $mysqli, $setting, $data;
	$t = $setting['default_theme'];
	if(boomLogged()){
		if(canTheme() && $data['user_theme'] != 'system'){
			if(file_exists(BOOM_PATH . '/css/themes/' . $data['user_theme'] . '/' . $data['user_theme'] . '.css')){
				$t = $data['user_theme'];
			}
			else {
				$mysqli->query("UPDATE boom_users SET user_theme = 'system' WHERE user_id = '{$data['user_id']}'");
				redisUpdateUser($data['user_id']);
			}
		}
	}
	return $t . '/' . $t . '.css';
}
function getLoginPage(){
	global $setting;
	return $setting['login_page'];
}
function getLogo(){
	global $mysqli, $setting, $data;
	$logo = 'default_images/logo.png';
	if(boomLogged()){
		if(canTheme() && $data['user_theme'] != 'system'){
			if(file_exists(BOOM_PATH . '/css/themes/' . $data['user_theme'] . '/images/logo.png')){
				$logo = BOOM_DOMAIN . 'css/themes/' . $data['user_theme'] . '/images/logo.png';
			}
		}
	}
	else {
		if(file_exists(BOOM_PATH . '/css/themes/' . $setting['default_theme'] . '/images/logo.png')){
			$logo = BOOM_DOMAIN . 'css/themes/' . $setting['default_theme'] . '/images/logo.png';
		}
	}
	return $logo . boomFileVersion();
}
function okEmo($c){
	global $setting;
	if(substr_count($c, ':') <= ($setting['max_emo'] * 2)){
		return true;
	}
}
function emoticon($emoticon){
	if(!okEmo($emoticon)){
		return $emoticon;
	}
	$supported = smiliesType();
	$folder = BOOM_PATH . '/emoticon';
	if ($dir = opendir($folder)) {
		while (false !== ($file = readdir($dir))){
			if ($file != "." && $file != ".."){
				$select = preg_replace('/\.[^.]*$/', '', $file);
				foreach($supported as $sup){
					if(strpos($file, $sup)){
						$emoticon = str_replace(':' . $select . ':', '<img  data=":' . $select . ':" title=":' . $select . ':" class="emocc emo_chat" src="emoticon/' . $select . $sup . '"> ', $emoticon);
					}
				}
			}
		}
		closedir($dir);
	}
	$list = getEmo();
	foreach ($list as $value) {
		$type = 'emo_chat';
		if(stripos($value, 'sticker') !== false){
			$type = 'sticker_chat';
		}
		if(stripos($value, 'custom') !== false){
			$type = 'custom_chat';
		}
		if ($dir = opendir($folder . '/' . $value)){
			while (false !== ($file = readdir($dir))){
				if ($file != "." && $file != ".."){
					$select = preg_replace('/\.[^.]*$/', '', $file);
					foreach($supported as $sup){
						if(strpos($file, $sup)){
							$emoticon = str_replace(':' . $select . ':', '<img  data=":' . $select . ':" title=":' . $select . ':" class="emocc ' . $type . '" src="emoticon/' . $value . '/' . $select . $sup . '"> ', $emoticon);
						}
					}
				}
			}
			closedir($dir);
		}
	}
	return $emoticon;
}
function regEmoticon($emoticon){
	if(!okEmo($emoticon)){
		return $emoticon;
	}
	$supported = smiliesType();
	$folder = BOOM_PATH . '/emoticon';
	if ($dir = opendir($folder)){
		while (false !== ($file = readdir($dir))){
			if ($file != "." && $file != ".."){
				$select = preg_replace('/\.[^.]*$/', '', $file);
				foreach($supported as $sup){
					if(strpos($file, $sup)){
						$emoticon = str_replace(':' . $select . ':', '<img  data=":' . $select . ':" title=":' . $select . ':" class="emocc emo_chat" src="emoticon/' . $select . $sup . '"> ', $emoticon);
					}
				}
			}
		}
		closedir($dir);
	}
	return $emoticon;
}
function getEmo(){
	$emo = [];
	$dir = glob(BOOM_PATH . '/emoticon/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		array_push($emo, str_replace(BOOM_PATH . '/emoticon/', '', $dirnew));
	}
	return $emo;
}
function boomPostIt($user, $content, $type = 1) {
	$content = systemReplace($content);
	if(userCanDirect($user)){
		$content = postLinking($content);
	}
	else {
		$content = linkingReg($content);
	}
	$content = regEmoticon(emoprocess($content));
	if($type == 1){
		return nl2br($content);
	}
	else {
		return $content;
	}
}
function boomPostFile($content, $type) {
	if($content == ''){
		return '';
	}
	$content = BOOM_DOMAIN . $content;
	switch($type){
		case 'image':
			return '<div class="post_image"><a href="' . $content . '" data-fancybox><img src="' . $content . '"/></a></div>';
		case 'file':
			return '<div class="post_zip bclick"><a href="' . $content . '" download><img src="default_images/icons/file.svg"/></a></div>';
		case 'audio';
			return '<div class="post_audio"><audio preload="none" src="' . $content . '" controls></audio></div>';
		case 'video';
			return '<div class="post_video"><video preload="auto" src="' . $content . '" controls></video></div>';
		default:
			return '';
	}
}
function linking($content) {
	if(!badWord($content)){
		$source = $content;
		$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
		if(normalise($content, 1)){
			$content = str_replace(['youtu.be/', 'youtube.com/shorts/'],'youtube.com/watch?v=',$content);
			if(preg_match('@https:\/\/(www\.)?youtube.com/watch\?v=([a-zA-Z0-9_-]{11})([' . $regex . ']*)?@ui', $content)){
				$content = preg_replace('@https:\/\/(www\.)?youtube.com/watch\?v=([a-zA-Z0-9_-]{11})([' . $regex . ']*)?@ui', youtubeProcess('$2'), $content);
			}
			else {
				$content = preg_replace('@https?:\/\/([-\w\.]+[-\w])+(:\d+)?\/[' . $regex . ']+\.(png|gif|jpg|jpeg|webp)((\?\S+)?[^\.\s])?@ui', ' <a href="$0" data-fancybox><img class="chat_image"src="$0"/></a> ', $content);
			}
			if(preg_last_error()) {
				$content = $source;
			}
			$content = preg_replace('@([^=][^"])(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '$1<a href="$2" target="_blank">$2</a>', $content);
			$content = preg_replace('@^(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '<a href="$1" target="_blank">$1</a>', $content);
		}
	}
	return $content;
}
function linkingReg($content){
	return $content;
}
function linkingLink($content){
	$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
	$content = preg_replace('@([^=][^"])(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '$1<a href="$2" target="_blank">$2</a>', $content);
	$content = preg_replace('@^(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '<a href="$1" target="_blank">$1</a>', $content);
	return $content;
}
function postLinking($content, $n = 2) {
	if(!badWord($content)){
		$source = $content;
		$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
		if(normalise($content, $n)){
			$content = str_replace(['youtu.be/', 'youtube.com/shorts/'],'youtube.com/watch?v=',$content);
			$content = preg_replace('@https?:\/\/(www\.)?youtube.com/watch\?v=([\w_-]*)([' . $regex . ']*)?@ui', '<div class="video_container"><iframe src="https://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe></div>', $content);
			$content = preg_replace('@https?:\/\/([-\w\.]+[-\w])+(:\d+)?\/[' . $regex . ']+\.(png|gif|jpg|jpeg|webp)((\?\S+)?[^\.\s])?@i', '<div class="post_image"> <a href="$0" data-fancybox><img src="$0"/></a> </div>', $content);
			if(preg_last_error()) {
				$content = $source;
			}
			$content = preg_replace('@([^=][^"])(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '$1<a href="$2" target="_blank">$2</a>', $content);
			$content = preg_replace('@^(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '<a href="$1" target="_blank">$1</a>', $content);
		}
	}
	return $content;
}
function stripUrl($u){
	$u = str_replace(array('www.','https://','http://'), '', $u);
	$u = rtrim($u,"/");
	$e = explode('/', $u);
	$u = $e[0];
	$p = explode('.', $u);
	if(count($p) > 2){
		$u = str_replace($p[0] . '.', '', $u);
	}
	return $u;
}
function uploadProcess($type, $f, $t = ''){
	if($f == ''){
		return '';
	}
	$f = BOOM_DOMAIN . $f;
	$t = BOOM_DOMAIN . $t;
	switch($type){
		case 'image':
			return '<a href="' . $f .'" data-fancybox><img class="chat_image"src="' . $f . '"/></a> ';
		case 'tumb':
			return '<a href="' . $f .'" data-fancybox><img class="chat_image"src="' . $t . '"/></a> ';
		case 'file':
			return '<a href="' . $f . '" download><img class="chat_file" src="default_images/icons/file.svg"/></a>';
		case 'audio';
			return '<div data="' . $f . '" class="boomaudio chat_audio"><img class="chat_file" src="default_images/icons/audio.svg"/></div>';
		case 'video';
			return '<div data="' . $f . '" value="uvideo" class="boomvideo chat_uvideo"><img class="chat_file" src="default_images/icons/video.svg"/></div>';
		case 'voice';
			return '<div data="' . $f . '" class="boomaudio chat_audio"><img class="chat_file" src="default_images/icons/voice.svg"/></div>';
		default:
			return '';
	}
}
function youtubeProcess($id){
	return '<div class="chat_video_container">
				<img data="https://www.youtube.com/embed/' . $id . '" value="youtube" class="boomvideo chat_video" src="https://img.youtube.com/vi/' . $id . '/mqdefault.jpg"/>
				<img class="boomcvideo chat_cvideo" src="default_images/icons/youtube.svg"/>
			</div>';
}
function cleanBoomName($name){
	return str_replace(array(' ', "'", '"', '<', '>', ","), array('_', '', '', '', '', ''), $name);
}
function filterOrigin($origin){
	if(strlen($origin) > 55){
		$origin = mb_substr($origin, 0, 55);
	}
	return str_replace(array(' ', '.', '-'), '_', $origin);
}
function badWord($content){
	$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
	if(preg_match('@https?:\/\/(www\.)?([' . $regex . ']*)?([\*]{4}){1,}([' . $regex . ']*)?@ui', $content)){
		return true;
	}
}
function clearUserData($u){
	global $mysqli;
	if(empty($u)){
		return false;
	}
	$id = $u['user_id'];
	$av = $u['user_tumb'];
	$cv = $u['user_cover'];
	$mysqli->query("DELETE FROM boom_chat WHERE user_id = '$id' OR quser = '$id'");
	$mysqli->query("DELETE FROM boom_room_action WHERE action_user = '$id'");
	$mysqli->query("DELETE FROM boom_private WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_conversation WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_post WHERE post_user = '$id'");
	$mysqli->query("DELETE FROM boom_post_reply WHERE reply_user = '$id' OR reply_uid = '$id'");
	$mysqli->query("DELETE FROM boom_news_reply WHERE reply_user = '$id' OR reply_uid = '$id'");
	$mysqli->query("DELETE FROM boom_post_like WHERE uid = '$id' OR liked_uid = '$id'");
	$mysqli->query("DELETE FROM boom_news_like WHERE uid = '$id' OR liked_uid = '$id'");
	$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '$id'");
	$mysqli->query("DELETE FROM boom_friends WHERE hunter = '$id' OR target = '$id'");
	$mysqli->query("DELETE FROM boom_notification WHERE notifier = '$id' OR notified = '$id'");
	$mysqli->query("DELETE FROM boom_users WHERE user_id = '$id'");
	$mysqli->query("DELETE FROM boom_report WHERE report_user = '$id' OR report_target = '$id'");
	$mysqli->query("DELETE FROM boom_ignore WHERE ignorer  = '$id' OR ignored = '$id'");
	$mysqli->query("DELETE FROM boom_console WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_history WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_pro_like WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_exp WHERE uid = '$id'");
	$mysqli->query("DELETE FROM boom_users_gift WHERE target = '$id'");
	$mysqli->query("DELETE FROM boom_name WHERE uid = '$id'");
	$mysqli->query("DELETE FROM boom_data WHERE data_user = '$id'");
	$mysqli->query("DELETE FROM boom_users_data WHERE data_user = '$id'");
	$mysqli->query("DELETE FROM boom_call WHERE call_target = '$id' OR call_hunter = '$id'");
	$mysqli->query("DELETE FROM boom_group_call WHERE call_creator = '$id'");
	$del_av = unlinkAvatar($av);
	$del_cv = unlinkCover($cv);
	redisClearUser($id);
}
function cleanList($type, $c = 0){
	global $mysqli;
	$user = [];
	$av = [];
	$ac = [];
	$find_query = cleanListQuery($type);
	if(empty($find_query) || $find_query == ''){
		return false;
	}
	$find_list = $mysqli->query("SELECT user_id, user_tumb, user_cover FROM boom_users WHERE $find_query");
	if($find_list->num_rows > 0){
		while($user_list = $find_list->fetch_assoc()){
			array_push($user, $user_list['user_id']);
			array_push($av, $user_list['user_tumb']);
			array_push($ac, $user_list['user_cover']);
		}
		if(!empty($user)){
			$list = implode(", ", $user);
			$mysqli->query("DELETE FROM boom_chat WHERE user_id IN ($list) OR quser IN ($list)");
			$mysqli->query("DELETE FROM boom_users WHERE user_id IN ($list) AND $find_query");
			$mysqli->query("DELETE FROM boom_private WHERE hunter  IN ($list) OR target  IN ($list)");
			$mysqli->query("DELETE FROM boom_conversation WHERE hunter  IN ($list) OR target  IN ($list)");
			$mysqli->query("DELETE FROM boom_room_action WHERE action_user  IN ($list)");
			$mysqli->query("DELETE FROM boom_ignore WHERE ignorer  IN ($list) OR ignored  IN ($list)");
			$mysqli->query("DELETE FROM boom_report WHERE report_user IN ($list) OR report_target IN ($list)");
			$mysqli->query("DELETE FROM boom_notification WHERE notifier IN ($list) OR notified IN ($list)");
			$mysqli->query("DELETE FROM boom_post WHERE post_user IN ($list)");
			$mysqli->query("DELETE FROM boom_post_reply WHERE reply_user IN ($list) OR reply_uid IN ($list)");
			$mysqli->query("DELETE FROM boom_news_reply WHERE reply_user IN ($list) OR reply_uid IN ($list)");
			$mysqli->query("DELETE FROM boom_post_like WHERE uid IN ($list) OR liked_uid IN ($list)");
			$mysqli->query("DELETE FROM boom_news_like WHERE uid IN ($list) OR liked_uid IN ($list)");
			$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff IN ($list)");
			$mysqli->query("DELETE FROM boom_friends WHERE hunter IN ($list) OR target IN ($list)");
			$mysqli->query("DELETE FROM boom_console WHERE hunter IN ($list) OR target IN ($list)");
			$mysqli->query("DELETE FROM boom_history WHERE hunter IN ($list) OR target IN ($list)");
			$mysqli->query("DELETE FROM boom_pro_like WHERE hunter IN ($list) OR target IN ($list)");
			$mysqli->query("DELETE FROM boom_exp WHERE uid IN ($list)");
			$mysqli->query("DELETE FROM boom_users_gift WHERE target IN ($list)");
			$mysqli->query("DELETE FROM boom_name WHERE uid IN ($list)");
			$mysqli->query("DELETE FROM boom_data WHERE data_user IN ($list)");
			$mysqli->query("DELETE FROM boom_users_data WHERE data_user IN ($list)");
			$mysqli->query("DELETE FROM boom_call WHERE call_target IN ($list) OR call_hunter IN ($list)");
			$mysqli->query("DELETE FROM boom_group_call WHERE call_creator IN ($list)");
		}
		if(!empty($av)){
			foreach($av as $del_av){
				unlinkAvatar($del_av);
			}
			foreach($ac as $del_ac){
				unlinkCover($del_ac);
			}
			redisClearUserList($user);
		}
	}	
}
function softGuestDelete($u){
	global $mysqli;
	$id = $u['user_id'];
	if(!isGuest($u)){
		return false;
	}
	$new_pass = randomPass();
	$new_name = '@' . $u['user_name'] . '-' . $id;
	$mysqli->query("DELETE FROM boom_room_action WHERE action_user = '$id'");
	$mysqli->query("DELETE FROM boom_private WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_conversation WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '$id'");
	$mysqli->query("DELETE FROM boom_friends WHERE hunter = '$id' OR target = '$id'");
	$mysqli->query("DELETE FROM boom_notification WHERE notifier = '$id' OR notified = '$id'");
	$mysqli->query("UPDATE boom_users SET user_name = '$new_name', user_password = '$new_pass' WHERE user_id = '$id'");
	$mysqli->query("DELETE FROM boom_data WHERE data_user = '$id'");
	redisUpdateUser($id);
}
function getRoomUser($r){
	global $mysqli;
	$users = [];
	$get_users = $mysqli->query("SELECT user_id FROM boom_users WHERE user_roomid = '$r'");
	if($get_users->num_rows > 0){
		while($user = $get_users->fetch_assoc()){
			$users[] = $user['user_id'];
		}
	}
	return $users;
}
function getRoomUserList($list){
	global $mysqli;
	$users = [];
	$get_users = $mysqli->query("SELECT user_id FROM boom_users WHERE user_roomid IN ($list)");
	if($get_users->num_rows > 0){
		while($user = $get_users->fetch_assoc()){
			$users[] = $user['user_id'];
		}
	}
	return $users;
}
function deleteRoom($r, $type = 0){
	global $mysqli;
	
	$users = getRoomUser($r);

	if($type == 1 && !canManageRoom()){
		return 0;
	}
	if($r == 1){
		return 0;
	}
	$room = roomDetails($r);
	if(empty($room)){
		return 0;
	}
	if($type == 1){
		boomConsole('delete_room', array('custom'=>$room['room_name']));
	}
	$mysqli->query("DELETE FROM boom_rooms WHERE room_id = '$r'");
	$mysqli->query("DELETE FROM boom_chat WHERE post_roomid = '$r'");
	$mysqli->query("DELETE FROM boom_room_action WHERE action_room = '$r'");
	$mysqli->query("DELETE FROM boom_console WHERE room = '$r'");
	$mysqli->query("UPDATE boom_users SET user_roomid = 0, user_action = user_action + 1, user_role = 0 WHERE user_roomid = '$r'");
	unlinkRoomIcon($room['room_icon']);
	redisDeleteRoom($r, $users);
	return 1;
}
function cleanRoomList($list){
	global $mysqli;
	
	$users = getRoomUserList($list);
	
	$get_room = $mysqli->query("SELECT room_icon FROM boom_rooms WHERE room_id IN ($list)");
	if($get_room->num_rows > 0){
		while($room = $get_room->fetch_assoc()){
			unlinkRoomIcon($room['room_icon']);
		}
	}
	$mysqli->query("DELETE FROM boom_rooms WHERE room_id IN ($list)");
	$mysqli->query("DELETE FROM boom_chat WHERE post_roomid IN ($list)");
	$mysqli->query("DELETE FROM boom_room_action WHERE action_room IN ($list)");
	$mysqli->query("DELETE FROM boom_console WHERE room IN ($list)");
	$mysqli->query("UPDATE boom_users SET user_roomid = 0, user_action = user_action + 1, user_role = 0 WHERE user_roomid IN ($list)");
	redisDeleteRoomList($list, $users);
}
function cleanListQuery($type){
	global $setting;
	$chat_delay = calMinutes($setting['chat_delete']);
	$innactive_delay = calMinutes($setting['member_delete']);
	$delete_delay = time();
	switch($type){
		case 'guest':
			return "user_rank = 0";
		case 'innactive_guest':
			return "user_rank = 0 AND last_action <= '$chat_delay' LIMIT 1000";
		case 'innactive_member':
			return "user_rank < 50 AND user_bot = 0 AND last_action <= '$innactive_delay' LIMIT 500";
		case 'account_delete':
			return "user_rank < 100 AND user_bot = 0 AND user_delete > 0 AND user_delete < '$delete_delay' LIMIT 500";
		default:
			return "";
	}
}
function clearRoom($id){
	global $data, $mysqli, $lang;
	$clearmessage = str_ireplace('%user%', systemNameFilter($data), $lang['room_clear']);
	$mysqli->query("DELETE FROM `boom_chat` WHERE `post_roomid` = '$id' ");
	systemPostChat($data['user_roomid'], $clearmessage, array('type'=> 'system__clear'));
	chatAction($id);
	$mysqli->query("DELETE FROM boom_report WHERE report_room = '$id'");
	if($mysqli->affected_rows > 0){
		updateStaffNotify();
	}
	boomConsole('clear_logs');
	return true;
}
function changeTopic($topic){
	global $mysqli, $data;
	if(!canTopic()){
		return false;
	}
	$topic = preg_replace('/(^|[^"])(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="\\2" target="_blank">\\2</a>', $topic);
	$mysqli->query("UPDATE `boom_rooms` SET `topic` = '$topic' WHERE `room_id` = '{$data['user_roomid']}'");
	boomConsole('change_topic', array('reason'=> $topic));
	redisUpdateRoom($data['user_roomid']);
	return true;
}
function createPag($content, $max, $custom = array()){
	global $lang;
	$pag = '';
	$elem = [];
	$control = '';
	$state = 1;
	$count = 0;
	$def = array(
		'template'	=> 'element/empty_element',
		'empty'		=> emptyZone($lang['empty']),
		'menu'		=> 'centered_element',
		'content'	=> '',
		'style'		=> 'list',
	);
	$r = array_merge($def, $custom);
	if((is_array($content) && count($content) > 0) || (is_object($content) && $content->num_rows > 0)){
		foreach($content as $e){
			if($count == $max){
				$state++;
				$count = 0;
			}
			if(!isset($elem[$state])){
				$elem[$state] = '';
			}
			$elem[$state] .= boomTemplate($r['template'], $e);
			$count++;
		}
		foreach($elem as $key => $value){
			$hide = ($key > 1) ? 'hidden' : '';
			$pag .= '<div class="pagzone ' . $r['content'] . ' pagitem' . $key . ' ' . $hide . '">' . $value . '</div>';
		}
		$pag_data = [
			'state'=> $state,
			'menu'=> $r['menu'],
			'content'=> $pag,
			'id'=> rand(1111111,9999999),
			'style'=> $r['style'],
		];
		switch($r['style']){
			case 'list': return boomTemplate('element/pag_list', $pag_data);
			case 'load': return boomTemplate('element/pag_load', $pag_data);
			case 'arrow': return boomTemplate('element/pag_arrow', $pag_data);
			case 'dot': return boomTemplate('element/pag_dot', $pag_data);
			default: return boomTemplate('element/pag_arrow', $pag_data);
		}
	}
	else {
		return $r['empty'];
	}
}
function getRoomList($type = 1){
	global $mysqli;
	$check_action = getDelay();
	if($type == 1){
		$f = 'element/room_element';
	}
	else if($type == 2){
		$f = 'element/room_element_chat';
	}
	$rooms = $mysqli->query(" 
		SELECT *, 
		(SELECT Count(boom_users.user_id) FROM boom_users  Where boom_users.user_roomid = boom_rooms.room_id AND last_action > '$check_action' AND user_status != 99) as room_count
		FROM  boom_rooms 
		ORDER BY pinned DESC, room_count DESC, room_action DESC
	");
	$sroom = 0;
	$room_list = '';
	while ($room = $rooms->fetch_assoc()){
		$room_list .= boomTemplate($f, $room);
	}
	return $room_list;
}
function loadAddonsJs($type = 'chat'){
	global $mysqli, $data, $setting, $lang;
	$load_addons = $mysqli->query("SELECT * FROM boom_addons ORDER BY addons_load ASC");
	if($load_addons->num_rows > 0){
		while ($addons = $load_addons->fetch_assoc()){
			include BOOM_PATH . '/addons/' . $addons['addons'] . '/files/' . $addons['addons'] . '.php';
		}
	}
}
function getPageData($page_data = array()){
	global $setting;
	$page_default = array(
		'page'=> '',
		'page_load'=> '',
		'page_menu'=> 0,
		'page_rank'=> 0,
		'page_room'=> 1,
		'page_out'=> 0,
		'page_title'=> $setting['title'],
		'page_keyword'=> $setting['site_keyword'],
		'page_description'=> $setting['site_description'],
		'page_rtl'=> 1,
		'page_nohome'=> 0,
	);
	$page = array_merge($page_default, $page_data);
	return $page;
}
function lastRecordedId(){
	global $mysqli;
	$getid = $mysqli->query("SELECT MAX(user_id) AS last_id FROM boom_users");
	$id = $getid->fetch_assoc();
	return $id['last_id'] + 1;
}
function listThisArray($a){
	return implode(", ", $a);
}
function listWordArray($a){
	return "'" . implode("','", $a) . "'";
}
function arrayThisList($l){
	return explode(',', $l);
}
function isRoomBlocked($id){
	global $mysqli, $data;
	$get_room = $mysqli->query("SELECT count(id) as b FROM boom_room_action WHERE action_room = '$id' AND action_user = '{$data['user_id']}' AND action_blocked > '" . time() . "'");
	$result = $get_room->fetch_assoc();
	if($result['b'] > 0){
		return true;
	}
}
function setUserRoom(){
	global $data, $mysqli;
	$room = myRoomDetails($data['user_roomid']);
	if(joinMessage($data)){
		joinRoomMessage($data['user_roomid']);
	}
	$mysqli->query("UPDATE boom_users SET user_roomid = '{$data['user_roomid']}', user_move = '" . time() . "', last_action = '" . time() . "', room_mute = '{$room['room_muted']}', user_role = '{$room['room_ranking']}' WHERE user_id = '{$data['user_id']}'");
	redisInitUser($data);
}
function getRoomId(){
	global $mysqli, $data;
	if($data['user_roomid'] == 0){
		if(!useLobby() && !isRoomBlocked(1)){
			return 1;
		}
		else {
			return 0;
		}
	}
	else {
		return $data['user_roomid'];
	}
}
function boomCookieLaw(){
	global $setting;
	if(!isset($_COOKIE[BOOM_PREFIX . "claw"]) && $setting['cookie_law'] == 1){
		return true;
	}
}
function getActionList($type){
	global $mysqli, $lang;
	$action_list = '';
	$action_info = getActionCritera($type);
	$getaction = $mysqli->query("SELECT * FROM boom_users WHERE $action_info");
	if($getaction->num_rows > 0){
		while($action = $getaction->fetch_assoc()){
			$action['type'] = $type;
			$action_list .= boomTemplate('element/admin_action_user', $action);
		}
	}
	else {
		$action_list .= emptyZone($lang['empty']);
	}
	return $action_list;
}
function getActionType($type){
	switch($type){
		case 'muted':
			return 'unmute';
		case 'mmuted';
			return 'main_unmute';
		case 'pmuted';
			return 'private_unmute';
		case 'kicked':
			return 'unkick';
		case 'ghosted':
			return 'unghost';
		case 'banned':
			return 'unban';
		default:
			return '';
	}
}
function getActionTimer($type, $action){
	switch($type){
		case 'muted':
			return boomTimeLeft($action['user_mute']);
		case 'kicked':
			return boomTimeLeft($action['user_kick']);
		case 'ghosted':
			return boomTimeLeft($action['user_ghost']);
		case 'mmuted':
			return boomTimeLeft($action['user_mmute']);
		case 'pmuted':
			return boomTimeLeft($action['user_pmute']);
		default:
			return '';
	}
}
function getActionCritera($c){
	switch($c){
		case 'muted':
			return "user_mute > " . time() . " ORDER BY user_mute ASC";
		case 'mmuted':
			return "user_mmute > " . time() . " ORDER BY user_mmute ASC";
		case 'pmuted':
			return "user_pmute > " . time() . " ORDER BY user_mmute ASC";
		case 'kicked':
			return "user_kick > " . time() . " ORDER BY user_kick ASC";
		case 'ghosted':
			return "user_ghost > " . time() . " ORDER BY user_ghost ASC";
		case 'banned':
			return "user_banned > 0 ORDER BY last_action DESC";
		default:
			return "user_id = 0";
	}	
}
function loadPageData($page){
	global $mysqli;
	$page_data = '';
	if(redisCacheExist('page:' . $page)){
		return redisGetElement('page:' . $page);
	}
	else {
		$get_page = $mysqli->query("SELECT * FROM boom_page WHERE page_name = '$page' LIMIT 1");
		if($get_page->num_rows > 0){
			$pdata = $get_page->fetch_assoc();
			$page_data = $pdata['page_content'];
		}
		redisSetElement('page:' . $page, $page_data);
		return $page_data;
	}
}
function loginFail($ip){
	global $mysqli;
	$logdelay = calMinutes(60);
	$get_count = $mysqli->query("SELECT count(id) as clogin FROM boom_login WHERE logip = '$ip' AND logdate > '$logdelay'");
	$login = $get_count->fetch_assoc();
	if($login['clogin'] >= 10){
		return true;
	}
}
function recordLoginFail($ip){
	global $mysqli;
	$mysqli->query("INSERT INTO boom_login (logip, logdate) VALUES ('$ip', '" . time() . "')");
}
function canSendMail($user, $type, $max){
	global $mysqli;
	$delayed = calHour(24);
	$count = $mysqli->query("SELECT * FROM boom_mail WHERE mail_user = '{$user['user_id']}' AND mail_type = '$type' AND mail_date >= '$delayed'");
	if($count->num_rows < $max){
		return true;
	}
}
function insertMail($user, $type){
	global $mysqli;
	$delay = calHour(48);
	$mysqli->query("INSERT INTO boom_mail (mail_user, mail_date, mail_type) VALUES ('{$user['user_id']}', '" . time() . "', '$type')");
	$mysqli->query("DELETE FROM boom_mail WHERE mail_date < '$delay'");
}
function boomCheckRecaptcha(){
	global $setting;
	if(!boomRecaptcha()){
		return true;
	}
	if(!isset($_POST['recaptcha'])){
		return false;
	}
	$recapt = escape($_POST['recaptcha']);
	if(empty($recapt)){
		return false;
	}
	if($setting['use_recapt'] == 1){
		$recapt_url = 'https://www.google.com/recaptcha/api/siteverify';
	}
	else if($setting['use_recapt'] == 2){
		$recapt_url = 'https://hcaptcha.com/siteverify';
	}
	else if($setting['use_recapt'] == 3){
		$recapt_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
	}
	else {
		return false;
	}
	$recapt_data = array('secret' => $setting['recapt_secret'], 'response' => $recapt);
	$response = doCurl($recapt_url, $recapt_data);
	$recheck = json_decode($response);
	if($recheck->success == true){
		return true;
	}
}
function validSwitch($v){
	if($v == 1 || $v == 0){
		return true;
	}
}
function createSwitch($id, $val, $ccall){
	switch($val){
		case 0:
			return '<div id="' . $id . '" class="btable bswitch offswitch" data="0" data-c="' . $ccall . '">
						<div class="bball_wrap"><div class="bball offball"></div></div>
					</div>';
		case 1:
			return '<div id="' . $id . '" class="btable bswitch onswitch" data="1" data-c="' . $ccall . '">
						<div class="bball_wrap"><div class="bball onball"></div></div>
					</div>';
		default:
			return false;
	}
}
function soundCode($sound, $val){
	if($val > 0){
		switch($sound){
			case 'chat':
				return '1';
			case 'private':
				return '2';
			case 'notify':
				return '3';
			case 'name':
				return '4';
			case 'call':
				return '5';
			default:
				return '';
		}
	}
	else {
		return '';
	}
}
function soundStatus($val){
	global $data;
	if(preg_match('@[' . $val . ']@i', $data['user_sound'])){
		return 1;
	}
	else {
		return 0;
	}
}
function playSound($val){
	global $data;
	if(preg_match('@[' . $val . ']@i', $data['user_sound'])){
		return true;
	}
}
function getLikes($post, $liked, $type){
	global $mysqli;
	$result = array(
		'like_post'=> $post,
		'like_count'=> 0,
		'dislike_count'=> 0,
		'love_count'=> 0,
		'fun_count'=> 0,
		'liked'=> '',
		'disliked'=> '',
		'loved'=> '',
		'funned'=> '',
	);
	if($type == 'wall'){
		$get_like = $mysqli->query("SELECT like_type FROM boom_post_like WHERE like_post = '$post'");
	}
	else if($type == 'news'){
		$get_like = $mysqli->query("SELECT like_type FROM boom_news_like WHERE like_post = '$post'");
	}
	else {
		return '';
	}
	switch($liked){
		case 1:
			$result['liked'] = ' liked';
			break;
		case 2:
			$result['disliked'] = ' liked';
			break;
		case 3:
			$result['loved'] = ' liked';
			break;
		case 4:
			$result['funned'] = ' liked';
			break;
		default:
			break;
	}
	if($get_like->num_rows > 0){
		while($like = $get_like->fetch_assoc()){
			if($like['like_type'] == 1){
				$result['like_count']++;
			}
			else if($like['like_type'] == 2){
				$result['dislike_count']++;
			}
			else if($like['like_type'] == 3){
				$result['love_count']++;
			}
			else if($like['like_type'] == 4){
				$result['fun_count']++;
			}
		}
	}
	if($type == 'wall'){
		return 	boomTemplate('element/likes_wall', $result);
	}
	else if($type == 'news'){
		return boomTemplate('element/likes_news', $result);
	}
	else {
		return '';
	}
}
function useLike(){
	global $setting;
	if($setting['use_like'] > 0){
		return true;
	}
}
function showUserLike($user){
	if(useLike() && isMember($user)){
		return true;
	}
}
function canLikeUser($user){
	global $data;
	if(isMember($user) && isMember($data) && !mySelf($user['user_id'])){
		return true;
	}
}
function getProfileLikes($user, $type = 0){
	global $mysqli, $data;
	$get_likes = $mysqli->query("
		SELECT
		(SELECT count(id) FROM boom_pro_like WHERE target = '{$user['user_id']}') as total_like,
		(SELECT count(id) as liked FROM boom_pro_like WHERE target = '{$user['user_id']}' AND hunter = '{$data['user_id']}') as liked
	");
	$c = $get_likes->fetch_assoc();
	$c['liking'] = 0;
	if(canLikeUser($user)){
		$c['liking'] = 1;
		$c['user'] = $user['user_id'];
	}
	$user = array_merge($user, $c);
	echo boomTemplate('element/pro_like', $user);
}
function getProfileLevel($user){
	echo boomTemplate('element/pro_level', $user);
}
function listReport(){
	global $lang;
	$rep = '';
	$rep .= '<option value="0">' . $lang['report_select'] . '</option>';
	$rep .= '<option value="1">' . $lang['report_language'] . '</option>';
	$rep .= '<option value="2">' . $lang['report_content'] . '</option>';
	$rep .= '<option value="3">' . $lang['report_fraud'] . '</option>';
	return $rep;
}
function validReport($r){
	$valid = array(1,2,3);
	if(in_array($r, $valid)){
		return true;
	}
}
function renderReport($r){
	global $lang;
	switch($r){
		case 1:
			return $lang['report_language'];
		case 2:
			return $lang['report_content'];
		case 3:
			return $lang['report_fraud'];
		default:
			return 'N/A';
	}
}
function userActive($user){
	if(!isVisible($user) && !canViewInvisible()){
		$active = 'innactive.svg';
	}
	else if($user['last_action'] >= getDelay() || isBot($user)){
		$active = 'active.svg';
	}
	else {
		$active = 'innactive.svg';
	}
	return 'default_images/icons/' . $active;
}
function boomConsole($type, $custom = array()){
	global $mysqli, $data;
	$def = array(
		'text'=> '',
		'hunter'=> $data['user_id'],
		'target'=> $data['user_id'],
		'room'=> $data['user_roomid'],
		'rank'=> 0,
		'delay'=> 0,
		'reason'=> '',
		'custom' => '',
		'custom2' => '',
	);
	$c = array_merge($def, $custom);
	$mysqli->query("INSERT INTO boom_console (hunter, target, room, ctype, crank, delay, reason, ctext, custom, custom2, cdate) VALUES ('{$c['hunter']}', '{$c['target']}', '{$c['room']}', '$type', '{$c['rank']}', '{$c['delay']}', '{$c['reason']}', '{$c['text']}', '{$c['custom']}', '{$c['custom2']}', '" . time() . "')");
}
function boomHistory($type, $custom = array()){
	global $mysqli, $data;
	$def = array(
		'hunter'=> $data['user_id'],
		'target'=> 0,
		'rank'=> 0,
		'delay'=> 0,
		'reason'=> '',
		'content'=> '',
	);
	$c = array_merge($def, $custom);
	if($c['target'] == 0){
		return false;
	}
	$mysqli->query("INSERT INTO boom_history (hunter, target, htype, delay, reason, history_date) VALUES ('{$c['hunter']}', '{$c['target']}', '$type',  '{$c['delay']}', '{$c['reason']}', '" . time() . "')");
}
function renderReason($t){
	global $lang;
	switch($t){
		case '':
			return $lang['no_reason'];
		case 'badword':
			return $lang['badword'];
		case 'spam':
			return $lang['spam'];
		case 'flood':
			return $lang['flood'];
		case 'vpn':
			return $lang['vpn'];
		default:
			return systemReplace($t);
	}
}
function getFriendList($id, $type = 0){
	global $mysqli;
	$friend_list = [];
	$find_friend = $mysqli->query("SELECT target FROM boom_friends WHERE hunter = '$id' AND fstatus = '3'");
	if($find_friend->num_rows > 0){
		while($find = $find_friend->fetch_assoc()){
			array_push($friend_list, $find['target']);
		}
		if($type == 1){
			array_push($friend_list, $id);
		}
	}
	return $friend_list;
}
function getActiveFriendList($id, $type = 0){
	global $mysqli;
	$delay = calDay(10);
	$friend_list = [];
	$find_friend = $mysqli->query("
		SELECT target, last_action
		FROM boom_friends
		LEFT JOIN boom_users ON user_id = target
		WHERE hunter = '$id' AND fstatus = '3'
	");
	if($find_friend->num_rows > 0){
		while($find = $find_friend->fetch_assoc()){
			if($find['last_action'] > $delay){
				array_push($friend_list, $find['target']);
			}
		}
		if($type == 1){
			array_push($friend_list, $id);
		}
	}
	return $friend_list;
}
function getRankList($rank){
	global $mysqli;
	$list = [];
	$find_list = $mysqli->query("SELECT user_id FROM boom_users WHERE user_rank = '$rank'");
	if($find_list->num_rows > 0){
		while($find = $find_list->fetch_assoc()){
			array_push($list, $find['user_id']);
		}
	}
	return $list;
}
function getStaffList(){
	global $mysqli;
	$list = [];
	$find_list = $mysqli->query("SELECT user_id FROM boom_users WHERE user_rank >= 70");
	if($find_list->num_rows > 0){
		while($find = $find_list->fetch_assoc()){
			array_push($list, $find['user_id']);
		}
	}
	return $list;
}

// clean function

function cleanDetails(){
	global $mysqli;
	$get_clean = $mysqli->query("SELECT * FROM boom_clean WHERE id = 1");
	$c = $get_clean->fetch_assoc();
	return $c;
}
function cleanDelay(){
	return calMinutesUp(5);
}

// vpn function check

function canVpn(){
	global $data;
	if($data['uvpn'] == 0){
		return true;
	}
	if(boomAllow(2)){
		return true;
	}
}
function userCanVpn($user){
	if(userBoomAllow($user, 2)){
		return true;
	}
}
function useVpn(){
	global $setting;
	if($setting['use_vpn'] > 0 && !empty($setting['vpn_key'])){
		return true;
	}
}
function useLookup(){
	global $setting;
	if(!empty($setting['vpn_key'])){
		return true;
	}
}
function checkVpn($ip){
	global $mysqli, $setting;
	if(useVpn()){
		$check_vpn = $mysqli->query("SELECT vtype FROM boom_vpn WHERE vip = '$ip'");
		if($check_vpn->num_rows > 0){
			$result = $check_vpn->fetch_assoc();
			if($result['vtype'] == 2){
				return true;
			}
		}
		else {
			$type = 1;
			$check = doCurl('http://proxycheck.io/v2/' . $ip . '?key=' . $setting['vpn_key'] . '&vpn=1&asn=1&inf=0&risk=1&days=7&tag=msg');
			$result = json_decode($check);
			if($result->status == 'ok'){
				if($result->$ip->proxy && $result->$ip->proxy == "yes"){
					$type = 2;
				}
				$mysqli->query("INSERT INTO boom_vpn (vip, vtype, vdate) VALUES ('$ip', '$type', '" . time() . "')");
				if($type == 2){
					return true;
				}
			}
		}
	}
}
function recheckVpn(){
	global $data;
	if(useVpn() && !canVpn()){
		$ip = getIp();
		if(!isset($_SESSION[BOOM_PREFIX . '_cip']) || $ip != $_SESSION[BOOM_PREFIX . '_cip']){
			if(checkVpn($ip)){
				systemVpnKick($data);
				return true;
			}
			else {
				$_SESSION[BOOM_PREFIX . '_cip'] = $ip;
			}
		}
	}
}

// room access ranking functions

function validRoomAccess($a){
	$valid = array(0,1,50,70,80);
	if(in_array($a, $valid) && boomAllow($a)){
		return true;
	}
}
function roomAccessTitle($room){
	global $lang;
	switch($room){
		case 0:
			return $lang['public'];
		case 1:
			return $lang['members'];
		case 50:
			return rankTitle(50);
		case 70:
			return $lang['staff'];
		case 80:
			return rankTitle(80);
		default:
			return $lang['public'];
	}
}
function roomAccessIcon($room){
	switch($room){
		case 0:
			return 'public_room.svg';
		case 1:
			return 'member_room.svg';
		case 50:
			return 'vip_room.svg';
		case 70:
			return 'staff_room.svg';
		case 80:
			return 'admin_room.svg';
		default:
			return 'public_room.svg';
	}
}
function roomAccess($r, $type){
	switch($r){
		case 0:
		case 1:
		case 50:
		case 70:
		case 80:
			return roomAccessTemplate($type, roomAccessTitle($r), roomAccessIcon($r));
		default:
			return roomAccessTemplate($type, roomAccessTitle(0), roomAccessIcon(0));
	}
}
function roomAccessTemplate($type, $txt, $icon){
	return '<img title="' . $txt . '" class="' . $type .  '" src="default_images/rooms/' . $icon . '">';	
}
function roomAccessOption($rank, $val){
	return '<option value="' . $val . '" ' . selCurrent($rank, $val) . '>' . roomAccessTitle($val) . '</option>';
}
function listRoomAccess($rank = 0){
	$room_menu = roomAccessOption($rank, 0);
	if(boomAllow(1)){
		$room_menu .= roomAccessOption($rank, 1);
	}
	if(boomAllow(50)){ 
		$room_menu .= roomAccessOption($rank, 50);
	}
	if(boomAllow(70)){ 
		$room_menu .= roomAccessOption($rank, 70);
	}
	if(boomAllow(80)){ 
		$room_menu .= roomAccessOption($rank, 80);
	}
	return $room_menu;
}
function roomPass($r){
	if($r != ''){
		return true;
	}
}
function roomLock($r, $type){
	if($r != ''){
		return '<img  class="' . $type .  '" src="default_images/rooms/locked_room.svg">';
	}
}
function roomPinned($room, $type){
	if($room['pinned'] > 0){
		return '<img  class="' . $type .  '" src="default_images/rooms/pinned_room.svg">';
	}
}

// timer functions

function boomRenderMinutes($val){
	global $lang;
	$year = '';
	$day = '';
	$hour = '';
	$minute = '';
	$y = floor ($val / 525600);
	$d = floor (($val - ($y * 525600)) / 1440);
	$h = floor (($val - ($y * 525600) - ($d * 1440)) / 60);
	$m = $val - ($y * 525600) - ($d * 1440) - ($h * 60);
	if($y > 0){
		if($y > 1){ $year = $y . ' ' . $lang['years']; } else{ $year = $y . ' ' . $lang['year']; }
	}
	if($d > 0){
		if($d > 1){ $day = $d . ' ' . $lang['days']; } else{ $day = $d . ' ' . $lang['day']; }
	}
	if($h > 0){
		if($h > 1){ $hour = $h . ' ' . $lang['hours']; } else{ $hour = $h . ' ' . $lang['hour']; }
	}
	if($m > 0){
		if($m > 1){ $minute = $m . ' ' . $lang['minutes']; } else{ $minute = $m . ' ' . $lang['minute']; }
	}
	return trim($year . ' ' . $day . ' ' . $hour  . ' ' . $minute);
}
function boomRenderSeconds($val){
	global $lang;
	$year = '';
	$day = '';
	$hour = '';
	$minute = '';
	$second = '';
	$y = floor($val / 31536000);
	$d = floor (($val - ($y * 31536000)) / 86400);
	$h = floor (($val - ($y * 31536000) - ($d * 86400)) / 3600);
	$m = floor (($val - ($y * 31536000) - ($d * 86400) - ($h * 3600)) / 60);
	$s = $val - ($y * 31536000) - ($d * 86400) - ($h * 3600) - ($m * 60);
	if($y > 0){
		if($y > 1){ $year = $y . ' ' . $lang['years']; } else{ $year = $y . ' ' . $lang['year']; }
	}
	if($d > 0){
		if($d > 1){ $day = $d . ' ' . $lang['days']; } else{ $day = $d . ' ' . $lang['day']; } }
	if($h > 0){
		if($h > 1){ $hour = $h . ' ' . $lang['hours']; } else{ $hour = $h . ' ' . $lang['hour']; }
	}
	if($m > 0){
		if($m > 1){ $minute = $m . ' ' . $lang['minutes']; } else{ $minute = $m . ' ' . $lang['minute']; }
	}
	if($s > 0){
		if($s > 1){ $second = $s . ' ' . $lang['seconds']; } else{ $second = $s . ' ' . $lang['second']; }
	}
	return trim($year . ' ' . $day . ' ' . $hour  . ' ' . $minute . ' ' . $second);
}
function boomTimeLeft($t){
	return boomRenderMinutes(floor(($t - time()) / 60));
}
function boomTimeAgo($t){
	global $lang;
	$t = boomRenderMinutes(floor((time() - $t) / 60));
	if(empty($t)){
		return $lang['just_now'];
	}
	else {
		return str_replace('%time%', $t, $lang['time_ago']);
	}
}



// country and flag functions

function listCountry($c){
	global $lang;
	require BOOM_PATH . '/system/location/country_list.php';
	$list_country = '';
	foreach ($country_list as $country => $key) {
		$list_country .= '<option ' . selCurrent($c, $country) . ' value="' . $country . '">' . $key . '</option>';
	}	
	return $list_country;
}
function countryName($country){
	global $lang;
	require BOOM_PATH . '/system/location/country_list.php';
	if(array_key_exists($country, $country_list)){
		return $country_list[$country];
	}
	else {
		return $lang['not_available'];
	}
}

// chat post functions

function userPostChat($content, $args = array()){
	global $mysqli, $data;
	$quote = [];
	$quoted = 0;
	$quoted_post = 0;
	$quoted_user = 0;
	$ghosted = 0;
	$file = 0;
	$def = array(
		'hunter'=> $data['user_id'],
		'room'=> $data['user_roomid'],
		'file'=> '',
		'file2'=> '',
		'filetype'=> 'file',
		'color'=> escape(myTextColor($data)),
		'type'=> 'public__message',
		'rank'=> 999,
		'quote'=> 0,
	);
	$c = array_merge($def, $data, $args);
	if($c['quote'] > 0 && useQuote() && canQuote()){
		$quote = quoteDetails($c['quote']);
		if(!empty($quote) && !isBot($quote) && myRoom($quote['post_roomid'])){
			$quoted = 1;
			$quoted_post = $quote['post_id'];
			$quoted_user = $quote['user_id'];
			if($quote['pghost'] > 0){
				$ghosted = 1;
			}
		}
	}
	if($c['file'] != ''){
		$file = 1;
	}
	if(isGhosted($data)){
		$ghosted = 1;
	}
	$mysqli->query("INSERT INTO `boom_chat` (post_date, user_id, post_message, post_roomid, type, file, log_rank, tcolor, quser, qpost, pghost) VALUES ('" . time() . "', '{$c['hunter']}', '$content', '{$c['room']}', '{$c['type']}', '$file', '{$c['rank']}', '{$c['color']}', '$quoted_user', '$quoted_post', '$ghosted')");
	$last_id = $mysqli->insert_id;
	if($c['file'] != ''){
		insertUpload('chat', $c['file'], $c['filetype'], $last_id);
	}
	if($c['file2'] != ''){
		insertUpload('chat', $c['file2'], $c['filetype'], $last_id);
	}
	chatAction($data['user_roomid']);
	addExp('chat');
	$post = getChatLog($last_id);
	if(!empty($post)){
		return createLog($post, $quote);
	}
}
function botPostChat($id, $room, $content, $custom = array()){
	global $mysqli;
	$def = array(
		'type'=> 'public__message',
		'color'=> '',
		'rank'=> 999,
		'ghost'=> 0,
		'uid'=> 0,
	);
	$post = array_merge($def, $custom);
	$mysqli->query("
	INSERT INTO `boom_chat` (post_date, user_id, post_message, post_roomid, type, log_rank, tcolor, pghost, log_uid) VALUES ('" . time() . "', '$id', '$content', '$room', '{$post['type']}', '{$post['rank']}', '{$post['color']}', '{$post['ghost']}', '{$post['uid']}')");
	chatAction($room);	
	return true;
}

// private post functions

function canSendPrivate($user){
	global $data;
	if(empty($user)){
		return false;
	}
	if(!userCanPrivate($user)){
		return false;
	}
	if(mySelf($user['user_id'])){
		return false;
	}
	if($user['user_private'] == 0 || $data['user_private'] == 0){ 
		if(!canBypassPrivate($user)){
			return false;
		}
	}
	if(($data['user_private'] == 2 || $user['user_private'] == 2) && !haveFriendship($user)){
		if(!canBypassPrivate($user)){
			return false;
		}
	}
	if(($data['user_private'] == 3 || $user['user_private'] == 3) && isGuest($data)){
		return false;
	}
	if(ignored($user) || ignoring($user)){
		return false;
	}
	return true;
}
function canSendPrivateNotification($user){
	global $data;
	if(!isGhosted($data)){
		return true;
	}
	if(isGhosted($data) && conversationExist($user)){
		return true;
	}
}
function canBypassPrivate($user){
	global $setting, $data;
	if(boomAllow($setting['can_bpriv']) && isGreater($user['user_rank'])){
		return true;
	}
}
function conversationExist($user){
	global $mysqli, $data;
	$getconv = $mysqli->query("SELECT cid FROM boom_conversation WHERE hunter = '{$user['user_id']}' AND target = '{$data['user_id']}'");
	if($getconv->num_rows > 0){
		return true;
	}
}
function userPostPrivate($user, $content, $args = array()){
	global $mysqli, $data;
	$quote = [];
	$quoted_post = 0;
	$file = 0;
	$def = array(
		'file'=> '',
		'filetype'=> 'file',
		'quote'=> 0,
		'qpost'=> 0,
	);
	$p = array_merge($def, $args);
	if($p['file'] != ''){
		$file = 1;
	}
	if($p['quote'] > 0 && usePrivateQuote() && canPrivateQuote() && !isBot($user)){
		$quote = privateQuoteDetails($p['quote']);
		if(!empty($quote) && validPrivateQuote($user, $quote)){
			$quoted_post = $quote['id'];
		}
	}
	$mysqli->query("INSERT INTO `boom_private` (time, target, hunter, message, file, qpost) VALUES ('" . time() . "', '{$user['user_id']}', '{$data['user_id']}', '$content', '$file', '$quoted_post')");
	$last_id = $mysqli->insert_id;
	if($p['file'] != ''){
		insertUpload('private', $p['file'], $p['filetype'], $last_id);
	}
	if(canSendPrivateNotification($user)){
		$mysqli->query("UPDATE boom_users SET pcount = pcount + 1 WHERE user_id = '{$user['user_id']}' OR user_id = '{$data['user_id']}'");
		updateConv($data['user_id'], $user['user_id']);
		redisUpdatePrivate($data['user_id']);
	}
	addExp('priv');
	$post = getPrivateLog($last_id);
	if(!empty($post)){
		return createPrivateLog($post, $quote);
	}
}
function systemPostPrivate($target, $content){
	global $mysqli, $setting;
	$mysqli->query("INSERT INTO `boom_private` (time, target, hunter, message) VALUES ('" . time() . "', '$target', '{$setting['system_id']}', '$content')");
	$last_id = $mysqli->insert_id;
	$mysqli->query("UPDATE boom_users SET pcount = pcount + 1 WHERE user_id = '$target'");
	updateConv($setting['system_id'], $target);
}
function botPostPrivate($hunter, $target, $content){
	global $mysqli;
	$mysqli->query("INSERT INTO `boom_private` (time, target, hunter, message) VALUES ('" . time() . "', '$target', '$hunter', '$content')");
	$last_id = $mysqli->insert_id;
	$mysqli->query("UPDATE boom_users SET pcount = pcount + 1 WHERE user_id = '$target'");
	updateConv($hunter, $target);
}
function validPrivateQuote($user, $log){
	global $data;
	if($log['hunter'] == $user['user_id'] && $log['target'] == $data['user_id']){
		return true;
	}
	if($log['hunter'] == $data['user_id'] && $log['target'] == $user['user_id']){
		return true;
	}
}

// paste functions

function mainPaste(){
	return (canUploadChat()) ? 1 : 0;
}
function privatePaste(){
	return (canUploadPrivate()) ? 1 : 0;
}	

// sub menu functions

function subMenu($icon, $title, $sub = ''){
	$sub = [
		'icon'=> $icon,
		'title'=> $title,
		'sub'=> $sub,
	];
	return 	boomTemplate('element/submenu', $sub);
}

// userlist functions

function createUserlist($list, $lazy = false){
	if(!isVisible($list)){
		return false;
	}
	$status = '';
	$offline = 'offline';
	
	if($list['last_action'] > getDelay() || isBot($list)){
		$offline = '';
		$status = getListStatus($list);
	}
	if($lazy){
		$avatar = '<img class="lazy avav acav ' . genderBorder($list['user_sex']) . '" data-src="' . myAvatar($list['user_tumb']) . '" src="' . imgLoader() . '"/>';
	}
	else {
		$avatar = '<img class="avav acav ' . genderBorder($list['user_sex']) . '" src="' . myAvatar($list['user_tumb']) . '"/>';
	}
	return '<div data-i="u' . $list['user_id'] . '" data-av="'.myAvatar($list['user_tumb']).'" data-cover="' . $list['user_cover'] . '" data-id="'.$list['user_id'].'" data-name="'.$list['user_name'].'" data-rank="'.$list['user_rank'].'" data-level="'.$list['user_level'].'" data-bot="'.$list['user_bot'].'" data-country="' . uCountry($list) . '" data-gender="' . uGender($list) . '" data-age="' . uAge($list) . '" class="avtrig drop_user bhover user_item ' . $offline . '">
				<div class="user_item_avatar">' . $avatar . ' ' . $status . '</div>
				<div class="user_item_data">
					<p class="username ' . myColorFont($list) . '">' . $list["user_name"] . '</p>
					<p class="list_mood">' . $list['user_mood'] . '</p>
				</div>
				' . getListAction($list). '
				<div class="user_item_icon icrank">' . userListRank($list) . '</div>
				' . getListFlag($list) . '
			</div>';
}

function getListAction($user){
	$action = '';
	if(isGhosted($user) && canGhost()){
		$action .= '<div class="user_item_icon icghost"><img class="list_ghost" src="default_images/actions/ghost.svg"/></div>';
	}
	if(isMuted($user) || isMainMuted($user)){
		$action .=  '<div class="user_item_icon icmute"><img class="list_mute" src="default_images/actions/muted.svg"/></div>';
	}
	else if(isRoomMuted($user)){
		$action .= '<div class="user_item_icon icmute"><img class="list_mute" src="default_images/actions/room_muted.svg"/></div>';
	}
	return $action;
}
function getListStatus($user){
	if($user['user_status'] != 99 && $user['user_status'] != 1){
		return '<img title="' . statusTitle($user['user_status']) . '" class="list_status" src="default_images/status/' . statusIcon($user['user_status']) . '"/>';
	}
}

function getListFlag($user){
	global $setting;
	if($setting['use_flag'] > 0 && userShareLocation($user)){
		return '<div class="user_item_icon icflag"><img class="list_flag" src="system/location/flag/' . $user['country'] . '.png"/></div>';
	}
}

// pending box function

function createModal($c, $t, $s, $p = ''){
	return [
		'content'=> $c,
		'type'=> $t,
		'size'=> $s,
		'sound'=> $p,
	];
}

// status functions

function newStatusIcon($status){
	return 'default_images/status/' . statusIcon($status);
}
function statusElement($val, $txt, $icon){
	return '<div class="status_option bhover fmenu_item" onclick="updateStatus(' . $val . ');" data="' . $val . '">
				<div class="fmenu_icon"><img class="icon_status" src="default_images/status/' . $icon . '"/></div>
				<div class="fmenu_text">' . $txt . '</div>
			</div>';
}
function listAllStatus(){
	$status = '';
	$list = statusList();
	foreach($list as $val){
		if($val == 99){
			if(canInvisible()){
				$status .= statusElement($val, statusTitle($val), statusIcon($val));
			}
		}
		else {
			$status .= statusElement($val, statusTitle($val), statusIcon($val));
		}
	}
	return $status;
}
function validStatus($val){
	$valid = statusList();
	if($val == 99 && !canInvisible()){
		return false;
	}
	if(in_array($val, $valid)){
		return true;
	}
}

// listing rank functions

function proRank($user, $type = 'pro_ranking'){
	return systemRank($user['user_rank'], $type) . ' ' . rankTitle($user['user_rank']);
}
function menuRank($user, $type = 'menuranking'){
	return systemRank($user['user_rank'], $type) . ' ' . rankTitle($user['user_rank']);
}
function userlistRank($list, $type = 'list_rank'){
	if(haveRole($list['user_role']) && !isStaff($list)){
		return roomRank($list['user_role'], $type);
	}
	return systemRank($list['user_rank'], $type);
}
function rankOption($current, $val){
	return '<option value="' . $val . '" ' . selCurrent($current, $val) . '>' . rankTitle($val) . '</option>';
}
function roomRankOption($current, $val){
	return '<option value="' . $val . '" ' . selCurrent($current, $val) . '>' . roomRankTitle($val) . '</option>';
}
function validRank($r){
	if(validValue($r, rankList()) && $r != 999){
		return true;
	}
}
function listRank($current){
	$rank = '';
	foreach(rankList() as $val){
		if($val != botRank()){
			$rank .= rankOption($current, $val);
		}
	}
	return $rank;
}
function listRankMember($current){
	$rank = '';
	foreach(rankList() as $val){
		if($val > 0 && $val != botRank()){
			$rank .= rankOption($current, $val);
		}
	}
	return $rank;
}
function listRankStaff($current){
	$rank = '';
	foreach(rankList() as $val){
		if($val >= 70 && $val <= 100){
			$rank .= rankOption($current, $val);
		}
	}
	return $rank;
}
function listRankStaffExtend($current){
	$rank = '';
	foreach(rankList() as $val){
		if($val >= 70){
			$rank .= rankOption($current, $val);
		}
	}
	return $rank;
}
function listRankSuper($current){
	$rank = '';
	foreach(rankList() as $val){
		if($val >= 80 && $val <= 100){
			$rank .= rankOption($current, $val);
		}
	}
	return $rank;
}
function listRoomStaffRank($current = 0){
	global $setting;
	$rank = '';
	foreach(roomRankList() as $val){
		if($val > 1){
			$rank .= roomRankOption($current, $val);
		}
	}
	return $rank;
}
function listRoomRank($current = 0){
	global $setting;
	$rank = '';
	foreach(roomRankList() as $val){
		if($val < 6){
			$rank .= roomRankOption($current, $val);
		}
		else if(boomAllow($setting['can_raction']) && $val <= 6){
			$rank .= roomRankOption($current, $val);
		}
	}
	return $rank;
}
function validRoomRank($r){
	if($r != 9 && validValue($r, roomRankList())){
		return true;
	}
}
function searchRank(){
	$rank = '';
	foreach(rankList() as $val){
		if($val >= 0 && $val < 100 && $val != 69){
			$rank .= rankOption(1000, $val);
		}
	}
	return $rank;
}
function changeRank($user){
	global $setting;
	$rank = '';
	if(isBot($user)){
		foreach(rankList() as $val){
			if(boomAllow($setting['can_rank']) && $val > 0 && $val <= 70){
				$rank .= rankOption($user['user_rank'], $val);
			}
			else if(boomAllow(100) && $val >= 70 && $val < 100){
				$rank .= rankOption($user['user_rank'], $val);
			}
		}
	}
	else {
		foreach(rankList() as $val){
			if(boomAllow($setting['can_rank']) && $val > 0 && $val <= 70 && $val != botRank()){
				$rank .= rankOption($user['user_rank'], $val);
			}
			else if(boomAllow(100) && $val >= 70 && $val < 100 && $val != botRank()){
				$rank .= rankOption($user['user_rank'], $val);
			}
		}
	}
	return $rank;
}

// permission functions

function canGhostUser($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_ghost'], 1) && !isStaff($user)){ 
		return true;
	}
}
function canMute(){
	global $setting;
	if(boomAllow($setting['can_mute'])){
		return true;
	}
}
function canMuteUser($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_mute'], 1)){ 
		return true;
	}
}
function canManageConsole(){
	global $setting;
	if(boomAllow($setting['can_mlogs'])){
		return true;
	}
}
function canCreateUser(){
	global $setting;
	if(boomAllow($setting['can_cuser'])){
		return true;
	}
}
function canDeleteWall($wall){
	global $setting;
	if(mySelf($wall['post_user'])){ 
		return true;
	}
	if(canDeleteContent() && isGreater($wall['user_rank'])){
		return true;
	}
}
function canDeleteWallReply($wall){
	global $setting;
	if(mySelf($wall['reply_user'])){
		return true;
	}
	if(mySelf($wall['reply_uid'])){ 
		return true;
	}
	if(canDeleteContent() && isGreater($wall['user_rank'])){
		return true;
	}
}
function canManageIp(){
	global $setting;
	if(boomAllow($setting['can_mip'])){
		return true;
	}
}
function canManageContact(){
	global $setting;
	if(boomAllow($setting['can_mcontact'])){
		return true;
	}
}
function canManageUser(){
	if(boomAllow(80)){
		return true;
	}
}
function canManagePlayer(){
	global $setting;
	if(boomAllow($setting['can_mplay'])){
		return true;
	}
}
function canManageDj(){
	global $setting;
	if(boomAllow($setting['can_dj'])){
		return true;
	}
}
function canManageHistory(){
	if(boomAllow(100)){
		return true;
	}
}
function canViewEmail($user){
	global $setting;
	if(userHaveEmail($user) && canEditUser($user, $setting['can_vemail'], 1)){
		return true;
	}
}
function canViewOther($user){
	global $setting;
	if(canEditUser($user, $setting['can_vother'], 1)){
		return true;
	}
}
function canViewName($user){
	global $setting;
	if(canEditUser($user, $setting['can_vname'], 1)){
		return true;
	}
}
function canViewIp($user){
	global $setting;
	if(canEditUser($user, $setting['can_vip'], 1)){
		return true;
	}
}
function canLookup($user){
	if(isBot($user)){
		return false;
	}
	if(canViewEmail($user) || canViewIp($user) || canViewOther($user) || canViewName($user)){
		return true;
	}
}
function canNote($user){
	global $setting;
	if(canEditUser($user, $setting['can_note'], 1)){
		return true;
	}
}
function canCritera($t){
	if(boomAllow($t)){
		return true;
	}
}
function canRoomPassword(){
	global $setting;
	if(boomAllow($setting['can_rpass']) || boomRole(6)){
		return true;
	}
}
function canAuth(){
	global $setting;
	if(boomAllow($setting['can_auth'])){
		return true;
	}
}
function canVerify(){
	global $setting;
	if(boomAllow($setting['can_verify'])){
		return true;
	}
}
function canBan(){
	global $setting;
	if(boomAllow($setting['can_ban'])){
		return true;
	}
}
function canBanUser($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_ban'], 1)){ 
		return true;
	}
}
function canManageAddons(){
	global $setting;
	if(boomAllow($setting['can_maddons'])){
		return true;
	}
}
function canRankUser($user){
	global $setting;
	if(empty($user)){
		return false;
	}
	if(isPaidVip($user) && !boomAllow(100)){
		return false;
	}
	if(isOwner($user) || isGuest($user)){
		return false;
	}
	if(canEditUser($user, $setting['can_rank'], 0)){ 
		return true;
	}
}
function canDeleteUser($user){
	global $setting;
	if(empty($user)){
		return false;
	}
	if(isOwner($user)){
		return false;
	}
	if(canEditUser($user, $setting['can_delete'], 1)){ 
		return true;
	}
}
function canWarn(){
	global $setting;
	if(boomAllow($setting['can_warn'])){
		return true;
	}
}
function canWarnUser($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_warn'], 1)){ 
		return true;
	}
}
function canKick(){
	global $setting;
	if(boomAllow($setting['can_kick'])){
		return true;
	}
}
function canKickUser($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_kick'], 1)){ 
		return true;
	}
}
function canDeleteNews($news){
	if(mySelf($news['news_poster'])){
		return true;
	}
	if(canPostNews() && isGreater($news['user_rank'])){
		return true;
	}
}
function canDeleteNewsReply($reply){
	if(mySelf($reply['reply_uid'])){
		return true;
	}
	if(canPostNews() && isGreater($reply['user_rank'])){
		return true;
	}
}
function canTopic(){
	global $setting;
	if(boomAllow($setting['can_topic']) || boomRole(6)){
		return true;
	}
}
function canManageRoom(){
	global $setting;
	if(boomAllow($setting['can_mroom'])){
		return true;
	}
}
function canColor(){
	global $setting;
	if(boomAllow($setting['allow_colors'])){
		return true;
	}
}
function canGrad(){
	global $setting;
	if(boomAllow($setting['allow_grad'])){
		return true;
	}
}
function canNeon(){
	global $setting;
	if(boomAllow($setting['allow_neon'])){
		return true;
	}
}
function canFont(){
	global $setting;
	if(useFont() && boomAllow($setting['allow_font'])){
		return true;
	}
}
function canMood(){
	global $setting;
	if(boomAllow($setting['allow_mood'])){
		return true;
	}
}
function canHistory(){
	global $setting;
	if(boomAllow($setting['allow_history'])){
		return true;
	}
}
function canTheme(){
	global $setting;
	if(boomAllow($setting['allow_theme'])){
		return true;
	}
}
function canAbout(){
	global $setting;
	if(boomAllow($setting['allow_about'])){
		return true;
	}
}
function canNameColor(){
	global $setting;
	if(boomAllow($setting['allow_name_color'])){
		return true;
	}
}
function canNameGrad(){
	global $setting;
	if(boomAllow($setting['allow_name_grad'])){
		return true;
	}
}
function canNameNeon(){
	global $setting;
	if(boomAllow($setting['allow_name_neon'])){
		return true;
	}
}
function canNameFont(){
	global $setting;
	if(useFont() && boomAllow($setting['allow_name_font'])){
		return true;
	}
}
function canInvisible(){
	global $setting;
	if(boomAllow($setting['can_inv'])){
		return true;
	}
}
function canPostNews(){
	global $setting;
	if(boomAllow($setting['can_news'])){
		return true;
	}
}
function canModifyAvatar($user){
	global $setting;
	if(!empty($user) && canAvatar() && canEditUser($user, $setting['can_modavat'])){
		return true;
	}
}
function canModifyCover($user){
	global $setting;
	if(!empty($user) && canCover() && canEditUser($user, $setting['can_modcover'])){
		return true;
	}
}
function canModifyName($user){
	global $setting;
	if(!empty($user) && canName() && canEditUser($user, $setting['can_modname'])){
		return true;
	}
}
function canModifyMood($user){
	global $setting;
	if(!empty($user) && canMood() && canEditUser($user, $setting['can_modmood'])){
		return true;
	}
}
function canModifyAbout($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_modabout'])){
		return true;
	}
}
function canModifyEmail($user){
	global $setting;
	if(!empty($user) && isMember($user) && isSecure($user) && canEditUser($user, $setting['can_modemail'], 1)){
		return true;
	}
}
function canModifyColor($user){
	global $setting;
	if(!empty($user) && canNameColor() && canEditUser($user, $setting['can_modcolor'])){
		return true;
	}
}
function canModifyPassword($user){
	global $setting;
	if(!empty($user) && isMember($user) && isSecure($user) && canEditUser($user, $setting['can_modpass'], 1)){
		return true;
	}
}
function canWhitelist($user){
	global $setting;
	if(!empty($user) && useVpn() && canEditUser($user, $setting['can_modvpn'], 1)){
		return true;
	}
}
function canBlockUser($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_modblock'], 1)){
		return true;
	}
}
function canUserHistory($user){
	global $setting;
	if(!empty($user) && canEditUser($user, $setting['can_vhistory'], 1)){
		return true;
	}
}
function canEmo(){
	global $setting;
	if(boomAllow($setting['emo_plus'])){
		return true;
	}
}
function canName(){
	global $setting;
	if(boomAllow($setting['allow_name'])){
		return true;
	}
}
function canDirect(){
	global $setting;
	if(boomAllow($setting['allow_direct'])){
		return true;
	}
}
function userCanDirect($user){
	global $setting;
	if(userBoomAllow($user, $setting['allow_direct'])){
		return true;
	}
}
function canVideo(){
	global $setting;
	if(boomAllow($setting['allow_video'])){
		return true;
	}
}
function canAudio(){
	global $setting;
	if(boomAllow($setting['allow_audio'])){
		return true;
	}
}
function canZip(){
	global $setting;
	if(boomAllow($setting['allow_zip'])){
		return true;
	}
}
function canGifCover(){
	global $setting;
	if(boomAllow($setting['allow_gcover'])){
		return true;
	}
}
function canRoom(){
	global $setting;
	if(boomAllow($setting['allow_room'])){
		return true;
	}
}
function canViewRoom(){
	global $setting;
	if(boomAllow($setting['allow_vroom'])){
		return true;
	}
}
function canAvatar(){
	global $setting, $data;
	if(boomAllow($setting['allow_avatar']) && !featureBlock($data['bupload'])){
		return true;
	}
}
function canCover(){
	global $setting, $data;
	if(boomAllow($setting['allow_cover']) && !featureBlock($data['bupload'])){
		return true;
	}
}
function canReplyNews(){
	global $setting, $data;
	if(!muted() && boomAllow($setting['allow_rnews']) && !featureBlock($data['bnews'])){
		return true;
	}
}
function canUploadChat(){
	global $setting, $data;
	if(boomAllow($setting['allow_cupload']) && !featureBlock($data['bupload'])){
		return true;
	}
}
function canUploadPrivate(){
	global $setting, $data;
	if(boomAllow($setting['allow_pupload']) && !featureBlock($data['bupload'])){
		return true;
	}
}
function canUploadWall(){
	global $setting, $data;
	if(boomAllow($setting['allow_wupload']) && !featureBlock($data['bupload'])){
		return true;
	}
}

// ranked list

function ranking($rank){
	if($rank < 4){
		return '<img src="default_images/icons/medal'.$rank.'.svg"/>';
	}
	else {
		return $rank;
	}
}

// experience functions

function useLevel(){
	global $setting;
	if($setting['use_level'] > 0){
		return true;
	}
}
function canLevel($user){
	if(!isGuest($user)){
		return true;
	}
}
function userExp($user){
	global $mysqli;
	$res = [];
	if(useLevel()){
		$get_exp = $mysqli->query("SELECT * FROM boom_exp WHERE uid = '{$user['user_id']}'");
		if($get_exp->num_rows > 0){
			$res = $get_exp->fetch_assoc();
		}
	}
	return $res;
}
function userExpDetails($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(!empty($user)){
		$get_exp = $mysqli->query("SELECT * FROM boom_exp WHERE uid = '{$user['user_id']}'");
		if($get_exp->num_rows > 0){
			return array_merge($user, $get_exp->fetch_assoc());
		}
	}
	return [];
}
function addExp($type){
	global $mysqli, $data;
	if(useLevel() && canLevel($data)){
		$exp = userExp($data);
		$add = featureExp($type);
		if(!empty($exp) && $add > 0){
			$required = requiredExp($data);
			$current = $exp['exp_current'] + $add;
			if($current >= $required){
				$mysqli->query("UPDATE boom_exp SET exp_current = " . newExp($current, $required) . ", exp_week = exp_week + $add, exp_month = exp_month + $add, exp_total = exp_total + $add WHERE uid = '{$data['user_id']}'");
				$mysqli->query("UPDATE boom_users SET user_level = user_level + 1 WHERE user_id = '{$data['user_id']}'");
				clearNotifyAction($data['user_id'], 'level');
				boomNotify('level', array('target'=> $data['user_id'], 'source'=> 'level', 'icon'=> 'level', 'custom'=> $data['user_level'] + 1));
				redisUpdateUser($data['user_id']);
			}
			else {
				$mysqli->query("UPDATE boom_exp SET exp_current = exp_current + $add, exp_week = exp_week + $add, exp_month = exp_month + $add, exp_total = exp_total + $add WHERE uid = '{$data['user_id']}'");
			}
		}
	}
}
function removeExp($type){
	global $mysqli, $data;
	if(useLevel() && canLevel($data)){
		$exp = featureExp($type);
		if($exp > 0){
			$mysqli->query("
				UPDATE boom_exp SET 
				exp_current = CASE WHEN exp_current >= $exp THEN exp_current - $exp ELSE exp_current END,
				exp_week = CASE WHEN exp_week >= $exp THEN exp_week - $exp ELSE exp_week END,
				exp_month = CASE WHEN exp_month >= $exp THEN exp_month - $exp ELSE exp_month END,
				exp_total = CASE WHEN exp_total >= $exp THEN exp_total - $exp ELSE exp_total END
				WHERE uid = '{$data['user_id']}'
			");
		}
	}
}
function newExp($current, $required){
	if($current > $required){
		$new = $current - $required;
		if($new > 20){
			return 0;
		}
		return $new;
	}
	return 0;
}
function featureExp($type){
	global $setting;
	if(isset($setting['exp_' . $type])){
		return $setting['exp_' . $type];
	}
	return 1;
}
function requiredExp($user){
	global $setting;
	return $user['user_level'] * $setting['level_mode'];
}
function userExpStatus($user){
	return round(($user['exp_current'] / requiredExp($user)) * 100,2);
}

/* custom select */

function boomSelOption($text, $icon, $class, $val = 0){
	$b = [
		'icon'=> $icon,
		'text'=> $text,
		'class'=> $class,
		'data'=> $val,
	];
	return boomTemplate('element/boom_sel_opt', $b);
}
function boomSelCurrent($text, $icon, $val = 0){
	$b = [
		'icon'=> $icon,
		'text'=> $text,
		'data'=> $val,
	];
	return boomTemplate('element/boom_sel', $b);
}

/* function badges */

function useBadge(){
	global $setting;
	if($setting['use_badge'] > 0){
		return true;
	}
}
function canBadge($user){
	if(!isGuest($user)){
		return true;
	}
}
function badgeCount($v){
	return min(100, $v);
}
function badgeTitle($t, $v){
	
}
function badgeIcon($type){
	return 'default_images/badge/' . $type . '.svg';
}
function badgeLevelIcon($v){
	if($v >= 100){
		return 'default_images/badge/numbers/100.svg';
	}
	return 'default_images/badge/numbers/' . $v . '.svg';
}
function badgeMemberIcon($v){
	return 'default_images/badge/badge_member' . $v . '.svg';
}
function renderBadgeInfo($t, $d){
	return str_replace('%data%', $d, $t);
}
function getYears($v){
    $cur = new DateTime();
    $comp = new DateTime('@' . $v);
    $diff = $cur->diff($comp);
    return $diff->y;
}

/* feature limitation */

function actLimit($a, $max = 3){
	global $mysqli, $setting, $data;
	if(isActProof()){
		return false;
	}
	$delay = calMinutes(1);
	$get_count = $mysqli->query("SELECT count(*) as count FROM boom_act WHERE  act_user = '{$data['user_id']}' AND act_name = '$a' AND act_time >= '$delay'");
	$c = $get_count->fetch_assoc();
	if($c['count'] >= $max){
		return true;
	}
	else {
		$mysqli->query("INSERT INTO boom_act (act_user, act_name, act_time) VALUES ('{$data['user_id']}', '$a',  '" . time() . "')");
		return false;
	}
}


function friendLimit(){
	return actLimit('friend', 3);
}
function goldLimit(){
	return actLimit('gold', 3);
}
function wallLimit(){
	return actLimit('wall', 3);
}
function likeLimit(){
	return actLimit('like', 3);
}
function callLimit(){
	return actLimit('call', 3);
}
function nameLimit(){
	return actLimit('gold_gift',1);
}

/* call functions */

function callDelay(){
	return 20;
}
function useCall(){
	global $setting;
	if($setting['use_call'] > 0){
		return true;
	}
}
function agoraCall(){
	global $setting;
	if($setting['use_call'] == 1){
		return true;
	}
}
function livekitCall(){
	global $setting;
	if($setting['use_call'] == 2){
		return true;
	}
}
function canCall(){
	global $setting, $data;
	if(featureBlock($data['bcall'])){
		return false;
	}
	if(boomAllow($setting['can_vcall']) || boomAllow($setting['can_acall'])){
		return true;
	}
}
function canVideoCall(){
	global $setting;
	if(boomAllow($setting['can_vcall'])){
		return true;
	}
}
function canAudioCall(){
	global $setting;
	if(boomAllow($setting['can_acall'])){
		return true;
	}
}
function callTimeout($call){
	if($call['call_time'] < time() - callDelay()){
		return true;
	}
}
function callExpired($call){
	global $setting;
	$delay = calMinutes($setting['call_max']);
	if($call['call_time'] < $delay){
		return true;
	}
}
function callActive($c){
	if($c['call_status'] > 1){
		return false;
	}
	if($c['call_status'] == 1 && $c['call_active'] < calSecond(30)){
		return false;
	}
	return true;
}
function groupCallActive($c){
	if($c['call_active'] < calSecond(30)){
		return false;
	}
	return true;
}
function canCallUser($user){
	global $data;
	if(empty($user)){
		return false;
	}
	if(mySelf($user['user_id'])){
		return false;
	}
	if(isBot($user)){
		return false;
	}
	if($user['last_action'] < getDelay()){
		return false;
	}
	if($user['user_call'] == 0){ 
		return false;
	}
	if($user['user_call'] == 2 && !haveFriendship($user)){
		return false;
	}
	if($user['user_call'] == 3 && isGuest($data)){
		return false;
	}
	if(ignored($user) || ignoring($user)){
		return false;
	}
	return true;
}
function acceptCall($call){
	global $mysqli;
	$mysqli->query("UPDATE boom_call SET call_status = '1' WHERE call_id = '{$call['call_id']}'");
}
function endCall($call, $reason){
	global $mysqli;
	$mysqli->query("UPDATE boom_call SET call_status = '2', call_reason = '$reason' WHERE call_id = '{$call['call_id']}'");
}
function endAllCall($reason){
	global $mysqli;
	$mysqli->query("UPDATE boom_call SET call_status = '2', call_reason = '$reason' WHERE call_status < 2");
}
function callDetails($id){
	global $mysqli;
	$call = [];
	$get_call = $mysqli->query("SELECT * FROM boom_call WHERE call_id = '$id'");
	if($get_call->num_rows > 0){
		$call = $get_call->fetch_assoc();
	}
	return $call;
}
function groupCallDetails($id){
	global $mysqli;
	$call = [];
	$get_call = $mysqli->query("SELECT * FROM boom_group_call WHERE call_id = '$id'");
	if($get_call->num_rows > 0){
		$call = $get_call->fetch_assoc();
	}
	return $call;
}
function incomingCallDetails(){
	global $mysqli, $data;
	$delay = time() - callDelay();
	$call = [];
	$get_call = $mysqli->query("
		SELECT boom_call.*, boom_users.* 
		FROM boom_call 
		LEFT JOIN boom_users ON boom_call.call_hunter = boom_users.user_id 
		WHERE boom_call.call_target = '{$data['user_id']}' AND boom_call.call_time >= '$delay' 
		ORDER BY boom_call.call_time DESC LIMIT 1;
	");
	if($get_call->num_rows > 0){
		$call = $get_call->fetch_assoc();
	}
	return $call;
}
function useCallBalance(){
	global $setting;
	if($setting['call_cost'] > 0 && useWallet()){
		return true;
	}
}

function canInitCall($type){
	global $setting;
	if(!canCall()){
		return false;
	}
	if($type == 1 && canVideoCall()){
		return true;
	}
	if($type == 2 && canAudioCall()){
		return true;
	}
}
function callBalance($type){
	global $setting;
	if(!useCallBalance()){
		return true;
	}
	if(walletBalance($setting['call_method'], $setting['call_cost'])){
		return true;
	}
}
function callType($t){
	global $lang;
	switch($t){
		case 1:
			return $lang['video_call'];
		case 2:
			return $lang['audio_call'];
		default:
			return 'N/A';
	}
}
function expiredCall($c){
	global $setting;
	if($c['call_date'] < calMinutes($setting['max_gcall'])){
		return true;
	}
}
function callIcon($t){
	switch($t){
		case 1:
			return 'video_call.svg';
		case 2:
			return 'audio_call.svg';
		default:
			return 'audio_call.svg';
	}
}
function setUserGroupCall($c){
	$_SESSION[BOOM_PREFIX  . 'call_time'] = 0;
	$_SESSION[BOOM_PREFIX  . 'call_id'] = $c['call_id'];
	$_SESSION[BOOM_PREFIX  . 'call_password'] = $c['call_password'];
}
function setUserCall($c){
	$_SESSION[BOOM_PREFIX  . 'call_id'] = $c['call_id'];
}
function updateUserCall(){
	global $mysqli, $setting, $data;
	if(!isset($_SESSION[BOOM_PREFIX  . 'call_time']) || $_SESSION[BOOM_PREFIX . 'call_time'] <= calMinutes(1)){
		$_SESSION[BOOM_PREFIX  . 'call_time'] = time();
		return true;
	}
}
function validGroupCall($call){
	if(isset($_SESSION[BOOM_PREFIX  . 'call_id']) && $_SESSION[BOOM_PREFIX  . 'call_id'] == $call['call_id']){
		return true;
	}	
}
function validCall($call){
	if(isset($_SESSION[BOOM_PREFIX  . 'call_id']) && $_SESSION[BOOM_PREFIX  . 'call_id'] == $call['call_id']){
		return true;
	}	
}
function canEditCall($c){
	global $setting;
	if(mySelf($c['call_creator']) || boomAllow($setting['can_mgcall'])){
		return true;
	}
}
function callBanned($id){
	global $mysqli, $data;
	if($data['ugcall'] > 0){
		if(callBlocked($id)){
			return true;
		}
		else {
			$mysqli->query("UPDATE boom_users SET ugcall = 0 WHERE user_id = '{$data['user_id']}");
			redisUpdateUser($data['user_id']);
		}
	}
}
function callBlocked($id){
	global $mysqli, $data;
	$cc = $mysqli->query("SELECT * FROM boom_call_action WHERE call_room = '$id' AND target = '{$data['user_id']}'");
	if($cc->num_rows > 0){
		return true;
	}
}
function canGroupCall(){
	global $setting;
	if(boomAllow($setting['can_gcall']) && useCall()){
		return true;
	}
}
function canCreateGroupCall(){
	global $setting;
	if(boomAllow($setting['can_cgcall']) && canGroupCall()){
		return true;
	}
}
function writeDomain($domain){
	global $setting;
	$file_path = BOOM_PATH . '/system/database.php';
	$file_content = file_get_contents($file_path);
	$updated_content = preg_replace(
		"/define\('BOOM_DOMAIN', '.*?'\);/",
		"define('BOOM_DOMAIN', '$domain');",
		$file_content
	);
	file_put_contents($file_path, $updated_content);
}
?>