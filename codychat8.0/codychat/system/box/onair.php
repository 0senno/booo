<?php
require('../config_session.php');

if(!userDj($data)){
	return 0;
}
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['onair_status']; ?></p>
		<select id="set_user_onair" onchange="userOnair(this);">
			<?php echo onOff($data['user_onair']); ?>
		</select>
	</div>
</div>