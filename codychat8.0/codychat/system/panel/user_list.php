<?php
require('../config_session.php');

$check_action = getDelay();
$online_delay = time() - ( 86400 * 7 );
$online_user = '';
$offline_user = '';
$onair_user = '';
$online_count = 0;
$onair_count = 0;
$lazy_state = 0;
$lazy_min = 20;

$data_list = $mysqli->query("
	SELECT user_id, user_name, user_color, user_font, user_rank, user_level, user_dj, user_onair, user_join, user_sex, user_age, user_tumb, user_cover, user_status, country,
	user_ghost, user_mute, user_rmute, user_mmute, room_mute, last_action, user_bot, user_role, user_mood, sshare, lshare, ashare
	FROM `boom_users`
	WHERE `user_roomid` = {$data["user_roomid"]}  AND last_action > '$check_action' AND user_status != 99 || user_bot = 1
	ORDER BY `user_rank` DESC, user_role DESC, `user_name` ASC 
");

if($setting['max_offcount'] > 0){
	$offline_list = $mysqli->query("
		SELECT user_id, user_name, user_color, user_font, user_rank, user_level, user_dj, user_onair, user_join, user_sex, user_age, user_tumb, user_cover, user_status, country,
		user_ghost, user_mute, user_rmute, user_mmute, room_mute, last_action, user_bot, user_role, user_mood, sshare, lshare, ashare
		FROM `boom_users`
		WHERE `user_roomid` = {$data["user_roomid"]}  AND last_action > '$online_delay' AND last_action < '$check_action' AND user_status != 99 AND  user_rank != 0 AND user_bot = 0
		ORDER BY last_action DESC LIMIT {$setting['max_offcount']}
	");
}

mysqli_close($mysqli);

if ($data_list->num_rows > 0){
	while ($list = $data_list->fetch_assoc()){
		if($list['user_dj'] == 1 && $list['user_onair'] == 1){
			$onair_user .= createUserlist($list);
			$onair_count++;
		}
		else {
			if($lazy_state < $lazy_min){
				$online_user .= createUserlist($list);
			}
			else {
				$online_user .= createUserlist($list, true);
			}
			$online_count++;
			$lazy_state++;
		}
	}
}
if($setting['max_offcount'] > 0){
	if($offline_list->num_rows > 0){
		while($offlist = $offline_list->fetch_assoc()){
			if($lazy_state < $lazy_min){
				$offline_user .= createUserlist($offlist);
				$lazy_state++;
			}
			else {
				$offline_user .= createUserlist($offlist, true);
			}
		}
	}
}

?>
<div id="container_user" class="pad10">
	<?php if($onair_user != ''){ ?>
	<div class="user_count">
		<div class="bcell">
			<?php echo $lang['onair']; ?> <span class="ucount theme_btn"><?php echo $onair_count; ?></span>
		</div>
	</div>
	<div class="online_user vpad5">
		<?php echo $onair_user; ?>
	</div>
	<?php } ?>
	<div class="user_count">
		<div class="bcell">
			<?php echo $lang['online']; ?> <span class="ucount theme_btn"><?php echo $online_count; ?></span>
		</div>
	</div>
	<div class="online_user vpad5">
		<?php echo $online_user; ?>
	</div>
	<?php if($offline_user != ''){ ?>
	<div class="user_count">
		<div class="bcell">
			<?php echo $lang['offline']; ?>
		</div>
	</div>
	<div class="offline_user vpad5">
		<?php echo $offline_user; ?>
	</div>
	<?php } ?>
	<div class="clear">
	</div>
</div>