<?php
if(!defined('BOOM')){
	die();
}
?>
<?php if(boomRecaptcha()){ ?>
<div>
<?php if($setting['use_recapt'] == 1){ ?>
<script src="https://google.com/recaptcha/api.js?onload=readyCaptcha&render=explicit"></script>
<?php } ?>
<?php if($setting['use_recapt'] == 2){ ?>
<script src="https://js.hcaptcha.com/1/api.js?onload=readyCaptcha&render=explicit"></script>
<?php } ?>
<?php if($setting['use_recapt'] == 3){ ?>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=readyCaptcha"async defer></script>
<?php } ?>
</div>
<?php } ?>
<script data-cfasync="false">
	var recapt = <?php echo $setting['use_recapt']; ?>;
	var recaptKey = '<?php echo $setting['recapt_key']; ?>';
</script>