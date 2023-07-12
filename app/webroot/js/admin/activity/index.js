$(document).ready(function() {
	if ($("#bunruicdhdn").val() == "1" || $("#bunruicdhdn").val() == "") {
		$("#bunruicd1").attr('checked', 'checked');
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
		$("#taishoukbn1").prop('checked', true);
		$('#taishoukbn2').attr('disabled', 'disabled');
	}
	if ($("#taisyoukbnhdn").val() == "1") {
		$("#taishoukbn2").prop('checked', true);
	} else {
		$("#taishoukbn1").prop('checked', true);
	}
	// 初期表示で非公開が選択処理
	/*if ($("#koukaikbnhdn").val() == "0") {
		$("#koukaikbn-0").attr('checked', 'checked');
	} else {
		$("#koukaikbn-1").attr('checked', 'checked');
	}*/
	// 公開区分項目の設定、お知らせ登録権限　=　"1"［権限あり］ お知らせ公開権限　=　"0"［権限なし］の場合
	if($("#registerKcaltourokuhdn").val()=='1' && $("#registerKcalkoukaihdn").val()=='0' && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
		$('input[name="koukaikbn"]').attr('disabled', 'disabled');
	} else {
		$("#koukaikbn-1").attr('checked', 'checked');
	}
	$(".b-preview").click(function() {
		$('#previewflg').val('1');
		$('#hdn_arno').val('');
		$('#register').submit();
	});
	$(".b-release").click(function() {
		$('#previewflg').val('0');
		$('#register').submit();
	});
	$('#teiin').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	var clicks = new Array();
	if($("#bunruicdhdn").val() == "") {
		clicks[0] = 1;
	} else {
		clicks[0] = $("#bunruicdhdn").val();
	}
	$('input[type=radio][name=bunruicd]').change(function() {
		clicks.push($(this).val());
		$('#hiddenradio_previous').val(clicks[clicks.length-2]);
		var selectedVal=this.value;
		$.confirm({
			title: '',
			content: '入力内容がクリアされますが、<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						sendAjaxRequest(selectedVal);
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
						if ($("#hdn_arno").val() == "") {
							$('#sosikicd').val('');
							$('#kbunruicd').val('');
							$('#kaisaidate').val('');
							$('#kaisaitmfrom').val('');
							$('#kaisaitmto').val('');
							$('#hyoudai').val('');
							$('#meisyou').val('');
							$('#basyo').val('');
							$('#naiyou').val('');
							$('#naiyou').val('');
							$('#gidai').val('');
							$('#kousi').val('');
							$('#taisyou').val('');
							$('#teiin').val('');
							$('#teiincom').val('');
							$('#hiyou').val('');
							$('#syugoubasyo').val('');
							$('#kigendate').val('');
							$('#kigentm').val('');
							$('#bikou').val('');
						}
					}
				},
				キャンセル: function () {
					// 会員区分「会員 」の場合
					var radchk = $('#hiddenradio_previous').val();
					$("#bunruicd"+radchk).prop('checked', true);
					clicks.pop(radchk);
				}
			}
		});
	});
	$('.backpage').click(function() {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						if ($("#hdn_arno").val() != "") {
							$('#katsudoModoruFrm').attr('action', '../AdminActivity/search');
						}
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
						$('#katsudoModoruFrm').submit();
					}
				},
				キャンセル: function () {
					
				}
			}
		});
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
				if(value.length < 5){
					return false;
				} 
			}
			return true;
});
jQuery.validator.addMethod("timeformat", function(value, element) {
		return this.optional(element) || value.match(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/);
});
jQuery.validator.addMethod("greaterThan", function(value) {
	if(value=='') { 
		return true;
	} else {
		if(new Date() >= new Date(value)) { return false; } 
	}
	return true;
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
				$("#register").validate({
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
							// ,
							// greaterThan: true
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
							dateFormat: "日付が不正な形式です。",
							greaterThan: "日付を正に入力してください。"
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
						if($('#previewflg').val() == 1 ){
							// if(!$('#bunruicd1').is(":checked") && $('#previewflg').val() == 1) {
								$('#register').attr('target', '_blank');
								if($('#bunruicd1').is(":checked")) {
									$('#register').attr('action', '../activity/Kaigidetail');
								} else {
									$('#register').attr('action', '../activity/detail');
								}
								// $('#register').attr('action', '../activity/detail');
								form.submit();
							// }
							$('#previewflg').val('0');
						} else {
							if($('input[name=koukaikbn]:checked').val() == 1) {
								fnAddCopyProcess(form);
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
												fnAddCopyProcess(form);
											}
										},
										送信しない: function () {
											$('#hdn_soushin').val(0);
											fnAddCopyProcess(form);
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
	if(timeLength == 1) {
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
		} else {
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
	} else if(timeLength == 4) {
		h = inputTime.substr(0,2);
		colon = inputTime.substr(2,1);
		m = inputTime.substr(3,1);
		if (h >= 0 && h < 24 && colon == ":") {
			outTime = "0" + h + ":" +m;
		} else {
			outTime = "";
		}
		if(m >= 0 && m < 6) {
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
	if(timeLength >= 5 ) {
		if(nextObjId != "") {
			var toTime = document.getElementById(nextObjId);
			if(toTime.value == "") {
				toTime.value = String.fromCharCode(evt.charCode);
			}
			toTime.focus();
		}
		return false;
	}
	document.getElementById(timeId).value = outTime;
	return true;
}

function fnAddCopyProcess(form) {
	$.confirm({
		title: '',
		content: INSERT_CONFIRM,
		type: 'blue',
		buttons: {
			OK: {
				action: function(){
					$('input[name="koukaikbn"]').removeAttr('disabled');
					$("#registercls").addClass('registercls');
					$('#register').attr('target', '');
					$('#register').attr('action', '../adminActivity/register');
					$('.b-release').prop('disabled', true);
					// form.submit();
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
												if ($("#hdn_arno").val() != "") {
													$('#katsudoModoruFrm').attr('action', '../AdminActivity/search');
													$( "#katsudoModoruFrm" ).submit();
												} else {
													$( "#stayaddFrm" ).submit();
												}
											}
										}
									}
								});
							} else {
								window.location = "../Error/systemError";
							}
						} else if (xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200 ){
							window.location = "../Error/systemError";
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
							var allErrArr = xhr.responseText.split("$$");
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
					};
				}
			},
			キャンセル: function () {
			}
		}
	});
}