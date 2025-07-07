<div id="pagbox<?php echo $boom['id']; ?>" data-max="<?php echo $boom['state']; ?>" data-cur="1" class="pagelement">
	<?php echo $boom['content']; ?>
	<div class="clear"></div>
	<?php if($boom['state'] > 1){ ?>
	<div class="vpad10 no_rtl bclear <?php echo $boom['menu']; ?>">
		<div data-pag="<?php echo $boom['id']; ?>" class="pagarrow pag_btn pagdown">
			<
		</div>
		<div data-pag="<?php echo $boom['id']; ?>" class="pagarrow pag_btn pagup">
			>
		</div>
	</div>
	<?php } ?>
</div>