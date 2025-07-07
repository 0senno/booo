<?php
// define call status
$status = $lang['progress'];
$scolor = 'neutralb';

if(!groupCallActive($boom)){
	$scolor = 'baseb';
	$status = $lang['ended'];	
}

?>
<div id="admingroupcall<?php echo $boom['call_id']; ?>" class="sub_list_item members_item blisting">
	<div class="sub_list_avatar hide_mobile">
		<img class="" src="default_images/call/<?php echo callIcon($boom['call_type']); ?>"/>
	</div>
	<div class="sub_list_name" onclick="getGroupCallInfo(<?php echo $boom['call_id']; ?>);">
		<p class="bold"><?php echo $boom['call_name']; ?></p>
		<p class="tpad3 text_small sub_text"><?php echo boomRenderSeconds($boom['call_time']); ?></p>
		<p class="tpad3 text_xsmall sub_text"><?php echo displayDate($boom['call_active']); ?></p>
	</div>
	<div class="sub_list_status aright">
		<p class="bellips call_status_btn <?php echo $scolor; ?>"><?php echo $status; ?></p>
	</div>
	<div onclick="deleteGroupCall(<?php echo $boom['call_id']; ?>);" class="sub_list_option">
		<i class="fa fa-times"></i>
	</div>
</div>