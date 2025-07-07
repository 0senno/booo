<?php
require('../config_session.php');

if(!useGift()){
	echo 0;
	die();
}

if(!isset($_POST['target'])){
	echo 0;
	die();
}
$target = escape($_POST['target'], true);

$gift = $mysqli->query("SELECT * FROM boom_gift WHERE id > 0  AND gift_rank <= '{$data['user_rank']}' ORDER BY gift_method ASC, gift_cost ASC");
?>
<div id="gift_first">
<div class="modal_content">
	<div class="tpad10">
		<?php echo createPag($gift, 12, array('template'=> 'element/gift_element', 'style'=> 'arrow')); ?>
	</div>
</div>
</div>
<div id="gift_second" class="hidden" data-id="" data-user="<?php echo $target; ?>">
	<div class="modal_content">
		<div class="centered_element">
			<div class="tpad20">
				<img class="gift_selected" id="gift_selected" src=""/>
			</div>
			<div id="gift_title" class="text_med bold tpad20">
			</div>
			<div class="gift_text sub_text">
				<?php echo myself($target) ? $lang['ok_buy'] : $lang['ok_gift']; ?>
			</div>
			<div class="tpad20 bpad10">
				<div class="btable_auto mauto">
					<div class="gift_selicon bcell_mid">
						<img id="gift_sgold" src="<?php echo goldIcon(); ?>"/>
						<img id="gift_sruby" src="<?php echo rubyIcon(); ?>"/>
					</div>
					<div id="gift_pricing" class="gift_pricing hpad5 bcell_mid">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal_control centered_element">
		<button onclick="sendGift();" class="reg_button theme_btn"><?php echo myself($target) ? $lang['buy'] : $lang['send']; ?></button>
		<button onclick="backGift();" class="reg_button default_btn"><?php echo $lang['back']; ?></button>
	</div>
</div>