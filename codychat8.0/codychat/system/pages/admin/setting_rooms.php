<?php
require(__DIR__ . '/../../config_admin.php');

if(!canManageRoom()){
	die();
}
?>
<?php echo elementTitle($lang['manage_room']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="admin_add_room">
			<button onclick="adminCreateRoom();" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add_room']; ?></button>
		</div>
		<div id="rom_search" class="vpad15">
			<div class="search_bar">
				<input id="search_admin_room" placeholder="<?php echo $lang['search']; ?>" class="full_input" type="text"/>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="page_element">
		<div id="room_listing">
			<?php echo adminRoomList(); ?>
		</div>
	</div>
</div>