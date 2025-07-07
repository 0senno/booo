<div class="btable">
	<?php if($boom['icon'] != ''){ ?>
	<div class="subi subm_icon bcell_mid">
		<i class="fa fa-<?php echo $boom['icon']; ?>"></i>
	</div>
	<?php } ?>
	<div class="bcell_mid">
		<p class="subm_title"><?php echo $boom['title']; ?></p>
		<?php if($boom['sub'] != ''){ ?>
		<p class="subm_sub sub_text bellips"><?php echo $boom['sub']; ?></p>
		<?php } ?>
	</div>
</div>