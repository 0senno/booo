<?php
require('../config_session.php');
if(!boomAllow(1)){ 
	die();
}
?>
<div class="modal_content">
	<div>
		<p class="text_med bold bpad5"><i class="fa fa-exclamation-triangle error"></i> <?php echo $lang['close_account']; ?></p>
		<p class="sub_text text_small"><?php echo $lang['close_message']; ?></p>
	</div>
	<div class="vpad15 ">
		<p class="label"><?php echo $lang['password']; ?></p>
		<input id="delete_account_password" type="password" class="full_input"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="deleteMyAccount();" class="reg_button delete_btn"><i class="fa fa-trash-can"></i> <?php echo $lang['delete']; ?></button>
	<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
</div>