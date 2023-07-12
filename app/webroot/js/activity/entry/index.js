$(function() {
	$('input').keydown(function(event) {
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	// 初期表示で確認画面ボタンを無効する処理。
	$('#submit').attr('disabled', 'disabled');
	// 初期表示で会員区分「会員 」を選択する。
	$("#kaiin").attr('checked', 'checked');
	// 初期表示で会員メールアドレスを表示する。
	$('#kainMail').show();
	// 初期表示でメールアドレスを表示しない。
	$('#mailAddr').hide();
	// 初期表示で確認用メールアドレスを表示しない。
	$('#confirmMail').hide();
	// 初期表示で個人情報の取扱についてを表示しない。
	$('#kojinInfo').hide();
	// 会社名で必須クラスを排除する。
	$('#kaisyaName').removeClass('required_form');
	// 氏名で必須クラスを排除する。
	$('#kaiinName').removeClass('required_form');
	$('.underscoresingle').bind('keydown keyup', function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if(charCode == 226) {
			this.value = this.value.replace("__", "_");
		}
	});
	$(".doublebyte").focusout(function(evt) {
		var id = this.id;
		$.ajax({
			url    : '../Common/doublebyte',
			type   : 'POST',
			datatype : 'JSON',
			data   : {'val': this.value},
			async: false,
			success : function(data) {
				$("#"+id).val(data);
			},
			error : function(errorData) {
				alert(errorData.status);
			}
		});
	});
	// 戻るの場合　同意チェックを選択して確認画面ボタンを有効する処理。
	if($("#kaigiEventButtonSel").val()=='modoru') {
		// 会員区分「会員 」の場合
		if($("#kaigiEventKaiinKbn").val()=='0') {
			// 会員区分「会員 」を選択する。
			$("#kaiin").attr('checked', 'checked');
			// 会員メールアドレスを表示する。
			$('#kainMail').show();
			// メールアドレスを表示しない。
			$('#mailAddr').hide();
			// 確認用メールアドレスを表示しない。
			$('#confirmMail').hide();
			// 個人情報の取扱についてを表示しない。
			$('#kojinInfo').hide();
			// 会社名で必須クラスを排除する。
			$('#kaisyaName').removeClass('required_form');
			// 氏名で必須クラスを排除する。
			$('#kaiinName').removeClass('required_form');
			// 会社名が表示のみの処理
			$('#kaisyanm').attr('readonly', true);
			// 氏名が表示のみの処理
			$('#kaiinnm').attr('readonly', true);
			// 同意チェックをチェックしない。
			$("#check").prop("checked", false)
		} else {
			// 会員区分「非会員 」を選択する。
			$("#hikaiin").attr('checked', 'checked');
			// 会員メールアドレスを表示しない。
			$('#kainMail').hide();
			// メールアドレスを表示する。
			$('#mailAddr').show();
			// 確認用メールアドレスを表示する。
			$('#confirmMail').show();
			// 個人情報の取扱についてを表示する。
			$('#kojinInfo').show();
			// 会社名で必須クラスを追加する。
			$('#kaisyaName').addClass('required_form');
			// 氏名で必須クラスを追加する。
			$('#kaiinName').addClass('required_form');
			// 会社名が表示のみを排除する。
			$("#kaisyanm").css("display", "block");
			// 氏名が表示のみを排除する。
			$("#kaiinnm").css("display", "block");
			// 会社名が表示のみの処理
			$('#kaisyanm').attr('readonly', false);
			// 氏名が表示のみの処理
			$('#kaiinnm').attr('readonly', false);
			$('#kaisyanmlb').html('');
			$('#kaiinnmlb').html('');
			// 同意チェックをチェックする。
			$("#check").prop("checked", true)
		}
	}
	// 確認画面ボタンを有効する処理。
	if($("#kaigiEventConfirmBut").val()=='enable') {
		$('#submit').removeAttr('disabled');
	}
	// 同意チェックをクリックするの場合
	$('#check').click(function() {
		// 同意チェックをチェックしない場合は、
		if ($(this).prop('checked') == false) {
			// 確認画面を無効
			$('#submit').attr('disabled', 'disabled');
		} else {
			// 確認画面を有効
			$('#submit').removeAttr('disabled');
		}
	});
	// 会員メールアドレスの検索ボタンをクリックするの場合。
	$('#kaiinMailbtn').click(function() {
		if($('#mailaddr').valid()) {
			$( ".kaiinMailbtnerr" ).html("");
			// 会社名で入力必須するチェックを排除する。
			$( "#kaisyanm" ).rules( "remove", "required" );
			// 氏名で入力必須するチェックを排除する。
			$( "#kaiinnm" ).rules( "remove", "required" );
			//氏名で全角スペースがあるチェックを排除する。
			$( "#kaiinnm" ).rules( "remove", "withTwoStrings" );
			// エラーメッセージを削除。
			$( "#flashMessage" ).empty();
			// データ取得。
			sendAjaxRequest();
		}
	});
	// メールアドレスのテキストボックス押すの場合
	$('#kaigiEventConfirmForm input#mailaddr').on('change', function () {
		// 会社名で入力必須するチェックを排除する。
		$( "#kaisyanm" ).rules( "remove", "required" );
		// 氏名で入力必須するチェックを排除する。
		$( "#kaiinnm" ).rules( "remove", "required" );
		//　氏名で全角スペースがあるチェックを排除する。
		$( "#kaiinnm" ).rules( "remove", "withTwoStrings" );
		//　フォームエラーの場合は、
		if (!$('#kaigiEventConfirmForm').valid()) {
			// 確認画面ボタンを無効
			$('#submit').attr('disabled', 'disabled');
		} 
		$('#submit').attr('disabled', 'disabled');
		// 会社名値は空白にセットする。
		$("#kaisyanm").val('');
		$("#error_label").html("");
		// 氏名値は空白にセットする。
		$("#kaiinnm").val('');
		// 会社名値は空白にセットする。
		$('#kaisyanmlb').html('');
		// 氏名値は空白にセットする。
		$('#kaiinnmlb').html('');
	});
	// エラーメッセージあった場合は
	if ($('#flashMessage').length==0) {
		// メールアドレスでエラークラスを排除する。
		$('#mailaddr').removeClass('error');
	} else {
		// メールアドレスでエラークラスを追加する。
		$('#mailaddr').addClass('error');
	}
	// 会員区分を変わるの場合は、確認メッセージを表示する処理。
	$('input[type=radio][name=free_radio]').change(function() {
		var selectedVal=this.value;
		$.confirm({
			title: '',
			content: '入力内容がクリアされますが、よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$(".db_error").each(function() {
						    $(".db_error").html("");
						});
						// 会員区分「会員 」の場合
						if (selectedVal == '会員') {
							$('#kaiincd').val("");
							$('#kaiinkbnmem').val(0); // 会員
							// 会員メールアドレスを表示する
							$('#kainMail').show();
							// メールアドレスを表示しない。
							$('#mailAddr').hide();
							// 確認用メールアドレスを表示しない。
							$('#confirmMail').hide();
							// 個人情報の取扱についてを表示しない。
							$('#kojinInfo').hide();
							// 会社名で必須クラスを排除する。
							$('#kaisyaName').removeClass('required_form');
							// 氏名で必須クラスを排除する。
							$('#kaiinName').removeClass('required_form');
							// 会社名が表示のみの処理
							$("#kaisyanm").css("display", "none");
							// 氏名が表示のみの処理
							$("#kaiinnm").css("display", "none");
							// 確認画面を無効
							$('#submit').attr('disabled', 'disabled');
							// 同意チェックをチェックしない
							$("#check").prop("checked", false)
						// 会員区分「非会員 」の場合
						} else {
							$('#kaiincd').val("");
							$('#kaiinkbnmem').val(1); //　非会員
							// 会員メールアドレスを表示しない。
							$('#kainMail').hide();
							// メールアドレスを表示する。
							$('#mailAddr').show();
							// 確認用メールアドレスを表示する。
							$('#confirmMail').show();
							// 個人情報の取扱についてを表示する。
							$('#kojinInfo').show();
							// 会社名で必須クラスを追加する。
							$('#kaisyaName').addClass('required_form');
							// 氏名で必須クラスを追加する。
							$('#kaiinName').addClass('required_form');
							// 会社名が表示のみを排除する。
							$("#kaisyanm").css("display", "block");
							// 氏名が表示のみを排除する。
							$("#kaiinnm").css("display", "block");
							// 会社名が表示のみを排除する。
							$('#kaisyanm').attr('readonly', false);
							// 氏名が表示のみの処理
							$('#kaiinnm').attr('readonly', false);
							$('#kaisyanmlb').html('');
							$('#kaiinnmlb').html('');
							// 確認画面を無効
							$('#submit').attr('disabled', 'disabled');
						}
						// 会員メールアドレス値は空白にセットする。
						$("#mailaddr").val('');
						// メールアドレス値は空白にセットする。
						$("#emailAddr").val('');
						// 確認用メールアドレス値は空白にセットする。
						$("#confirmEmail").val('');
						// 会社名値は空白にセットする。
						$("#kaisyanm").val('');
						// 氏名値は空白にセットする。
						$("#kaiinnm").val('');
						// 備考値は空白にセットする。
						$("#bikou").val('');
						// エラーメッセージを表示しない。
						$("label.error").hide();
						// エラーメッセージクラスを排除する。
						$("#captchaCode").parent().parent().next("label").html('');
						$(".error").removeClass("error");
					}
				},
				キャンセル: function () {
					// 会員区分「会員 」の場合
					if (selectedVal == '会員') {
						//会員区分「非会員 」を選択する。
						$("#hikaiin").attr('checked', 'checked');
					// 会員区分「非会員 」の場合
					} else {
						//会員区分「会員 」を選択する。
						$("#kaiin").attr('checked', 'checked');
					}
				}
			}
		});
	});
	function sendAjaxRequest() {
		$.ajax({
		    url    : 'byAjaxCheck',
		    type   : 'POST',
		    datatype : 'JSON',
		    data   : {'mailaddr': $("#mailaddr").val()},
		    async: false,
		    success : function(data) {
		    	data = JSON.parse(data);
		    	if(data.length == 0) {
		    		$("#error_label").html("該当する会員メールアドレスが存在しません。");
		    	} else {
		    		$('#kaisyanm').val(data[0]);
		    		$('#kaisyanmHid').val(data[0]);
		    		$('#kaisyanmlb').html(data[0]);
		    		
		    		$('#kaiinnmHid').val(data[1]);
		    		$('#kaiinnm').val(data[1]);
		    		$('#kaiinnmlb').html(data[1]);

		    		$('#kaiincd').val(data[2]);
		    		
		    		$('#submit').prop('disabled', false);
		    	}
		    },
		    error : function(errorData) {
		   		alert(errorData.status);
		    }
		});
	}
	// 全角スペースがあるチェックの機能を追加。
	jQuery.validator.addMethod(
			"withTwoStrings",
			function(value, element) {
				howManyWords = value.trim();
				howManyWords = howManyWords.replace(/\s{2,}/g, '　'); //remove extra spaces
				howManyWords = howManyWords.split('　');
					if(howManyWords.length == 2) {
						return true;
					} else {
						return false;
					}
					e.preventDefault();
			});
	// 英数、ハイフン(-)、アンダーバー(_)、ピリオド(.)、@の文字チェックの機能を追加
	jQuery.validator.addMethod(
			"specialChar", 
			function(value, element) {
				return this.optional(element) || value.match(/^[a-zA-Z0-9-_.@]*$/);
			});
	jQuery.validator.addMethod(
		"mailvalidation",
		function(value, element) {
			return this.optional(element) || value.match(/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/);
		});
	jQuery.validator.addMethod(
		"restrictEmail",
		function(value, element) {
			return this.optional(element) || (value != RESTRICT_MAIL_ADDR);
		});
	jQuery.validator.addMethod(
		"checkCaptcha",
		function(value, element) {
			return this.optional(element) || (value == captchaCode);
		});

	// 会議・イベント申込フォーム確認
	$("#kaigiEventConfirmForm").validate({
		// onfocusout: false,
		errorPlacement: function(error, element) {
			if(element.attr("name") == "mailaddr") {
				$(".error_mail").html("");
				error.appendTo('.error_mail');
			} else if (element.attr("id") == "captchaCode") {
				element.parent().parent().next("label").html('');
				error.insertAfter(element.parent().parent().next("label"));
			} else {
				error.insertAfter(element.parent("div"));
			}
		},
		onkeyup: false,
		rules: {
			// 会員メールアドレス
			mailaddr: {
				required:true,
				email:true,
				specialChar:true,
				mailvalidation:true,
				restrictEmail:true
			},
			// 会社名
			kaisyanm: "required",
			// 氏名
			kaiinnm: {
				required:true,
				withTwoStrings: true,
			},
			// メールアドレス
			emailAddr:{
				required:true,
				email:true,
				specialChar:true,
				mailvalidation:true,
				restrictEmail:true
			},
			// 確認用メールアドレス
			confirmEmail:{
				required:true,
				email:true,
				specialChar:true,
				mailvalidation:true,
				equalTo: '[name="emailAddr"]',
				restrictEmail:true
			},
			captchaCode: {
				required : true,
				checkCaptcha : true
			}
		},
		messages: {
			// 会員メールアドレスのエラーメッセージ。
			mailaddr:{ 
				required:"会員メールアドレスが未入力です。",
				email: "メールアドレスの形式が不正です。",
				specialChar:"メールアドレスに使用できない文字が含まれています。",
				mailvalidation:"メールアドレスの形式が不正です。",
				restrictEmail:"このメールアドレスは制限されています。"
			},
			// 会社名のエラーメッセージ。
			kaisyanm: "会社名が未入力です。",
			// 氏名のエラーメッセージ。
			kaiinnm: {
				required:"氏名が未入力です。",
				withTwoStrings:"姓と名の間に全角スペースを入力してください。"
			},
			// メールアドレスのエラーメッセージ。
			emailAddr:{
				required:"メールアドレスが未入力です。",
				email: "メールアドレスの形式が不正です。",
				specialChar:"メールアドレスに使用できない文字が含まれています。",
				mailvalidation:"メールアドレスの形式が不正です。",
				restrictEmail:"このメールアドレスは制限されています。"
			},
			// 確認用メールアドレスのエラーメッセージ。
			confirmEmail:{
				required:"メールアドレスが未入力です",
				email: "メールアドレスの形式が不正です。",
				specialChar:"メールアドレスに使用できない文字が含まれています。",
				mailvalidation:"メールアドレスの形式が不正です。",
				equalTo:"メールアドレスが一致しません。",
				restrictEmail:"このメールアドレスは制限されています。"
			},
			captchaCode: { 
				required:"キャプチャが未入力です。",
				checkCaptcha:"正しいキャプチャを入力してください。"
			}
		},
		submitHandler: function(form) {
			var arno = $('#arno').val();
			var kaiincd = $('#kaiincd').val();
			var kaiinnm = $('#kaiinnm').val();
			var kaiinkbnmem = $('#kaiinkbnmem').val();
			$.ajax({
		        url    : 'appliedcheck',
		        type   : 'POST',
		        data   : {'arno': arno ,
		        		'kaiincd' : kaiincd, 
		        		'kaiinnm' : kaiinnm, 
		        		'kaiinkbnmem' : kaiinkbnmem},
		        async: false,
		        success : function(data){
		          if(data == 1){
		            alreadyapplied();
		          } else {
					form.submit();
		          }
		        },
		        error : function(errorData){
		         alreadyapplied();
		        }
		    });
		}

	});
});
function alreadyapplied(){
     $.confirm({
        title: '',
        content: '既にお申し込み頂いております',
        type: 'blue',
        buttons: {
          OK: {
                btnClass: 'btn-blue',
                keys: ['enter']                                 
              }
        }
    });
}
