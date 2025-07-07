<?php
require('../config_chat.php');

if(isset($_POST['last'], $_POST['caction'], $_POST['fload'], $_POST['preload'], $_POST['priv'], $_POST['lastp'], $_POST['pcount'], $_POST['room'], $_POST['notify'], $_POST['curset'])){
	
	$last = escape($_POST['last'], true);
	$fload = escape($_POST['fload'], true);
	$caction = escape($_POST['caction'], true);
	$preload = escape($_POST['preload'], true);
	$priv = escape($_POST['priv'], true);
	$lastp = escape($_POST['lastp'], true);
	$pcount = escape($_POST['pcount'], true);
	$croom = escape($_POST['room'], true);
	$notify = escape($_POST['notify'], true);
	$curset = escape($_POST['curset'], true);
	
	if($croom != $data['user_roomid']){
		echo json_encode( array("check" => 188, "act" => $data['user_action']));
		die();
	}
	
	$d['mlogs'] = [];
	$d['plogs'] = [];
	$d['pcount'] = $pcount;
	$cpriv = 1;
	
	// heartbeat && gold
	if(time() > $data['last_action'] + 60){
		$ip = getIp();
		$gold_update = '';
		$ruby_update = '';
		if(useWallet()){
			if(canGoldReward()){
				$gold_update = ",user_gold = user_gold + {$setting['gold_base']}, last_gold = '" . time() . "'";
			}
			if(canRubyReward()){
				$ruby_update = ",user_ruby = user_ruby + {$setting['ruby_base']}, last_ruby = '" . time() . "'";
			}
		}
		$mysqli->query("UPDATE boom_users SET last_action = '" . time() . "', user_beat = user_beat + 1, user_ip = '$ip' $gold_update $ruby_update WHERE user_id = '{$data['user_id']}'");
		redisUpdateUser($data['user_id']);
	}
	if(useWallet()){
		$d['gold'] = (int) $data['user_gold'];
		$d['ruby'] = (int) $data['user_ruby'];
	}
	
	// notification
	if($notify < $data['naction']){
		$d['notify'] = getNotification();
	}

	// main chat logs part
	if($fload == 0){
		$d['rdata'] = createRoomData($room);
	}
	else if($caction != $room['rcaction']){
		$d['mlogs'] = getChatLogs($data['user_roomid'], $last);
	}
	
	// delete log
	if(!empty($room['rldelete']) && !delExpired($room['rltime'])){
		$d['del'] = $room['rldelete'];
	}
	
	// private chat logs part
	if(!canPrivate()){
		$cpriv = 0;
	}
	if($priv > 0 && $cpriv > 0){
		if($preload == 1){
			$d['pload'] = getPrivateHistory($priv);
		}
		else if($pcount != $data['pcount']){
			$d['plogs'] = getPrivateLogs($priv, $lastp);
		}
		if(!empty($data['pdel']) && !delExpired($data['pdeltime'])){
			$d['pdel'] = $data['pdel'];
		}
	}
	
	// room access
	if(canEditRoom()){
		$d['rset'] = 1;
	}
	
	// room ranking
	if(haveRole($data['user_role'])){
		$d['role'] = $data['user_role'];
	}
	
	// mute check
	$d['rm'] = checkMute($data);
	
	// private count
	if($data['private_count'] > 0){
		$d['pico'] = $data['private_count'];
	}
	
	if($setting['curset'] > $curset){
		$d['curset'] = reloadSettings();
	}
	
	// warning
	if(isWarned($data)){
		$d['warn'] = $data['warn_msg'];
	}

	mysqli_close($mysqli);
	
	// output
	if($cpriv > 0){
		$d['pcount'] = (int) $data['pcount'];
	}

	$d['cact'] = (int) $room['rcaction'];
	$d['act'] = (int) $data['user_action'];
	$d['curp'] = (int) $priv;
	$d['spd'] = (int)$setting['speed'];
	$d['acd'] = (int) $setting['act_delay'];
	$d['pmin'] = (int) $setting['allow_private'];
	$d['call'] = (int) $data['ucall'];
	
	echo json_encode($d, JSON_UNESCAPED_UNICODE);
}
?>