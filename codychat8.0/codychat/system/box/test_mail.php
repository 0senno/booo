<?php 
require('../config_session.php');
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['email']; ?></p>
		<input id="test_email" class="full_input" value="<?php echo $data['user_email']; ?>" type="text"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="testMail();" class="reg_button theme_btn"><i class="fa fa-paper-plane"></i> <?php echo $lang['send']; ?></button>
	<button class="cancel_modal reg_button default_btn"><?php echo $lang['cancel']; ?></button>
</div>