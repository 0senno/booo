<?php
require(__DIR__ . '/../../config_admin.php');

if(!canManageIp()){
	die();
}
?>
<?php echo elementTitle($lang['manage_ban']); ?>
<div class="page_full">
	<div class="page_element">
		<div id="ip_search">
			<div class="search_bar">
				<input id="search_ip" placeholder="<?php echo $lang['search']; ?>" class="full_input" type="text"/>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="page_element">
		<div id="ip_list">
			<?php echo listAdminIp(); ?>
		</div>
	</div>
</div>