<?php
// main system ranking functions

function botRank(){
	return 69;
}
function rankList(){
	return array(0,1,50,69,70,80,90,100,999);
}
function rankIcon($rank){
	switch($rank){
		case 0:
			return 'guest.svg';
		case 1:
			return 'user.svg';
		case 50:
			return 'vip.svg';
		case 69:
			return 'bot.svg';
		case 70:
			return 'mod.svg';
		case 80:
			return 'admin.svg';
		case 90:
			return 'super.svg';
		case 100:
			return 'owner.svg';
		default:
			return 'user.svg';
	}
}
function rankTitle($rank){
	global $lang;
	switch($rank){
		case 0:
			return $lang['guest'];
		case 1:
			return $lang['user'];
		case 50:
			return $lang['vip'];
		case 69:
			return $lang['user_bot'];
		case 70:
			return $lang['mod'];
		case 80:
			return $lang['admin'];
		case 90:
			return $lang['super_admin'];
		case 100:
			return $lang['owner'];
		case 999:
			return $lang['nobody'];
		default:
			return $lang['user'];
	}
}

// room system ranking functions

function roomRankList(){
	return array(0,4,5,6,9);
}

function roomRankTitle($rank){
	global $lang;
	switch($rank){
		case 0:
			return $lang['user'];
		case 4:
			return $lang['r_mod'];
		case 5:
			return $lang['r_admin'];
		case 6:
			return $lang['r_owner'];
		case 9:
			return $lang['nobody'];
		default:
			return $lang['user'];
	}
}
function roomRankIcon($rank){
	switch($rank){
		case 4:
			return 'room_mod.svg';
		case 5:
			return 'room_admin.svg';
		case 6:
			return 'room_owner.svg';
		default:
			return 'user.svg';
	}
}

// status system functions 

function statusList(){
	return array(1,2,3,99);
}
function statusTitle($status){
	global $lang;
	switch($status){
		case 1:  
			return $lang['online'];
		case 2:  
			return $lang['away'];
		case 3:  
			return $lang['busy'];
		case 99:  
			return $lang['invisible'];
		default: 
			return $lang['online'];
	}
}
function statusIcon($status){
	switch($status){
		case 1:
			return 'online.svg';
		case 2:
			return 'away.svg';
		case 3:
			return 'busy.svg';
		case 99:
			return 'invisible.svg';
		default:
			return 'online.svg';
	}	
}
?>