$(document).ready(function() {
	$("#lgid").focus();
	$('#cmailaddr').bind("cut copy paste drop",function(e) {
	     e.preventDefault();
	 });
	// エラーメッセージあった場合は
	if ($('#flashMessage').length != 0) {
		$("#lgid").css("background", "#FFF5F5");
		$("#lgpass").css("background", "#FFF5F5");
	}
	$('#loginbtn').click(function() {
		// エラーメッセージを削除。
		$( "#flashMessage" ).empty();
		if($("#lgid").val() !=""){
			$("#lgid").css("background-color", "white");
		}
		if($("#lgpass").val()!=""){
			$("#lgpass").css("background-color", "white");
		}
	});
    $('#lgpass').blur(function() {
        this.value = this.value.replace(/\s+/g, '');
    });
    $('.underscoresingle').bind('keydown keyup', function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if(charCode == 226) {
			this.value = this.value.replace("__", "_");
		}
	});
	jQuery.validator.addMethod("lettersonly", function(value, element) {
		var emil=value;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if(!emailReg.test(emil)) {
			return false;
        } else {
        	return true;
        }
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
		"alphanumsymbol",
		function(value, element) {	
			return this.optional(element) || value.match(/^[A-Za-z0-9 !"#$%&'()=~|^`{[@+*}_?><,./\\\]:;-]*$/g);
		});
	jQuery.validator.addMethod("minlengthpass",function(value) {
		if(value == "") {
			return true;
		} else if(value.length < 6){
			return false;
		} else {
			return true;
		}
	});
	$.validator.addMethod("pwcheck", function(value) {
		if(value == "") {
			return true;
		} else {
			return /^[a-zA-Z0-9!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]+$/.test(value)
			&& /\d/.test(value)//has a digit
			&& /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/.test(value)// has a special character
		}
	});
});
//入力値の検証
(function($,W,D)
{
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 管理画面ログインフォーム確認
			$("#loginfrm").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					if(element.attr("name") == "lgid") {
						error.appendTo('#errordiv_lgid');
					} else if(element.attr("name") == "lgpass") {
						error.appendTo('#errordiv_lgpass');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					// 会員メールアドレス
					lgid: {
						required:true,
						alphanumsymbol:true
					},
					// 会社名
					lgpass: {
						required:true
					},
				},
				messages: {
					// 会員メールアドレスのエラーメッセージ。
					lgid:{ 
						required:"ユーザ名が未入力です。",
						alphanumsymbol:"入力可能文字種は、英数字、記号です。"
					},
					// 会社名のエラーメッセージ。
					lgpass: {
						required:"パスワードが未入力です。",
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
			
		}
	}

	$(D).ready(function($) {
		jqueryValidation.UTIL.setupFormValidation();
	});

})(jQuery, window, document);
(function($,W,D)
{
    var JQUERY4U = {};
    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#pwdchangefrm").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					if(element.attr("name") == "pwd") {
						error.appendTo('#errordiv_pwd');
					} else if(element.attr("name") == "re_pwd") {
						error.appendTo('#errordiv_re_pwd');
					} else {
						error.insertAfter(element);
					}
				},
                rules: {
                	pwd: {
						required:true,
						minlengthpass: true,
						maxlength: 40,
						pwcheck:true
					},
                	re_pwd: {
						required:true,
						equalTo: "#pwd",
						minlengthpass: true,
						maxlength: 40,
						pwcheck:true
					}
                },
                messages: {
					pwd: {
                		required:"パスワードが未入力です。",
                		minlengthpass:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						pwcheck:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						maxlength: "最大文字数を超えています。"
                	},
					re_pwd: {
                		required:"確認パスワードが未入力です。",
                		equalTo:"パスワードが一致しません。",
                		minlengthpass:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						pwcheck:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						maxlength: "最大文字数を超えています。"
                	}
                },
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });
})(jQuery, window, document);

(function($,W,D)
{
    var JQUERY4U = {};
    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#pwdMailSendFrm").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					if(element.attr("name") == "mailaddr") {
						error.appendTo('#errordiv_mailaddr');
					} else if(element.attr("name") == "cmailaddr") {
						error.appendTo('#errordiv_cmailaddr');
					} else {
						error.insertAfter(element);
					}
				},
                rules: {
                	mailaddr: {
						required:true,
						email: true,
                        specialChar:true,
                        mailvalidation:true
					},
                	cmailaddr: {
						required:true,
						email: true,
						specialChar:true,
						mailvalidation:true,
						equalTo: "#mailaddr"
					}
                },
                messages: {
                	mailaddr: {
                		required:"メールアドレスが未入力です。",
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です"
                	},
                	cmailaddr: {
                		required:"確認メールアドレスが未入力です。",
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です",
                		equalTo:"メールアドレスが一致しません。"
                	}
                },
                submitHandler: function(form) {
					$(".Errtxt").html("");
                	$('.button').prop('disabled', true);
					var data = new FormData();
					var serializedData = $("#pwdMailSendFrm").serialize();
					serializedData = decodeURIComponent(serializedData);
					data.append('otherFields', serializedData);
					var xhr = new XMLHttpRequest();
				 	xhr.open('POST', 'sendMail', true);
				 	xhr.send(data);
					$("#updatecls").addClass('updatecls');
				 	xhr.onload = function () {
						if(xhr.responseText == "1") {
							$("#updatecls").removeClass('updatecls');
				 			$.confirm({
								title: '',
								content: '登録メールアドレスへ再発行画面ＵＲＬを送信しました。',
								type: 'blue',
								buttons: {
									OK: {
										btnClass: 'btn-blue',
										keys: ['enter'],
										action: function(){
						                    $("#loginindex").submit();
										}
									}
								}
							});
						} else {
							$("#updatecls").removeClass('updatecls');
							var Errtxt = xhr.responseText;
               			 	$('.button').prop('disabled', false);
							$(".Errtxt").html("");
					 		$(".Errtxt").html(Errtxt);
						}
					}
                }
            });
        }
    }
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });
})(jQuery, window, document);