<?php if(canViewWallet($boom)){ ?>
<div onclick="getWallet(<?php echo $boom['user_id']; ?>);" class="btable blisting proitem">
	<div class="bcell_mid"><i class="fa fa-wallet  proicon"></i><?php echo $lang['wallet']; ?></div>
</div>
<?php } ?>
<?php if(canUserHistory($boom)){ ?>
<div onclick="getHistory(<?php echo $boom['user_id']; ?>);" class="btable blisting proitem">
	<div class="bcell_mid"><i class="fa fa-hourglass  proicon"></i><?php echo $lang['history']; ?></div>
</div>
<?php } ?>
<?php if(canNote($boom)){ ?>
<div onclick="getNote(<?php echo $boom['user_id']; ?>);" class="btable blisting proitem">
	<div class="bcell_mid"><i class="fa fa-file-text  proicon"></i><?php echo $lang['note']; ?></div>
</div>
<?php } ?>
<?php if(canLookup($boom)){ ?>
<div onclick="getWhois(<?php echo $boom['user_id']; ?>);" class="btable blisting proitem">
	<div class="bcell_mid"><i class="fa fa-globe  proicon"></i><?php echo $lang['whois']; ?></div>
</div>
<?php } ?>
