<div data="<?php echo $boom['data']; ?>" data-icon="<?php echo $boom['icon']; ?>" data-text="<?php echo $boom['text']; ?>" class="boom_opt blisting <?php echo $boom['class']; ?>">
	<div class="btable">
		<?php if($boom['icon'] != ''){ ?>
		<div class="boom_opt_icon">
			<img src="<?php echo $boom['icon']; ?>"/>
		</div>
		<?php } ?>
		<div class="boom_opt_text">
			<?php echo $boom['text']; ?>
		</div>
	</div>
</div>