<?php
require('../config_session.php');

if(!isset($_POST['get_profile'], $_POST['cp'])){
	die();
}
$id = escape($_POST['get_profile'], true);
$curpage = escape($_POST['cp']);
$user = userProfileDetails($id);
if(empty($user)){
	echo 2;
	die();
}
$other = boomTemplate('element/profile_other', $user);
if(useBadge() && canBadge($user)){
	$badge = boomTemplate('element/profile_badge', $user);
}
else {
	$badge = '';
}
?>
<div class="modal_wrap_top pro_top profile_background <?php echo coverClass($user); ?>" <?php echo getCover($user); ?>>
	<div class="brow">
		<div class="bcell">
			<div class="modal_top_menu">
				<div class="bcell_mid hpad15">
					<?php if(showUserLike($user) || (useLevel() && canLevel($user))){ ?>
					<div id="profile_like">
						<?php echo getProfileLevel($user); ?>
						<?php echo getProfileLikes($user); ?>
					</div>
					<?php } ?>
				</div>
				<?php if(canEditUser($user, 70)){ ?>
				<div onclick="editUser(<?php echo $user['user_id']; ?>);" class="cover_text modal_top_item">
					<i class="fa fa-edit"></i>
				</div>
				<?php } ?>
				<?php if(!canManageReport() && !mySelf($user['user_id']) && !isBot($user) && canReport()){ ?>
				<div onclick="openReport(<?php echo $user['user_id']; ?>, 4);" class="cover_text modal_top_item">
					<i class="fa fa-flag"></i>
				</div>
				<?php } ?>
				<?php if(!mySelf($user['user_id']) && !isBot($user)){ ?>
				<div onclick="getActions(<?php echo $user['user_id']; ?>);" class="cover_text modal_top_item">
					<i class="fa fa-bars"></i>
				</div>
				<?php } ?>
				<?php if(mySelf($user['user_id'])){ ?>
				<div onclick="editProfile();" class="modal_top_item cover_text">
					<i class="fa-regular fa-edit"></i>
				</div>
				<?php } ?>
				<div class="cancel_modal cover_text modal_top_item">
					<i class="fa fa-times"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="brow">
		<div class="bcell_bottom profile_top">
			<div class="btable_auto">
				<div id="proav" class="profile_avatar" data="<?php echo $user['user_tumb']; ?>" >
					<div class="avatar_spin">
						<img data-fancybox class="avatar_profile" href="<?php echo myAvatar($user['user_tumb']); ?>" src="<?php echo myAvatar($user['user_tumb']); ?>"/>
					</div>
					<img class="state_profile" src="<?php echo userActive($user); ?>"/>
					<?php if(canNote($user) && !empty($user['user_note'])){ ?>
					<img class="state_note" src="default_images/icons/note.svg" onclick="getNote(<?php echo $user['user_id']; ?>);"/>
					<?php } ?>
				</div>
				<div class="profile_tinfo cover_text">
					<div class="pdetails">
						<div class="pdetails_text pro_rank">
							<?php echo proRank($user); ?>
						</div>
					</div>
					<div class="pdetails">
						<div class="pdetails_text pro_name">
							<?php echo $user['user_name']; ?>
						</div>
					</div>
					<?php if(!empty($user['user_mood'])){ ?>
					<div class="pdetails">
						<div class="pdetails_text pro_mood bellips">
							<?php echo $user['user_mood']; ?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(isMuted($user) && !isBanned($user)){ ?>
<div class="im_muted profile_info_box warn_btn">
	<i class="fa fa-exclamation-circle"></i> <?php echo $lang['user_muted']; ?>
</div>
<?php } ?>
<?php if(isBanned($user)){ ?>
<div class="im_banned profile_info_box delete_btn">
	<i class="fa fa-exclamation-circle"></i> <?php echo $lang['user_banned']; ?>
</div>
<?php } ?>
<div class="pro_menu_wrap">
	<div class="modal_menu modal_mback hpad15">
		<ul>
			<li class="modal_menu_item modal_selected" data="mprofilemenu" data-z="probio"><?php echo $lang['bio']; ?></li>
			<?php if(!empty($user['user_about'])){ ?>
			<li class="modal_menu_item" data="mprofilemenu" data-z="proabout"><?php echo $lang['about_me']; ?></li>
			<?php } ?>
			<?php if(userShareFriend($user)){ ?>
			<li class="modal_menu_item" data="mprofilemenu" data-z="profriend" onclick="getUserFriend(<?php echo $user['user_id']; ?>);"><?php echo $lang['friends']; ?></li>
			<?php } ?>
			<?php if(userShareGift($user)){ ?>
			<li class="modal_menu_item" data="mprofilemenu" data-z="progift" onclick="getUserGift(<?php echo $user['user_id']; ?>);"><?php echo $lang['gift']; ?></li>
			<?php } ?>
			<?php if($other != ''){ ?>
			<li class="modal_menu_item" data="mprofilemenu" data-z="profile_more"><?php echo $lang['more']; ?></li>
			<?php } ?>
		</ul>
	</div>
</div>
<div id="mprofilemenu">
	<div class="modal_zone pad25 tpad15" id="probio">
		<div class="tpad10">
			<?php if(userShareAge($user)){ ?>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><i class="fa fa-calendar proicon"></i><?php echo $lang['age']; ?></div>
				<div class="bcell_mid prodata"><?php echo getUserAge($user['user_age']); ?></div>
			</div>
			<?php } ?>
			<?php if(userShareGender($user)){ ?>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><i class="fa fa-venus-mars proicon"></i><?php echo $lang['gender']; ?></div>
				<div class="bcell_mid prodata"><?php echo genderTitle($user['user_sex']); ?></div>
			</div>
			<?php } ?>
			<?php if(userShareLocation($user)){ ?>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><i class="fa fa-globe proicon"></i><?php echo $lang['country']; ?></div>
				<div class="bcell_mid prodata bbreak"><?php echo countryName($user['country']); ?></div>
			</div>
			<?php } ?>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><i class="fa fa-language proicon"></i><?php echo $lang['language']; ?></div>
				<div class="bcell_mid prodata"><?php echo $user['user_language']; ?></div>
			</div>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><i class="fa fa-user proicon"></i><?php echo $lang['join_chat']; ?></div>
				<div class="bcell_mid prodata"><?php echo longDate($user['user_join']); ?></div>
			</div>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><i class="fa fa-home proicon"></i><?php echo $lang['cur_room']; ?></div>
				<div class="bcell_mid prodata"><?php echo currentUserRoom($user); ?></div>
			</div>
			<?php if(isVisible($user) && !isBot($user)){ ?>
			<div class="btable blisting proitem">
				<div class="bcell_mid bold"><i class="fa fa-eye proicon"></i><?php echo $lang['last_seen']; ?></div>
				<div class="bcell_mid prodata"><?php echo longDateTime($user['last_action']); ?></div>
			</div>
			<?php } ?>
			<?php if(!empty($badge)){ ?>
			<div class="btable blist proitem">
				<div class="bcell_mid prodata tpad5">
					<?php echo $badge; ?>
				</div>
			</div>	
			<?php } ?>
		</div>
	</div>
	<?php if(!empty($user['user_about'])){ ?>
	<div class="modal_zone hide_zone pad25" id="proabout">
		<div class="listing_element info_item">
			<div class="sub_text tbreak"><?php echo boomFormat($user['user_about']);?></div>
		</div>
	</div>
	<?php } ?>
	<div class="modal_zone hide_zone pad25" id="profriend" value="0">
		<div class="menu_spinner_wrap"><i class="fa fa-circle-notch fa-spin fa-fw bspin menu_spinner"></i></div>
	</div>
	<div class="modal_zone hide_zone pad25" id="progift" value="0">
		<div class="menu_spinner_wrap"><i class="fa fa-circle-notch fa-spin fa-fw bspin menu_spinner"></i></div>
	</div>
	<div class="modal_zone hide_zone pad25" id="profile_more">
		<?php echo $other; ?>
	</div>
</div>