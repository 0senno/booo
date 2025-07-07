<?php
require(__DIR__ . '/../../config_admin.php');

if(!canManageContact()){
	die();
}
?>
<?php echo elementTitle($lang['manage_contact']); ?>
<div class="page_full">
	<?php if(boomAllow(100)){ ?>
	<div class="page_element">
		<button onclick="openClearContact();" class="reg_button delete_btn"><?php echo $lang['clear']; ?></button>
	</div>
	<?php } ?>
	<div class="page_element">
		<div id="contact_listing">
			<?php echo listContact(); ?>
		</div>
	</div>
</div>