<?php
function getWeekWinner(){
	global $mysqli, $setting;
	$get_winner = $mysqli->query("SELECT * FROM boom_exp WHERE exp_week = ( SELECT MAX(exp_week) FROM boom_exp )");
	if($get_winner->num_rows > 0){
		$winner = $get_winner->fetch_assoc();
		return $winner['uid'];
	}
}
function getMonthWinner(){
	global $mysqli, $setting;
	$get_winner = $mysqli->query("SELECT * FROM boom_exp WHERE exp_month = ( SELECT MAX(exp_month) FROM boom_exp )");
	if($get_winner->num_rows > 0){
		$winner = $get_winner->fetch_assoc();
		return $winner['uid'];
	}
}
function createLeader($lead, $rank, $type, $icon){
	return '<div class="puser_item  blisting ' . myElement($lead['user_id'], 'cselected') . '">
				<div class="puser_rank">
					' . ranking($rank) . '
				</div>
				<div class="get_info puser_avatar" data="' . $lead['user_id'] . '">
					<img class="lazy" data-src="' . myAvatar($lead['user_tumb']) . '" src="' . imgLoader() . '"/>
				</div>
				<div class="puser_name">
					<p class="username ' . myColor($lead) . '">' . $lead["user_name"] . '</p>
				</div>
				<div class="puser_score rtl_aleft">
					' . $lead[$type] . '
				</div>
				<div class="puser_icon">
					<img src="' . $icon . '"/>
				</div>
			</div>';
}

// xp

function getXpLeader($type){
	global $mysqli, $setting, $lang;
	$leader_list = '';
	$get_leader = $mysqli->query("
		SELECT 
		boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_level, boom_users.user_tumb, boom_exp.$type
		FROM boom_users
		JOIN boom_exp ON boom_users.user_id = boom_exp.uid
		ORDER BY boom_exp.$type DESC
		LIMIT 50;
	");
	if($get_leader->num_rows > 0){
		$rank = 1;
		while($lead = $get_leader->fetch_assoc()){
			$leader_list .= createLeader($lead, $rank, $type, xpIcon());
			$rank++;
		}		
	}
	if(empty($leader_list)){
		$leader_list .= emptyZone($lang['no_data']);
	}
	return $leader_list;
}

// gold

function getGoldLeader($type){
	global $mysqli, $setting, $lang;
	$leader_list = '';
	$get_leader = $mysqli->query("
		SELECT user_id, user_name, user_color, user_rank, user_tumb, user_gold, user_bot
		FROM boom_users 
		WHERE user_rank > 0 AND user_bot = 0
		ORDER BY $type DESC LIMIT 100
	");
	if($get_leader->num_rows > 0){
		$rank = 1;
		while($lead = $get_leader->fetch_assoc()){
			$leader_list .= createLeader($lead,$rank,$type, goldIcon());
			$rank++;
		}		
	}
	if(empty($leader_list)){
		$leader_list .= emptyZone($lang['no_data']);
	}
	return $leader_list;
}

// level 

function getLevelLeader(){
	global $mysqli, $setting, $lang;
	$leader_list = '';
	$get_leader = $mysqli->query("
		SELECT user_id, user_name, user_color, user_rank, user_level, user_tumb, user_bot
		FROM boom_users 
		WHERE user_rank > 0 AND user_bot = 0
		ORDER BY user_level DESC LIMIT 100
	");
	if($get_leader->num_rows > 0){
		$rank = 1;
		while($lead = $get_leader->fetch_assoc()){
			$leader_list .= createLeader($lead,$rank, 'user_level', levelIcon());
			$rank++;
		}		
	}
	if(empty($leader_list)){
		$leader_list .= emptyZone($lang['no_data']);
	}
	return $leader_list;
}

// like

function getLikeLeader(){
	global $mysqli, $setting, $lang;
	$leader_list = '';
	$get_leader = $mysqli->query("
		SELECT u.user_id, u.user_name, u.user_tumb, u.user_rank, u.user_color, l.like_count
		FROM boom_users u
		JOIN (
			SELECT target AS user_id, COUNT(id) AS like_count
			FROM boom_pro_like
			GROUP BY target
		) l ON u.user_id = l.user_id
		ORDER BY l.like_count DESC
		LIMIT 100
	");
	if($get_leader->num_rows > 0){
		$rank = 1;
		while($lead = $get_leader->fetch_assoc()){
			$leader_list .= createLeader($lead,$rank, 'like_count', likeIcon());
			$rank++;
		}		
	}
	if(empty($leader_list)){
		$leader_list .= emptyZone($lang['no_data']);
	}
	return $leader_list;
}

// gift 

// gift 

function getGiftLeader($type){
	global $mysqli, $setting, $lang;
	if($type == 'gold'){
		$q = '
			SELECT
				u.user_id, u.user_name, u.user_tumb, u.user_rank, u.user_color, g.total_count
			FROM boom_users u
			JOIN (
				SELECT l.target AS user_id, SUM(g.gift_cost * l.gift_count) AS total_count
				FROM boom_users_gift l
				JOIN boom_gift g ON l.gift = g.id
				WHERE g.gift_method = 1
				GROUP BY l.target
			) g ON u.user_id = g.user_id
			ORDER BY g.total_count DESC
			LIMIT 100;
		';
		$icon = goldIcon();
	}
	else if($type == 'ruby'){
		$q = '
			SELECT
				u.user_id, u.user_name, u.user_tumb, u.user_rank, u.user_color, g.total_count
			FROM boom_users u
			JOIN (
				SELECT l.target AS user_id, SUM(g.gift_cost * l.gift_count) AS total_count
				FROM boom_users_gift l
				JOIN boom_gift g ON l.gift = g.id
				WHERE g.gift_method = 2
				GROUP BY l.target
			) g ON u.user_id = g.user_id
			ORDER BY g.total_count DESC
			LIMIT 100;
		';
		$icon = rubyIcon();
	}
	else if($type == 'count'){
		$q = '
			SELECT u.user_id, u.user_name, u.user_tumb, u.user_rank, u.user_color, g.total_count
			FROM boom_users u
			JOIN (
				SELECT target AS user_id, SUM(gift_count) AS total_count
				FROM boom_users_gift
				GROUP BY target
			) g ON u.user_id = g.user_id
			ORDER BY g.total_count DESC
			LIMIT 100
		';
		$icon = giftIcon();
	}
	$leader_list = '';
	$get_leader = $mysqli->query("$q");
	if($get_leader->num_rows > 0){
		$rank = 1;
		while($lead = $get_leader->fetch_assoc()){
			$leader_list .= createLeader($lead, $rank, 'total_count', $icon);
			$rank++;
		}		
	}
	if(empty($leader_list)){
		$leader_list .= emptyZone($lang['no_data']);
	}
	return $leader_list;
}
?>