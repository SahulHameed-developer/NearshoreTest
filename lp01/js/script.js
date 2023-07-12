$(function() {
	
	
	const switchPoint = 960;

    function navClose() {
        if (window.innerWidth > switchPoint) {
            $('.mobile_drawer').fadeOut(300);
            $('.header_trigger').removeClass('open').addClass('close');
        }
    }
    $(window).resize(function() { navClose(); });
    navClose();


    $('.header_trigger').on('click', function() {
        if ($(this).hasClass('close')) {
            $('.mobile_drawer').fadeIn(400);
            $('.header_trigger').removeClass('close').addClass('open');
            return false();
        } else {
            $('.mobile_drawer').fadeOut(300);
            $('.header_trigger').removeClass('open').addClass('close');
            $('.mobile_drawer li ul').slideUp(0);
            $('.mobile_drawer li.parent > a').removeClass('open');
        }
    });

    $('.closelink, .drawer_header .header_logo a,.mobile_drawer li a').on('click', function() {
        $('.mobile_drawer').fadeOut(300);
        $('.header_trigger').removeClass('open').addClass('close');
        $('.mobile_drawer li ul').slideUp(0);
        $('.mobile_drawer li.parent > a').removeClass('open');
    });
	
    function heroHeight() {
        var heroHeight = $(window).height() * 0.7;
        $('.hero').css({
            // 'height': heroHeight + 'px',
        });
    }
    $(window).resize(function() { heroHeight(); });
    heroHeight();
	
    function drawerHeight() {
        var drawerHeight = $(window).height() - 60;
        $('.drawer_inner').css({
            'height': drawerHeight + 'px',
        });
    }
    $(window).resize(function() { drawerHeight(); });
    drawerHeight();
	
	
	
	// screen size
    function screenSize() {
        var winH = $(window).innerHeight();
        var winW = $(window).innerWidth();
        if (winH < 715) {
            $('body').addClass('narrowScreen');
        } else {
            $('body').removeClass('narrowScreen');
        }
    }
    $(window).resize(function() { screenSize(); });
    screenSize();
	
	
	// STRENGTH
	
	$('.about_front').heightLine();
	
	$('.strength_col div').heightLine();

	$('.area_flex div div').heightLine({
       //  minWidth: 767
    });
	
	
	$('.ul_list_flex').heightLine({
        minWidth: 767
	});
	
	$('.flow_col_caption').heightLine({
		minWidth: 767
	});


	$('.member_nav a[href^="#"]').click(function(){
    var href= $(this).attr('href');
    var target = $(href == '#' || href == '' ? 'html' : href);
    var position = target.offset().top - 100;
    $('html, body').animate({scrollTop:position}, 400, 'swing');
    return false;
  });
	
	
	    $('.faq_Q').on('click', function() {
        $(this).toggleClass('open');
        $(this).next('.faq_A').slideToggle(200);
        // $('.faq_Q').removeClass('open');
        // $(this).addClass('open');
        // $('.faq_A').slideUp(200);
        // $('+div',this).slideDown(200);
    });
	
	
	$('nav li a[href^="#"]').click(function(){
    var href= $(this).attr('href');
    var target = $(href == '#' || href == '' ? 'html' : href);
    var position = target.offset().top;
    $('html, body').animate({scrollTop:position}, 400, 'swing');
    return false;
  });
  
  
	
	// PAGETOP
	$('.pagetop').click(function () {
	$('body,html').animate({
	scrollTop: 0
	}, 500);
	return false;
	});
	
	
	
	var $setElement = $('.switch');
    replaceWidth = 768;
 
    $setElement.each(function(){
        var $this = $(this);
        function imgSwitch(){
            if(window.innerWidth > replaceWidth) {
                $this.attr('src',$this.attr('src').replace('_sp','_pc')).css({visibility:'visible'});
            } else {
                $this.attr('src',$this.attr('src').replace('_pc','_sp')).css({visibility:'visible'});
            }
        }
        $(window).resize(function(){imgSwitch();});
        imgSwitch();
    });
	
	
	
});