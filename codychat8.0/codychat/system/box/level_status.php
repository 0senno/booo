<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	echo 0;
	die();
}
$target = escape($_POST['target'], true);
$user = userExpDetails($target);
if(empty($user)){
	echo 0;
	die();
}
if(!canLevel($user)){
	echo 0;
	die();
}
$percent = userExpStatus($user);
?>
<div class="tpad10">
	<div class="modal_content">
		<div class="modal_title">
			<?php echo str_replace('%level%', $user['user_level'], $lang['level_progress']); ?>
		</div>
		<div class="progress_zone">
			<div class="progress_box">
			  <div style="width:<?php echo $percent; ?>%;" class="progress_bar">&nbsp;&nbsp;<?php echo $percent; ?>%</div>
			</div>
			<div class="text_small tpad5 bpad20 hpad5">
					<?php echo $user['exp_current']; ?> / <?php echo requiredExp($user); ?> <?php echo $lang['xp']; ?>
			</div>
		</div>
		<div class="tborder tmargin10">
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><?php echo $lang['exp_week']; ?></div>
				<div class="bcell_mid prodata"><?php echo $user['exp_week']; ?></div>
			</div>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><?php echo $lang['exp_month']; ?></div>
				<div class="bcell_mid prodata"><?php echo $user['exp_month']; ?></div>
			</div>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><?php echo $lang['exp_ttotal']; ?></div>
				<div class="bcell_mid prodata"><?php echo $user['exp_total']; ?></div>
			</div>
		</div>
	</div>
	<div class="modal_control">
		<div class="tpad10">
			<button class="close_over default_btn reg_button"><?php echo $lang['close']; ?></button>
		</div>
	</div>
</div>