$(function() {
	$(".faq_list .dd").hide();
	$(".faq_list .dl:first-child .dd").show();
	$(".faq_list dt").on("click", function() {
		$(this).next().slideToggle(0);
	});
});