$(document).ready(function() {

	if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) {
		if($("#ulradio").width() > 680) {
			$("#ulradio").css({"display":"block"});
		}
	} else { 
		if($("#ulradio").width() >= 680 && $("#ulradio").height() > 29 ) {
			$("#ulradio").css({"display":"block"});
		}
	}	

	if($("#mstcode").val() == M_BUNRUI_VAL || $("#mstcode").val() == M_KONIN_VAL || $("#mstcode").val() == M_KOUKAI_VAL || $("#mstcode").val() == M_KEIYAKU_VAL) {
		$("#code").attr('maxlength','1');
	} else if($("#mstcode").val() == M_KBUNRUI_VAL || $("#mstcode").val() == M_KURABU_VAL ) {
		$("#code").attr('maxlength','3');
	} else {
		$("#code").attr('maxlength','2');
	}

	if($("#mstcode").val() == M_KONIN_VAL || $("#mstcode").val() == M_KOUKAI_VAL || $("#mstcode").val() == M_TODOFUKEN_VAL) {
		$("#meisho").attr('maxlength','20');
	} else {
		$("#meisho").attr('maxlength','40');
	}

	$('#code').blur(function() {
		if($("#mstcode").val() == M_KONIN_VAL || $("#mstcode").val() == M_KOUKAI_VAL || $("#mstcode").val() == M_BUNRUI_VAL || $("#mstcode").val() == M_KEIYAKU_VAL) {
			var pad = "";
		} else if($("#mstcode").val() == M_KBUNRUI_VAL) {
			var pad = "000";
		} else {
			var pad = "00";
		}
		var str = $("#code").val();
		var codeval = pad.substring(0, pad.length - str.length) + str;
		$("#code").val(codeval);
	});

	$('input[type=radio][name=bunruicd]').change(function() {
		if($("#mstcode").val() == M_KBUNRUI_VAL) {
			var fromdt = checkdate($("#fromdt").val());
			var todt = checkdate($("#todt").val());
			var return_first = function () {
		    var tmp = null;
				$.ajax({
					url    : 'checkbunruicd',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'fromdt': fromdt ,'todt': todt ,'kbunruicd': $("#code").val() ,'bunruicd': $('input[name=bunruicd]:checked').val() },
					async: false,
					success : function(data){
						if(data != "[]") {
							tmp = 1;
						} else {
							tmp = 2;
						}
					}
				});
			    return tmp;
			}();
			if(return_first != 1) {
				$('label[for=code]').remove();
				$("#code").removeClass('error');
				$('#checkcode_err').hide();
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			} else {
				$('#checkcode_err').show();
				$('.e-release').prop('disabled', true);
				$('.b-release').prop('disabled', true);
			}
			if($("#bunruicd_db").val() == $('input[name=bunruicd]:checked').val() && $("#db_fromdt").val() == $("#fromdt").val() && $("#db_todt").val() == $("#todt").val() ) {
				$('label[for=code]').remove();
				$('#checkcode_err').hide();
				$("#code").removeClass('error');
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			}
			if($("#bunruicd_db").val() == 0 ) {
				$('label[for=code]').remove();
				$('#checkcode_err').hide();
				$("#code").removeClass('error');
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			}
		}
	});
	$('#code ,#fromdt, #todt').change(function() {
		if($("#mstcode").val() == M_KBUNRUI_VAL) {
			var fromdt = checkdate($("#fromdt").val());
			var todt = checkdate($("#todt").val());
			var return_first = function () {
		    var tmp = null;
				$.ajax({
					url    : 'checkbunruicd',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'fromdt': fromdt ,'todt': todt ,'kbunruicd': $("#code").val() ,'bunruicd': $('input[name=bunruicd]:checked').val() },
					async: false,
					success : function(data){
						if(data != "[]") {
							tmp = 1;
						} else {
							tmp = 2;
						}
					}
				});
			    return tmp;
			}();
			if(return_first != 1) {
				$('label[for=code]').remove();
				$("#code").removeClass('error');
				$('#checkcode_err').hide();
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			} else {
				$('#checkcode_err').show();
				$('.e-release').prop('disabled', true);
				$('.b-release').prop('disabled', true);
			}
			if($("#bunruicd_db").val() == $('input[name=bunruicd]:checked').val() && $("#db_fromdt").val() == $("#fromdt").val() && $("#db_todt").val() == $("#todt").val() ) {
				$('label[for=code]').remove();
				$('#checkcode_err').hide();
				$("#code").removeClass('error');
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			}
			if($("#bunruicd_db").val() == 0 ) {
				$('label[for=code]').remove();
				$('#checkcode_err').hide();
				$("#code").removeClass('error');
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			}
		} else {
			var fromdt = checkdate($("#fromdt").val());
			var todt = checkdate($("#todt").val());
			var return_first = function () {
		    var tmp = null;
				$.ajax({
					url    : 'checkcode',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'fromdt': fromdt ,'todt': todt ,'checkcode': $("#code").val(),'table': $("#mstcode").val() },
					async: false,
					success : function(data){
						if(data != "[]") {
							tmp = 1;
						} else {
							tmp = 2;
						}
					}
				});
			    return tmp;
			}();
			if(return_first != 1) {
				$('label[for=code]').remove();
				$("#code").removeClass('error');
				$('#checkcode_err').hide();
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			} else {
				$('#checkcode_err').show();
				$("#code").addClass('error');
				$('.e-release').prop('disabled', true);
				$('.b-release').prop('disabled', true);
			}
			if($("#db_fromdt").val() == $("#fromdt").val() && $("#db_todt").val() == $("#todt").val() ) {
				$('label[for=code]').remove();
				$('#checkcode_err').hide();
				$("#code").removeClass('error');
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			}
			if($("#code").val() == "") {
				$('label[for=code]').remove();
				$("#code").removeClass('error');
				$('#checkcode_err').hide();
				$('.e-release').prop('disabled', false);
				$('.b-release').prop('disabled', false);
			}
		}
	});
	// 一覧に戻る
	$(".returnList").click(function(){
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$( "#listModoruFrm" ).submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".returnListhome").click(function(){
		$( "#listModoruFrm" ).submit();
	});
	$(".shosaiSakujo").click(function () {
		var code = $(this).attr("data-code");
		var bunruicd = $(this).attr("data-bunruicd");
		var fromdt = $(this).attr("data-fromdt");
		var todt = $(this).attr("data-todt");
		$.confirm({
			title: '',
			content: '削除を実行しますとデータがディスク上から消去されます。<br/>削除してもよろしいですか？<br/><br/>※&nbsp;一度運用で使用したコードは削除せず、適用終了日を更新してください。<br/>※&nbsp;未使用で、誤入力等不要な場合に限り、削除を実行してください。',
			type: 'blue',
	        columnClass: 'col-md-6 col-md-offset-3 col-sm-7 col-sm-offset-2 col-xs-10 col-xs-offset-1',
			buttons: {
				OK: {
					action: function(){
						$.ajax({
							url    : 'tabledatachk',
							type   : 'POST',
							datatype : 'JSON',
							data   : {'masterCode':$("#sousai_FrmSelectedmstcode").val(),'code': code,'bunruicd': bunruicd,'fromdt': fromdt,'todt': todt },
							async: false,
							success : function(data){
								if(data == 0 ) {
									$("#sousai_FrmCode").val(code);
									$("#sousai_FrmBunruicd").val(bunruicd);
									$("#sousai_FrmFromdt").val(fromdt);
									$("#sousai_FrmTodt").val(todt);
									$('#sousai_Frm').attr('action', '../AdminMaster/delete');
									$("#sousai_Frm").submit();
								} else {
									$.confirm({
										title: '',
										content: 'コードが使用されているため削除できません。',
										type: 'blue',
	        							columnClass: 'col-md-6 col-md-offset-3 col-sm-5 col-sm-offset-3 col-xs-10 col-xs-offset-1',
										buttons: {
											OK: {
												btnClass: 'btn-blue',
												keys: ['enter']
												
											}
										}
									});
								}
							},
							error : function(errorData){
								alert(errorData.status);
							}
						});
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".shosaiShutoku").click(function () {
		var code = $(this).attr("data-code");
		var bunruicd = $(this).attr("data-bunruicd");
		var fromdt = $(this).attr("data-fromdt");
		var todt = $(this).attr("data-todt");
		$("#sousai_FrmCode").val(code);
		$("#sousai_FrmBunruicd").val(bunruicd);
		$("#sousai_FrmFromdt").val(fromdt);
		$("#sousai_FrmTodt").val(todt);
		$('#sousai_Frm').attr('action', '../AdminMaster/edit');
		$("#sousai_Frm").submit();
	});
	$(".b-sendregister").click(function () {
		$('#sousai_Frm').attr('action', '../AdminMaster/add');
		$("#sousai_Frm").submit();
	});
	$('.backpage').click(function() {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$( "#ModoruFrm" ).submit();
					}
				},
				キャンセル: function () {
					
				}
			}
		});
	});
	$(".b-release").click(function(){
		$('#register').submit();
	});
	$(".e-release").click(function(){
		$('#update').submit();
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
});
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
	"lessThan", 
	function(value, element, params) {
		if(value=='') {
			return true;
		} else {
			var fromtime = $(params).val();
			if(fromtime > value){
				return false;
			} 
		}
		return true;
});
jQuery.validator.addMethod("numbersOnly", function(value, element) {
	return this.optional(element) || value.match(/^[0-9]*$/);
});
jQuery.validator.addMethod("startdatechk", function(value, element) {
	if($("#code").val() != "") {
		var return_first = function () {
	    var tmp = null;
		    $.ajax({
				url    : 'checkfromtodt',
				type   : 'POST',
				datatype : 'JSON',
				data   : {'fromdt': $("#fromdt").val() ,'code': $("#code").val(),'table': $("#mstcode").val(), 'bunruicd':$('input[name=bunruicd]:checked').val() },
				async: false,
				success : function(data){
					tmp = data.replace(/\"/g, '');
				}
			});
		    return tmp;
		}();
		if(return_first != 0) {
			if(return_first == 1) {
				$(".errorft").html("");
				$(".errorft").html("適用開始日は、過去データの適用終了日より未来の日付を指定してください。");
			} else {
				$(".errorft").html("");
				$(".errorft").html("適用開始日は、既存データの適用開始日より未来の日付を指定してください。");
			}
			return false;
		} else {
			$(".errorft").html("");
			return true;
		}
	}
});
jQuery.validator.addMethod("startdatechkedit", function(value, element) {
	var return_first = function () {
    var tmp = null;
	    $.ajax({
			url    : 'checkfromtodtedit',
			type   : 'POST',
			datatype : 'JSON',
			data   : {'db_fromdt': $("#db_fromdt").val() ,'db_todt': $("#db_todt").val() ,'fromdt': $("#fromdt").val(),'todt': $("#todt").val() ,'code': $("#code").val(),'table': $("#mstcode").val(), 'bunruicd':$('input[name=bunruicd]:checked').val() },
			async: false,
			success : function(data){
				tmp = data.replace(/\"/g, '');
			}
		});
	    return tmp;
	}();
	if(return_first != 0) {
		if(return_first == 1) {
			$(".errorft").html("");
			$(".errorft").html("現在有効でない過去データの変更はできません。");
		} else if(return_first == 2) {
			$(".errorft").html("");
			$(".errorft").html("適用開始日は、過去データの適用終了日より未来の日付を指定してください。");
		} else {
			$(".errorft").html("");
			$(".errorft").html("適用終了日は、過去データの適用開始日より未来の日付を指定してください。");
		}
		return false;
	} else {
		$(".errorft").html("");
		return true;
	}
});
jQuery.validator.addMethod("startenddatechkedit", function(value, element) {
	var return_first = function () {
    var tmp = null;
	    $.ajax({
			url    : 'tablestartenddate',
			type   : 'POST',
			datatype : 'JSON',
			data   : {'dbfromdt': $("#db_fromdt").val() ,'dbtodt': $("#db_todt").val() ,'masterCode':$("#mstcode").val(),'code': $("#code").val(),'bunruicd':$('input[name=bunruicd]:checked').val(),'fromdt': $("#fromdt").val(),'todt': $("#todt").val() },
			async: false,
			success : function(data){
				tmp = data.replace(/\"/g, '');
			}
		});
	    return tmp;
	}();
	if(return_first != 0) {
		if(return_first == 1) {
			$(".errorft").html("");
			$(".errorft").html("既に登録済みのデータが適用期間外となるような期間に変更はできません。");
		}
		return false;
	} else {
		$(".errorft").html("");
		return true;
	}
});
jQuery.validator.addMethod("notzero", function(value, element) {
	if( value != 0 ) { return true; } else { return false; }
});
jQuery.validator.addMethod("mailvalidation",function(value, element) {
	return this.optional(element) || value.match(/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/);
});
jQuery.validator.addMethod("specialChar",function(value, element) {
	return this.optional(element) || value.match(/^[a-zA-Z0-9-_.@]*$/);
});
(function($,W,D)
{
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#register").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					if(element.attr("name") == "fromdt" || element.attr("name") == "todt") {
						$(".date_errorft").html("");
						error.appendTo('.date_errorft');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					code: {
						required:true,
                		numbersOnly:true
					},
					meisho: {
						required:true
					},
					ryakusho: {
						required:true,
                		maxlength: 20
					},
					mailaddr: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					kmnm1: {
						required:true,
						maxlength: 20
					},
					kmnm2: {
						required:true,
						maxlength: 20
					},
					kmnm3: {
						required:true,
						maxlength: 20
					},
					kmnm4: {
						required:true,
						maxlength: 20
					},
					fromdt: {
						required:true,
						dateFormat:true,
						startdatechk:true
					},
					todt: {
						dateFormat: true,
						lessThan: '[name="fromdt"]'
					},
					hyojino: {
						required:true,
						numbersOnly:true,
						notzero:true,
                		maxlength: 3
					}
				},
				messages: {
					code: {
						required:"コードが未入力です。",
						numbersOnly:"数値を入力してください。"
					},
					meisho: {
						required:"名称が未入力です。"
					},
					ryakusho: {
						required:"略称が未入力です。",
                		maxlength: "最大文字数を超えています。"
					},
					mailaddr:{
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm1: {
						required:"項目名称１が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm2: {
						required:"項目名称２が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm3: {
						required:"項目名称３が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm4: {
						required:"項目名称４が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					fromdt: {
						required:"適用開始日が不正な形式です。",
						dateFormat: "日付が不正な形式です。",
						startdatechk:""
					},
					todt: {
						dateFormat: "日付が不正な形式です。",
						lessThan: "「適用終了日」は「適用開始日」以降の日付を指定してください。"
					},
					hyojino: {
						required:"表示順が未入力です。",
						numbersOnly:"数値を入力してください。",
						notzero:"有効な表示順を入力してください。",
                		maxlength: "最大文字数を超えています。"
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
									$('#register').attr('target', '');
									$('#register').attr('action', '../AdminMaster/register');
									$('.b-release').prop('disabled', true);
									var data = new FormData();
									var serializedData = $("#register").serialize();
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
														 		$('.b-release').prop('disabled', false);
																$("#bunruicd1").prop('checked', true);
																$( "#code" ).val('');
																$( "#meisho" ).val('');
																$( "#ryakusho" ).val('');
																$( "#mailaddr" ).val('');
																$( "#kmnm1" ).val('');
																$( "#kmnm2" ).val('');
																$( "#kmnm3" ).val('');
																$( "#kmnm4" ).val('');
																$( "#fromdt" ).val('');
																$( "#todt" ).val('');
																$( "#hyojino" ).val('');
															}
														}
													}
												});
											} else {
												$.confirm({
													title: '',
													content: INSERT_FAILURE,
													type: 'blue',
													buttons: {
														OK: {
															btnClass: 'btn-blue',
															keys: ['enter']																
														}
													}
												});
											}
										} else {
											var allErrArr = xhr.responseText.split("$$");
									 		var focusArea ="";
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

(function($,W,D)
{
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#update").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					if(element.attr("name") == "fromdt" || element.attr("name") == "todt") {
						$(".date_errorft").html("");
						error.appendTo('.date_errorft');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					code: {
						required:true,
                		numbersOnly:true
					},
					meisho: {
						required:true
					},
					ryakusho: {
						required:true,
						maxlength: 20
					},
					mailaddr: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					kmnm1: {
						required:true,
						maxlength: 20
					},
					kmnm2: {
						required:true,
						maxlength: 20
					},
					kmnm3: {
						required:true,
						maxlength: 20
					},
					kmnm4: {
						required:true,
						maxlength: 20
					},
					fromdt: {
						required:true,
						dateFormat: true,
						startdatechkedit:true,
						startenddatechkedit:true
					},
					todt: {
						dateFormat: true,
						lessThan: '[name="fromdt"]',
						startenddatechkedit:true
					},
					hyojino: {
						required:true,
						numbersOnly:true,
						notzero:true,
                		maxlength: 3
					}
				},
				messages: {
					code: {
						required:"コードが未入力です。",
						numbersOnly:"数値を入力してください。"
					},
					meisho: {
						required:"名称が未入力です。"
					},
					ryakusho: {
						required:"略称が未入力です。",
                		maxlength: "最大文字数を超えています。"
					},
					mailaddr:{
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm1: {
						required:"項目名称１が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm2: {
						required:"項目名称２が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm3: {
						required:"項目名称３が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kmnm4: {
						required:"項目名称４が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					fromdt: {
						required:"適用開始日が不正な形式です。",
						dateFormat: "日付が不正な形式です。",
						startdatechkedit:"",
						startenddatechkedit:""
					},
					todt: {
						dateFormat: "日付が不正な形式です。",
						lessThan: "「適用終了日」は「適用開始日」以降の日付を指定してください。",
						startenddatechkedit:""
					},
					hyojino: {
						required:"表示順が未入力です。",
						numbersOnly:"数値を入力してください。",
						notzero:"有効な表示順を入力してください。",
                		maxlength: "最大文字数を超えています。"
					}
				},
				submitHandler: function(form) {
					$.confirm({
						title: '',
						content: UPDATE_CONFIRM,
						type: 'blue',
						buttons: {
							OK: {
								action: function(){
									$("#updatecls").addClass('updatecls');
									$('#update').attr('target', '');
									$('#update').attr('action', '../AdminMaster/update');
									$('.e-release').prop('disabled', true);
									var data = new FormData();
									var serializedData = $("#update").serialize();
									serializedData = decodeURIComponent(serializedData);
									data.append('otherFields', serializedData);
									var xhr = new XMLHttpRequest();
								 	xhr.open('POST', 'update', true);
								 	xhr.send(data);
								 	xhr.onload = function () {
								 		// alert(xhr.responseText);
								    	$("#updatecls").removeClass('updatecls');
									 	if(xhr.responseText == "1") {
									 		if (xhr.status === 200) {
									 			$.confirm({
													title: '',
													content: UPDATE_SUCCESS,
													type: 'blue',
													buttons: {
														OK: {
															btnClass: 'btn-blue',
															keys: ['enter'],
															action: function(){
																$( "#ModoruFrm" ).submit();
															}
														}
													}
												});
											} else {
												$.confirm({
													title: '',
													content: UPDATE_FAILURE,
													type: 'blue',
													buttons: {
														OK: {
															btnClass: 'btn-blue',
															keys: ['enter']																
														}
													}
												});
											}
										} else {
											var allErrArr = xhr.responseText.split("$$");
									 		var focusArea ="";
									 		allErrArr.forEach(function(errArr) {
									 			var err = errArr.split("##");
									 			focusArea = err[0];
									 		   $("."+err[0]).html(err[1]);
									 		});
									 		$("#"+focusArea).focus();
									 		$('.e-release').prop('disabled', false);
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

function checkdate(value) {
	var check = "";
	var re = /^(\d{4})\/(\d{1,2})\/(\d{1,2})$/;
	if( re.test(value)) {
		var adata = value.split('/');
		var yyyy = parseInt(adata[0],10);
		var mm = parseInt(adata[1],10);
		var dd = parseInt(adata[2],10);
		var xdata = new Date(yyyy,mm-1,dd);
		if ( ( xdata.getFullYear() === yyyy ) && ( xdata.getMonth () === mm - 1 ) && ( xdata.getDate() === dd ) ) {
			check = value;
		} else {
			check = "";
		}
	} else {
		check = "";
	}
	if(value == "") {
		check = value;
	}
	return check;
}