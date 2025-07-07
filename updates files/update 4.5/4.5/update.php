<?php
$mysqli->query("ALTER TABLE `boom_setting` ADD can_bpriv int(3) NOT NULL DEFAULT '100' AFTER can_clear");
$mysqli->query("ALTER TABLE `boom_setting` ADD use_gender int(1) NOT NULL DEFAULT '0' AFTER use_like");
$mysqli->query("ALTER TABLE `boom_setting` ADD use_flag int(1) NOT NULL DEFAULT '0' AFTER use_like");
$mysqli->query("ALTER TABLE `boom_setting` ADD can_vghost int(3) NOT NULL DEFAULT '999' AFTER can_vemail");
$mysqli->query("ALTER TABLE `boom_setting` ADD can_warn int(3) NOT NULL DEFAULT '100' AFTER can_mute");
$mysqli->query("ALTER TABLE `boom_setting` ADD allow_vroom int(3) NOT NULL DEFAULT '100' AFTER allow_room");
 $mysqli->query("ALTER TABLE `boom_setting` ADD reg_mute int(11) NOT NULL DEFAULT '0' AFTER registration");
$mysqli->query("ALTER TABLE `boom_users` ADD warn_msg varchar(300) NOT NULL DEFAULT '' AFTER kick_msg");
$mysqli->query("ALTER TABLE `boom_users` ADD user_rmute int(11) NOT NULL DEFAULT '0' AFTER user_mute");
$mysqli->query("ALTER TABLE `boom_console` ADD ctext varchar(400) NOT NULL DEFAULT '' AFTER reason");
$mysqli->query("UPDATE boom_setting SET version = '4.5' WHERE id > 0");

setcookie(BOOM_PREFIX . "ssid","{$data['session_id']}",time()+ 31556926, '/');

redisFlushAll();
boomCacheUpdate();
usleep(6000000);
?>