<?php
if(!defined('BOOM')){
	die();
}
?>
<div class="out_page_container back_page">
	<div class="out_page_content">
		<div class="out_page_box">
			<div class="pad_box">
				<div class="bpad15">
					<img class="large_icon" src="default_images/icons/banned.svg"/>
				</div>
				<div class="bpad10">
					<p class="text_xlarge bold bpad10"><?php echo $lang['ban_title']; ?></p>
					<p class="text_med"><?php echo $lang['ban_text']; ?></p>
				</div>
				<?php if(!empty($data['ban_msg'])){ ?>
				<div class="tpad10">
					<p class="bold theme_color bpad5"><?php echo $lang['reason_given']; ?></p>
					<p class="text_med"><?php echo renderReason($data['ban_msg']); ?></p>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
