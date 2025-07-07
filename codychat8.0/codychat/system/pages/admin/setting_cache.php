<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}

$good = '<span class="success">Online</span>';
$bad = '<span class="error">Offline</span>';

$result = $bad;
$con = 0;
if(extension_loaded('redis')){
	try{
		$redis = new Redis(); 
		$redis->connect(REDIS_IP, REDIS_PORT, 0.2);
		$result = $good;
		$con = 1;
	}
	catch(\RedisException $e){
		$result = $bad;
		$con = 0;
	}
}
$con_status = '<span class="error">Not connected</span>';
if($con){
	if($setting['redis_status'] == 1){
		$con_status = '<span class="success">Connected</span>';
	}
	else {
		$con_status = '<span class="error">Not connected</span>';
	}
}
?>
<?php echo elementTitle($lang['cache']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['redis_status']; ?> <?php echo createInfo('redis_cache'); ?></p>
				<select id="set_redis_status">
					<?php echo onOff($setting['redis_status']); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminCache();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
			<button onclick="flushCache();" type="button" class="reg_button default_btn "><?php echo $lang['redis_flush']; ?></button>
		</div>
	</div>
	<div class="page_element">
		<div class="blist pad10">
			<span class="bold">Redis server : </span><?php echo $result; ?>
		</div>
		<div class="blist pad10">
			<span class="bold">Redis Status : </span><?php echo $con_status; ?>
		</div>
		<div class="blist pad10">
			<span class="bold">Redis ip : </span><?php echo REDIS_IP; ?>
		</div>
		<div class="blist pad10">
			<span class="bold">Redis port : </span><?php echo REDIS_PORT; ?>
		</div>
		<div class="blist pad10">
			<span class="bold">Redis timeout : </span><?php echo REDIS_TIMEOUT; ?>
		</div>
	</div>
</div>