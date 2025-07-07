<div class="ulist_item bbackhover">
	<div class="ulist_avatar">
		<img class="lazy" data-src="<?php echo myAvatar($boom['user_tumb']); ?>" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="ulist_name">
		<p class="username <?php echo myColor($boom); ?>"><?php echo $boom["user_name"]; ?></p>
		<p class="text_small sub_text"><?php echo roomRankTitle($boom['room_rank']); ?></p>
	</div>
	<div class="ulist_rank">
		<?php echo roomRank($boom['room_rank'], 'ulist_ranking'); ?>
	</div>
	<?php if(!mySelf($boom['user_id']) && canEditRoom()){ ?>
	<div onclick="removeRoomStaff(this, <?php echo $boom['user_id']; ?>);" class="ulist_option">
		<i class="fa fa-times"></i>
	</div>
	<?php } ?>
</div>