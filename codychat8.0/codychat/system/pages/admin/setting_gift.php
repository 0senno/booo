<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
function listAdminGift(){
	global $mysqli, $data, $lang;
	$list = '';
	$get_gift = $mysqli->query("SELECT * FROM boom_gift WHERE id > 0 ORDER BY id DESC");
	if($get_gift->num_rows > 0){
		while($gift = $get_gift->fetch_assoc()){
			$list .= boomTemplate('element/admin_gift', $gift);
		}
	}
	return $list;
}
?>
<?php echo elementTitle($lang['gift_settings']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="setting_element ">
			<p class="label"><?php echo $lang['use_gift']; ?>  <?php echo createInfo('gift'); ?></p>
			<select id="set_use_gift">
				<?php echo onOff($setting['use_gift']); ?>
			</select>
		</div>
	</div>
	<div class="page_element">
		<div class="btable_auto brelative">
			<button onclick="addGift();" class="theme_btn reg_button"><i class="fa fa-plus-circle"></i> <?php echo $lang['add_gift']; ?></button>
			<input id="add_gift" class="up_input" onchange="addGift();" type="file">
		</div>
	</div>
	<div class="page_full">
		<div class="page_element">
			<div id="gift_list">
				<?php echo listAdminGift(); ?>
			</div>
		</div>
	</div>
</div>