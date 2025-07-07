<script>
systemRankIcon = function(v){
	var s = <?php echo jsonRankIcon(); ?>;
	if(v in s){
		return 'default_images/rank/'+s[v];
	}
}
systemRankTitle = function(v){
	var s = <?php echo jsonRankTitle(); ?>;
	if(v in s){
		return s[v];
	}
}
roomRankIcon = function(v){
	var s = <?php echo jsonRoomRankIcon(); ?>;
	if(v in s){
		return 'default_images/rank/'+s[v];
	}
}
roomRankTitle = function(v){
	var s = <?php echo jsonRoomRankTitle(); ?>;
	if(v in s){
		return s[v];
	}
}
statusIcon= function(v){
	var s = <?php echo jsonStatusIcon(); ?>;
	if(v in s){
		return 'default_images/status/'+s[v];
	}
}
statusTitle = function(v){
	var s = <?php echo jsonStatusTitle(); ?>;
	if(v in s){
		return s[v];
	}
}
genderTitle = function(v){
	var s = <?php echo jsonGenderTitle(); ?>;
	if(v in s){
		return s[v];
	}
}
renderAge = function(v){
	return v+" <?php echo $lang['years']; ?>";
}
muteIcon = function(){
	return 'default_images/actions/muted.svg';
}
ghostIcon = function(){
	return 'default_images/actions/ghost.svg';
}
imgLoader = () => {
	return 'default_images/misc/holder.png';
}
</script>