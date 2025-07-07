<?php
require('../config_session.php');

if(!boomAllow(100)){
	echo 0;
	die();
}
if(!isset($_POST['edit_gift'])){
	echo 0;
	die();
}
$target = escape($_POST['edit_gift'], true);
$gift = giftDetails($target);

if(empty($gift)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div>
		<img class="gift_edit_img" src="gift/<?php echo $gift['gift_image']; ?>"/>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['gift_title']; ?></p>
		<input id="set_gift_title" class="full_input" value="<?php echo $gift['gift_title']; ?>" type="text"/>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['rank_require']; ?></p>
		<select id="set_gift_rank">
			<?php echo listRank($gift['gift_rank']); ?>
		</select>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['payment_method']; ?></p>
		<select id="set_gift_method">
			<option value="1" <?php echo selCurrent($gift['gift_method'], 1); ?>><?php echo $lang['gold']; ?></option>
			<option value="2" <?php echo selCurrent($gift['gift_method'], 2); ?>><?php echo $lang['ruby']; ?></option>
		</select>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['amount_required']; ?></p>
		<select id="set_gift_cost">
			<?php echo optionCount($gift['gift_cost'], 10, 90, 10); ?>
			<?php echo optionCount($gift['gift_cost'], 100, 900, 50); ?>
			<?php echo optionCount($gift['gift_cost'], 1000, 25000, 250); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button onclick="saveGift(<?php echo $gift['id']; ?>);" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
	<button class="reg_button default_btn cancel_modal"><?php echo $lang['cancel']; ?></button>
	<button onclick="deleteGift(<?php echo $gift['id']; ?>);" class="button fright rtl_fleft delete_btn"><i class="fa fa-trash-can"></i></button>
</div>