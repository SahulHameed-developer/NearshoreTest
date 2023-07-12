$(document).ready(function() {
	$('#naiyoufield').hide();
	$('#kousifield').hide();
	$('#taisyoufield').hide();
	$('#teiincommentfield').hide();
	$('#teiinfield').hide();
	$('#hiyoufield').hide();
	$('#syugoubasyofield').hide();
	$('#kigendatefield').hide();
	$('#kigentmfield').hide();
	$('#bikoufield').hide();
	// $('#preview').hide();
	if($('#hdn_bunruicd').val() == 1) {
		$('#naiyoufield').hide();
		$('#kousifield').hide();
		$('#taisyoufield').hide();
		$('#teiincommentfield').hide();
		$('#teiinfield').hide();
		$('#hiyoufield').hide();
		$('#syugoubasyofield').hide();
		$('#kigendatefield').hide();
		$('#kigentmfield').hide();
		$('#bikoufield').hide();
		$('#gidaifield').show();
		$('#taishoukbn2').attr('disabled', 'disabled');
		// $('#preview').hide();
	// 会員区分「非会員 」の場合
	} else {
		$('#naiyoufield').show();
		$('#kousifield').show();
		$('#taisyoufield').show();
		$('#teiincommentfield').show();
		$('#teiinfield').show();
		$('#hiyoufield').show();
		$('#syugoubasyofield').show();
		$('#kigendatefield').show();
		$('#kigentmfield').show();
		$('#bikoufield').show();
		$('#gidaifield').hide();
		$('#taishoukbn2').removeAttr('disabled');
		// $('#preview').show();
	}
	var koukaikbnhdn = $("#koukaikbnhdn").val();
	var bunruicdhdn = $("#bunruicdhdn").val();
	var taisyoukbnhdn = $("#taisyoukbnhdn").val();
	var kbunruicdhdn = $("#kbunruicdhdn").val();
	if($("#updateKcaltourokuhdn").val()=='1' && $("#updateKcalkoukaihdn").val()=='0' && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
		$('input[name="koukaikbn"]').attr('disabled', 'disabled');
	}
	if($("#updateKcaltourokuhdn").val()=='0' && $("#updateKcalkoukaihdn").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
		$('input[name="bunruicd"]').attr('disabled', 'disabled');
		$('input[name="taishoukbn"]').attr('disabled', 'disabled');
	    $("#sosikicd").attr('disabled', 'disabled');
	    $("#kbunruicd").attr('disabled', 'disabled');
		$('#kaisaidate').attr('disabled', 'disabled');
		$('#kaisaitmfrom').attr('disabled', 'disabled');
		$('#kaisaitmto').attr('disabled', 'disabled');
		$('#hyoudai').attr('disabled', 'disabled');
		$('#meisyou').attr('disabled', 'disabled');
		$('#basyo').attr('disabled', 'disabled');
		$('#naiyou').attr('disabled', 'disabled');
		$('#naiyou').attr('disabled', 'disabled');
		$('#gidai').attr('disabled', 'disabled');
		$('#kousi').attr('disabled', 'disabled');
		$('#taisyou').attr('disabled', 'disabled');
		$('#teiin').attr('disabled', 'disabled');
		$('#teiincom').attr('disabled', 'disabled');
		$('#hiyou').attr('disabled', 'disabled');
		$('#syugoubasyo').attr('disabled', 'disabled');
		$('#kigendate').attr('disabled', 'disabled');
		$('#kigentm').attr('disabled', 'disabled');
		$('#bikou').attr('disabled', 'disabled');
		$("#mailcheck").attr("disabled", true);
	} else {
		$(".datepicker").datepicker();
	}
	$('input[type=radio][name=bunruicd]').change(function() {
		var reqUrl= $('input[name=bunruicd]:checked').val();
       	sendAjaxRequest(reqUrl);
		var selectedVal=this.value;
		// 会員区分「会員 」の場合
		if (selectedVal == '1') {
			$('#naiyoufield').hide();
			$('#kousifield').hide();
			$('#taisyoufield').hide();
			$('#teiincommentfield').hide();
			$('#teiinfield').hide();
			$('#hiyoufield').hide();
			$('#syugoubasyofield').hide();
			$('#kigendatefield').hide();
			$('#kigentmfield').hide();
			$('#bikoufield').hide();
			$('#gidaifield').show();
			$("#taishoukbn1").prop('checked', true);
			$('#taishoukbn2').prop('checked', false);
			$('#taishoukbn2').attr('disabled', 'disabled');
			// $('#preview').hide();
		// 会員区分「非会員 」の場合
		} else {
			$('#naiyoufield').show();
			$('#kousifield').show();
			$('#taisyoufield').show();
			$('#teiincommentfield').show();
			$('#teiinfield').show();
			$('#hiyoufield').show();
			$('#syugoubasyofield').show();
			$('#kigendatefield').show();
			$('#kigentmfield').show();
			$('#bikoufield').show();
			$('#gidaifield').hide();
			$("#taishoukbn1").prop('checked', true);
			$('#taishoukbn2').prop('checked', false);
			$('#taishoukbn2').removeAttr('disabled');
			// $('#preview').show();
		}
	});
	$('.backpage').click(function() {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$( "#katsudoModoruFrm" ).submit();
					}
				},
				キャンセル: function () {
					
				}
			}
		});
	});
	$('.backpage_head').click(function() {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$('#katsudoModoruFrm').attr('action', '../admin/home');
						$('#katsudoModoruFrm').submit();
					}
				},
				キャンセル: function () {
					
				}
			}
		});
	});
	$('#teiin').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	$(".b-preview").click(function() {
		$('#previewflg').val('1');
		$('#update').attr('target', '_blank');
		if($('#bunruicd1').is(":checked")) {
			$('#update').attr('action', '../activity/Kaigidetail');
		} else {
			$('#update').attr('action', '../activity/detail');
		}
		$('#update').submit();
	});
	$(".b-release").click(function() {
		$('#previewflg').val('0');
		$('#update').submit();
	});
});
function sendAjaxRequest(reqUrl) {
	$.ajax({
	 url    : 'byAjaxCheck',
	 type   : 'POST',
	 datatype : 'JSON',
	 data   : {'bunruicd': reqUrl},
	 async: false,
	 success : function(data) {
    	 data = JSON.parse(data);
    	 var count = Object.keys(data).length;
    	 jQuery('#kbunruicd').val('');
     	 jQuery('#kbunruicd').text('');
     	$('#kbunruicd').append( '<option value="">選択してください</option>' );
     	$.each(data , function(i, val) { 
    		 $("#kbunruicd").append('<option value="'+i+'">'+val+'</option>');
    	 });
       },
	 error : function(errorData) {
		 alert(errorData.status);
	 }
	});
}

function checkTimeValue(evt, timeId, nextObjId) {
	if (evt.charCode == 0 || evt.charCode == 120 || evt.charCode == 118 || evt.charCode == 99|| evt.charCode == 97) {
		return true;
	}
	if (!(evt.charCode >= 48 && evt.charCode <= 57)) return false;
	var inputTime = document.getElementById(timeId).value; 
	var timeLength = inputTime.length;  
	var outTime;  
	var h = "";  
	var m = "";  
	var colon;
	if (timeLength == 1) {
		h = inputTime.substr(0,1);
		if(h >= 0 && h < 3) {
			outTime = h;
		} else if(h > 2 && h < 10) {
			outTime = "0" + h + ":";
		} else {
			outTime = "";
		}
	} else if(timeLength == 2) {
		h = inputTime.substr(0,2);
		if (h >= 0 && h <=23) {
			outTime = h + ":";
		}else{
			outTime = "";
		}
	} else if(timeLength == 3) {
		h = inputTime.substr(0,2);
		colon = inputTime.substr(2,1);
		if (h >= 0 && h <=23 && colon == ":") {
			outTime = h + ":";
		} else {
			outTime = "";
		}
	} else if (timeLength == 4) {
		h = inputTime.substr(0,2);
		colon = inputTime.substr(2,1);
		m = inputTime.substr(3,1);
		if (h >= 0 && h < 24 && colon == ":") {
			outTime = "0" + h + ":" +m;
		} else {
			outTime = "";
		}
		if (m >= 0 && m < 6) {
			outTime = h + ":" + m;
		} else if(m >= 6 && m < 10) {
			m = inputTime.substr(3,1);
			h++;
			if (h >0 && h<10) {
				outTime = "0"+h + ":" + "0";
			} else {
				outTime = h + ":" + "0";
			}
		}
	} else if(timeLength == 5) {
		h = inputTime.substr(0,1);
		colon = inputTime.substr(2,1);
		m = inputTime.substr(3,2);
		if (h >= 0 && h < 24 && colon == ":") {
			outTime = "0" + h + ":" +m;
		} else {
			outTime = "";
		}
		if (m >= 0 && m < 60) {
			h++;
			outTime = h + m;
		} else {
			outTime = h + "";
		}
	} else {
		outTime = "";
	}
	if (timeLength >= 5 ) {
		if (nextObjId != "") {
			var toTime = document.getElementById(nextObjId);
			if (toTime.value == "") {
				toTime.value = String.fromCharCode(evt.charCode);
			}
			toTime.focus();
		}
		return false;
	}
	document.getElementById(timeId).value = outTime;
	return true;
}
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
				if(fromtime >= value){
					return false;
				} 
			}
			return true;
});
jQuery.validator.addMethod(
		"timeLength", 
		function(value) {
			if(value=='') {
				return true;
			} else {
				if(value.length < 5) {
					return false;
				} 
			}
			return true;
});
jQuery.validator.addMethod("timeformat", function(value, element) {
	return this.optional(element) || value.match(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/);
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
				$("#update").validate({
					onkeyup: false,
					errorPlacement: function(error, element) {
						$(".sosikicd").html("");
						$(".kbunruicd").html("");
						$(".kaisaidate").html("");
						$(".kaisaitmfrom").html("");
						$(".kaisaitmto").html("");
						$(".hyoudai").html("");
						$(".meisyou").html("");
						$(".basyo").html("");
						$(".naiyou").html("");
						$(".gidai").html("");
						$(".kousi").html("");
						$(".taisyou").html("");
						$(".teiin").html("");
						$(".teiincom").html("");
						$(".hiyou").html("");
						$(".syugoubasyo").html("");
						$(".bikou").html("");
						error.insertAfter(element);
					},
					rules: {
						// 期間（From）
						sosikicd: "required",
						// 期間（To）
						kbunruicd: "required",

						kaisaidate: {
							required:true,
							dateFormat: true
						},
						// 期間（From）
						kaisaitmfrom: {
							required:true,
							timeLength:true,
							timeformat: true
						},
						// 期間（to）
						kaisaitmto: {
							required:true,
							lessThan: '[name="kaisaitmfrom"]',
							timeLength:true,
							timeformat: true
						},
						kigentm: {
							timeLength:true,
							timeformat: true
						},
						hyoudai: {
							required:true,
							maxlength: 60
						},
						meisyou: {
							required:true,
							maxlength: 60
						},
						basyo: {
							maxlength: 100
						},
						naiyou: {
							maxlength: 1024
						},
						gidai: {
							maxlength: 255
						},
						kousi: {
							maxlength: 100
						},
						taisyou: {
							maxlength: 100
						},
						teiincom: {
							maxlength: 60
						},
						hiyou: {
							maxlength: 100
						},
						teiin: {
							range: [ -32768, 32767 ],
							maxlength: 5
						},
						syugoubasyo: {
							maxlength: 255
						},
						bikou: {
							maxlength: 1024
						},
						kigendate: "dateFormat"
					},
					messages: {
						// 期間（From）
						sosikicd: "組織を選択してください。",
						// 期間（To）
						kbunruicd: "活動分類を選択してください。",
						
						kaisaidate: { 
							required:"日付を入力してください。",
							dateFormat: "日付が不正な形式です。"
						},
						// 期間（From）
						kaisaitmfrom: { 
							required:"開始時間を入力してください。",
							timeLength: "開始時間が不正な形式です。",
							timeformat:"開始時間が不正な形式です。"
						},
						// 期間（to）
						kaisaitmto: { 
							required:"終了時間を入力してください。",
							lessThan:"期間のFrom、Toを正しく入力してください。",
							timeLength: "終了時間が不正な形式です。",
							timeformat:"終了時間が不正な形式です。"
						},
						kigentm: { 
							timeLength: "申込期限_時間が不正な形式です。",
							timeformat:"申込期限_時間が不正な形式です。"
						},
						hyoudai: {
							required:"表題を入力してください。",
							maxlength: "最大文字数を超えています。"
						},
						meisyou: {
							required:"名称を入力してください。",
							maxlength: "最大文字数を超えています。"
						},
						teiin: {
							range: "最大文字数を超えています。",
							maxlength: "最大文字数を超えています。"
						},
						basyo: {
							maxlength: "最大文字数を超えています。"
						},
						naiyou: {
							maxlength: "最大文字数を超えています。"
						},
						gidai: {
							maxlength: "最大文字数を超えています。"
						},
						kousi: {
							maxlength: "最大文字数を超えています。"
						},
						taisyou: {
							maxlength: "最大文字数を超えています。"
						},
						teiincom: {
							maxlength: "最大文字数を超えています。"
						},
						hiyou: {
							maxlength: "最大文字数を超えています。"
						},
						syugoubasyo: {
							maxlength: "最大文字数を超えています。"
						},
						bikou: {
							maxlength: "最大文字数を超えています。"
						},
						kigendate: "申込期限_日付が不正な形式です。"
					},
					submitHandler: function(form) {
						if($('#previewflg').val() == 1 ) {
							// if(!$('#bunruicd1').is(":checked")) {
								if($("#updateKcaltourokuhdn").val()=='0' && $("#updateKcalkoukaihdn").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
									$('#kaisaidate').attr('disabled', false);
									$('#kaisaitmfrom').attr('disabled', false);
									$('#kaisaitmto').attr('disabled', false);
									$('#hyoudai').attr('disabled', false);
									$('#meisyou').attr('disabled', false);
									$('#basyo').attr('disabled', false);
									$('#naiyou').attr('disabled', false);
									$('#naiyou').attr('disabled', false);
									$('#gidai').attr('disabled', false);
									$('#kousi').attr('disabled', false);
									$('#taisyou').attr('disabled', false);
									$('#teiin').attr('disabled', false);
									$('#teiincom').attr('disabled', false);
									$('#hiyou').attr('disabled', false);
									$('#syugoubasyo').attr('disabled', false);
									$('#kigendate').attr('disabled', false);
									$('#kigentm').attr('disabled', false);
									$('#bikou').attr('disabled', false);
									$("#sosikicd").attr('disabled', false);
								    $("#kbunruicd").attr('disabled', false);
								}
								form.submit();
								$('#previewflg').val('0');
								if($("#updateKcaltourokuhdn").val()=='0' && $("#updateKcalkoukaihdn").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
									$("#sosikicd").attr('disabled', 'disabled');
								    $("#kbunruicd").attr('disabled', 'disabled');
								    $('#kaisaidate').attr('disabled', 'disabled');
									$('#kaisaitmfrom').attr('disabled', 'disabled');
									$('#kaisaitmto').attr('disabled', 'disabled');
									$('#hyoudai').attr('disabled', 'disabled');
									$('#meisyou').attr('disabled', 'disabled');
									$('#basyo').attr('disabled', 'disabled');
									$('#naiyou').attr('disabled', 'disabled');
									$('#naiyou').attr('disabled', 'disabled');
									$('#gidai').attr('disabled', 'disabled');
									$('#kousi').attr('disabled', 'disabled');
									$('#taisyou').attr('disabled', 'disabled');
									$('#teiin').attr('disabled', 'disabled');
									$('#teiincom').attr('disabled', 'disabled');
									$('#hiyou').attr('disabled', 'disabled');
									$('#syugoubasyo').attr('disabled', 'disabled');
									$('#kigendate').attr('disabled', 'disabled');
									$('#kigentm').attr('disabled', 'disabled');
									$('#bikou').attr('disabled', 'disabled');
								}
							// }
						} else {
							if($('input[name=koukaikbn]:checked').val() == 1) {
								fnEditProcess(form);
							} else {
								$.confirm({
									title: '',
									content: "各会員へ更新通知メールを送信しますか？",
									type: 'blue',
									boxWidth: '304px',
									useBootstrap: false,
									buttons: {
										送信する: {
											action: function() {
												$('#hdn_soushin').val(1);
												fnEditProcess(form);
											}
										},
										送信しない: function () {
											$('#hdn_soushin').val(0);
											fnEditProcess(form);
										}
									}
								});
							}
							
						}
					}
				});
			}
		}
		$(D).ready(function($) {
			jqueryValidation.UTIL.setupFormValidation();
		});
	})(jQuery, window, document);

	function fnEditProcess(form) {
		$.confirm({
			title: '',
			content: UPDATE_CONFIRM,
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$('#kaisaidate').attr('disabled', false);
						$('#kaisaitmfrom').attr('disabled', false);
						$('#kaisaitmto').attr('disabled', false);
						$('#hyoudai').attr('disabled', false);
						$('#meisyou').attr('disabled', false);
						$('#basyo').attr('disabled', false);
						$('#naiyou').attr('disabled', false);
						$('#naiyou').attr('disabled', false);
						$('#gidai').attr('disabled', false);
						$('#kousi').attr('disabled', false);
						$('#taisyou').attr('disabled', false);
						$('#teiin').attr('disabled', false);
						$('#teiincom').attr('disabled', false);
						$('#hiyou').attr('disabled', false);
						$('#syugoubasyo').attr('disabled', false);
						$('#kigendate').attr('disabled', false);
						$('#kigentm').attr('disabled', false);
						$('#bikou').attr('disabled', false);
						$("#sosikicd").attr('disabled', false);
					    $("#kbunruicd").attr('disabled', false);
						$('#taishoukbn1').removeAttr('disabled');
						$('#taishoukbn2').removeAttr('disabled');
						$('input[name="koukaikbn"]').removeAttr('disabled');
						$('input[name="bunruicd"]').removeAttr('disabled');
						$('input[name="taishoukbn"]').removeAttr('disabled');
						$("#updatecls").addClass('updatecls');
						var request;
						var $inputs = $(form).find("input, select, button, textarea");
						var serializedData = $(form).serialize();
						$inputs.prop("disabled", true);
						request = $.ajax({
						        url: "update",
						        type: "post",
						        datatype : 'JSON',
						        data: serializedData
						});
						// callback handler that will be called on success
						request.done(function (response, textStatus, jqXHR) {
						 	if(response == "1") {
						   		// log a message to the console
								$.confirm({
									title: '',
									content: UPDATE_SUCCESS,
									type: 'blue',
									buttons: {
										OK: {
											btnClass: 'btn-blue',
											keys: ['enter'],
											action: function(){
												$( "#katsudoModoruFrm" ).submit();
											}
										}
									}
								});
							} else if(response == "SYSTEM_ERROR"){
								window.location = "../Error/systemError";
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
						    	$("#updatecls").removeClass('updatecls');
								var allErrArr = response.split("$$");
						 		var focusArea ="";
								$(".sosikicd").html("");
								$(".kbunruicd").html("");
								$(".kaisaidate").html("");
								$(".kaisaitmfrom").html("");
								$(".kaisaitmto").html("");
								$(".hyoudai").html("");
								$(".meisyou").html("");
								$(".basyo").html("");
								$(".naiyou").html("");
								$(".gidai").html("");
								$(".kousi").html("");
								$(".taisyou").html("");
								$(".teiin").html("");
								$(".teiincom").html("");
								$(".hiyou").html("");
								$(".syugoubasyo").html("");
								$(".bikou").html("");
						 		allErrArr.forEach(function(errArr) {
						 			var err = errArr.split("##");
						 			focusArea = err[0];
						 		   $("."+err[0]).html(err[1]);
						 		});
						 		$("#"+focusArea).focus();
						 		$('.b-release').prop('disabled', false);
							}
						});
						// callback handler that will be called on failure
						request.fail(function (jqXHR, textStatus, errorThrown) {
						    // log the error to the console
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
						});
					    // callback handler that will be called regardless
					    // if the request failed or succeeded
						request.always(function () {
					    	$("#updatecls").removeClass('updatecls');
						        // reenable the inputs
						        $inputs.prop("disabled", false);
						});
					}
				},
				キャンセル: function () {
				}
			}
		});
	}