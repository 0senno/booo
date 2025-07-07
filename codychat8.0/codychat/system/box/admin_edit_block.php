<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	echo 0;
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);
if(empty($user)){
	echo 0;
	die();
}
if(!canBlockUser($user)){
	echo 0;
	die();
}
?>
<div class="modal_title">
	<?php echo $lang['block_feature']; ?>
</div>
<div class="modal_content">
	<div id="set_ublock" value="<?php echo $user['user_id']; ?>">
		<div class="switch_item bbackhover">
			<div class="switch_item_text">
				<?php echo $lang['block_upload']; ?>
			</div>
			<div class="switch_item_switch">
				<div class="switch_wrap">
					<?php echo createSwitch('set_bupload', $user['bupload'], 'adminSaveBlock'); ?>
				</div>
			</div>
		</div>
		<div class="switch_item bbackhover">
			<div class="switch_item_text">
				<?php echo $lang['block_comment']; ?>
			</div>
			<div class="switch_item_switch">
				<div class="switch_wrap">
					<?php echo createSwitch('set_bnews', $user['bnews'], 'adminSaveBlock'); ?>
				</div>
			</div>
		</div>
		<div class="switch_item bbackhover">
			<div class="switch_item_text">
				<?php echo $lang['block_call']; ?>
			</div>
			<div class="switch_item_switch">
				<div class="switch_wrap">
					<?php echo createSwitch('set_bcall', $user['bcall'], 'adminSaveBlock'); ?>
				</div>
			</div>
		</div>
	</div>
</div>