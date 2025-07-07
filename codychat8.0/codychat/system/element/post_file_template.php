<?php if($boom['type'] == 'image'){ ?>
<div class="up_file">
	<div class="up_file_content">
		<div class="up_data">
			<img class="up_image" src="<?php echo BOOM_DOMAIN . $boom['file']; ?>"/>
			<div class="up_file_control">
				<div class="up_file_remove theme_btn bshadow" onclick="removeFile('<?php echo $boom['encrypt']; ?>');">
					<i class="fa fa-times"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php if($boom['type'] == 'audio'){ ?>
<div class="up_file">
	<div class="up_file_content">
		<div class="up_data">
			<img class="up_image" src="default_images/icons/audio.svg"/>
			<div class="up_file_control">
				<div class="up_file_remove theme_btn bshadow" onclick="removeFile('<?php echo $boom['encrypt']; ?>');">
					<i class="fa fa-times"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php if($boom['type'] == 'video'){ ?>
<div class="up_file">
	<div class="up_file_content">
		<div class="up_data">
			<img class="up_image" src="default_images/icons/video.svg"/>
			<div class="up_file_control">
				<div class="up_file_remove theme_btn bshadow" onclick="removeFile('<?php echo $boom['encrypt']; ?>');">
					<i class="fa fa-times"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php if($boom['type'] == 'file'){ ?>
<div class="up_file">
	<div class="up_file_content">
		<div class="up_data">
			<img class="up_image" src="default_images/icons/file.svg"/>
			<div class="up_file_control">
				<div class="up_file_remove theme_btn bshadow" onclick="removeFile('<?php echo $boom['encrypt']; ?>');">
					<i class="fa fa-times"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>