<?php
if(!defined('BOOM')){
	die();
}
?>
<div class="btable" style="width:100%; height:100%;">
	<div class="bcell_mid" style="width:100%; height:100%;">
		<div id="vcall_streams" class="call_item_container">
		</div>
		<div class="centered_element" id="vcall_control_wrap">
			<div id="vcall_group_control">
				<div class="bcell">
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
<script src="js/agora/group_audio.js<?php echo $bbfv; ?>"></script>
<?php } ?>
<?php if(livekitCall()){ ?>
<script>
	var appcall = '<?php echo $call['call_id']; ?>';
	var appuser = <?php echo (int) $data['user_id']; ?>;
</script>
<script src="js/livekit/livekit.js<?php echo $bbfv; ?>"></script>
<script src="js/livekit/group_audio.js<?php echo $bbfv; ?>"></script>
<?php } ?>