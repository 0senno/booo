<div id="call_pending" data="<?php echo $boom['call_id']; ?>" data-call="0" class="pad25">
	<div class="modal_content">
		<div class="centered_element hpad25">
			<div class="centered_element">
				<img class="med_avatar brad50" src="<?php echo myAvatar($boom['user_tumb']); ?>"/>
			</div>
			<div class="text_large bold">
				<?php echo $boom['user_name']; ?>
			</div>
			<p class="vpad5"><?php echo $lang['call_outtext']; ?></p>
		</div>
	</div>
	<div class="modal_control">
		<div class="centered_element">
			<button onclick="cancelCall(<?php echo $boom['call_id']; ?>);" class="delete_btn reg_button"><?php echo $lang['cancel']; ?></button>
		</div>
	</div>
	<?php if(playSound(5)){ ?>
	<audio class="hidden" id="action_sound" src="sounds/call_out.mp3<?php echo boomFileVersion(); ?>" autoplay loop></audio>
	<?php } ?>
</div>