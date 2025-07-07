<?php
$ask = 0;
$owner = '';
if($boom['password'] != ''){
	$ask = 1;
}
if($boom['description'] == ''){
	$description = $lang['room_no_description'];
}
else {
	$description = $boom['description'];
}
if($data['user_id'] == $boom['room_creator']){
	$owner = 'owner ';
}
?>
<div class="room_element room_celem blisting" onclick="switchRoom(<?php echo $boom['room_id']; ?>, <?php echo $ask; ?>, <?php echo $boom['access']; ?>);">
	<div class="bcell_mid room_cicon_wrap">
		<img class="room_cicon lazy" data-src="<?php echo myRoomIcon($boom['room_icon']); ?>" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="bcell_mid room_content">
		<div class="room_cname roomtitle">
			<?php echo $boom['room_name']; ?>
		</div>
		<div class="room_cdescription roomdesc sub_text">
			<?php echo $description; ?>
		</div>
		<div class="btable">
			<?php if(roomPass($boom['password'])){ ?>
			<div class="roomcopt bcell_mid">
				<?php echo roomLock($boom['password'], 'room_ctag'); ?>
			</div>
			<?php } ?>
			<div class="roomcopt bcell_mid">
				<?php echo roomAccess($boom['access'], 'room_ctag'); ?>
			</div>
			<?php if(pinnedRoom($boom)){ ?>
			<div class="roomcopt bcell_mid">
				<?php echo roomPinned($boom, 'room_ctag'); ?>
			</div>
			<?php } ?>
			<div class="bcell_mid room_ccount hpad3 rtl_aleft">
				<?php echo $boom['room_count']; ?>
			</div>
			<div class="roomcopt bcell_mid">
				<img  class="room_ctag" src="default_images/rooms/user_count.svg">
			</div>
		</div>
	</div>
</div>
