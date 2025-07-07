<?php
require(__DIR__ . '/../../config_admin.php');

if(!canManageUser()){
	die();
}
?>
<?php echo elementTitle($lang['manage_member']); ?>
<div class="page_full">
	<div class="page_element">
		<?php if(canCreateUser()){ ?>
		<button onclick="createUser();" class="theme_btn bmargin10 reg_button"><i class="fa fa-plus-circle"></i> <?php echo $lang['add_user']; ?></button>
		<?php } ?>
		<p class="label"><?php echo $lang['search_member']; ?></p>
		<div class="admin_search">
			<div class="admin_input bcell">
				<input class="full_input" id="member_to_find" type="text"/>
			</div>
			<div id="search_member" class="admin_search_btn default_btn">
				<i class="fa fa-search" aria-hidden="true"></i>
			</div>
		</div>
		<div class="setting_element ">
			<p class="label"><?php echo $lang['advance_search']; ?></p>
			<select id="member_critera">
				<option value="1000" selected disabled><?php echo $lang['select_critera']; ?></option>
				<?php echo searchRank(); ?>
				<option value="bot"><?php echo $lang['user_bot']; ?></option>
				<?php if(canViewInvisible()){ ?>
				<option value="invisible"><?php echo $lang['invisible']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="page_full" id="member_list">
		<div class="page_element">
				<?php echo listLastMembers(); ?>
		</div>
	</div>
</div>