<?php
require('../config_session.php');
if(!isset($_POST['id'])){
	echo 0;
	die();
}
$id = escape($_POST['id'], true);

$wall = wallDetails($id);

if(empty($wall)){
	echo 0;
	die();
}
if(!mySelf($wall['post_user'])){
	echo 0;
	die();
}
?>
<div class="modal_title">
	<?php echo $lang['post_options']; ?>
</div>
<div class="modal_content">
	<div id="wall_target" class="hidden" data="<?php echo $id; ?>">
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['post_comments']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_wcomment', $wall['post_comment'], 'saveWallOptions'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['post_likes']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_wlike', $wall['post_like'], 'saveWallOptions'); ?>
			</div>
		</div>
	</div>
</div>