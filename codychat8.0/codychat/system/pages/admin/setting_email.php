<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['email_settings']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['mail_type']; ?></p>
				<select id="set_mail_type">
					<option <?php echo selCurrent($setting['mail_type'], 'mail'); ?> value="mail">mail</option>
					<option <?php echo selCurrent($setting['mail_type'], 'smtp'); ?> value="smtp">smtp</option>
				</select>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['site_email']; ?></p>
				<input id="set_site_email" class="full_input" value="<?php echo $setting['site_email']; ?>" type="text"/>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['email_from']; ?></p>
				<input id="set_email_from" class="full_input" value="<?php echo $setting['email_from']; ?>" type="text"/>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['smtp_host']; ?></p>
				<input id="set_smtp_host" class="full_input" value="<?php echo $setting['smtp_host']; ?>" type="text"/>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['smtp_username']; ?></p>
				<input id="set_smtp_username" class="full_input" value="<?php echo $setting['smtp_username']; ?>" type="text"/>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['smtp_password']; ?></p>
				<input id="set_smtp_password" type="password" class="full_input" value="<?php echo $setting['smtp_password']; ?>" type="text"/>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['smtp_port']; ?></p>
				<input id="set_smtp_port" class="full_input" value="<?php echo $setting['smtp_port']; ?>" type="text"/>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['smtp_encryption']; ?></p>
				<select id="set_smtp_type">
					<option <?php echo selCurrent($setting['smtp_type'], 'tls'); ?> value="tls">tls</option>
					<option <?php echo selCurrent($setting['smtp_type'], 'ssl'); ?> value="ssl">ssl</option>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminEmail();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
			<button type="button" onclick="openTestMail();" class="reg_button default_btn"><i class="fa fa-envelope-o"></i> <?php echo $lang['test']; ?></button>
		</div>
	</div>
</div>