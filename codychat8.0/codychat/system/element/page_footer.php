<div class="foot vpad25 hpad15 centered_element" id="main_footer">
	<div id="menu_main_footer">
		<ul>
			<li><?php echo date('Y'); ?> ©<span class="theme_color"> <?php echo $setting['title']; ?></span></li>
			<li class="bclick"><a href="<?php echo $setting['domain']; ?>"><?php echo $lang['home']; ?></a></li>
			<li class="bclick"><a href="<?php echo $setting['domain'] . '/terms.php'; ?>"><?php echo $lang['terms']; ?></a></li>
			<li class="bclick"><a href="<?php echo $setting['domain'] . '/privacy.php'; ?>"><?php echo $lang['privacy']; ?></a></li>
			<li class="bclick"><a href="<?php echo $setting['domain'] . '/rules.php'; ?>"><?php echo $lang['rules']; ?></a></li>
			<li class="bclick"><a href="<?php echo $setting['domain'] . '/contact_us.php'; ?>"><?php echo $lang['contact_us']; ?></a></li>
			<?php if(!boomLogged()){ ?>
			<li class="bclick" onclick="getLanguage();"><i class="fa fa-language"></i> <?php echo $lang['language']; ?></li>
			<?php } ?>
			<?php if(bridgeMode(1)){ ?>
			<li class="bclick" onclick="getLogin();"><?php echo $lang['login']; ?></li>
			<?php } ?>
		</ul>
	</div>
</div>