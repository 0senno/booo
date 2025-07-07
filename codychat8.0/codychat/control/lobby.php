<?php
if(!defined('BOOM')){
	die();
}
include('header.php');
?>
<div id="page_content">
	<div id="page_global">
		<div class="page_indata">
			<div id="page_wrapper">
				<div class="page_element">
					<div class="lobby_control">
						<div class="vpad5">
							<div class="rtl_elem">
								<?php if(canRoom()){ ?>
								<button class="small_button theme_btn" onclick="openAddRoom();"><i class="fa fa-plus-circle"></i> <?php echo $lang['add_room']; ?></button>
								<?php } ?>
							</div>
						</div>
						<div id="room_filter" class="room_filters tpad10">
							<div class="room_search bpad5">
								<input id="search_chat_room" class="full_input hpad15" placeholder="<?php echo $lang['search']; ?>"/>
							</div>
						</div>
					</div>
				</div>
				<div class="page_element">
					<div id="container_rooms">
						<?php echo getRoomList(1); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script data-cfasync="false">
	var curPage = 'lobby';
</script>
<script data-cfasync="false" src="js/function_lobby.js<?php echo $bbfv; ?>"></script>

					