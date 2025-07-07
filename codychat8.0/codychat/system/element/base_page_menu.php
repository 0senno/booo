<div id="page_full_content">
	<div id="page_full_global">
		<div id="page_menu" class="page_menu back_pmenu menu_page">
			<div class="page_menu_wrapper pph">
				<div class="page_menu_content">
					<?php echo $boom; ?>
				</div>
			</div>
		</div>
		<div class="page_full_indata">
			<div id="page_wrapper" class="page_wrapper_in pph">
			</div>
		</div>
	</div>
</div>
<div id="side_menu" class="bshadow hideall back_pmenu">
	<div class="page_menu_wrapper menu_page">
		<div class="side_smenu_content">
			<?php echo $boom; ?>
		</div>
	</div>
</div>
<script data-cfasync="false">
adjustPage = function(){
	var winWidth = $(window).width();
	var winHeight = $(window).height();
	var headHeight = $('#header_full').outerHeight();
	
	var ch = (winHeight - headHeight);

	$(".pph").css("height", ch);
}
$(document).ready(function() {
	adjustPage();
	$( window ).resize(function() {
		adjustPage();
	});
});
</script>