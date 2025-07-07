<?php
require('../config_session.php');

if(!useWallet()){
	die();
}
if(!isset($_POST['target'])){
	die();
}
$target = escape($_POST['target'], true);
$user = userRelationDetails($target);
if(empty($user)){
	echo 0;
	die();
}
if(!canShareWallet($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="modal_menu modal_mborder bmargin10">
		<ul>
			<li class="modal_menu_item modal_selected" data="sharewallet" data-z="sharegold"><?php echo $lang['gold']; ?></li>
			<li class="modal_menu_item" data="sharewallet" data-z="shareruby"><?php echo $lang['ruby']; ?></li>
		</ul>
	</div>
	<div id="sharewallet">
		<div class="modal_zone tpad10" id="sharegold">
			<div class="modal_content">
				<div class="bpad10">
					<div class="text_med bold bpad10">
						<p><?php echo $lang['gold_balance']; ?></p>
					</div>
					<div class="btable">
						<div class="bcell_mid gold_icon2">
							<img src="<?php echo goldIcon(); ?>"/> 
						</div>
						<div class="bcell_mid gold_text2 hpad5">
							<?php echo $data['user_gold']; ?>
						</div>
					</div>
				</div>
				<div class="setting_element">
					<p class="label"><?php echo $lang['amount_share']; ?></p>
					<input class="full_input" id="gold_shared" type="text"/>
					<p class="text_xsmall sub_text tpad5"><?php echo $lang['minimum']; ?> <?php echo minGold(); ?> - <?php echo $lang['maximum']; ?> <?php echo maxGold(); ?></p>
				</div>
			</div>
			<div class="modal_control">
				<button class="reg_button theme_btn" onclick="shareGold(<?php echo $user['user_id']; ?>);"><?php echo $lang['send']; ?></button>
				<button class="reg_button default_btn cancel_over"><?php echo $lang['cancel']; ?></button>
			</div>

		</div>
		<div class="hide_zone modal_zone tpad10" id="shareruby">
			<div class="modal_content">
				<div class="bpad10">
					<div class="text_med bold bpad10">
						<p><?php echo $lang['ruby_balance']; ?></p>
					</div>
					<div class="btable">
						<div class="bcell_mid gold_icon2">
							<img src="<?php echo rubyIcon(); ?>"/> 
						</div>
						<div class="bcell_mid gold_text2 hpad5">
							<?php echo $data['user_ruby']; ?>
						</div>
					</div>
				</div>
				<div class="setting_element">
					<p class="label"><?php echo $lang['amount_share']; ?></p>
					<input class="full_input" id="ruby_shared" type="text"/>
					<p class="text_xsmall sub_text tpad5"><?php echo $lang['minimum']; ?> <?php echo minRuby(); ?> - <?php echo $lang['maximum']; ?> <?php echo maxRuby(); ?></p>
				</div>
			</div>
			<div class="modal_control">
				<button class="reg_button theme_btn" onclick="shareRuby(<?php echo $user['user_id']; ?>);"><?php echo $lang['send']; ?></button>
				<button class="reg_button default_btn cancel_over"><?php echo $lang['cancel']; ?></button>
			</div>
		</div>
	</div>
</div>