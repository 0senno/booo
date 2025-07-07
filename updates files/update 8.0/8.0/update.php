<?php
$rules_content = '<p class="text_title">Title here</p>\n<p class="text_text sub_text">\nSed ut perspiciatiae dicta\nsunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia\nconsequuntur magni dolores eos qui ratione adipisci velit, sed quia non numquam eius modi tempora\nincidunt uaerat voluptatem. Ut enim ad minima veniam, quis nostrum\n</p>\n\n<p class="text_title">Title here</p>\n<p class="text_text sub_text">\nSed ut perspiciatiae dicta\nsunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia\nconsequuntur magni dolores eos qui ratione adipisci velit, sed quia non numquam eius modi tempora\nincidunt uaerat voluptatem. Ut enim ad minima veniam, quis nostrum\n</p>\n\n<p class="text_title">Title here</p>\n<p class="text_text sub_text">\nSed ut perspiciatiae dicta\nsunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia\nconsequuntur magni dolores eos qui ratione adipisci velit, sed quia non numquam eius modi tempora\nincidunt uaerat voluptatem. Ut enim ad minima veniam, quis nostrum\n</p>';

$mysqli->query("ALTER TABLE `boom_setting` ADD can_cgcall int(3) NOT NULL DEFAULT '100'");
$mysqli->query("ALTER TABLE `boom_setting` ADD can_gcall int(3) NOT NULL DEFAULT '100'");
$mysqli->query("ALTER TABLE `boom_setting` ADD can_mgcall int(3) NOT NULL DEFAULT '100'");
$mysqli->query("ALTER TABLE `boom_setting` ADD max_gcall int(5) NOT NULL DEFAULT '180'");

$mysqli->query("ALTER TABLE `boom_users` ADD ugcall int(1) NOT NULL DEFAULT '0'");

$mysqli->query("CREATE TABLE IF NOT EXISTS `boom_group_call` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `call_name` varchar(100) NOT NULL DEFAULT '',
  `call_creator` int(11) NOT NULL DEFAULT '0',
  `call_type` int(1) NOT NULL DEFAULT '1',
  `call_active` int(11) NOT NULL DEFAULT '0',
  `call_time` int(11) NOT NULL DEFAULT '0',
  `call_paid` int(11) NOT NULL DEFAULT '0',
  `call_method` int(1) NOT NULL DEFAULT '0',
  `call_room` varchar(100) NOT NULL DEFAULT '',
  `call_password` varchar(40) NOT NULL DEFAULT '',
  `call_date` int(1) NOT NULL DEFAULT '0',
  `call_access` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`call_id`),
  KEY `call_date` (`call_date`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1");	

$mysqli->query("CREATE TABLE IF NOT EXISTS `boom_call_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `call_room` int(11) NOT NULL DEFAULT '0',
  `hunter` int(11) NOT NULL DEFAULT '0',
  `target` int(11) NOT NULL DEFAULT '0',
  `action_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `target` (`target`),
  KEY `action_time` (`action_time`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1");	

$mysqli->query("CREATE TABLE IF NOT EXISTS `boom_call_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `croom` int(11) NOT NULL DEFAULT '0',
  `cuser` int(11) NOT NULL DEFAULT '0',
  `cdate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `croom` (`croom`),
  KEY `cuser` (`cuser`),
  KEY `cdate` (`cdate`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1");

$mysqli->query("CREATE TABLE IF NOT EXISTS `boom_act` (
  `act_user` int(11) NOT NULL DEFAULT '0',
  `act_name` varchar(100) NOT NULL DEFAULT '',
  `act_time` int(11) NOT NULL DEFAULT '0',
  KEY `act_name` (`act_name`),
  KEY `act_user` (`act_user`),
  KEY `act_time` (`act_time`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1");

$mysqli->query("INSERT INTO `boom_page` (`page_name`, `page_content`) VALUES ('rules', '$rules_content')");

$mysqli->query("UPDATE boom_setting SET version = '8.0' WHERE id > 0");

redisFlushAll();
boomCacheUpdate();
boomSaveSettings();
?>