<?php
require('../config_session.php');

if(!canManageContact()){
	echo 0;
	die();
}
if(!isset($_POST['open_contact'])){
	echo 0;
	die();
}
$target = escape($_POST['open_contact'], true);
$get_contact = $mysqli->query("SELECT * FROM boom_contact WHERE id = '$target'");
$mysqli->query("UPDATE boom_contact SET cview = 1 WHERE id = '$target'");
if($get_contact->num_rows < 1){
	echo 0;
	die();
}
$contact = $get_contact->fetch_assoc();
?>
<div class="modal_content">
	<div class="vpad10">
		<p class="bold text_med"><?php echo $contact['cname']; ?></p>
		<p class="sub_text"><?php echo $contact['cemail']; ?></p>
		<div class="vpad15">
			<p class=""><?php echo linkingLink(nl2br($contact['cmessage'])); ?></p>
		</div>
	</div>
	<div class="vpad10">
		<textarea id="contact_reply" spellcheck="false" class="large_textarea full_textarea"></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="replyContact(<?php echo $contact['id']; ?>);" class="reg_button theme_btn"><i class="fa fa-paper-plane"></i> <?php echo $lang['reply']; ?></button>
	<button class="reg_button default_btn cancel_modal"><?php echo $lang['cancel']; ?></button>
	<button onclick="deleteContact(<?php echo $contact['id']; ?>);" class="button fright rtl_fleft delete_btn"><i class="fa fa-trash-can"></i></button>
</div>