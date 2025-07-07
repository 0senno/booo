<?php
if(isset($setting['redis_status']) && $setting['redis_status']){
	try{
		$redis = new Redis(); 
		$redis->connect(REDIS_IP, REDIS_PORT, REDIS_TIMEOUT);
		if(!empty(REDIS_PASS)){
			$redis->auth(REDIS_PASS);
		}
		$use_redis = 1;
	}
	catch(\RedisException $e){
		$redis = '';
		$use_redis = 0;
	}
	define('BOOM_REDIS', $use_redis);
}
else {
	$redis;
	define('BOOM_REDIS', 0);
}

// redis controllers

function redisSetElement($id, $content, $ex = 3600){
	global $redis;
	if(BOOM_REDIS){
		$redis->setex(BOOM_PREFIX . $id, $ex, $content);
	}
}
function redisGetElement($id){
	global $redis;
	if(BOOM_REDIS){
		return $redis->get(BOOM_PREFIX . $id);
	}
}
function redisSetObject($id, $content, $ex = 3600){
	global $redis;
	if(BOOM_REDIS){
		$redis->setex(BOOM_PREFIX . $id, $ex, json_encode($content));
	}
}
function redisGetObject($id){
	global $redis;
	if(BOOM_REDIS && ($cache = $redis->get(BOOM_PREFIX . $id))){
		return json_decode($cache, true);
	}
	return false;
}
function redisCacheExist($id){
	global $redis;
	if(BOOM_REDIS){
		return $redis->exists(BOOM_PREFIX . $id);
	}
}

// redis delete function

function redisDel($id){
	global $redis;
	if(BOOM_REDIS){
		$redis->del(BOOM_PREFIX . $id);
	}
}
function redisFlushAll(){
	global $redis;
	if(BOOM_REDIS){
		$redis->flushall();
	}
}

// redis main element function

function redisUpdateUser($id){
	redisDel('user:' . $id);
	redisDel('cuser:' . $id);
}
function redisUpdateChatUser($id){
	redisDel('cuser:' . $id);
}
function redisUpdateIgnore($id){
	redisDel('ignore:' . $id);
}
function redisUpdatePlayer($id){
	redisDel('player:' . $id);
}
function redisUpdateQuote($id){
	redisDel('quote:' . $id);
}
function redisUpdatePrivateQuote($id){
	redisDel('pquote:' . $id);
}
function redisUpdateLogs($id){
	//redisDel('hlog:' . $id);
}
function redisUpdateRoom($id){
	redisDel('room:' . $id);
}
function redisUpdateNotify($id){
	redisDel('cuser:' . $id);
}
function redisUpdateAddons($name){
	redisDel('addons:' . $name);
}
function redisUpdatePage($page){
	redisDel('page:' . $page);
}

// redis global function

function redisUpdatePrivate($id){
	redisUpdateChatUser($id);
}
function redisUpdateChat($id){
	redisUpdateRoom($id);
	redisUpdateLogs($id);
}
function redisInitUser($user){
	redisUpdateUser($user['user_id']);
}
function redisClearUser($id){
	redisUpdateUser($id);
}
function redisClearUserList($list){
	global $redis;
	if(BOOM_REDIS){
		foreach($list as $id){
			redisClearUser($id);
		}
	}
}
function redisUpdateRoomList($list){
	global $redis;
	if(BOOM_REDIS){
		$rooms = arrayThisList($list);
		foreach($rooms as $room){
			redisUpdateRoom($room);
		}
	}
}
function redisDeleteRoom($id, $users){
	global $mysqli, $redis;
	if(BOOM_REDIS){
		foreach($users as $user){
			redisUpdateUser($user);
		}
		redisUpdateRoom($id);
	}
}
function redisDeleteRoomList($list, $users){
	global $mysqli, $redis;
	if(BOOM_REDIS){
		foreach($users as $user){
			redisUpdateUser($user);
		}
		redisUpdateRoomList($list);
	}
}
function redisListNotify($list){
	global $redis;
	if(BOOM_REDIS){
		foreach($list as $u){
			redisUpdateNotify($u);
		}
	}
}
function redisUpdateAllNotify(){
	global $mysqli, $redis;
	if(BOOM_REDIS){
		$delay = getDelay();
		$get_list = $mysqli->query("SELECT user_id FROM boom_users WHERE last_action > '$delay'");
		if($get_list->num_rows > 0){
			while($list = $get_list->fetch_assoc()){
				redisUpdateNotify($list['user_id']);
			}
		}
	}
}
function redisUpdateStaffNotify(){
	global $mysqli, $redis;
	if(BOOM_REDIS){
		$delay = getDelay();
		$get_list = $mysqli->query("SELECT user_id FROM boom_users WHERE user_rank > '70' AND last_action > '$delay'");
		if($get_list->num_rows > 0){
			while($list = $get_list->fetch_assoc()){
				redisUpdateNotify($list['user_id']);
			}
		}
	}
}
?>