<?php
require('../../config_session.php');
require('../../function_leaderboard.php');

if(!useLike()){ 
	die();
}
?>
<?php
ob_start();
?>
<div class="pad15">
	<div id="like_leaderboard_content">
		<?php echo getLikeLeader(); ?>
	</div>
	</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['like_leaderboard'];
echo boomCode(1, $res);
?>