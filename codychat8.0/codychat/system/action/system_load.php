<?php
require(__DIR__ . '/../config_admin.php');

session_write_close();

$curpage = escape($_POST['cp']);

$d = [];

function boomGeo(){
	global $mysqli, $data;
	if(checkGeo()){
		require BOOM_PATH . '/system/location/country_list.php';
		require BOOM_PATH . '/system/location/timezone.php';
		$ip = getIp();
		$country = 'ZZ';
		$tzone = $data['user_timezone'];
		$loc = doCurl('http://www.geoplugin.net/php.gp?ip=' . $ip);
		$res = unserialize($loc);
		if(isset($res['geoplugin_countryCode']) && array_key_exists($res['geoplugin_countryCode'], $country_list)){
			$country = escape($res['geoplugin_countryCode']);
		}
		if(isset($res['geoplugin_timezone']) && in_array($res['geoplugin_timezone'], $timezone)){
			$tzone = escape($res['geoplugin_timezone']);
		}
		$mysqli->query("UPDATE boom_users SET user_ip = '$ip', country = '$country', user_timezone = '$tzone' WHERE user_id = '{$data['user_id']}'");
		redisUpdateUser($data['user_id']);
		return 1;
	}
	else {
		return 0;
	}
}

function checkRegmute(){
	global $data;
	$r = [];
	if(isRegmuted($data)){
		$r = createModal(boomTemplate('element/regmute'), 'empty', 400);
	}
	return $r;
}

$d['geo'] = boomGeo();

if($curpage == 'chat'){
	$d['modal'] = [];
	$reg = checkRegmute();
	array_push($d['modal'], $reg);
}

echo json_encode($d, JSON_UNESCAPED_UNICODE);
die();
?>