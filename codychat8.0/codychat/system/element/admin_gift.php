<div id="agift<?php echo $boom['id']; ?>" class="sub_list_item blisting">
	<div class="sub_list_gift">
		<img id="gift<?php echo $boom['id']; ?>" class="lazy gift_listing brad5" data-src="<?php echo giftImage($boom['gift_image']); ?>" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="sub_list_text hpad15">
		<p class="bold bellips"><?php echo $boom['gift_title']; ?></p>
		<p class="text_small bellips"><?php echo featureCost($boom['gift_cost'], $boom['gift_method']); ?></p>
		<p class="text_small bellips sub_text"><?php echo str_replace('%data%', rankTitle($boom['gift_rank']), $lang['gift_rank']); ?></p>
	</div>
	<div class="sub_list_option" onclick="editGift(<?php echo $boom['id']; ?>);">
		<i class="fa fa-edit edit_btn"></i>
	</div>
</div>