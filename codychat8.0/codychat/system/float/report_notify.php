<?php
require('../config_session.php');

if(!canManageReport()){
	echo emptyZone($lang['no_report'], array('size'=> 'reg_icon'));
	die();
}
$report_list = '';
$find_report = $mysqli->query("SELECT boom_report.*, boom_users.user_name, boom_users.user_id, boom_users.user_color, boom_users.user_tumb
FROM boom_report, boom_users WHERE boom_report.report_user = boom_users.user_id
ORDER BY report_date DESC LIMIT 40");

if($find_report->num_rows > 0){
	while($report = $find_report->fetch_assoc()){
		$report_list .= boomTemplate('element/report_notify', $report);
	}
}
else {
	$report_list .= emptyZone($lang['no_report'], array('size'=> 'reg_icon'));
}
echo $report_list;
?>
