<?php 
require('../config_session.php');
if(!isset($_POST['edit_user'])){
	die();
}
if(!boomAllow(70)){
	die();
}
$result = '';
$target = escape($_POST['edit_user'], true);
$user = userDetails($target);
if(!canEditUser($user, 70)){
	echo 99;
	die();
}
?>
<div class="modal_wrap_top pro_top  profile_background <?php echo coverClass($user); ?>" <?php echo getCover($user); ?>>
	<div class="brow">
		<div class="bcell">
			<div class="modal_top_menu">
				<div onclick="getProfile(<?php echo $user['user_id']; ?>);" class="modal_top_item cover_text">
					<i class="fa fa-arrow-left"></i>
				</div>
				<div class="bcell_mid">
				</div>
				<?php if(canModifyCover($user)){ ?>
					<div class="cover_menu">
						<div class="cover_item_wrap lite_olay">
							<div class="cover_item delete_cover" onclick="adminRemoveCover(<?php echo $user['user_id']; ?>);">
								<i class="fa fa-times" id="cover_button"></i>
							</div>
							<div class="cover_item add_cover">
								<i class="fa fa-camera" id="admin_cover_icon" data="fa-camera"></i>
								<input id="admin_cover_file" class="up_input" onchange="adminUploadCover(<?php echo $user['user_id']; ?>);" type="file"/>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="modal_top_menu_empty">
				</div>
				<div class="cancel_modal modal_top_item cover_text">
					<i class="fa fa-times"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="brow">
		<div class="bcell_bottom profile_top">
			<div class="btable_auto">	
				<div class="profile_avatar" data="<?php echo $user['user_tumb']; ?>" >
					<div class="avatar_spin">
						<img data-fancybox class="avatar_profile" href="<?php echo myAvatar($user['user_tumb']); ?>" src="<?php echo myAvatar($user['user_tumb']); ?>"/>
					</div>
					<?php 
					if(canModifyAvatar($user)){ ?>
					<div class="avatar_control olay">
						<div class="avatar_button" onclick="adminRemoveAvatar(<?php echo $user['user_id']; ?>);">
							<i class="fa fa-times"></i>
						</div>
						<div id="avatarupload" class="avatar_button">
							<i class="fa fa-camera" id="avat_admin" data="fa-camera"></i>
							<input id="admin_avatar_image" class="up_input" onchange="adminUploadAvatar(<?php echo $user['user_id']; ?>);" type="file" >
						</div>
					</div>
					<?php } ?>
				</div>
				<div class="profile_tinfo cover_text">
					<div class="pdetails">
						<div id="pro_admin_name" class="pdetails_text pro_name">
							<?php echo $user['user_name']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="pro_menu_wrap">
	<div class="modal_menu modal_mback hpad15">
		<ul>
			<li class="modal_menu_item modal_selected" data="madminuser" data-z="admin_pro_details"><?php echo $lang['options']; ?></li>
		</ul>
	</div>
</div>
<div id="madminuser">
	<div class="modal_zone pad25 tpad15" id="admin_pro_details">
		<?php if(!isGuest($user) && canEditUser($user, $setting['can_rank'])){ ?>
		<div onclick="adminGetRank(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-star proicon"></i><?php echo $lang['change_rank']; ?></div>
		</div>
		<?php } ?>
		<?php if(!authUser($user) && !isGuest($user) && canEditUser($user, $setting['can_auth'])){ ?>
		<div onclick="adminUserAuth(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-check-circle proicon"></i><?php echo $lang['edit_auth']; ?></div>
		</div>
		<?php } ?>
		<?php if(canModifyName($user)){ ?>
		<div onclick="adminChangeName(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-edit proicon"></i><?php echo $lang['edit_username']; ?></div>
		</div>
		<?php } ?>
		<?php if(canModifyColor($user)){ ?>
		<div onclick="adminUserColor(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-paint-brush proicon"></i><?php echo $lang['edit_color']; ?></div>
		</div>
		<?php } ?>
		<?php if(canModifyMood($user)){ ?>
		<div onclick="adminChangeMood(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-pencil proicon"></i><?php echo $lang['edit_mood']; ?></div>
		</div>
		<?php } ?>
		<?php if(canModifyEmail($user)){ ?>
		<div onclick="adminGetEmail(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-envelope proicon"></i><?php echo $lang['edit_email']; ?></div>
		</div>
		<?php } ?>
		<?php if(canModifyAbout($user)){ ?>
		<div onclick="adminUserAbout(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-user proicon"></i><?php echo $lang['edit_about']; ?></div>
		</div>
		<?php } ?>
		<?php if(canModifyPassword($user)){ ?>
		<div onclick="adminUserPassword(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-key proicon"></i><?php echo $lang['change_password']; ?></div>
		</div>
		<?php } ?>
		<?php if(!verified($user) && canEditUser($user, $setting['can_verify'], 1)){ ?>
		<div onclick="adminUserVerify(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-check-circle proicon"></i><?php echo $lang['mail_verify']; ?></div>
		</div>
		<?php } ?>
		<?php if(canWhitelist($user) && !userCanVpn($user)){ ?>
		<div onclick="adminUserWhitelist(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-ghost proicon"></i><?php echo $lang['vpn_option']; ?></div>
		</div>
		<?php } ?>
		<?php if(canBlockUser($user)){ ?>
		<div onclick="adminUserBlock(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-ban proicon"></i><?php echo $lang['block_feature']; ?></div>
		</div>
		<?php } ?>
		<?php if(canDeleteUser($user)){ ?>
		<div onclick="eraseAccount(<?php echo $user['user_id']; ?>);" class="btable blisting proitem">
			<div class="bcell_mid"><i class="fa fa-trash-can proicon"></i><?php echo $lang['delete_account']; ?></div>
		</div>
		<?php } ?>
	</div>
</div>