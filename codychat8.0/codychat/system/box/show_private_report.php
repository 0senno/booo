<?php
require('../config_session.php');

$show_report = '';
if(!canManageReport()){
	die();
}
if(isset($_POST['private_report'])){
	$id = escape($_POST['private_report'], true);
	$report = reportDetails($id);
	if(empty($report)){
		echo 1;
		die();
	}
	$privlog = $mysqli->query("
		SELECT 
		log.*, boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot 
		FROM ( SELECT * FROM `boom_private` WHERE  `hunter` = '{$report['report_user']}' AND `target` = '{$report['report_target']}'  OR `hunter` = '{$report['report_target']}' AND `target` = '{$report['report_user']}' ORDER BY `id` DESC LIMIT 50) AS log 
		LEFT JOIN boom_users
		ON log.hunter = boom_users.user_id
		ORDER BY `time` DESC
	");
	if($privlog->num_rows > 0){
		while($log = $privlog->fetch_assoc()){
			$show_report .= '
			<div class="btable blisting pad10">
				<div class="prep_avatar"><img src="' . myAvatar($log['user_tumb']) . '"/></div>
				<div class="preplog bcell_top hpad10">
					<div class="username text_small">' . $log['user_name'] . '</div>
					<div class="bpad5">' . processPrivateMessage($log) . '</div>
				</div>
			</div>';
		}
	}
	else {
		$mysqli->query("DELETE FROM boom_report WHERE report_id = '$id' AND report_type = 3");
		updateStaffNotify();
		echo 1;
		die();
	}
	$user = userDetails($report['report_target']);
}
else {
	die();
}
?>
<div class="modal_content">
	<div class="report_user vpad10 blist">
		<div class="report_avatar get_info" data="<?php echo $user['user_id']; ?>">
			<img src="<?php echo myAvatar($user['user_tumb']); ?>"/>
		</div>
		<div class="hpad5 report_info bcell_mid">
			<p class="text_small username"><?php echo $user['user_name']; ?></p>
			<p class="text_xsmall sub_date"><?php echo displayDate($report['report_date']); ?></p>
		</div>
	</div>
	<div class="report_data tmargin20 box_height300">
		<?php echo $show_report; ?>
	</div>
</div>
<div class="modal_control">
	<button onclick="removeReport(3,<?php echo $report['report_id']; ?>, <?php echo $report['report_target']; ?>);" class="reg_button delete_btn"><?php echo $lang['delete']; ?></button>
	<button onclick="unsetReport(<?php echo $report['report_id']; ?>, 3);" class="unset_report reg_button default_btn"><?php echo $lang['action_none']; ?></button>
</div>