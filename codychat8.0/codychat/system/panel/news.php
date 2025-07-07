<?php
require('../config_session.php');

$content = '';
$count = 0;
$max_news = 10;

$get_news = $mysqli->query("SELECT boom_news.*, boom_users.*,
(SELECT count(id) FROM boom_news) as news_count,
(SELECT count( parent_id ) FROM boom_news_reply WHERE parent_id = boom_news.id ) as reply_count,
(SELECT like_type FROM boom_news_like WHERE uid = '{$data['user_id']}' AND like_post = boom_news.id) as liked
FROM boom_news, boom_users
WHERE boom_news.news_poster = boom_users.user_id 
ORDER BY news_date DESC LIMIT $max_news");

if($get_news->num_rows > 0){
	while ($news = $get_news->fetch_assoc()){
		$count = $news['news_count'];
		$content .= boomTemplate('element/news', $news);
	}
	$mysqli->query("UPDATE boom_users SET user_news = '" . time() . "' WHERE user_id = '{$data['user_id']}'");
	redisUpdateUser($data['user_id']);
}
else {
	$content .= emptyZone($lang['no_news']);
}

ob_start();
?>
<div class="left_keep">
	<div class="pad20">
		<?php if(canPostNews()){ ?>
		<div class="bpad15">
			<button onclick="addNews();" class="theme_btn button"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
		</div>
		<?php } ?>
		<div id="container_news">
			<?php echo $content; ?>
		</div>
		<?php if($count > $max_news){ ?>
		<div class="load_more_news centered_element">
			<button onclick="moreNews(this);" class="theme_btn small_button rounded_button load_more"><i class="fa fa-plus-circle"></i> <?php echo $lang['load_more']; ?></button>
		</div>
		<?php } ?>
	</div>
</div>
<?php
$res['content'] = ob_get_clean();
$res['title'] = $lang['system_news'];
echo boomCode(1, $res);
?>