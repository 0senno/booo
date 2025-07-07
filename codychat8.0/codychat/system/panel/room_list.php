<?php
require('../config_session.php');
?>
<?php
ob_start();
?>
<div class="chat_rlist pad15 left_keep">
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
	<div id="container_room" class="tpad10">
		<?php echo getRoomList(2); ?>
	</div>
</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['room_list'];
echo boomCode(1, $res);
?>