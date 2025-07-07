<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['ai']); ?>
<div class="page_full">
	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="aitab" data-z="openai"><?php echo $lang['openai']; ?></li>
			</ul>
		</div>
	</div>
	<div class="page_element">
		<div id="aitab">
			<div id="openai" class="tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['openai_key']; ?> <?php echo createInfo('openai'); ?></p>
						<input id="set_openai_key" class="full_input" value="<?php echo $setting['openai_key']; ?>" type="text"/>
					</div>
				</div>
				<div class="setting_element ">
					<p class="label"><?php echo $lang['img_mod']; ?></p>
					<select id="set_img_mod">
						<?php echo onOff($setting['img_mod']); ?>
					</select>
				</div>
				<div class="form_control">
					<button onclick="saveAdminAi();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
					<button onclick="openModCat();" type="button" class="reg_button default_btn"><?php echo $lang['edit_filter']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>