var avCurrent = '';

appAvMenu = function(type, icon, text, pCall){
	var cMenu = '<div data="" value="" data-av="" class="avset bmenu avitem" onclick="'+pCall+'"><i class="fa fa-'+icon+'"></i> '+text+'</div>';
	$('.av'+type).append(cMenu);
}
renderAvMenu = function(i){
	var uid = $(i).attr('data-id');
	var avt = $(i).attr('data-av');
	var uname = $(i).attr('data-name');
	var urank = $(i).attr('data-rank');
	var ubot = $(i).attr('data-bot');
	var cover = $(i).attr('data-cover');
	var country = $(i).attr('data-country');
	var gender = $(i).attr('data-gender');
	var ulev = $(i).attr('data-level');
	var age = $(i).attr('data-age');
	var uinfo = userInfo(age, gender);
	
	$('#action_menu .avset').attr('data', uid);
	$('#action_menu .avset').attr('value', uname);
	$('#action_menu .avset').attr('data-av', avt);
	$('#action_menu .avavatar').attr('src', avt);
	$('#action_menu .avusername').text(uname);
	
	if(cover != ''){
		$('#action_menu .avbackground').css('background-image', 'url("cover/' + cover + '")');
	}
	else {
		$('#action_menu .avbackground').css('background-image', '');
	}
	if(urank > 0 && useLevel > 0){
		$('#action_menu .clevel_count').text(ulev);
		$('#action_menu .clevel').removeClass('hidden');
	}
	else {
		$('#action_menu .clevel_count').text('');
		$('#action_menu .clevel').addClass('hidden');
	}
	if(useCall > 0 && boomAllow(canCall) && !ignored(parseInt(uid)) && callLock == 0){
		$('#action_menu .avcall').removeClass('fhide');
	}
	else {
		$('#action_menu .avcall').addClass('fhide');
	}
	if(country != 'ZZ'){
		$('#action_menu .avflag').attr('src', 'system/location/flag/' + country + '.png');
		$('#action_menu .avflag').removeClass('hidden');
	}
	else {
		$('#action_menu .avflag').addClass('hidden');
	}
	if(uinfo != ''){
		$('#action_menu .gentext').text(uinfo).removeClass('hidden');
	}
	else {
		$('#action_menu .gentext').text('').addClass('hidden');
	}
	if(ignored(parseInt(uid)) || urank < priMin || user_rank < priMin || privLock == 1){
		$('#action_menu .avpriv').addClass('fhide');
	}
	else {
		$('#action_menu .avpriv').removeClass('fhide');
	}
	var avDrop = '';
	avDrop += $('#action_menu .avheader')[0].outerHTML;
	if(uid == user_id){
		avDrop += $('#action_menu .avself')[0].outerHTML;
	}
	else if(ubot > 0){
		avDrop += $('#action_menu .avbot')[0].outerHTML;
	}
	else if(isStaff(user_rank) && user_rank > urank){
		avDrop += $('#action_menu .avstaff')[0].outerHTML;
	}
	else if(!isStaff(urank) && isRoomStaff(roomRank)){
		avDrop += $('#action_menu .avroomstaff')[0].outerHTML;
	}
	else {
		avDrop += $('#action_menu .avother')[0].outerHTML;
	}
	return avDrop;
}
userInfo = function(a,g){
	var ugen = 0;
	var uage = 0;
	if(g > 0){
		ugen = 1;
	}
	if(a > 0){
		uage = 1;
	}
	if(uage > 0 && ugen > 0){
		return renderAge(a)+" • "+genderTitle(g);
	}
	else if(a > 0){
		return renderAge(a);
	}
	else if(g > 0){
		return genderTitle(g);
	}
	else {
		return '';
	}
}
resetLogMenu = function(){
	$('#logmenu').html('');
	$('#log_menu').css({
		'left': '-5000px',
	});	
}
resetAvMenu = function(){
	$('.avavatar').attr('src', '');
	$('#av_list').html('');
	$('#av_menu').css({
		'left': '-5000px',
	});	
}
hunterMenu = function(elem){
	$('#private_actions .ppitem').attr('data-id', $(elem).attr('data-id'));
	var pmenu = '';
	if(boomAllow(canScontent)){
		pmenu += $("#private_actions .ppdel")[0].outerHTML;
	}
	if(boomAllow(upQuote)){
		pmenu += $("#private_actions .ppquote")[0].outerHTML;
	}
	$(elem).find('.privopt').html(pmenu);
}
targetMenu = function(elem){
	$('#private_actions .ppitem').attr('data-id', $(elem).attr('data-id'));
	var pmenu = '';
	if(boomAllow(upQuote)){
		pmenu += $("#private_actions .ppquote")[0].outerHTML;
	}
	$(elem).find('.privopt').html(pmenu);
}
resetHunterMenu = function(elem){
	$(elem).find('.privopt').html('');
}
resetTargetMenu = function(elem){
	$(elem).find('.privopt').html('');
}

/* document ready functions */

$(document).ready(function(){

	$(document).on('click', '.avs_menu', function(){
		var elem = $(this);
		var citem = $(this).attr('data-i');
		var avDrop = renderAvMenu(elem);
		$('#avcontent').html(avDrop);
		
		if($('#av_menu').css('left') != '-5000px' && citem == avCurrent){
			resetAvMenu();
		}
		else {
			avCurrent = citem;
			var zHeight = $(window).height();
			var offset = $(elem).offset();
			var emoWidth = $(elem).width();
			var avMenu = $('#avcontent').outerHeight();
			var avWidth = $('#av_menu').width();
			var footHeight = $('#my_menu').outerHeight();
			var inputHeight = $('#top_chat_container').outerHeight();
			var avSafe = avMenu + footHeight + inputHeight;
			if(offset.top > zHeight - avSafe){
				var avTop = zHeight - avSafe - 5;
			}
			else {
				var avTop = offset.top;
			}
			if(rtlMode == 1){
				var avLeft = offset.left - (avWidth + 5);
			}
			else {
				var avLeft = offset.left + emoWidth + 5;
			}
			$('#av_menu').css({
				'left': avLeft,
				'top': avTop,
				'height': avMenu,
				'z-index': 99,
			}, 100);
		}
	});

	$(document).on('click', '.drop_user', function(){
		var elem = $(this);
		var citem = $(this).attr('data-i');
		var avDrop = renderAvMenu(elem);
		$('#avcontent').html(avDrop);
		
		if($('#av_menu').css('left') != '-5000px' && citem == avCurrent){
			resetAvMenu();
		}
		else {
			avCurrent = citem;
			var zHeight = $(window).height();
			var zWidth = $(window).width();
			var offset = $(elem).offset();
			var emoWidth = $(elem).width();
			var emoHeight = $(elem).outerHeight();
			var avMenu = $('#avcontent').outerHeight();
			var avWidth = $('#av_menu').width();
			var footHeight = $('#my_menu').outerHeight();
			var avSafe = avMenu + footHeight;
			var avLeft = offset.left + 10;
			var leftSafe = offset.left;
			if(offset.top > zHeight - avSafe){
				var avTop = zHeight - avSafe;
			}
			else {
				var avTop = offset.top + emoHeight - 10;
			}
			if(leftSafe > emoWidth){
				avLeft = offset.left - avWidth + 10;
			}
			$('#av_menu').css({
				'left': avLeft,
				'top': avTop,
				'height': avMenu,
				'z-index': 202,
			});
		}	
	});

	$(document).on('click', '.logs_menu', function(){
		var elem = $(this);
		var rep = $(elem).attr('data-rep');
		var id = $(elem).attr('data-id');
		var uid = $(elem).attr('data-user');
		$('#log_menu_content .logmm').attr('data', id);
		var menuLog = '';
		if(boomAllow(uQuote)){
			menuLog += $("#log_menu_content .log_quote")[0].outerHTML;
		}
		menuLog += $("#log_menu_content .log_hide")[0].outerHTML;
		if(!mySelf(uid) && !boomAllow(canContent) && boomAllow(canReport) && !boomRoomAllow(canRoomLogs)){
			menuLog += $("#log_menu_content .log_report")[0].outerHTML;
		}
		if(boomAllow(canScontent) && mySelf(uid) || boomAllow(canContent) || boomRoomAllow(canRoomLogs)){
			menuLog += $("#log_menu_content .log_delete")[0].outerHTML;
		}
		$('#logmenu').html(menuLog);
		if($('#log_menu').css('left') != '-5000px'){
			resetLogMenu();
		}
		else {
			var zHeight = $(window).height();
			var offset = $(elem).offset();
			var emoWidth = $(elem).width();
			var emoHeight = $(elem).height();
			var avMenu = $('#logmenu').outerHeight();
			var avWidth = $('#log_menu').width();
			var footHeight = $('#my_menu').outerHeight();
			var inputHeight = $('#top_chat_container').outerHeight();
			var avSafe = avMenu + footHeight + inputHeight;
			if(offset.top > zHeight - avSafe){
				var avTop = zHeight - avSafe - 5;
			}
			else {
				var avTop = offset.top;
			}
			if(rtlMode == 1){
				var avLeft = offset.left + emoWidth;
			}
			else {
				var avLeft = offset.left - avWidth;
			}
			$('#log_menu').css({
				'left': avLeft,
				'top': avTop,
				'height': avMenu,
			});
		}	
	});

	$(document).on('mouseenter', '#private_content .outpriv', function(){		
		hunterMenu($(this));
	});

	$(document).on('mouseleave', '#private_content .outpriv', function(){		
		resetHunterMenu($(this));
	});

	$(document).on('mouseenter', '#private_content .inpriv', function(){		
		targetMenu($(this));
	});

	$(document).on('mouseleave', '#private_content .inpriv', function(){		
		resetTargetMenu($(this));
	});

	$(document).on('mouseleave', '#log_menu', function(){
		resetLogMenu();
	});

	$(document).click(function(e){
		var container = $(".avtrig");
		if(!$(e.target).hasClass('avtrig')){
			if (!container.is(e.target) && container.has(e.target).length === 0){
					resetAvMenu();
			}
		}
	});

});