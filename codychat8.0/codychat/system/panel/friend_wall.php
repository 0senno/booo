<?php
require('../config_session.php');

if(!useWall()){
	die();
}

$content = '';
$count = 0;

$find_friend = $mysqli->query("SELECT target FROM boom_friends WHERE hunter = '{$data['user_id']}' AND fstatus = '3'");
$friend_array = array($data['user_id']);
if($find_friend->num_rows > 0){
	while($add_friend = $find_friend->fetch_assoc()){
		array_push($friend_array, $add_friend['target']);
	}
}
$newarray = implode(", ", $friend_array);	
$wall_post = $mysqli->query("SELECT boom_post.*, boom_users.*,
(SELECT count( parent_id ) FROM boom_post_reply WHERE parent_id = boom_post.post_id ) as reply_count,
(SELECT like_type FROM boom_post_like WHERE uid = '{$data['user_id']}' AND like_post = boom_post.post_id) as liked,
(SELECT count( post_id ) FROM boom_post WHERE post_user IN ($newarray)) as post_count
FROM  boom_post, boom_users 
WHERE boom_post.post_user = boom_users.user_id AND boom_post.post_user IN ($newarray)
ORDER BY boom_post.post_actual DESC LIMIT 10");

if($wall_post->num_rows > 0){
	while ($wall = $wall_post->fetch_assoc()){
		$count = $wall['post_count'];
		$content .= boomTemplate('element/wall_post',$wall);
	}
}
else { 
	$content .= emptyZone($lang['wall_empty']);
}

ob_start();
?>
<div class="left_keep">
	<div class="pad20">
		<?php if(!muted()){ ?>
		<div class="bpad15">
			<button onclick="addWall();" class="theme_btn button"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
		</div>
		<?php } ?>
		<div id="container_wall">
		<?php echo $content; ?>
		</div>
		<?php if($count > 10){ ?>
		<div class="centered_element">
			<button id="data_count" onclick="moreWall(this);" class="theme_btn small_button rounded_button load_more"  data-current="10" data-total="<?php echo $count; ?>"><i class="fa fa-plus"></i> <?php echo $lang['load_more']; ?></button>
		</div>
		<?php } ?>
	</div>
</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['wall'];
echo boomCode(1, $res);
?>
