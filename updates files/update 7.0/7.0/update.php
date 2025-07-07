<?php
// add new settings

$mysqli->query("ALTER TABLE `boom_setting` ADD live_url varchar(60) NOT NULL DEFAULT ''");
$mysqli->query("ALTER TABLE `boom_setting` ADD live_appid varchar(50) NOT NULL DEFAULT ''");
$mysqli->query("ALTER TABLE `boom_setting` ADD live_secret varchar(100) NOT NULL DEFAULT ''");
$mysqli->query("ALTER TABLE `boom_setting` ADD use_app int(1) NOT NULL DEFAULT '0'");
$mysqli->query("ALTER TABLE `boom_setting` ADD app_name varchar(30) NOT NULL DEFAULT 'Chat'");
$mysqli->query("ALTER TABLE `boom_setting` ADD app_color varchar(10) NOT NULL DEFAULT '#000000'");
$mysqli->query("ALTER TABLE `boom_setting` ADD openai_key varchar(200) NOT NULL DEFAULT ''");
$mysqli->query("ALTER TABLE `boom_setting` ADD mod_cat varchar(200) NOT NULL DEFAULT ''");
$mysqli->query("ALTER TABLE `boom_setting` ADD img_mod int(1) NOT NULL DEFAULT '0'");

// add chat table 

$mysqli->query("ALTER TABLE `boom_chat` ADD log_uid int(11) NOT NULL DEFAULT '0'");

// add user table

$mysqli->query("ALTER TABLE `boom_users` ADD ufriend int(1) NOT NULL DEFAULT '1'");


// call table
$mysqli->query("ALTER TABLE boom_call MODIFY COLUMN call_token VARCHAR(500) DEFAULT ''");
$mysqli->query("ALTER TABLE `boom_call` ADD call_token2 varchar(500) NOT NULL DEFAULT ''");

$mysqli->query("UPDATE boom_setting SET version = 7.0 WHERE id > 0");

redisFlushAll();
boomCacheUpdate();
boomSaveSettings();
?>