<?php
require_once('../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['vip_settings']); ?>
<div class="page_full">
	<div>
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="vip" data-z="vip_setting"><?php echo $lang['settings']; ?></li>
				<li class="tab_menu_item" data="vip" data-z="vip_manage" onclick="vipLoadList();"><?php echo $lang['vip_manage']; ?></li>
				<li class="tab_menu_item" data="vip" data-z="vip_transaction" onclick="vipLoadTransaction();"><?php echo $lang['vip_transaction']; ?></li>
			</ul>
		</div>
	</div>
	<div id="vip">
		<div id="vip_setting" class="tab_zone">
			<div class="page_element">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['vip_mode_status']; ?></p>
						<select id="set_vip_status">
							<?php echo onOff($setting['use_vip']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['vset1']; ?></p>
						<input id="set_plan1" class="full_input" value="<?php echo $setting['vipplan1']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['vset2']; ?></p>
						<input id="set_plan2" class="full_input" value="<?php echo $setting['vipplan2']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['vset3']; ?></p>
						<input id="set_plan3" class="full_input" value="<?php echo $setting['vipplan3']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['vset4']; ?></p>
						<input id="set_plan4" class="full_input" value="<?php echo $setting['vipplan4']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['vset5']; ?></p>
						<input id="set_plan5" class="full_input" value="<?php echo $setting['vipplan5']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo 'Feature list'; ?></p>
						<textarea id="set_feature" class="full_textarea large_textarea" type="text" spellcheck="false"><?php echo $setting['vipfeature']; ?></textarea>
					</div>
				</div>
				<div class="form_control">
					<button data="vip" type="button" class="save_admin tmargin10 reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
		<div id="vip_manage" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="vpad10">
					<button onclick="vipAddBox();" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['vip_add']; ?></button>
				</div>
				<div id="vip_search_user" class="vpad15">
					<div class="admin_search">
						<div class="admin_input bcell">
							<input class="full_input" placeholder="<?php echo $lang['search']; ?>" id="vip_user_find" type="text"/>
						</div>
						<div onclick="searchVipUser();" class="admin_search_btn default_btn">
							<i class="fa fa-search" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="page_element">
				<div id="vip_paid_listing">
				</div>
				<div class="centered_element vpad10 hidden">
					<p class="bold"><?php echo $lang['load_more']; ?></p>
				</div>
			</div>
		</div>
		<div id="vip_transaction" class="tab_zone hide_zone">
			<div class="page_element">
				<div id="vip_search_transaction">
					<div class="admin_search">
						<div class="admin_input bcell">
							<input class="full_input" placeholder="<?php echo $lang['search']; ?>" id="vip_find" type="text"/>
						</div>
						<div onclick="searchVip();" class="admin_search_btn default_btn">
							<i class="fa fa-search" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="page_element">
				<div id="vip_transaction_list">
				</div>
			</div>
		</div>
	</div>
	<div class="config_section">
		<script data-cfasync="false">
			vipWait = 0;
			searchVip = function(){
				$.post('system/action/action_vip.php', {
					search_vip: $('#vip_find').val(),
					token: utk,
					}, function(response) {
						$('#vip_transaction_list').html(response);
				});	
			}
			vipAddBox = function(){
				$.post('system/box/vip_add.php', {
					token: utk,
					}, function(response) {
						showModal(response);
				});	
			}
			searchVipUser = function(){
				$.post('system/action/action_vip.php', {
					vip_search_user: $('#vip_user_find').val(),
					token: utk,
					}, function(response) {
						$('#vip_paid_listing').html(response);
				});	
			}
			vipCancelPlan = function(vip){
				$.post('system/box/vip_cancel.php', {
					vip_cancel: vip,
					token: utk,
					}, function(response) {
						showModal(response,400);
				});
			}
			vipConfirmCancel = function(vip){
				$.post('system/action/action_vip.php', {
					vip_cancel: vip,
					token: utk,
					}, function(response) {
						if(response == 1){
							hideModal();
							callSuccess(system.actionComplete);
							$('#pvip'+vip).replaceWith("");
						}
				});
			}
			vipLoadList = function(){
				$.post('system/action/action_vip.php', {
					vip_load_list: 1,
					token: utk,
					}, function(response) {
						$('#vip_user_find').val('');
						$('#vip_paid_listing').html(response);
				});
			}
			vipLoadTransaction = function(){
				$.post('system/action/action_vip.php', {
					load_transaction: 1,
					token: utk,
					}, function(response) {
						$('#vip_find').val('');
						$('#vip_transaction_list').html(response);
				});
			}
			vipDetails = function(id){
				$.post('system/box/vip_details.php', {
					tdetails: id,
					token: utk,
					}, function(response) {
						if(response == 0){
							callError(system.error);
						}
						else {
							showModal(response, 500);
						}
				});	
			}
			vipWait = 0;
			addVipData = function(){
				if(vipWait == 0){
					vipWait = 1;
					$.post('system/action/action_vip.php', {
						vip_add: 1,
						vip_user: $('#set_vip_name').val(),
						vip_plan: $('#set_vip_plan').val(),
						token: utk,
						}, function(response) {
							vipWait = 0;
							if(response == 2){
								callError(system.noUser);
							}
							else if(response == 3){
								callError(system.cannotUser);
							}
							else if(response.indexOf("pvip") >= 1){
								hideModal();
								callSuccess(system.actionComplete);
								if($('.vipuserelem:visible').length){
									$('#vip_paid_listing').prepend(response);
								}
								else {
									$('#vip_paid_listing').html(response);
								}
							}
							else {
								callError(system.error);
							}
					});	
				}
			}
		</script>
	</div>
</div>
