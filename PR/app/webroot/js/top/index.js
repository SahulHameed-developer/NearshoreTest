$('.containerdiv').each(function() {
	var fadedivid = $(this).attr('id');
	if($(this).outerHeight() > 70) {
		$(this).addClass('fade-container');
		$('#'+fadedivid+'fadediv').removeClass('dispNone');
	}
});

$(".memberShosai").click(function () {
	$("#arno").val($(this).attr("data-arno"));
	$("#kaisyacd").val($(this).attr("data-kaisyacd"));
	$("#tantou").val($(this).attr("data-tantou"));
	$( "#memberShosaifrm" ).submit();
});

function detailscontent() {
	setTimeout(function() {
		$('.containerdiv').each(function() {
			var fadedivid = $(this).attr('id');
			if($(this).outerHeight() > 70) {
				$(this).addClass('fade-container');
				$('#'+fadedivid+'fadediv').removeClass('dispNone');
			}
		});
	}, 200);
}

// bxslider
$('.bxslider').bxSlider({
	speed: 500,
	pager: false,
	controls: false,
	auto: true,
	mode: 'fade',
	captions: true
});

// bxslider2
var w = $(window).width();
var x4 = 1100;
var x3 = 834;
var x2 = 556;
if (w >= x4) {
	var ms = 4;
} else if (w >= x3) {
	var ms = 3;
} else if (w >= x2) {
	var ms = 2;
} else {
	var ms = 1;
}
$('.bxslider2').bxSlider({
	speed: 500,
	pager: false,
	controls: false,
	auto: true,
	captions: false,
	slideWidth: 266,
	maxSlides: ms,
	minSlides: 1,
	moveSlides: 1,
	slideMargin: 12
});