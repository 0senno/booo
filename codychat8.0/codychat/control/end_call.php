<?php
if(!defined('BOOM')){
	die();
}
$end = 1;
if(isset($_GET['end'])){
	$end = escape($_GET['end'], true);
}
switch($end){
	case 1:
		$reason = $lang['call_left'];
		break;
	case 2:
		$reason = $lang['call_fund'];
		break;
	case 3:
		$reason = $lang['call_expire'];
		break;
	default:
		$reason = $lang['call_error'];
}
?>
<div class="out_page_container">
	<div class="out_page_content">
		<div class="out_page_box">
			<div class="pad_box">
				<p class="text_med bold bpad5"><?php echo $lang['call_ended']; ?></p>
				<p><?php echo $reason; ?></p>
			</div>
		</div>
	</div>
</div>