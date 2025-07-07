<?php
// create tables

date_default_timezone_set($setting['timezone']);

$mysqli->query("CREATE TABLE IF NOT EXISTS `boom_exp` (
	`uid` int(11) NOT NULL AUTO_INCREMENT,
	`exp_current` int(11) NOT NULL DEFAULT 0,
	`exp_week` int(11) NOT NULL DEFAULT 0,
	`exp_month` int(11) NOT NULL DEFAULT 0,
	`exp_total` int(11) NOT NULL DEFAULT 0,
PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1");

// update user_about and create new table to store users data

$mysqli->query("CREATE TABLE IF NOT EXISTS `boom_users_data` (
	`uid` int(11) NOT NULL AUTO_INCREMENT,
	`badge_auth` int(1) NOT NULL DEFAULT '0',
	`badge_member` int(11) NOT NULL DEFAULT '0',
	`badge_chat` int(11) NOT NULL DEFAULT '0',
	`badge_top` int(11) NOT NULL DEFAULT '0',
	`badge_qtop` int(11) NOT NULL DEFAULT '0',
	`badge_beat` int(11) NOT NULL DEFAULT '0',
	`badge_gold` int(11) NOT NULL DEFAULT '0',
	`badge_like` int(11) NOT NULL DEFAULT '0',
	`badge_friend` int(11) NOT NULL DEFAULT '0',
	`badge_gift` int(11) NOT NULL DEFAULT '0',
	`user_about` varchar(4000) NOT NULL DEFAULT '',
	`user_note` varchar(4000) NOT NULL DEFAULT '',
PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1");

usleep(2000000);

// insert into boom_users_data and delete old data from boom_data

$mysqli->query("
	INSERT IGNORE INTO boom_users_data (uid, user_about, user_note)
	SELECT
		data_user,
		MAX(CASE WHEN data_key = 'user_about' THEN data_value ELSE NULL END) AS user_about,
		MAX(CASE WHEN data_key = 'user_note' THEN data_value ELSE NULL END) AS user_note
	FROM boom_data
	WHERE data_key IN ('user_about', 'user_note')
	GROUP BY data_user;
");
$mysqli->query("INSERT IGNORE INTO boom_users_data (uid) SELECT user_id FROM boom_users WHERE user_id > 0");
$mysqli->query("DELETE FROM boom_data WHERE data_key = 'user_about' OR data_key = 'user_note'");

// update boom_setting

$mysqli->query("ALTER TABLE `boom_setting` ADD can_auth int(3) NOT NULL DEFAULT '100' AFTER can_rank");
$mysqli->query("ALTER TABLE `boom_setting` ADD use_level int(1) NOT NULL DEFAULT '0'");
$mysqli->query("ALTER TABLE `boom_setting` ADD level_mode int(4) NOT NULL DEFAULT '10'");
$mysqli->query("ALTER TABLE `boom_setting` ADD exp_chat int(3) NOT NULL DEFAULT '1'");
$mysqli->query("ALTER TABLE `boom_setting` ADD exp_priv int(3) NOT NULL DEFAULT '1'");
$mysqli->query("ALTER TABLE `boom_setting` ADD exp_gift int(3) NOT NULL DEFAULT '1'");
$mysqli->query("ALTER TABLE `boom_setting` ADD exp_post int(3) NOT NULL DEFAULT '1'");
$mysqli->query("ALTER TABLE `boom_setting` ADD use_rate int(1) NOT NULL DEFAULT '0'");
$mysqli->query("ALTER TABLE `boom_setting` ADD rate_limit int(3) NOT NULL DEFAULT '50'");
$mysqli->query("ALTER TABLE `boom_setting` ADD word_proof int(3) NOT NULL DEFAULT '100'");
$mysqli->query("ALTER TABLE `boom_setting` ADD use_badge int(1) NOT NULL DEFAULT '0'");
$mysqli->query("ALTER TABLE `boom_setting` ADD bachat int(2) NOT NULL DEFAULT '10'");
$mysqli->query("ALTER TABLE `boom_setting` ADD bagift int(2) NOT NULL DEFAULT '10'");
$mysqli->query("ALTER TABLE `boom_setting` ADD balike int(2) NOT NULL DEFAULT '10'");
$mysqli->query("ALTER TABLE `boom_setting` ADD bafriend int(2) NOT NULL DEFAULT '10'");
$mysqli->query("ALTER TABLE `boom_setting` ADD bagold int(6) NOT NULL DEFAULT '5000'");
$mysqli->query("ALTER TABLE `boom_setting` ADD babeat int(6) NOT NULL DEFAULT '1000'");

// update boom_clean

$mysqli->query("ALTER TABLE `boom_clean` ADD last_expw int(11) NOT NULL DEFAULT '0'");
$mysqli->query("ALTER TABLE `boom_clean` ADD last_expm int(11) NOT NULL DEFAULT '0'");

usleep(1000000);

$mysqli->query("UPDATE boom_clean SET last_expm = '".strtotime('midnight first day of next month')."' WHERE id > 0");
$mysqli->query("UPDATE boom_clean SET last_expw = '" . strtotime('next monday') . "' WHERE id > 0");
$mysqli->query("ALTER TABLE boom_clean DROP COLUMN last_vip");


// insert to boom_exp 

$mysqli->query("INSERT IGNORE INTO boom_exp (uid) SELECT user_id FROM boom_users WHERE user_id > 0");


// update users 

$mysqli->query("ALTER TABLE `boom_users` ADD exp_post int(3) NOT NULL DEFAULT '1'"); // not sure
$mysqli->query("ALTER TABLE `boom_users` ADD user_beat int(11) NOT NULL DEFAULT '0' AFTER last_action");
$mysqli->query("ALTER TABLE `boom_users` ADD user_sgold int(11) NOT NULL DEFAULT '0' AFTER user_gold");
$mysqli->query("ALTER TABLE `boom_users` ADD user_auth int(1) NOT NULL DEFAULT '0' AFTER user_ip");
$mysqli->query("ALTER TABLE `boom_users` ADD user_level int(11) NOT NULL DEFAULT '1' AFTER user_rank");

// update version

$mysqli->query("UPDATE boom_setting SET version = '5.0' WHERE id > 0");

// adding some index

boomIndexing('boom_users', 'user_rank');
boomIndexing('boom_chat', 'pghost');

redisFlushAll();
boomCacheUpdate();
boomSaveSettings();
usleep(2000000);
?>