<div id="gcall<?php echo $boom['call_id']; ?>" onclick="openJoinGroupCall(<?php echo $boom['call_id']; ?>, <?php echo $boom['call_access']; ?>);" class="sub_list_item pad10 blisting join_group_call call_element">
	<div class="call_cicon_wrap bcell_mid">
		<img src="default_images/call/<?php echo callIcon($boom['call_type']); ?>"/>
	</div>
	<div class="sub_list_content hpad5">
		<div class="call_name">
			<p class="bold"><?php echo $boom['call_name']; ?></p>
			<p class="sub_text text_xsmall callusername"><?php echo $boom['user_name']; ?></p>
		</div>
		<div class="btable">
			<?php if(roomPass($boom['call_password'])){ ?>
			<div class="call_opt bcell_mid">
				<?php echo roomLock($boom['call_password'], 'call_ctag'); ?>
			</div>
			<?php } ?>
			<div class="call_opt bcell_mid">
				<?php echo roomAccess($boom['call_access'], 'call_ctag'); ?>
			</div>
			<div class="bcell_mid call_count hpad3 rtl_aleft">
				<?php echo $boom['user_count']; ?>
			</div>
			<div class="call_opt bcell_mid">
				<img  class="room_ctag" src="default_images/rooms/user_count.svg">
			</div>
		</div>
	</div>
</div>