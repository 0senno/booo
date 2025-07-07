<?php
require('../config_session.php');
if(!useBadge()){
	die();
}
?>
<div class="modal_content">
	<div class="bpad10 hpad20">
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_member1.svg"/>
			</div>
			<div class="bcell_mid pad10">
				<p class="bold bpad3"><?php echo $lang['badge_member_title']; ?></p>
				<p><?php echo $lang['badge_member_info']; ?></p>
			</div>
		</div>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_auth.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_auth_title']; ?></p>
				<p><?php echo $lang['badge_auth_info']; ?></p>
			</div>
		</div>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_beat.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_beat_title']; ?></p>
				<p><?php echo $lang['badge_beat_info']; ?></p>
			</div>
		</div>
		<?php if(useLevel()){ ?>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_chat.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_chat_title']; ?></p>
				<p><?php echo renderBadgeInfo($lang['badge_chat_info'], $setting['bachat']); ?></p>
			</div>
		</div>
		<?php } ?>
		<?php if(useLike()){ ?>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_like.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_like_title']; ?></p>
				<p><?php echo renderBadgeInfo($lang['badge_like_info'], $setting['balike']); ?></p>
			</div>
		</div>
		<?php } ?>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_friend.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_friend_title']; ?></p>
				<p><?php echo renderBadgeInfo($lang['badge_friend_info'], $setting['bafriend']); ?></p>
			</div>
		</div>
		<?php if(useLevel()){ ?>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_top.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_top_title']; ?></p>
				<p><?php echo $lang['badge_top_info']; ?></p>
			</div>
		</div>
		<?php } ?>
		<?php if(useGift()){ ?>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_gift.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_gift_title']; ?></p>
				<p><?php echo renderBadgeInfo($lang['badge_gift_info'], $setting['bagift']); ?></p>
			</div>
		</div>
		<?php } ?>
		<?php if(useWallet()){ ?>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_gold.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_gold_title']; ?></p>
				<p><?php echo renderBadgeInfo($lang['badge_gold_info'], $setting['bagold']); ?></p>
			</div>
		</div>
		<div class="btable blist hpad10 vpad15">
			<div class="bcell_mid badge_info_icon">
				<img src="default_images/badge/badge_ruby.svg"/>
			</div>
			<div class="bcell_mid hpad10">
				<p class="bold bpad3"><?php echo $lang['badge_ruby_title']; ?></p>
				<p><?php echo renderBadgeInfo($lang['badge_ruby_info'], $setting['baruby']); ?></p>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="modal_control hpad20">
	<button class="reg_button ok_btn cancel_over"><?php echo $lang['close']; ?></button>
</div>