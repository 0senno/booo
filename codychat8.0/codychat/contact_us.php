<?php
require("system/config.php");

$page_info = array(
	'page'=> 'privacy',
	'page_out'=> 1,
);

// loading head tag element
include('control/head_load.php');

// load page header
include('control/header.php');

// load page content
echo boomTemplate('element/base_page_no_menu', boomTemplate('pages/contact/contact_us'));
echo boomTemplate('element/page_footer');

?>
<script data-cfasync="false" src="js/function_contact.js<?php echo $bbfv; ?>"></script>
<?php
include('control/captcha.php');
include('control/body_end.php');
?>