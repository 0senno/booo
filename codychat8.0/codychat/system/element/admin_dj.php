<?php
$onair = '';
if(isOnAir($boom)){
	$onair = 'success';
}
?>
<div class="sub_list_item members_item blisting" id="djuser<?php echo $boom['user_id']; ?>">
	<div class="sub_list_avatar">
		<img class="lazy admin_user<?php echo $boom['user_id']; ?>" data-src="<?php echo myAvatar($boom['user_tumb']); ?>" src="<?php echo imgLoader(); ?>"/>
		<img class="sub_list_active" src="<?php echo userActive($boom); ?>"/>
	</div>
	<div class="sub_list_name">
		<p class="username <?php echo myColor($boom); ?>"><?php echo $boom['user_name']; ?></p>
	</div>
	<div onclick="onAirUser(<?php echo $boom['user_id']; ?>);" class="sub_list_option">
		<i class="fa fa-microphone edit_btn <?php echo $onair; ?>" id="dj<?php echo $boom['user_id']; ?>"></i>
	</div>
	<div onclick="getProfile(<?php echo $boom['user_id']; ?>);" class="sub_list_option">
		<i class="fa fa-edit edit_btn"></i>
	</div>
	<div onclick="removeDj(<?php echo $boom['user_id']; ?>);" class="sub_list_option">
		<i class="fa fa-times edit_btn"></i>
	</div>
</div>