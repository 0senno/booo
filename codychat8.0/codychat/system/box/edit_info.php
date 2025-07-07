<?php
require('../config_session.php');
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['age']; ?></p>
		<select id="set_profile_age">
			<?php echo listAge($data['user_age']); ?>
		</select>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['gender']; ?></p>
		<select id="set_profile_gender">
			<?php echo listGender($data['user_sex']); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button type="button" onclick="saveInfo();" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
</div>