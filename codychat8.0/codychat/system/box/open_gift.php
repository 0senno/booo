<?php
require('../config_session.php');

if(!isset($_POST['open_gift'])){
	echo 0;
	die();
}
if(!useGift()){
	echo 0;
	die();
}
$id = escape($_POST['open_gift'], true);
$gift = giftDetails($id);
if(empty($gift)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="centered_element tpad25">
		<div class="bpad3">
			<img class="gift_received" src="<?php echo giftImage($gift['gift_image']); ?>"/>
		</div>
		<div class="vpad15">
			<div class="text_med bold">
				<?php echo $gift['gift_title']; ?>
			</div>
			<div class="gift_text sub_text">
				<?php echo $lang['gift_received']; ?>
			</div>
		</div>
	</div>
</div>
<div class="modal_control centered_element">
	<button class="reg_button ok_btn cancel_over"><?php echo $lang['ok']; ?></button>
</div>