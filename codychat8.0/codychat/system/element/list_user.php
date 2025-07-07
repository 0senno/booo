<div class="bhover user_item">
	<div class="user_item_avatar">
		<img class="lazy avav acav" data-src="<?php echo myAvatar($boom['user_tumb']); ?>" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="user_item_data">
		<p class="username <?php echo myColorFont($boom); ?>"><?php echo $boom["user_name"]; ?></p>
		<p class="list_mood"><?php echo $boom['user_mood']; ?></p>
	</div>
</div>