<?php 
require('../config.php');
?>
<div class="modal_title">
	<?php echo $lang['recovery']; ?>
</div>
<div class="modal_content">
	<div>
		<input id="recovery_email" class="full_input" maxlength="80" type="text" placeholder="<?php echo $lang['email']; ?>">
	</div>
</div>
<div class="modal_control">
	<button onclick="sendRecovery();" type="button" class="large_button full_button theme_btn" id="recovery_button"><?php echo $lang['recover']; ?></button>
</div>