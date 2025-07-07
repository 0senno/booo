<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['system_update']); ?>
<div class="page_full">
	<div class="page_element">
		<div id="update_list">
		<?php echo getUpdateList(); ?>
		</div>
	</div>
</div>