previewName = function(c){
	var n = $('.user_color').attr('data');
	var f = $('#fontitname').val();
	$('#preview_name').removeClass();
	$('#preview_name').addClass(n+' '+f);
}
var waitGuest = 0;
registerGuest = function() {
	var gname = $('#new_guest_name').val();
	var gpass = $('#new_guest_password').val();
	var gemail = $('#new_guest_email').val();
	if(gname == '' || gpass == '' || gemail == ''){
		callError(system.emptyField);
		return false;
	}
	else if (/^\s+$/.test($('#new_guest_name').val())){
		callError(system.emptyField);
		$('#new_guest_name').val("");
		return false;
	}
	else if (/^\s+$/.test($('#new_guest_password').val())){
		callError(system.emptyField);
		$('#new_guest_password').val("");
		return false;
	}
	else if (/^\s+$/.test($('#new_guest_email').val())){
		callError(system.emptyField);
		$('#new_guest_email').val("");
		return false;
	}
	else {
		if(waitGuest == 0){
			waitGuest = 1;
			$.post('system/action/action_member.php', {
				new_guest_name: gname,
				new_guest_password: gpass,
				new_guest_email: gemail,
				}, function(response) {
					if (response == 1){
						location.reload();
					}
					else if (response == 4){
						callError(system.invalidUsername);
						$('#new_guest_name').val("");
					}
					else if (response == 5){
						callError(system.usernameExist);
						$('#new_guest_name').val("");
					}
					else if (response == 6){
						callError(system.invalidEmail);
						$('#new_guest_email').val("");
					}
					else if (response == 10){
						callError(system.emailExist);
						$('#new_guest_email').val("");
					}
					else if (response == 16){
						callError(system.maxReg);
					}
					else if (response == 17){
						callError(system.invalidPass);
						$('#new_guest_password').val("");
					}
					else if(response == 0){
						callError(system.registerClose);
					}
					else {
						waitGuest = 0;
						return false;
					}
					waitGuest = 0;
			});
		}
		else{
			return false;
		}
	}
}
var waitSecure = 0;
secureAccount = function() {
	var sname = $('#secure_name').val();
	var spass = $('#secure_password').val();
	var semail = $('#secure_email').val();
	if(sname == '' || spass == '' || semail == ''){
		callError(system.emptyField);
		return false;
	}
	else if (/^\s+$/.test($('#secure_name').val())){
		callError(system.emptyField);
		$('#secure_name').val("");
		return false;
	}
	else if (/^\s+$/.test($('#secure_password').val())){
		callError(system.emptyField);
		$('#secure_password').val("");
		return false;
	}
	else if (/^\s+$/.test($('#secure_email').val())){
		callError(system.emptyField);
		$('#secure_email').val("");
		return false;
	}
	else {
		if(waitSecure == 0){
			waitSecure = 1;
			$.post('system/action/action_secure.php', {
				secure_name: sname,
				secure_password: spass,
				secure_email: semail,
				}, function(response) {
					if (response == 1){
						location.reload();
					}
					else if(response == 99){
						callError(system.error);
						$('#secure_password').val("");
						$('#secure_name').val("");
						$('#secure_email').val("");	
					}
					else if (response == 4){
						callError(system.invalidUsername);
						$('#secure_name').val("");
					}
					else if (response == 5){
						callError(system.usernameExist);
						$('#secure_name').val("");
					}
					else if (response == 6){
						callError(system.invalidEmail);
						$('#secure_email').val("");
					}
					else if (response == 10){
						callError(system.emailExist);
						$('#secure_email').val("");
					}
					else if (response == 16){
						callError(system.maxReg);
					}
					else if (response == 17){
						callError(system.invalidPass);
						$('#secure_password').val("");
					}
					else if(response == 0){
						callError(system.registerClose);
					}
					else {
						waitSecure = 0;
						return false;
					}
					waitSecure = 0;
			});
		}
		else{
			return false;
		}
	}
}
verifyAccount = function(){
	$('.resend_hide').hide();
	$.post('system/action/action_member.php', {
		send_verify: 1,
		}, function(response){	
		if(response == 1){
			callSuccess(system.emailSent);
		}
		else if(response == 3){
			callError(system.somethingWrong);
		}
		else {
			callError(system.oops);
		}
	});
}
boomSound = function(snd){
	if(uSound.match(snd)){
		return true;
	}
}
resetVerify = function(){
	$('#verify_one').show();
	$('#verify_two').hide();
}
toggleVerify = function(){
	$('#verify_one').hide();
	$('#verify_two').show();
}
validCode = function(type){
	var vCode = $('#boom_code').val();
	if (/^\s+$/.test(vCode) || vCode == ''){
		callError(system.emptyField);
	}
	else {
		$.post('system/action/action_member.php', {
			valid_code: vCode,
			verify_code:1,
			}, function(response) {	
			if(response == 0){
				callError(system.invalidCode);
			}
			else if(response == 1){
				if(type == 1){
					location.reload();
				}
				if(type == 2){
					$('#not_verify').replaceWith("");
					$('#verify_hide').replaceWith("");
					$('#now_verify').show();
				}
			}
			else {
				callError(system.somethingWrong);
			}
			$('#boom_code').val('');
		});
	}
}
var modalList = [];
scanModal = function(v){
	if('modal' in v){
		var m = v.modal;
		if(m.length > 0){
			for (var i = 0; i < m.length; i++){
				modalList.push(m[i]);
			}
		}
	}
}
registerModal = function(v){
	if('content' in v && 'type' in v && 'size' in v){
		modalList.push(v);
	}
}
checkModal = function(){
	if(systemLoaded == 0 || modalList.length === 0 || $('.modal_back:visible').length){
		return false;
	}
	else {
		var m = modalList.shift();
		if(m.type == 'modal'){
			showModal(m.content, m.size);
			callSound(m.sound);
		}
		else if(m.type == 'empty'){
			showEmptyModal(m.content, m.size);
			callSound(m.sound);
		}
	}
}
editProfile = function(){
	$.post('system/box/edit_profile.php', {
		}, function(response) {
			showEmptyModal(response, 580);
	});
}
storeArray = function(key, value) {
	localStorage.setItem(key, JSON.stringify(value));
}

getArray = function(key) {
	var stored = localStorage.getItem(key);
	if(stored != null) {
		return JSON.parse(stored);
	}
	else {
		return [];
	}
}
setArray = function(key, value){
	var arr = getArray(key);
	arr.push(value);
	storeArray(key, arr);
}

setUserTheme = function(item){
	var theme = $(item).val();
	$.ajax({
		url: "system/action/action_profile.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			set_user_theme: theme,
		},
		success: function(response){
			$("#actual_theme").attr("href", "css/themes/" + response.theme + "/" + response.theme + ".css"+bbfv);
			$('#main_logo').attr('src', response.logo);
		},
	});
}
saveUserSound = function(){
	boomDelay(function() {
		$.ajax({
			url: "system/action/action_profile.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				change_sound: 1,
				chat_sound: $('#set_chat_sound').attr('data'),
				private_sound: $('#set_private_sound').attr('data'),
				notify_sound: $('#set_notification_sound').attr('data'),
				name_sound: $('#set_username_sound').attr('data'),
				call_sound: $('#set_call_sound').attr('data'),
			},
			success: function(response){
				if(response.code == 1) {
					uSound = response.data;
				}
				else {
					return false;
				}
			},
			error: function(){
				return false;
			}
		});
	}, 500);
}
systemLoad = function(){
	$.ajax({
		url: "system/action/system_load.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: {},
		success: function(response){
			scanModal(response);
		},
		error: function(){
		}
	});
}
logOut = function(){
	$.post('system/action/logout.php', { 
		logout_from_system: 1,
		}, function(response) {
			if(response == 1){
				location.reload();
			}
	});
}
saveMood = function(){
	$.post('system/action/action_profile.php', { 
		save_mood: $('#set_mood').val(),
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
saveInfo = function(){
	$.ajax({
		url: "system/action/action_profile.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			save_info: 1,
			age: $('#set_profile_age').val(),
			gender: $('#set_profile_gender').val(),
		},
		success: function(response) {
			if(response.code == 1){
				$('.avatar_profile').attr('src', response.av);
				$('.avatar_profile').attr('href', response.av);
				$('.glob_av').attr('src', response.av);
				callSuccess(system.saved);
				hideOver();
			}
			else if(response.code == 3){
				callError(system.ageRequirement);
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
saveShare = function(){
	boomDelay(function() {
		$.post('system/action/action_profile.php', { 
				save_shared: 1,
				ashare: $('#set_ashare').attr('data'),
				sshare: $('#set_sshare').attr('data'),
				fshare: $('#set_fshare').attr('data'),
				gshare: $('#set_gshare').attr('data'),
				lshare: $('#set_lshare').attr('data'),
			}, function(response) {
		});
	}, 500);
}
saveAbout = function(){
	$.post('system/action/action_profile.php', { 
		save_about: '1',
		about: $('#set_user_about').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
				hideOver();
			}
			else if(response == 2){
				callError(system.restrictedContent);
			}
			else if(response == 0){
				callError(system.error);
			}
			else {
				return false;
			}
	});	
}
saveEmail = function(){
	$.post('system/action/action_secure.php', { 
		save_email: '1',
		email: $('#set_profile_email').val(),
		password: $('#email_password').val(),
		}, function(response) {
			if(response == 2){
				callError(system.invalidEmail);
			}
			else if(response == 3){
				callError(system.wrongPass);
				$('#email_password').val('');
			}
			else if(response == 4){
				callError(system.emailExist);
			}
			else if(response == 1){
				callSuccess(system.saved);
				hideOver();
			}
			else {
				callError(system.error);
			}
	});	
}
changePassword = function(){
	var actual = $('#set_actual_pass').val();
	var newPass = $('#set_new_pass').val();
	var newRepeat = $('#set_repeat_pass').val();
	$.post('system/action/action_secure.php', { 
		actual_pass: actual,
		new_pass: newPass,
		repeat_pass: newRepeat,
		change_password: 1,
		}, function(response) {
			if(response == 2){
				callError(system.emptyField);
			}
			else if(response == 3){
				callError(system.notMatch);
			}
			else if(response == 4){
				callError(system.invalidPass);
			}
			else if(response == 5){
				callError(system.badActual);
			}
			else if(response == 1){
				callSuccess(system.saved);
				hideOver();
			}
			else {
				callError(system.error);
				hideOver();
			}
	});
}
deleteMyAccount = function(){
	$.post('system/action/action_secure.php', { 
		delete_my_account: '1',
		delete_account_password: $('#delete_account_password').val(),
		}, function(response) {
			if(response == 2){
				callError(system.wrongPass);
				$('#delete_account_password').val('');
			}
			else if(response == 1){
				callSuccess(system.saved);
				$('#del_account_btn').replaceWith("");
				hideOver();
			}
			else {
				callError(system.error);
			}
	});	
}
cancelDelete = function(){
	$.post('system/action/action_secure.php', { 
		cancel_delete_account: '1',
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
				$('#delete_warn').replaceWith("");
			}
	});	
}
saveLocation = function(){
	$.post('system/action/action_profile.php', {
		user_timezone: $('#set_profile_timezone').val(),
		user_language: $('#set_profile_language').val(),
		user_country: $('#set_profile_country').val(),
		}, function(response) {
			if(response == 1){
				location.reload();
			}
			else {
				callSuccess(system.saved);
			}
	});
}
savePreference = function(){
	$.post('system/action/action_profile.php', {
		save_preference: 1,
		save_ulogin: $('#set_ulogin').val(),
		set_private_mode: $('#set_private_mode').val(),
		set_user_call: $('#set_user_call').val(),
		set_ufriend: $('#set_ufriend').val(),
		}, function(response) {
			if(response == 0){
				callError(system.error);
				hideOver();
			}
			else if(response == 1){
				callSuccess(system.saved);
			}
	});	
}
getProfile = function(profile){
	hideOver();
	$.post('system/box/profile.php', {
		get_profile: profile,
		}, function(response) {
			if(response == 1){
				return false;
			}
			else if(response == 2){
				callError(system.noUser);
			}
			else {
				showEmptyModal(response,580);
			}
	});
}
getBadgeInfo = function(){
	hideOver();
	$.post('system/box/badge_info.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response,540);
			}
	});
}
getDisplaySetting = function(){
	$.post('system/box/display.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
getActions = function(id){
	$.post('system/box/action_main.php', {
		id: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
			}
			else {
				overModal(response,400);
			}
	});
}
getPassword = function(){
	$.post('system/box/edit_password.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
getUserLogin = function(){
	$.post('system/box/edit_login.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
getOtherLogout = function(){
	$.post('system/box/other_logout.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
otherLogout = function(){
	$.post('system/action/logout.php', {
		other_logout: 1,
		}, function(response) {
			if(response == 1){
				callSuccess(system.actionComplete);
			}
	});
}
getFriends = function(){
	$.post('system/box/manage_friends.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
getGift = function(){
	var sgift = $('#proselfgift').attr('value');
	if(sgift == 0){
		$.post('system/box/my_gift.php', {
			}, function(response) {
				if(response == 0){
					return false;
				}
				else {
					$('#proselfgift').html(response).attr('value', 1);
				}
		});
	}
}
reloadGift = function(){
	$.post('system/box/my_gift.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				$('#proselfgift').html(response).attr('value', 1);
			}
	});
}

$(document).on('click', '.view_gift', function(){
	$('#view_gift_title').text($(this).attr('data-title'));
	$('#view_gift_img').attr('src', $(this).attr('data-img'));
	$('#view_gift_id').attr('data', $(this).attr('data-gift'));
	overModal($('#view_gift_template').html(), 400);
});

$(document).on('click', '#gift_delete', function(){
	var gift = $('#view_gift_id').attr('data');
	$.post('system/box/gift_delete.php', {
			gift: gift,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
});

$(document).on('click', '#delete_mgift', function(){
	var gift = $(this).attr('data');
	$.post('system/action/action_gift.php', {
			delete_mgift: gift,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				hideOver();
				callSuccess(system.actionComplete);
				$('#mgift'+gift).replaceWith("");
			}
	});
});

$(document).on('click', '.view_friend', function(){
	$('#view_friend_name').text($(this).attr('data-name'));
	$('#view_friend_avatar').attr('src', $(this).attr('data-avatar'));
	$('#view_friend_id').attr('data', $(this).attr('data-id'));
	overModal($('#view_friend_template').html(), 400);
});

getUserGift = function(id){
	var cgift = $('#progift').attr('value');
	if(cgift == 0){
		$.post('system/box/gift_view.php', {
				target: id,
			}, function(response) {
				if(response == 0){
					return false;
				}
				else {
					$('#progift').html(response).attr('value', 1);
				}
		});
	}
}
getUserFriend = function(id){
	var cfriend = $('#profriend').attr('value');
	if(cfriend == 0){
		$.post('system/box/friend_view.php', {
				target: id,
			}, function(response) {
				if(response == 0){
					return false;
				}
				else {
					$('#profriend').html(response).attr('value', 1);
				}
		});
	}
}
getIgnore = function(){
	$.post('system/box/manage_ignore.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
getLocation = function(){
	$.post('system/box/location.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
getPrivateSettings = function(){
	$.post('system/box/private_settings.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
getCallSettings = function(){
	$.post('system/box/call_settings.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
getPreference = function(){
	$.post('system/box/preference.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 460);
			}
	});
}
getVerify = function(){
	$.post('system/box/verify_account.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 500);
			}
	});
}
getEmail = function(){
	$.post('system/box/edit_email.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
getDeleteAccount = function(){
	$.post('system/box/user_delete.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response, 500);
			}
	});
}
acceptFriend = function(t, friend){
	$.post("system/action/action_friend.php", { 
		add_friend: friend,
		}, function(response) {
			$(t).parent().replaceWith("");
			if($('.friend_request').length < 1 && $('#friends_menu:visible').length){
				hideMenu('friends_menu');
			}
	});
}
declineFriend = function(t, id){
	$.post("system/action/action_friend.php", {
		remove_friend: id,
		}, function(response) {
			$(t).parent().replaceWith("");
			if($('.friend_request').length < 1){
				hideMenu('friends_menu');
			}
	});
}
removeFriend = function(t, id){
	$.post('system/action/action_friend.php', { 
		remove_friend: id,
		}, function(response) {
			$(t).parent().replaceWith("");
			if($('.friend_request').length < 1 && $('#friends_menu:visible').length){
				hideMenu('friends_menu');
			}
	});
}
deleteIgnore = function(t, id){
	$.post('system/action/action_member.php', { 
		remove_ignore: id,
		}, function(response) {
			$(t).parent().replaceWith("");
			removeIgnore(id);
	});
}
addFriend = function(id){
	$.post("system/action/action_friend.php", {
		add_friend: id,
		}, function(response) {
			if(response == 4){
				callError(syste.actLimit);
			}
			else if(response != 3){
				callSuccess(system.actionComplete);
			}
			else {
				callError(system.error);
			}
			hideOver();
	});
}
unFriend = function(id){
	$.post('system/action/action_friend.php', { 
		remove_friend: id,
		}, function(response) {
			callSuccess(system.actionComplete);
			hideOver();
	});
}
ignoreUser = function(id){
	$.post('system/action/action_member.php', { 
		add_ignore: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else if(response == 1){
				callSuccess(system.actionComplete);
				addIgnore(id);
			}
			else if(response == 2){
				callSuccess(system.actionComplete);
				addIgnore(id);
			}
			else {
				callError(system.error);
			}
			hideOver();
	});
}
unIgnore = function(id){
	$.post('system/action/action_member.php', { 
		remove_ignore: id,
		}, function(response) {
			callSuccess(system.actionComplete);
			removeIgnore(id);
			hideOver();
	});
}
ignoreThisUser = function(){
	ignoreUser(currentPrivate);
}
changeUsername = function(){
	$.post('system/box/edit_name.php', { 
		}, function(response) {
			overModal(response);
	});
}
changeInfo = function(){
	$.post('system/box/edit_info.php', { 
		}, function(response) {
			overModal(response);
	});
}
changeShared = function(){
	$.post('system/box/edit_shared.php', { 
		}, function(response) {
			overModal(response);
	});
}
changeAbout = function(){
	$.post('system/box/edit_about.php', { 
		}, function(response) {
			overModal(response, 500);
	});
}
getTextOptions = function(){
	$.post('system/box/chat_text.php', {
		}, function(response) {
			overModal(response);
	});
}
getSoundSetting = function(){
	$.post('system/box/sound.php', {
		}, function(response) {
			overModal(response, 380);
	});
}
changeColor = function(){
	$.post('system/box/edit_color.php', { 
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
openSecure = function(){
	$.post('system/box/secure_account.php', { 
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
openGuestRegister = function(){
	$.post('system/box/guest_register.php', { 
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});
}
changeMood = function(){
	$.post('system/box/edit_mood.php', { 
		}, function(response) {
			overModal(response);
	});
}
changeMyUsername = function(){
	var myNewName = $('#my_new_username').val();
	$.post('system/action/action_profile.php', { 
		edit_username: 1,
		new_name: myNewName,
		}, function(response) {
			if(response == 1){
				$('.globname').text(myNewName);
				hideOver();
			}
			else if(response == 2){
				callError(system.invalidUsername);
				$('#my_new_username').val('');
			}
			else if(response == 3){
				callError(system.usernameExist);
				$('#my_new_username').val();
			}
			else if(response == 4){
				callError(system.actLimit);
				hideOver();
			}
			else {
				callError(system.error);
				hideOver();
			}
	});
}
saveNameColor = function(){
	$.post('system/action/action_profile.php', {
		my_username_color: $('.user_color').attr('data'),
		my_username_font: $('#fontitname').val(),
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});
}
saveUserColor = function(u){
	$.post('system/action/action_users.php', {
		user_color: $('.user_color').attr('data'),
		user_font: $('#fontitname').val(),
		user: u,
		}, function(response) {
			if(response == 1){
				callSuccess(system.saved);
			}
			else {
				callError(system.error);
			}
	});	
}
openAddRoom = function(){
	$.post('system/box/create_room.php', {
		}, function(response) {
			overModal(response);
	});
}
openShareWallet = function(id){
	$.post('system/box/wallet_share.php', {
			target: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response);
			}
	});
}
openSendGift = function(id){
	$.post('system/box/gift.php', {
			target: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response, 480);
			}
	});
}
viewLevelStatus = function(id){
	$.post('system/box/level_status.php', {
			target: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response, 480);
			}
	});
}
var waitShare = 0;
shareGold = function(id){
	if(waitShare == 0){
		waitShare = 1;
		$.post('system/action/action_member.php', {
				share_gold: id,
				shared_gold: $('#gold_shared').val(),
			}, function(response) {
				if(response == 1){
					callSuccess(system.actionComplete);
					hideOver();
				}
				else if(response == 2){
					callError(system.lowBalance);
				}
				else if(response == 3){
					callError(system.cannotUser);
					hideOver();
				}
				else if(response == 4){
					callError(system.invalidAmount);
				}
				else if(response == 5){
					callError(system.actLimit);
				}
				else {
					callError(system.error);
					hideOver();
				}
				waitShare = 0;
		});
	}
}
shareRuby = function(id){
	if(waitShare == 0){
		waitShare = 1;
		$.post('system/action/action_member.php', {
				share_ruby: id,
				shared_ruby: $('#ruby_shared').val(),
			}, function(response) {
				if(response == 1){
					callSuccess(system.actionComplete);
					hideOver();
				}
				else if(response == 2){
					callError(system.lowBalance);
				}
				else if(response == 3){
					callError(system.cannotUser);
					hideOver();
				}
				else if(response == 4){
					callError(system.invalidAmount);
				}
				else {
					callError(system.error);
					hideOver();
				}
				waitShare = 0;
		});
	}
}
roomBlockBox = function(id){
	$.post('system/box/room_block.php', {
		room_block: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
roomMuteBox = function(id){
	$.post('system/box/room_mute.php', {
		room_mute: id,
		}, function(response) {
			if(response == 0){
				callError(system.cannotUser);
			}
			else {
				overModal(response);
			}
	});
}
actionResponse = function(r){
	if(r == 0){
		callError(system.cannotUser);
	}
	else if(r == 1){
		callSuccess(system.actionComplete);
	}
	else if (r == 2){
		callError(system.alreadyAction);
	}
	else if (r == 3){
		callError(system.noUser);
	}
	else {
		callError(system.error);
	}
}
roomMuteUser = function(target){
	$.post('system/action/action.php', {
		room_mute: target,
		delay: $('#room_mute_delay').val(),
		reason: $('#room_mute_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}
roomBlockUser = function(target){
	$.post('system/action/action.php', {
		room_block: target,
		delay: $('#room_block_delay').val(),
		reason: $('#room_block_reason').val(),
		}, function(response) {
			actionResponse(response);
			hideOver();
	});
}

listAction = function(target, act){
	closeTrigger();
	if(act == 'ban'){
		banBox(target);
	}
	else if(act == 'kick'){
		kickBox(target);
	}
	else if(act == 'mute'){
		muteBox(target);
	}
	else if(act == 'main_mute'){
		mainMuteBox(target);
	}
	else if(act == 'private_mute'){
		privateMuteBox(target);
	}
	else if(act == 'ghost'){
		ghostBox(target);
	}
	else if(act == 'warn'){
		warnBox(target);
	}
	else if(act == 'room_mute'){
		roomMuteBox(target);
	}
	else if(act == 'room_block'){
		roomBlockBox(target);
	}
	else if(act == 'change_rank'){
		adminGetRank(target);
	}
	else if(act == 'room_rank'){
		openRoomRank(target);
	}
	else if(act == 'delete_account'){
		eraseAccount(target);
	}
	else {
		$.post('system/action/action.php', {
			take_action: act,
			target: target,
			}, function(response) {
				if(response == 0){
					callError(system.cannotUser);
				}
				else if(response == 1){
					hideOver();
					callSuccess(system.actionComplete);
					processAction(act);
					if(act == 'unghost'){
						$('.ghst'+target).replaceWith("");
					}
				}
				else if(response == 2){
					callError(system.alreadyAction);
				}
				else {
					callError(system.error);
				}
		});
	}
}
processAction = function(act){
	if(act == 'unmute'){
		$('.im_muted').replaceWith("");
	}
	else if(act == 'unban'){
		$('.im_banned').replaceWith("");
	}
}
removeRoomAction = function(elem, action, target){
	$.post('system/action/action.php', {
		take_action: action,
		target: target,
		}, function(response) {
			if(response == 1){
				$(elem).parent().replaceWith("");
			}
			else {
				callError(system.error);
			}
	});
}
appLeftMenu = function(aIcon, aText, aCall, optMenu){
	var qmenu = '';
	if(!optMenu){
		optMenu = '';
	}
	qmenu += '<div class="fmenu_item bhover lmenu_item" onclick="'+aCall+'">';
	qmenu += '<div class="fmenu_icon"><i class="fa fa-'+aIcon+' menui"></i></div>';
	qmenu += '<div class="fmenu_text">'+aText+'</div>';
	if(optMenu != ''){
		qmenu += '<div class="fmenu_notify">';
		qmenu += '<div id="'+optMenu+'" class="fnotify bnotify"></div>';
		qmenu += '</div>';
	}
	qmenu += '</div>';
	$('#left_main_content').append(qmenu);
}
appLeadMenu = function(aIcon, aText, aCall){
	var qmenu = '';
	qmenu += '<div class="fmenu_item bhover" onclick="'+aCall+'">';
	qmenu += '<div class="fmenu_img">';
	qmenu += '<img src="'+aIcon+'"/>';
	qmenu += '</div>';
	qmenu += '<div class="fmenu_text">'+aText+'</div>';
	qmenu += '</div>';
	$('#leaderboard_menu_content').append(qmenu);
}
appGameMenu = function(aIcon, aText, aCall){
	var qmenu = '';
	qmenu += '<div class="fmenu_item bhover" onclick="'+aCall+'">';
	qmenu += '<div class="fmenu_gimg">';
	qmenu += '<img src="'+aIcon+'"/>';
	qmenu += '</div>';
	qmenu += '<div class="fmenu_text">'+aText+'</div>';
	qmenu += '</div>';
	$('#game_menu_content').append(qmenu);
}
appAppMenu = function(aIcon, aText, aCall){
	var qmenu = '';
	qmenu += '<div class="fmenu_item bhover" onclick="'+aCall+'">';
	qmenu += '<div class="fmenu_aimg">';
	qmenu += '<img src="'+aIcon+'"/>';
	qmenu += '</div>';
	qmenu += '<div class="fmenu_text">'+aText+'</div>';
	qmenu += '</div>';
	$('#app_menu_content').append(qmenu);
}
appStoreMenu = function(aIcon, aText, aCall){
	var qmenu = '';
	qmenu += '<div class="fmenu_item bhover" onclick="'+aCall+'">';
	qmenu += '<div class="fmenu_simg">';
	qmenu += '<img src="'+aIcon+'"/>';
	qmenu += '</div>';
	qmenu += '<div class="fmenu_text">'+aText+'</div>';
	qmenu += '</div>';
	$('#store_menu_content').append(qmenu);
}
appToolMenu = function(aIcon, aText, aCall){
	var qmenu = '';
	qmenu += '<div class="fmenu_item bhover" onclick="'+aCall+'">';
	qmenu += '<div class="fmenu_timg">';
	qmenu += '<img src="'+aIcon+'"/>';
	qmenu += '</div>';
	qmenu += '<div class="fmenu_text">'+aText+'</div>';
	qmenu += '</div>';
	$('#tool_menu_content').append(qmenu);
}

appPanelMenu = function(icon, text, pCall){
	var panMenu = '<div title="'+text+'" class="panel_option" onclick="'+pCall+'"><i class="fa fa-'+icon+'"></i></div>';
	$('#right_panel_bar').append(panMenu);
}
appInputMenu = function(mIcon, mCall){
	var inpMenu = '<div class="sub_options" onclick="'+mCall+'"><img src="'+mIcon+'"/></div>';
	$('#main_input_extra').append(inpMenu);
}
appPrivInputMenu = function(mIcon, mCall){
	var privInpMenu = '<div class="psub_options" onclick="'+mCall+'"><img src="'+mIcon+'"/></div>';
	$('#priv_input_extra').append(privInpMenu);
}
noDataTemplate = function(){
	return '<div class="pad_box"><p class="centered_element text_med sub_text">'+system.noResult+'</p></div>';
}
cleanData = function(){
	if(isStaff(user_rank)){
		$.ajax({
			url: "system/action/system_clean.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				clean_data: 1,
			},
			success: function(response){
				return false;
			},
			error: function(){
				return false;
			}
			
		});
	}
}
isStaff = function(urank){
	if(urank >= 70){
		return true;
	}
}
betterRank = function(urank){
	if(user_rank > urank){
		return true;
	}
}

removeRoomStaff = function(elem, target){
	$.post('system/action/action.php', {
		remove_room_staff: 1,
		target: target,
		}, function(response) {
			if(response == 1){
				$(elem).parent().replaceWith("");
			}
			else {
				callError(system.error);
			}
	});
}
joinRoomPassword = function(rt, rank){
	if(!boomAllow(rank)){
		callError(system.accessRequirement);
		return;
	}
	$.ajax({
		url: "system/action/action_room.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			pass: $('#pass_input').val(),
			room: rt,
			join_room_pass: 1,
		},
		success: function(response){
			if(response.code == 10){
				if(insideChat()){
					resetRoom(response.data);
					hideOver();
				}
				else {
					location.reload();
				}
			}
			else if(response.code == 5){
				callError(system.wrongPass);
				$('#pass_input').val('');
			}
			else if(response.code == 2){
				callError(system.accessRequirement);
			}
			else if(response.code == 99){
				callError(system.roomBlock);
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

var waitJoin = 0;
switchRoom = function(room, pass, rank){
	if(insideChat()){
		if(room == user_room){
			return;
		}
	}
	if(!boomAllow(rank)){
		callError(system.accessRequirement);
		return;
	}
	if(waitJoin == 0){
		waitJoin = 1;
		if(pass == 1){
			$.post('system/box/pass_room.php', {
				room_rank: rank,
				room_id: room,
				}, function(response) {
					overModal(response);
					waitJoin = 0;
			});
		}
		else {
			$.ajax({
				url: "system/action/action_room.php",
				type: "post",
				cache: false,
				dataType: 'json',
				data: { 
					room: room,
					join_room: 1,
				},
				success: function(response){
					if(response.code == 10){
						if(insideChat()){
							resetRoom(response.data);
						}
						else {
							location.reload();
						}
					}
					else if(response.code == 99){
						callError(system.roomBlock);
						waitJoin = 0;
					}
					else {
						waitJoin = 0;
						return false;
					}
				},
				error: function(){
					callError(system.error);	
					waitJoin = 0;
				}
			});			
		}
	}
	else {
		return false;
	}
}
var waitRoom = 0;
addRoom = function(){
	if(waitRoom == 0){
		waitRoom = 1;
		$.ajax({
			url: "system/action/action_room.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				set_name: $("#set_room_name").val(),
				set_type: $("#set_room_type").val(),
				set_pass: $("#set_room_password").val(),
				set_description: $("#set_room_description").val(),
				set_ricon: $('#set_room_icon').attr('data'),
			},
			success: function(response){
				if(response.code == 1){
					callError(system.error);
				}
				else if (response.code == 2){
					callError(system.roomName);
				}
				else if (response.code == 5){
					hideModal();
					callError(system.maxRoom);
				}
				else if (response.code == 6){
					callError(system.roomExist);
				}
				else if(response.code == 7){
					if(insideChat()){
						resetRoom(response.data);
					}
					else {
						location.reload();
					}
				}
				else {
					waitRoom = 0;
					return false;
				}
				waitRoom = 0;
			},
			error: function(){
				callError(system.error);	
			}
		});
	}
	else {
		return false;
	}	
}

// files functions 
var mupload;
var pupload;

uploadChatFile = function(){
	if($('#chat_file').val() === ''){
		return;
	}
	else {
		uploadChat($("#chat_file").prop("files")[0]);
	}
}

var waitUpload = 0;
uploadChat = function(f){
	var filez = (f.size / 1024 / 1024).toFixed(2);
	if( filez > fileMax ){
		callError(system.fileBig);
	}
	else {
		if(waitUpload == 0){
			uploadStatus('chat_file', 2);
			waitUpload = 1;
			var form_data = new FormData();
			form_data.append("file", f)
			form_data.append("token", utk)
			mupload = $.ajax({
				url: "system/action/file_chat.php",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				beforeSend: function(){
					startMainUp();
				},
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							upMainStatus((Math.round(percentComplete * 100)));
						}
					}, false);
					return xhr;
				},
				success: function(response){
					if(response.code == 1){
						callError(system.wrongFile);
					}
					else if(response.code == 9){
						callError(system.fileBlocked);
					}
					else if(response.code == 5){
						appendSelfChatMessage(response.logs);
					}
					else {
						callError(system.error);
					}
					resetMainUp();
				},
				error: function(){
					resetMainUp();
				}
			})
		}
		else {
			return false;
		}
	}
}

// up functions controller

startMainUp = function(){
	upMainStatus(0);
	$('#main_progress').show();
}
upMainStatus = function(v){
	$('#mprogress').css('width', v+'%');
}
cancelMainUp = function(){
	mupload.abort();
}
resetMainUp = function(){
	$('#main_progress').hide();
	$("#chat_file").val("");
	uploadStatus('chat_file', 1);
	waitUpload = 0;
}

startPrivateUp = function(){
	upPrivateStatus(0);
	$('#private_progress').show();
}
upPrivateStatus = function(v){
	$('#pprogress').css('width', v+'%');
}
cancelPrivateUp = function(){
	pupload.abort();
}
resetPrivateUp = function(){
	$("#private_file").val("");
	$('#private_progress').hide();
	uploadStatus('private_file', 1);
	waitUpload = 0;
}

uploadPrivateFile = function(){
	if($('#private_file').val() === ''){
		return;
	}
	else {
		uploadPrivate($("#private_file").prop("files")[0]);
	}
}

uploadPrivate = function(f){
	var filez = (f.size / 1024 / 1024).toFixed(2);
	if( filez > fileMax ){
		callError(system.fileBig);
	}
	else {
		if(waitUpload == 0){
			uploadStatus('private_file', 2);
			waitUpload = 1;
			var form_data = new FormData();
			form_data.append("file", f)
			form_data.append("target", currentPrivate)
			form_data.append("zone", 'private')
			form_data.append("token", utk)
			pupload = $.ajax({
				url: "system/action/file_private.php",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				beforeSend: function(){
					startPrivateUp();
				},
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							upPrivateStatus((Math.round(percentComplete * 100)));
						}
					}, false);
					return xhr;
				},
				success: function(response){
					if(response.code == 1){
						callError(system.wrongFile);
					}
					else if(response.code == 9){
						callError(system.fileBlocked);
					}
					else if(response.code == 5){
						appendSelfPrivateMessage(response.logs);
					}
					else if(response.code == 99){
						appendCannotPrivate();
					}
					else {
						callError(system.error);
					}
					resetPrivateUp();
				},
				error: function(){
					resetPrivateUp();
				}
			})
		}
		else {
			return false;
		}
	}
}
var waitAvatar = 0;
uploadAvatar = function(){
	var file_data = $("#avatar_image").prop("files")[0];
	var filez = ($("#avatar_image")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > avatarMax ){
		callError(system.fileBig);
	}
	else if($("#avatar_image").val() === ""){
		callError(system.noFile);
	}
	else {
		if(waitAvatar == 0){
			waitAvatar = 1;
			uploadIcon('avat_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("self", 1)
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
						$('.glob_av').attr('src', response.data);
					}
					else {
						callError(system.error);
					}
					uploadIcon('avat_icon', 2);
					waitAvatar = 0;
				},
				error: function(){
					callError(system.error);
					uploadIcon('avat_icon', 2);
					waitAvatar = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}

var waitCover = 0;
uploadCover = function(){
	var file_data = $("#cover_file").prop("files")[0];
	var filez = ($("#cover_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > coverMax ){
		callError(system.fileBig);
	}
	else if($("#cover_file").val() === ""){
		callError(system.noFile);
	}
	else {
		if(waitCover == 0){
			waitCover = 1;
			uploadIcon('cover_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("self", 1)
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
					uploadIcon('cover_icon', 2);
					waitCover = 0;
				},
				error: function(){
					callError(system.error);
					uploadIcon('cover_icon', 2);
					waitCover = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}
var waitRoomIcon = 0;
addRoomIcon = function(id){
	var file_data = $("#ricon_image").prop("files")[0];
	var filez = ($("#ricon_image")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > riconMax ){
		callError(system.fileBig);
	}
	else if($("#ricon_image").val() === ""){
		callError(system.noFile);
	}
	else {
		if(waitRoomIcon == 0){
			waitRoomIcon = 1;
			uploadIcon('ricon_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("add_icon", 1)
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
					waitRoomIcon = 0;
				},
				error: function(){
					callError(system.error);
					uploadIcon('ricon_icon', 2);
					waitRoomIcon = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}
var wallUpload = 0;
uploadWall = function(){
	var file_data = $("#wall_file").prop("files")[0];
	var filez = ($("#wall_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > fileMax ){
		callError(system.fileBig);
	}
	else if($("#wall_file").val() === ""){
		callError(system.noFile);
	}
	else {
		if(wallUpload == 0){
			wallUpload = 1;
			postIcon(1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("token", utk)
			form_data.append("zone", 'wall')
			$.ajax({
				url: "system/action/file_wall.php",
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
					wallUpload = 0;
				},
				error: function(){
					wallUpload = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}

// misc function for files

addCover = function(cover){
	$('.profile_background').css('background-image', 'url('+cover+')');
	$('.profile_background').addClass('cover_size');
}
delCover = function(cover){
	$('.profile_background').css('background-image', '');
	$('.profile_background').removeClass('cover_size');
}
uploadIcon = function(target, type){
	var upIcon = $('#'+target).attr('data');
	console.log(upIcon);
	if(type == 2){
		$('#'+target).removeClass('fa-circle-notch fa-spin fa-fw').addClass(upIcon);
	}
	else {
		$('#'+target).removeClass(upIcon).addClass('fa-circle-notch fa-spin fa-fw');
	}
}
uploadStatus = function(target, type){
	if(type == 2){
		$("#"+target).prop('disabled', true);
	}
	else {
		$("#"+target).prop('disabled', false);
	}
}
postIcon = function(type){
	if(type == 2){
		$('#post_file_data').html('').hide();
	}
	else {
		$('#post_file_data').html(regSpinner).show();
	}
	$('#post_file_data').attr('data-key', '');
}
removeFile = function(target){
	postIcon(2);
	$.post('system/action/action_files.php', {
		remove_uploaded_file: target,
		}, function(response) {
	});
}

// files removal options

deleteAvatar = function(){
	$.ajax({
		url: "system/action/avatar.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			delete_avatar: 1,
		},
		success: function(response) {
			$('.avatar_profile').attr('src', response.data);
			$('.avatar_profile').attr('href', response.data);
			$('.glob_av').attr('src', response.data);
		},
		error: function(){
			callError(system.error);
		}
	});
}
deleteCover = function(){
	$.post('system/action/cover.php', { 
		delete_cover: 1,
		}, function(response) {
			delCover();
	});
}
removeRoomIcon = function(id){
	$.ajax({
		url: "system/action/room_icon.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			remove_icon: id,
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
infoPop = function(i){
	$.post('system/action/help.php', { 
			info:i,
		}, function(response) {
			overModal(response, 500);
	});
}

/* gift functions */

$(document).on('click', '.select_gift', function(){
	var gimg = $(this).attr('data-img');
	var gprice = $(this).attr('data-price');
	var gid = $(this).attr('data-id');
	var gtitle = $(this).attr('data-title');
	var gmethod = $(this).attr('data-method');
	
	if(gmethod == 1){
		$('#gift_sruby').hide();
		$('#gift_sgold').show();
	}
	if(gmethod == 2){
		$('#gift_sgold').hide();
		$('#gift_sruby').show();
	}
	
	$('#gift_second').attr('data-id', gid);
	$('#gift_selected').attr('src', gimg);
	$('#gift_pricing').text(gprice);
	$('#gift_title').text(gtitle);
	$('#gift_first').hide();
	$('#gift_second').show();
});
$(document).on('click', '.open_gift', function(){
	$.post('system/box/open_gift.php', {
		open_gift: $(this).attr('data'),
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else {
				overModal(response, 400);
			}
	});
});

var waitSendGift = 0;
sendGift = function(){
	if(waitSendGift == 0){
		waitSendGift = 1;
		$.post('system/action/action_gift.php', {
			send_gift: $('#gift_second').attr('data-id'),
			target: $('#gift_second').attr('data-user'),
			}, function(response) {
				if(response == 1){
					callSuccess(system.actionComplete);
					hideOver();
				}
				else if(response == 11){
					callSuccess(system.actionComplete);
					hideOver();
					reloadGift();
				}
				else if(response == 2){
					callError(system.noGold);
				}
				else {
					callError(system.error);
					hideOver();
				}
				waitSendGift = 0;
		});
	}
}
backGift = function(){
	$('#gift_second').hide();
	$('#gift_first').show();
}

/* document ready functions */

$(document).ready(function(){
	
	systemLoad();
	setTimeout(cleanData, 5000)
	runClean = setInterval(cleanData, 300000);

	$(document).on('click', '.get_info', function(){
		var profile = $(this).attr('data');
		closeTrigger();
		getProfile(profile);
	});
	$(document).on('click', '.get_finfo', function(){
		var profile = $(this).attr('data');
		closeTrigger();
		hideOver();
		getProfile(profile);
	});
	$(document).on('click', '.open_profile', function(){
		editProfile();
	});
	$(document).on('click', '.badge_info', function(){
		getBadgeInfo();
	});
	$(document).on('click', '.get_actions', function(){
		var id = $(this).attr('data');
		closeTrigger();
		getActions(id);
	});
	$(document).on('click', '.open_same_page', function(){
		var l = $(this).attr('data');
		openSamePage(l);
	});
	$(document).on('click', '.open_link_page', function(){
		var l = $(this).attr('data');
		openLinkPage(l);
	});
	$(document).on('click', '.get_room_actions', function(){
		var id = $(this).attr('data');
		closeTrigger();
		getRoomActions(id);
	});

	$(document).on('click', '.name_choice, .choice', function() {	
		var curColor = $(this).attr('data');
		if($('.user_color').attr('data') == curColor){
			$('.bccheck').replaceWith("");
			$('.user_color').attr('data', 'user');
		}
		else {
			$('.bccheck').replaceWith("");
			$(this).append('<i class="fa fa-check bccheck"></i>');
			$('.user_color').attr('data', curColor);
		}
		previewName();
	});
	
	$(document).on('change', '#fontitname', function(){		
		previewName();
	});
	
	$(document).on('click', '.infopop', function(){		
		infoPop($(this).attr('data'));
	});
	
	$(document).on('keydown', function(event) {
		if( event.which === 8 && event.ctrlKey && event.altKey ) {
			getConsole();
		}
	});
	
	$(document).on('change, paste, keyup', '#search_chat_room', function(){
		var sr = $(this).val().toLowerCase();
		if(sr == ''){
			$(".room_element").each(function(){
				$(this).show();
			});	
		}
		else {
			$(".room_element").each(function(){
				var rt = $(this).find('.roomtitle').text().toLowerCase();
				var rd = $(this).find('.roomdesc').text().toLowerCase();
				if(rt.indexOf(sr) < 0 && rd.indexOf(sr) < 0){
					$(this).hide();
				}
				else {
					$(this).show();
				}
			});
		}
	});
	
	$(document).on("mouseenter", '.srnk', function(){
		var rtitle = $(this).attr('data-r');
		$(this).attr('title', systemRankTitle(parseInt(rtitle)));
	});
	$(document).on("mouseenter", '.rrnk', function(){
		var rtitle = $(this).attr('data-r');
		$(this).attr('title', roomRankTitle(parseInt(rtitle)));
	});
	$(document).on("mouseenter", '.sttle', function(){
		var stitle = $(this).attr('data-s');
		$(this).attr('title', statusTitle(parseInt(stitle)));
	});
});