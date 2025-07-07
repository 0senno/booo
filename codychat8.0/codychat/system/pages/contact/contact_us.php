<?php
$cname = '';
$cemail = '';
if(boomLogged()){
	$cname = $data['user_name'];
	$cemail = $data['user_email'];
}
?>
<div class="page_full vheight">
	<?php echo pageTitle($lang['contact_us'], 'envelope'); ?>
	<div class="page_element">
		<div class="pad15">
			<div id="contact_form">
				<div class="contact_top bpad20">
					<p><?php echo $lang['contact_top']; ?></p>
				</div>
				<div class="setting_element">
					<p class="label"><?php echo $lang['contact_name']; ?></p>
					<input value="<?php echo $cname; ?>" maxlength="50" id="contact_name" class="full_input"/>
				</div>
				<div class="setting_element">
					<p class="label"><?php echo $lang['email']; ?></p>
					<input value="<?php echo $cemail; ?>" maxlength="50" id="contact_email" class="full_input"/>
				</div>
				<div class="setting_element">
					<p class="label"><?php echo $lang['message']; ?></p>
					<textarea value="" spellcheck="false" maxlength="2000" id="contact_message" class="large_textarea full_textarea"></textarea>
				</div>
				<?php if(boomRecaptcha()){ ?>
				<div id="contact_recapt" class="recapcha_div vpad10">
					<div id="boom_recaptcha" class="contact_recapt">
					</div>
				</div>
				<?php } ?>
				<div id="contact_send" class="tpad5">
					<button onclick="sendContact();"  class="reg_button theme_btn"><i class="fa fa-paper-plane"></i> <?php echo $lang['send']; ?></button>
				</div>
			</div>
			<div id="contact_sent" class="centered_element pad25 hidden">
				<p class="text_ultra success"><i class="fa fa-check-circle"></i></p>
				<p class="text_large bold bpad10"><?php echo $lang['contact_done']; ?></p>
				<p class=""><?php echo $lang['contact_sent']; ?></p>
			</div>
			<div id="contact_max" class="centered_element pad25 hidden">
				<p class="text_ultra error"><i class="fa fa-exclamation-triangle"></i></p>
				<p class="text_large bold bpad10"><?php echo $lang['something_wrong']; ?></p>
				<p class=""><?php echo $lang['contact_max']; ?></p>
			</div>
			<div id="contact_error" class="centered_element pad25 hidden">
				<p class="text_ultra error"><i class="fa fa-exclamation-triangle"></i></p>
				<p class="text_large bold bpad10"><?php echo $lang['something_wrong']; ?></p>
				<p class=""><?php echo $lang['contact_error']; ?></p>
			</div>
		</div>
	</div>
</div>