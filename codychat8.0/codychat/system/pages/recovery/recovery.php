<?php
$valid = 1;
if(!isset($_GET['k'], $_GET['t'], $_GET['v'])){
	$valid = 0;
}
else if(!validRecovery($_GET['k'], $_GET['t'], $_GET['v'])){
	$valid = 0;
}
if($valid == 1){
	$reck = htmlspecialchars($_GET['k']);
	$recv = htmlspecialchars($_GET['v']);
	$rect = htmlspecialchars(intval($_GET['t']));
}
?>
<?php if($valid == 1){ ?>
<div class="page_full vheight">
	<div class="page_element">
		<div class="pad15">
			<div id="recovery_form">
				<div class="recovery_top bpad20">
					<p class="text_med bold bpad5"><?php echo $lang['pass_reset']; ?></p>
					<p><?php echo $lang['recovery_tip']; ?></p>
				</div>
				<div class="setting_element">
					<p class="label"><?php echo $lang['new_pass']; ?></p>
					<input type="password" maxlength="50" id="recovery_new" class="full_input"/>
				</div>
				<div class="setting_element">
					<p class="label"><?php echo $lang['repeat_pass']; ?></p>
					<input type="password" maxlength="50" id="recovery_repeat" class="full_input"/>
				</div>
				<div id="recovery_send" class="tpad5">
					<button onclick="sendRecoveryReset();"  class="reg_button theme_btn"><i class="fa fa-paper-plane"></i> <?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="recovery_success" class="centered_element pad25 hidden">
				<p class="text_ultra success"><i class="fa fa-check-circle"></i></p>
				<p class="text_large bold bpad10"><?php echo $lang['pass_updated']; ?></p>
				<p class=""><?php echo $lang['recovery_done']; ?></p>
				<div class="tpad15">
					<button onclick="openSamePage('<?php echo $setting['domain']; ?>');" class="reg_button theme_btn"><?php echo $lang['login']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
const recoveryK = '<?php echo $reck; ?>';
const recoveryV = '<?php echo $recv; ?>';
const recoveryT = '<?php echo $rect; ?>';

var waitRecovery = 0;
sendRecoveryReset = function(){
	var upass = $('#recovery_new').val();
	var urepeat = $('#recovery_repeat').val();
	if(upass == '' || urepeat == ''){
		callSaved(system.emptyField, 3);
		return false;
	}
	else if (/^\s+$/.test($('#recovery_new').val())){
		callSaved(system.emptyField, 3);
		$('#recovery_new').val("");
		return false;
	}
	else if (/^\s+$/.test($('#recovery_repeat').val())){
		callSaved(system.emptyField, 3);
		$('#recovery_repeat').val("");
		return false;
	}
	else {
		if(waitRecovery == 0){
			waitRecovery = 1;
			$.post('system/action/recovery.php', {
				rpass: upass, 
				rrepeat: urepeat,
				rk: recoveryK,
				rv: recoveryV,
				rt: recoveryT
				}, function(response) {
					if(response == 1){
						resetRecoveryUrl();
					}
					else if(response == 2){
						callSaved(system.notMatch, 3);
					}
					else if(response == 3){
						callSaved(system.invalidPass, 3);
					}
					else if(response == 4){
						callSaved(system.emptyField, 3);
					}
					else {
						callSaved(system.error, 3);
					}
					waitRecovery = 0;
			});
		}
		else {
			return false;
		}
	}
}

resetRecoveryUrl = function(){
	$('#recovery_form').hide();
	$('#recovery_success').show();
	window.history.replaceState({}, null, '<?php echo $setting['domain'] . '/'; ?>');
}	
</script>
<?php } ?>
<?php if($valid == 0){ ?>
<div class="page_full vheight">
	<div class="page_element">
		<div class="pad15">
			<div id="recovery_form">
				<div class="centered_element pad25">
					<p class="text_ultra error"><i class="fa fa-exclamation-triangle"></i></p>
					<p class="text_large bold bpad10"><?php echo $lang['something_wrong']; ?></p>
					<p class=""><?php echo $lang['recovery_invalid']; ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>