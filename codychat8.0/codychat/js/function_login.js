var waitReply = 0;

$(document).ready(function(){

	selectIt();
	bcCookie();
	
	$(document).keypress(function(e) {
		if(e.which == 13) {
			if($('#login_form_box:visible').length){
				sendLogin();
			}
			else if($('#registration_form_box:visible').length){
				sendRegistration();
			}
			else if($('#guest_form_box:visible').length){
				sendGuestLogin();
			}
			else {
				return false;
			}
		}
	});

});

coppaRule = function(){
	hideAllModal();
	callError(system.coppa);
}
bcCookie = function(){
	var checkCookie = navigator.cookieEnabled;
	if(checkCookie == false){
		alert("you need to enable cookie for the site to be able to log in");
	}
}
getLogin = function(){
	$.post('system/box/login.php', {
		}, function(response) {
			if(response != 0){
				showModal(response);
			}
			else {
				return false;
			}
	});
}
getLoginFail = function(){
	$.post('system/box/login_fail.php', {
		}, function(response) {
			showModal(response);
	});
}
getGuestLogin = function(){
	$.post('system/box/guest_login.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else if(response == 99){
				coppaRule();
			}
			else {
				showModal(response);
				renderCaptcha();
			}
	});
}
getRegistration = function(){
	$.post('system/box/registration.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else if(response == 99){
				coppaRule();
			}
			else {
				showModal(response);
				renderCaptcha();
			}
	});
}
getRecovery = function(){
	$.post('system/box/pass_recovery.php', {
		}, function(response) {
			if(response != 0){
				showModal(response);
			}
			else {
				return false;
			}
	});
}
hideArrow = function(d){
	if($("#last_active .last_10 .active_user").length <= d){
		$("#last_active .left-arrow, #last_active .right-arrow").hide();
	}
	else {
		$("#last_active .left-arrow, #last_active .right-arrow").show();	
	}
}
sendLogin = function(){
	var upass = $('#user_password').val();
	var uuser = $('#user_username').val();
	if(upass == '' || uuser == ''){
		callError(system.emptyField);
		return false;
	}
	else if (/^\s+$/.test($('#user_password').val())){
		callError(system.emptyField);
		$('#user_password').val("");
		return false;
	}
	else if (/^\s+$/.test($('#user_username').val())){
		callError(system.emptyField);
		$('#user_username').val("");
		return false;
	}
	else {
		if(waitReply == 0){
			waitReply = 1;
			$.post('system/action/login.php', {
				password: upass, 
				username: uuser,
				}, function(response) {
					if(response == 1){
						callError(system.badLogin);
						$('#user_password').val("");
					}
					else if(response == 17){
						$('#login_recapt').removeClass('hidden');
						callError(system.missingRecaptcha);
					}
					else if (response == 2){
						callError(system.badLogin);
						$('#user_password').val("");
					}
					else if ( response == 99){
						getLoginFail();
					}
					else if (response == 3){
						location.reload();
					}
					else if (response == 8){
						callError(system.vpnUsage);
					}
					else if (response == 99){
						callError(system.error);
					}
					waitReply = 0;
			});
		}
		else {
			return false;
		}
	}
}
sendRegistration = function() {
	var upass = $('#reg_password').val();
	var uuser = $('#reg_username').val();
	var uemail = $('#reg_email').val();
	var ugender = $('#login_select_gender').val();
	var uage = $('#login_select_age').val();
	var regRecapt = getCaptcha();
	if(upass == '' || uuser == '' || uemail == ''){
		callError(system.emptyField);
		return false;
	}
	else if (/^\s+$/.test($('#reg_username').val())){
		callError(system.emptyField);
		$('#reg_username').val("");
		return false;
	}
	else if (/^\s+$/.test($('#reg_password').val())){
		callError(system.emptyField);
		$('#reg_password').val("");
		return false;
	}
	else if (/^\s+$/.test($('#reg_email').val())){
		callError(system.emptyField);
		$('#reg_email').val("");
		return false;
	}
	else if(recapt > 0 && regRecapt == ''){
		callError(system.missingRecaptcha);
		return false;
	}
	else {
		if(waitReply == 0){
			waitReply = 1;
			$.post('system/action/registration.php', {
				password: upass,
				username: uuser,
				email: uemail,
				age: uage,
				gender: ugender,
				recaptcha: regRecapt,
				}, function(response) {
					if(response != 1){
						resetCaptcha();
					}
					if(response == 2){
						callError(system.error);
						$('#reg_password').val("");
						$('#reg_username').val("");
						$('#reg_email').val("");	
					}
					else if (response == 3){
						callError(system.error);
						$('#reg_password').val("");
						$('#reg_username').val("");
						$('#reg_email').val("");
					}
					else if (response == 4){
						callError(system.invalidUsername);
						$('#reg_username').val("");
					}
					else if (response == 5){
						callError(system.usernameExist);
						$('#reg_username').val("");
					}
					else if (response == 6){
						callError(system.invalidEmail);
						$('#reg_email').val("");
					}
					else if (response == 7){
						callError(system.missingRecaptcha);
					}
					else if (response == 8){
						callError(system.vpnUsage);
					}
					else if (response == 10){
						callError(system.emailExist);
						$('#reg_email').val("");
					}
					else if (response == 12){
						callError(system.selAge);
					}
					else if (response == 13){
						callError(system.ageRequirement);
					}
					else if (response == 14){
						callError(system.error);
					}
					else if (response == 16){
						callError(system.maxReg);
					}
					else if (response == 17){
						callError(system.invalidPass);
						$('#reg_password').val("");
					}
					else if (response == 1){
						location.reload();
					}
					else if(response == 99){
						coppaRule();
					}
					else if(response == 0){
						callError(system.registerClose);
					}
					else {
						waitReply = 0;
						return false;
					}
					waitReply = 0;
			});
		}
		else{
			return false;
		}
	}
}
sendGuestLogin = function(){
	var gname = $('#guest_username').val();
	var ggender = $('#guest_gender').val();
	var gage = $('#guest_age').val();
	var guestRecapt = getCaptcha();
	if(gname == ''){
		callError(system.emptyField);
		return false;
	}
	else if (/^\s+$/.test($('#guest_username').val())){
		callError(system.emptyField);
		$('#guest_username').val("");
		return false;
	}
	else if(recapt > 0 && guestRecapt == ''){
		callError(system.missingRecaptcha);
		return false;
	}
	else {
		if(waitReply == 0){
			waitReply = 1;
			$.post('system/action/login.php', {
				gusername: gname,
				ggender: ggender,
				gage: gage,
				recaptcha: guestRecapt,
				}, function(response) {
					if(response != 1){
						resetCaptcha();
					}
					if (response == 4){
						callError(system.invalidUsername);
						$('#guest_username').val("");
					}
					else if (response == 5){
						callError(system.usernameExist);
						$('#guest_username').val("");
					}
					else if (response == 6){
						callError(system.missingRecaptcha);
					}
					else if (response == 8){
						callError(system.vpnUsage);
					}
					else if (response == 16){
						callError(system.maxReg);
					}
					else if(response == 12){
						callError(system.selAge);
					}
					else if (response == 13){
						callError(system.ageRequirement);
					}
					else if (response == 14){
						callError(system.error);
					}
					else if(response == 99){
						coppaRule();
					}
					else if (response == 1){
						location.reload();
					}
					else {
						callError(system.error);
					}
					waitReply = 0;
			});
		}
		else {
			return false;
		}
	}
}
sendRecovery = function() {
	var rEmail = $('#recovery_email').val();
	if(rEmail == ''){
		callError(system.emptyField);
		return false;
	}
	else if (/^\s+$/.test($('#recovery_username').val())){
		callError(system.emptyField);
		$('#recovery_username').val("");
		return false;
	}
	else if (/^\s+$/.test($('#recovery_email').val())){
		callError(system.emptyField);
		$('#recovery_email').val("");
		return false;
	}
	else {
		if(waitReply == 0){
			waitReply = 1;
			$.post('system/action/recovery.php', {
				remail: rEmail,
				}, function(response) {
					if (response == 1){
						$('#recovery_email').val("");
						hideModal();
						callSuccess(system.recoverySent);
					}
					else if (response == 2){
						$('#recovery_email').val("");
						callError(system.noUser);
					}
					else if (response == 3){
						$('#recovery_email').val("");
						callError(system.invalidEmail);
					}
					else {
						hideModal();
						callError(system.error);
					}
					waitReply = 0;
			});
		}
		else {
			return false;
		}
	}
}
bridgeLogin = function(path){
	if(waitReply == 0){
		waitReply = 1;
		$.post('../boom_bridge.php', {
			path: path,
			special_login: 1,
			}, function(response) {
				if (response == 1){
					location.reload();
				}
				else {
					callError(system.siteConnect);
				}
				waitReply = 0;
		});
	}
}
hideCookieBar = function(){
	$.post('system/action/cookie_law.php', {
		cookie_law: 1,
		}, function(response) {
			$('.cookie_wrap').fadeOut(400);
	});
}
readyCaptcha = function(){
	return false;
};