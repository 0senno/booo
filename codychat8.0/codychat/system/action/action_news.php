<?php
require(__DIR__ . '/../config_session.php');

function moreNews(){
	global $mysqli, $data;
	
	$news = escape($_POST['more_news'], true);
	
	$news_content = '';	
	
	$get_news = $mysqli->query("SELECT boom_news.*, boom_users.*,
	(SELECT count(id) FROM boom_news) as news_count,
	(SELECT count( parent_id ) FROM boom_news_reply WHERE parent_id = boom_news.id ) as reply_count,
	(SELECT like_type FROM boom_news_like WHERE uid = '{$data['user_id']}' AND like_post = boom_news.id) as liked
	FROM boom_news, boom_users
	WHERE boom_news.id < '$news' AND boom_news.news_poster = boom_users.user_id 
	ORDER BY news_date DESC LIMIT 10");

	
	if($get_news->num_rows > 0){
		while ($news = $get_news->fetch_assoc()){
			$news_content .= boomTemplate('element/news',$news);
		}
	}
	else { 
		$news_content .= 0;
	}
	return $news_content;
}
function loadNewsComment(){
	global $mysqli, $data, $lang;
	
	$id = escape($_POST["id"], true);
	
	$load_reply = '';
	$reply_count = 0;
	$find_reply = $mysqli->query("SELECT boom_news_reply.*, boom_users.*,
	(SELECT count(reply_id) FROM boom_news_reply WHERE parent_id = '$id' ) as reply_count
	FROM  boom_news_reply, boom_users WHERE boom_news_reply.parent_id = '$id' AND boom_news_reply.reply_user = boom_users.user_id ORDER BY boom_news_reply.reply_id DESC LIMIT 10");
	if($find_reply->num_rows > 0){
		while($reply = $find_reply->fetch_assoc()){
			$load_reply .= boomTemplate('element/news_reply', $reply);
			$reply_count = $reply['reply_count'];
		}
	}
	if($reply_count > 10){
		$more = '<a onclick="moreNewsComment(this,' . $id . ')" class="theme_color text_small more_comment">' . $lang['view_more_comment'] . '</a>';
	}
	else {
		$more = 0;
	}
	return boomCode(1, array("reply" => $load_reply, "more"=> $more));
}
function moreNewsComment(){
	global $mysqli, $data, $lang;

	$id = escape($_POST["id"], true);
	$offset = escape($_POST["current"], true);
	
	$reply_comment = '';
	$find_reply = $mysqli->query("SELECT boom_news_reply.*, boom_users.*
	FROM  boom_news_reply, boom_users WHERE boom_news_reply.parent_id = '$id' AND boom_news_reply.reply_id < '$offset' AND boom_news_reply.reply_user = boom_users.user_id ORDER BY boom_news_reply.reply_id DESC LIMIT 20");
	if($find_reply->num_rows > 0){
		while($reply = $find_reply->fetch_assoc()){
			$reply_comment .= boomTemplate('element/news_reply', $reply);
		}
	}
	else {
		$reply_comment = 0;
	}
	return $reply_comment;
}
function deleteNewsReply(){
	global $mysqli, $data, $lang;
	
	$reply_id = escape($_POST['delete_news_reply'], true);
	
	$reply_info = $mysqli->query("
	SELECT boom_news_reply.*, boom_users.*
	FROM boom_news_reply, boom_users 
	WHERE boom_news_reply.reply_id = '$reply_id' AND boom_users.user_id = boom_news_reply.reply_user
	");
	if($reply_info->num_rows == 1){
		$reply = $reply_info->fetch_assoc();
		if(!canDeleteNewsReply($reply)){
			return boomCode(0);
		}
		$mysqli->query("DELETE FROM boom_news_reply WHERE reply_id = '$reply_id'");
		$total = newsReplyCount($reply['parent_id']);
		return boomCode(1, array('news'=> $reply['parent_id'], 'reply'=> $reply_id, 'total'=> $total));
		if(!mySelf($reply['user_id'])){
			boomConsole('cnews_delete', array('hunter'=> $data['user_id'], 'target'=> $reply['user_id']));
		}
	}
	else {
		return boomCode(0);
	}
}
function deleteNews(){
	global $mysqli, $data, $lang;
	$news = escape($_POST['remove_news'], true);
	$valid = $mysqli->query("
	SELECT boom_news.*, boom_users.* 
	FROM boom_news, boom_users 
	WHERE boom_news.id = '$news' AND boom_users.user_id = boom_news.news_poster
	");
	if($valid->num_rows > 0){
		$tnews = $valid->fetch_assoc();
		if(!canDeleteNews($tnews)){
			return 1;
		}
		$mysqli->query("DELETE FROM boom_news WHERE id = '$news'");
		$mysqli->query("DELETE FROM boom_news_reply WHERE parent_id = '$news'");
		$mysqli->query("DELETE FROM boom_news_like WHERE like_post = '$news'");
		removeRelatedFile($news, 'news');
		updateAllNotify();
		if(!mySelf($tnews['user_id'])){
			boomConsole('news_delete', array('hunter'=> $data['user_id'], 'target'=> $tnews['user_id']));
		}
		return 'boom_news' . $news;
	}
	else {
		return 1;
	}
}
function newsLike(){
	global $mysqli, $data;
	
	if(!boomAllow(1)){
		return '';
	}
	$id = escape($_POST["like_news"], true);
	$type = escape($_POST["like_type"], true);

	$like_result = $mysqli->query("SELECT news_poster, news_like, (SELECT like_type FROM boom_news_like WHERE like_post = '$id' AND uid = '{$data['user_id']}') AS type FROM boom_news WHERE id = '$id'");
	if($like_result->num_rows > 0){
		$like = $like_result->fetch_assoc();
		
		if(!allowNewsLikes($like)){
			return boomCode(0);
		}
		
		$mysqli->query("DELETE FROM boom_news_like WHERE like_post = '$id' AND uid = '{$data['user_id']}'");
		
		if($like['type'] == $type) {
			return boomCode(1, array('data'=> getLikes($id, 0, 'news')));
		}
		else {
			$mysqli->query("INSERT INTO boom_news_like ( uid, liked_uid, like_type, like_post, like_date) VALUE ('{$data['user_id']}', '{$like['news_poster']}', $type, '$id', '" . time() . "')");
			return boomCode(1, array('data'=> getLikes($id, $type, 'news')));
		}
	}
	else {
		return boomCode(0);
	}
}
function newsReply(){
	global $mysqli, $data;
	
	if(postBlocked()){
		return;
	}
	
	if(wallLimit()){
		return boomCode(4);
	}
	
	$content = escape($_POST["content"]);
	$reply_to = escape($_POST["reply_news"], true);
	
	if(!canReplyNews()){
		return '';
	}
	
	$content = wordFilter($content);
	if(strlen($content) >= 1001){
		return boomCode(0);
	}
	$news = newsDetails($reply_to);
	if(empty($news)){
		return boomCode(0);
	}
	if(!allowNewsComment($news)){
		return boomCode(0);
	}
	$mysqli->query("INSERT INTO boom_news_reply (parent_id, reply_date, reply_user, reply_content, reply_uid) VALUES ('{$news['id']}', '" . time() . "', '{$data['user_id']}', '$content', '{$news['news_poster']}')");
	$last_id = $mysqli->insert_id;

	$get_back = $mysqli->query("
		SELECT boom_news_reply.*, boom_users.* 
		FROM boom_news_reply, boom_users
		WHERE boom_news_reply.parent_id = '$reply_to' AND boom_news_reply.reply_user = '{$data['user_id']}' AND boom_users.user_id = '{$data['user_id']}' 
		ORDER BY reply_id DESC LIMIT 1
	");
	if($get_back->num_rows < 1){
		return boomCode(0);
	}
	$reply = $get_back->fetch_assoc();
	$log = boomTemplate('element/news_reply', $reply);
	$total = newsReplyCount($reply_to);
	return boomCode(1, array('data'=> $log, 'total'=> $total));
}
function saveNewsOptions(){
	global $mysqli, $setting, $data;
	
	$id = escape($_POST['news_id'], true);
	$comment = escape($_POST['news_comment'], true);
	$like = escape($_POST['news_like'], true);
	
	$news = newsDetails($id);
	if(empty($news)){
		return boomCode(0);
	}
	if(!mySelf($news['news_poster'])){
		return boomCode(0);
	}
	
	$val = array(0,1);
	if(!validValue($comment, $val) || !validValue($like, $val)){
		return boomCode(0);
	}
	
	$mysqli->query("UPDATE boom_news SET news_comment = '$comment', news_like = '$like' WHERE id = '$id'");
	return boomCode(1, array('data'=> showNewsPost($id))); 
}
function postSystemNews(){
	global $mysqli, $setting, $data;
	
	if(postBlocked()){
		return 0;
	}
	
	$news = clearBreak($_POST['add_news']);
	$news = escape($news);
	$post_file = escape($_POST['post_file']);
	$comment = escape($_POST['comment'], true);
	$like = escape($_POST['like'], true);
	
	$news_file = '';
	$file_type = '';
	$file_ok = 0;

	if(!canPostNews()){
		return 0;
	}
	
	$news = trimContent($news);
	
	if(empty($news) && empty($post_file)){
		return 0;
	}
	if($post_file != ''){
		$get_file = $mysqli->query("SELECT * FROM boom_upload WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}' AND file_complete = '0'");
		if($get_file->num_rows > 0){
			$file = $get_file->fetch_assoc();
			$news_file = 'upload/news/' . $file['file_name'];
			$file_type = $file['file_type']; 
			$file_ok = 1;
		}
		else {
			if($news == ''){
				return 0;
			}
		}
	}
	$mysqli->query("UPDATE boom_users SET user_news = '" . time() . "' WHERE user_id = '{$data['user_id']}'");
	$mysqli->query("INSERT INTO boom_news ( news_comment, news_like, news_poster, news_message, news_file, news_file_type, news_date ) VALUE ('$comment', '$like', '{$data['user_id']}', '$news', '$news_file', '$file_type', '" . time() . "')");
	$news_id = $mysqli->insert_id;
	if($file_ok == 1){
		$mysqli->query("UPDATE boom_upload SET file_complete = '1', relative_post = '$news_id' WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}'");			
	}
	addExp('post');
	updateAllNotify();
	return showNewsPost($news_id);
}

// end of functions

if(isset($_POST['add_news'], $_POST['post_file'], $_POST['comment'], $_POST['like'])){
	echo postSystemNews();
	die();
}
if(isset($_POST['content']) && isset($_POST['reply_news'])){
	echo newsReply();
	die();
}
if(isset($_POST['like_news'], $_POST['like_type'])){
	echo newsLike();
	die();
}
if(isset($_POST['more_news'])){
	echo moreNews();
	die();
}
if(isset($_POST['id'], $_POST['load_news_comment'])){
	echo loadNewsComment();
	die();
}
if(isset($_POST['current'], $_POST['id'], $_POST['load_news_reply'])){
	echo moreNewsComment();
	die();
}
if(isset($_POST['delete_news_reply'])){
	echo deleteNewsReply();
	die();
}
if(isset($_POST['remove_news'])){
	echo deleteNews();
	die();
}
if(isset($_POST['news_id'], $_POST['news_comment'], $_POST['news_like'])){
	echo saveNewsOptions();
	die();
}
die();
?>