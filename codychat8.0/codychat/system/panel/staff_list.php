<?php
require('../config_session.php');

$online_staff = '';
$offline_staff = '';
$online_count = 0;

$find_staff = $mysqli->query("
	SELECT *
	FROM boom_users
	WHERE user_rank >= 70 AND user_status != 99 AND user_bot = 0
	ORDER BY user_rank DESC
");

if($find_staff->num_rows > 0){				
	while($find = $find_staff->fetch_assoc()){
		if($find['last_action'] > getDelay()){
			$online_staff .= createUserList($find);
			$online_count++;
		}
		else {
			$offline_staff .= createUserList($find);
		}
	}
}
?>
<div id="container_friendship">
	<div class="boom_keep pad10" id="container_staff">
		<?php if($online_staff != ''){ ?>
		<div class="user_count">
			<div class="bcell">
				<?php echo $lang['online']; ?> <span class="ucount theme_btn"><?php echo $online_count; ?></span>
			</div>
		</div>
		<div class="online_user">
			<?php echo $online_staff; ?>
		</div>
		<?php } ?>
		<?php if($offline_staff != ''){ ?>
		<div class="user_count">
			<div class="bcell">
				<?php echo $lang['offline']; ?>
			</div>
		</div>
		<div class="offline_user">
			<?php echo $offline_staff; ?>
		</div>
		<?php } ?>
	</div>
</div>