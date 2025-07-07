openContact = function(id){
	$.post('system/box/contact_box.php', {
		open_contact: id,
		}, function(response) {
			showModal(response, 700);
			$('#unread_contact'+id).remove();
	});	
}
deleteContact = function(id){
	$.post('system/action/action_contacts.php', {
		delete_contact: id,
		}, function(response) {
			if(response == 1){
				hideModal();
				$('#contact'+id).remove();
			}
	});	
}
openClearContact = function(){
	$.post('system/box/contact_confirm.php', {
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				overModal(response);
			}
	});	
}
clearContact = function(){
	$.post('system/action/action_contacts.php', {
		clear_contact: 1,
		}, function(response) {
			hideOver();
			if(response == 0){
				return false;
			}
			else {
				$('#contact_listing').html(response);
			}
	});	
}
var waitContact = 0;
replyContact = function(id){
	waitContact = 1;
	$.ajax({
		url: "system/action/action_contacts.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			reply_id: id,
			reply_content: $('#contact_reply').val(),
		},
		success: function(response){
			if(response == 1){
				$('#contact'+id).remove();
				callSuccess(system.actionComplete);
				hideModal();
			}
			else {
				callError(system.error);
			}
		},
		error: function(){
			waitContact = 0;
		}
	});
}
reloadContact = function(){
	$.post('system/action/action_contacts.php', {
		reload_contact: 1,
		}, function(response) {
			if(response > 0){
				if(response > 99){
					response = 99;
				}
				$('#contact_notify').show();
			}
			else {
				$('#contact_notify').hide();
			}

	});	
}

$(document).ready(function(){

	reloadContact();
	contactReload = setInterval(reloadContact, 15000);
	
});