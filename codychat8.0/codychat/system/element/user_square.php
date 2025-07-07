<div class="user_square_elem view_friend" data-name="<?php echo $boom['user_name']; ?>" data-avatar="<?php echo myAvatar($boom['user_tumb']); ?>" data-id="<?php echo $boom['user_id']; ?>">
	<img data-src="<?php echo myAvatar($boom['user_tumb']); ?>" class="lazy avatar_friends" src="<?php echo imgLoader(); ?>"/>
	<div class="square_name lite_olay">
		<?php echo $boom['user_name']; ?>
	</div>
</div>