<?php
// define call status

$status = $lang['progress'];
$scolor = 'neutralb';

if(!callActive($boom)){
	$scolor = 'baseb';
	$status = $lang['ended'];	
}

// define call icon

if($boom['call_type'] == 1){
	$icon = 'video_call.svg';
}
else {
	$icon = 'audio_call.svg';
}
?>
<div id="admincall<?php echo $boom['call_id']; ?>" class="sub_list_item members_item blisting">
	<div class="sub_list_avatar hide_mobile">
		<img class="" src="default_images/call/<?php echo $icon; ?>"/>
	</div>
	<div class="sub_list_name" onclick="getCallInfo(<?php echo $boom['call_id']; ?>);">
		<p class="bold"><?php echo $boom['call_room']; ?></p>
		<p class="tpad3 text_small sub_text"><?php echo boomRenderSeconds($boom['call_active'] - $boom['call_time']); ?></p>
		<p class="tpad3 text_xsmall sub_text"><?php echo displayDate($boom['call_time']); ?></p>
	</div>
	<div class="sub_list_status aright">
		<p class="bellips call_status_btn <?php echo $scolor; ?>"><?php echo $status; ?></p>
	</div>
</div>