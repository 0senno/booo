<?php
$pinned = '';
if(pinnedRoom($boom)){
	$pinned = 'success';
}
?>
<div class="sub_list_item blisting room_item <?php echo roomActive($boom); ?>">
	<div class="sub_list_room">
		<img id="ricon<?php echo $boom['room_id']; ?>" class="lazy room_listing" data-src="<?php echo myRoomIcon($boom['room_icon']); ?>" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="sub_list_text">
		<p class="bold bellips"><?php echo $boom['room_name']; ?></p>
		<p class="sub_text text_small bellips"><?php echo $boom['description']; ?></p>
	</div>
	<div onclick="pinRoom(<?php echo $boom['room_id']; ?>);" class="sub_list_option">
		<i class="fa fa-thumb-tack <?php echo $pinned; ?>" id="pinned<?php echo $boom['room_id']; ?>"></i>
	</div>
	<div onclick="editRoom(<?php echo $boom['room_id']; ?>);" class="sub_list_option">
		<i class="fa fa-edit edit_btn"></i>
	</div>
	<?php if($boom['room_id'] == 1){ ?>
		<div class="sub_list_option">
			<i class="fa fa-home"></i>
		</div>
	<?php } ?>
	<?php if($boom['room_id'] > 1 && canManageRoom()){ ?>
	<div onclick="deleteRoom(this, <?php echo $boom['room_id']; ?>);" class="sub_list_option">
		<i class="fa fa-times"></i>
	</div>
	<?php } ?>
</div>