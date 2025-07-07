<?php
require('../config_session.php');
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['language']; ?></p>
		<select id="set_profile_language">
			<?php echo listLanguage($data['user_language'], 1); ?>
		</select>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['country']; ?></p>
		<select id="set_profile_country">
			<?php echo listCountry($data['country']); ?>
		</select>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['user_timezone']; ?></p>
		<select id="set_profile_timezone">
			<?php echo getTimezone($data['user_timezone']); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button onclick="saveLocation();" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>