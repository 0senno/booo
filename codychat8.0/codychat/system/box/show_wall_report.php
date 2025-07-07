<?php
require('../config_session.php');

if(!canManageReport()){
	die();
}
if(isset($_POST['wall_report'])){
	$id = escape($_POST['wall_report'], true);
	$report = reportDetails($id);
	if(empty($report)){
		echo 1;
		die();
	}
	$get_report = $mysqli->query("
		SELECT boom_post.*, boom_users.*
		FROM boom_post, boom_users
		WHERE boom_users.user_id = boom_post.post_user AND boom_post.post_id = '{$report['report_post']}' LIMIT 1
	");
	if($get_report->num_rows > 0){
		$rep = $get_report->fetch_assoc();
		$r = array_merge($report, $rep);
	}
	else {
		$mysqli->query("DELETE FROM boom_report WHERE report_id = '$id' AND report_type = 2");
		updateStaffNotify();
		echo 1;
		die();
	}
}
else {
	die();
}
?>
<div class="modal_content">
	<div class="report_user vpad10 blist">
		<div class="report_avatar get_info" data="<?php echo $r['user_id']; ?>">
			<img src="<?php echo myAvatar($r['user_tumb']); ?>"/>
		</div>
		<div class="hpad5 report_info bcell_mid">
			<p class="text_small username"><?php echo $r['user_name']; ?></p>
			<p class="text_xsmall sub_date"><?php echo displayDate($r['post_date']); ?></p>
		</div>
	</div>
	<div class="report_data vpad15">
		<?php echo boomPostIt($r, $r['post_content']); ?>
		<?php echo boomPostFile($r['post_file'], $r['post_file_type']); ?>
	</div>
</div>
<div class="modal_control">
	<div class="bcell report_action">
		<button onclick="removeReport(2,<?php echo $r['report_id']; ?>, <?php echo $r['user_id']; ?>);" class="remove_report reg_button delete_btn"><?php echo $lang['action']; ?></button>
		<button onclick="unsetReport(<?php echo $r['report_id']; ?>, 2);" class="unset_report reg_button default_btn"><?php echo $lang['action_none']; ?></button>
	</div>
</div>