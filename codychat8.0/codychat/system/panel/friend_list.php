<?php
require('../config_session.php');

$delay = getDelay();
$friend_list = '';
$online_friend = '';
$offline_friend = '';
$friends = 0;
$lazy_state = 0;
$lazy_min = 20;

$find_friend = $mysqli->query("
	SELECT boom_users.*, boom_friends.* 
	FROM boom_users, boom_friends 
	WHERE hunter = '{$data['user_id']}' AND fstatus = '3' AND target = boom_users.user_id 
	ORDER BY user_name ASC
");

if($find_friend->num_rows > 0){				
	while($find = $find_friend->fetch_assoc()){
		$friends++;
		if($find['last_action'] > getDelay()){
			$online_friend .= createUserList($find);
		}
		else {
			if($lazy_state < $lazy_min){
				$offline_friend .= createUserList($find);
				$lazy_state++;
			}
			else {
				$offline_friend .= createUserList($find, true);
			}
		}
	}
}
$glob_friend = $online_friend . $offline_friend;
?>
<div id="container_friendship">
	<?php if($glob_friend == ''){ ?>
	<div class="boom_keep pad10" id="container_friends">
		<?php echo emptyZone($lang['no_friend']); ?>
	</div>
	<?php } ?>
	<?php if($glob_friend != ''){ ?>
	<div class="pad10" id="friend_search_box">
		<div class="search_bar">
			<input id="search_friend" placeholder="<?php echo $lang['search']; ?>" class="full_input" type="text"/>
			<div class="clear"></div>
		</div>
	</div>
	<div class="boom_keep pad10" id="container_friends">
		<?php if($online_friend != ''){ ?>
		<div class="online_user">
			<?php echo $online_friend; ?>
		</div>
		<?php } ?>
		<?php if($offline_friend != ''){ ?>
		<div class="user_count">
			<div class="bcell">
				<?php echo $lang['offline']; ?>
			</div>
		</div>
		<div class="offline_user">
			<?php echo $offline_friend; ?>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>