<?php
require('../config_session.php');
require(BOOM_PATH . '/system/language/' . $data['user_language'] . '/history.php');

function renderHistoryText($history){
	global $data, $hlang, $lang;
	$ctext = $hlang[$history['htype']];
	$ctext = str_replace('%hunter%', $history['user_name'], $ctext);
	$ctext = str_replace('%delay%', boomRenderMinutes($history['delay']), $ctext);
	return $ctext;
}

if(!isset($_POST['target'])){
	echo 0;
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);
if(empty($user)){
	echo 0;
	die();
}
if(!canUserHistory($user)){
	echo 0;
	die();
}

$find_history = $mysqli->query("
	SELECT boom_history.*, boom_users.user_name, boom_users.user_tumb, boom_users.user_color
	FROM boom_history
	LEFT JOIN boom_users
	ON boom_history.hunter = boom_users.user_id
	WHERE boom_history.target = '{$user['user_id']}'
	ORDER BY boom_history.history_date DESC LIMIT 50
");

$history_list = '';
if($find_history->num_rows > 0){
	while($history = $find_history->fetch_assoc()){
		$history_list .= boomTemplate('element/history_log', $history);
	}
}
?>
<div class="modal_content">
	<div class="tmargin15 box_height500">
		<?php
			if($history_list != ''){
				echo $history_list;
			}
			else {
				echo emptyZone($lang['no_data']);
			}
		?>
	</div>
</div>