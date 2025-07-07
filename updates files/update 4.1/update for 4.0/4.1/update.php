<?php
$mysqli->query("UPDATE boom_setting SET version = '4.1' WHERE id > 0");
$mysqli->query("UPDATE boom_setting SET bbfv = bbfv + 0.01 WHERE id > 0");
boomSaveSettings();
?>