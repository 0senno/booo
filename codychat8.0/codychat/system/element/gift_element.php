<div class="fborder bhover gcard select_gift" data-img="<?php echo giftImage($boom['gift_image']); ?>" data-title="<?php echo $boom['gift_title']; ?>" data-method="<?php echo $boom['gift_method']; ?>" data-price="<?php echo $boom['gift_cost']; ?>" data-id="<?php echo $boom['id']; ?>">
	<img class="lazy gcard_img" data-src="<?php echo giftImage($boom['gift_image']); ?>" src="<?php echo imgLoader(); ?>"/>
	<div class="btable_auto gcard_price gtag">
		<div class="bcell_mid text_small">
			<div class="btable_auto">
				<div class="bcell_mid gcard_pwrap">
					<?php if($boom['gift_method'] == 1){ ?>
					<img src="<?php echo goldIcon(); ?>"/>
					<?php } ?>
					<?php if($boom['gift_method'] == 2){ ?>
					<img src="<?php echo rubyIcon(); ?>"/>
					<?php } ?>
				</div>
				<div class="bcell_mid hpad3 bold">
					<?php echo $boom['gift_cost']; ?>
				</div>
			</div>
		</div>
	</div>
</div>