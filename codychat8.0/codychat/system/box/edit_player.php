<?php
require('../config_session.php');

if(!isset($_POST['edit_player'])){
	die();
}
$id = escape($_POST['edit_player'], true);
$get_player = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id = '$id'");
if($get_player->num_rows < 1){
	die();
}
else {
	$player = $get_player->fetch_assoc();
}
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['stream_alias']; ?></p>
		<input id="new_stream_alias" class="full_input" value="<?php echo $player['stream_alias']; ?>"/>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['stream_url']; ?></p>
		<input id="new_stream_url" class="full_input" value="<?php echo $player['stream_url']; ?>"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="savePlayer(<?php echo $player['id']; ?>);" type="button" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>