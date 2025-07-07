<?php
$mysqli->query("ALTER TABLE `boom_news` ADD news_like int(1) NOT NULL DEFAULT '1' AFTER id");
$mysqli->query("ALTER TABLE `boom_news` ADD news_comment int(1) NOT NULL DEFAULT '1' AFTER id");
$mysqli->query("ALTER TABLE `boom_post` ADD post_like int(1) NOT NULL DEFAULT '1' AFTER post_id");
$mysqli->query("ALTER TABLE `boom_post` ADD post_comment int(1) NOT NULL DEFAULT '1' AFTER post_id");
$mysqli->query("ALTER TABLE `boom_setting` ADD can_rlogs int(1) NOT NULL DEFAULT '6'");
$mysqli->query("ALTER TABLE `boom_setting` ADD can_rclear int(1) NOT NULL DEFAULT '6'");
$mysqli->query("ALTER TABLE `boom_setting` ADD can_rpass int(3) NOT NULL DEFAULT '100' AFTER can_clear");
$mysqli->query("UPDATE boom_setting SET version = '4.2' WHERE id > 0");

redisFlushAll();
boomCacheUpdate();
boomSaveSettings();
?>