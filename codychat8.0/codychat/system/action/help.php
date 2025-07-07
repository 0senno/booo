<?php
require('../config_session.php');

$ilang['index_path'] = "The index path must be an absolute path of your chat location and must not end with a /.";
$ilang['redis_cache'] = "Redis is a server-side in-memory database that can improve server load on higher chat traffic. To use Redis, you'll need to install the Redis server and PHP Redis extension. Redis is optional.";
$ilang['captcha'] = "Improve your protection from automated bot actions by adding a captcha verification to crucial system parts such as registration and guest login.";
$ilang['proxycheck'] = "Limit access to your site by blocking VPNs from entering your chat. This option requires an API key.";
$ilang['flood'] = "This setting is used to limit the number of messages a single user can send to the system in a 10-second interval before the system sees it as a flood attempt.";
$ilang['rate_limit'] = "When activated, this option monitors how many requests are sent by a single user in a 20-second interval. Once that limit is reached, the system will completely ignore future requests sent by the user for 5 minutes.";
$ilang['guest_form'] = 'Guest extended form will require Guest visitor to provide their age and gender instead of only asking for a desired username.';
$ilang['bridge'] = 'This option can be activated when using the chat inside a CMS such as Wordpress, Wowonder, or other available CMS bridges. This option will convert the current login page to allow users logged in the CMS to access the chat without the need of filling out a registration form.';
$ilang['email_filter'] = 'The email filter is a restrictive filter. It only allows email addresses specified in the filter to register in the system. When activated, this feature improves security by not allowing temporary emails that are not listed to enter the system.';
$ilang['gift'] = 'The gift system allows users to buy and send gifts to other members using gold or ruby. This system requires the wallet system to be activated.';
$ilang['video_call'] = 'Before using call feature make sure you fill api credential for the selected provider in the api tab.';
$ilang['coppa'] = 'By activating COPPA compliance, you ensure that visitors under the age of 13 are restricted from entering the site or registering, in accordance with the Children\'s Online Privacy Protection Act (COPPA).';
$ilang['level_mode'] = 'The coefficient are the difficulty of each level. The higher the coefficient is higher is the xp required to complete each levels.';
$ilang['agora'] = 'The video and audio call system uses an external resource and requires an API key to be activated. You can easily create your API key by following the link below.';
$ilang['livekit'] = 'The video and audio call system uses an external resource and requires an API key to be activated. You can easily create your API key by following the link below.';
$ilang['openai'] = 'The AI moderation system require the use of an external resource and require an API key to be activated. You can easely create your API key by following the link below.';

if(!isset($_POST['info'])){
	die();
}
$info = $_POST['info'];

function renderInfoLink($text, $url){
	return '<a target="_BLANK" class="theme_color bblock bmargin5" href="' . $url . '">' . $text . '</a>';
}

function renderInfo($text) {
    $text = str_ireplace('%s%', '<span class="theme_color">', $text);
    $text = str_ireplace('%ss%', '</span>', $text);
    return $text;
}

function helpExtra($type){
	switch($type){
		case 'captcha':
			return '
				<p class="bold bpad5">Google recaptcha</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://google.com/recaptcha/about/">https://google.com/recaptcha/about/</a>
				<p class="bold bpad5">Cloudflare turnstile</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://cloudflare.com/products/turnstile/">https://cloudflare.com/products/turnstile/</a>
				<p class="bold bpad5">Hcaptcha</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://hcaptcha.com/">https://hcaptcha.com/</a>
			';
		case 'proxycheck':
			return '
				<p class="bold bpad5">Proxycheck</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://proxycheck.io/">https://proxycheck.io/</a>
			';
		case 'agora':
			return '
				<p class="bold bpad5">Agora</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://agora.io">https://agora.io</a>
			';
		case 'openai':
			return '
				<p class="bold bpad5">Openai</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://openai.com/chatgpt/pricing">https://openai.com/chatgpt/pricing</a>
			';
		case 'livekit':
			return '
				<p class="bold bpad5">Livekit</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://livekit.io">https://livekit.io</a>
			';
		case 'index_path':
			return '
				<p class="bold bpad5">Example</p>
				<p class="theme_color bmargin10" href="#">https://yoururl.com/chat</p>
			';
		case 'coppa':
			return '
				<p class="bold bpad5">Learn more</p>
				<a target="_BLANK" class="theme_color bblock bmargin10" href="https://ftc.gov/legal-library/browse/rules/childrens-online-privacy-protection-rule-coppa">https://ftc.gov/legal-library/browse/rules/childrens-online-privacy-protection-rule-coppa</a>
			';
		default:
			return '';
	}
}

function createHelp($type){
	global $ilang;
	$text = renderInfo($ilang[$type]);
	$add = helpExtra($type);
	if(!empty($add)){
		$add = '<div class="tmargin10">
					' . $add . '
				</div>';
	}
	return '
		<div class="info_container pad10">
			<div class="info_content">
				<p>' . $text . '<p>
				' . $add . '
			</div>
		</div>
	';
}

if(isset($ilang[$info])){
	echo createHelp($info);
}
?>