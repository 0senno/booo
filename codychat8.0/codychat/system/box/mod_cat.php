<?php
require('../config_session.php');

if(!boomAllow(100)){
	die();
}

$mc = arrayThisList($setting['mod_cat']);

$sexual     = in_array('sexual', $mc) ? 0 : 1;
$harassment = in_array('harassment', $mc) ? 0 : 1;
$hate       = in_array('hate', $mc) ? 0 : 1;
$illicit    = in_array('illicit', $mc) ? 0 : 1;
$violence   = in_array('violence', $mc) ? 0 : 1;
?>
<div class="bpad15">
	<div class="text_xxreg bold">
		<?php echo $lang['modcat_title']; ?>
	</div>
</div>
<div class="modal_content ">
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			Sexual
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_mod_sexual', $sexual, 'saveModCat'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			Hate
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_mod_hate', $hate, 'saveModCat'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			Harassment
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_mod_harassment', $harassment, 'saveModCat'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			Illicit
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_mod_illicit', $illicit, 'saveModCat'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			Violence
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_mod_violence', $violence, 'saveModCat'); ?>
			</div>
		</div>
	</div>
</div>