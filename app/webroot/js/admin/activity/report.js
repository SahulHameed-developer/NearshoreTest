$(document).ready(function() {
	if(($("#khoutourokuhdn").val() != '1' || $("#khoukoukaihdn").val() != '1') && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
		$('#comment').attr('readonly','readonly');
		$('#syasin1Path').attr('readonly',true);
		$('#syasin2Path').attr('readonly',true);
		$('#syasin3Path').attr('readonly',true);
		$('#syasin1Title').attr('readonly',true);
		$('#syasin2Title').attr('readonly',true);
		$('#syasin3Title').attr('readonly',true);
		$('.rstSyasin1').attr('disabled','disabled');
		$('.rstSyasin2').attr('disabled','disabled');
		$('.rstSyasin3').attr('disabled','disabled');
		$('.syasin1btn').attr('disabled','disabled');
		$('.syasin2btn').attr('disabled','disabled');
		$('.syasin3btn').attr('disabled','disabled');
		$('input[name="koukaikbn"]').attr('disabled', 'disabled');
		$("#mailcheck").attr("disabled", true);
	}
	if($("#khoutourokuhdn").val()=='0' && $("#khoukoukaihdn").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
		$('input[name="bunruicd"]').attr('disabled', 'disabled');
		$('input[name="koukaikbn"]').removeAttr('disabled');
		$('input[name="scategory_radio"]').attr('disabled', 'disabled');
		$('#conference').attr('disabled', 'disabled');
		$('#kbunruicd').attr('disabled', 'disabled');
		$('#gidai').attr('disabled','disabled');
		$('#kaisaidate').attr('disabled','disabled');
		$('#kaisaitmfrom').attr('disabled','disabled');
		$('#kaisaitmto').attr('disabled','disabled');
		$('#hyoudai').attr('disabled','disabled');
		$('#meisyou').attr('disabled','disabled');
		$('#basyo').attr('disabled','disabled');
		$('#naiyou').attr('disabled','disabled'); 
		$('#kousi').attr('disabled','disabled');
		$('#taisyou').attr('disabled','disabled');
		$('#teiin').attr('disabled','disabled');
		$('#teiincom').attr('disabled','disabled');
		$('#hiyou').attr('disabled','disabled');
		$('#syugoubasyo').attr('disabled','disabled');
		$('#kigendate').attr('disabled','disabled');
		$('#kigentm').attr('disabled','disabled');
		$('#bikou').attr('disabled','disabled');
		$('#comment').attr('disabled','disabled');
		$('#syasin1Path').attr('disabled','disabled');
		$('#syasin2Path').attr('disabled','disabled');
		$('#syasin3Path').attr('disabled','disabled');
		$('#syasin1Title').attr('disabled','disabled');
		$('#syasin2Title').attr('disabled','disabled');
		$('#syasin3Title').attr('disabled','disabled');
		$('.rstSyasin1').attr('disabled','disabled');
		$('.rstSyasin2').attr('disabled','disabled');
		$('.rstSyasin3').attr('disabled','disabled');
		$('.syasin1btn').attr('disabled','disabled');
		$('.syasin2btn').attr('disabled','disabled');
		$('.syasin3btn').attr('disabled','disabled');
		$("#mailcheck").attr("disabled", true);
		$(".syasin1btn").css({"backgroundColor":"gray"});
		$(".syasin2btn").css({"backgroundColor":"gray"});
		$(".syasin3btn").css({"backgroundColor":"gray"});
		$(".rstSyasin1").css({"backgroundColor":"gray"});
		$(".rstSyasin2").css({"backgroundColor":"gray"});
		$(".rstSyasin3").css({"backgroundColor":"gray"});
	} else {
		$(".datepicker").datepicker();
	}
	if($("#khoutourokuhdn").val()=='1' && $("#khoukoukaihdn").val()=='0' && $("#kanrikbnhdn").val() < SYS_KANRISHA ) {
		$('input[name="koukaikbn"]').attr('disabled', 'disabled');
	}
	// イベントと会議の「流用」ボタン押下ので初期表示で非公開が選択処理
	if($("#divert").val() == 1) {
		$("#koukaikbn-1").attr('checked', 'checked');
	}
	$('#naiyoufield').hide();
	$('#kousifield').hide();
	$('#taisyoufield').hide();
	$('#teiinfield').hide();
	$('#hiyoufield').hide();
	$('#syugoubasyofield').hide();
	$('#kigendatefield').hide();
	$('#kigentmfield').hide();
	$('#bikoufield').hide();
	$('#teiincomfield').hide();
	$('#gidaifield').show();
	// $('#preview').hide();
	if($('#hdn_bunruicd').val() == 1) {
		$('#naiyoufield').hide();
		$('#kousifield').hide();
		$('#taisyoufield').hide();
		$('#teiinfield').hide();
		$('#hiyoufield').hide();
		$('#syugoubasyofield').hide();
		$('#kigendatefield').hide();
		$('#kigentmfield').hide();
		$('#bikoufield').hide();
		$('#teiincomfield').hide();
		$('#gidaifield').show();
		// $('#preview').hide();
	// 会員区分「非会員 」の場合
	} else {
		$('#naiyoufield').show();
		$('#kousifield').show();
		$('#taisyoufield').show();
		$('#teiinfield').show();
		$('#hiyoufield').show();
		$('#syugoubasyofield').show();
		$('#kigendatefield').show();
		$('#kigentmfield').show();
		$('#bikoufield').show();
		$('#gidaifield').hide();
		$('#teiincomfield').show();
		// $('#preview').show();
	}
	// 初期表示に画像選択で、画像タイトル
	if($("#urlsyasin1").val() == "") {
		$('#syasin1Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin2").val() == "") {
		$('#syasin2Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin3").val() == "") {
		$('#syasin3Title').attr('disabled', 'disabled');
	}
	// 初期表示に画像選択で、リセット
	if($("#urlsyasin1").val() == "") {
		$('.rstSyasin1').prop('disabled', true);
	}
	if($("#urlsyasin2").val() == "") {
		$('.rstSyasin2').prop('disabled', true);
	}
	if($("#urlsyasin3").val() == "") {
		$('.rstSyasin3').prop('disabled', true);
	}
	
	// 写真1
	$( "#syasin1" ).change(function() {
		$("#reset1").val('');
		$('#syasin1Title').removeAttr('disabled');
		$('.rstSyasin1').prop('disabled', false);
		if($("#syasin1").val() !="") {
			var iSize = ($("#syasin1")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin1").val("");
				$("#syasin1Path").val("");
				$("#thum01").attr('src', $("#image1").val());
				$("#syasin1dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image1").val() == "" ) {
					$("#syasin1Title").val("");
					$("#reset1").val('1');
					$("#image1").val("");
					$('#syasin1Title').attr('disabled', 'disabled');
					$('.rstSyasin1').prop('disabled', true);
					$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				}
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
		$("#reset2").val('');
		$('#syasin2Title').removeAttr('disabled');
		$('.rstSyasin2').prop('disabled', false);
		if($("#syasin2").val() !="") {
			var iSize = ($("#syasin2")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin2").val("");
				$("#syasin2Path").val("");
				$("#thum02").attr('src', $("#image2").val());
				$("#syasin2dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image2").val() == "" ) {
					$("#syasin2Title").val("");
					$("#reset2").val('1');
					$("#image2").val("");
					$('#syasin2Title').attr('disabled', 'disabled');
					$('.rstSyasin2').prop('disabled', true);
					$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				}
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
		$("#reset3").val('');
		$('#syasin3Title').removeAttr('disabled');
		$('.rstSyasin3').prop('disabled', false);
		if($("#syasin3").val() !="") {
			var iSize = ($("#syasin3")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin3").val("");
				$("#syasin3Path").val("");
				$("#thum03").attr('src', $("#image3").val());
				$("#syasin3dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image3").val() == "" ) {
					$("#syasin3Title").val("");
					$("#reset3").val('1');
					$("#image3").val("");
					$('#syasin3Title').attr('disabled', 'disabled');
					$('.rstSyasin3').prop('disabled', true);
					$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				}
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
	$(".b-release").click(function () {
		$('#previewflg').val('0');
		$("#reportedit").submit();
	});
	$(".menuBack").click(function () {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#adminActivityeditFrm").submit();
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
						$('#adminActivityeditFrm').attr('action', '../admin/home');
						$('#adminActivityeditFrm').submit();
					}
				},
				キャンセル: function () {
					
				}
			}
		});
	});
	$(".backtohome").click(function () {
		$("#backtohome").submit();
	});
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	$(".editpreview").click(function(){
		$('#previewflg').val('1');
		$('#reportedit').submit();
	});
	$(".add_2").click(function () {
		var arno = $(this).attr("data-arno");
		var syasinkey = $(this).attr("data-syasinkey");
		var divert = $(this).attr("data-divert");
		$("#adminActivityeditFrmArno").val(arno);
		$("#adminActivityeditFrmSyasinkey").val(syasinkey);
		$("#adminActivityeditFrmDivert").val(divert);
		$( "#adminActivityeditFrm" ).submit();
	});
	$(".edit").click(function () {
		var arno = $(this).attr("data-arno");
		var syasinkey = $(this).attr("data-syasinkey");
		$("#adminActivityeditFrmArno").val(arno);
		$("#adminActivityeditFrmSyasinkey").val(syasinkey);
		$("#adminActivityeditFrm" ).submit();
	});

	$(".attendanceReport").click(function () {
		$("#adminActivityAttendanceFrmArno").val($(this).attr("data-arno"));
		$("#adminActivityAttendanceFrmMeisyou").val($(this).attr("data-meisyou"));
		$("#adminActivityAttendanceFrmHdnBunruicd").val($(this).attr("data-hdn_bunruicd"));
		$("#adminActivityAttendanceFrm" ).submit();
	});

	$(".reportSakujo").click(function () {
		var arno = $(this).attr("data-arno");
		var syasinkey = $(this).attr("data-syasinkey");
		$.confirm({
			title: '',
			content: '削除を実行しますとデータがディスク上から消去されます。<br>削除してもよろしいですか？',
			columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						var data = new FormData();
						data.append('arno', arno);
						data.append('syasinKey', syasinkey);
						var xhr = new XMLHttpRequest();
					 	xhr.open('POST', 'delete', true);
					 	xhr.send(data);
					 	xhr.onload = function () {
				 		// $("#registercls").removeClass('registercls');
					 		if (xhr.responseText == "1" && xhr.status === 200) {
					 			$.confirm({
									title: '',
									content: DELETE_SUCCESS,
									type: 'blue',
									buttons: {
										OK: {
											btnClass: 'btn-blue',
											keys: ['enter'],
											action: function(){
												$('#report').submit();
											}
										}
									}
								});
							} else if (xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200 ){
								window.location="../Error/systemError";
							} else {
								$.confirm({
									title: '',
									content: DELETE_FAILURE,
									type: 'blue',
									buttons: {
										OK: {
											btnClass: 'btn-blue',
											keys: ['enter']																	
										}
									}
								});
								// $("#registercls").addClass('registercls');
							}
				 		};

						// $("#adminActivitydeleteFrmArno").val(arno);
						// $("#adminActivitydeleteFrmSyasinkey").val(syasinkey);
						// $("#adminActivitydeleteFrm").submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".kaigibtn").click(function () {
		$("#event").val('');
		$("#eventFrom").val('');
		$("#eventTo").val('');
		$("#searchcon").val('1');
	});
	$(".eventbtn").click(function () {
		$("#conference").val('');
		$("#kaigiFrom").val('');
		$("#kaigiTo").val('');
		$("#searchcon").val('2');
	});
	$('input[type=radio][name=bunruicd]').change(function() {
     	var reqUrl= $('input[name=bunruicd]:checked').val();
       	sendAjaxRequest(reqUrl);             
    });
	// 写真1のリセット
	$(".rstSyasin1").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$("#syasin1Path").val("");
						$("#syasin1Title").val("");
						$("#syasin1").val("");
						$("#syasin1dd").html("");
						$("#reset1").val('1');
						$("#image1").val("");
						$("#divrstsyashin1").val("");
						$('#syasin1Title').attr('disabled', 'disabled');
						$('.rstSyasin1').prop('disabled', true);
						$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
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
					action: function() {
						$("#syasin2Path").val("");
						$("#syasin2Title").val("");
						$("#syasin2").val("");
						$("#syasin2dd").html("");
						$("#reset2").val('1');
						$("#image2").val("");
						$("#divrstsyashin2").val("");
						$('#syasin2Title').attr('disabled', 'disabled');
						$('.rstSyasin2').prop('disabled', true);
						$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
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
					action: function() {
						$("#syasin3Path").val("");
						$("#syasin3Title").val("");
						$("#syasin3").val("");
						$("#syasin3dd").html("");
						$("#reset3").val('1');
						$("#image3").val("");
						$("#divrstsyashin3").val("");
						$('#syasin3Title').attr('disabled', 'disabled');
						$('.rstSyasin3').prop('disabled', true);
						$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
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
	$('input[type=radio][name=bunruicd]').change(function() {
		var selectedVal=this.value;
		// 会員区分「会員 」の場合
		if (selectedVal == '1') {
			$('#naiyoufield').hide();
			$('#kousifield').hide();
			$('#taisyoufield').hide();
			$('#teiinfield').hide();
			$('#hiyoufield').hide();
			$('#syugoubasyofield').hide();
			$('#kigendatefield').hide();
			$('#kigentmfield').hide();
			$('#bikoufield').hide();
			$('#teiincomfield').hide();
			$('#gidaifield').show();
			// $('#preview').hide();
			$("#kaigi").attr('checked', 'true');
		// 会員区分「非会員 」の場合
		} else {
			$('#naiyoufield').show();
			$('#kousifield').show();
			$('#taisyoufield').show();
			$('#teiinfield').show();
			$('#hiyoufield').show();
			$('#syugoubasyofield').show();
			$('#kigendatefield').show();
			$('#kigentmfield').show();
			$('#bikoufield').show();
			$('#gidaifield').hide();
			$('#teiincomfield').show();
			// $('#preview').show();
		}
	});
});
jQuery.validator.addMethod(
		"dateFormatfull",
		function(value, element) {
			var check = false;
			var re = /^(\d{4})\/(\d{1,2})\/(\d{1,2})$/;
				if( re.test(value)){
					var adata = value.split('/');
					var yyyy = parseInt(adata[0],10);
					var mm = parseInt(adata[1],10);
					var dd = parseInt(adata[2],10);
					var xdata = new Date(yyyy,mm-1,dd);
					if ( ( xdata.getFullYear() === yyyy ) && ( xdata.getMonth () === mm - 1 ) && ( xdata.getDate() === dd ) ) {
						check = true;
					}
					else {
						check = false;
					}
				} else {
					check = false;
				}
				return this.optional(element) || check;
	});
jQuery.validator.addMethod(
		"dateFormat",
		function(value, element) {
			var check = false;
			var re = /^(\d{4})\/(\d{1,2})$/;
				if( re.test(value)){
					var adata = value.split('/');
					var yyyy = parseInt(adata[0],10);
					var mm = parseInt(adata[1],10);
					var dd = parseInt('01');
					var xdata = new Date(yyyy,mm-1,dd);
					if ( ( xdata.getFullYear() === yyyy ) && ( xdata.getMonth () === mm - 1 ) && ( xdata.getDate() === dd ) ) {
						check = true;
					}
					else {
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
			if(value==''){
				return true;
			}else{
				var fromtime = $(params).val();
				if(fromtime > value){
					return false;
				} 
			}
			return true;
	});

jQuery.validator.addMethod(
		"timeLength", 
		function(value) {
			if(value==''){
				return true;
			}else{
				if(value.length < 5){
					return false;
				} 
			}
			return true;
});
jQuery.validator.addMethod("timeformat", function(value, element) {
	return this.optional(element) || value.match(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/);
});
jQuery.validator.addMethod("imgval1", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		if ($.inArray(lastChar, fileExtension) == -1) {
			if($("#image1").val() == "" ) {
				$("#syasin1").val("");
				$("#syasin1Path").val("");
				$("#syasin1Title").val("");
				$('#syasin1Title').attr('disabled', 'disabled');
				$('.rstSyasin1').prop('disabled', true);
				$("#reset1").val('1');
				$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				var img1 = $("#image1").val();
				var imgtit1 = $("#urltitle1").val();
				$("#thum01").attr('src', img1);
				$("#syasin1Title").val(imgtit1);
				$("#syasin1").val("");
				$("#syasin1Path").val("");
			}
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
	    	if($("#image2").val() == "" ) {
				$("#syasin2").val("");
				$("#syasin2Title").val("");
				$("#syasin2Path").val("");
				$('#syasin2Title').attr('disabled', 'disabled');
				$('.rstSyasin2').prop('disabled', true);
				$("#reset2").val('1');
				$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				var img2 = $("#image2").val();
				var imgtit2 = $("#urltitle2").val();
				$("#thum02").attr('src', img2);
				$("#syasin2Title").val(imgtit2);
				$("#syasin2").val("");
				$("#syasin2Path").val("");
			}
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
	    	if($("#image3").val() == "" ) {
				$("#syasin3").val("");
				$("#syasin3Title").val("");
				$("#syasin3Path").val("");
				$('#syasin3Title').attr('disabled', 'disabled');
				$('.rstSyasin3').prop('disabled', true);
				$("#reset3").val('1');
				$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				var img3 = $("#image3").val();
				var imgtit3 = $("#urltitle3").val();
				$("#thum03").attr('src', img3);
				$("#syasin3Title").val(imgtit3);
				$("#syasin3").val("");
				$("#syasin3Path").val("");
			}
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
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
				$("#report").validate({
					onkeyup: false,
					rules: {
						// 期間（From）
						kaigiFrom: "dateFormat",
						// 期間（To）
						kaigiTo: {
							dateFormat:true,
							lessThan: '[name="kaigiFrom"]'
						},
						// 期間（From）
						eventFrom: "dateFormat",
						// 期間（To）
						eventTo: {
							dateFormat:true,
							lessThan: '[name="eventFrom"]'
						}
					},
					messages: {
						//期間（From）のエラーメッセージ。
						kaigiFrom: "正しい年月を入力してください。",
						// 期間（To）のエラーメッセージ。
						kaigiTo: { 
							dateFormat:"正しい年月を入力してください。",
							lessThan:"会議開催期間のFrom、Toを正しく入力してください。"
						},
						//期間（From）のエラーメッセージ。
						eventFrom: "正しい年月を入力してください。",
						// 期間（To）のエラーメッセージ。
						eventTo: { 
							dateFormat:"正しい年月を入力してください。",
							lessThan:"イベント開催期間のFrom、Toを正しく入力してください。"
						}
					},
					submitHandler: function(form) {
						form.submit();
					}
				});
				$("#reportedit").validate({
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
						$(".syasin1Title").html("");
						$(".syasin2Title").html("");
						$(".syasin3Title").html("");
						if(element.attr("name") == "syasin1Path" || element.attr("name") == "syasin2Path" || element.attr("name") == "syasin3Path") {
							error.appendTo( element.parent("div").next("div") );
						} else {
							error.insertAfter(element);
						}
					},
					rules: {
						sosikicd: "required",
						kbunruicd: "required",
						kaisaidate: {
							required:true,
							dateFormatfull: true
						},
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
						teiin: {
							range: [ -32768, 32767 ],
							maxlength: 5
						},
						teiincom: {
							maxlength: 60
						},
						hiyou: {
							maxlength: 100
						},
						syugoubasyo: {
							maxlength: 255
						},
						bikou: {
							maxlength: 1024
						},
						comment: {
							maxlength: 1024
						},
						syasin1Title: {
							maxlength: 60
						},
						syasin2Title: {
							maxlength: 60
						},
						syasin3Title: {
							maxlength: 60
						},
						kigendate: "dateFormatfull",
						syasin1Path: "imgval1",
						syasin2Path: "imgval2",
						syasin3Path: "imgval3"
					},
					messages: {
						sosikicd: "組織を選択してください。",
						kbunruicd: "活動分類を選択してください。",
						kaisaidate: { 
							required:"日付を入力してください。",
							dateFormatfull: "正しい年月を入力してください。"
						},
						hyoudai: {
							required:"表題を入力してください。",
							maxlength: "最大文字数を超えています。"
						},
						meisyou: {
							required:"名称を入力してください。",
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
						teiin: {
							range: "最大文字数を超えています。",
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
						comment: {
							maxlength: "最大文字数を超えています。"
						},
						syasin1Title: {
							maxlength: "最大文字数を超えています。"
						},
						syasin2Title: {
							maxlength: "最大文字数を超えています。"
						},
						syasin3Title: {
							maxlength: "最大文字数を超えています。"
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
						kigendate: "申込期限_日付が不正な形式です。",
						syasin1Path : "画像しか入力できません。画像を入力してください。",
						syasin2Path : "画像しか入力できません。画像を入力してください。",
						syasin3Path : "画像しか入力できません。画像を入力してください。"
						
					},
					submitHandler: function(form) {
						if($('#previewflg').val() == 1 ) {
							$('#kigendate').removeAttr('disabled');
							$('input[name="scategory_radio"]').removeAttr('disabled');
							$('#reportedit').attr('target', '_blank');
							$('#reportedit').attr('action', '../activity/reportDetail');							
							$('input[name="bunruicd"]').removeAttr('disabled');
							$('#conference').attr('disabled', false);
							$('#kbunruicd').attr('disabled', false);
							$('#gidai').attr('disabled',false);
							$('#kaisaidate').attr('disabled',false);
							$('#kaisaitmfrom').attr('disabled',false);
							$('#kaisaitmto').attr('disabled',false);
							$('#hyoudai').attr('disabled',false);
							$('#meisyou').attr('disabled',false);
							$('#basyo').attr('disabled',false);
							$('#naiyou').attr('disabled',false); 
							$('#kousi').attr('disabled',false);
							$('#taisyou').attr('disabled',false);
							$('#teiin').attr('disabled',false);
							$('#teiincom').attr('disabled',false);
							$('#hiyou').attr('disabled',false);
							$('#syugoubasyo').attr('disabled',false);
							$('#kigendate').attr('disabled',false);
							$('#kigentm').attr('disabled',false);
							$('#bikou').attr('disabled',false);
							$('#comment').attr('disabled',false);
							if($("#khoutourokuhdn").val()=='0' && $("#khoukoukaihdn").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA ){
								$('#syasin1Path').attr('disabled',false);
								$('#syasin2Path').attr('disabled',false);
								$('#syasin3Path').attr('disabled',false);
								$('#syasin1Title').attr('disabled',false);
								$('#syasin2Title').attr('disabled',false);
								$('#syasin3Title').attr('disabled',false);
							}
							form.submit();
							if($("#khoutourokuhdn").val()=='0' && $("#khoukoukaihdn").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA ){
								$('input[name="bunruicd"]').attr('disabled', 'disabled');
								$('#conference').attr('disabled', 'disabled');
								$('#kbunruicd').attr('disabled', 'disabled');
								$('#gidai').attr('disabled','disabled');
								$('#kaisaidate').attr('disabled','disabled');
								$('#kaisaitmfrom').attr('disabled','disabled');
								$('#kaisaitmto').attr('disabled','disabled');
								$('#hyoudai').attr('disabled','disabled');
								$('#meisyou').attr('disabled','disabled');
								$('#basyo').attr('disabled','disabled');
								$('#naiyou').attr('disabled','disabled'); 
								$('#kousi').attr('disabled','disabled');
								$('#taisyou').attr('disabled','disabled');
								$('#teiin').attr('disabled','disabled');
								$('#teiincom').attr('disabled','disabled');
								$('#hiyou').attr('disabled','disabled');
								$('#syugoubasyo').attr('disabled','disabled');
								$('#kigendate').attr('disabled','disabled');
								$('#kigentm').attr('disabled','disabled');
								$('#bikou').attr('disabled','disabled');
								$('#comment').attr('disabled','disabled');
								$('#syasin1Path').attr('disabled','disabled');
								$('#syasin2Path').attr('disabled','disabled');
								$('#syasin3Path').attr('disabled','disabled');
								$('#syasin1Title').attr('disabled','disabled');
								$('#syasin2Title').attr('disabled','disabled');
								$('#syasin3Title').attr('disabled','disabled');
								$('input[name="scategory_radio"]').attr('disabled', 'disabled');
								$('#kigendate').attr('disabled','disabled');
							}
							$('#previewflg').val('0');
						} else {
							if($('input[name=koukaikbn]:checked').val() == 1) {
								fnReportCopyEditProcess(form);
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
												fnReportCopyEditProcess(form);
											}
										},
										送信しない: function () {
											$('#hdn_soushin').val(0);
											fnReportCopyEditProcess(form);
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
		if (h >= 0 && h <=23 && colon == ":"){
			outTime = h + ":";
		} else {
			outTime = "";
		}
	} else if(timeLength == 4) {
		h = inputTime.substr(0,2);
		colon = inputTime.substr(2,1);
		m = inputTime.substr(3,1);
		if(h >= 0 && h < 24 && colon == ":") {
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
		if(m >= 0 && m < 60) {
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
$(document).ready(function() {
	if($("#kaisaidate").val() == "0000-00-00" || $("#kaisaidate").val() == "0000/00/00") {
		$("#kaisaidate").val('');
	}
	if($("#kaisaitmfrom").val() == "00:00") {
		$("#kaisaitmfrom").val('');
	}
	if($("#kaisaitmto").val() == "00:00") {
		$("#kaisaitmto").val('');
	}
	if($("#kigendate").val() == "0000-00-00" || $("#kigendate").val() == "0000/00/00") {
		$("#kigendate").val('');
	}
	if($("#kigentm").val() == "00:00") {
		$("#kigentm").val('');
	}
});
function fnReportCopyEditProcess(form) {
	if($("#divert").val() == 1){
		var confirmmsg = INSERT_CONFIRM;
		var successmsg = INSERT_SUCCESS;
		var failuremsg = INSERT_FAILURE;
	} else {
		var confirmmsg = UPDATE_CONFIRM;
		var successmsg = UPDATE_SUCCESS;
		var failuremsg = UPDATE_FAILURE;
	}
	$.confirm({
		title: '',
		content: confirmmsg,
		type: 'blue',
		buttons: {
			OK: {
				action: function() {
					$('.b-release').prop('disabled', true);
					$("#updatecls").addClass('updatecls');
					$('#gidai').attr('disabled',false);
					$('#kaisaidate').attr('disabled',false);
					$('#kaisaitmfrom').attr('disabled',false);
					$('#kaisaitmto').attr('disabled',false);
					$('#hyoudai').attr('disabled',false);
					$('#meisyou').attr('disabled',false);
					$('#basyo').attr('disabled',false);
					$('#naiyou').attr('disabled',false); 
					$('#kousi').attr('disabled',false);
					$('#taisyou').attr('disabled',false);
					$('#teiin').attr('disabled',false);
					$('#teiincom').attr('disabled',false);
					$('#hiyou').attr('disabled',false);
					$('#syugoubasyo').attr('disabled',false);
					$('#kigendate').attr('disabled',false);
					$('#kigentm').attr('disabled',false);
					$('#bikou').attr('disabled',false);
					$('#comment').attr('disabled',false);
					$('#syasin1Path').attr('disabled',false);
					$('#syasin2Path').attr('disabled',false);
					$('#syasin3Path').attr('disabled',false);
					$('#syasin1Title').attr('disabled',false);
					$('#syasin2Title').attr('disabled',false);
					$('#syasin3Title').attr('disabled',false);
					$('#kigendate').removeAttr('disabled');
					$('input[name="scategory_radio"]').removeAttr('disabled');
					$('#reportedit').attr('target', '');
					$('#reportedit').attr('action', '../adminActivity/reportupdate');
					$('input[name="bunruicd"]').removeAttr('disabled');
					$('#conference').attr('disabled', false);
					$('#kbunruicd').attr('disabled', false);
					$('input[name="koukaikbn"]').removeAttr('disabled');
					// form.submit();
					var data = new FormData();
					var serializedData = $("#reportedit").serialize();
					serializedData = decodeURIComponent(serializedData);
					data.append('syasin1', $("#syasin1").get(0).files[0]);
					data.append('syasin2', $("#syasin2").get(0).files[0]);
					data.append('syasin3', $("#syasin3").get(0).files[0]);
					data.append('otherFields', serializedData);
					var xhr = new XMLHttpRequest();
				 	xhr.open('POST', 'reportupdate', true);
				 	xhr.send(data);
				 	xhr.onload = function () {
				    	$("#updatecls").removeClass('updatecls');
					 	//alert(xhr.responseText);
					 	if(xhr.responseText == "1") {
					 		if (xhr.status === 200) {
					 			$.confirm({
									title: '',
									content: successmsg,
									type: 'blue',
									buttons: {
										OK: {
											btnClass: 'btn-blue',
											keys: ['enter'],
											action: function(){
												$( "#adminActivityeditFrm" ).submit();
											}
										}
									}
								});
							} else {
								window.location = "../Error/systemError";
							}
						} else if(xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200 ) {
							window.location = "../Error/systemError";
						}else {
							$.confirm({
									title: '',
									content: failuremsg,
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
							$(".syasin1Title").html("");
							$(".syasin2Title").html("");
							$(".syasin3Title").html("");
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