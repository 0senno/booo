<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(80)){
	die();
}
$result = getDashboard();
?>
<?php echo elementTitle($lang['dashboard']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_members">
					<i class="fa fa-users"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['registered']; ?></p>
					<p class="sp_count"><?php echo $result['user_count']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_members">
					<i class="fa fa-toggle-on"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['online']; ?></p>
					<p class="sp_count"><?php echo $result['online_count']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_female">
					<i class="fa fa-female"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['female']; ?></p>
					<p class="sp_count"><?php echo $result['female_count']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_male">
					<i class="fa fa-male"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['male']; ?></p>
					<p class="sp_count"><?php echo $result['male_count']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_muted">
					<i class="fa fa-microphone-slash"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['muted']; ?></p>
					<p class="sp_count"><?php echo $result['muted_users']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_kicked">
					<i class="fa fa-bolt"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['kicked']; ?></p>
					<p class="sp_count"><?php echo $result['kicked_users']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_verified">
					<i class="fa fa-ghost"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['ghosted']; ?></p>
					<p class="sp_count"><?php echo $result['ghosted_users']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_banned">
					<i class="fa fa-ban"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['banned']; ?></p>
					<p class="sp_count"><?php echo $result['banned_users']; ?></p>
				</div>
			</div>
		</div>
		<?php if(boomAllow(90)){ ?>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_chat">
					<i class="fa fa-comments"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['chat_logs']; ?></p>
					<p class="sp_count"><?php echo $result['chat_count']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_private">
					<i class="fa fa-comments"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['private_logs']; ?></p>
					<p class="sp_count"><?php echo $result['private_count']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_post">
					<i class="fa fa-rss"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['post_count']; ?></p>
					<p class="sp_count"><?php echo $result['post_count']; ?></p>
				</div>
			</div>
		</div>
		<div class="sp_box bback">
			<div class="sp_content">
				<div class="sp_icon back_theme bcell_mid sp_reply">
					<i class="fa fa-reply"></i>
				</div>
				<div class="sp_info bcell_mid">
					<p class="sp_title"><?php echo $lang['post_reply']; ?></p>
					<p class="sp_count"><?php echo $result['reply_count']; ?></p>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
</div>