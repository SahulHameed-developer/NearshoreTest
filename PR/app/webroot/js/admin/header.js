$(document).ready(function() {
	var valid_paths = ['AdminProductsite'];
	for (i=0;i<valid_paths.length;i++) {
		if (valid_paths[i] == location.pathname.split("/").pop() ) {
			if($('#scroll_val').val() > 0 && $('#scroll_val').val() != "" ) {
				$('body,html').animate({scrollTop: $('#scroll_val').val() }, 0, "swing");
			}
		}
	}
});
$(window).load(function () {
	// scrolltop
	$('.gototop').click(function(){
		var speed = 500;
		$('body,html').animate({scrollTop:0}, speed, "swing");
		return false;
	});
	// scrollBottom
	$('.gotobottom').click(function(){
		var speed = 500;
		var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
		if(scrollBottom != '0') {
			$('body,html').animate({scrollTop: $(document).height() }, speed, "swing");
		}
		return false;
	});
	$(function(){
		var pageTop = $( '.pagetop img');
		var pagebottom = $( '.pagebottom img');
		var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
		if(scrollBottom == '0') {
			pagebottom.hide();
		} else {
			pagebottom.show();
		}
		pageTop.hide();
		$(window).scroll(function() {
			if($(this).scrollTop() > 50) {
				pageTop.fadeIn();
			} else {
				pageTop.fadeOut();
			}
			if($(window).scrollTop() + $(window).height() > $(document).height() - 50) {
				pagebottom.fadeOut();
			} else {
				pagebottom.fadeIn();
			}
		});
	});
	$(document).click(function() {
		var valid_paths = ['AdminProductsite'];
		for (i=0;i<valid_paths.length;i++) {
		    if (valid_paths[i] == location.pathname.split("/").pop() ) {
				$.ajax({
					url    : '../Common/scrollsession',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'scroll_val': $(this).scrollTop() },
					async: false
				});
		    }
		}
	});
});