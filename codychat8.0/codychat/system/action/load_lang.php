<?php
require('../config.php');
if(isset($_POST['lang'])){
	$lang = boomSanitize($_POST['lang']);
	if(file_exists(BOOM_PATH . '/system/language/' . $lang . '/language.php')){
		setBoomLang($lang);
	}
}
?>