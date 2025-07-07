<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	echo 0;
	die();
}
if(!canDeletePrivate()){
	echo 0;
	die();
}
$id = escape($_POST['target'], true);
?>
<div class="centered_element">
	<div class="modal_content">
		<div class="pad15">
			<p class="text_large bold bpad10"><?php echo $lang['you_sure']; ?></p>
			<p><?php echo $lang['delete_private']; ?></p>
		</div>
	</div>
	<div class="modal_control">
		<button onclick="clearPrivate(<?php echo $id; ?>);" class="reg_button theme_btn"><?php echo $lang['yes']; ?></button>
		<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
	</div>
</div>