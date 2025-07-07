<?php
require('../config.php');
if(!allowGuest()){
	die();
}
if(checkCoppa()){
	echo 99;
	die();
}
?>
<div id="guest_form_box">
	<div class="modal_title">
		<?php echo $lang['guest_login']; ?>
	</div>
	<div class="modal_content">
		<div>
		<input id="guest_username" class="user_username full_input" type="text" maxlength="<?php echo $setting['max_username']; ?>" name="username" autocomplete="off" placeholder="<?php echo $lang['username']; ?>">
		</div>
		<?php if(guestForm()){ ?>
		<div class="tpad15">
			<div class="form_split register_options">
				<div class="form_left">
					<select id="guest_gender">
						<?php echo listGender(1); ?>
					</select>
				</div>
				<div class="form_right">
					<select size="1" id="guest_age">
						<?php echo listAge(0, 1); ?>
					</select>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
		<?php if(!guestForm()){ ?>
			<input id="guest_gender" class="hidden" value="1">
			<input id="guest_age" class="hidden" value="1">
		<?php } ?>
		<?php if(boomRecaptcha()){ ?>
		<div class="recapcha_div tmargin15">
			<div id="boom_recaptcha" class="guest_recaptcha">
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="modal_control">
		<button onclick="sendGuestLogin();" type="button" class="theme_btn full_button large_button"><i class="fa fa-sign-in"></i> <?php echo $lang['login']; ?></button>
	</div>
</div>