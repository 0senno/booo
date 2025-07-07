<?php
require('../config_session.php');
?>
<div class="modal_content hpad15">
	<div class="centered_element tpad25">
		<div class="bpad15 tpad10">
			<p class="text_med bold"><?php echo $lang['logout_title']; ?></p>
			<p class="tpad10"><?php echo $lang['logout_text']; ?></p>
		</div>
	</div>
</div>
<div class="modal_control centered_element">
	<button onclick="otherLogout();" class="reg_button ok_btn close_over"><?php echo $lang['yes']; ?></button>
	<button class="reg_button default_btn close_over"><?php echo $lang['cancel']; ?></button>
</div>