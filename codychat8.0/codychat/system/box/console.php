<?php
require('../config_session.php');
?>
<div class="modal_content">
	<p class="label"><?php echo $lang['console']; ?></p>
	<input class="full_input" id="console_content"/>
</div>
<div class="modal_control">
	<button id="send_console" onclick="sendConsole();" class="reg_button theme_btn"><i class="fa fa-check"></i> <?php echo $lang['execute']; ?></button>
	<button class="reg_button cancel_modal default_btn"><?php echo $lang['cancel']; ?></button>
</div>