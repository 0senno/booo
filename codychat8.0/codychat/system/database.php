<?php
// base system prefix
define('BOOM_PREFIX', 'tc_');

// optional base domain
define('BOOM_DOMAIN', '');

// default redis configuration
define('REDIS_IP', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_TIMEOUT', 0.2);
define('REDIS_PASS', '');

// you can edit these lines to configure new setting for your chat
define('BOOM_DHOST', '');
define('BOOM_DUSER', '');
define('BOOM_DPASS', '');
define('BOOM_DNAME', '');

// base system main path do not modify
define('BOOM_PATH', dirname(__DIR__));

// do not modify those variables
define('BOOM_CRYPT', '');
define('BOOM_INSTALL', 0);
define('BOOM', 1);
?>