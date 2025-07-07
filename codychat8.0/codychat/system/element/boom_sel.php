<div class="btable">
	<?php if($boom['icon'] != ''){ ?>
	<div class="boom_sel_icon">
		<img class="boom_cur_icon" src="<?php echo $boom['icon']; ?>"/>
	</div>
	<?php } ?>
	<div class="boom_cur_text boom_sel_text">
		<?php echo $boom['text']; ?>
	</div>
	<div class="boom_sel_menu bcell_mid">
		<i class="fa fa-bars"></i>
	</div>
</div>