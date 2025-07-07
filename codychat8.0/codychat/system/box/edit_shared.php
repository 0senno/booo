<?php
require('../config_session.php');
?>
<div class="bpad15">
	<div class="text_xxreg bold">
		<?php echo $lang['edit_privacy']; ?>
	</div>
	<div class="text_small sub_text tpad3">
		<?php echo $lang['privacy_text']; ?>
	</div>
</div>
<div class="modal_content">
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['share_age']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_ashare', $data['ashare'], 'saveShare'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['share_gender']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_sshare', $data['sshare'], 'saveShare'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['share_location']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_lshare', $data['lshare'], 'saveShare'); ?>
			</div>
		</div>
	</div>
	<?php if(isMember($data)){ ?>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['share_flist']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_fshare', $data['fshare'], 'saveShare'); ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if(useGift()){ ?>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['share_glist']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_gshare', $data['gshare'], 'saveShare'); ?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>