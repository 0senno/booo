<?php
require('../../config_session.php');
require('../../function_leaderboard.php');

if(!useWallet()){ 
	die();
}
?>
<?php
ob_start();
?>
<div class="pad15">
	<div id="gold_leaderboard_content">
		<?php echo getGoldLeader('user_gold'); ?>
	</div>
</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['gold_leaderboard'];
echo boomCode(1, $res);
?>