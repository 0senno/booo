<?php
require('../config_session.php');

if(!isset($_POST['gift'])){
	echo 0;
	die();
}

$gift = escape($_POST['gift'], true);

$get_gift = $mysqli->query("
	SELECT boom_gift.*
	FROM boom_users_gift 
	LEFT JOIN boom_gift ON boom_gift.id = boom_users_gift.gift
	WHERE boom_users_gift.target = '{$data['user_id']}' AND boom_users_gift.gift = '$gift'
");

if($get_gift->num_rows > 0){
	$gift = $get_gift->fetch_assoc();
}
else {
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="centered_element tpad25">
		<div class="bpad3">
			<img class="gift_del" src="<?php echo giftImage($gift['gift_image']); ?>"/>
		</div>
		<div class="bpad15 tpad10">
			<p class="text_med bold"><?php echo $gift['gift_title']; ?></p>
			<p class="tpad10"><?php echo $lang['gift_delete']; ?></p>
		</div>
	</div>
</div>
<div class="modal_control centered_element">
	<button id="delete_mgift" class="reg_button ok_btn close_over" data="<?php echo $gift['id']; ?>"><?php echo $lang['yes']; ?></button>
	<button class="reg_button default_btn close_over"><?php echo $lang['cancel']; ?></button>
</div>