<?php
require('../config_session.php');

if(!isset($_POST['type'], $_POST['id'])){
	die();
}
$id = escape($_POST['id'], true);
$type = escape($_POST['type'], true);

if(!canSendReport()){
	echo 3;
	die();
}
?>
<div class="modal_content">
	<div class="bpad15 text_med bold">
		<i class="fa fa-exclamation-triangle error"></i> <?php echo $lang['report_post']; ?>
	</div>
	<div class="bpad10">
		<p class="text_small" ><?php echo $lang['report_warning']; ?></p>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['reason']; ?></p>
		<select id="report_reason">
			<?php echo listReport(); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button onclick="makeReport(<?php echo $type; ?>,<?php echo $id; ?>);" class="reg_button theme_btn"><?php echo $lang['report']; ?></button>
	<button class="reg_button close_over default_btn"><?php echo $lang['cancel']; ?></button>
</div>