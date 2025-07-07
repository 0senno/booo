$(document).ready(function(){
	
	var audio = document.createElement("audio");
	audio.volume = 0.5;
	
	$(function() {
		var slider = $('#slider');
		slider.slider({
			range: "min",
			min: 0,
			max:100,
			value: 50,
			slide: function(event, ui) {
				var newVolume = slider.slider('value');
				var sSound = $('.show_sound');
				audio.volume = newVolume / 100;
				if(newVolume < 20) { 
					sSound.removeClass('fa-volume-up fa-volume-down').addClass('fa-volume-off');
				} 
				else if (newVolume < 71) {
					sSound.removeClass('fa-volume-up fa-volume-off').addClass('fa-volume-down');
				} 
				else {
					sSound.removeClass('fa-volume-down fa-volume-off').addClass('fa-volume-up');
				} 
			},
			stop: function(event,ui) {
				var value = slider.slider('value');
				$('#volume').text(value+"%");
				audio.volume = value / 100;
			},
		});
	});
	$(document).on('click', '.turn_on_play', function(){
		audio.src = source;
		$(this).toggleClass("turn_on_play turn_off_play");
		$(this).children().toggleClass("fa-play-circle fa-stop-circle");
		audio.play();
	});
	$(document).on('click', '.turn_off_play', function(){
		audio.src = "sounds/mute.mp3";
		$(this).toggleClass("turn_off_play turn_on_play");
		$(this).children().toggleClass("fa-stop-circle fa-play-circle");
		audio.pause();
	});
	$(document).on('click', '.radio_item', function(){
		var newSource = $(this).attr('data');
		var sourceTitle = $(this).text();
		hideModal();
		$('#player_actual_status').removeClass("turn_on_play").addClass("turn_off_play");
		$('#current_play_btn').addClass("fa-stop-circle").removeClass('fa-play-circle');
		$('#current_station').text(sourceTitle);
		source = newSource;
		audio.src = newSource;
		audio.play();
	});
	
});