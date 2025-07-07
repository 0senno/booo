editUser = function(id){
	$.post('system/box/admin_user.php', {
		edit_user: id,
		}, function(response) {
			if(response == 99){
				callError(system.cantModifyUser);
			}
			else {
				showEmptyModal(response, 580);
			}
	});	
}
adminSaveEmail = function(id){
	$.post('system/action/action_users.php', { 
		set_user_id: id,
		set_user_email: $('#set_user_email').val(),
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
				callSuccess(system.saved);
				hideOver();
			}
			else if(response == 2){
				callError(system.emailExist);
			}
			else if(response == 3){
				callError(system.invalidEmail);
			}
			else {
				callError(system.error);
			}
	});		
}
adminSaveAbout = function(id){
	$.post('system/action/action_users.php', { 
		target_about: id,
		set_user_about: $('#admin_user_about').val(),
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
				callSuccess(system.saved);
				hideOver();
			}
			else if(response == 2){
				callError(system.restrictedContent);
			}
			else {
				callError(system.error);
			}
	});		
}
adminSaveNote = function(id){
	$.post('system/action/action_staff.php', { 
		target: id,
		user_note: $('#set_user_note').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});		
}
adminChangeName = function(u){
	$.post('system/box/admin_edit_name.php', { 
		target: u,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response);
			}
	});
}
adminChangeMood = function(u){
	$.post('system/box/admin_edit_mood.php', { 
		target: u,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response);
			}
	});
}
adminSaveName = function(u){
	var myNewName = $('#new_user_username').val();
	$.post('system/action/action_users.php', { 
		target_id: u,
		user_new_name: myNewName,
		}, function(response) {
			if(response == 1){
				$('#pro_admin_name').text(myNewName);
				hideOver();
			}
			else if(response == 2){
				callError(system.invalidUsername);
				$('#new_user_username').val('');
			}
			else if(response == 3){
				callError(system.usernameExist);
				$('#new_user_username').val();
			}
			else {
				callError(system.error);
				hideOver();
			}
	});
}
adminSaveMood = function(u){
	$.post('system/action/action_users.php', { 
		target_id: u,
		user_new_mood: $('#new_user_mood').val(),
		}, function(response) {
			if(response == 0){
				callError(system.error);
				hideOver();
			}
			else if(response == 2){
				callError(system.restrictedContent);
			}
			else {
				callSuccess(system.saved);
				hideOver();
			}
	});
}
adminSavePassword = function(u){
	$.post('system/action/action_users.php', { 
		target_id: u,
		user_new_password: $('#new_user_password').val(),
		}, function(response) {
			if(response == 0){
				callError(system.error);
				hideOver();
			}
			else if(response == 2){
				callError(system.invalidPass);
			}
			else {
				callSuccess(system.actionComplete);
				hideOver();
			}
	});
}
adminSaveBlock = function(){
	boomDelay(function() {
		$.ajax({
			url: "system/action/action_users.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				target: $('#set_ublock').attr('value'),
				set_bupload: $('#set_bupload').attr('data'),
				set_bnews: $('#set_bnews').attr('data'),
				set_bcall: $('#set_bcall').attr('data'),
			},
			success: function(response){
				
			},
			error: function(){
				return false;
			}
		});
	}, 500);
}
adminGetEmail = function(u){
	$.post('system/box/admin_edit_email.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
adminGetRank = function(u){
	$.post('system/box/admin_edit_rank.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
adminUserColor = function(u){
	$.post('system/box/admin_edit_color.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
adminUserAbout = function(u){
	$.post('system/box/admin_edit_about.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 500);
			}
	});
}
adminUserPassword = function(u){
	$.post('system/box/admin_edit_password.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 500);
			}
	});
}
adminUserWhitelist = function(u){
	$.post('system/box/admin_edit_whitelist.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 400);
			}
	});
}
adminUserBlock = function(u){
	$.post('system/box/admin_edit_block.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 400);
			}
	});
}
adminUserVerify = function(u){
	$.post('system/box/admin_edit_verify.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
adminUserAuth = function(u){
	$.post('system/box/admin_edit_auth.php', {
		target: u,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
changeRank = function(t, target){
	$.post('system/action/action_users.php', {
		change_rank: $(t).val(),
		target: target,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
				callSuccess(system.saved);
				if($('#mprofilemenu:visible').length){
					getProfile(target);
				}
			}
			else {
				callError(system.error);
			}
			hideOver();
	});
}
changeUserVerify = function(target){
	$.post('system/action/action_users.php', {
		verify_member: target,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
				callSuccess(system.actionComplete);
			}
			else {
				callError(system.error);
			}
			hideOver();
	});
}
authUser = function(target){
	$.post('system/action/action_users.php', {
		auth_member: target,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
				callSuccess(system.actionComplete);
			}
			else {
				callError(system.error);
			}
			hideOver();
	});
}
changeUserVpn = function(t, target){
	$.post('system/action/action_users.php', {
		set_user_vpn: $(t).val(),
		target: target,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
			hideOver();
	});
}
banBox = function(id){
	$.post('system/box/ban.php', {
		ban: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
kickBox = function(id){
	$.post('system/box/kick.php', {
		kick: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
muteBox = function(id){
	$.post('system/box/mute.php', {
		mute: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
warnBox = function(id){
	$.post('system/box/warn.php', {
		warn: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
ghostBox = function(id){
	$.post('system/box/ghost.php', {
		ghost: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
mainMuteBox = function(id){
	$.post('system/box/mute_main.php', {
		mute: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
privateMuteBox = function(id){
	$.post('system/box/mute_private.php', {
		mute: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
getHistory = function(id){
	$.post('system/box/admin_history.php', {
		target:id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response, 460);
			}
	});
}
getWallet = function(id){
	$.post('system/box/admin_wallet.php', {
		target:id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response, 340);
			}
	});
}
removeHistory = function(target, id){
	$.post('system/action/action_staff.php', {
		remove_history: id,
		target: target,
		}, function(response) {
			if(response == 1){
				$('.hist'+id).replaceWith("");
			}
			else {
				callError(system.error);
			}
	});
}
kickUser = function(target){
	$.post('system/action/action.php', {
		kick: target,
		delay: $('#kick_delay').val(),
		reason: $('#kick_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
banUser = function(target){
	$.post('system/action/action.php', {
		ban: target,
		reason: $('#ban_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
warnUser = function(target){
	$.post('system/action/action.php', {
		warn: target,
		reason: $('#warn_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
muteUser = function(target){
	$.post('system/action/action.php', {
		mute: target,
		delay: $('#mute_delay').val(),
		reason: $('#mute_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
ghostUser = function(target){
	$.post('system/action/action.php', {
		ghost: target,
		delay: $('#ghost_delay').val(),
		reason: $('#ghost_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
mainMuteUser = function(target){
	$.post('system/action/action.php', {
		main_mute: target,
		delay: $('#mute_delay').val(),
		reason: $('#mute_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
privateMuteUser = function(target){
	$.post('system/action/action.php', {
		private_mute: target,
		delay: $('#mute_delay').val(),
		reason: $('#mute_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
eraseAccount = function(target){
	$.post('system/box/delete_account.php', {
		account: target,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response);
			}
	});
}
confirmDelete = function(target){
	$.post('system/action/action_users.php', {
		delete_user_account: target,
		}, function(response) {
			hideOver();
			hideModal();
			if(response == 1){
				callSuccess(system.actionComplete);
				$('#found'+target).replaceWith("");
			}
			else {
				callError(system.cannotUser);
			}
	});
}
removeSystemAction = function(elem, u, t){
	$.post('system/action/action.php', {
		target: u,
		take_action: t,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				$(elem).parent().replaceWith("");
			}
	});	
}
getConsole = function(){
	$.post('system/box/console.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				showModal(response, 500);
			}
	});
}
sendConsole = function(){
	var console = $('#console_content').val();
	$.post('system/action/console.php', {
		run_console: console,
		}, function(response) {
			if(response == 1){
				callSuccess(system.confirmedCommand);
			}
			else if(response == 2){
				callError(system.invalidCommand);
			}
			else if(response == 3){
				callError(system.error);
			}
			else if(response == 4){
				callError(system.noUser);
			}
			else if(response == 5){
				callError(system.cannotUser);
			}
			else if(response == 6){
				location.reload();
			}
			else {
				callError(system.invalidCommand);
			}
			$('#console_content').val('');
	});
}

var waitAdminAvatar = 0;
adminUploadAvatar = function(id){
	var file_data = $("#admin_avatar_image").prop("files")[0];
	var filez = ($("#admin_avatar_image")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > avatarMax ){
		callError(system.fileBig);
	}
	else if($("#admin_avatar_image").val() === ""){
		callError(system.noFile);
	}
	else {
		if(waitAdminAvatar == 0){
			waitAdminAvatar = 1;
			uploadIcon('avat_admin', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("target", id)
			form_data.append("token", utk)
			$.ajax({
				url: "system/action/avatar.php",
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
					else if(response.code == 9){
						callError(system.fileBlocked);
					}
					else if(response.code == 5){
						$('.avatar_profile').attr('src', response.data);
						$('.avatar_profile').attr('href', response.data);
					}
					else {
						callError(system.error);
					}
					uploadIcon('avat_admin', 2);
					waitAdminAvatar = 0;
				},
				error: function(){
					callError(system.error);
					uploadIcon('avat_admin', 2);
					waitAdminAvatar = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}

var adminWaitCover = 0;
adminUploadCover = function(id){
	var file_data = $("#admin_cover_file").prop("files")[0];
	var filez = ($("#admin_cover_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > coverMax ){
		callError(system.fileBig);
	}
	else if($("#admin_cover_file").val() === ""){
		callError(system.noFile);
	}
	else {
		if(adminWaitCover == 0){
			adminWaitCover = 1;
			uploadIcon('admin_cover_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("target", id)
			form_data.append("token", utk)
			$.ajax({
				url: "system/action/cover.php",
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
					else if(response.code == 9){
						callError(system.fileBlocked);
					}
					else if(response.code == 5){
						addCover(response.data);
					}
					else {
						callError(system.error);
					}
					uploadIcon('admin_cover_icon', 2);
					adminWaitCover = 0;
				},
				error: function(){
					callError(system.error);
					uploadIcon('admin_cover_icon', 2);
					adminWaitCover = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}

var waitIcon = 0;
adminRoomIcon = function(id){
	var file_data = $("#ricon_image").prop("files")[0];
	var filez = ($("#ricon_image")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > riconMax ){
		callError(system.fileBig);
	}
	else if($("#ricon_image").val() === ""){
		callError(system.noFile);
	}
	else {
		if(waitIcon == 0){
			waitIcon = 1;
			uploadIcon('ricon_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("staff_add_icon", id)
			form_data.append("token", utk)
			$.ajax({
				url: "system/action/room_icon.php",
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
						$('.ricon_current').attr('src', response.data);
						$('#ricon'+id).attr('src', response.data);
					}
					else {
						callError(system.error);
					}
					uploadIcon('ricon_icon', 2);
					waitIcon = 0;
				},
				error: function(){
					callError(system.error);
					uploadIcon('ricon_icon', 2);
					waitIcon = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}

var newsWait = 0;
uploadNews = function(){
	var file_data = $("#news_file").prop("files")[0];
	var filez = ($("#news_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > fileMax ){
		callError(system.fileBig);
	}
	else if($("#news_file").val() === ""){
		callError(system.noFile);
	}
	else {
		if(newsWait == 0){
			newsWait = 1;
			postIcon(1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("token", utk)
			form_data.append("zone", 'news')
			$.ajax({
				url: "system/action/file_news.php",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(response){
					if(response.code > 0){
						if(response.code == 1){
							callError(system.wrongFile);
						}
						else if(response.code == 9){
							callError(system.fileBlocked);
						}
						postIcon(2);
					}
					else {
						$('#post_file_data').attr('data-key', response.key);
						$('#post_file_data').html(response.file);
					}
					newsWait = 0;
				},
				error: function(){
					newsWait = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}

// lookup

getWhois = function(id){
	$.post('system/box/admin_lookup.php', {
		target:id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response, 420);
			}
	});
}
getNote = function(id){
	$.post('system/box/admin_note.php', {
		target:id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response, 420);
			}
	});
}
getIpDetails = function(id){
	$('#scanbtn').hide();
	$.post('system/action/action_staff.php', {
		get_ip:id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				$('#ip_details').html(response).show();
			}
	});
}

adminRemoveAvatar = function(id){
	$.ajax({
		url: "system/action/avatar.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			remove_avatar: id,
		},
		success: function(response){
			if(response.code == 0){
				callError(system.cannotUser);
			}
			else if(response.code == 1) {
				$('.avatar_profile').attr('src', response.data);
				$('.avatar_profile').attr('href', response.data);
			}
			else {
				callError(system.error);
			}
		},
		error: function(){
			callError(system.error);
		}
	});
}
adminRemoveCover = function(id){
	$.post('system/action/cover.php', {
		remove_cover: id,
		}, function(response) {
			if(response == 1){
				delCover();
			}
			else {
				callError(system.cantModifyUser);
			}
	});	
}
staffRemoveRoomIcon = function(id){
	$.ajax({
		url: "system/action/room_icon.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			staff_remove_icon: id,
		},
		success: function(response){
			if(response.code == 1) {
				$('.ricon_current').attr('src', response.data);
				$('#ricon'+id).attr('src', response.data);
			}
			else {
				callError(system.error);
			}
		},
		error: function(){
			callError(system.error);
		}
	});
}

$(document).ready(function(){

});