<div id="pagbox<?php echo $boom['id']; ?>" data-max="<?php echo $boom['state']; ?>" data-cur="1" class="pagelement">
	<?php echo $boom['content']; ?>
	<div class="clear"></div>
	<?php if($boom['state'] > 1){ ?>
	<div class="pagload<?php echo $boom['id']; ?> vpad10 no_rtl bclear <?php echo $boom['menu']; ?>">
		<button data-pag="<?php echo $boom['id']; ?>"class="reg_button pag_btn pagload"><?php echo $lang['load_more']; ?></button>
	</div>
	<?php } ?>
</div>
