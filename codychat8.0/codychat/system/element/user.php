<div class="ulist_item bbackhover" onclick="getProfile(<?php echo $boom['user_id']; ?>);">
	<div class="ulist_avatar">
		<img class="lazy" data-src="<?php echo myAvatar($boom['user_tumb']); ?>" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="ulist_name">
		<p class="username <?php echo myColor($boom); ?>"><?php echo $boom["user_name"]; ?></p>
	</div>
</div>