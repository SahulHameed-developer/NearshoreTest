/*
 * onSubmit 申込情報の詳細情報画面へ
 */
$(function() {
	jQuery.validator.addMethod(
		"checkCaptcha",
		function(value, element) {
			return this.optional(element) || (value == captchaCode);
		});
	//form validation rules
	$("#moshiKomitorikeshiFrm").validate({
		errorPlacement: function(error, element) {
			if (element.attr("id") == "captchaCode") {
				element.parent().parent().next("label").html('');
				error.insertAfter(element.parent().parent().next("label"));
			} else {
				error.insertAfter(element.parent("div"));
			}
		},
		onkeyup: false,
		rules: {
			captchaCode: {
				required : true,
				checkCaptcha : true
			}
		},
		messages: {
			captchaCode: { 
				required:"キャプチャが未入力です。",
				checkCaptcha:"正しいキャプチャを入力してください。"
			}
		}
	});
});
