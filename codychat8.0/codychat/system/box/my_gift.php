<?php
require('../config_session.php');

function userGiftList($user){
	global $mysqli, $lang;
	$get_gift = $mysqli->query("
		SELECT boom_gift.*, boom_users_gift.gift_count
		FROM boom_users_gift 
		LEFT JOIN boom_gift ON boom_gift.id = boom_users_gift.gift
		WHERE boom_users_gift.target = '{$user['user_id']}' ORDER BY boom_users_gift.gift_count DESC
	");
	return createPag($get_gift, 20, array('template'=> 'element/gift_profile', 'style'=> 'arrow'));
}

if(!useGift()){
	echo 0;
	die();
}
?>
<div class="tpad10 bpad15 hpad5">
	<button class="small_button ok_btn" onclick="openSendGift(<?php echo $data['user_id']; ?>);"><i class="fa fa-gift"></i> <?php echo $lang['self_gift']; ?></button>
</div>
<div id="view_gift_box">
	<?php echo userGiftList($data); ?>
</div>
<div id="view_gift_template" class="hidden">
	<div class="modal_content">
		<div id="view_gift_id" data="" class="centered_element tpad25">
			<div class="bpad3">
				<img id="view_gift_img" class="gift_received" src=""/>
			</div>
			<div class="vpad15">
				<div id="view_gift_title" class="text_med bold">
				</div>
			</div>
		</div>
	</div>
	<div class="modal_control centered_element">
		<button class="reg_button ok_btn close_over"><?php echo $lang['close']; ?></button>
		<button id="gift_delete" class="reg_button default_btn"><?php echo $lang['delete']; ?></button>
	</div>
</div>