<?php
require('../config_session.php');
if(!canCreateUser()){ 
	die(); 
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['username']; ?></p>
		<input id="set_create_name" class="full_input" type="text" maxlength="<?php echo $setting['max_username']; ?>" />
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['password']; ?></p>
		<input id="set_create_password" class="full_input" type="text" maxlength="30" />
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['email']; ?></p>
		<input id="set_create_email" class="full_input" type="text" maxlength="80" value="<?php echo 'user_'.lastRecordedId().'@user.com'; ?>"/>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['gender']; ?></p>
		<select id="set_create_gender">
			<?php echo listGender($data['user_sex']); ?>
		</select>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['age']; ?></p>
		<select id="set_create_age">
			<?php echo listAge($setting['min_age']); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button class="theme_btn reg_button tmargin5" onclick="addNewUser();" id="add_new_user"><i class="fa fa-plus-circle"></i> <?php echo $lang['create']; ?></button>
	<button class="reg_button cancel_modal default_btn"><?php echo $lang['cancel']; ?></button>
</div>