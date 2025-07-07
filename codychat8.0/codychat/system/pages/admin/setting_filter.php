<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow($setting['can_mfilter'])){
	die();
}
?>
<?php echo elementTitle($lang['manage_filter']); ?>
<div class="page_full">
	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="filter_tab" data-z="word_filter"><?php echo $lang['word_filter']; ?></li>
				<li class="tab_menu_item" data="filter_tab" data-z="spam_filter"><?php echo $lang['spam_filter']; ?></li>
				<li class="tab_menu_item" data="filter_tab" data-z="username_filter"><?php echo $lang['name_filter']; ?></li>
				<li class="tab_menu_item" data="filter_tab" data-z="email_filter"><?php echo $lang['mail_filter']; ?></li>
			</ul>
		</div>
	</div>
	<div id="filter_tab">
		<div id="word_filter" class="tab_zone">
			<div class="page_element">
				<div class="setting_element ">
					<p class="label"><?php echo $lang['add_word']; ?></p>
					<input id="word_add" class="full_input"/>
				</div>
				<div class="tpad5">
					<button id="add_word" onclick="addWord('word', 'badword_list', 'word_add');" type="button" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
					<?php if(boomAllow(100)){ ?>
					<button onclick="openWordAction();" type="button" class="reg_button default_btn"><?php echo $lang['set_action']; ?></button>
					<?php } ?>
				</div>
			</div>
			<div class="page_element">
				<div id="badword_list">
					<?php echo listFilter('word'); ?>
				</div>
			</div>
		</div>
		<div id="spam_filter" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="setting_element ">
					<p class="label"><?php echo $lang['add_word']; ?></p>
					<input id="spam_add" class="full_input"/>
				</div>
				<div class="tpad5">
					<button id="add_spam" onclick="addWord('spam', 'spam_list', 'spam_add');" type="button" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
					<?php if(boomAllow(100)){ ?>
					<button onclick="openSpamAction();" type="button" class="reg_button default_btn"><?php echo $lang['set_action']; ?></button>
					<?php } ?>
				</div>
			</div>
			<div class="page_element">
				<div id="spam_list">
					<?php echo listFilter('spam'); ?>
				</div>
			</div>
		</div>
		<div id="username_filter" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['add_word']; ?></p>
						<input id="username_add" class="full_input"/>
					</div>
				</div>
				<div class="form_control">
					<button id="add_username_filter" onclick="addWord('username', 'name_list', 'username_add');" type="button" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
				</div>
			</div>
			<div class="page_element">
				<div id="name_list">
					<?php echo listFilter('username'); ?>
				</div>
			</div>
		</div>
		<div id="email_filter" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="form_content">
					<?php if(boomAllow(100)){ ?>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['email_filter']; ?>  <?php echo createInfo('email_filter'); ?></p>
						<select id="set_email_filter" onchange="setEmailFilter();">
							<?php echo yesNo($setting['email_filter']); ?>
						</select>
					</div>
					<?php } ?>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['add_word']; ?></p>
						<input id="email_add" class="full_input"/>
					</div>
				</div>
				<div class="form_control">
					<button id="add_email_filter" onclick="addWord('email', 'email_list', 'email_add');" type="button" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
				</div>
			</div>
			<div class="page_element">
				<div id="email_list">
					<?php echo listFilter('email'); ?>
				</div>
			</div>
		</div>
	</div>
</div>