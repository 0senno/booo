<?php
if(!defined('BOOM')){
	die();
}
?>
<div class="out_page_container back_page">
	<div class="out_page_content">
		<div class="out_page_box">
			<div class="pad_box">
				<div class="bpad15">
					<img class="large_icon" src="default_images/icons/warning.svg"/>
				</div>
				<div class="bpad10">
					<p class="text_xlarge bold bpad10"><?php echo $lang['kick_title']; ?></p>
					<p class="text_med"><?php echo $lang['kick_text']; ?></p>
				</div>
				<div class="vpad10">
					<p id="kick_timer" class="centered_element text_jumbo bold"></p>
				</div>
				<?php if(!empty($data['kick_msg'])){ ?>
				<div class="tpad10">
					<p class="bold theme_color bpad5"><?php echo $lang['reason_given']; ?></p>
					<p class="text_med"><?php echo renderReason($data['kick_msg']); ?></p>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script data-cfasync="false">
var boomTime = <?php echo time(); ?>;
boomCountDown = function(){
	var kickEnd = <?php echo $data['user_kick']; ?>;
	if(boomTime >= kickEnd){
		location.reload();
	}
	else {
		var remain = kickEnd - boomTime;
		var days = Math.floor(remain / (60 * 60 * 24));
		var hours = Math.floor(((remain % (60 * 60 * 24)) / (60 * 60)) + (days * 24));
		var minutes = Math.floor((remain % (60 * 60)) / (60));
		var seconds = Math.floor((remain % (60)));
		if(hours < 10){
			hours = '0'+hours;
		}
		if(minutes < 10){
			minutes = '0'+minutes;
		}
		if(seconds < 10){
			seconds = '0'+seconds;
		}
		if(hours >= 24){
			days = Math.floor(hours / 24);
			hours = 23;
		}
		if(days > 0){
			$('#kick_timer').html(days + ":" + hours + ":" + minutes + ":" + seconds);
		}
		else {
			$('#kick_timer').html(hours + ":" + minutes + ":" + seconds);
		}
		boomTime = boomTime + 1;
	}
}
checkKick = function(){
	$.post('system/action/action_out.php', {
		check_kick: 1,
		}, function(response) {
			if(response == 1){
				location.reload();
			}
	});	
}
$(document).ready(function(){
	boomKickTimer = setInterval(boomCountDown, 1000);
	boomCheckKick = setInterval(checkKick, 30000);
	boomCountDown();
	checkKick();
});
</script>
