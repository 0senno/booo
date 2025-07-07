<?php
require('../config_session.php');
if(!isset($_POST['pcom'], $_POST['plike'])){
	echo 0;
	die();
}
$pcom = escape($_POST['pcom'], true);
$plike = escape($_POST['plike'], true);
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
				<?php echo createSwitch('set_pcomment', $pcom, 'setNewsOptions'); ?>
			</div>
		</div>
	</div>
	<div class="switch_item bbackhover">
		<div class="switch_item_text">
			<?php echo $lang['post_likes']; ?>
		</div>
		<div class="switch_item_switch">
			<div class="switch_wrap">
				<?php echo createSwitch('set_plike', $plike, 'setNewsOptions'); ?>
			</div>
		</div>
	</div>
</div>