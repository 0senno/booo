<?php
require('../config_session.php');
if(!canManagePlayer()){
	die();
}
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['stream_alias']; ?></p>
		<input id="add_stream_alias" class="full_input"/>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['stream_url']; ?></p>
		<input id="add_stream_url" class="full_input"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="addPlayer();" type="button" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
</div>