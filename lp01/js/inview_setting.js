    
	
	    $(window).scroll(function() {
        var windowH = $(window).height();
        var scrollY = $(window).scrollTop();
        var footerLeadPosition = $('.section_strength').offset().top;
        var btnPosition = $('.section_contact').offset().top;

        if (scrollY > footerLeadPosition - windowH + 150 && scrollY < btnPosition - windowH) {
           $('.contact_btn_fixed').fadeIn(500);
        } else {
            $('.contact_btn_fixed').fadeOut(500);
        }

    });



	$('.section_strength').on('inview', function(event, visible, tbb) {
        if (tbb == 'all') {
            $('.nv1').addClass('current');
			$('nav li:not(.nv1)').removeClass('current');
        } else {
            $('.nv1').removeClass('current');
		}
    });
	
	
	$('.section_works').on('inview', function(event, visible, tbb) {
        if (tbb == 'all') {
            $('.nv2').addClass('current');
			$('nav li:not(.nv2)').removeClass('current');
        } else {
            $('.nv2').removeClass('current');
		}
    });

	$('.section_flow').on('inview', function(event, visible, tbb) {
        if (tbb == 'all') {
            $('.nv3').addClass('current');
			$('nav li:not(.nv3)').removeClass('current');
        } else {
            $('.nv3').removeClass('current');
		}
    });

	$('.section_members').on('inview', function(event, visible, tbb) {
        if (tbb == 'all') {
            $('.nv4').addClass('current');
			$('nav li:not(.nv4)').removeClass('current');
        } else {
            $('.nv4').removeClass('current');
		}
    });
	
	$('.section_faq').on('inview', function(event, visible, tbb) {
        if (tbb == 'all') {
            $('.nv5').addClass('current');
			$('nav li:not(.nv5)').removeClass('current');
        } else {
            $('.nv5').removeClass('current');
		}
    });
	
