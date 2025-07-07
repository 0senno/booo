<?php if(boomCookieLaw()){ ?>
<div class="cookie_wrap back_modal">
	<div class="cookie_img">
		<img src="default_images/icons/cookies.svg"/>
	</div>
	<div class="cookie_text">
		<p class="text_med bold bpad5"><?php echo $lang['cookie_title']; ?></p>
		<p><?php echo str_replace('%data%', '<span onclick="openSamePage(\'privacy.php\');" class="bclick link_like">' . $lang['privacy'] . '</span>', $lang['cookie_text']); ?></p>
	</div>
	<div class="cookie_button">
		<button onclick="hideCookieBar();" class="ok_btn reg_button"><?php echo $lang['ok']; ?></button>
	</div>
</div>
<?php } ?>