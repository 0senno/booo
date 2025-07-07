<?php
require('../config_session.php');
if(!canAbout()){ 
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['about_me']; ?></p>
		<textarea id="set_user_about" class="large_textarea about_area full_textarea" spellcheck="false" maxlength="800" ><?php echo getUserData($data, 'user_about'); ?></textarea>
	</div>
</div>
<div class="modal_control">
	<button type="button" onclick="saveAbout();" id="save_profile" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
</div>