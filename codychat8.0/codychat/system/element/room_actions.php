<?php if(canEditRoom() && canRoomAction($boom, 6)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'room_rank');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-star"></i></div>
	<div class="sub_list_content"><?php echo $lang['change_rank']; ?></div>
</div>
<?php } ?>
<?php if($boom['room_muted'] < time() && canRoomAction($boom, 4, 2)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'room_mute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone-slash error"></i></div>
	<div class="sub_list_content"><?php echo $lang['mute']; ?></div>
</div>
<?php } ?>
<?php if($boom['room_muted'] > time() && canRoomAction($boom, 4, 2)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'room_unmute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone success"></i></div>
	<div class="sub_list_content"><?php echo $lang['unmute']; ?></div>
</div>
<?php } ?>
<?php if($boom['room_blocked'] < time() && canRoomAction($boom, 5, 2)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'room_block');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa-regular fa-hand error"></i></div>
	<div class="sub_list_content"><?php echo $lang['block']; ?></div>
</div>
<?php } ?>
<?php if($boom['room_blocked'] > time() && canRoomAction($boom, 5, 2)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'room_unblock');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa-regular fa-hand success"></i></div>
	<div class="sub_list_content"><?php echo $lang['unblock']; ?></div>
</div>
<?php } ?>