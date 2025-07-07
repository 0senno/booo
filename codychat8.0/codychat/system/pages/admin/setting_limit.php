<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['member_permission']); ?>
<div class="page_full">

	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="limtab" data-z="limit_profile"><?php echo $lang['account']; ?></li>
				<li class="tab_menu_item" data="limtab" data-z="limit_upload"><?php echo $lang['upload']; ?></li>
				<li class="tab_menu_item" data="limtab" data-z="limit_chat"><?php echo $lang['chat']; ?></li>
				<li class="tab_menu_item" data="limtab" data-z="limit_display"><?php echo $lang['display']; ?></li>
				<li class="tab_menu_item" data="limtab" data-z="limit_other"><?php echo $lang['other']; ?></li>
			</ul>
		</div>
	</div>
	<div class="page_element">
		<div id="limtab">
			<div id="limit_profile" class="tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_avatar']; ?></p>
						<select id="set_allow_avatar">
							<?php echo listRank($setting['allow_avatar']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_name']; ?></p>
						<select id="set_allow_name">
							<?php echo listRankMember($setting['allow_name']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_cover']; ?></p>
						<select id="set_allow_cover">
							<?php echo listRank($setting['allow_cover']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_gcover']; ?></p>
						<select id="set_allow_gcover">
							<?php echo listRank($setting['allow_gcover']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_mood']; ?></p>
						<select id="set_allow_mood">
							<?php echo listRank($setting['allow_mood']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_about']; ?></p>
						<select id="set_allow_about">
							<?php echo listRank($setting['allow_about']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminUserPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="limit_upload" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_cupload']; ?></p>
						<select id="set_allow_cupload">
							<?php echo listRank($setting['allow_cupload']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_pupload']; ?></p>
						<select id="set_allow_pupload">
							<?php echo listRank($setting['allow_pupload']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_wupload']; ?></p>
						<select id="set_allow_wupload">
							<?php echo listRank($setting['allow_wupload']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_video']; ?></p>
						<select id="set_allow_video">
							<?php echo listRank($setting['allow_video']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_audio']; ?></p>
						<select id="set_allow_audio">
							<?php echo listRank($setting['allow_audio']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_zip']; ?></p>
						<select id="set_allow_zip">
							<?php echo listRank($setting['allow_zip']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminUserPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="limit_display" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['name_color']; ?></p>
						<select id="set_allow_name_color">
							<?php echo listRank($setting['allow_name_color']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_colors']; ?></p>
						<select id="set_allow_colors">
							<?php echo listRank($setting['allow_colors']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['name_grad']; ?></p>
						<select id="set_allow_name_grad">
							<?php echo listRank($setting['allow_name_grad']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_grad']; ?></p>
						<select id="set_allow_grad">
							<?php echo listRank($setting['allow_grad']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['name_neon']; ?></p>
						<select id="set_allow_name_neon">
							<?php echo listRank($setting['allow_name_neon']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_neon']; ?></p>
						<select id="set_allow_neon">
							<?php echo listRank($setting['allow_neon']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['name_font']; ?></p>
						<select id="set_allow_name_font">
							<?php echo listRank($setting['allow_name_font']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_font']; ?></p>
						<select id="set_allow_font">
							<?php echo listRank($setting['allow_font']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminUserPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="limit_chat" class=" hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_main']; ?></p>
						<select id="set_allow_main">
							<?php echo listRank($setting['allow_main']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_private']; ?></p>
						<select id="set_allow_private">
							<?php echo listRank($setting['allow_private']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_quote']; ?></p>
						<select id="set_allow_quote">
							<?php echo listRank($setting['allow_quote']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_pquote']; ?></p>
						<select id="set_allow_pquote">
							<?php echo listRank($setting['allow_pquote']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['emo_plus']; ?></p>
						<select id="set_emo_plus">
							<?php echo listRank($setting['emo_plus']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_direct']; ?></p>
						<select id="set_allow_direct">
							<?php echo listRank($setting['allow_direct']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_scontent']; ?></p>
						<select id="set_allow_scontent">
							<?php echo listRank($setting['allow_scontent']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_history']; ?></p>
						<select id="set_allow_history">
							<?php echo listRank($setting['allow_history']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminUserPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="limit_other" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['word_proof']; ?></p>
						<select id="set_word_proof">
							<?php echo listRank($setting['word_proof']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_vroom']; ?></p>
						<select id="set_allow_vroom">
							<?php echo listRank($setting['allow_vroom']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_room']; ?></p>
						<select id="set_allow_room">
							<?php echo listRankMember($setting['allow_room']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_user_theme']; ?></p>
						<select id="set_allow_theme">
							<?php echo listRank($setting['allow_theme']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_report']; ?></p>
						<select id="set_allow_report">
							<?php echo listRank($setting['allow_report']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['allow_rnews']; ?></p>
						<select id="set_allow_rnews">
							<?php echo listRank($setting['allow_rnews']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminUserPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>