<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
$good = '<i class="fa fa-check success"></i>';
$bad = '<i class="fa fa-times error"></i>';
$warn = '<i class="fa fa-exclamation warn"></i>';

$check_upload = $good;
$check_avatar = $good;
$check_cover = $good;
$check_gift = $good;
$check_gd = $good;
$check_php = $good;
$check_curl = $good;
$check_zip = $good;
$check_mbstring = $good;
$check_settings = $good;
$check_app = $good;

if(!is_writable(dirname(BOOM_PATH . '/avatar'))){
	$check_avatar = $bad;
}
if(!is_writable(dirname(BOOM_PATH . '/cover'))){
	$check_cover = $bad;
}
if(!is_writable(BOOM_PATH . '/system/settings.php')){
	$check_settings = $bad;
}
if(!is_writable(BOOM_PATH . '/js/pwa/manifest.json')){
	$check_app = $bad;
}
if(!is_writable(dirname(BOOM_PATH . '/upload'))){
	$check_upload = $bad;
}
if(!is_writable(dirname(BOOM_PATH . '/gift'))){
	$check_gift = $bad;
}
if(!extension_loaded('gd') && !function_exists('gd_info')) {
	$check_gd = $bad;
}
if(version_compare(PHP_VERSION, '8.1.0', '<')){
	$check_php = $bad;
}
if(version_compare(PHP_VERSION, '8.4.0', '>=')){
	$check_php = $bad;
}
if (!function_exists('curl_init')) {
	$check_curl = $bad;
}
if(!extension_loaded('zip')){
	$check_zip = $bad;
}
if(!extension_loaded('mbstring')){
	$check_mbstring = $bad;
}
?>
<?php echo elementTitle('Writable files / folders'); ?>
<div class="page_full">
	<div class="page_element">
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<i class="fa-regular fa-file"></i> system / settings.php
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_settings; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<i class="fa-regular fa-file"></i> js / pwa / manifest.json
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_app; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<i class="fa-regular fa-folder"></i> avatar folder
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_avatar; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<i class="fa-regular fa-folder"></i> cover folder
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_cover; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<i class="fa-regular fa-folder"></i> upload folder
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_upload; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<i class="fa-regular fa-folder"></i> gift folder
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_gift; ?>
			</div>
		</div>
	</div>
</div>
<?php echo elementTitle('Required PHP modules'); ?>
<div class="page_full">
	<div class="page_element">
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				Php version 8.1 to 8.3
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_php; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				GD library
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_gd; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				Curl extension
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_curl; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				Zip extension
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_zip; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				Mbstring extension
			</div>
			<div class="listing_reg_icon">
				<?php echo $check_mbstring; ?>
			</div>
		</div>
	</div>
</div>
<?php echo elementTitle('System information'); ?>
<div class="page_full">
	<div class="page_element">
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<?php echo $lang['current_version']; ?> <?php echo $setting['version']; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<?php echo $lang['php_version']; ?> <?php echo PHP_VERSION; ?>
			</div>
		</div>
		<div class="listing_reg blisting system_item">
			<div class="listing_reg_content">
				<?php echo $lang['max_upload']; ?> <?php echo ini_get("upload_max_filesize"); ?>
			</div>
		</div>
	</div>
</div>