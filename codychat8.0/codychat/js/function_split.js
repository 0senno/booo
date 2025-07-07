var regSpinner = '<i class="fa fa-circle-notch fa-spin fa-fw bspin reg_spinner"></i>';
var menuSpinner = '<div class="menu_spinner_wrap"><i class="fa fa-circle-notch fa-spin fa-fw bspin menu_spinner"></i></div>';
var largeSpinner = '<div class="large_spinner"><i class="fa fa-circle-notch fa-spin fa-fw bspin boom_spinner"></i></div>';

resetCaptcha = function(){
	if(recapt > 0){
		if(recapt == 1){
			grecaptcha.reset();
		}
		else if(recapt == 2){
			hcaptcha.reset();
		}
		else if(recapt == 3){
			turnstile.reset();
		}
	}
}
renderCaptcha = function(){
	if(recapt > 0){
		if(recapt == 1){
			grecaptcha.render("boom_recaptcha", { 'sitekey': recaptKey, });
		}
		else if(recapt == 2){
			hcaptcha.render("boom_recaptcha", { 'sitekey': recaptKey, });
		}
		else if(recapt == 3){
			turnstile.render("#boom_recaptcha", { 'sitekey': recaptKey, 'theme': 'light'});
		}
	}
}
getCaptcha = function(){
	if(recapt > 0){
		if(recapt == 1){
			return grecaptcha.getResponse();
		}
		else if(recapt == 2){
			return hcaptcha.getResponse();
		}
		else if(recapt == 3){
			return turnstile.getResponse();
		}
	}
	else {
		return 'disabled';
	}
}

pageMenuSelect = function(){
	if($('.page_menu_item').length > 1){
		$('.page_menu_item').first().addClass('pselected');
	}
}
selectIt = function(){
	$("select:visible").selectBoxIt({ 
		autoWidth: false,
		hideEffect: 'fadeOut',
		hideEffectSpeed: 100
	});
}
hideAll = function(){
	$('.hideall').hide();
	$('.sysmenu').hide();
	vidaudOff();
}
adjustSubMenu = function(){
	$('#side_menu').hide();
}
hideSubMenu = function(){
	var mobWidth = $(window).width();
	if(mobWidth <= 1024){
		$('.sub_page_menu').hide();
	}
}

callSuccess = function(t){
	callSaved(t, 1);
}
callWarning = function(t){
	callSaved(t, 2);
}
callError = function(t){
	callSaved(t, 3);
}

var curCall = '';
callSaved = function(text, type){
	var s = 3000;
	if(type == 1){
		s = 1000;
	}
	if(text == curCall && $('.saved_data:visible').length){
		return false;
	}
	else {
		if(type == 1){
			$('.saved_data').removeClass('saved_warn saved_error').addClass('saved_ok');
		}
		if(type == 2){
			$('.saved_data').removeClass('saved_ok saved_error').addClass('saved_warn');
		}
		if(type == 3){
			$('.saved_data').removeClass('saved_warn saved_ok').addClass('saved_error');
		}
		$('.saved_span').text(text);
		$('.saved_data').fadeIn(300).delay(s).fadeOut();
		curCall = text;
	}
}
textArea = function(elem, height) {
    $(elem).css('height', height + 'px');
    $(elem).css('height', (elem.scrollHeight)+"px");
}
loadLob = function(p){
	hideAll();
	$.post('system/pages/'+p, { 
		}, function(response) {
			$('#page_wrapper').html(response);
			selectIt();
			pageTop();
	});
}
loadWrap = function(content){
	$('#page_wrapper').html(content);
	selectIt();
	pageTop();
}
loadFirst = function(){
	if(loadPage != ''){
		$.post(loadPage, { 
			}, function(response) {
				$('#page_wrapper').html(response);
				selectIt();
		});
	}
}
ignored = id => {
	return ignoreList.has(id);
}
mySelf = function(id){
	if(id == user_id){
		return true;
	}
}
boomAllow = function(rnk){
	if(user_rank >= rnk){
		return true;
	}
	else {
		return false;
	}
}
boomRoomAllow = function(rnk){
	if(roomRank >= rnk){
		return true;
	}
	else {
		return false;
	}
}
isStaff = function(rnk){
	if(rnk >= 70){
		return true;
	}
	else {
		return false;
	}
}
isRoomStaff = function(rnk){
	if(rnk >= 4){
		return true;
	}
	else {
		return false;
	}
}
showModal = function(r,s){
	hideAll();
	hideModal();
	if(!s){
		s = 400;
	}
	if(s == 0){
		s = 400;
	}
	$('.small_modal_in').css('max-width', s+'px');
	$('#small_modal_content').html(r);
	$('#small_modal').show();
	offScroll();
	modalTop();
	selectIt();
}
showEmptyModal = function(r,s){
	hideAll();
	hideModal();
	if(!s){
		s = 400;
	}
	if(s == 0){
		s = 400;
	}
	$('.large_modal_in').css('max-width', s+'px');
	$('#large_modal_content').html(r);
	$('#large_modal').show();
	offScroll();
	modalTop();
	selectIt();
}
overModal = function(r,s){
	hideAll();
	hideOver();
	if(!s){
		s = 400;
	}
	if(s == 0){
		s = 400;
	}
	$('.over_modal_in').css('max-width', s+'px');
	$('#over_modal_content').html(r);
	$('#over_modal').show();
	offScroll();
	selectIt();
}
overEmptyModal = function(r,s){
	hideAll();
	hideOver();
	if(!s){
		s = 400;
	}
	if(s == 0){
		s = 400;
	}
	$('.over_emodal_in').css('max-width', s+'px');
	$('#over_emodal_content').html(r);
	$('#over_emodal').show();
	offScroll();
	selectIt();
}
hideModal = function(){
	$('#small_modal_content, #large_modal_content').html('');
	$('#small_modal, #large_modal').hide();
	onScroll();
}
hideOver = function(){
	$('#over_modal_content, #over_emodal_content').html('');
	$('#over_modal, #over_emodal').hide();
	if(!$('#small_modal:visible').length && !$('#large_modal:visible').length){
		onScroll();
	}
}
hideAllModal = function(){
	hideModal();
	hideOver();
}
pageTop = function(){
	$("html, body").animate({ scrollTop: 0 }, "fast");
}
modalTop = function(){
	$(".modal_back").animate({ scrollTop: 0 }, "fast");
}
insideChat = function(){
	if(curPage == 'chat'){
		return true;
	}
}
offScroll = function(){
	if(!insideChat()){
		$('body').addClass('modal_open');
	}
}
onScroll = function(){
	if(!insideChat()){
		$('body').removeClass('modal_open');
	}
	else {
		$('body').css('overflow', 'hidden');
	}
}
messagePlay = function(){
	if(boomSound(1)){
		document.getElementById('message_sound').play();
	}
}
clearPlay = function(){
	if(boomSound(1)){
		document.getElementById('clear_sound').play();
	}
}
joinPlay = function(){
	if(boomSound(1)){
		document.getElementById('join_sound').play();
	}
}
actionPlay = function(){
	if(boomSound(1)){
		document.getElementById('action_sound').play();
	}
}
whistlePlay = function(){
	if(boomSound(1)){
		document.getElementById('whistle_sound').play();
	}
}
privatePlay = function(){
	if(boomSound(2)){
		document.getElementById('private_sound').play();
	}
}
notifyPlay = function(){
	if(boomSound(3)){
		document.getElementById('notify_sound').play();
	}
}
usernamePlay = function(){
	if(boomSound(4)){
		document.getElementById('username_sound').play();
	}
}
quotePlay = function(){
	if(boomSound(4)){
		document.getElementById('quote_sound').play();
	}
}
newsPlay = function(){
	if(boomSound(3)){
		document.getElementById('news_sound').play();
	}
}
levelPlay = function(){
	if(boomSound(3)){
		document.getElementById('levelup_sound').play();
	}
}
badgePlay = function(){
	if(boomSound(3)){
		document.getElementById('badge_sound').play();
	}
}
callendPlay = function(){
	if(boomSound(5)){
		document.getElementById('callend_sound').play();
	}
}

const soundFunctions = {
  'message': messagePlay,
  'clear': clearPlay,
  'join': joinPlay,
  'action': actionPlay,
  'whistle': whistlePlay,
  'private': privatePlay,
  'notify': notifyPlay,
  'username': usernamePlay,
  'quote': quotePlay,
  'news': newsPlay,
  'level': levelPlay,
  'badge': badgePlay,
  'callend': callendPlay,
}

const callSound = function(t) {
  const soundFunction = soundFunctions[t];
  if (soundFunction) {
    soundFunction();
  }
}
updateSession = function(){
	if(!insideChat() && logged == 1){
		$.post('system/action/update_session.php', { 
			}, function(response) {
				if(response == 0){
					location.reload();
				}
		});
	}
}
isMobile = function(){
	return /iPhone|iPad|iPod|Android|webOS|BlackBerry|Windows Phone|Opera Mini|IEMobile|Mobile/i.test(navigator.userAgent);
}

isPwa = function() {
    return 'onbeforeinstallprompt' in window;
}
lazyBoom = function(zone){
	$("#"+zone+" .lazyboom").each(function(){
		$(this).attr('src', $(this).attr('data-img'));
	});
}
closeTrigger = function(){
	$('.drop_list').slideUp(100);
}
getLanguage = function(){
	$.post('system/box/language.php', {
		}, function(response) {
				showModal(response, 300);
	});
}
toggleNotify = function(t, v){
	if(v > 0){
		$("#"+t).show();
	}
	else {
		$("#"+t).hide();
	}
}
showRules = function(){
	$.post('system/box/terms.php', {
		}, function(response) {
			overModal(response, 500);
	});
}
showPrivacy = function(){
	$.post('system/box/privacy.php', {
		}, function(response) {
			showModal(response, 500);
	});
}
boomClick = function(id){
	$("#"+id).trigger('click');
}
backLocation = function(){
	window.history.back();
	hideAll();
}
openSamePage = function(l){
	var addEmbed = '';
	if(pageEmbed == 1){
		addEmbed = '?embed=1';
	}
	window.location.href = l+addEmbed;
}
openLinkPage = function(l){
	window.open(l, '_BLANK');
}
openParentPage = function(l){
	window.open(l, '_PARENT');
}
checkPageHistory = function(){
	if(window.history.length <= 1){
		$('.back_location').hide();
	}
}
resetSelect = function(val){
	$('#'+val).selectBoxIt('selectOption', 0);
}
getBox = function(f, t, s){
	if(!s){
		s = 0;
	}
	if(insideChat()){
		closeLeft();
	}
	hideModal();
	$.post(f, { 
		}, function(response) {
			if(t == 'modal'){
				showModal(response, s);
			}
			if(t == 'emodal'){
				showEmptyModal(response, s);
			}
			if(t == 'panel' && insideChat()){
				prepareRight(s);
				chatRightIt(response);
			}
			else {
				return false;
			}
			selectIt();
	});	
}
getOver = function(f, t, s){
	if(!s){
		s = 0;
	}
	hideOver();
	$.post(f, { 
		}, function(response) {
			if(t == 'over'){
				overModal(response, s);
			}
			if(t == 'eover'){
				overEmptyModal(response, s);
			}
			selectIt();
	});	
}
var boomDelay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

boomAddCss = function(addFile){
	$('head').append('<link rel="stylesheet" href="'+addFile+bbfv+'" type="text/css" />');
}
loadLanguage = function(lang){
	$.post('system/action/load_lang.php', {
		lang: lang,
		}, function(response) {
			location.reload();
	});
}
showMenu = function(id){
	vidaudOff();
	if($('#'+id+':visible').length){
		$('#'+id).hide();
	}
	else {
		$('#'+id).show().scrollTop(0);
		selectIt();
	}
	$('.sysmenu').each(function(){
		if($(this).attr('id') != id){
			$(this).hide();
		}
	});
}
prepareMenu = function(id){
	if($('#'+id+':visible').length){
		return false;
	}
	else {
		var container = $('#'+id).attr('data');
		$('#'+container).html(menuSpinner);
		showMenu(id);
		return true;
	}
}
appendMenu = function(id, data){
	var container = $('#'+id).attr('data');
	$('#'+container).html(data);
}
hideAllMenu = function(){
	$('.sysmenu').hide();
}
hideMenu = function(id){
	$('#'+id).hide();
}
boomSound = function(snd){
	if(uSound.match(snd)){
		return true;
	}
}

avFix = function(item){
	$(item).attr('src', 'default_images/avatar/default_avatar.png');
	$(item).attr("onerror", '');
}

noAction = function(){
	console.log('there is no action on that button');
}
toggleSel = function(t){
	if(t.is(":visible")){
		t.hide();
	}
	else {
		t.show();
	}
}

$(document).ready(function(){
	
	$.ajaxSetup({
		data: {
			token: utk,
			cp: curPage,
		}
	});
	
	loadFirst();
	pageMenuSelect();
	checkPageHistory();
	
	updateSession();
	var upsess = setInterval(updateSession, 60000);
	
	$(document).on('click', '.modal_menu_item', function(){
		var mmi = $(this).attr('data-z');
		if(mmi != 'void'){
			$(this).parent().find('.modal_menu_item').removeClass('modal_selected');
			$(this).addClass('modal_selected');
			$('#'+$(this).attr('data')+' .modal_zone').hide();
			$('#'+$(this).attr('data-z')).fadeIn(200);
			selectIt();
		}
	});
	
	$(document).on('click', '.tab_menu_item', function(){
		$(this).parent().find('.tab_menu_item').removeClass('tab_selected');
		$(this).addClass('tab_selected');
		$('#'+$(this).attr('data')+' .tab_zone').hide();
		$('#'+$(this).attr('data-z')).fadeIn(200);
		selectIt();
	});
	
	$(document).on('click', '.reg_menu_item', function(){
		$(this).parent().find('.reg_menu_item').removeClass('rselected');
		$(this).addClass('rselected');
		$('#'+$(this).attr('data')+' .reg_zone').hide();
		$('#'+$(this).attr('data-z')).fadeIn(200);
		selectIt();
	});

	$(document).on('click', '.close_modal, .cancel_modal', function(){
		hideModal();
	});
	$(document).on('click', '.close_over, .cancel_over', function(){
		hideOver();
	});
	$(document).on('click', '.close_side, .cancel_side', function(){
		hideSide();
	});
	
	$(document).on('click', '#open_sub_mobile', function(){
		$('#side_menu').toggle();
	});
	
	$(document).on('click', '#close_sub_mobile', function(){
		$('#side_menu').toggle();
	});
	
	$(document).on('click', '.get_dat', function(){
		var p = $(this).attr('data');
		loadLob(p);
	});
	
	$(document).on('click', '.open_page', function(){
		hideAll();
		var toPage = $(this).attr('data');
		window.open(toPage, '_blank'); 
	});
	
	$(document).on('click', '.getmenu', function(){
		var getPage = $(this).attr('data');
		window.location.href = getPage;
	});
	
	$(document).on('click', '#open_sub_mobile, #close_sub', function(){		
		$('.sub_page_menu').toggle();
	});

	$(document).on('click', '.getbox', function(){
		if(!$(this).attr('data-type')){
			return false;
		}
		if(!$(this).attr('data-box')){
			return false;
		}
		var dSize = 0;
		var dType = $(this).attr('data-type');
		var dFile = $(this).attr('data-box');
		if($(this).attr('data-size')){
			dSize = $(this).attr('data-size');
		}
		getBox(dFile, dType, dSize);
	});
	
	$(document).on('click', '.page_drop_control', function() {	
		if($(this).next('.page_drop').is(":visible")){
			$(this).next('.page_drop').slideUp(100);
			$(this).find('.pdcontrol').removeClass('fa-chevron-up');
			$(this).find('.pdcontrol').addClass('fa-chevron-down');
		}
		else {
			$(this).next('.page_drop').slideDown(100);
			$(this).find('.pdcontrol').removeClass('fa-chevron-down');
			$(this).find('.pdcontrol').addClass('fa-chevron-up');
		}
	});
	$(document).on('click', '.page_drop_item, .page_menu_item', function() {
		if(!$(this).hasClass('page_drop_control')){
			$('.page_drop_item, .page_menu_item').removeClass('pselected');
			$(this).addClass('pselected');
		}
	});
	
	$(document).click(function(e){
		var target = $(e.target);
		if(!target.parents('.sysmenu').length && !target.parents('.menutrig').length){
			hideAllMenu();
		}
	});
	
	$(document).on('click', '.docu_head', function(){
		if($(this).next('.docu_content').is(":visible")){
			$(this).next('.docu_content').hide();
		}
		else {
			$( ".docu_content" ).each(function() {
				$(this).hide();
			});
			$(this).next('.docu_content').show();
		}
	});
	
	$(document).on('click', '.show_menu', function(){
		var id = $(this).attr('data-menu');
		showMenu(id);
	});
	
	$(document).on('click', '.hide_menu', function(){
		var id = $(this).attr('data-menu');
		hideMenu(id);
	});
	
	$(document).on('click', '.pagdown', function(){
		var i = $(this).attr('data-pag');
		var c = parseInt($('#pagbox'+i).attr('data-cur'));
		var m = parseInt($('#pagbox'+i).attr('data-max'));
		var s = c > 1 ? c - 1 : m;
		$('#pagbox'+i).find('.pagzone').hide();
		$('#pagbox'+i).find('.pagitem'+s).show();
		$('#pagbox'+i).attr('data-cur', s);
	});

	$(document).on('click', '.pagup', function(){
		var i = $(this).attr('data-pag');
		var c = parseInt($('#pagbox'+i).attr('data-cur'));
		var m = parseInt($('#pagbox'+i).attr('data-max'));
		var s = c < m ? c + 1 : 1;
		$('#pagbox'+i).find('.pagzone').hide();
		$('#pagbox'+i).find('.pagitem'+s).show();
		$('#pagbox'+i).attr('data-cur', s);
	});
	
	$(document).on('click', '.paglist', function(){
		var id = $(this).attr('data-pag');
		var pag = $(this).attr('data-item');
		$('#pagbox'+id).find('.paglist').removeClass('pagselected');
		$('#pagbox'+id).find('.pagzone').hide();
		$('#pagbox'+id).find('.pagitem'+pag).show();
		$(this).addClass('pagselected');
	});
	
	$(document).on('click', '.pagdot', function(){
		var id = $(this).attr('data-pag');
		var pag = $(this).attr('data-item');
		$('#pagbox'+id).find('.pagdot').removeClass('pagselected');
		$('#pagbox'+id).find('.pagzone').hide();
		$('#pagbox'+id).find('.pagitem'+pag).show();
		$(this).addClass('pagselected');
	});
	
	$(document).on('click', '.pagload', function(){
		var i = $(this).attr('data-pag');
		var c = parseInt($('#pagbox'+i).attr('data-cur'));
		var m = parseInt($('#pagbox'+i).attr('data-max'));
		if(c < m){
			c++;
			$('#pagbox'+i).attr('data-cur', c);
			$('#pagbox'+i).find('.pagitem'+c).show();
			if(c >= m){
				$('.pagload'+i).replaceWith("");
			}
		}
	});
	
	
	$(document).on('click', '.bswitch', function(){
		var cval = $(this).attr('data');
		var callback = $(this).attr('data-c');
		if(cval == 1){
			$(this).attr('data', 0);
			$(this).switchClass( "onswitch", "offswitch", 100);
			$(this).find('.bball').switchClass( "onball", "offball", 100, function(){ window[callback](); });
		}
		else if(cval == 0){
			$(this).attr('data', 1);
			$(this).switchClass( "offswitch", "onswitch", 100);
			$(this).find('.bball').switchClass( "offball", "onball", 100, function(){ window[callback](); });
		}
	});
	
	var modal = document.getElementById('small_modal');	
	var largeModal = document.getElementById('large_modal');
	
	vidOff = function(){
		$('.vidstream').removeClass('over_stream');
	}
	audOff = function(){
		$('.audstream').removeClass('over_stream');
	}
	
	vidaudOff = function(){
		vidOff();
		audOff();
	}
	vidOn = function(){
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
	audOn = function(){
		if(!insideChat()){
			$('.vidminus').replaceWith("");
		}
		if($('.modal_in:visible').length){
			$('.audstream').addClass('over_stream');
		}
		else {
			audOff();
		}
	}
	
	closeVideo = function(){
		$('#wrap_stream').html('');
		$('#container_stream').hide();
		vidOff();
	}
	
	closeAudio = function(){
		$('#wrap_stream_audio').html('');
		$('#container_stream_audio').hide();
		audOff();
	}
	
	toggleStream = function(type){
		if(type == 1){
			$("#container_stream").addClass('streamout');
			$('#mstream').removeClass('streamhide');
		}
		if(type == 2){
			$("#container_stream").removeClass('streamout');
			$('#mstream').addClass('streamhide');
		}
	}
	
	toggleStreamAudio = function(type){
		if(type == 1){
			$("#container_stream_audio").addClass('streamout');
			$('#mstream_audio').removeClass('streamhide');
		}
		if(type == 2){
			$("#container_stream_audio").removeClass('streamout');
			$('#mstream_audio').addClass('streamhide');
		}
	}
	
	$(document).on('click', '.boom_sel', function(){
		var e = $(this).closest(".boom_sel_container").find(".boom_opt_container");
		toggleSel(e);
	});
	
	$(document).on('click', '.boom_opt', function(){
		var e = $(this).closest(".boom_sel_container").find(".boom_sel");
		var d = $(this).attr('data');
		var i = $(this).attr('data-icon');
		var t = $(this).attr('data-text');
		e.attr('data', d);
		e.find('.boom_cur_text').text(t);
		e.find('.boom_cur_icon').attr('src', i);
		toggleSel($(this).parent());
	});
	
	$(function() {
		$( "#container_stream" ).draggable({
			handle: "#move_video",
			containment: "document",
		});
		$( "#container_stream_audio" ).draggable({
			handle: "#move_audio",
			containment: "document",
		});
		$( "#container_call" ).draggable({
			handle: "#move_cam",
			containment: "document",
		});
	});
	
	createYoutube = function(s){
		$('#wrap_stream').html('<iframe src="'+s+'" allowfullscreen scrolling="" frameborder=""></iframe>');
	}
	createVideo = function(s){
		if(autoVideo == 1){
			$('#wrap_stream').html('<video autoplay src="'+s+'" controls></video>');
		}
		else {
			$('#wrap_stream').html('<video src="'+s+'" controls></video>');
		}
	}
	createAudio = function(s){
		if(autoAudio == 1){
			$('#wrap_stream_audio').html('<audio autoplay src="'+s+'" controls></audio>');
		}
		else {
			$('#wrap_stream_audio').html('<audio preload="none" src="'+s+'" controls></audio>');
		}
		audOn();
	}
	
	boomVideo = function(type, vlink){
		$("#container_stream").removeClass('streamout').fadeIn(300);
		$('#mstream').addClass('streamhide');
		if(type == 'youtube'){
			createYoutube(vlink);
		}
		else if(type == 'uvideo'){
			createVideo(vlink);
		}
		vidOn();
	}
	
	boomAudio = function(vlink){
		$("#container_stream_audio").removeClass('streamout').fadeIn(300);
		$('#mstream_audio').addClass('streamhide');
		createAudio(vlink);
	}
	
	$(document).on('click', '.boomcvideo', function(){
		var elem = $(this).parent().find('.boomvideo');
		var vlink = $(elem).attr('data');
		var type = $(elem).attr('value');
		boomVideo(type, vlink);
	});
	
	$(document).on('click', '.boomvideo', function(){
		event.preventDefault();
		var vlink = $(this).attr('data');
		var type = $(this).attr('value');
		boomVideo(type, vlink);
	});
	
	$(document).on('click', '.boomaudio', function(){
		event.preventDefault();
		var vlink = $(this).attr('data');
		boomAudio(vlink);
	});
	
	$(document).on('click', '#app_reload', function(){
		location.reload();
	});
	
});