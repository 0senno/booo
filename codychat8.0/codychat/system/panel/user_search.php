<?php
require('../config_session.php');
?>

<div id="ev_search_container" class="boom_keep">
	<div class="pad10">
		<div class="bpad5">
			<p class="label"><?php echo $lang['username']; ?></p>
			<input id="usearch_input" name="evolve_users" class="evolve_users full_input" value="" type="text" autocomplete="off" />
		</div>
		<div class="bmargin10 form_split">
			<div class="form_left">
				<p class="label"><?php echo $lang['type']; ?></p>
				<select id="usearch_type">
					<option value="1"><?php echo $lang['all']?></option>
					<option value="2"><?php echo $lang['female']?></option>
					<option value="3"><?php echo $lang['male']?></option>
					<option value="4"><?php echo $lang['staff']?></option>
				</select>
			</div>
			<div class="form_right">
				<p class="label"><?php echo $lang['order_by']; ?></p>
				<select id="usearch_order">
					<option value="0"><?php echo $lang['random']; ?></option>
					<option value="1"><?php echo $lang['newest']; ?></option>
					<option value="2"><?php echo $lang['last_action']; ?></option>
					<option value="3"><?php echo $lang['username']; ?></option>
					<option value="4"><?php echo $lang['user_rank']; ?></option>
				</select>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="pad10" id="usearch_result">
	</div>
</div>