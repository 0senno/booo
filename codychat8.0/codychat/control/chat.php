<?php
if(!defined('BOOM')){
	die();
}
$room = roomDetails($data['user_roomid']);
if(usePlayer()){
	$player = playerDetails($room['room_player_id']);
}
setUserRoom();
?>
<div id="chat_head" class="bhead chat_head ">
	<div class="head_option show_menu menutrig" data-menu="chat_left_menu">
		<div class="btable notif_zone">
			<div class="bcell_mid">
				<i class="fa fa-bars i_btm"></i>
			</div>
		</div>
		<div id="bottom_news_notify" class="head_notify bnotify"></div>
	</div>
	<?php if(!embedMode()){?>
	<div class="chat_head_logo">
		<img id="main_logo" alt="logo" src="<?php echo getLogo(); ?>"/>
	</div>
	<?php } ?>
	<div id="empty_top_mob" class="bcell_mid hpad10">
	</div>
	<div value="0" onclick="getPrivate();" id="get_private" class="privelem head_option menutrig <?php echo privCheck(); ?>">
		<div class="btable notif_zone">
			<div class="bcell_mid">
				<i class="fa fa-envelope i_btm"></i>
			</div>
		</div>
		<div id="notify_private" class="head_notify bnotify"></div>
	</div>
	<?php if(boomAllow(1)){ ?>
	<div onclick="friendRequest();" class="head_option menutrig">
		<div class="btable notif_zone">
			<div class="bcell_mid">
				<i class="fa fa-user-plus"></i>
			</div>
		</div>
		<div id="notify_friends" class="head_notify bnotify"></div>
	</div>
	<?php } ?>
	<div onclick="getNotification();" class="head_option menutrig">
		<div class="btable notif_zone">
			<div class="bcell_mid">
				<i class="fa fa-bell"></i>
			</div>
		</div>
		<div id="notify_notify" class="head_notify bnotify"></div>
	</div>
	<?php if(canManageReport()){ ?>
	<div onclick="getReport();" class="head_option menutrig">
		<div class="btable notif_zone">
			<div class="bcell_mid">
				<i class="fa fa-flag"></i>
			</div>
		</div>
		<div id="report_notify" class="head_notify bnotify"></div>
	</div>
	<?php } ?>
	<div data-menu="chat_main_menu" id="main_mob_menu" class="show_menu menutrig">
		<img class="avatar_menu glob_av" src="<?php echo myAvatar($data['user_tumb']); ?>"/>
		<img class="top_status status_icon" src="default_images/status/<?php echo statusIcon($data['user_status']); ?>"/>
	</div>
</div>

<div id="global_chat" class="backglob chatheight" >

	<div id="chat_left" class="left_hide back_panel rborder bshadow pheight">
		<div id="left_content">
			<div id="left_panel_bar" class="btable bborder panel_bar">
				<div id="leftpanel_head" class="left_head_empty bcell_mid">
				</div>
				<div class="left_bar_item" onclick="resetLeftPanel();">
					<i class="fa fa-times"></i>
				</div>
			</div>
			<div id="chat_left_data" class="clheight">
			</div>
		</div>
	</div>
	
	<div id="chat_center" class="chatheight" style="position:relative;">
		<div  id="container_chat">
			<div id="wrap_chat">
				<div id="chat_toping" class="chat_topping">
					<!--
					you can add content to the top of chat by editing file located in
					chat_element / top.php
					-->
					<?php echo boomTemplate('../control/element/top'); ?>
				</div>
				<div id="warp_show_chat">
					<div id="container_show_chat">
						<div id="inside_wrap_chat">
							<ul class="back_chat" id="show_chat" value="1">
								<ul id="chat_logs_container">
								</ul>
							</ul>
						</div>
						<div value="0" id="main_emoticon" class="back_box bshadow">
							<div class="emo_head bborder main_emo_head">
								<?php if(canEmo()){ ?>
									<div data="base_emo" class="bselected emo_menu emo_menu_item"><img class="emo_select" src="emoticon_icon/base_emo.png"/></div>
									<?php echo emoItem(1); ?>
								<?php } ?>
								<div class="empty_emo">
								</div>
								<div class="emo_menu" onclick="hideEmoticon();">
									<i class="fa fa-times"></i>
								</div>
							</div>
							<div id="main_emo" class="emo_content">
								<?php listSmilies(1); ?>
							</div>
						</div>
						<div id="main_input_extra" class="bshadow back_box">
							<?php if(canUploadChat()){ ?>
							<div class="sub_options">
								<img src="default_images/icons/upload.svg"/>
								<input id="chat_file" class="up_input" onchange="uploadChatFile();" type="file"/>
							</div>
							<?php } ?>
						</div>
						<div id="quote_controller" class="qwraper back_quote bshadow">
							<div id="quote_control" class="qcontrol" data="0">
								<div class="qavatarwrap">
									<img id="quote_avatar" class="qavatar" src=""/>
								</div>
								<div class="qusername_wrap">
									<p class="text_xsmall bold quotequote theme_color"><?php echo $lang['quote']; ?></p>
									<p id="quoted_user" class="qusername"></p>
								</div>
								<div class="qcancel" onclick="resetQuote();">
									<i class="fa fa-times"></i>
								</div>
							</div>
						</div>
						<div id="main_progress" class="uprogress">
							<div class="uprogress_wrap">
								<div id="mprogress" class="uprogress_progress">
								</div>
								<div class="uprogress_content btable">
									<div class="bcell_mid uprogress_text">
										<p class="bold text_small"><i class="fa fa-upload"></i> <?php echo $lang['upload']; ?></p>
									</div>
									<div class="bcell_mid uprogress_icon" onclick="cancelMainUp();">
										<i class="fa fa-times"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="top_chat_container" class="back_input input_wrap">
					<div id="container_input" class="no_rtl hidden">
						<form id="main_input" name="chat_data" action="" method="post">
							<div class="input_table">
								<div id="ok_sub_item" class="input_item main_item base_main sub_hidden" onclick="getChatSub();">
									<i class="fa fa-plus input_icon bblock"></i>
								</div>
								<div value="0" class="input_item main_item base_main" onclick="showEmoticon();" id="emo_item">
									<i class="fa-regular fa-face-smile bblock"></i>
								</div>
								<div id="main_input_box" class="td_input">
									<input data-paste="<?php echo mainPaste(); ?>" type="text" spellcheck="false" name="content" placeholder="<?php echo $lang['type_something']; ?>" maxlength="<?php echo $setting['max_main']; ?>" id="content" autocomplete="off"/>
								</div>
								<div id="inputt_right" class="main_item">
									<button type="submit"  class="send_btn" id="submit_button"><i class="fa fa-paper-plane"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div id="main_disabled" class="hidden">
						<div id="disabled_content" class="btable">
							<div class="bcell_mid bellips centered_element hpad10">
								<?php echo $lang['main_disabled']; ?>
							</div>
						</div>
					</div>
					<div id="main_load">
						<div id="main_load_content">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="private_center" class="privelem privhide pboxed">
		<div id="private_box" class="privelem back_priv prifoff <?php echo privCheck(); ?>">
			<div class="top_panel btable back_ptop" id="private_top">
				<div id="private_av_wrap" class="bcell_mid">
					<img data="" id="private_av" class="get_info" src="">
				</div>
				<div onclick="" id="private_name" class="bcell_mid bellips">
					<p class="bellips"></p>
				</div>
				<div id="private_boxing" onclick="privateBox();" class="private_opt fhide">
					<i class="fa fa-compress"></i>
				</div>
				<div id="private_paneling" onclick="privatePanel();" class="private_opt">
					<i class="fa fa-expand"></i>
				</div>
				<div id="priv_minimize" onclick="togglePrivate(1);" class="private_opt">
					<i class="fa fa-minus"></i>
				</div>
				<div id="private_call" data="" class="opencall private_opt">
					<i class="fa fa-phone"></i>
				</div>
				<div id="private_min" data-menu="private_opt" class="show_menu menutrig private_opt">
					<i class="fa fa-cog"></i>
				</div>
				<div id="private_close" class="private_opt">
					<i class="fa fa-times"></i>
				</div>
			</div>
			<div id="private_wrap_content" class="pcontent">
				<div id="private_content" class="back_priv pcontent" value="1">
					<div id="inside_wrap_private">
						<ul id="show_private_wrap">
							<ul id="show_private">
							</ul>
						</ul>
					</div>
				</div>
				<div id="privspin" class="large_spinner">
					<i class="fa fa-circle-notch fa-spin fa-fw bspin boom_spinner"></i>
				</div>
				<div id="priv_input_extra" class="back_box bshadow">
					<?php if(canUploadPrivate()){ ?>
					<div class="psub_options">
						<img src="default_images/icons/upload.svg"/>
						<input id="private_file" class="up_input" onchange="uploadPrivateFile();" type="file"/>
					</div>
					<?php } ?>
				</div>
				<div id="pquote_controller" class="qwraper back_quote bshadow">
					<div id="pquote_control" class="qcontrol" data="0">
						<div class="qavatarwrap">
							<img id="pquote_avatar" class="qavatar" src=""/>
						</div>
						<div class="qusername_wrap">
							<p class="text_xsmall bold theme_color quotequote"><?php echo $lang['quote']; ?></p>
							<p id="pquoted_user" class="qusername"></p>
						</div>
						<div class="qcancel" onclick="resetPrivateQuote();">
							<i class="fa fa-times"></i>
						</div>
					</div>
				</div>
				<div id="private_opt" class="sysmenu float_menu back_menu bshadow">
					<div class="submenu_item submenu" onclick="ignoreThisUser();">
						<?php echo subMenu('ban', $lang['ignore'], $lang['ignore_text']); ?>
					</div>
					<?php if(!canManageReport() && canReport()){ ?>
					<div class="submenu_item submenu" onclick="reportPrivateLog();">
						<?php echo subMenu('exclamation-circle', $lang['report'], $lang['report_text']); ?>
					</div>
					<?php } ?>
					<?php if(canDeletePrivate()){ ?>
					<div class="submenu_item submenu" onclick="confirmClearPrivate();">
						<?php echo subMenu('trash', $lang['delete'], $lang['clear_text']); ?>
					</div>
					<?php } ?>
				</div>
				<div id="private_emoticon" class="back_box bshadow">
					<div class="emo_head bborder private_emo_head">
						<?php if(canEmo()){ ?>
							<div data="base_emo" class="bselected emo_menu emo_menu_item_priv"><img class="emo_select" src="emoticon_icon/base_emo.png"/></div>
							<?php echo emoItem(2); ?>
						<?php } ?>
						<div class="empty_emo">
						</div>
						<div class="emo_menu" id="emo_close_priv" onclick="hidePrivEmoticon();">
							<i class="fa fa-times"></i>
						</div>
					</div>
					<div id="private_emo" class="emo_content_priv">
						<?php listSmilies(2); ?>
					</div>
				</div>
				<div id="private_progress" class="uprogress">
					<div class="uprogress_wrap">
						<div id="pprogress" class="uprogress_progress">
						</div>
						<div class="uprogress_content btable">
							<div class="bcell_mid uprogress_text">
								<p class="bold text_small"><i class="fa fa-upload"></i> <?php echo $lang['upload']; ?></p>
							</div>
							<div class="bcell_mid uprogress_icon" onclick="cancelPrivateUp();">
								<i class="fa fa-times"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="priv_input" class="back_pinput input_wrap">
				<div id="private_input" class="no_rtl back_input">
					<form id="message_form"  action="" method="post" name="private_form">
						<div class="input_table">
							<div id="ok_priv_item" class="input_item main_item sub_hidden" onclick="getPrivSub();">
								<i class="fa fa-plus input_icon bblock"></i>
							</div>
							<div value="0" id="emo_item_priv" class="input_item main_item" onclick="showPrivEmoticon();">
								<i class="fa-regular fa-face-smile"></i>
							</div>
							<div id="private_input_box" class="td_input">
								<input data-paste="<?php echo privatePaste(); ?>" spellcheck="false" id="message_content" placeholder="<?php echo $lang['type_something']; ?>" maxlength="<?php echo $setting['max_private']; ?>" autocomplete="off"/>
							</div>
							<div id="message_send" class="main_item">
								<button class="send_btn" id="private_send"><i class="fa fa-paper-plane"></i></button>
							</div>
						</div>
					</form>
				</div>
				<div id="private_disabled" class="hidden">
					<div id="private_disable" class="btable">
						<div class="bcell_mid bellips centered_element hpad10">
							<?php echo $lang['private_disabled']; ?>
						</div>
					</div>
				</div>
				<div id="private_load">
					<div id="private_load_content">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="chat_right" class="cright back_panel lborder bshadow pheight">
		<div id="right_panel_bar" class="bborder panel_bar">
			<div onclick="closeRight();" class="panel_bar_item">
				<i class="fa fa-times"></i>
			</div>
			<div class="bcell_mid">
			</div>
			<div id="users_option"title="<?php echo $lang['user_list']; ?>" class="bselected panel_option" onclick="userReload(1);">
				<i class="fa fa-users"></i>
			</div>
			<?php if(boomAllow(1)){ ?>
			<div id="friends_option" title="<?php echo $lang['friend_list']; ?>" class="panel_option" onclick="myFriends(1);">
				<i class="fa fa-user"></i>
			</div>
			<?php } ?>
			<div id="users_option"title="<?php echo $lang['staff_list']; ?>" class="panel_option" onclick="staffList(1);">
				<i class="fa fa-user-shield"></i>
			</div>
			<?php if(canGroupCall()){ ?>
			<div id="users_option"title="<?php echo $lang['group_call']; ?>" class="panel_option" onclick="getCallList();">
				<i class="fa fa-phone-volume"></i>
			</div>
			<?php } ?>
			<div id="search_option" title="<?php echo $lang['search_user']; ?>" class="panel_option" onclick="getSearchUser();">
				<i class="fa fa-search"></i>
			</div>
		</div>
		<div id="chat_right_data" class="crheight">
		</div>
	</div>
	
</div>

<div id="wrap_footer" class="bfoot" data="1" >
	<div id="my_menu">
		<?php if(usePlayer()){ ?>
		<div class="show_menu footer_item menutrig" data-menu="player_menu" >
			<i class="fa fa-play-circle footer_play i_btm"></i>
		</div>
		<?php } ?>
		<div class="bcell_mid">
		</div>
		<div id="mstream" onclick="toggleStream(2)" class="footer_item streamhide">
			<img id="mstream_img" src="default_images/icons/vidhide.svg"/>
		</div>
		<div id="mstream_call" onclick="toggleCall(2)" class="footer_item streamhide">
			<img id="mstream_img" src="default_images/icons/callmin.svg"/>
		</div>
		<div id="mstream_audio" onclick="toggleStreamAudio(2)" class="footer_item streamhide">
			<img id="mstream_img" src="default_images/icons/audiohide.svg"/>
		</div>
		<div id="dpriv" onclick="togglePrivate(2);" class="privelem footer_item privhide <?php echo privCheck(); ?>">
			<img id="dpriv_av" src=""/>
			<div id="dpriv_notify" class="foot_notify bnotify">
			</div>
		</div>
		<!--
		<div class="footer_item dectext">
			<i class="fa fa-minus i_btm"></i>
		</div>
		<div class="footer_item inctext">
			<i class="fa fa-plus i_btm"></i>
		</div>
		-->
		<div id="rlist_open" onclick="toggleRight();" class="footer_item testthis">
			<i class="fa fa-bars i_btm"></i>
		</div>
	</div>
</div>

<?php if(usePlayer()){ ?>
<div id="player_menu" class="float_menu back_menu sysmenu">
	<div id="player_menu_content" class="float_content">
		<div class="player_wrap hpad5">
			<div id="current_player" class="cur_play">
				<div class="btable bborder vpad10">
					<div id="player_actual_status" class="splay_btn bcell_mid turn_on_play">
						<i class="fa fa-play-circle i_btm" id="current_play_btn"></i>
					</div>
					<div class="bcell_mid hpad5">
						<p class="text_xsmall theme_color"><?php echo $lang['station']; ?></p>
						<p id="current_station"><?php echo $player['stream_alias']; ?></p>
					</div>
					<div data-menu="station_menu" class="bcell_mid player_change show_menu">
						<i class="fa fa-list"></i>
					</div>
				</div>
			</div>
			<div class="player_volume">
				<div id="sound_display" class="bcell_mid">
					<i class="fa fa-volume-down show_sound"></i>
				</div>
				<div id="player_volume" class="bcell_mid boom_slider">
					<div id="slider"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="station_menu" class="float_menu back_menu sysmenu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="player_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['station_list']; ?>
		</div>
	</div>
	<div id="station_menu_content" class="float_content">
		<?php echo playerList(); ?>
	</div>
</div>
<?php } ?>


<div id="private_menu" data="private_menu_content" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_icon">
			<i class="fa fa-comments"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['private']; ?>
		</div>
		<div class="ftop_empty">
		</div>
		<div class="ftop_action" onclick="openPrivateRead();">
			<i class="fa fa-square-check"></i>
		</div>
		<div class="ftop_action" onclick="clearPrivateList();">
			<i class="fa fa-trash-can"></i>
		</div>
	</div>
	<div class="float_content">
		<div id="private_menu_content">
		</div>
	</div>
</div>


<div id="report_menu" data="report_menu_content" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_icon">
			<i class="fa fa-flag"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['report']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="report_menu_content">
		</div>
	</div>
</div>


<div id="friends_menu" data="friends_menu_content" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_icon">
			<i class="fa fa-user-plus"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['friend_request']; ?>
		</div>
	</div>
	<div id="friends_menu_content" class="float_content">
	</div>
</div>


<div id="notification_menu" data="notification_menu_content" class="sysmenu back_menu float_menu">
	<div id="float_top_ref" class="ftop_elem float_top">
		<div class="ftop_opt_icon">
			<i class="fa fa-bell"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['notification']; ?>
		</div>
		<div class="ftop_action" onclick="clearNotification();">
			<i class="fa fa-trash-can"></i>
		</div>
	</div>
	<div class="float_content">
		<div id="notification_menu_content">
		</div>
	</div>
</div>


<div id="status_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_main_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['status']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="status_menu_content">
			<?php echo listAllStatus(); ?>
		</div>
	</div>
</div>

<?php if(useWallet()){ ?>
<div id="bank_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_main_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['wallet']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="bank_menu_content">
			<div class="hpad10 bpad10">
				<div class="vpad10 blist">
					<p class="text_xsmall bold bpad5"><?php echo $lang['ruby']; ?></p>
					<div class="btable">
						<div class="bcell_mid ruby_icon">
							<img src="<?php echo rubyIcon(); ?>"/>
						</div>
						<div id="ruby" class="bcell_mid ruby_text bold hpad5">
							<?php echo $data['user_ruby']; ?>
						</div>
					</div>
				</div>
				<div class="vpad10">
					<p class="text_xsmall bold bpad5"><?php echo $lang['gold']; ?></p>
					<div class="btable">
						<div class="bcell_mid gold_icon">
							<img src="<?php echo goldIcon(); ?>"/>
						</div>
						<div id="gold" class="bcell_mid gold_text bold hpad5">
							<?php echo $data['user_gold']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div id="room_options_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_left_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['room_options']; ?>
		</div>
	</div>
	<div id="room_options_menu_content" class="float_content">
		<div class="float_section bborder">
			<div class="fmenu_item bhover mmenu_item" onclick="openRoomSettings();">
				<div class="fmenu_icon">
					<i class="fa fa-cogs menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['settings']; ?>
				</div>
			</div>
			<div class="fmenu_item bhover mmenu_item" onclick="openRoomStaff();">
				<div class="fmenu_icon">
					<i class="fa fa-shield menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['manage_staff']; ?>
				</div>
			</div>
		</div>
		<div class="float_section">
			<div class="fmenu_item bhover mmenu_item" onclick="openRoomActions();">
				<div class="fmenu_icon">
					<i class="fa fa-bolt menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['manage_action']; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="chat_left_menu" class="sysmenu back_menu float_menu">
	<div class="float_ctop" id="mmenul_top">
		<div class="btable pad10">
			<div class="bcell_mid roomcv">
				<img class="glob_ricon" src="<?php echo myRoomIcon($room['room_icon']); ?>"/>
			</div>
			<div class="bcell_mid hpad10">
				<div class="mroom_text sub_text">
					<?php echo $lang['current_room']; ?>
				</div>
				<div class="mroom_name bellips glob_rname">
					<?php echo $room['room_name']; ?>
				</div>
			</div>
			<div class="bcell_mid mroom_change room_granted nogranted show_menu" data-menu="room_options_menu">
				<i class="fa fa-cog"></i>
			</div>
		</div>
	</div>
	<div id="left_menu_content" class="float_content">
		<div id="left_main_content">
			<div id="room_menu" class="fmenu_item bhover lmenu_item" onclick="getRoomList();">
				<div class="fmenu_icon">
					<i class="fa fa-house-user menui"></i>
				</div>
				<div class="fmenu_text left_text">
					<?php echo $lang['room_list']; ?>
				</div>
			</div>
			<?php if(useWall() && boomAllow(1)){ ?>
			<div id="wall_menu" class="fmenu_item bhover lmenu_item" onclick="getWall();">
				<div class="fmenu_icon">
					<i class="fa fa-rss menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['wall']; ?>
				</div>
			</div>
			<?php } ?>
			<div id="news_menu" class="fmenu_item bhover lmenu_item" onclick="getNews();">
				<div class="fmenu_icon">
					<i class="fa fa-newspaper menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['system_news']; ?>
				</div>
				<div class="fmenu_notify">
					<div id="news_notify" class="fnotify bnotify"></div>
				</div>
			</div>
			<div id="app_menu_btn" data-menu="app_menu" class="fmenu_item bhover mmenu_item show_menu fhide">
				<div class="fmenu_icon">
					<i class="fa fa-tablet-screen-button menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['apps']; ?>
				</div>
				<div class="fmenu_arrow">
					<i class="fa fa-chevron-right"></i>
				</div>
			</div>
			<div id="tool_menu_btn" data-menu="tool_menu" class="fmenu_item bhover mmenu_item show_menu fhide">
				<div class="fmenu_icon">
					<i class="fa fa-toolbox menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['tools']; ?>
				</div>
				<div class="fmenu_arrow">
					<i class="fa fa-chevron-right"></i>
				</div>
			</div>
			<div id="store_menu_btn" data-menu="store_menu" class="fmenu_item bhover mmenu_item show_menu fhide">
				<div class="fmenu_icon">
					<i class="fa fa-store menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['store']; ?>
				</div>
				<div class="fmenu_arrow">
					<i class="fa fa-chevron-right"></i>
				</div>
			</div>
			<div id="game_menu_btn" data-menu="game_menu" class="fmenu_item bhover mmenu_item show_menu fhide">
				<div class="fmenu_icon">
					<i class="fa fa-dice menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['games']; ?>
				</div>
				<div class="fmenu_arrow">
					<i class="fa fa-chevron-right"></i>
				</div>
			</div>
			<div id="leaderboard_menu_btn" data-menu="leaderboard_menu" class="fmenu_item bhover mmenu_item show_menu fhide">
				<div class="fmenu_icon">
					<i class="fa fa-medal menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['leaderboard']; ?>
				</div>
				<div class="fmenu_arrow">
					<i class="fa fa-chevron-right"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="leaderboard_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_left_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['leaderboard']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="leaderboard_menu_content">
			<?php if(useLevel()){ ?>
			<div onclick="getLeaderboard('leader_xp');" class="fmenu_item bhover">
				<div class="fmenu_img">
					<img src="default_images/menu/top_xp.svg"></img>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['xp_leaderboard']; ?>
				</div>
			</div>
			<?php } ?>
			<?php if(useLevel()){ ?>
			<div onclick="getLeaderboard('leader_level');" class="fmenu_item bhover">
				<div class="fmenu_img">
					<img src="default_images/menu/top_level.svg"></img>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['level_leaderboard']; ?>
				</div>
			</div>
			<?php } ?>
			<?php if(useWallet()){ ?>
			<div onclick="getLeaderboard('leader_gold');" class="fmenu_item bhover">
				<div class="fmenu_img">
					<img src="default_images/menu/top_gold.svg"></img>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['gold_leaderboard']; ?>
				</div>
			</div>
			<?php } ?>
			<?php if(useGift()){ ?>
			<div onclick="getLeaderboard('leader_gift');" class="fmenu_item bhover">
				<div class="fmenu_img">
					<img src="default_images/menu/top_gift.svg"></img>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['gift_leaderboard']; ?>
				</div>
			</div>
			<?php } ?>
			<?php if(useLike()){ ?>
			<div onclick="getLeaderboard('leader_like');" class="fmenu_item bhover">
				<div class="fmenu_img">
					<img src="default_images/menu/top_like.svg"></img>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['like_leaderboard']; ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<div id="game_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_left_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['games']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="game_menu_content">
		</div>
	</div>
</div>

<div id="store_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_left_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['store']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="store_menu_content">
		</div>
	</div>
</div>

<div id="app_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_left_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['apps']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="app_menu_content">
		</div>
	</div>
</div>

<div id="tool_menu" class="sysmenu back_menu float_menu">
	<div class="ftop_elem float_top">
		<div class="ftop_opt_btn show_menu" data-menu="chat_left_menu">
			<i class="fa fa-chevron-left"></i> 
		</div>
		<div class="ftop_opt_text">
			<?php echo $lang['tools']; ?>
		</div>
	</div>
	<div class="float_content">
		<div id="tool_menu_content">
		</div>
	</div>
</div>

<div id="chat_main_menu" class="sysmenu back_menu float_menu">
	<div class="float_ctop" id="mmenu_top">
		<div class="btable pad10">
			<div class="bcell_mid avmmenu">
				<img class="glob_av" src="<?php echo myAvatar($data['user_tumb']); ?>"/>
			</div>
			<div class="bcell_mid hpad10">
				<div class="menuranktxt">
				<?php echo menuRank($data); ?>
				</div>
				<div class="menuname bellips globname">
					<?php echo $data['user_name']; ?>
				</div>
			</div>
			<div data-menu="status_menu" class="bcell_mid editstatus show_menu">
				<img class="stat_icon status_icon" src="default_images/status/<?php echo statusIcon($data['user_status']); ?>"/>
			</div>
		</div>
	</div>
	<div class="float_content">
		<div id="section_tmmenu" class="float_section bborder tpad0">
			<?php if(useLevel() && canLevel($data)){ ?>
			<div class="fmenu_item bhover mmenu_item" onclick="viewLevelStatus(<?php echo $data['user_id']; ?>);">
				<div class="fmenu_icon">
					<i class="fa fa-layer-group menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['level_info']; ?>
				</div>
			</div>
			<?php } ?>
			<?php if(useWallet()){ ?>
			<div data-menu="bank_menu" class="fmenu_item bhover mmenu_item show_menu">
				<div class="fmenu_icon">
					<i class="fa fa-wallet menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['wallet']; ?>
				</div>
				<div class="fmenu_arrow">
					<i class="fa fa-chevron-right"></i>
				</div>
			</div>
			<?php } ?>
			<div class="fmenu_item bhover mmenu_item" onclick="editProfile();">
				<div class="fmenu_icon">
					<i class="fa fa-user-circle menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['edit_profile']; ?>
				</div>
			</div>
			<?php if(userDj($data)){ ?>
			<div class="fmenu_item  bhover mmenu_item show_menu" onclick="openOnair();">
				<div class="fmenu_icon">
					<i class="fa fa-microphone menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['onair_status']; ?>
				</div>
			</div>
			<?php } ?>
		</div>
		<div id="section_bmmenu" class="float_section bpad0">
			<?php if(boomAllow(80)){ ?>
			<div class="fmenu_item bhover mmenu_item" onclick="openLinkPage('admin.php');">
				<div class="fmenu_icon">
					<i class="fa fa-dashboard menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['admin_panel']; ?>
				</div>
			</div>
			<?php } ?>
			<?php if(useApp()){ ?>
			<div id="app_install" class="fmenu_item bhover mmenu_item fhide">
				<div class="fmenu_icon">
					<i class="fa fa-mobile-screen menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['app_add']; ?>
				</div>
			</div>
			<div id="app_reload" class="fmenu_item bhover mmenu_item fhide">
				<div class="fmenu_icon">
					<i class="fa fa-rotate-right menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['app_reload']; ?>
				</div>
			</div>
			<?php } ?>
			<?php if(useLobby()){ ?>
			<div class="fmenu_item bhover mmenu_item" onclick="backHome();">
				<div class="fmenu_icon">
					<i class="fa fa-arrow-circle-left menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['exit_room']; ?>
				</div>
			</div>
			<?php } ?>
			<div class="fmenu_item bhover mmenu_item" onclick="logOut();">
				<div class="fmenu_icon">
					<i class="fa fa-sign-out menui"></i>
				</div>
				<div class="fmenu_text">
					<?php echo $lang['logout']; ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="av_menu" class="avmenu bshadow back_menu">
	<div id="avcontent" class="avcontent">
	</div>
</div>
<div id="log_menu" class="bshadow back_menu">
	<div id="logmenu" class="logmenu">
	</div>
</div>


<div id="monitor_data" onclick="getMonitor();">
	<p>Active: <span id="current_active">0</span></p>
	<p>Count: <span id="logs_counter">0</span></p>
	<p>Speed: <span id="current_speed">0</span></p>
	<p>Latency: <span id="current_latency">0</span></p>
</div>
<div id="action_menu" class="bshadow hidden">
	<?php echo boomTemplate('element/actions_card'); ?>
</div>
<div id="log_menu_content" class="bshadow hidden">
	<?php echo boomTemplate('element/actions_logs'); ?>
</div>
<div id="private_actions" class="bshadow hidden">
	<?php echo boomTemplate('element/actions_private'); ?>
</div>
<script data-cfasync="false">
	var curPage = 'chat';
	var roomTitle = '<?php echo $room['room_name']; ?>';
	var user_room = <?php echo $data['user_roomid']; ?>;
	var userAction = '<?php echo $data['user_action']; ?>';
	var	globNotify = 0;
	var pCount = "<?php echo $data['pcount']; ?>";
	var uCall = '<?php echo $data['ucall']; ?>';
	var callLock = '<?php echo $data['bcall']; ?>';
	var ignoreList = new Set(<?php echo json_encode(loadIgnore($data['user_id'])); ?>);
</script>
<?php if(usePlayer()){ ?>
<script data-cfasync="false">
	var source = "<?php echo $player['stream_url']; ?>";
</script>
<?php } ?>
<?php loadAddonsJs();?>
<script data-cfasync="false" src="js/function_main.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/function_temp.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/function_menu.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/function_player.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" src="js/function_call.js<?php echo $bbfv; ?>"></script>
<?php if(canUploadChat() || canUploadPrivate()){ ?>
<script data-cfasync="false" src="js/function_paste.js<?php echo $bbfv; ?>"></script>
<?php } ?>