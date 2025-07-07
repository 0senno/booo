<?php
require('../config_session.php');
function myIgnore(){
	global $data, $mysqli, $lang;
	$ignore_list = '';
	$find_ignore = $mysqli->query("SELECT boom_users.user_name, boom_users.user_id, boom_users.user_tumb, boom_users.user_color, boom_users.last_action, boom_users.user_rank, boom_ignore.* FROM boom_users, boom_ignore 
	WHERE ignorer = '{$data['user_id']}' AND ignored = boom_users.user_id ORDER BY boom_users.user_name ASC");
	if($find_ignore->num_rows > 0){
		while($find = $find_ignore->fetch_assoc()){
		$ignore_list .= boomTemplate('element/ignore_element', $find);
		}
	}
	else {
		$ignore_list .= emptyZone($lang['no_ignore']);
	}
	return $ignore_list;
}
?>
<div class="modal_content tpad15">
	<div class="ulist_container">
		<div class="ignore_listing">
			<?php echo myIgnore(); ?>
		</div>
	</div>
</div>