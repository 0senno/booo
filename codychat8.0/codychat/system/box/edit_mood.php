<?php
require('../config_session.php');
if(!canMood()){ 
	die();
}
?>
<div class="modal_title">
	<?php echo $lang['mood']; ?>
</div>
<div class="modal_content">
	<div class="mood_content">
		<input id="set_mood" maxlength="30" class="full_input" value="<?php echo $data['user_mood']; ?>" autocomplete="off" type="text"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="saveMood();" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>