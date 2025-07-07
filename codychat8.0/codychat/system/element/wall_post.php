<div class="blist post_element" id="boom_post<?php echo $boom['post_id']; ?>">
	<div class="post_title">
		<div class="post_avatar get_info" data="<?php echo $boom['user_id']; ?>">
			<img src="<?php echo myAvatar($boom['user_tumb']); ?>"/>
		</div>
		<div class="hpad5 post_info maxflow bcell_mid">
			<p class="text_small username <?php echo myColor($boom); ?>"><?php echo $boom['user_name']; ?></p>
			<p class="text_xsmall sub_date"><?php echo displayDate($boom['post_date']); ?></p>
		</div>
		<div onclick="openPostOptions(this);" class="post_edit bcell_mid_center">
			<i class="fa fa-ellipsis-h"></i>
			<div class="post_menu back_menu bshadow fmenu">
				<div onclick="viewWallLikes(<?php echo $boom['post_id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('heart', $lang['view_likes'], $lang['like_text']); ?>
				</div>
				<?php if(mySelf($boom['post_user'])){ ?>
				<div onclick="openWallOptions(<?php echo $boom['post_id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('cogs', $lang['post_options'], $lang['post_config']); ?>
				</div>
				<?php } ?>
				<?php if(canDeleteWall($boom)){ ?>
				<div onclick="openDeletePost('wall', <?php echo $boom['post_id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('trash', $lang['delete'], $lang['delete_text']); ?>
				</div>
				<?php } ?>
				<?php if(canReport() && !canDeleteWall($boom)){ ?>
				<div onclick="reportWallLog(<?php echo $boom['post_id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('exclamation-circle', $lang['report'], $lang['report_text']); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="post_content">
		<?php echo boomPostIt($boom, $boom['post_content']); ?>
		<?php echo boomPostFile($boom['post_file'], $boom['post_file_type']); ?>
	</div>
	<div class="post_control btauto">
		<?php if(allowWallLikes($boom)){ ?>
		<div class="bcell_mid like_container like<?php echo $boom['post_id']; ?>">
			<?php echo getLikes($boom['post_id'], $boom['liked'], 'wall'); ?>
		</div>
		<?php } ?>
		<div data="0" class="bcell_mid comment_count bcauto load_comment <?php if($boom['reply_count'] < 1){ echo 'hidden'; } ?>" onclick="loadComment(this, <?php echo $boom['post_id']; ?>);">
			<span id="repcount<?php echo $boom['post_id']; ?>"><?php echo $boom['reply_count']; ?></span> <img class="comment_icon" src="default_images/icons/comment.svg"/>
		</div>
	</div>
	<?php if(!muted() && allowWallComment($boom)){ ?>
	<div class="add_comment_zone cmb<?php echo $boom['post_id']; ?>">
		<div class="vpad10 reply_post">
			<form class="friend_reply_form" data-id="<?php echo $boom['post_id']; ?>">
				<input  maxlength="500" placeholder="<?php echo $lang['comment_here']; ?>" class="add_comment full_input">
			</form>
		</div>
	</div>
	<?php } ?>
	<div class="cmtboxwrap<?php echo $boom['post_id']; ?>">
		<div class="cmtbox cmtbox<?php echo $boom['post_id']; ?>">
		</div>
		<div class="morebox morebox<?php echo $boom['post_id']; ?>">
		</div>
		<div class="clear"></div>
	</div>
</div>