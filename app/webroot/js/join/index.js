$(function() {
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	// 初期表示で確認画面ボタンを無効する処理。
	$('#submit').attr('disabled', 'disabled');
	// 業種名の値セット
	$('#gyosyunm').val('');
	// 戻るの場合　同意チェックを選択して確認画面ボタンを有効する処理。
	if($("#nyukaiButtonSel").val()=='modoru'){
		// 同意チェックをチェック
		$("#check").prop("checked", true);
		// 確認画面を有効
		$('#submit').removeAttr('disabled');
	}else{
		// 同意チェックをチェックしない。
		$("#check").prop("checked", false);
		// 確認画面を無効
		$('#submit').attr('disabled', 'disabled');
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
	// 会員種別を変わるの場合は、
	$('#members_type').change(function() {
		// 選択したテキストのセット
		$('#kaiinsbName').val($(this).find('option:selected').text());
		// 会員種別が"正会員"or"準会員"の場合
	});
	// 選択したテキストのセット
	$('#kaiinsbName').val($("#members_type").find('option:selected').text());
	// 業種を変わるの場合は、
	if($('#industry').find('option:selected').text() != "") {
		$('#gyosyuName').val($('#industry').find('option:selected').text());
	} 
	$('#industry').change(function() {
		// 選択したテキストを業種名にセットする。
		$('#gyosyuName').val($(this).find('option:selected').text());
	});
	$(".doublebyte").focusout(function(evt) {
		var id = this.id;
		$.ajax({
			url    : '../Common/doublebyte',
			type   : 'POST',
			datatype : 'JSON',
			data   : {'val': this.value},
			async: false,
			success : function(data){
				$("#"+id).val(data);
			},
			error : function(errorData){
				alert(errorData.status);
			}
		});
	});
	$('.underscoresingle').bind('keydown keyup', function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if(charCode == 226) {
			this.value = this.value.replace("__", "_");
		}
	});
	// 全角スペースがあるチェックの機能を追加。
	jQuery.validator.addMethod(
		"withTwoStrings",
		function(value, element) {
			if(value != "") {
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
			} else {
				return true;
			}
		});
	// ハイフンを含めた電話番号、市外局番の省略無しするチェックの機能を追加。
	jQuery.validator.addMethod(
		"phone", 
		function (phone_number, element) {
			phone_number = phone_number.replace(/\s+/g, "");
			return this.optional(element) || phone_number.length > 9 &&
				phone_number.match(/^\(?[\d\s]{3}-[\d\s]{3}-[\d\s]{4}$/);
		});
	// 英数、ハイフン(-)、アンダーバー(_)、ピリオド(.)、@の文字チェックの機能を追加
	jQuery.validator.addMethod(
		"specialChar", 
		function(value, element) {
			return this.optional(element) || value.match(/^[a-zA-Z0-9-_.@]*$/);
		});
	jQuery.validator.addMethod(
		"starthyphens", 
		function(value, element) {
			return this.optional(element) || value.match(/^[0-9](?!.*--)[0-9-]*[0-9]$/);
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
	jQuery.validator.addMethod("hiragana", function(value, element) {
		return this.optional(element) || /^([ぁ-ん　]+)$/.test(value);
	});
	jQuery.validator.addMethod("hirasymJH", function(value, element) {
		return this.optional(element) || /^([ぁ-ん　ー＝~｜－＾\＠［｀｛＋＊｝；：］＜＞？＿，．／！"＃＄％＆'（）－＾＠「‘｛｝＊＋；：」＿？＞＜、。・￥]+)$/.test(value);
	});
	$("#nyukaiConfirmForm").validate({
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
			// 会員種別
			members_type: "required",
			// 紹介者会社名
			syokaikaisyanm:{
				maxlength: 100
			},
			// 紹介者名
			syokainm:{
				withTwoStrings: true,
				maxlength: 40
			},
			// 会社名
			kaisyanm:{
				required:true,
				maxlength: 100
			},
			// 会社名かな
			kaisyanmkana:{
				required:true,
				hirasymJH:true,
				maxlength: 255
			},
			// 役職名
			yakunm:{
				required:true,
				maxlength: 40
			},
			// 氏名
			simei:{
				required:true,
				withTwoStrings: true,
				maxlength: 40
			},
			// 氏名かな
			simeikana:{
				required:true,
				hiragana:true,
				withTwoStrings: true,
				maxlength: 40
			},
			// 電話番号
			telno:{
				required:true,
				alphahypen:true,
				hyphensnecessary:true,
				jpnumberformat:true,
				jpnumbernotzeros:true,
				maxlength: 15
			},
			// メールアドレス
			mailaddr:{
				required:true,
				email:true,
				specialChar:true,
				mailvalidation:true,
				maxlength: 100,
				restrictEmail:true
			},
			// 確認用メールアドレス
			confMailaddr:{
				required:true,
				email:true,
				specialChar:true,
				mailvalidation:true,
				equalTo: '[name="mailaddr"]',
				maxlength: 100,
				restrictEmail:true
			},
			//備考
			bikou:{
				maxlength: 255
			},
			// 業種
			industry:"required",
			captchaCode: {
				required : true,
				checkCaptcha : true
			}
		},
		messages: {
			// 会員種別のエラーメッセージ。
			members_type: "会員種別が未選択です。",
			// 紹介者会社名のエラーメッセージ。
			syokaikaisyanm: {
				maxlength: "最大文字数を超えています。"
			},
			// 紹介者名
			syokainm: {
				withTwoStrings:"姓と名の間に全角スペースを入力してください。",
				maxlength: "最大文字数を超えています。"
			},
			// 会社名のエラーメッセージ。
			kaisyanm: {
				required: "会社名が未入力です。",
				maxlength: "最大文字数を超えています。"
			},
			// 会社名かなのエラーメッセージ。
			kaisyanmkana: {
				required:"会社名かなが未入力です。",
				hirasymJH:"入力可能文字種は、ひらがな、記号、ーです。",
				maxlength: "最大文字数を超えています。"
			},
			// 役職名のエラーメッセージ。
			yakunm: {
				required: "役職名が未入力です。",
				maxlength: "最大文字数を超えています。"
			},
			// 氏名のエラーメッセージ。
			simei: {
				required: "氏名が未入力です。",
				withTwoStrings:"姓と名の間に全角スペースを入力してください。",
				maxlength: "最大文字数を超えています。"
			},
			// 氏名かなのエラーメッセージ。
			simeikana: {
				required: "氏名かなが未入力です。",
				hiragana:"ひらがなのみ入力できます。",
				withTwoStrings:"姓と名の間に全角スペースを入力してください。",
				maxlength: "最大文字数を超えています。"
			},
			// 電話番号のエラーメッセージ。
			telno: {
				required:"電話番号が未入力です。",
				jpnumbernotzeros:"正しい番号を入力してください。",
				alphahypen:"数値を入力してください。",
				jpnumberformat:"正しい番号を入力してください。",
				hyphensnecessary:"ハイフンを含めた番号を入力してください。",
				maxlength: "最大文字数を超えています。"
			},
			// メールアドレスのエラーメッセージ。
			mailaddr:{ 
				required:"メールアドレスが未入力です。",
				email: "メールアドレスの形式が不正です",
				specialChar:"メールアドレスに使用できない文字が含まれています。",
				mailvalidation:"メールアドレスの形式が不正です",
				maxlength: "最大文字数を超えています。",
				restrictEmail:"このメールアドレスは制限されています。"
			},
			// 確認用メールアドレスのエラーメッセージ。
			confMailaddr:{
				required:"メールアドレスが未入力です。",
				email: "メールアドレスの形式が不正です",
				specialChar:"メールアドレスに使用できない文字が含まれています。",
				mailvalidation:"メールアドレスの形式が不正です",
				equalTo:"メールアドレスが一致しません。",
				maxlength: "最大文字数を超えています。",
				restrictEmail:"このメールアドレスは制限されています。"
				
			},
			//備考のエラーメッセージ。
			bikou:{
				maxlength: "最大文字数を超えています。"
			},
			// 業種のエラーメッセージ。
			industry: "業種が未選択です。",
			captchaCode: { 
				required:"キャプチャが未入力です。",
				checkCaptcha:"正しいキャプチャを入力してください。"
			}
		}
	});
});