<?php if($boom['badge_member'] > 0){ ?>
<div title="<?php echo $lang['badge_member_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_member<?php echo $boom['badge_member']; ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_auth'] > 0){ ?>
<div title="<?php echo $lang['badge_auth_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_auth.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_beat'] > 0){ ?>
<div title="<?php echo $lang['badge_beat_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_beat.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_beat']); ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_chat'] > 0 && useLevel()){ ?>
<div title="<?php echo $lang['badge_chat_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_chat.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_chat']); ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_like'] > 0 && useLike()){ ?>
<div title="<?php echo $lang['badge_like_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_like.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_like']); ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_friend'] > 0){ ?>
<div title="<?php echo $lang['badge_friend_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_friend.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_friend']); ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_top'] > 0 && useLevel()){ ?>
<div title="<?php echo $lang['badge_top_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_top.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_top']); ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_gift'] > 0 && useGift()){ ?>
<div title="<?php echo $lang['badge_gift_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_gift.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_gift']); ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_gold'] > 0 && useWallet()){ ?>
<div title="<?php echo $lang['badge_gold_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_gold.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_gold']); ?>.svg"/>
</div>
<?php } ?>
<?php if($boom['badge_ruby'] > 0 && useWallet()){ ?>
<div title="<?php echo $lang['badge_ruby_title']; ?>" class="pbadge badge_info">
	<img class="pbadge_img" src="default_images/badge/badge_ruby.svg"/>
	<img class="pbadge_count" src="default_images/badge/numbers/<?php echo badgeCount($boom['badge_ruby']); ?>.svg"/>
</div>
<?php } ?>
