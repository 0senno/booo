<?php
require('../config_session.php');
?>
<div class="centered_element">
	<div class="modal_content">
		<div class="pad15">
			<p class="text_large bold vpad10"><?php echo $lang['you_sure']; ?></p>
			<p><?php echo $lang['private_read']; ?></p>
		</div>
	</div>
	<div class="modal_control">
		<button onclick="privateRead();" class="reg_button theme_btn"><?php echo $lang['yes']; ?></button>
		<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
	</div>
</div>