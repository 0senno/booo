<?php
require('../config_session.php');
require('../function_leaderboard.php');

if(!useLevel()){ 
	die();
}
?>

<?php
ob_start();
?>
<div class="pad15 rtl_elem">
	<div class="bpad20">
		<div class="boom_sel_container">
			<div id="leader_selection" class="boom_sel fborder brad10" data="">
				<?php echo boomSelCurrent($lang['xp_leaderboard'], xpIcon()); ?>
			</div>
			<div class="boom_opt_container fborder brad10 back_menu bshadow">
				<?php
				echo boomSelOption($lang['xp_leaderboard'], xpIcon(), 'get_leader_data', 'leader_xp');
				echo boomSelOption($lang['level_leaderboard'], levelIcon(), 'get_leader_data', 'leader_level');
				if(useGift()){
					echo boomSelOption($lang['gift_leaderboard'], giftIcon(), 'get_leader_data', 'leader_gift');
				}
				if(useLike()){
					echo boomSelOption($lang['like_leaderboard'], likeIcon(), 'get_leader_data', 'leader_like');
				}
				?>
			</div>
		</div>
	</div>
	<div id="leaderboard_container">
		<div id="xp_leader_menu" class="bpad10">
			<div class="reg_menu">
				<ul>
					<li class="reg_menu_item rselected" data="xp_lead" data-z="topweek"><?php echo $lang['top_week']; ?></li>
					<li class="reg_menu_item" data="xp_lead" data-z="topmonth"><?php echo $lang['top_month']; ?></li>
					<li class="reg_menu_item" data="xp_lead" data-z="topall"><?php echo $lang['top_all']; ?></li>
				</ul>
			</div>
		</div>
		<div id="xp_lead" class="vpad15">
			<div class="reg_zone" id="topweek"><?php echo getXpLeader('exp_week'); ?></div>
			<div class="reg_zone hide_zone" id="topmonth"><?php echo getXpLeader('exp_month'); ?></div>
			<div class="reg_zone hide_zone" id="topall"><?php echo getXpLeader('exp_total'); ?></div>
		</div>
	</div>
</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['leaderboard'];
echo boomCode(1, $res);
?>