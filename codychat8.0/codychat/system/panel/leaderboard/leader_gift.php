<?php
require('../../config_session.php');
require('../../function_leaderboard.php');

if(!useGift()){ 
	die();
}
?>
<?php
ob_start();
?>
<div class="pad15">
	<div id="xp_leader_menu" class="bpad10">
		<div class="reg_menu">
			<ul>
				<li class="reg_menu_item rselected" data="gift_lead" data-z="gifttotal"><?php echo $lang['total']; ?></li>
				<li class="reg_menu_item" data="gift_lead" data-z="giftgold"><?php echo $lang['gold']; ?></li>
				<li class="reg_menu_item" data="gift_lead" data-z="giftruby"><?php echo $lang['ruby']; ?></li>
			</ul>
		</div>
	</div>
	<div id="gift_lead" class="vpad15">
		<div class="reg_zone" id="gifttotal"><?php echo getGiftLeader('count'); ?></div>
		<div class="reg_zone hide_zone" id="giftgold"><?php echo getGiftLeader('gold'); ?></div>
		<div class="reg_zone hide_zone" id="giftruby"><?php echo getGiftLeader('ruby'); ?></div>
	</div>
</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['gift_leaderboard'];
echo boomCode(1, $res);
?>