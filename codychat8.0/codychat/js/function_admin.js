removeAddons = function(item, aname){
	$(item).hide();
	$(item).parent().children('.work_button').show();
	$(item).parent().children('.config_addons').hide();
	$.post('system/action/system_addons.php', {
		remove_addons: 1,
		addons: aname,
		}, function(response) {
			loadLob('admin/setting_addons.php');
	});	
}
configAddons = function(aname){
	$.post('addons/'+aname+'/system/config.php', {
		addons: aname,
		}, function(response) {
			loadWrap(response);
	});	
}
addWord = function(t, z, i){
	$.post('system/action/action_filter.php', {
		add_word: $('#'+i).val(),
		type: t,
		}, function(response) {
			if(response == 0){
				callError(system.dataExist)
			}
			else if(response == 2){
				callError(system.emptyField);
			}
			else if(response == 99){
				callError(registerKey);
			}
			else {
				$('#'+z+' .empty_zone').replaceWith("");
				$('#'+z).prepend(response);
			}
			$('#'+i).val('');
	});	
}
deleteWord = function(t, id){
	$.post('system/action/action_filter.php', {
		delete_word: id,
		}, function(response) {
			if(response == 1){
				$(t).parent().replaceWith("");
			}
			else {
				callError(system.error);
			}
	});	
}
openModCat = function(){
	$.post('system/box/mod_cat.php', {
		}, function(response) {
			showModal(response, 400);
	});	
}
openAddPlayer = function(){
	$.post('system/box/add_player.php', {
		}, function(response) {
			showModal(response, 500);
	});	
}
addPlayer = function(){
	var playerAlias = $('#add_stream_alias').val();
	var playerUrl = $('#add_stream_url').val();
	$.post('system/action/action_player.php', {
		stream_alias: playerAlias,
		stream_url: playerUrl,
		}, function(response) {
			if(response == 1){
				hideModal();
				loadLob('admin/setting_player.php');
			}
			else if(response == 2){
				callError(system.emptyField);
			}
			else {
				callError(system.error);
			}
	});	
}
pinRoom = function(id){
	$.post('system/action/action_rooms.php', {
		pin_room: id,
		}, function(response) {
			if(response == 1){
				$('#pinned'+id).addClass('success');
			}
			else if(response == 99){
				$('#pinned'+id).removeClass('success');
			}
			else {
				callError(system.error);
			}
	});
}
saveRoomAdmin = function(){
	$.post('system/action/action_rooms.php', {
		admin_set_room_id: $('#admin_save_room').attr('data'),
		admin_set_room_name: $('#set_room_name').val(),
		admin_set_room_description: $('#set_room_description').val(),
		admin_set_room_password: $('#set_room_password').val(),
		admin_set_room_player: $('#set_room_player').val(),
		admin_set_room_access: $('#set_room_access').val(),

		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
				loadLob('admin/setting_rooms.php');
			}
			else if(response == 2){
				callError(system.roomExist);
			}
			else if(response == 4){
				callError(system.roomName);
			}
			else {
				callError(system.error);
			}
	});	
}
saveModCat = function(){
	boomDelay(function() {
		$.post('system/action/system_save.php', { 
			save_admin_modcat: 1,
			set_mod_sexual: $('#set_mod_sexual').attr('data'),
			set_mod_hate: $('#set_mod_hate').attr('data'),
			set_mod_harassment: $('#set_mod_harassment').attr('data'),
			set_mod_illicit: $('#set_mod_illicit').attr('data'),
			set_mod_violence: $('#set_mod_violence').attr('data'),
			}, function(response) {
		});	
	}, 500);
}
saveAdminRegistration = function(){
	$.post('system/action/system_save.php', { 
		save_admin_registration: 1,
		set_registration: $('#set_registration').val(),
		set_max_reg: $('#set_max_reg').val(),
		set_activation: $('#set_activation').val(),
		set_max_username: $('#set_max_username').val(),
		set_min_age: $('#set_min_age').val(),
		set_coppa: $('#set_coppa').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminRegAction = function(){
	$.post('system/action/system_save.php', { 
		save_admin_registration_act: 1,
		set_reg_act: $('#set_reg_act').val(),
		set_reg_delay: $('#set_reg_delay').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminMain = function(){
	$.post('system/action/system_save.php', { 
		save_admin_main: 1,
		set_index_path: $('#set_index_path').val(),
		set_title: $('#set_title').val(),
		set_timezone: $('#set_timezone').val(),
		set_default_language: $('#set_default_language').val(),
		set_site_description: $('#set_site_description').val(),
		set_site_keyword: $('#set_site_keyword').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 2){
				location.reload();
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminApp = function(){
	$.post('system/action/system_save.php', { 
		save_admin_app: 1,
		set_use_app: $('#set_use_app').val(),
		set_app_name: $('#set_app_name').val(),
		set_app_color: $('#set_app_color').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminMaintenance = function(){
	$.post('system/action/system_save.php', { 
		save_admin_maintenance: 1,
		set_maint_mode: $('#set_maint_mode').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 2){
				location.reload();
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminWallet = function(){
	$.post('system/action/system_save.php', { 
		save_admin_wallet: 1,
		set_use_wallet: $('#set_use_wallet').val(),
		set_can_swallet: $('#set_can_swallet').val(),
		set_can_gold: $('#set_can_gold').val(),
		set_gold_delay: $('#set_gold_delay').val(),
		set_gold_base: $('#set_gold_base').val(),
		set_can_ruby: $('#set_can_ruby').val(),
		set_ruby_delay: $('#set_ruby_delay').val(),
		set_ruby_base: $('#set_ruby_base').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 2){
				location.reload();
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminGift = function(){
	$.post('system/action/system_save.php', { 
		save_admin_gift: 1,
		set_use_gift: $('#set_use_gift').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminLevel = function(){
	$.post('system/action/system_save.php', { 
		save_admin_level: 1,
		set_use_level: $('#set_use_level').val(),
		set_level_mode: $('#set_level_mode').val(),
		set_exp_chat: $('#set_exp_chat').val(),
		set_exp_priv: $('#set_exp_priv').val(),
		set_exp_post: $('#set_exp_post').val(),
		set_exp_gift: $('#set_exp_gift').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 2){
				location.reload();
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminBadge = function(){
	$.post('system/action/system_save.php', { 
		save_admin_badge: 1,
		set_use_badge: $('#set_use_badge').val(),
		set_bachat: $('#set_bachat').val(),
		set_bagift: $('#set_bagift').val(),
		set_balike: $('#set_balike').val(),
		set_bafriend: $('#set_bafriend').val(),
		set_baruby: $('#set_baruby').val(),
		set_bagold: $('#set_bagold').val(),
		set_babeat: $('#set_babeat').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 2){
				location.reload();
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminData = function(){
	$.post('system/action/system_save.php', { 
		save_admin_data: 1,
		set_max_avatar: $('#set_max_avatar').val(),
		set_max_cover: $('#set_max_cover').val(),
		set_max_ricon: $('#set_max_ricon').val(),
		set_max_file: $('#set_max_file').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminPlayer = function(){
	$.post('system/action/system_save.php', { 
		save_admin_player: 1,
		set_default_player: $('#set_default_player').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 2){
				callSuccess(system.saved);
				loadLob('admin/setting_player.php');
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminEmail = function(){
	$.post('system/action/system_save.php', { 
		save_admin_email: 1,
		set_mail_type: $('#set_mail_type').val(),
		set_site_email: $('#set_site_email').val(),
		set_email_from: $('#set_email_from').val(),
		set_smtp_host: $('#set_smtp_host').val(),
		set_smtp_username: $('#set_smtp_username').val(),
		set_smtp_password: $('#set_smtp_password').val(),
		set_smtp_port: $('#set_smtp_port').val(),
		set_smtp_type: $('#set_smtp_type').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminCache = function(){
	$.post('system/action/system_save.php', { 
		save_admin_cache: 1,
		set_redis_status: $('#set_redis_status').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
				loadLob('admin/setting_cache.php');
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminGuest = function(){
	$.post('system/action/system_save.php', { 
		save_admin_guest: 1,
		set_allow_guest: $('#set_allow_guest').val(),
		set_max_greg: $('#set_max_greg').val(),
		set_guest_form: $('#set_guest_form').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminDisplay = function(){
	$.post('system/action/system_save.php', { 
		save_admin_display: 1,
		set_main_theme: $('#set_main_theme').val(),
		set_login_page: $('#set_login_page').val(),
		set_use_gender: $('#set_use_gender').val(),
		set_use_flag: $('#set_use_flag').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 2){
				location.reload();
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminBridge = function(){
	$.post('system/action/system_save.php', { 
		save_admin_bridge: 1,
		set_use_bridge: $('#set_use_bridge').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else if(response == 404){
				callError(system.noBridge);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminUserPermission = function(){
	$.post('system/action/system_save.php', { 
		save_admin_user_permission: 1,
		set_allow_avatar: $('#set_allow_avatar').val(),
		set_allow_cover: $('#set_allow_cover').val(),
		set_allow_gcover: $('#set_allow_gcover').val(),
		set_allow_cupload: $('#set_allow_cupload').val(),
		set_allow_pupload: $('#set_allow_pupload').val(),
		set_allow_wupload: $('#set_allow_wupload').val(),
		set_allow_video: $('#set_allow_video').val(),
		set_allow_audio: $('#set_allow_audio').val(),
		set_allow_zip: $('#set_allow_zip').val(),
		set_allow_main: $('#set_allow_main').val(),
		set_allow_private: $('#set_allow_private').val(),
		set_allow_quote: $('#set_allow_quote').val(),
		set_allow_pquote: $('#set_allow_pquote').val(),
		set_emo_plus: $('#set_emo_plus').val(),
		set_allow_direct: $('#set_allow_direct').val(),
		set_allow_room: $('#set_allow_room').val(),
		set_allow_vroom: $('#set_allow_vroom').val(),
		set_allow_theme: $('#set_allow_theme').val(),
		set_allow_history: $('#set_allow_history').val(),
		set_allow_colors: $('#set_allow_colors').val(),
		set_allow_grad: $('#set_allow_grad').val(),
		set_allow_neon: $('#set_allow_neon').val(),
		set_allow_font: $('#set_allow_font').val(),
		set_allow_name_color: $('#set_allow_name_color').val(),
		set_allow_name_grad: $('#set_allow_name_grad').val(),
		set_allow_name_neon: $('#set_allow_name_neon').val(),
		set_allow_name_font: $('#set_allow_name_font').val(),
		set_allow_name: $('#set_allow_name').val(),
		set_allow_mood: $('#set_allow_mood').val(),
		set_allow_about: $('#set_allow_about').val(),
		set_allow_report: $('#set_allow_report').val(),
		set_allow_scontent: $('#set_allow_scontent').val(),
		set_allow_rnews: $('#set_allow_rnews').val(),
		set_word_proof: $('#set_word_proof').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminStaffPermission = function(){
	$.post('system/action/system_save.php', { 
		save_admin_staff_permission: 1,
		set_can_raction: $('#set_can_raction').val(),
		set_can_mute: $('#set_can_mute').val(),
		set_can_warn: $('#set_can_warn').val(),
		set_can_kick: $('#set_can_kick').val(),
		set_can_ghost: $('#set_can_ghost').val(),
		set_can_ban: $('#set_can_ban').val(),
		set_can_delete: $('#set_can_delete').val(),
		set_can_modavat: $('#set_can_modavat').val(),
		set_can_modcover: $('#set_can_modcover').val(),
		set_can_modmood: $('#set_can_modmood').val(),
		set_can_modabout: $('#set_can_modabout').val(),
		set_can_modcolor: $('#set_can_modcolor').val(),
		set_can_modname: $('#set_can_modname').val(),
		set_can_auth: $('#set_can_auth').val(),
		set_can_modemail: $('#set_can_modemail').val(),
		set_can_modpass: $('#set_can_modpass').val(),
		set_can_modblock: $('#set_can_modblock').val(),
		set_can_modvpn: $('#set_can_modvpn').val(),
		set_can_verify: $('#set_can_verify').val(),
		set_can_note: $('#set_can_note').val(),
		set_can_vip: $('#set_can_vip').val(),
		set_can_vemail: $('#set_can_vemail').val(),
		set_can_vghost: $('#set_can_vghost').val(),
		set_can_vother: $('#set_can_vother').val(),
		set_can_vname: $('#set_can_vname').val(),
		set_can_vhistory: $('#set_can_vhistory').val(),
		set_can_vwallet: $('#set_can_vwallet').val(),
		set_can_news: $('#set_can_news').val(),
		set_can_rank: $('#set_can_rank').val(),
		set_can_inv: $('#set_can_inv').val(),
		set_can_cuser: $('#set_can_cuser').val(),
		set_can_content: $('#set_can_content').val(),
		set_can_clear: $('#set_can_clear').val(),
		set_can_rpass: $('#set_can_rpass').val(),
		set_can_bpriv: $('#set_can_bpriv').val(),
		set_can_topic: $('#set_can_topic').val(),
		set_can_maddons: $('#set_can_maddons').val(),
		set_can_mroom: $('#set_can_mroom').val(),
		set_can_mfilter: $('#set_can_mfilter').val(),
		set_can_dj: $('#set_can_dj').val(),
		set_can_mip: $('#set_can_mip').val(),
		set_can_mlogs: $('#set_can_mlogs').val(),
		set_can_mplay: $('#set_can_mplay').val(),
		set_can_mcontact: $('#set_can_mcontact').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminRoomPermission = function(){
	$.post('system/action/system_save.php', { 
		save_admin_room_permission: 1,
		set_can_rlogs: $('#set_can_rlogs').val(),
		set_can_rclear: $('#set_can_rclear').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminDelays = function(){
	$.post('system/action/system_save.php', { 
		save_admin_delays: 1,
		set_act_delay: $('#set_act_delay').val(),
		set_chat_delete: $('#set_chat_delete').val(),
		set_private_delete: $('#set_private_delete').val(),
		set_wall_delete: $('#set_wall_delete').val(),
		set_member_delete: $('#set_member_delete').val(),
		set_room_delete: $('#set_room_delete').val(),
		set_ignore_delete: $('#set_ignore_delete').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminCall = function(){
	$.post('system/action/system_save.php', { 
		save_admin_call: 1,
		set_use_call: $('#set_use_call').val(),
		set_can_vcall: $('#set_can_vcall').val(),
		set_can_acall: $('#set_can_acall').val(),
		set_call_appid: $('#set_call_appid').val(),
		set_call_secret: $('#set_call_secret').val(),
		set_live_url: $('#set_live_url').val(),
		set_live_appid: $('#set_live_appid').val(),
		set_live_secret: $('#set_live_secret').val(),
		set_call_max: $('#set_call_max').val(),
		set_call_method: $('#set_call_method').val(),
		set_call_cost: $('#set_call_cost').val(),
		set_can_cgcall: $('#set_can_cgcall').val(),
		set_can_gcall: $('#set_can_gcall').val(),
		set_can_mgcall: $('#set_can_mgcall').val(),
		set_max_gcall: $('#set_max_gcall').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminModules = function(){
	$.post('system/action/system_save.php', { 
		save_admin_modules: 1,
		set_use_like: $('#set_use_like').val(),
		set_use_wall: $('#set_use_wall').val(),
		set_use_lobby: $('#set_use_lobby').val(),
		set_cookie_law: $('#set_cookie_law').val(),
		set_use_geo: $('#set_use_geo').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminChat = function(){
	$.post('system/action/system_save.php', { 
		save_admin_chat: 1,
		set_room_count: $('#set_room_count').val(),
		set_max_main: $('#set_max_main').val(),
		set_max_private: $('#set_max_private').val(),
		set_max_offcount: $('#set_max_offcount').val(),
		set_privload: $('#set_privload').val(),
		set_speed: $('#set_speed').val(),
		set_max_emo: $('#set_max_emo').val(),
		set_max_room: $('#set_max_room').val(),
		set_log_join: $('#set_log_join').val(),
		set_log_name: $('#set_log_name').val(),
		set_log_action: $('#set_log_action').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminSecurity = function(){
	$.post('system/action/system_save.php', { 
		save_admin_security: 'security_registration',
		set_use_recapt: $('#set_use_recapt').val(),
		set_recapt_key: $('#set_recapt_key').val(),
		set_recapt_secret: $('#set_recapt_secret').val(),
		set_use_vpn: $('#set_use_vpn').val(),
		set_vpn_key: $('#set_vpn_key').val(),
		set_vpn_delay: $('#set_vpn_delay').val(),
		set_flood_action: $('#set_flood_action').val(),
		set_flood_delay: $('#set_flood_delay').val(),
		set_max_flood: $('#set_max_flood').val(),
		set_use_rate: $('#set_use_rate').val(),
		set_rate_limit: $('#set_rate_limit').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
saveAdminAi = function(){
	$.post('system/action/system_save.php', { 
		save_admin_ai: 1,
		set_openai_key: $('#set_openai_key').val(),
		set_img_mod: $('#set_img_mod').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
testMail = function(target){
	$.post('system/action/system_save.php', {
		test_mail: 1,
		test_email: $('#test_email').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.actionComplete);
			}
			else {
				callError(system.error);
			}
			hideModal();
	});
}
deleteRoom = function(item, id){
	$.post('system/action/action_rooms.php', {
		delete_room: id,
		}, function(response) {
			if(response == 1){
				$(item).parent().replaceWith("");
			}
			else {
				callError(system.error);
			}
	});	
}
editRoom = function(id){
	$.post('system/box/edit_room.php', {
		edit_room: id,
		}, function(response) {
			showModal(response, 500);
	});	
}
editGift = function(id){
	$.post('system/box/edit_gift.php', {
		edit_gift: id,
		}, function(response) {
			showModal(response, 500);
	});	
}
openTestMail = function(target){
	$.post('system/box/test_mail.php', {
		}, function(response) {
			showModal(response);
	});
}
savePlayer = function(id){
	$.post('system/action/action_player.php', {
		new_stream_url: $('#new_stream_url').val(),
		new_stream_alias: $('#new_stream_alias').val(),
		player_id: id,
		}, function(response) {
			if(response == 1){
				hideModal();
				callSuccess(system.saved);
				loadLob('admin/setting_player.php');
			}
			else {
				callError(system.error);
			}
	});	
}
moreAdminSearch = function(ct){
	var lct = $('#search_admin_list .sub_list_item:last').attr('id');
	lastCt = lct.replace('found', '');	
	$.post('system/action/action_search.php', {
		more_search_critera: ct,
		last_critera: lastCt,
		}, function(response) {
			if(response == 0){
				$('#search_for_more').replaceWith("");
			}
			else {
				$('#search_admin_list').append(response);
			}
	});
	
}
roomAdmin = 0;
addAdminRoom = function(){
	if(roomAdmin == 0){
		roomAdmin = 1;
		$.post('system/action/action_rooms.php', { 
			admin_add_room: 1,
			admin_set_name: $("#set_room_name").val(),
			admin_set_type: $("#set_room_type").val(),
			admin_set_pass: $("#set_room_password").val(),
			admin_set_description: $("#set_room_description").val(),
			admin_set_ricon: $('#set_room_icon').attr('data'),
			}, function(response) {
				if(response == 0 || response == 1){
					callError(system.error);
				}
				else if (response == 2){
					callError(system.roomName);
				}
				else if (response == 6){
					callError(system.roomExist);
				}
				else {
					$('#room_listing').prepend(response);
					hideModal();
				}
				roomAdmin = 0;
		});
	}
	else {
		return false;
	}	
}
adminCreateRoom = function(){
	$.post('system/box/admin_create_room.php', {
		}, function(response) {
			showModal(response);
	});
}
deletePlayer = function(id, item){
	$.post('system/action/action_player.php', {
		delete_player: id,
		}, function(response) {
			if(response == 1){
				$(item).parent().replaceWith("");
			}
			else if(response == 2){
				loadLob('admin/setting_player.php');
			}
			else {
				callError(system.error);
			}
	});	
}
editPlayer = function(id){
	$.post('system/box/edit_player.php', {
		edit_player: id,
		}, function(response) {
			showModal(response, 500);
	});	
}
createUser = function(){
	$.post('system/box/create_user.php', {
		}, function(response) {
			showModal(response, 500);
	});	
}
waitCreate = 0;
addNewUser = function(){
	if(waitCreate == 0){
		waitCreate = 1;
		$.post('system/action/action_users.php', {
			create_user: 1,
			create_name: $('#set_create_name').val(),
			create_password: $('#set_create_password').val(),
			create_email: $('#set_create_email').val(),
			create_gender: $('#set_create_gender').val(),
			create_age: $('#set_create_age').val(),
			}, function(response) {
				if(response == 5){
					callError(system.invalidEmail);
				}
				else if(response == 6){
					callError(system.emailExist);
				}
				else if(response == 4){
					callError(system.usernameExist);
				}
				else if(response == 3){
					callError(system.invalidUsername);
				}
				else if(response == 2){
					callError(system.emptyField);
				}
				else if(response == 13){
					callError(system.ageRequirement);
				}
				else if (response == 1){
					callSuccess(system.saved);
					hideModal();
					loadLob('admin/setting_members.php');
				}
				waitCreate = 0;
		});
	}
}
savePageData = function(p, c){
	$.post('system/action/system_save.php', {
		page_content: $('#'+c).val(),
		page_target: p,
		save_page: 1,
		}, function(response) {
			callSuccess(system.saved);
	});	
}
flushCache = function(){
	$.post('system/action/system_save.php', {
		flush_cache: 1,
		}, function(response) {
			if(response == 1){
				callSuccess(system.actionComplete);
			}
	});	
}
reloadSystemConsole = function(){
	var systemConsoleState = $('#search_system_console').val();
	if($('#console_logs_box:visible').length && systemConsoleState == ''){
		var lastConsole = 0;
		if($('.console_item').length > 0){
			lastConsole = $('#console_results .console_item:first').attr('value');
		}
		$.post('system/action/system_console.php', {
			reload_console: lastConsole,
			}, function(response) {
				if(response == 0){
					return false;
				}
				else {
					$('#console_results .empty_zone').replaceWith("");
					$('#console_spinner').hide();
					$('#console_results').prepend(response);
				}
		});
	}
}
clearConsole = function(){
	$.post('system/box/console_confirm.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 400);
			}
	});
}
clearSystemConsole = function(){
	$.post('system/action/system_console.php', {
		clear_console: 1,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				hideOver();
				$('#console_results').html('');
				reloadSystemConsole();
			}
	});
}
searchSystemConsole = function(){
	boomDelay(function() {
		$('#console_results').html('');
		$('#console_spinner').show();
		$.post('system/action/system_console.php', {
			search_console: $('#search_system_console').val(),
			}, function(response) {
				if(response == 0){
					return false;
				}
				else {
					$('#console_spinner').hide();
					$('#console_results').html(response);
				}
		});
	}, 1000);
}
addDj = function(){
	$.ajax({
		url: "system/action/action_dj.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			add_dj: $('#dj_name').val(),
		},
		success: function(response){
			if(response.code == 1){
				$('#dj_listing .empty_zone').replaceWith("");
				$('#dj_listing').prepend(response.data);
				$('#dj_name').val('');
			}
			else if(response.code == 2){
				callError(system.cannotUser);
			}
			else if(response.code == 4){
				callError(system.alreadyAction);
			}
			else {
				callError(system.error);
			}
		},
		error: function(){
			return false;
		}
	});
}
removeDj = function(id){
	$.post('system/action/action_dj.php', {
		remove_dj: id,
		}, function(response) {
			if(response == 1){
				$('#djuser'+id).replaceWith("");
			}
			else if(response == 2){
				callError(system.cannotUser);
			}
			else {
				callError(system.error);
			}
	});	
}
onAirUser = function(id){
	$.post('system/action/action_dj.php', {
		admin_onair: id,
		}, function(response) {
			if(response == 0){
				$('#dj'+id).removeClass('success');
			}
			else if(response == 1){
				$('#dj'+id).addClass('success');
			}
			else if(response == 2){
				callError(system.cannotUser);
			}
			else {
				callError(system.error);
			}
	});	
}
saveGift = function(id){
	$.ajax({
		url: "system/action/action_gift.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			save_gift: id,
			gift_title: $('#set_gift_title').val(),
			gift_rank: $('#set_gift_rank').val(),
			gift_method: $('#set_gift_method').val(),
			gift_cost: $('#set_gift_cost').val(),
		},
		success: function(response){
			if(response.code == 1){
				$('#agift'+id).replaceWith(response.data);
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
			hideModal();
		},
		error: function(){
			callError(system.error);
		}
	});
}
deleteGift = function(id){
	$.post('system/action/action_gift.php', { 
		delete_gift: id,
		}, function(response) {
			if(response == 1){
				$('#agift'+id).replaceWith("");
			}
			else {
				callError(system.error);
			}
			hideModal();
	});
}
var waitGift = 0;
addGift = function(){
	var file_data = $("#add_gift").prop("files")[0];
	var filez = ($("#add_gift")[0].files[0].size / 1024 / 1024).toFixed(2);
	if($("#add_gift").val() === ""){
		callError(system.noFile);
	}
	else {
		if(waitGift == 0){
			waitGift = 1;
			uploadIcon('ricon_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("add_gift", 1)
			form_data.append("token", utk)
			$.ajax({
				url: "system/action/action_gift.php",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(response){
					if(response.code == 1){
						callError(system.wrongFile);
					}
					else if(response.code == 5){
						$('#gift_list').prepend(response.data);
					}
					else {
						callError(system.error);
					}
					uploadIcon('ricon_icon', 2);
					waitGift = 0;
				},
				error: function(){
					callError(system.error);
					uploadIcon('ricon_icon', 2);
					waitGift = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}
setEmailFilter = function(){
	$.post('system/action/action_filter.php', {
		email_filter: $('#set_email_filter').val(),
		}, function(response) {
	});	
}
openWordAction = function(){
	$.post('system/box/action_word.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				showModal(response);
			}
	});	
}
openSpamAction = function(){
	$.post('system/box/action_spam.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				showModal(response);
			}
	});	
}
setWordAction = function(){
	$.post('system/action/action_filter.php', {
		word_action: $('#set_word_action').val(),
		word_delay: $('#set_word_delay').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
	});	
}
getCallInfo = function(id){
	$.post('system/box/call_info.php', {
			call_id: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				showModal(response);
			}
	});	
}
getGroupCallInfo = function(id){
	$.post('system/box/group_call_info.php', {
			call_id: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				showModal(response);
			}
	});	
}
adminCancelCall = function(id){
	$.post('system/action/action_scall.php', {
			admin_cancel: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				callSuccess(system.actionComplete);
				$('#admincall'+id).replaceWith(response);
				hideModal();
			}
	});	
}
reloadAdminCall = function(){
	$.post('system/action/action_scall.php', {
			reload_call: 1,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				$('#admin_calls').html(response);
			}
	});	
}
reloadAdminGroupCall = function(){
	$.post('system/action/action_scall.php', {
			reload_group_call: 1,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				$('#admin_group_calls').html(response);
			}
	});	
}
adminLoad = function(){
	$.post('system/action/system_save.php', {
		check: 1,
		}, function(response) {
			if(response == 1){
				activeLoad();
			}
	});	
}
activeLoad = function(){
	$.post('system/action/system_save.php', {
		active_load: 1,
		}, function(response) {
			showModal(response, 460);
	});	
}
setSpamAction = function(){
	$.post('system/action/action_filter.php', {
		spam_action: $('#set_spam_action').val(),
		spam_delay: $('#set_spam_delay').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
	});	
}

deleteGroupCall = function(id){
	$.post('system/action/action_group_call.php', { 
			delete_group_call: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				hideAllModal();
				$('#admingroupcall' + id).replaceWith("");
				$('#gcall' + id).replaceWith("");
				callSuccess(system.actionComplete);
			}
	});
}

/* document ready functions */

$(document).ready(function(){
	
	adminLoad();
	reloadSystemConsole();
	reloadConsoleLogs = setInterval(reloadSystemConsole, 4500);
	
	$(document).on('click', '.save_admin', function(){
		var saveAdmin = $(this).attr('data');
		saveSettings(saveAdmin);
	});

	$(document).on('click', '#admin_save_room', function(){
		saveRoomAdmin();
	});
	
	$(document).on('change', '#set_use_gift', function(){		
		saveAdminGift();
	});
	
	$(document).on('click', '#search_member', function(){
		validSearch = $('#member_to_find').val().length;
		if(validSearch >= 1){
			$.post('system/action/action_search.php', {
				search_member: $('#member_to_find').val(),
				}, function(response) {
					$('#member_list').html(response);
			});
		}
		else {
			callError(system.tooShort);
		}
	});

	$(document).on('change', '#member_critera', function(){
		var checkCritera = $(this).val();
		if(checkCritera == 1000){
			return false;
		}
		else {
			$.post('system/action/action_search.php', {
				search_critera: $(this).val(),
				}, function(response) {
					$('#member_list').html(response);
			});
		}
	});
	
	$(document).on('change', '#member_action', function(){
		var actionCritera = $(this).val();
		if(actionCritera == 1000){
			return false;
		}
		else {
			$.post('system/action/action_search.php', {
				search_action: $(this).val(),
				}, function(response) {
					$('#action_listing').html(response);
			});
		}
	});

	$(document).on('click', '.delete_ip', function(){
		var ipdel = $(this).attr('data');
		$.post('system/action/action_staff.php', {
			delete_ip: ipdel,
			}, function(response) {
				if(response == 1){
					$('#ipdel'+ipdel).replaceWith("");
				}
				else {
					callError(system.error);
				}
		});	
	});

	$(document).on('change, paste, keyup', '#search_ip', function(){
		var searchIp = $(this).val().toLowerCase();
		if(searchIp == ''){
			$(".ip_item").each(function(){
				$(this).show();
			});	
		}
		else {
			$(".ip_item").each(function(){
				var ipData = $(this).text().toLowerCase();
				if(ipData.indexOf(searchIp) < 0){
					$(this).hide();
				}
				else if(ipData.indexOf(searchIp) > 0){
					$(this).show();
				}
			});
		}
	});

	var addonsReply = 1;
	$(document).on('click', '.activate_addons', function(){
		$(this).hide();
		$(this).prev('.work_button').show();
		if(addonsReply == 1){
			addonsReply = 0;
			$.ajax({
				url: "system/action/system_addons.php",
				type: "post",
				cache: false,
				dataType: 'json',
				data: { 
					activate_addons: 1,
					addons: $(this).attr('data'),
				},
				success: function(response){
					if(response.code != 1){
						callError(response.error);
					}
					loadLob('admin/setting_addons.php');
					addonsReply = 1;
				},
				error: function(){
					loadLob('admin/setting_addons.php');
					addonsReply = 1;
				}
			});
	
		}
		else {
			return false;
		}
	});
	$(document).on('change, paste, keyup', '#search_admin_room', function(){
		var searchRoom = $(this).val().toLowerCase();
		if(searchRoom == ''){
			$(".room_item").each(function(){
				$(this).show();
			});	
		}
		else {
			$(".room_item").each(function(){
				var roomData = $(this).text().toLowerCase();
				if(roomData.indexOf(searchRoom) < 0){
					$(this).hide();
				}
				else if(roomData.indexOf(searchRoom) > 0){
					$(this).show();
				}
			});
		}
	});
	
	var waitUpdate = 1;
	$(document).on('click', '.update_system', function(){
		if(waitUpdate == 1){
			waitUpdate = 0;
			$(this).hide();
			$(this).prev('.work_button').show();
			$.ajax({
				url: "system/action/system_update.php",
				type: "post",
				cache: false,
				dataType: 'json',
				data: { 
					version_install: $(this).attr('data'),
				},
				success: function(response){
					if(response.code == 2){
						location.reload();
					}
					else {
						callError(response.error);
					}
					loadLob('admin/setting_update.php');
					waitUpdate = 1;
				},
				error: function(){
					loadLob('admin/setting_update.php');
					waitUpdate = 1;
				}
			});
		}
		else {
			return false;
		}
	});
   
});