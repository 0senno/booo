<?php
require(__DIR__ . '/../config_session.php');

function staffSearchMember(){
	global $mysqli, $data, $lang;
	$target = cleanSearch(escape($_POST['search_member']));
	$list_members = '';
	if(!canManageUser()){
		return '';
	}
	if(filter_var($target, FILTER_VALIDATE_EMAIL)){
		$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE user_email = '$target' ORDER BY user_name ASC LIMIT 200");
	}
	else if(filter_var($target, FILTER_VALIDATE_IP)){
		$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE user_ip = '$target' ORDER BY user_name ASC LIMIT 200");
	}
	else {
		$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE user_name LIKE '$target%' OR user_ip LIKE '$target%' ORDER BY user_name ASC LIMIT 200");
	}
	if($getmembers->num_rows > 0){
		while($members = $getmembers->fetch_assoc()){
			$list_members .= boomTemplate('element/admin_user', $members);
		}
	}
	else {
		$list_members .= emptyZone($lang['empty']);
	}
	return '<div class="page_element">' . $list_members . '</div>';	
}

function staffMoreCritera(){
	global $mysqli, $data;
	$target = escape($_POST['more_search_critera']);
	$last = escape($_POST['last_critera'], true);
	if(!canManageUser()){
		return '';
	}
	if($target == 11 && !canViewInvisible()){
		return '';
	}
	$list_members = '';
	$critera = getCritera($target);
	$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE $critera AND user_id > '$last' ORDER BY user_id ASC LIMIT 50");
	if($getmembers->num_rows > 0){
		while($members = $getmembers->fetch_assoc()){
			$list_members .= boomTemplate('element/admin_user', $members);
		}
		return $list_members;
	}
	else {
		return 0;
	}
}

function staffSearchCritera(){
	global $mysqli, $data, $lang;
	$target = escape($_POST['search_critera']);
	if(!canManageUser()){
		return '';
	}
	if($target == 11 && !canViewInvisible()){
		return '';
	}
	$list_members = '';
	$count = 0;
	$critera = getCritera($target);
	$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE $critera ORDER BY user_id ASC LIMIT 50");
	if($getmembers->num_rows > 0){
		while($members = $getmembers->fetch_assoc()){
			$list_members .= boomTemplate('element/admin_user', $members);
		}
		$get_count = $mysqli->query("SELECT user_id FROM boom_users WHERE $critera");
		$count = $get_count->num_rows;
	}
	else {
		$list_members .= emptyZone($lang['empty']);
	}
	$list = '<div id="search_admin_list" class="page_element">' . $list_members . '</div>';
	if($count > 50){
		$list .= '<div id="search_for_more" class="page_element"><button onclick="moreAdminSearch(' . $target . ');" class="default_btn full_button reg_button">' . $lang['load_more'] . '</button></div>';
	}
	return $list;
}

function staffSearchAction(){
	global $mysqli, $data, $lang;
	$action = escape($_POST['search_action']);
	if($action == 'muted' && canMute()){
		$list = getActionList('muted');
	}
	else if($action == 'mmuted' && canMute()){
		$list = getActionList('mmuted');
	}
	else if($action == 'pmuted' && canMute()){
		$list = getActionList('pmuted');
	}
	else if($action == 'kicked' && canKick()){
		$list = getActionList('kicked');
	}
	else if($action == 'ghosted' && canGhost()){
		$list = getActionList('ghosted');
	}
	else if($action == 'banned' && canBan()){
		$list = getActionList('banned');
	}
	else {
		$list = emptyZone($lang['empty']);
	}
	return $list;
}

function searchUser(){
	global $mysqli, $data, $lang;
	
	$username = escape($_POST['query']);
	$type = escape($_POST['search_type']);
	$order = escape($_POST['search_order']);
	$online_delay = getDelay();
	$list = '';
	$user = '';
	
	switch($type) {
		case 1:
			$search_type = "user_id > 0 AND user_bot = 0";
			break;
		case 2:
			$search_type = "user_sex = 2 AND sshare = 1 AND user_bot = 0";
			break;
		case 3:
			$search_type = "user_sex = 1 AND sshare = 1 AND user_bot = 0";
			break;
		case 4:
			$search_type = "user_rank >= 70  AND user_bot = 0";
			break;
		default:
			$search_type = "";
	}
	
	switch($order) {
		case 0:
			$order = "ORDER BY rand()";
			break;
		case 1:
			$order = "ORDER BY user_join DESC";
			break;
		case 2:
			$order = "ORDER BY last_action DESC";
			break;
		case 3:
			$order = "ORDER BY user_name ASC";
			break;
		case 4:
			$order = "ORDER BY user_rank DESC";
			break;
		default:
			$order = "";
			break;
	}
	
	

	if($search_type == '' || $order == ''){
		return 'aalskjdflsad';
	}
	
	if($username != ''){
		$user = "AND user_name LIKE '%$username%'";
	}
	
	$result_array = $mysqli->query("SELECT * FROM boom_users WHERE user_rank >= 0 AND $search_type $user $order LIMIT 100");
	
	if($result_array->num_rows > 0) {
		foreach($result_array as $result) {
			$list .= createUserlist($result, true);
		}
		return $list;
	}
	else {
		return emptyZone($lang['nothing_found']);
	}
}

// end of functions

if(isset($_POST['query'], $_POST['search_type'], $_POST['search_order'])){
	echo searchUser();
}
if(isset($_POST['search_member'])){
	echo staffSearchMember();
	die();
}
if(isset($_POST['search_critera'])){
	echo staffSearchCritera();
	die();
}
if(isset($_POST['search_action'])){
	echo staffSearchAction();
	die();
}
if(isset($_POST['more_search_critera'], $_POST['last_critera'])){
	echo staffMoreCritera();
}
die();
?>