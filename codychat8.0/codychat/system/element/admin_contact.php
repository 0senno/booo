<div class="contact_item sub_list_item members_item blisting" id="contact<?php echo $boom['id']; ?>">
	<div class="sub_list_img" onclick="openContact(<?php echo $boom['id']; ?>);">
		<img class="brad50" src="default_images/icons/contact.svg"/>
	</div>
	<div class="sub_list_content hpad10" onclick="openContact(<?php echo $boom['id']; ?>);">
		<p class="text_small bold"><?php echo $boom['cemail']; ?></p>
		<p class="text_small sub_text"><?php echo boomTimeAgo($boom['cdate']); ?></p>
	</div>
	<?php if($boom['cview'] == 0){ ?>
	<div id="unread_contact<?php echo $boom['id']; ?>" class="sub_list_option">
		<i class="fa fa-circle error"></i>
	</div>
	<?php } ?>
	<div onclick="deleteContact(<?php echo $boom['id']; ?>);" class="sub_list_option">
		<i class="fa fa-trash-can edit_btn"></i>
	</div>
</div>