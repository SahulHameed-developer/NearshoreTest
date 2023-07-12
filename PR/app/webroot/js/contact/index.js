/*
 * onSubmit お問い合わせの詳細情報画面
 */
$(function() {
	$('#submit').attr('disabled', 'disabled');
	$('#check').click(function() {
		if ($(this).prop('checked') == false) {
			$('#submit').attr('disabled', 'disabled');
		} else {
			$('#submit').removeAttr('disabled');
		}
	});
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	$(".doublebyte").focusout(function(evt) {
		var id = this.id;
		$.ajax({
			url    : 'contact/doublebyte',
			type   : 'POST',
			datatype : 'JSON',
			data   : {'val': this.value},
			async: false,
			success : function(data){
				$("#"+id).val(data);
			},
			error : function(errorData){
				//alert(errorData.status);
			}
		});
	});
	$(".doublebyte2").focusout(function(evt) {
		var id = this.id;
		$.ajax({
			url    : '../contact/doublebyte',
			type   : 'POST',
			datatype : 'JSON',
			data   : {'val': this.value},
			async: false,
			success : function(data){
				$("#"+id).val(data);
			},
			error : function(errorData){
				//alert(errorData.status);
			}
		});
	});
	$('.underscoresingle').bind('keydown keyup', function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if(charCode == 226) {
			this.value = this.value.replace("__", "_");
		}
	});
	jQuery.validator.addMethod("withTwoStrings", function(value, element) {
		howManyWords = value.trim();
		howManyWords = howManyWords.replace(/\s{2,}/g, '　'); //remove extra spaces
		howManyWords = howManyWords.split('　');
		if(howManyWords.length == 2){
			return true;
		}
		else{
			return false;
		}
		e.preventDefault();
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
	jQuery.validator.addMethod("mailvalidation", function(value, element) {
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
	// 英数、ハイフン(-)、アンダーバー(_)、ピリオド(.)、@の文字チェックの機能を追加
	jQuery.validator.addMethod("specialChar", function(value, element) {
		return this.optional(element) || value.match(/^[a-zA-Z0-9-_.@]*$/);
	});
	jQuery.validator.addMethod("alphahypen", function(value, element) {
		return this.optional(element) || value.match(/^[0-9,-]*$/);
	});
	jQuery.validator.addMethod("hyphensnecessary", function(value, element) {
		return this.optional(element) || value.match(/[-]/);
	});
	jQuery.validator.addMethod("jpnumbernotzeros", function(value, element) {
		if(value == "000-0000-0000" || value == "000-000-0000") { return false; } else { return true; }
	});
	jQuery.validator.addMethod("jpnumberformat", function(value, element) {
		return this.optional(element) || value.match(/^(?:\d{10}|\d{3}-\d{3}-\d{4}|\d{2}-\d{4}-\d{4}|\d{3}-\d{4}-\d{4}|\d{4}-\d{2}-\d{4})$/);
	});
    //form validation rules
    $("#toiawasei").validate({
    	errorPlacement: function(error, element) {
    		if(element.attr("name") == "gyosyucd") {
    			$(".error_gyosyucd").html("");
				error.appendTo('.error_gyosyucd');
			} else if (element.attr("id") == "captchaCode") {
				element.parent().parent().next("label").html('');
				error.insertAfter(element.parent().parent().next("label"));
			} else {
				error.insertAfter(element.parent("div"));
			}
		},
		onkeyup: false,
        rules: {
        	kaisyanm: {
				required:true,
				maxlength: 100
			},
			yakunm: {
				required:true,
				maxlength: 40
			},
        	tantou: {
				required:true,
				withTwoStrings: true,
				maxlength: 40
			},
        	mailaddr: {
                required: true,
                email: true,
                specialChar:true,
                mailvalidation:true,
				maxlength: 100,
				restrictEmail:true
            },
        	cmailaddr: {
                required: true,
                email: true,
                specialChar:true,
                mailvalidation:true,
                equalTo: "#mailaddr",
				maxlength: 100,
				restrictEmail:true
            },
            telno: {
				alphahypen:true,
				hyphensnecessary:true,
				jpnumberformat:true,
				jpnumbernotzeros:true,
				maxlength: 15
			},
            gyosyucd: "required",
			naiyou: {
				required:true,
				maxlength: 1024
			},
			captchaCode: {
				required : true,
				checkCaptcha : true
			}
        },
        messages: {
        	kaisyanm: { 
				required:"会社名が未入力です。",
				maxlength: "最大文字数を超えています。"
			},
			yakunm: { 
				required:"役職名が未入力です。",
				maxlength: "最大文字数を超えています。"
			},
        	tantou: {
				required:"担当者名が未入力です。",
				withTwoStrings:"姓と名の間に全角スペースを入力してください。",
				maxlength: "最大文字数を超えています。"
			},
        	mailaddr: {
        		required:"メールアドレスが未入力です。",
        		email:"メールアドレスの書式で入力してください。",
        		specialChar:"メールアドレスに使用できない文字が含まれています。",
        		mailvalidation:"メールアドレスの形式が不正です",
				maxlength: "最大文字数を超えています。",
				restrictEmail:"このメールアドレスは制限されています。"
        	},
        	cmailaddr: {
        		required:"確認メールアドレスが未入力です。",
        		email:"メールアドレスの書式で入力してください。",
        		specialChar:"メールアドレスに使用できない文字が含まれています。",
        		mailvalidation:"メールアドレスの形式が不正です",
        		equalTo:"確認メールアドレスが一致しません。",
				maxlength: "最大文字数を超えています。",
				restrictEmail:"このメールアドレスは制限されています。"
        	},
        	telno: {
				jpnumbernotzeros:"電話番号が未入力です。",
				alphahypen:"数値を入力してください。",
				jpnumberformat:"電話番号の書式で入力してください。",
				hyphensnecessary:"ハイフンを含めた番号を入力してください。",
				maxlength: "最大文字数を超えています。"
			},
        	gyosyucd: "業種が未選択です。",
			naiyou: { 
				required:"お問い合わせ内容が未入力です。",
				maxlength: "最大文字数を超えています。"
			},
			captchaCode: { 
				required:"キャプチャが未入力です。",
				checkCaptcha:"正しいキャプチャを入力してください。"
			}
        }
    });
});