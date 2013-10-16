/*!
 * SLIDE DOWN
 */

$(function() {
	$(".icoLink a").click(function() {
		if($(this).siblings("ul").is(":hidden")) {
			$(this).siblings("ul").slideDown("fast");
			$(this).addClass("on");
		}else {
			$(this).siblings("ul").slideUp("fast");
			$(this).removeClass("on");
		}
	});
});