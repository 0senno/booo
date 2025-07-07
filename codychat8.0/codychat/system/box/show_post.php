<?php
require('../config_session.php');

if(!isset($_POST['post_id'], $_POST['show_this_post'])){
	echo 0;
	die();
}
$postid = escape($_POST["post_id"], true);
if(!canPostAction($postid)){
	echo 0;
	die();
}
ob_start();
?>
<div class="left_keep pad20">
	<?php echo showWallPost($postid); ?>
</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['wall'];
echo boomCode(1, $res);
?>