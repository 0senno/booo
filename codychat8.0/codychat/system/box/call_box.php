<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	die();
}
$target = escape($_POST['target'], true);
$user = userRelationDetails($target);

if(empty($user)){
	die();
}

$no_call = 0;

if(!useCall()){
	$no_call++;
}

if(!canCallUser($user)){
	$no_call++;
}
?>
<?php if($no_call > 0){ ?>
<div class="modal_content">
	<div class="centered_element hpad25">
		<div class="centered_element">
			<img class="med_avatar brad50" src="<?php echo myAvatar($user['user_tumb']); ?>"/>
		</div>
		<div class="text_large bold">
			<?php echo $user['user_name']; ?>
		</div>
		<p class="vpad5"><?php echo $lang['cannot_call']; ?></p>
	</div>
</div>
<div class="modal_control centered_element">
	<button class="close_over delete_btn reg_button"><?php echo $lang['close']; ?></button>
</div>
<?php } ?>
<?php if($no_call == 0){ ?>
<div class="modal_content">
	<div class="centered_element hpad25">
		<div class="centered_element">
			<img class="med_avatar brad50" src="<?php echo myAvatar($user['user_tumb']); ?>"/>
		</div>
		<div class="text_large bold">
			<?php echo $user['user_name']; ?>
		</div>
		<p class="vpad5"><?php echo $lang['call_select']; ?></p>
	</div>
</div>
<div class="modal_control centered_element">
	<?php if(canVideoCall()){ ?>
	<div>
		<button data-user="<?php echo $user['user_id']; ?>" data-type="1" class="startcall delete_btn large_button"><i class="fa fa-video-camera"></i>  <?php echo $lang['video_call']; ?></button>
	</div>
	<?php } ?>
	<?php if(canAudioCall()){ ?>
	<div class="tpad10">
		<button data-user="<?php echo $user['user_id']; ?>" data-type="2" class="startcall default_btn large_button"><i class="fa fa-microphone"></i> <?php echo $lang['audio_call']; ?></button>
	</div>
	<?php } ?>
	<?php if(useCallBalance()){ ?>
	<div class="tpad15">
		<div class="bpad3">
		<?php echo costTags($setting['call_method'], $setting['call_cost'], array('text'=> $lang['call_cost'])); ?>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>