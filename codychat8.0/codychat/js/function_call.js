initCall = function(data){
	hideAllModal();
	hideCallRequest();
	hideCall();
	$('#wrap_call').html(data);
	showCall();
}

startCall = function(id, type){
	hideAllModal();
	$.post('system/action/action_call.php', { 
			init_call: id,
			call_type: type,
		}, function(response) {
			if(response == 0){
				callError(system.callFail);
			}
			else if(response == 4){
				callError(system.actLimit);
			}
			else if(response == 22){
				callError(system.lowBalance);
			}
			else {
				overEmptyModal(response);
			}
	});
}
openCall = function(id){
	hideAllModal();
	$.post('system/box/call_box.php', { 
			target: id,
		}, function(response) {
			if(response != 0){
				overModal(response);
			}
	});
}
cancelCall = function(id){
	$.post('system/action/action_call.php', { 
			cancel_call: id,
		}, function(response) {
			hideOver();
	});
}
acceptCall = function(){
	$.ajax({
		url: "system/action/action_call.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			accept_call: $('#call_request').attr('data'),
		},
		success: function(response){
			if(response.code == 1){
				initCall(response.data);
			}
			else if(response.code == 99){
				callError(system.callFail);
				hideCallRequest();
			}
		},
	});	
}
joinGroupCall = function(id, rank){
	var gpass = '';
	if ($("#call_password").length){
		gpass = $('#call_password').val();
	}
	if(!boomAllow(rank)){
		callError(system.accessRequirement);
		return;
	}
	$.ajax({
		url: "system/action/action_group_call.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			join_group_call: id,
			call_key: gpass,
		},
		success: function(response){
			if(response.code == 1){
				initCall(response.data);
			}
			else if(response.code == 2){
				callError(system.wrongPass);
			}
			else if(response.code == 4){
				callError(system.actLimit);
			}
			else if(response.code == 3){
				hideOver();
				callError(system.lowBalance);
			}
			else if(response.code == 99){
				callError(system.callBlock);
			}
		},
	});	
}
openJoinGroupCall = function(id, rank){
	if(!boomAllow(rank)){
		callError(system.accessRequirement);
		return;
	}
	$.post('system/box/join_group_call.php', { 
			call_id: id,
		}, function(response) {
			if(response == 0){
				callError(system.error);
			}
			else if(response == 1){
				callError(system.error);
			}
			else {
				overModal(response, 320);
			}
	});
}
declineCall = function(){
	$.post('system/action/action_call.php', { 
			decline_call: $('#call_request').attr('data'),
		}, function(response) {
			hideCallRequest();
	});
}

updateCall = function(type){
	if($('#call_pending:visible').length){
		$.ajax({
			url: "system/action/action_call.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				update_call: $('#call_pending').attr('data'),
			},
			success: function(response){
				if(response.code == 1){
					initCall(response.data);
				}
				else if(response.code == 99){
					callError(system.callFail);
					hideOver();
				}
			},
		});	
	}
}

updateIncomingCall = function(type){
	if($('#call_request:visible').length){
		$.ajax({
			url: "system/action/action_call.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				update_incoming_call: $('#call_request').attr('data'),
			},
			success: function(response){
				if(response.code == 99){
					hideCallRequest();
				}
			},
		});	
	}
}

hideCallRequest = function(){
	$('#call_request').attr('data', '');
	$('#call_request_type').text('');
	$('#call_request_name').text('');
	$('#call_request_avatar').attr('src', '');
	$('#call_request').addClass('fhide');
}
showCallRequest = function(d){
	$('#call_request').attr('data', d.call_id);
	$('#call_request_type').text(d.call_type);
	$('#call_request_name').text(d.call_username);
	$('#call_request_avatar').attr('src', d.call_avatar);
	$('#call_request').removeClass('fhide');
}

checkCall = function(ncall){
	if(ncall > uCall){
		uCall = ncall;
		$.ajax({
			url: "system/action/action_call.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				check_call: inCall(),
			},
			success: function(response){
				if(response.code == 1){
					showCallRequest(response.data);
				}
			},
		});	
	}	
}

inCall = function(){
	if($('#call_pending:visible').length || $('#call_request:visible').length || $('#container_call:visible').length){
		return 1;
	}
	else {
		return 0;
	}
}

callOff = function(){
	$('.vcallstream').removeClass('over_stream');
}
callOn = function(){
	if(!insideChat()){
		$('.vidminus').replaceWith("");
	}
	if($('.modal_in:visible').length){
		$('.vidstream').addClass('over_stream');
	}
	else {
		vidOff();
	}
}

hideCall = function(){
	$('#wrap_call').html('');
	$('#container_call').hide();
	$('#mstream_call').addClass('streamhide');
}
showCall = function(){
	$("#container_call").removeClass('streamout').fadeIn(300);
}

toggleCall = function(type){
	if(type == 1){
		$("#container_call").addClass('streamout');
		$('#mstream_call').removeClass('streamhide');
	}
	if(type == 2){
		$("#container_call").removeClass('streamout');
		$('#mstream_call').addClass('streamhide');
	}
}

openAddCall = function(){
	$.post('system/box/create_group_call.php', {
		}, function(response) {
			overModal(response);
	});
}
editGroupCall = function(id){
	hideAllModal();
	$.post('system/box/edit_group_call.php', { 
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
var waitGcall = 0;
addGroupCall = function(){
	if(waitGcall == 0){
		waitGcall = 1;
		$.ajax({
			url: "system/action/action_group_call.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				add_group_call: 1,
				call_name: $('#set_call_name').val(),
				call_password: $('#set_call_password').val(),
				call_access: $('#set_call_access').val(),
			},
			success: function(response){
				if(response.code == 1){
					joinGroupCall(response.room, response.rank);
				}
				else if(response.code == 2){
					callError(system.roomName);
				}
				else if(response.code == 3){
					callError(system.invalidPass);
				}
				else if(response.code == 4){
					callError(system.maxRoom);
				}
				else {
					callError(system.error);
				}
				waitGcall = 0;
			},
			error: function(){
				callError(system.error);
				waitGcall = 0;
			}
		});	
	}
	else {
		return false;
	}
}

saveGroupCall = function(id){
	$.ajax({
		url: "system/action/action_group_call.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			save_group_call: 1,
			call_id: id,
			call_name: $('#save_call_name').val(),
			call_password: $('#save_call_password').val(),
			call_access: $('#save_call_access').val(),
		},
		success: function(response){
			if(response.code == 1){
				callSuccess(system.saved);
				hideModal();
			}
			else if(response.code == 2){
				callError(system.roomName);
			}
			else if(response.code == 3){
				callError(system.invalidPass);
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

var waitGcall = 0;
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


$(document).ready(function(){
	callUpdate = setInterval(updateCall, 3000);
	callIncoming = setInterval(updateIncomingCall, 3000);
	updateCall();
	updateIncomingCall();
	
	$(document).on('click', '.opencall', function(){
		var calluser = $(this).attr('data');
		openCall(calluser);
	});
	$(document).on('click', '.startcall', function(){
		var cuser = $(this).attr('data-user');
		var ctype = $(this).attr('data-type');
		startCall(cuser, ctype);
	});
	$(document).on('click', '.hide_call', function(){
		hideCall();
	});
	
	$(window).on('message', function(event) {
		if (event.originalEvent.origin !== window.location.origin) {
			return;
		}
		if (event.originalEvent.data === 'endCall') {
			hideCall();
			callendPlay();
		}
	});
	
	$(document).on('change, paste, keyup', '#search_call_room', function(){
		var sr = $(this).val().toLowerCase();
		if(sr == ''){
			$(".call_element").each(function(){
				$(this).show();
			});	
		}
		else {
			$(".call_element").each(function(){
				var rt = $(this).find('.call_name').text().toLowerCase();
				var rd = $(this).find('.callusername').text().toLowerCase();
				if(rt.indexOf(sr) < 0 && rd.indexOf(sr) < 0){
					$(this).hide();
				}
				else {
					$(this).show();
				}
			});
		}
	});
});