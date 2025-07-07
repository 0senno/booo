<div id="call_incoming" data="<?php echo $boom['call_id']; ?>" data-call="0" class="pad25">
	<div class="modal_content">
		<div class="centered_element hpad25">
			<div class="centered_element">
				<img class="med_avatar brad50" src="<?php echo myAvatar($boom['user_tumb']); ?>"/>
			</div>
			<div class="text_large bold">
				<?php echo $boom['user_name']; ?>
			</div>
			<?php if($boom['call_type'] == 1){ ?>
				<p class="vpad5"><?php echo $lang['call_invideo']; ?></p>
			<?php } ?>
			<?php if($boom['call_type'] == 2){ ?>
				<p class="vpad5"><?php echo $lang['call_inaudio']; ?></p>
			<?php } ?>
		</div>
	</div>
	<div class="modal_control">
		<div class="centered_element">
			<button onclick="acceptCall(<?php echo $boom['call_id']; ?>);" class="ok_btn reg_button"><?php echo $lang['answer']; ?></button>
			<button onclick="declineCall(<?php echo $boom['call_id']; ?>);" class="delete_btn reg_button"><?php echo $lang['decline']; ?></button>
		</div>
	</div>
	<?php if(playSound(5)){ ?>
	<audio class="hidden" id="action_sound" src="sounds/call_in.mp3<?php echo boomFileVersion(); ?>" autoplay loop></audio>
	<?php } ?>
</div>