$(document).ready(function() {
	function validateContractDate() {
		$('#s_keiyaku_from').trigger('focusin');
		$('#s_keiyaku_from').trigger('focusout');
		$('#s_keiyaku_to').trigger('focusin');
		$('#s_keiyaku_to').trigger('focusout');
	}
	$('#s_keiyaku_from, #s_keiyaku_to').MonthPicker()
	    .on("input change click", function (e) {
	    	validateContractDate();
	});
	$('input[name="ktukisuu"]').click(function() {
		validateContractDate();
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
	$(".menuBack").click(function () {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#menuFrm").submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$('.listBack').click(function() {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$('#ContractSearchForm').submit();
					}
				},
				キャンセル: function () {
					
				}
			}
		});
	});
	$('.underscoresingle').bind('keydown keyup', function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if(charCode == 226) {
			this.value = this.value.replace("__", "_");
		}
	});
	$(".add").click(function(){
		$('#ContractRegisterfrm').submit();
	});

	$('#s_keikin').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'').replace(/\b0+/g,"");
	});
	jQuery.nl2br = function(varTest){
		return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
	};
});

//入力値の検証
(function($,W,D)
{
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#ContractRegisterfrm").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					$(".tantounm").html("");
					$(".tantounmkana").html("");
					$(".uketukedt").html("");
					$(".syounindt").html("");
					$(".tuuchidt").html("");
					$(".nyukindt").html("");
					$(".utantounm").html("");
					$(".s_keiyaku_from").html("");
					$(".s_keiyaku_to").html("");
					$(".s_keikin").html("");
					if(element.attr("name") == "s_keiyaku_from" || element.attr("name") == "s_keiyaku_to") {
						$(".date_errorft").html("");
						error.appendTo('.date_errorft');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					tantounm: {
						required:true,
						zenkaku:true,
						withTwoStrings: true,
						maxlength: 40
					},
					tantounmkana: {
						hiragana:true,
						zenkaku:true,
						withTwoStrings: true,
						maxlength: 40
					},
					mailaddr: {
						required:true,
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					telno: {
						// required:true,
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					faxno: {
						// required:true,
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					uketukedt: {
						dateFormat: true,
					},
					syounindt: {
						dateFormat: true,
					},
					tuuchidt: {
						dateFormat: true,
					},
					nyukindt: {
						dateFormat: true,
					},
					utantounm: {
						// required:true,
						zenkaku:true,
						withTwoStrings: true,
						maxlength: 40
					},
					s_keiyaku_from: {
						required:true,
						monthFormat: true,
						skeiyakukikan: true
					},
					s_keiyaku_to: {
						required:true,
						monthFormat: true,
						// lessThan: '[name="s_keiyaku_from"]',
						monthcount: true,
						skeiyakukikan: true
					},
					s_keikin: {
						required:true
					}
				},
				messages: {
					tantounm: { 
						required:"広告担当者名が未入力です。",
						zenkaku:"全角を入力してください。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tantounmkana: { 
						hiragana:"ひらがなのみ入力できます。",
						zenkaku:"全角を入力してください。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					mailaddr:{
						required:"メールアドレスを入力してください。",
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。"
					},
					telno: {
						required:"電話番号を入力してください。",
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					faxno: {
						required:"FAX番号を入力してください。",
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					uketukedt: {
						dateFormat: "受付日付が不正な形式です",
					},
					syounindt: {
						dateFormat: "承認日付が不正な形式です",
					},
					tuuchidt: {
						dateFormat: "承諾通知日付が不正な形式です",
					},
					nyukindt: {
						dateFormat: "入金締切日付が不正な形式です",
					},
					utantounm: { 
						required:"受付担当者名が未入力です",
						zenkaku:"全角を入力してください。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					s_keiyaku_from: {
						required:"初回契約期間（開始月）を入力してください。",
						monthFormat: "初回契約期間（開始月）が不正な形式です。",
						skeiyakukikan: "初回契約期間（終了月）は 初回契約期間（開始月) 以降の日付を指定してください。"
					},
					s_keiyaku_to: {
						required:"初回契約期間（終了月）を入力してください。",
						monthFormat: "初回契約期間（終了月）が不正な形式です。",
						lessThan:"期間の開始、終了を正しく入力してください。",
						monthcount:"契約期間と契約月数が異なっています。契約期間を修正してください。",
						skeiyakukikan: "初回契約期間（終了月）は 初回契約期間（開始月) 以降の日付を指定してください。"
					},
					s_keikin: { 
						required:"初回契約金額を入力してください。"
					}
				},
				submitHandler: function(form) {
					$.confirm({
						title: '',
						content: INSERT_CONFIRM,
						type: 'blue',
						buttons: {
							OK: {
								action: function(){
									$("#registercls").addClass('registercls');
				                	$('.b-release').prop('disabled', true);
									$('#ContractRegisterfrm').attr('target', '');
									$('#ContractRegisterfrm').attr('action', '../AdminContract/register');
									var data = new FormData();
									var serializedData = $("#ContractRegisterfrm").serialize();
									serializedData = decodeURIComponent(serializedData);
									data.append('otherFields', serializedData);
									var xhr = new XMLHttpRequest();
								 	xhr.open('POST', 'register', true);
								 	xhr.send(data);
								 	xhr.onload = function () {
								 		$("#registercls").removeClass('registercls');
									 	if(xhr.responseText == "1") {
									 		if (xhr.status === 200) {
									 			$.confirm({
													title: '',
													content: INSERT_SUCCESS,
													type: 'blue',
													buttons: {
														OK: {
															btnClass: 'btn-blue',
															keys: ['enter'],
															action: function(){
																$( "#ContractSearchForm" ).submit();
															}
														}
													}
												});
											} else {
												window.location = "../Error/systemError";
											}
									 	} else if (xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200) {
									 		window.location = "../Error/systemError";
									 	} else {
									 		$.confirm({
													title: '',
													content: INSERT_FAILURE,
													type: 'blue',
													buttons: {
														OK: {
															btnClass: 'btn-blue',
															keys: ['enter'],
															action: function(){
														 		$('.b-release').prop('disabled', false);
															}															
														}
													}
												});
									 		var allErrArr = xhr.responseText.split("$$");
									 		var focusArea ="";
											$(".tantounm").html("");
											$(".tantounmkana").html("");
											$(".uketukedt").html("");
											$(".syounindt").html("");
											$(".tuuchidt").html("");
											$(".nyukindt").html("");
											$(".utantounm").html("");
											$(".s_keiyaku_from").html("");
											$(".s_keiyaku_to").html("");
											$(".s_keikin").html("");
									 		allErrArr.forEach(function(errArr) {
									 			var err = errArr.split("##");
									 			focusArea = err[0];
												$("."+err[0]).html(err[1]);
									 		});
									 		$("#"+focusArea).focus();
									 		$('.b-release').prop('disabled', false);
									 	}
								 		
									};
								}
							},
							キャンセル: function () {
							}
						}
					});
				}
			});
			
		}
	}

	$(D).ready(function($) {
		jqueryValidation.UTIL.setupFormValidation();
	});

})(jQuery, window, document);

jQuery.validator.addMethod(
	"dateFormat",
	function(value, element) {
		var check = false;
		var re = /^(\d{4})\/(\d{1,2})\/(\d{1,2})$/;
			if( re.test(value)) {
				var adata = value.split('/');
				var yyyy = parseInt(adata[0],10);
				var mm = parseInt(adata[1],10);
				var dd = parseInt(adata[2],10);
				var xdata = new Date(yyyy,mm-1,dd);
				if ( ( xdata.getFullYear() === yyyy ) && ( xdata.getMonth () === mm - 1 ) && ( xdata.getDate() === dd ) ) {
					check = true;
				} else {
					check = false;
				}
			} else {
				check = false;
			}
			return this.optional(element) || check;
});
jQuery.validator.addMethod(
	"monthFormat",
	function(value, element) {
		var check = false;
		var re = /^(\d{4})\/(\d{1,2})$/;
			if( re.test(value)) {
				var adata = value.split('/');
				var yyyy = parseInt(adata[0],10);
				var mm = parseInt(adata[1],10);
				var xdata = new Date(yyyy,mm-1);
				if ( ( xdata.getFullYear() === yyyy ) && ( xdata.getMonth () === mm - 1 ) ) {
					check = true;
				} else {
					check = false;
				}
			} else {
				check = false;
			}
			return this.optional(element) || check;
});
jQuery.validator.addMethod(
		"lessThan", 
		function(value, element, params) {
			if(value=='') {
				return true;
			} else {
				var fromtime = $(params).val();
				if(fromtime >= value){
					return false;
				} 
			}
			return true;
});
// 全角スペースがあるチェックの機能を追加。
jQuery.validator.addMethod(
	"withTwoStrings",
	function(value, element) {
		howManyWords = value.trim();
		if(howManyWords !="") {
			howManyWords = howManyWords.replace(/\s{2,}/g, '　'); //remove extra spaces
			howManyWords = howManyWords.split('　');
				if(howManyWords.length == 2) {
					return true;
				} else {
					return false;
				}
				e.preventDefault();
		} else {
			return true;
		}
});
jQuery.validator.addMethod("zenkaku", function(value, element) {
	 return this.optional(element) || /^[^ -~｡-ﾟ]*$/.test(value);
});
jQuery.validator.addMethod("monthcount", function(value, element) {
	var monthscheck = $( 'input[name=ktukisuu]:checked' ).val();
	var monthval;
	if(monthscheck == 1) {
		monthval = 6;
	} else {
		monthval = 12;
	}
	var s_keiyaku_from = new Date($("#s_keiyaku_from").val()+"/01");
	var s_keiyaku_to = new Date($("#s_keiyaku_to").val()+"/01");
	var difference = (s_keiyaku_to.getFullYear()*12 + s_keiyaku_to.getMonth()) - (s_keiyaku_from.getFullYear()*12 + s_keiyaku_from.getMonth());
	if(monthval > difference) {
		return true;
	} else {
		return false;
	}
});
jQuery.validator.addMethod("skeiyakukikan", function(value, element) {
	var from = $("#s_keiyaku_from").val();
	var to = $("#s_keiyaku_to").val();
	if(to != "") {
		if(dateCheck(from+'/01',to+'/01',value+'/01')) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
});
function dateCheck(from,to,check) {
    var fDate,lDate,cDate;
    fDate = Date.parse(from);
    lDate = Date.parse(to);
    cDate = Date.parse(check);
    if((cDate <= lDate && cDate >= fDate)) { return true; }
    return false;
}
jQuery.validator.addMethod(
	"specialChar", 
	function(value, element) {
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
jQuery.validator.addMethod(
	"mailvalidation",
	function(value, element) {
		return this.optional(element) || value.match(/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/);
	});
jQuery.validator.addMethod("hiragana", function(value, element) {
	 return this.optional(element) || /^([ぁ-ん　]+)$/.test(value);
});