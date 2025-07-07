<?php 
require('../config_session.php');
?>
<div class="modal_content">
	<p class="label"><?php echo $lang['username']; ?></p>
	<input type="text" id="my_new_username" value="<?php echo $data['user_name']; ?>" class="full_input"/>
</div>
<div class="modal_control">
	<button onclick="changeMyUsername();" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>