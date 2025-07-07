<?php
require('../../config_session.php');
require('../../function_leaderboard.php');

if(!useLevel()){ 
	die();
}
?>
<?php
ob_start();
?>
<div class="pad15">
	<div id="level_leaderboard_content">
		<?php echo getLevelLeader(); ?>
	</div>
	</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['level_leaderboard'];
echo boomCode(1, $res);
?>