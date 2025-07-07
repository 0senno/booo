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
					<img class="large_icon" src="default_images/icons/verify.svg"/>
				</div>
				<div class="bpad10">
					<p class="text_xlarge bold bpad10"><?php echo $lang['active_title']; ?></p>
					<p class="text_med"><?php echo boomThisText($lang['active_message']); ?></p>
				</div>
				<div class="vpad25">
					<input type="text" id="boom_code" placeholder="<?php echo $lang['code']; ?>" class="full_input centered_element sub_input"/>
				</div>
				<div class="tpad10">
					<div class="bpad10">
						<button onclick="validCode(1);" class="reg_button ok_btn"><i class="fa fa-paper-plane"></i> <?php echo $lang['verify_account']; ?></button>
						<?php if(okVerify()){ ?>
						<button onclick="verifyAccount(2);" class="resend_hide reg_button theme_btn"><?php echo $lang['resend']; ?></button>
						<?php } ?>
					</div>
					<div class="tpad5">
						<p onclick="logOut();" class="link_like tmargin5 bclick" ><?php echo $lang['logout']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>