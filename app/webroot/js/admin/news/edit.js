$(document).ready(function() {
	// 公開区分項目の設定、お知らせ登録権限　=　"1"［権限あり］ お知らせ公開権限　=　"0"［権限なし］の場合
	if($("#osirasetouroku").val()=='1' && $("#osirasekoukai").val()=='0' && $("#kanrikbnhdn").val() < SYS_KANRISHA){
		$("#koukaikbn_r1").attr('checked', 'checked');
		$('#koukaikbn_r0').attr('disabled', 'disabled');
	}
	// 公開区分項目の設定、お知らせ登録権限　=　"0"［権限あり］ お知らせ公開権限　=　"1"［権限なし］の場合
	if($("#osirasetouroku").val()=='0' && $("#osirasekoukai").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA){
		$(".syasin1btn").css({"backgroundColor":"gray"});
		$(".syasin2btn").css({"backgroundColor":"gray"});
		$(".syasin3btn").css({"backgroundColor":"gray"});
		$(".file1btn").css({"backgroundColor":"gray"});
		$(".file2btn").css({"backgroundColor":"gray"});
		$(".file3btn").css({"backgroundColor":"gray"});
		$(".rstSyasin1").css({"backgroundColor":"gray"});
		$(".rstSyasin2").css({"backgroundColor":"gray"});
		$(".rstSyasin3").css({"backgroundColor":"gray"});
		$(".rstFile1").css({"backgroundColor":"gray"});
		$(".rstFile2").css({"backgroundColor":"gray"});
		$(".rstFile3").css({"backgroundColor":"gray"});
		$('#osirasedate').attr('disabled','disabled');
		$('#osirasetime').attr('disabled','disabled');
		$('#title').attr('disabled','disabled');
		$('#naiyo').attr('disabled','disabled');
		$('#syasin1Path').attr('disabled','disabled');
		$('#syasin2Path').attr('disabled','disabled');
		$('#syasin3Path').attr('disabled','disabled');
		$('#file1Path').attr('disabled','disabled');
		$('#file2Path').attr('disabled','disabled');
		$('#file3Path').attr('disabled','disabled');
		$('.rstSyasin1').attr('disabled','disabled');
		$('.rstSyasin2').attr('disabled','disabled');
		$('.rstSyasin3').attr('disabled','disabled');
		$('.rstFile1').attr('disabled','disabled');
		$('.rstFile2').attr('disabled','disabled');
		$('.rstFile3').attr('disabled','disabled');
		$('.syasin1btn').attr('disabled','disabled');
		$('.syasin2btn').attr('disabled','disabled');
		$('.syasin3btn').attr('disabled','disabled');
		$('.file1btn').attr('disabled','disabled');
		$('.file2btn').attr('disabled','disabled');
		$('.file3btn').attr('disabled','disabled');
		$('#syasin1Title').attr('disabled', 'disabled');
		$('#syasin2Title').attr('disabled', 'disabled');
		$('#syasin3Title').attr('disabled', 'disabled');
		$('#file1Title').attr('disabled', 'disabled');
		$('#file2Title').attr('disabled', 'disabled');
		$('#file3Title').attr('disabled', 'disabled');
		$("#mailchk").attr("disabled", true);
	}
	// 初期表示に画像選択で、画像タイトル
	if($("#urlsyasin1").val() == ""){
		$('#syasin1Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin2").val() == ""){
		$('#syasin2Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin3").val() == ""){
		$('#syasin3Title').attr('disabled', 'disabled');
	}
	// 初期表示に画像選択で、リセット
	if($("#urlsyasin1").val() == ""){
		$('.rstSyasin1').prop('disabled', true);
	}
	if($("#urlsyasin2").val() == ""){
		$('.rstSyasin2').prop('disabled', true);
	}
	if($("#urlsyasin3").val() == ""){
		$('.rstSyasin3').prop('disabled', true);
	}
	// 初期表示に画像選択で、リセット
	if($("#urlfile1").val() == ""){
		$('.rstFile1').prop('disabled', true);
	}
	if($("#urlfile2").val() == ""){
		$('.rstFile2').prop('disabled', true);
	}
	if($("#urlfile3").val() == ""){
		$('.rstFile3').prop('disabled', true);
	}
	// 初期表示にファイル選択で、ファイルタイトル
	if($("#urlfile1").val() == ""){
		$('#file1Title').attr('disabled', 'disabled');
	}
	if($("#urlfile2").val() == ""){
		$('#file2Title').attr('disabled', 'disabled');
	}
	if($("#urlfile3").val() == ""){
		$('#file3Title').attr('disabled', 'disabled');
	}
	// 写真1
	$( "#syasin1" ).change(function() {
		$('#syasin1Title').removeAttr('disabled');
		$('.rstSyasin1').prop('disabled', false);
		$(".syasin1Title").html("");
		$("#reset1").val('');
		if($("#syasin1").val() !="") {
			var iSize = ($("#syasin1")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin1").val("");
				$("#syasin1Path").val("");
				$("#thum01").attr('src', $("#image1").val());
				$("#syasin1dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image1").val() == "" ) {
					$("#syasin1Path").val("");
					$("#syasin1Title").val("");
					$("#syasin1").val("");
					$("#urltitle1").val("");
					$("#image1").val("");
					$("#reset1").val('1');
					$('#syasin1Title').attr('disabled', 'disabled');
					$('.rstSyasin1').prop('disabled', true);
					$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin1Title").html("");
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
		$(".syasin2Title").html("");
		if($("#syasin2").val() !="") {
			var iSize = ($("#syasin2")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin2").val("");
				$("#syasin2Path").val("");
				$("#thum02").attr('src', $("#image2").val());
				$("#syasin2dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image2").val() == "" ) {
					$("#syasin2Path").val("");
					$("#syasin2Title").val("");
					$("#syasin2").val("");
					$("#urltitle2").val("");
					$("#image2").val("");
					$("#reset2").val('1');
					$('#syasin2Title').attr('disabled', 'disabled');
					$('.rstSyasin2').prop('disabled', true);
					$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin2Title").html("");
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
		$(".syasin3Title").html("");
		if($("#syasin3").val() !="") {
			var iSize = ($("#syasin3")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin3").val("");
				$("#syasin3Path").val("");
				$("#thum03").attr('src', $("#image3").val());
				$("#syasin3dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image3").val() == "" ) {
					$("#syasin3Path").val("");
					$("#syasin3Title").val("");
					$("#syasin3").val("");
					$("#urltitle3").val("");
					$("#image3").val("");
					$("#reset3").val('1');
					$('#syasin3Title').attr('disabled', 'disabled');
					$('.rstSyasin3').prop('disabled', true);
					$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin3Title").html("");
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
	// 添付ファイル1
	$( "#file1" ).change(function() {
		$("#resetfile1").val('');
		$('#file1Title').removeAttr('disabled');
		$('.rstFile1').prop('disabled', false);
		$("#path1").hide();
		$(".file1Title").html("");
		if($("#file1").val() !="") {
			var iSize = ($("#file1")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file1").val("");
				$("#file1Path").val("");
				$("#file1dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#path1file").val() == "") {
					$("#file1Path").val("");
					$("#file1Title").val("");
					$("#urlfiletitle1").val("");
					$("#path1file").val("");
					$("#resetfile1").val('1');
					$("#file1").val("");
					$('.rstFile1').prop('disabled', true);
					$('#file1Title').attr('disabled', 'disabled');
					$("#path1").hide();
					$(".file1Title").html("");
				}
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
		$("#resetfile2").val('');
		$('#file2Title').removeAttr('disabled');
		$('.rstFile2').prop('disabled', false);
		$("#path2").hide();
		$(".file2Title").html("");
		if($("#file2").val() !="") {
			var iSize = ($("#file2")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file2").val("");
				$("#file2Path").val("");
				$("#file2dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#path2file").val() == "") {
					$("#file2Path").val("");
					$("#file2Title").val("");
					$("#urlfiletitle2").val("");
					$("#path2file").val("");
					$("#resetfile2").val('1');
					$("#file2").val("");
					$('.rstFile2').prop('disabled', true);
					$('#file2Title').attr('disabled', 'disabled');
					$("#path2").hide();
					$(".file2Title").html("");
				}
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
		$("#resetfile3").val('');
		$('#file3Title').removeAttr('disabled');
		$('.rstFile3').prop('disabled', false);
		$("#path3").hide();
		$(".file3Title").html("");
		if($("#file3").val() !="") {
			var iSize = ($("#file3")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file3").val("");
				$("#file3Path").val("");
				$("#file3dd").html("ファイルサイズは2MB未満でなければなりません。");
				if($("#path3file").val() == "") {
					$("#file3Path").val("");
					$("#file3Title").val("");
					$("#urlfiletitle3").val("");
					$("#path3file").val("");
					$("#resetfile3").val('1');
					$("#file3").val("");
					$('.rstFile3').prop('disabled', true);
					$('#file3Title').attr('disabled', 'disabled');
					$("#path3").hide();
					$(".file3Title").html("");
				}
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
						$("#syasin1Title").val("");
						$("#syasin1").val("");
						$("#syasin1dd").html("");
						$("#urltitle1").val("");
						$("#image1").val("");
						$("#reset1").val('1');
						$('#syasin1Title').attr('disabled', 'disabled');
						$('.rstSyasin1').prop('disabled', true);
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
						$("#syasin2Title").val("");
						$("#syasin2").val("");
						$("#syasin2dd").html("");
						$("#urltitle2").val("");
						$("#image2").val("");
						$("#reset2").val('1');
						$('#syasin2Title').attr('disabled', 'disabled');
						$('.rstSyasin2').prop('disabled', true);
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
						$("#urltitle3").val("");
						$("#image3").val("");
						$("#reset3").val('1');
						$('#syasin3Title').attr('disabled', 'disabled');
						$('.rstSyasin3').prop('disabled', true);
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
						$("#urlfiletitle1").val("");
						$("#path1file").val("");
						$("#resetfile1").val('1');
						$("#file1").val("");
						$("#file1dd").html("");
						$('.rstFile1').prop('disabled', true);
						$('#file1Title').attr('disabled', 'disabled');
						$("#path1").hide();
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
						$("#urlfiletitle2").val("");
						$("#path2file").val("");
						$("#resetfile2").val('1');
						$("#file2").val("");
						$("#file2dd").html("");
						$('.rstFile2').prop('disabled', true);
						$('#file2Title').attr('disabled', 'disabled');
						$("#path2").hide();
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
						$("#urlfiletitle3").val("");
						$("#path3file").val("");
						$("#resetfile3").val('1');
						$("#file3").val("");
						$("#file3dd").html("");
						$('.rstFile3').prop('disabled', true);
						$('#file3Title').attr('disabled', 'disabled');
						$("#path3").hide();
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
	// 編集写真1のリセット
	$(".rstEdtSyasin1").click(function () {
		$("#syasin1Path").val("");
		$("#syasin1Title").val($("#urltitle1").val());
		$("#syasin1").val("");
		if($("#urlsyasin1").val()=="") {
			$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		} else {
			$("#thum01").attr('src', $("#baseurl").val()+'/adminNews/getSyasin/'+$("#urlsyasin1").val()+'/'+$("#urlsyasinKey").val());
		}
	});
	// 編集写真2のリセット
	$(".rstEdtSyasin2").click(function () {
		$("#syasin2Path").val("");
		$("#syasin2Title").val($("#urltitle2").val());
		$("#syasin2").val("");
		if($("#urlsyasin2").val()=="") {
			$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		} else {
			$("#thum02").attr('src', $("#baseurl").val()+'/adminNews/getSyasin/'+$("#urlsyasin2").val()+'/'+$("#urlsyasinKey").val());
		}
	});
	// 編集写真3のリセット
	$(".rstEdtSyasin3").click(function () {
		$("#syasin3Path").val("");
		$("#syasin3Title").val($("#urltitle3").val());
		$("#syasin3").val("");
		if($("#urlsyasin3").val()=="") {
			$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		} else {
			$("#thum03").attr('src', $("#baseurl").val()+'/adminNews/getSyasin/'+$("#urlsyasin3").val()+'/'+$("#urlsyasinKey").val());
		}
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
	$('.backpage_head').click(function() {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$('#menuFrm').attr('action', '../admin/home');
						$('#menuFrm').submit();
					}
				},
				キャンセル: function () {
					
				}
			}
		});
	});
	$(".b-preview").click(function () {
		$('#previewflg').val('1');
		$('#adminNewsregister').submit();
	});
	$(".b-release").click(function(){
		$('#previewflg').val('0');
		$('#adminNewsregister').submit();
	});
	$( "#title" ).change(function() {
		$(".title").html("");
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
			if($("#image1").val() == "" ) {
				$("#syasin1").val("");
				$("#syasin1Path").val("");
				$("#syasin1Title").val("");
				$('#syasin1Title').attr('disabled', 'disabled');
				$('.rstSyasin1').prop('disabled', true);
				$("#reset1").val('1');
				$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				var imgtit1 = $("#urltitle1").val();
				$("#thum01").attr('src', $("#image1").val());
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
				$("#syasin2Path").val("");
				$("#syasin2Title").val("");
				$('#syasin2Title').attr('disabled', 'disabled');
				$('.rstSyasin2').prop('disabled', true);
				$("#reset2").val('1');
				$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				var imgtit2 = $("#urltitle2").val();
				$("#thum02").attr('src', $("#image2").val());
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
				$("#syasin3Title").val("");
				$("#syasin3").val("");
				$("#syasin3Path").val("");
				$('#syasin3Title').attr('disabled', 'disabled');
				$('.rstSyasin3').prop('disabled', true);
				$("#reset3").val('1');
				$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				var imgtit3 = $("#urltitle3").val();
				$("#thum03").attr('src', $("#image3").val());
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
			$("#adminNewsregister").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					$(".osirasedate").html("");
					$(".osirasetime").html("");
					$(".title").html("");
					$(".naiyo").html("");
					$(".syasin1Title").html("");
					$(".syasin2Title").html("");
					$(".syasin3Title").html("");
					$(".file1Title").html("");
					$(".file2Title").html("");
					$(".file3Title").html("");
					if(element.attr("name") == "syasin1Path" || element.attr("name") == "syasin2Path" || element.attr("name") == "syasin3Path") {
						error.appendTo( element.parent("div").next("div") );
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					// お知らせ日付
					osirasedate: {
						required:true,
						dateFormat: true
					},
					// お知らせ時刻
					osirasetime: {
						required:true,
						timeLength:true,
						timeformat: true
					},
					// お知らせタイトル）
					title: {
						required:true,
						maxlength: 100
					},
					// お知らせ内容
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
					syasin3Path: "imgval3"
				},
				messages: {
					// お知らせ日付
					osirasedate: {
						required:"お知らせ日付を入力してください。",
						dateFormat: "日付が不正な形式です。"
					},
					// お知らせ時刻
					osirasetime: {
						required:"お知らせ時刻を入力してください。",
						timeLength:"時間が不正な形式です。",
						timeformat: "時間が不正な形式です。"
					},
					// お知らせタイトル）
					title: { 
						required:"お知らせタイトルを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					// お知らせ内容
					naiyo: { 
						required:"お知らせ内容を入力してください。",
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
					syasin3Path : "画像しか入力できません。画像を入力してください。"
				},
				submitHandler: function(form) {
					var osiraseNotifyFlag = fnOsiraseDateTimeExistingCheck($('#osirasedate').val(),$('#osirasetime').val());

					if($('#previewflg').val() == 1 ) {
						if($("#osirasetouroku").val()=='0' && $("#osirasekoukai").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA){
							$('#file1Title').attr('disabled', false);
							$('#file2Title').attr('disabled', false);
							$('#file3Title').attr('disabled', false);
							$('#osirasedate').attr('disabled',false);
							$('#osirasetime').attr('disabled',false);
							$('#title').attr('disabled',false);
							$('#naiyo').attr('disabled',false);
							$('#syasin1Path').attr('disabled',false);
							$('#syasin2Path').attr('disabled',false);
							$('#syasin3Path').attr('disabled',false);
							$('#file1Path').attr('disabled',false);
							$('#file2Path').attr('disabled',false);
							$('#file3Path').attr('disabled',false);
							$('#syasin1Title').attr('disabled', false);
							$('#syasin2Title').attr('disabled', false);
							$('#syasin3Title').attr('disabled', false);
						}
						$('#adminNewsregister').attr('target', '_blank');
						$('#adminNewsregister').attr('action', '../news/detail');
						$('#previewflg').val('0');
						form.submit();
						if($("#osirasetouroku").val()=='0' && $("#osirasekoukai").val()=='1' && $("#kanrikbnhdn").val() < SYS_KANRISHA){
							$('#osirasedate').attr('disabled','disabled');
							$('#osirasetime').attr('disabled','disabled');
							$('#title').attr('disabled','disabled');
							$('#naiyo').attr('disabled','disabled');
							$('#syasin1Path').attr('disabled','disabled');
							$('#syasin2Path').attr('disabled','disabled');
							$('#syasin3Path').attr('disabled','disabled');
							$('#file1Path').attr('disabled','disabled');
							$('#file2Path').attr('disabled','disabled');
							$('#file3Path').attr('disabled','disabled');
							if($("#urlsyasin1").val() == ""){
								$('#syasin1Title').attr('disabled', 'disabled');
							}
							if($("#urlsyasin2").val() == ""){
								$('#syasin2Title').attr('disabled', 'disabled');
							}
							if($("#urlsyasin3").val() == ""){
								$('#syasin3Title').attr('disabled', 'disabled');
							}
							if($("#urlfile1").val() == ""){
								$('#file1Title').attr('disabled', 'disabled');
							}
							if($("#urlfile2").val() == ""){
								$('#file2Title').attr('disabled', 'disabled');
							}
							if($("#urlfile3").val() == ""){
								$('#file3Title').attr('disabled', 'disabled');
							}
						}
					} else {
						if($('input[name=koukaikbn]:checked').val() == 1 || !osiraseNotifyFlag) {
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

function fnEditProcess(form) {
	$.confirm({
		title: '',
		content: UPDATE_CONFIRM,
		type: 'blue',
		buttons: {
			OK: {
				action: function(){
					$("#updatecls").addClass('updatecls');
					$('#file1Title').attr('disabled', false);
					$('#file2Title').attr('disabled', false);
					$('#file3Title').attr('disabled', false);
					$('#syasin1Title').attr('disabled', false);
					$('#syasin2Title').attr('disabled', false);
					$('#syasin3Title').attr('disabled', false);
					$('#osirasedate').attr('disabled',false);
					$('#osirasetime').attr('disabled',false);
					$('#title').attr('disabled',false);
					$('#naiyo').attr('disabled',false);
					$('#syasin1Path').attr('disabled',false);
					$('#syasin2Path').attr('disabled',false);
					$('#syasin3Path').attr('disabled',false);
					$('#file1Path').attr('disabled',false);
					$('#file2Path').attr('disabled',false);
					$('#file3Path').attr('disabled',false);
                	$('#adminNewsregister').attr('target', '');
					$('#adminNewsregister').attr('action', '../adminNews/update');
					$('.b-release').prop('disabled', true);
					var data = new FormData();
					var serializedData = $("#adminNewsregister").serialize();
					serializedData = decodeURIComponent(serializedData);
					data.append('syasin1', $("#syasin1").get(0).files[0]);
					data.append('syasin2', $("#syasin2").get(0).files[0]);
					data.append('syasin3', $("#syasin3").get(0).files[0]);
					data.append('file1', $("#file1").get(0).files[0]);
					data.append('file2', $("#file2").get(0).files[0]);
					data.append('file3', $("#file3").get(0).files[0]);
					data.append('otherFields', serializedData);
					var xhr = new XMLHttpRequest();
				 	xhr.open('POST', 'update', true);
				 	xhr.send(data);
				 	xhr.onload = function () {
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
									content: UPDATE_FAILURE,
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
					 		$(".osirasedate").html("");
							$(".osirasetime").html("");
							$(".title").html("");
							$(".naiyo").html("");
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

function fnOsiraseDateTimeExistingCheck(osiraseDate,osiraseTime) {
	var osiraseDateTime = osiraseDate +" "+ osiraseTime;
	var currentDate = new Date().toLocaleDateString('en-ZA', {timeZone: 'Asia/Tokyo'});
	var currentTime = new Date().toLocaleTimeString('en-US', {timeZone: 'Asia/Tokyo',hour12: false,hour: '2-digit',minute: '2-digit'});
	var currentDateTime = currentDate + " " + currentTime;
	if(currentDateTime < osiraseDateTime){
		return false;
	}
	return true;
}