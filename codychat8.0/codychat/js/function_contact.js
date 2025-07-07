selectIt();
$('#contact_message').val('');

sendContact = function(){
	contactSend(0);
	boomDelay(function() {
		
		var uname = $('#contact_name').val();
		var usubject = $('#contact_subject').val();
		var uemail = $('#contact_email').val();
		var umessage = $('#contact_message').val();
		var contactCapt = getCaptcha();

		if(uname == '' || usubject == 0 || uemail == '' || umessage == ''){
			callError(system.emptyField);
			return false;
		}
		else if (/^\s+$/.test($('#contact_name').val())){
			callError(system.emptyField);
			$('#contact_name').val("");
			return false;
		}
		else if (/^\s+$/.test($('#contact_email').val())){
			callError(system.emptyField);
			$('#contact_email').val("");
			return false;
		}
		else if (/^\s+$/.test($('#contact_message').val())){
			callError(system.emptyField);
			$('#contact_message').val("");
			return false;
		}
		else if(recapt > 0 && contactCapt == ''){
			callError(system.missingRecaptcha);
			return false;
		}
		else {
			$.post('system/action/action_contact.php', {
				name: uname,
				subject: usubject,
				email: uemail,
				message: umessage,
				recaptcha: getCaptcha(),
				}, function(response) {
					if(response == 1){
						contactSend(2);
					}
					else if(response == 2){
						callError(system.emptyField);
						contactSend(1);
					}
					else if(response == 3){
						callError(system.invalidEmail);
						contactSend(1);
					}
					else if(response == 4){
						contactSend(3);
					}
					else if(response == 6){
						callError(system.missingRecaptcha);
						contactSend(1);
					}
					else {
						contactSend(4);
					}
			});
		}
	}, 500);
}

contactSend = function(i){
	if(i == 0){
		$('.contact_send').hide();
	}
	else if(i == 1){
		resetCaptcha();
		$('.contact_send').show();
	}
	else if(i == 2){
		$('#contact_form').remove();
		$('#contact_sent').show();
	}
	else if(i == 3){
		$('#contact_form').remove();
		$('#contact_max').show();
	}
	else {
		$('#contact_form').remove();
		$('#contact_error').show();
	}
}

readyCaptcha = function(){
	renderCaptcha();
}

$(document).ready(function(){
});