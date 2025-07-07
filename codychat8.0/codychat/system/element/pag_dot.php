<div id="pagbox<?php echo $boom['id']; ?>" class="pagelement">
	<?php echo $boom['content']; ?>
	<div class="clear"></div>
	<?php if($boom['state'] > 1){ ?>
	<div class="vpad10 no_rtl bclear <?php echo $boom['menu']; ?>">
		<?php
			for($i = 1; $i <= $boom['state']; $i++){
				$sel = ($i == 1) ? 'pagselected' : '';
				echo '<div data-pag="' . $boom['id'] . '" data-item="' . $i . '" class="pagdot ' . $sel . ' pag_btn"></div> ';
			}
		?>
	</div>
	<?php } ?>
</div>
