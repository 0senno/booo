<?php
require(__DIR__ . '/../config_session.php');

if(!useWall()){
	die();
}

function userMoreWall(){
	global $mysqli, $data;
	
	$of = escape($_POST["offset"], true);
	
	$wall_content = '';
	$find_friend = $mysqli->query("SELECT target FROM boom_friends WHERE hunter = '{$data['user_id']}' AND fstatus = '3'");
	$friend_array = array($data['user_id']);
	if($find_friend->num_rows > 0){
		while($add_friend = $find_friend->fetch_assoc()){
			array_push($friend_array, $add_friend['target']);
		}
	}
	$newarray = implode(", ", $friend_array);	
	$wall_post = $mysqli->query("
		SELECT boom_post.*, boom_users.*,
		(SELECT count( parent_id ) FROM boom_post_reply WHERE parent_id = boom_post.post_id ) as reply_count,
		(SELECT like_type FROM boom_post_like WHERE uid = '{$data['user_id']}' AND like_post = boom_post.post_id) as liked
		FROM  boom_post, boom_users 
		WHERE boom_post.post_user = boom_users.user_id AND boom_post.post_user IN ($newarray)
		ORDER BY boom_post.post_actual DESC LIMIT 10 OFFSET $of
	");
	
	if($wall_post->num_rows > 0){
		while ($wall = $wall_post->fetch_assoc()){
			$wall_content .= boomTemplate('element/wall_post',$wall);
		}
	}
	else { 
		$wall_content .= 0;
	}
	return $wall_content;
}
function userPostLike(){
	global $mysqli, $setting, $data;
	
	$id = escape($_POST["like"], true);
	$type = escape($_POST["like_type"], true);
	
	if(!boomAllow(1)){
		return '';
	}

	if(!canPostAction($id)){
		return boomCode(0);
	}
	$like_result = $mysqli->query("SELECT post_user, post_like, (SELECT like_type FROM boom_post_like WHERE like_post = '$id' AND uid = '{$data['user_id']}') AS type FROM boom_post WHERE post_id = '$id'");
	if($like_result->num_rows > 0){
		$like = $like_result->fetch_assoc();
		
		if(!allowWallLikes($like)){
			return boomCode(0);
		}

		$mysqli->query("DELETE FROM boom_post_like WHERE like_post = '$id' AND uid = '{$data['user_id']}'");
		$mysqli->query("DELETE FROM boom_notification WHERE notifier = '{$data['user_id']}' AND notify_id = '$id' AND notify_type = 'like'");
		
		if($like['type'] == $type) {
			updateNotify($like['post_user']); 
			return boomCode(1, array('data'=> getLikes($id, 0, 'wall')));
		}
		else {
			$mysqli->query("INSERT INTO boom_post_like ( uid, liked_uid, like_type, like_post, like_date) VALUE ('{$data['user_id']}', '{$like['post_user']}', $type, '$id', '" . time() . "')");
			if(!mySelf($like['post_user'])){
				boomNotify('like', array('hunter'=> $data['user_id'], 'target'=> $like['post_user'], 'source'=> 'post', 'sourceid'=> $id, 'custom'=> $type, 'icon'=> 'preact', 'class'=> 'show_post', 'data'=> $id));
			}
			return boomCode(1, array('data'=> getLikes($id, $type, 'wall')));
		}
	}
	else {
		return boomCode(0);
	}
}
function userLoadComment(){
	global $mysqli, $data, $lang;
	
	$id = escape($_POST["id"], true);
	
	if(!boomAllow(1)){
		return '';
	}
	if(!canPostAction($id)){
		return boomCode(0, array("reply" => 0, "more"=> ''));
	}
	$load_reply = '';
	$reply_count = 0;
	$find_reply = $mysqli->query("
	SELECT boom_post_reply.*, boom_users.*,
	(SELECT count(reply_id) FROM boom_post_reply WHERE parent_id = '$id' ) as reply_count
	FROM  boom_post_reply, boom_users 
	WHERE boom_post_reply.parent_id = '$id' AND boom_post_reply.reply_user = boom_users.user_id 
	ORDER BY boom_post_reply.reply_id DESC LIMIT 10
	");
	if($find_reply->num_rows > 0){
		while($reply = $find_reply->fetch_assoc()){
			$load_reply .= boomTemplate('element/wall_reply', $reply);
			$reply_count = $reply['reply_count'];
		}
	}
	if($reply_count > 10){
		$more = '<a onclick="moreComment(this,' . $id . ')" class="theme_color text_small more_comment">' . $lang['view_more_comment'] . '</a>';
	}
	else {
		$more = 0;
	}
	return boomCode(1, array("reply" => $load_reply, "more"=> $more));
}
function userLoadReply(){
	global $mysqli, $data, $lang;
	
	$id = escape($_POST["id"], true);
	$offset = escape($_POST["current"], true);

	if(!boomAllow(1)){
		return '';
	}
	if(!canPostAction($id)){
		return 99;
	}
	$reply_comment = '';
	$find_reply = $mysqli->query("
	SELECT boom_post_reply.*, boom_users.*
	FROM  boom_post_reply, boom_users 
	WHERE boom_post_reply.parent_id = '$id' AND boom_post_reply.reply_id < '$offset' AND boom_post_reply.reply_user = boom_users.user_id 
	ORDER BY boom_post_reply.reply_id DESC LIMIT 20
	");
	if($find_reply->num_rows > 0){
		while($reply = $find_reply->fetch_assoc()){
			$reply_comment .= boomTemplate('element/wall_reply', $reply);
		}
	}
	else {
		$reply_comment = 0;
	}
	return $reply_comment;
}
function deleteReply(){
	global $mysqli, $data, $lang;
	
	$reply_id = escape($_POST['delete_reply'], true);
	
	$reply_info = $mysqli->query("
	SELECT boom_post_reply.*, boom_users.* 
	FROM boom_post_reply, boom_users 
	WHERE boom_post_reply.reply_id = '$reply_id' AND boom_users.user_id = boom_post_reply.reply_user
	");
	if($reply_info->num_rows == 1){
		$reply = $reply_info->fetch_assoc();
		if(canDeleteWallReply($reply)){
			$mysqli->query("DELETE FROM boom_post_reply WHERE reply_id = '$reply_id'");
			$mysqli->query("DELETE FROM boom_notification WHERE notifier = '{$reply['reply_user']}' AND notify_id = '{$reply['parent_id']}' AND notify_custom = '$reply_id'");
			updateNotify($reply['reply_uid']);
			if(!mySelf($reply['user_id'])){
				boomConsole('cwall_delete', array('hunter'=> $data['user_id'], 'target'=> $reply['user_id']));
			}
			$total = wallReplyCount($reply['parent_id']);
			return boomCode(1, array('wall'=> $reply['parent_id'], 'reply'=> $reply_id, 'total'=> $total));
		}
		else {
			return boomCode(0);
		}
	}
	else {
		return boomCode(0);
	}
}
function userDeleteWall(){
	global $mysqli, $data, $lang;
	
	$post = escape($_POST["delete_wall_post"], true);

	$valid = $mysqli->query("
	SELECT boom_post.*, boom_users.* 
	FROM boom_post, boom_users 
	WHERE boom_post.post_id = '$post' AND boom_users.user_id = boom_post.post_user
	");
	if($valid->num_rows > 0){
		$wall = $valid->fetch_assoc();
		if(!canDeleteWall($wall)){
			return 1;
		}
		$mysqli->query("DELETE FROM boom_post WHERE post_id = '$post'");
		$mysqli->query("DELETE FROM boom_post_reply WHERE parent_id = '$post'");
		$mysqli->query("DELETE FROM boom_notification WHERE notify_id = '$post' AND notify_source = 'post'");
		$mysqli->query("DELETE FROM boom_post_like WHERE like_post = '$post'");
		$mysqli->query("DELETE FROM boom_report WHERE report_post = '$post' AND report_type = 2");
		if($mysqli->affected_rows > 0){
			updateStaffNotify();
		}
		removeRelatedFile($post, 'wall');
		$list = getActiveFriendList($wall['user_id'], 1);
		updateListNotify($list);
		if(!mySelf($wall['user_id'])){
			boomConsole('wall_delete', array('hunter'=> $data['user_id'], 'target'=> $wall['user_id']));
		}
		else {
			removeExp('post');
		}
		return 'boom_post' . $post;
	}
	else {
		return 1;
	}
}
function saveWallOptions(){
	global $mysqli, $setting, $data;
	
	$id = escape($_POST['post_id'], true);
	$comment = escape($_POST['post_comment'], true);
	$like = escape($_POST['post_like'], true);
	
	$wall = wallDetails($id);
	if(empty($wall)){
		return boomCode(0);
	}
	if(!mySelf($wall['post_user'])){
		return boomCode(0);
	}
	
	$val = array(0,1);
	if(!validValue($comment, $val) || !validValue($like, $val)){
		return boomCode(0);
	}
	
	$mysqli->query("UPDATE boom_post SET post_comment = '$comment', post_like = '$like' WHERE post_id = '$id'");
	return boomCode(1, array('data'=> showWallPost($id))); 
}
function userPostWall(){
	global $mysqli, $setting, $data;
	
	if(postBlocked() || !useWall()){
		return '';
	}
	
	if(!boomAllow(1)){
		return '';
	}

	$content = clearBreak($_POST['post_to_wall']);
	$content = escape($content);
	$post_file = escape($_POST['post_file']);
	$comment = escape($_POST['comment'], true);
	$like = escape($_POST['like'], true);
	
	$file_content = '';
	$file_type = '';
	$file_ok = 0;
	
	if(wallLimit()){
		return 4;
	}

	$content = wordFilter($content);
	if(empty($content) && empty($post_file)){
		return 0;
	}
	if($post_file != ''){
		$get_file = $mysqli->query("SELECT * FROM boom_upload WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}' AND file_complete = '0'");
		if($get_file->num_rows > 0){
			$file = $get_file->fetch_assoc();
			$file_content = 'upload/wall/' . $file['file_name'];
			$file_type = $file['file_type'];
			$file_ok = 1;
		}
		else {
			if($content == ''){
				return 0;
			}
		}
	}
	if(strlen($content) < 2000){
		$mysqli->query("INSERT INTO boom_post (post_comment, post_like,  post_date, post_user, post_content, post_file, post_file_type, post_actual) VALUES ('$comment', '$like', '" . time() . "', '{$data['user_id']}', '$content', '$file_content', '$file_type', '" . time() . "' )");
		$postid = $mysqli->insert_id;
		if($file_ok == 1){
			$mysqli->query("UPDATE boom_upload SET file_complete = '1', relative_post = '$postid' WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}'");			
		}
		$list = getActiveFriendList($data['user_id']);
		boomListNotify($list, 'add_post', array('hunter'=> $data['user_id'], 'source'=> 'post', 'sourceid'=> $postid, 'icon'=> 'post', 'class'=> 'show_post', 'data'=> $postid));
		addExp('post');
		return showWallPost($postid);
	}
	else {
		return 2;
	}
}

function userWallReply(){
	global $mysqli, $data;
	
	if(postBlocked() || !useWall()){
		return '';
	}
	
	$content = escape($_POST["content"]);
	$reply_to = escape($_POST["reply_to_wall"], true);
	
	if(wallLimit()){
		return boomCode(4);
	}
	
	if(!boomAllow(1)){
		return '';
	}

	$content = wordFilter($content);
	if(strlen($content) >= 1001){
		return boomCode(0);
	}
	if(!canPostAction($reply_to)){
		return boomCode(0);
	}
	$wall = wallDetails($reply_to);
	if(empty($wall)){
		return boomCode(0);
	}
	if(!allowWallComment($wall)){
		return boomCode(0);
	}
	
	$id = $wall['post_id'];
	$who = $wall['post_user'];
	$mysqli->query("INSERT INTO boom_post_reply (parent_id, reply_uid, reply_date, reply_user, reply_content) VALUES ('$id', '$who', '" . time() . "', '{$data['user_id']}', '$content')");
	$last_id = $mysqli->insert_id;
	$mysqli->query("UPDATE boom_post SET post_actual = '" . time() . "' WHERE post_id = '$id'");
	if(!mySelf($who)){
		boomNotify('reply', array('hunter'=> $data['user_id'], 'target'=> $who, 'source'=> 'post', 'sourceid'=> $reply_to, 'custom'=> $last_id, 'icon'=> 'reply', 'class'=> 'show_post', 'data'=> $reply_to));
	}
	$get_back = $mysqli->query("
		SELECT boom_post_reply.*, boom_users.* 
		FROM boom_post_reply, boom_users
		WHERE boom_post_reply.parent_id = '$reply_to' AND boom_post_reply.reply_user = '{$data['user_id']}' AND boom_users.user_id = '{$data['user_id']}' 
		ORDER BY reply_id DESC LIMIT 1
	");
	if($get_back->num_rows < 1){
		return boomCode(0);
	}
	$reply = $get_back->fetch_assoc();
	$log = boomTemplate('element/wall_reply', $reply);
	$total = wallReplyCount($reply_to);
	return boomCode(1, array('data'=> $log, 'total'=> $total));
}

// end of functions

if(isset($_POST['post_to_wall'], $_POST['post_file'], $_POST['comment'], $_POST['like'])){
	echo userPostWall();
	die();
}
if(isset($_POST['content']) && isset($_POST['reply_to_wall'])){
	echo userWallReply();
	die();
}
if (isset($_POST['offset'], $_POST['load_more'], $_POST['load_more_wall'])){
	echo userMoreWall();
	die();
}
if(isset($_POST['like'], $_POST['like_type'])){
	echo userPostLike();
	die();
}
if(isset($_POST['delete_reply'])){
	echo deleteReply();
	die();
}
if(isset($_POST['id'], $_POST['load_comment'])){
	echo userLoadComment();
	die();
}
if(isset($_POST['current'], $_POST['id'], $_POST['load_reply'])){
	echo userLoadReply();
	die();
}
if(isset($_POST['delete_wall_post'])){
	echo userDeleteWall();
	die();
}
if(isset($_POST['view_likes'])){
	echo viewWallLikes();
	die();
}
if(isset($_POST['post_id'], $_POST['post_comment'], $_POST['post_like'])){
	echo saveWallOptions();
	die();
}
die();
?>