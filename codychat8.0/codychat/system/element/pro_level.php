<?php if(useLevel()){ ?>
<div class="lite_olay plevel_item plevel" onclick="viewLevelStatus(<?php echo $boom['user_id']; ?>);">
	<img src="<?php echo levelIcon(); ?>"/> <span class="plevel_count"><?php echo $boom['user_level']; ?></span>
</div>
<?php } ?>