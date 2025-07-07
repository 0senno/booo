<?php
require('../config_session.php');
if(!isset($_POST['wcom'], $_POST['wlike'])){
	echo 0;
	die();
}
$pcom = escape($_POST['wcom'], true);
$plike = escape($_POST['wlike'], true);
?>
<div class="modal_title">
	<?php echo $lang['post_options']; ?>
</div>
<div class="modal_content">
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['post_comments']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_wcomment', $pcom, 'setWallOptions'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['post_likes']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_wlike', $plike, 'setWallOptions'); ?>
			</div>
		</div>
	</div>
</div>