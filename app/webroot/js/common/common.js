charset="UTF-8"
var captchaCode = '';
//モーダルメニュー
$(function(){
  // 「.modal-open」をクリック
  $('.modal-open').click(function(){

    // スクロールバーの横幅を取得
    var scrollsize = $(window).width() - $('body').prop('clientWidth');

    // html、bodyを固定（overflow:hiddenにする）
    $('html, body').addClass('lock');

    // オーバーレイ用の要素を追加
    $('body').append('<div class="modal-overlay"></div>');

    // オーバーレイをフェードイン
    $('.modal-overlay').fadeIn('slow');

    // モーダルコンテンツのIDを取得
    var modal = '#' + $(this).attr('data-target');

    // モーダルコンテンツを囲む要素を追加
    $(modal).wrap("<div class='modal-wrap'></div>");

    // モーダルコンテンツを囲む要素を表示
    $('.modal-wrap').show();

    // モーダルコンテンツの表示位置を設定
    modalResize();

    // モーダルコンテンツフェードイン
    $(modal).fadeIn('slow');

    // モーダルコンテンツをクリックした時はフェードアウトしない
    $(modal).click(function(e){
    e.stopPropagation();
    });

    // 「.modal-overlay」あるいは「.modal-close」をクリック
    $('.modal-wrap, .modal-close').off().click(function(){
      // モーダルコンテンツとオーバーレイをフェードアウト
      $(modal).fadeOut('slow');
      $('.modal-overlay').fadeOut('slow',function(){
      // html、bodyの固定解除
      $('html, body').removeClass('lock');
      // オーバーレイを削除
      $('.modal-overlay').remove();
      // モーダルコンテンツを囲む要素を削除
      $(modal).unwrap("<div class='modal-wrap'></div>");
      });
    });

    // リサイズしたら表示位置を再取得
    $(window).on('resize', function(){
    modalResize();
    });

    // モーダルコンテンツの表示位置を設定する関数
    function modalResize(){
      // ウィンドウの横幅、高さを取得
      var w = $(window).width();
      var h = $(window).height();

      // モーダルコンテンツの横幅、高さを取得
      var mw = $(modal).outerWidth(true);
      var mh = $(modal).outerHeight(true);
    }
  });
  // 新しいキャプチャをリロードするために使用される「.refresh-captcha」クラス
  $('.refresh-captcha').click(function() {
    $.ajax({
      url : 'getRefreshCaptcha',
      type : 'GET',
      cache: false,
      async: false,
      success : function(response) {
        var obj = JSON.parse(response);
        captchaCode = obj.captcha_code;
        $(".captcha-image").attr("src", 'data:image/jpeg;base64,' + obj.image);
      },
      error : function(errorData){
        alert(errorData.status);
      }
    });
  });
});

$(window).load(function () {

	/* =ページ内スクロール
	 ------------------------------------------------------------------*/
	$('a[href^=#]').click(function(){
		var navHight = 100;
		var speed = 500;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top-navHight;
		$('body,html').animate({scrollTop:position}, speed, "swing");
		return false;
	});

      // scrolltop
      $(function(){
        var pageTop = $( '.pagetop img');
        pageTop.hide();
        $(window).scroll(function(){
            if($(this).scrollTop()> 50){
                pageTop.fadeIn();
            } else {
                pageTop.fadeOut();
            }
        });
      });

      /* メガメニュー ---------------------------------------------------------------- */
      if($("#wrap").hasClass("about_wrap")) { $(".parent_about").addClass("current"); }
      else if($("#wrap").hasClass("members_wrap")) { $(".parent_members").addClass("current"); }
      else if($("#wrap").hasClass("activity_wrap")) { $(".parent_activity").addClass("current"); }
      else if($("#wrap").hasClass("join_wrap")) { $(".parent_join").addClass("current"); }
      else if($("#wrap").hasClass("contact_wrap")) { $(".parent_contact").addClass("current"); }
      else if($("#wrap").hasClass("membermenu_wrap")) { $(".parent_membermenu").addClass("current"); }

      $('#mega_menu > li').hover(function(){
        $("ul:not(:animated)", this).slideDown(0);
      }, function(){
        $("ul", this).slideUp(0);
      });

      /* スマホメニュー ---------------------------------------------------------------- */
      /*
      $('#sp_menu a').click(function() {
        $('.sp_header_inner nav').slideToggle(300);
      });
      */
      var toggleNav = $('.sp_header_inner nav a.nlt');
      $(toggleNav).next('ul').css('display','none');
      $(toggleNav).click(function() {
        if($(this).next('ul').css('display') =='none'){
          $(this).addClass('active')
          $(this).next().slideDown(300);
        } else {
          $(this).removeClass('active')
          $(this).next().slideUp(300);
        };
        var self = $(this);
        $(toggleNav).not(self).removeClass('active')
        $(toggleNav).not(self).next().slideUp(300);
      });

      $('.sp_close_btn_area .btn').click(function() {
        $(toggleNav).removeClass('active')
        $(toggleNav).next().slideUp(300);
      });

      /* Tel無効（PCのみ） ---------------------------------------------------------------- */
      $(function(){
          var ua = navigator.userAgent;
          if(ua.indexOf('iPhone') < 0 && ua.indexOf('Android') < 0){
              $('.contact_block .tel a span').each(function(){
                  $(this).unwrap();
              });
          }
      });
});
