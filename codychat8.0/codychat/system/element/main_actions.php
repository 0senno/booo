<?php if(canRankUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'change_rank');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-star"></i></div>
	<div class="sub_list_content"><?php echo $lang['change_rank']; ?></div>
</div>
<?php } ?>
<?php if(!isWarned($boom) && canWarnUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'warn');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-exclamation-triangle warn"></i></div>
	<div class="sub_list_content"><?php echo $lang['warn']; ?></div>
</div>
<?php } ?>
<?php if(!isMuted($boom) && canMuteUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'mute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone-slash error"></i></div>
	<div class="sub_list_content"><?php echo $lang['mute']; ?></div>
</div>
<?php } ?>
<?php if(isMuted($boom) && canMuteUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'unmute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone success"></i></div>
	<div class="sub_list_content"><?php echo $lang['unmute']; ?></div>
</div>
<?php } ?>
<?php if(!isMainMuted($boom) && !isMuted($boom) && canMuteUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'main_mute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone-slash error"></i></div>
	<div class="sub_list_content"><?php echo $lang['main_mute']; ?></div>
</div>
<?php } ?>
<?php if(isMainMuted($boom) && !isMuted($boom) && canMuteUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'main_unmute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone-slash success"></i></div>
	<div class="sub_list_content"><?php echo $lang['main_unmute']; ?></div>
</div>
<?php } ?>
<?php if(!isPrivateMuted($boom) && !isMuted($boom) && canMuteUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'private_mute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone-slash error"></i></div>
	<div class="sub_list_content"><?php echo $lang['private_mute']; ?></div>
</div>
<?php } ?>
<?php if(isPrivateMuted($boom) && !isMuted($boom) && canMuteUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'private_unmute');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-microphone-slash success"></i></div>
	<div class="sub_list_content"><?php echo $lang['private_unmute']; ?></div>
</div>
<?php } ?>
<?php if(!isGhosted($boom) && !isMuted($boom) && canGhostUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'ghost');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-ghost error"></i></div>
	<div class="sub_list_content"><?php echo $lang['ghost']; ?></div>
</div>
<?php } ?>
<?php if(isGhosted($boom) && !isMuted($boom) && canGhostUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'unghost');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-ghost success"></i></div>
	<div class="sub_list_content"><?php echo $lang['unghost']; ?></div>
</div>
<?php } ?>
<?php if(isKicked($boom) && canKickUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'unkick');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-bolt success"></i></div>
	<div class="sub_list_content"><?php echo $lang['unkick']; ?></div>
</div>
<?php } ?>
<?php if(!isKicked($boom) && canKickUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'kick');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-bolt error"></i></div>
	<div class="sub_list_content"><?php echo $lang['kick']; ?></div>
</div>
<?php } ?>
<?php if(isBanned($boom) && canBanUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'unban');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-ban success"></i></div>
	<div class="sub_list_content"><?php echo $lang['unban']; ?></div>
</div>
<?php } ?>
<?php if(!isBanned($boom) && canBanUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'ban');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-ban error"></i></div>
	<div class="sub_list_content"><?php echo $lang['ban']; ?></div>
</div>
<?php } ?>
<?php if(canDeleteUser($boom)){ ?>
<div onclick="listAction(<?php echo $boom['user_id']; ?>, 'delete_account');" class="sub_list_item bbackhover action_item">
	<div class="sub_list_icon"><i class="fa fa-trash-can error"></i></div>
	<div class="sub_list_content"><?php echo $lang['delete_account']; ?></div>
</div>
<?php } ?>