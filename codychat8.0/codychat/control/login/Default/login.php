<div id="login_wrap" class="back_login">
	<div id="intro_top" class="btable">
		<div class="bcell_mid">
			<div id="login_all" class="pad30">
				<div class="centered_element">
					<img id="login_logo" src="<?php echo getLogo(); ?>"/>
				</div>
				<div class="login_text vpad20 centered_element">
					<p class="bold text_xlarge bpad10"><?php echo $lang['left_title']; ?></p>
					<p class="text_med"><?php echo $lang['left_welcome']; ?></p>
				</div>
				<div class="centered_element vpad15">
					<?php if(bridgeMode(0)){ ?>
					<button onclick="getLogin();" class="intro_login_btn large_button_rounded ok_btn btnshadow"><i class="fa fa-paper-plane"></i> <?php echo $lang['login']; ?></button>
					<div class="clear"></div>
					<?php } ?>
					<?php if(bridgeMode(1)){ ?>
					<button onclick="bridgeLogin('<?php echo getChatPath(); ?>');" class="intro_login_btn large_button_rounded ok_btn btnshadow"><i class="fa fa-user"></i> <?php echo $lang['enter_now']; ?></button>
					<div class="clear"></div>
					<?php } ?>
					<?php if(allowGuest()){ ?>
					<button onclick="getGuestLogin();" class="intro_guest_btn large_button_rounded default_btn btnshadow"><?php echo $lang['guest_login']; ?></button>
					<div class="clear"></div>
					<?php } ?>
				</div>
				<?php if(registration()){ ?>
				<div class="centered_element">
					<div class="tpad20">
						<p class="text_xsmall"><?php echo $lang['new_here']; ?></p>
						<p onclick="getRegistration();" class="text_med bold bclick tpad5"><?php echo $lang['register_now']; ?></p>
					</div>
				</div>
				<?php } ?>
				<div onclick="getLanguage();" class="bclick btable" id="intro_lang">
					<div class="bcell_mid centered_element">
						<img alt="flag" class="intro_lang" src="system/language/<?php echo BOOM_LANG; ?>/flag.png"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="section">
		<div class="section_content">
			<!-- add your content here if you need to add more for seo -->
		</div>
	</div>
	<?php echo boomTemplate('element/page_footer'); ?>
</div>
<?php echo boomTemplate('element/cookie'); ?>
<script data-cfasync="false" src="js/function_login.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/function_active.js<?php echo $bbfv; ?>"></script>