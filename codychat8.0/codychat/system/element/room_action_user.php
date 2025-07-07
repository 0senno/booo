<?php
$time_left = boomTimeLeft($boom['timer']);
?>
<div class="ulist_item bbackhover">
	<div class="ulist_avatar">
		<img class="lazy" data-src="<?php echo myAvatar($boom['user_tumb']); ?>" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="ulist_name">
		<p class="username <?php echo myColor($boom); ?>"><?php echo $boom["user_name"]; ?></p>
		<?php if($time_left != ''){ ?>
		<p class="sub_text text_xsmall"><?php echo $time_left; ?></p>
		<?php } ?>
	</div>
	<div onclick="removeRoomAction(this, '<?php echo $boom['action']; ?>', <?php echo $boom['user_id']; ?>);" class="ulist_option">
		<i class="fa fa-times"></i>
	</div>
</div>