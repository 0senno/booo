<?php
if(!defined('BOOM')){
	die();
}
?>
<div class="out_page_container back_page">
	<div class="out_page_content">
		<div class="out_page_box">
			<div class="pad_box">
				<div class="bpad15">
					<img class="large_icon" src="default_images/icons/maintenance.svg"/>
				</div>
				<div class="bpad10">
					<p class="text_xlarge bold bpad10"><?php echo $lang['maint_title']; ?></p>
					<p class="text_med"><?php echo $lang['maint_text']; ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<script data-cfasync="false">
maintCheck = function(){
	$.post('system/action/action_out.php', {
		check_maintenance: 1,
		}, function(response) {
			if(response == 1){
				location.reload();
			}
	});	
}
$(document).ready(function(){
	boomCheckMaint = setInterval(maintCheck, 30000);
	maintCheck();
});
</script>

