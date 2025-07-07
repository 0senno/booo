<div id="boom_news<?php echo $boom['id']; ?>" data="<?php echo $boom['id']; ?>" class="news_box blist post_element">
	<div class="post_title">
		<div class=" post_avatar get_info" data="<?php echo $boom['user_id']; ?>">
			<img src="<?php echo myAvatar($boom['user_tumb']); ?>"/>
		</div>
		<div class="bcell_mid hpad5 maxflow post_info">
			<p class="username text_small <?php echo myColor($boom); ?>"><?php echo $boom['user_name']; ?></p>
			<p class="text_xsmall sub_date"><?php echo displayDate($boom['news_date']); ?></p>
		</div>
		<div onclick="openPostOptions(this);" class="post_edit bcell_mid_center">
			<i class="fa fa-ellipsis-h"></i>
			<div class="post_menu back_menu bshadow fmenu">
				<div onclick="viewNewsLikes(<?php echo $boom['id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('heart', $lang['view_likes'], $lang['like_text']); ?>
				</div>
				<?php if(mySelf($boom['news_poster'])){ ?>
				<div onclick="openNewsOptions(<?php echo $boom['id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('cogs', $lang['post_options'], $lang['post_config']); ?>
				</div>
				<?php } ?>
				<?php if(canDeleteNews($boom)){ ?>
				<div onclick="openDeletePost('news', <?php echo $boom['id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('trash', $lang['delete'], $lang['delete_text']); ?>
				</div>
				<?php } ?>
				<?php if(canReport() && !canDeleteNews($boom)){ ?>
				<div onclick="reportNewsLog(<?php echo $boom['id']; ?>);" class="submenu_item submenu">
					<?php echo subMenu('exclamation-circle', $lang['report'], $lang['report_text']); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="post_content">
		<?php echo boomPostIt($boom, $boom['news_message']); ?>
		<?php echo boomPostFile($boom['news_file'], $boom['news_file_type']); ?>
	</div>
	<div class="post_control btauto">
		<?php if(allowNewsLikes($boom)){ ?>
		<div class="bcell_mid like_container newslike<?php echo $boom['id']; ?>">
			<?php echo getLikes($boom['id'], $boom['liked'], 'news'); ?>
		</div>
		<?php } ?>
		<div data="0" class="bcell_mid comment_count bcauto load_comment <?php if($boom['reply_count'] < 1){ echo 'hidden'; } ?>" onclick="loadNewsComment(this, <?php echo $boom['id']; ?>);">
			<span id="nrepcount<?php echo $boom['id']; ?>"><?php echo $boom['reply_count']; ?></span> <img class="comment_icon" src="default_images/icons/comment.svg"/>
		</div>
	</div>
	<?php if(canReplyNews() && allowNewsComment($boom)){ ?>
	<div class="add_comment_zone cmb<?php echo $boom['id']; ?>">
		<div class="tpad10 reply_post">
			<form class="news_reply_form" data-id="<?php echo $boom['id']; ?>">
				<input maxlength="500" placeholder="<?php echo $lang['comment_here']; ?>" class="add_comment full_input">
			</form>		
		</div>
	</div>
	<?php } ?>
	<div class="tpad10 ncmtboxwrap<?php echo $boom['id']; ?>">
		<div class="ncmtbox ncmtbox<?php echo $boom['id']; ?>">
		</div>
		<div class="nmorebox nmorebox<?php echo $boom['id']; ?>">
		</div>
		<div class="clear"></div>
	</div>
</div>