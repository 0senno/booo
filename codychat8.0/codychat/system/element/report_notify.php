<?php
$report_message = '';
$add_link = '';
if($boom['report_type'] == 1){
	$report_message = $lang['reported_chat'];
	$add_link = 'onclick="showChatReport(\'' . $boom['report_id'] . '\', this);"';
}
if($boom['report_type'] == 2){
	$report_message = $lang['reported_post'];
	$add_link = 'onclick="showWallReport(\'' . $boom['report_id'] . '\', this);"';
}
if($boom['report_type'] == 3){
	$report_message = $lang['reported_private'];
	$add_link = 'onclick="showPrivateReport(\'' . $boom['report_id'] . '\', this);"';
}
if($boom['report_type'] == 4){
	$report_message = $lang['reported_profile'];
	$add_link = 'onclick="showProfileReport(\'' . $boom['report_id'] . '\', \'' . $boom['report_target'] . '\', 4);"';
}
if($boom['report_type'] == 5){
	$report_message = $lang['reported_news'];
	$add_link = 'onclick="showNewsReport(\'' . $boom['report_id'] . '\', this);"';
}
?>
<div <?php echo $add_link; ?> class="report<?php echo $boom['report_id']; ?> fmenu_item bhover brad5 notify_item">
	<div class="notify_avatar">
		<img src="<?php echo myAvatar($boom['user_tumb']); ?>"/>
	</div>
	<div class="notify_details">
		<p class="hnotify username <?php echo myColor($boom); ?>"><?php echo $boom['user_name']; ?></p>
		<p class="notify_text" ><?php echo $report_message; ?></p>
		<p class="vpad3 sub_text text_xsmall" ><span class="bold"><?php echo $lang['reason']; ?> - </span> <?php echo renderReport($boom['report_reason']); ?></p>
	</div>
</div>