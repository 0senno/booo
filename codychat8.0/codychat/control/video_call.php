<?php
if(!defined('BOOM')){
	die();
}
?>
<div class="btable" style="width:100%; height:100%;">
	<div class="bcell_mid centered_element" style="width:100%; height:100%;">
		<div id="vcall_streams">
		</div>
		<div id="vcall_self" class="vcallhide">
		</div>
		<div id="vcall_control_wrap">
			<div id="vcall_control">
				<div class="bcell">
				</div>
				<div id="vcall_cam" class="bcell_mid vcall_btn">
					<img class="vcall_icon" src="default_images/call/video.svg" />
				</div>
				<div class="bcell vcall_spacer">
				</div>
				<div id="vcall_mic" class="bcell_mid vcall_btn">
					<img class="vcall_icon" src="default_images/call/microphone.svg" />
				</div>
				<div class="bcell vcall_spacer">
				</div>
				<div id="vcall_leave" class="bcell_mid vcall_btn">
					<img class="vcall_icon" src="default_images/call/leave.svg" />
				</div> 
				<div class="bcell">
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(agoraCall()){ ?>
<script>
	var appcall = '<?php echo $call['call_id']; ?>';
	var appuser = <?php echo (int) $data['user_id']; ?>;
</script>
<script src="js/agora/agora.js<?php echo $bbfv; ?>"></script>
<script src="js/agora/main_video.js<?php echo $bbfv; ?>"></script>
<?php } ?>
<?php if(livekitCall()){ ?>
<script>
	var appcall = '<?php echo $call['call_id']; ?>';
	var appuser = <?php echo (int) $data['user_id']; ?>;
</script>
<script src="js/livekit/livekit.js<?php echo $bbfv; ?>"></script>
<script src="js/livekit/main_video.js<?php echo $bbfv; ?>"></script>
<?php } ?>