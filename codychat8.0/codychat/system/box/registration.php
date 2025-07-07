<?php 
require('../config.php'); 
if(checkCoppa()){
	echo 99;
	die();
}
?>
<div id="registration_form_box">
	<div class="modal_title">
		<?php echo $lang['register']; ?>
	</div>
	<div class="modal_content">
		<div class="bpad15">
			<input spellcheck="false" id="reg_username" class="full_input" type="text" maxlength="<?php echo $setting['max_username']; ?>" autocomplete="off" placeholder="<?php echo $lang['username']; ?>">
			<input type="text" style="display:none">
			<input type="password" style="display:none">
		</div>
		<div class="bpad15">
			<input spellcheck="false" id="reg_password" class="full_input" maxlength="30" type="password" autocomplete="off" placeholder="<?php echo $lang['password']; ?>">
		</div>
		<div class="bpad15">
			<input spellcheck="false" id="reg_email" class="full_input" maxlength="80" type="text" autocomplete="off" placeholder="<?php echo $lang['email']; ?>">
		</div>
		<div class="form_split register_options">
			<div class="form_left">
				<select id="login_select_gender">
					<?php echo listGender(1); ?>
				</select>
			</div>
			<div class="form_right">
				<select size="1" id="login_select_age">
					<?php echo listAge(0, 1); ?>
				</select>
			</div>
		</div>
		<div class="clear"></div>
		<?php if(boomRecaptcha()){ ?>
		<div class="recapcha_div tmargin15">
			<div id="boom_recaptcha" class="register_recaptcha">
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="modal_control">
		<button onclick="sendRegistration();" type="button" class="theme_btn full_button large_button" id="register_button"><i class="fa fa-edit"></i> <?php echo $lang['register']; ?></button>
		<div class="rules_text_elem vpad10">
			<p class="rules_text text_xsmall sub_text"><?php echo $lang['i_agree']; ?> <span class="rules_click" onclick="showRules();"><?php echo $lang['terms']; ?></span></p>
		</div>
	</div>
</div>