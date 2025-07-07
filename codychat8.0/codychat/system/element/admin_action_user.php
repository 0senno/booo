<?php
$time_left = getActionTimer($boom['type'], $boom);
?>
<div class="sub_list_item members_found blisting" id="foundaction<?php echo $boom['user_id']; ?>">
	<div class="sub_list_avatar">
		<img class="lazy admin_user<?php echo $boom['user_id']; ?>" data-src="<?php echo myAvatar($boom['user_tumb']); ?>" src="<?php echo imgLoader(); ?>"/>
		<img class="sub_list_active" src="<?php echo userActive($boom); ?>"/>
	</div>
	<div class="sub_list_name" onclick="getProfile(<?php echo $boom['user_id']; ?>);">
		<p class="username  <?php echo myColor($boom); ?>"><?php echo $boom['user_name']; ?></p>
		<?php if($time_left != ''){ ?>
		<p class="sub_text text_xsmall"><?php echo $time_left; ?></p>
		<?php } ?>
	</div>
	<div onclick="removeSystemAction(this, <?php echo $boom['user_id']; ?>, '<?php echo getActionType($boom['type']); ?>');" class="sub_list_option">
		<i class="fa fa-times edit_btn"></i>
	</div>
</div>