$(document).ready(function() {
	$("#mailaddress").focus();
	
	$('#loginbtn').click(function() {
		$( "#flashMessage" ).empty();
	});
	
    $('.underscoresingle').bind('keydown keyup', function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if(charCode == 226) {
			this.value = this.value.replace("__", "_");
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
				rules: {
					mailaddress: {
						required:true,
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
                    }
				},
				messages: {
					mailaddress: {
                		required:"メールアドレスが未入力です。",
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
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

jQuery.validator.addMethod("specialChar", function(value, element) {
	return this.optional(element) || value.match(/^[a-zA-Z0-9-_.@]*$/);
});

jQuery.validator.addMethod("mailvalidation",function(value, element) {
	return this.optional(element) || value.match(/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/);
});