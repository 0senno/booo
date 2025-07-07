<div id="mgift<?php echo $boom['id']; ?>" class="fborder view_gift bhover pgcard" data-gift="<?php echo $boom['id']; ?>" data-img="<?php echo giftImage($boom['gift_image']); ?>" data-title="<?php echo $boom['gift_title']; ?>">
	<img class="lazy pgcard_img" data-src="<?php echo giftImage($boom['gift_image']); ?>" src="<?php echo imgLoader(); ?>"/>
	<div class="btable_auto gtag pgcard_count">
		<div class="bcell_mid text_small">
			<div class="btable_auto">
				<div class="bcell_mid hpad3 bold">
					<?php echo $boom['gift_count']; ?>
				</div>
			</div>
		</div>
	</div>
</div>