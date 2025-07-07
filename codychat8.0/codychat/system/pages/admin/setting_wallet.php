<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['wallet_settings']); ?>
<div class="page_full">
	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="wtab" data-z="wallet_main"><?php echo $lang['config']; ?></li>
				<li class="tab_menu_item" data="wtab" data-z="wallet_gold"><?php echo walletTitle(1); ?></li>
				<li class="tab_menu_item" data="wtab" data-z="wallet_ruby"><?php echo walletTitle(2); ?></li>
			</ul>
		</div>
	</div>
	<div class="page_element">
		<div id="wtab">
			<div id="wallet_main" class="tab_zone">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['use_wallet']; ?></p>
						<select id="set_use_wallet">
							<?php echo onOff($setting['use_wallet']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_swallet']; ?></p>
						<select id="set_can_swallet">
							<?php echo listRank($setting['can_swallet']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminWallet();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="wallet_ruby" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_ruby']; ?></p>
						<select id="set_can_ruby">
							<?php echo listRank($setting['can_ruby']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['ruby_delay']; ?></p>
						<select id="set_ruby_delay">
							<?php echo optionMinutes($setting['ruby_delay'], array(15,20,30,60,120,180,240,300,360,420,480,540,600,660,720,1440)); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['ruby_base']; ?></p>
						<select id="set_ruby_base">
							<?php echo optionCount($setting['ruby_base'], 0, 5, 1); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminWallet();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="wallet_gold" class=" hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_gold']; ?></p>
						<select id="set_can_gold">
							<?php echo listRank($setting['can_gold']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['gold_delay']; ?></p>
						<select id="set_gold_delay">
							<?php echo optionMinutes($setting['gold_delay'], array(1,2,3,4,5,10,15,20,25,30,60)); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['gold_base']; ?></p>
						<select id="set_gold_base">
							<?php echo optionCount($setting['gold_base'], 0, 10, 1); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminWallet();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>