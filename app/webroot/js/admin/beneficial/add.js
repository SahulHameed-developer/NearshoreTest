$(document).ready(function() {
	// 初期表示で非公開が選択処理
	$("#koukaikbn_r1").attr('checked', 'checked');
	// 公開区分項目の設定、有益登録権限　=　"1"［権限あり］ 有益公開権限　=　"0"［権限なし］の場合
	if($("#yuekitouroku").val()=='1' && $("#yuekikoukai").val()=='0' && $("#kanrikbnhdn").val() < SYS_KANRISHA){
		$("#koukaikbn_r1").attr('checked', 'checked');
		$('#koukaikbn_r0').attr('disabled', 'disabled');
	}
	// 初期表示に画像選択で、画像タイトル
	$('#syasin1Title').attr('disabled', 'disabled');
	$('#syasin2Title').attr('disabled', 'disabled');
	$('#syasin3Title').attr('disabled', 'disabled');
	// 初期表示に画像選択で、リセット
	$('.rstSyasin1').prop('disabled', true);
	$('.rstSyasin2').prop('disabled', true);
	$('.rstSyasin3').prop('disabled', true);
	// 初期表示にファイル選択で、ファイルタイトル
	$('#file1Title').attr('disabled', 'disabled');
	$('#file2Title').attr('disabled', 'disabled');
	$('#file3Title').attr('disabled', 'disabled');
	// 初期表示にファイル選択で、リセット
	$('.rstFile1').prop('disabled', true);
	$('.rstFile2').prop('disabled', true);
	$('.rstFile3').prop('disabled', true);
	// 写真1
	$( "#syasin1" ).change(function() {
		$('#syasin1Title').removeAttr('disabled');
		$('.rstSyasin1').prop('disabled', false);
		$(".syasin2Title").html("");
		if($("#syasin1").val() !="") {
			var iSize = ($("#syasin1")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin1").val("");
				$("#syasin1Path").val("");
				$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				$("#syasin1dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				$("#syasin1Title").val("");
				$('#syasin1Title').attr('disabled', 'disabled');
				$('.rstSyasin1').prop('disabled', true);
				$(".syasin1Title").html("");
			} else {
				$("#syasin1dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin1Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum01").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真2
	$( "#syasin2" ).change(function() {
		$('#syasin2Title').removeAttr('disabled');
		$('.rstSyasin2').prop('disabled', false);
		$(".syasin2Title").html("");
		if($("#syasin2").val() !="") {
			var iSize = ($("#syasin2")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin2").val("");
				$("#syasin2Path").val("");
				$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				$("#syasin2dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				$("#syasin2Title").val("");
				$('#syasin2Title').attr('disabled', 'disabled');
				$('.rstSyasin2').prop('disabled', true);
				$(".syasin2Title").html("");
			} else {
				$("#syasin2dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin2Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum02").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真3
	$( "#syasin3" ).change(function() {
		$('#syasin3Title').removeAttr('disabled');
		$('.rstSyasin3').prop('disabled', false);
		$(".syasin3Title").html("");
		if($("#syasin3").val() !="") {
			var iSize = ($("#syasin3")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin3").val("");
				$("#syasin3Path").val("");
				$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				$("#syasin3dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				$("#syasin3Title").val("");
				$('#syasin3Title').attr('disabled', 'disabled');
				$('.rstSyasin3').prop('disabled', true);
				$(".syasin3Title").html("");
			} else {
				$("#syasin3dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin3Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum03").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 添付ファイル1
	$( "#file1" ).change(function() {
		$('#file1Title').removeAttr('disabled');
		$('.rstFile1').prop('disabled', false);
		$(".file1Title").html("");
		if($("#file1").val() !="") {
			var iSize = ($("#file1")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file1").val("");
				$("#file1Path").val("");
				$("#file1dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				$("#file1Title").val("");
				$('.rstFile1').prop('disabled', true);
				$('#file1Title').attr('disabled', 'disabled');
				$(".file1Title").html("");
			} else {
				$("#file1dd").html("");
			}
		}
		if(this.value !="") {
			$("#file1Path").val(this.value);
		}
	});
	// 添付ファイル2
	$( "#file2" ).change(function() {
		$('#file2Title').removeAttr('disabled');
		$('.rstFile2').prop('disabled', false);
		$(".file2Title").html("");
		if($("#file2").val() !="") {
			var iSize = ($("#file2")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file2").val("");
				$("#file2Path").val("");
				$("#file2dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				$("#file2Title").val("");
				$('.rstFile2').prop('disabled', true);
				$('#file2Title').attr('disabled', 'disabled');
				$(".file2Title").html("");
			} else {
				$("#file2dd").html("");
			}
		}
		if(this.value !="") {
			$("#file2Path").val(this.value);
		}
	});
	// 添付ファイル3
	$( "#file3" ).change(function() {
		$('#file3Title').removeAttr('disabled');
		$('.rstFile3').prop('disabled', false);
		$(".file3Title").html("");
		if($("#file3").val() !="") {
			var iSize = ($("#file3")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file3").val("");
				$("#file3Path").val("");
				$("#file3dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				$("#file3Title").val("");
				$('.rstFile3').prop('disabled', true);
				$('#file3Title').attr('disabled', 'disabled');
				$(".file3Title").html("");
			} else {
				$("#file3dd").html("");
			}
		}
		if(this.value !="") {
			$("#file3Path").val(this.value);
		}
	});
	// 写真1のリセット
	$(".rstSyasin1").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin1Path").val("");
						$("#syasin1dd").html("");
						$("#syasin1Title").val("");
						$("#syasin1").val("");
						$('#syasin1Title').attr('disabled', 'disabled');
						$('.rstSyasin1').prop('disabled', true);
						// $("label[for='syasin1Title']").empty();
						$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin1Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真2のリセット
	$(".rstSyasin2").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin2Path").val("");
						$("#syasin2dd").html("");
						$("#syasin2Title").val("");
						$("#syasin2").val("");
						$('#syasin2Title').attr('disabled', 'disabled');
						$('.rstSyasin2').prop('disabled', true);
						// $("label[for='syasin2Title']").empty();
						$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin2Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真3のリセット
	$(".rstSyasin3").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin3Path").val("");
						$("#syasin3Title").val("");
						$("#syasin3").val("");
						$("#syasin3dd").html("");
						$('#syasin3Title').attr('disabled', 'disabled');
						$('.rstSyasin3').prop('disabled', true);
						// $("label[for='syasin3Title']").empty();
						$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin3Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 添付ファイル1のリセット
	$(".rstFile1").click(function () {
		$.confirm({
			title: '',
			content: 'ファイルファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			boxWidth: '310px',
   	 		useBootstrap: false,
			buttons: {
				OK: {
					action: function(){
						$("#file1Path").val("");
						$("#file1Title").val("");
						$("#file1").val("");
						$("#file1dd").html("");
						$('.rstFile1').prop('disabled', true);
						// $("label[for='file1Title']").empty();
						$('#file1Title').attr('disabled', 'disabled');
						$(".file1Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 添付ファイル2のリセット
	$(".rstFile2").click(function () {
		$.confirm({
			title: '',
			content: 'ファイルファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			boxWidth: '310px',
   	 		useBootstrap: false,
			buttons: {
				OK: {
					action: function(){
						$("#file2Path").val("");
						$("#file2Title").val("");
						$("#file2").val("");
						$("#file2dd").html("");
						$('.rstFile2').prop('disabled', true);
						// $("label[for='file2Title']").empty();
						$('#file2Title').attr('disabled', 'disabled');
						$(".file2Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 添付ファイル3のリセット
	$(".rstFile3").click(function () {
		$.confirm({
			title: '',
			content: 'ファイルファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			boxWidth: '310px',
   	 		useBootstrap: false,
			buttons: {
				OK: {
					action: function(){
						$("#file3Path").val("");
						$("#file3Title").val("");
						$("#file3").val("");
						$("#file3dd").html("");
						$('.rstFile3').prop('disabled', true);
						// $("label[for='file3Title']").empty();
						$('#file3Title').attr('disabled', 'disabled');
						$(".file3Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
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
	// 写真1のアップロード
	$(".syasin1btn").click(function () {
		$("#syasin1").click();
	});
	// 写真2のアップロード
	$(".syasin2btn").click(function () {
		$("#syasin2").click();
	});
	// 写真3のアップロード
	$(".syasin3btn").click(function () {
		$("#syasin3").click();
	});
	// 添付ファイル1のアップロード
	$(".file1btn").click(function () {
		$("#file1").click();
	});
	// 添付ファイル2のアップロード
	$(".file2btn").click(function () {
		$("#file2").click();
	});
	// 添付ファイル3のアップロード
	$(".file3btn").click(function () {
		$("#file3").click();
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
	$(".b-preview").click(function () {
		$('#previewflg').val('1');
		$('#adminBeneficialregister').submit();
	});
	$(".b-release").click(function(){
		$('#previewflg').val('0');
		$('#adminBeneficialregister').submit();
	});
});
jQuery.validator.addMethod("zenkaku", function(value, element) {
	 return this.optional(element) || /^[^ -~｡-ﾟ]*$/.test(value);
});
jQuery.validator.addMethod("imgval1", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		if ($.inArray(lastChar, fileExtension) == -1) {
	    	$("#syasin1Path").val("");
			$("#syasin1Title").val("");
			$("#syasin1").val("");
			$('#syasin1Title').attr('disabled', 'disabled');
			$('.rstSyasin1').prop('disabled', true);
			$("label[for='syasin1Title']").empty();
			$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval2", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	$("#syasin2Path").val("");
			$("#syasin2Title").val("");
			$("#syasin2").val("");
			$('#syasin2Title').attr('disabled', 'disabled');
			$('.rstSyasin2').prop('disabled', true);
			$("label[for='syasin2Title']").empty();
			$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval3", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	$("#syasin3Path").val("");
			$("#syasin3Title").val("");
			$("#syasin3").val("");
			$('#syasin3Title').attr('disabled', 'disabled');
			$('.rstSyasin3').prop('disabled', true);
			$("label[for='syasin3Title']").empty();
			$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
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
//入力値の検証
(function($,W,D)
{
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#adminBeneficialregister").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					$(".yuekidate").html("");
					$(".yuekitime").html("");
					$(".kaiinnm").html("");
					$(".title").html("");
					$(".naiyo").html("");
					$(".sankourl").html("");
					$(".syasin1Title").html("");
					$(".syasin2Title").html("");
					$(".syasin3Title").html("");
					$(".file1Title").html("");
					$(".file2Title").html("");
					$(".file3Title").html("");
					if(element.attr("name") == "syasin1Path" || element.attr("name") == "syasin2Path" || element.attr("name") == "syasin3Path"
						  || element.attr("name") == "syasin1" || element.attr("name") == "syasin2" || element.attr("name") == "syasin3") {
						error.appendTo( element.parent("div").next("div") );
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					// 有益日付
					yuekidate: {
						required:true,
						dateFormat: true
					},
					// 有益時刻
					yuekitime: {
						required:true,
						timeLength:true,
						timeformat: true
					},
					// 有益情報提供会員
					kaiinnm: {
						required:true,
						maxlength: 40,
						withTwoStrings: true,
					},
					// 有益タイトル
					title: {
						required:true,
						maxlength: 100
					},
					// 有益内容
					naiyo: {
						required:true,
						maxlength: 1024
					},
					//全角のみ
					syasin1Title: {
						zenkaku:true,
						maxlength: 60
					},
					syasin2Title: {
						zenkaku:true,
						maxlength: 60
					},
					syasin3Title: {
						zenkaku:true,
						maxlength: 60
					},
					file1Title: {
						zenkaku:true,
						maxlength: 60
					},
					file2Title: {
						zenkaku:true,
						maxlength: 60
					},
					file3Title: {
						zenkaku:true,
						maxlength: 60
					},
					syasin1Path: "imgval1",
					syasin2Path: "imgval2",
					syasin3Path: "imgval3",
					sankourl: {
						url: true,
						maxlength: 512
					},
				},
				messages: {
					// 有益日付
					yuekidate: {
						required:"日付を入力してください。",
						dateFormat: "日付が不正な形式です。"
					},
					// 有益時刻
					yuekitime: {
						required:"時刻を入力してください。",
						timeLength:"時間が不正な形式です。",
						timeformat: "時間が不正な形式です。"
					},
					// 有益情報提供会員
					kaiinnm: { 
						required:"会員名称が未入力です",
						maxlength: "最大文字数を超えています。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。"
					},
					// 有益タイトル）
					title: { 
						required:"タイトルを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					// 有益内容
					naiyo: { 
						required:"内容を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					//全角のみ
					syasin1Title: {
						zenkaku:"全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasin2Title: {
						zenkaku:"全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasin3Title: {
						zenkaku:"全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					file1Title: {
						zenkaku:"全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					file2Title: {
						zenkaku:"全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					file3Title: {
						zenkaku:"全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasin1Path : "画像しか入力できません。画像を入力してください。",
					syasin2Path : "画像しか入力できません。画像を入力してください。",
					syasin3Path : "画像しか入力できません。画像を入力してください。",
					sankourl: {
						url: "正しいURLを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
				},
				submitHandler: function(form) {
					if($('#previewflg').val() == 1 ) {
						$('#adminBeneficialregister').attr('target', '_blank');
						$('#adminBeneficialregister').attr('action', '../Beneficial/detail');
						$('#previewflg').val('0');
						form.submit();
					} else {
						if($('input[name=koukaikbn]:checked').val() == 1) {
							fnAddProcess(form);
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
											fnAddProcess(form);
										}
									},
									送信しない: function () {
										$('#hdn_soushin').val(0);
										fnAddProcess(form);
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

function fnAddProcess(form) {
	$.confirm({
		title: '',
		content: INSERT_CONFIRM,
		type: 'blue',
		buttons: {
			OK: {
				action: function(){
					$("#registercls").addClass('registercls');
                	$('.b-release').prop('disabled', true);
					$('#adminBeneficialregister').attr('target', '');
					$('#adminBeneficialregister').attr('action', '../AdminBeneficial/register');
					var data = new FormData();
					var serializedData = $("#adminBeneficialregister").serialize();
					serializedData = decodeURIComponent(serializedData);
					data.append('syasin1', $("#syasin1").get(0).files[0]);
					data.append('syasin2', $("#syasin2").get(0).files[0]);
					data.append('syasin3', $("#syasin3").get(0).files[0]);
					data.append('file1', $("#file1").get(0).files[0]);
					data.append('file2', $("#file2").get(0).files[0]);
					data.append('file3', $("#file3").get(0).files[0]);
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
												$( "#menuFrm" ).attr('action', '../adminBeneficial/add');
												$( "#menuFrm" ).submit();
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
											keys: ['enter']																	
										}
									}
								});
					 		var allErrArr = xhr.responseText.split("$$");
					 		var focusArea ="";
					 		$(".yuekidate").html("");
							$(".yuekitime").html("");
							$(".kaiinnm").html("");
							$(".title").html("");
							$(".naiyo").html("");
							$(".sankourl").html("");
							$(".syasin1Title").html("");
							$(".syasin2Title").html("");
							$(".syasin3Title").html("");
							$(".file1Title").html("");
							$(".file2Title").html("");
							$(".file3Title").html("");
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