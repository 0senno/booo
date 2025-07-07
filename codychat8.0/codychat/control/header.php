<?php
if(!defined('BOOM')){
	die();
}
?>
<div id="header_full" class="bhead">
	<div id="wrap_full_header">
		<div id="main_header" class="out_head headers">
			<?php if($page['page_menu'] == 1){ ?>
			<div id="open_sub_mobile">
			<i class="fa fa-bars"></i>
			</div>
			<?php } ?>
			<div class="head_logo">
				<img id="main_logo" alt="logo" src="<?php echo getLogo(); ?>"/>
			</div>
			<div id="empty_top_mob" class="bcell_mid hpad10">
			</div>
			<?php if($page['page_nohome'] == 0){ ?>
			<div onclick="openSamePage('<?php echo $setting['domain']; ?>');" class="head_option">
				<i class="fa fa-home i_btm"></i>
			</div>
			<?php } ?>
			<?php if(boomLogged()){?>
			<div data-menu="page_main_menu" id="main_mob_menu" class="show_menu menutrig bclick">
				<img class="menutrig glob_av avatar_menu" src="<?php echo myAvatar($data['user_tumb']); ?>"/>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php if(boomLogged()){ ?>
<div id="page_main_menu" class="hideall sysmenu float_menu bshadow setdef back_menu">
	<div class="float_content" id="page_mmcontent">
		<div class="fmenu_item bhover pmenu_item" onclick="editProfile();">
			<div class="fmenu_icon">
				<i class="fa fa-user-circle menui"></i>
			</div>
			<div class="fmenu_text">
				<?php echo $lang['my_profile']; ?>
			</div>
		</div>
		<?php if($page['page'] != 'admin' && boomAllow(80)){ ?>
		<div class="fmenu_item bhover pmenu_item" onclick="openLinkPage('admin.php');">
			<div class="fmenu_icon">
				<i class="fa fa-dashboard menui"></i>
			</div>
			<div class="fmenu_text">
				<?php echo $lang['admin_panel']; ?>
			</div>
		</div>
		<?php } ?>
		<div class="fmenu_item bhover pmenu_item" onclick="logOut();">
			<div class="fmenu_icon">
				<i class="fa fa-sign-out menui"></i>
			</div>
			<div class="fmenu_text">
				<?php echo $lang['logout']; ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>