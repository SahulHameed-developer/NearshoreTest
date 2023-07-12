$(document).ready(function() {	
	if($("#kurabucd").val() == "") {
		$(".buttonsearch").prop("disabled",true);

		$('.syasinbtn').prop('disabled', true);
		$('.syasin1btn').prop('disabled', true);
		$('.syasin2btn').prop('disabled', true);
		$('.syasin3btn').prop('disabled', true);
		$('.syasin4btn').prop('disabled', true);
		$('.syasin5btn').prop('disabled', true);
		$('.syasin6btn').prop('disabled', true);
		$('.syasin7btn').prop('disabled', true);
		$('.syasin8btn').prop('disabled', true);
		$('.syasin9btn').prop('disabled', true);

		$("#syasinPath").prop("disabled",true);
		$("#syasin1Path").prop("disabled",true);
		$("#syasin2Path").prop("disabled",true);
		$("#syasin3Path").prop("disabled",true);
		$("#syasin4Path").prop("disabled",true);
		$("#syasin5Path").prop("disabled",true);
		$("#syasin6Path").prop("disabled",true);
		$("#syasin7Path").prop("disabled",true);
		$("#syasin8Path").prop("disabled",true);
		$("#syasin9Path").prop("disabled",true);

		$('input[name="koukaikbn"]').attr('disabled', 'disabled');
		$("#mailchk").attr("disabled", true);
	}

	// 初期表示に画像選択で、画像タイトル
	if($("#urlsyasin").val() == ""){
		$('#syasinTitle').attr('disabled', 'disabled');
	}
	if($("#urlsyasin1").val() == ""){
		$('#syasin1Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin2").val() == ""){
		$('#syasin2Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin3").val() == ""){
		$('#syasin3Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin4").val() == ""){
		$('#syasin4Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin5").val() == ""){
		$('#syasin5Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin6").val() == ""){
		$('#syasin6Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin7").val() == ""){
		$('#syasin7Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin8").val() == ""){
		$('#syasin8Title').attr('disabled', 'disabled');
	}
	if($("#urlsyasin9").val() == ""){
		$('#syasin9Title').attr('disabled', 'disabled');
	}

	 //$("#syasinPath").prop("click",return false); 

	if($("#urlsyasin").val() == ""){
		$('.rstsyasin').prop('disabled', true);
	}
	if($("#urlsyasin1").val() == ""){
		$('.rstsyasin1').prop('disabled', true);
	}
	if($("#urlsyasin2").val() == ""){
		$('.rstsyasin2').prop('disabled', true);
	}
	if($("#urlsyasin3").val() == ""){
		$('.rstsyasin3').prop('disabled', true);
	}
	if($("#urlsyasin4").val() == ""){
		$('.rstsyasin4').prop('disabled', true);
	}
	if($("#urlsyasin5").val() == ""){
		$('.rstsyasin5').prop('disabled', true);
	}
	if($("#urlsyasin6").val() == ""){
		$('.rstsyasin6').prop('disabled', true);
	}
	if($("#urlsyasin7").val() == ""){
		$('.rstsyasin7').prop('disabled', true);
	}
	if($("#urlsyasin8").val() == ""){
		$('.rstsyasin8').prop('disabled', true);
	}
	if($("#urlsyasin9").val() == ""){
		$('.rstsyasin9').prop('disabled', true);
	}


	// 写真のアップロード
	$(".syasinbtn, #syasinPath").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin").click();
		}
	});
	// 写真1のアップロード
	$(".syasin1btn, #syasin1Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin1").click();
		}
	});
	// 写真2のアップロード
	$(".syasin2btn, #syasin2Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin2").click();
		}
	});
	// 写真3のアップロード
	$(".syasin3btn, #syasin3Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin3").click();
		}
	});
	// 写真4のアップロード
	$(".syasin4btn, #syasin4Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin4").click();
		}
	});
	// 写真5のアップロード
	$(".syasin5btn, #syasin5Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin5").click();
		}
	});
	// 写真6のアップロード
	$(".syasin6btn, #syasin6Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin6").click();
		}
	});
	// 写真7のアップロード
	$(".syasin7btn, #syasin7Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin7").click();
		}
	});
	// 写真8のアップロード
	$(".syasin8btn, #syasin8Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin8").click();
		}
	});
	// 写真9のアップロード
	$(".syasin9btn, #syasin9Path").click(function () {
		if($("#kurabucd").val() != "") {
			$("#syasin9").click();
		}
	});

	// 写真1
	$( "#syasin" ).change(function() {
		$("#reset").val('');
		$('#syasinTitle').removeAttr('disabled');
		$('.rstsyasin').prop('disabled', false);
		$(".syasinTitle").html("");
		if($("#syasin").val() !="") {
			var iSize = ($("#syasin")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin").val("");
				$("#syasinPath").val("");
				$("#thum").attr('src', $("#image").val());
				$("#syasindd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image").val() == "" ) {
					$("#syasinTitle").val("");
					$("#urltitle").val("");
					$("#image").val("");
					$("#reset").val('1');
					$('#syasinTitle').attr('disabled', 'disabled');
					$('.rstsyasin').prop('disabled', true);
					$("#thum").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasinTitle").html("");
				}
			} else {
				$("#syasindd").html("");
			}
		}
		if(this.value !="") {
			$("#syasinPath").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真1
	$( "#syasin1" ).change(function() {
		$("#reset1").val('');
		$('#syasin1Title').removeAttr('disabled');
		$('.rstsyasin1').prop('disabled', false);
		$(".syasin1Title").html("");
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
					$("#urltitle1").val("");
					$("#image1").val("");
					$("#reset1").val('1');
					$('#syasin1Title').attr('disabled', 'disabled');
					$('.rstsyasin1').prop('disabled', true);
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
		$('.rstsyasin2').prop('disabled', false);
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
					$("#syasin2Title").val("");
					$("#urltitle2").val("");
					$("#image2").val("");
					$("#reset2").val('1');
					$('#syasin2Title').attr('disabled', 'disabled');
					$('.rstsyasin2').prop('disabled', true);
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
		if($("#syasin3").val() !="") {
		$("#reset3").val('');
		$('#syasin3Title').removeAttr('disabled');
		$('.rstsyasin3').prop('disabled', false);
		$(".syasin3Title").html("");
			var iSize = ($("#syasin3")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin3").val("");
				$("#syasin3Path").val("");
				$("#thum03").attr('src', $("#image3").val());
				$("#syasin3dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image3").val() == "" ) {
					$("#syasin3Title").val("");
					$("#urltitle3").val("");
					$("#image3").val("");
					$("#reset3").val('1');
					$('#syasin3Title').attr('disabled', 'disabled');
					$('.rstsyasin3').prop('disabled', true);
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
	// 写真4
	$( "#syasin4" ).change(function() {
		$("#reset4").val('');
		$('#syasin4Title').removeAttr('disabled');
		$('.rstsyasin4').prop('disabled', false);
		$(".syasin4Title").html("");
		if($("#syasin4").val() !="") {
			var iSize = ($("#syasin4")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin4").val("");
				$("#syasin4Path").val("");
				$("#thum04").attr('src', $("#image4").val());
				$("#syasin4dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image4").val() == "" ) {
					$("#syasin4Title").val("");
					$("#urltitle4").val("");
					$("#image4").val("");
					$("#reset4").val('1');
					$('#syasin4Title').attr('disabled', 'disabled');
					$('.rstsyasin4').prop('disabled', true);
					$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin4Title").html("");
				}
			} else {
				$("#syasin4dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin4Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum04").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真5
	$( "#syasin5" ).change(function() {
		$("#reset5").val('');
		$('#syasin5Title').removeAttr('disabled');
		$('.rstsyasin5').prop('disabled', false);
		$(".syasin5Title").html("");
		if($("#syasin5").val() !="") {
			var iSize = ($("#syasin5")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin5").val("");
				$("#syasin5Path").val("");
				$("#thum05").attr('src', $("#image5").val());
				$("#syasin5dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image5").val() == "" ) {
					$("#syasin5Title").val("");
					$("#urltitle5").val("");
					$("#image5").val("");
					$("#reset5").val('1');
					$('#syasin5Title').attr('disabled', 'disabled');
					$('.rstsyasin5').prop('disabled', true);
					$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin5Title").html("");
				}
			} else {
				$("#syasin5dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin5Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum05").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真6
	$( "#syasin6" ).change(function() {
		$("#reset6").val('');
		$('#syasin6Title').removeAttr('disabled');
		$('.rstsyasin6').prop('disabled', false);
		$(".syasin6Title").html("");
		if($("#syasin6").val() !="") {
			var iSize = ($("#syasin6")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin6").val("");
				$("#syasin6Path").val("");
				$("#thum06").attr('src', $("#image6").val());
				$("#syasin6dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image6").val() == "" ) {
					$("#syasin6Title").val("");
					$("#urltitle6").val("");
					$("#image6").val("");
					$("#reset6").val('1');
					$('#syasin6Title').attr('disabled', 'disabled');
					$('.rstsyasin6').prop('disabled', true);
					$("#thum06").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin6Title").html("");
				}
			} else {
				$("#syasin6dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin6Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum06").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真7
	$( "#syasin7" ).change(function() {
		$("#reset7").val('');
		$('#syasin7Title').removeAttr('disabled');
		$('.rstsyasin7').prop('disabled', false);
		$(".syasin7Title").html("");
		if($("#syasin7").val() !="") {
			var iSize = ($("#syasin7")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin7").val("");
				$("#syasin7Path").val("");
				$("#thum07").attr('src', $("#image7").val());
				$("#syasin7dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image7").val() == "" ) {
					$("#syasin7Title").val("");
					$("#urltitle7").val("");
					$("#image7").val("");
					$("#reset7").val('1');
					$('#syasin7Title').attr('disabled', 'disabled');
					$('.rstsyasin7').prop('disabled', true);
					$("#thum07").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin7Title").html("");
				}
			} else {
				$("#syasin7dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin7Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum07").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真8
	$( "#syasin8" ).change(function() {
		$("#reset8").val('');
		$('#syasin8Title').removeAttr('disabled');
		$('.rstsyasin8').prop('disabled', false);
		$(".syasin8Title").html("");
		if($("#syasin8").val() !="") {
			var iSize = ($("#syasin8")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin8").val("");
				$("#syasin8Path").val("");
				$("#thum08").attr('src', $("#image8").val());
				$("#syasin8dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image8").val() == "" ) {
					$("#syasin8Title").val("");
					$("#urltitle8").val("");
					$("#image8").val("");
					$("#reset8").val('1');
					$('#syasin8Title').attr('disabled', 'disabled');
					$('.rstsyasin8').prop('disabled', true);
					$("#thum08").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin8Title").html("");
				}
			} else {
				$("#syasin8dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin8Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum08").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真9
	$( "#syasin9" ).change(function() {
		$("#reset9").val('');
		$('#syasin9Title').removeAttr('disabled');
		$('.rstsyasin9').prop('disabled', false);
		$(".syasin9Title").html("");
		if($("#syasin9").val() !="") {
			var iSize = ($("#syasin9")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin9").val("");
				$("#syasin9Path").val("");
				$("#thum09").attr('src', $("#image9").val());
				$("#syasin9dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image9").val() == "" ) {
					$("#syasin9Title").val("");
					$("#urltitle9").val("");
					$("#image9").val("");
					$("#reset9").val('1');
					$('#syasin9Title').attr('disabled', 'disabled');
					$('.rstsyasin9').prop('disabled', true);
					$("#thum09").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					$(".syasin9Title").html("");
				}
			} else {
				$("#syasin9dd").html("");
			}
		}
		if(this.value !="") {
			$("#syasin9Path").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum09").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 写真のリセット
	$(".rstsyasin").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasinPath").val("");
						$("#syasindd").html("");
						$("#syasinTitle").val("");
						$("#syasin").val("");
						$("#urltitle").val("");
						$("#image").val("");
						$("#reset").val('1');
						$('#syasinTitle').attr('disabled', 'disabled');
						$('.rstsyasin').prop('disabled', true);
						// $("label[for='syasinTitle']").empty();
						$("#thum").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasinTitle").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真1のリセット
	$(".rstsyasin1").click(function () {
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
						$("#urltitle1").val("");
						$("#image1").val("");
						$("#reset1").val('1');
						$('#syasin1Title').attr('disabled', 'disabled');
						$('.rstsyasin1').prop('disabled', true);
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
	$(".rstsyasin2").click(function () {
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
						$("#urltitle2").val("");
						$("#image2").val("");
						$("#reset2").val('1');
						$('#syasin2Title').attr('disabled', 'disabled');
						$('.rstsyasin2').prop('disabled', true);
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
	$(".rstsyasin3").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin3Path").val("");
						$("#syasin3dd").html("");
						$("#syasin3Title").val("");
						$("#syasin3").val("");
						$("#urltitle3").val("");
						$("#image3").val("");
						$("#reset3").val('1');
						$('#syasin3Title').attr('disabled', 'disabled');
						$('.rstsyasin3').prop('disabled', true);
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
	// 写真4のリセット
	$(".rstsyasin4").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin4Path").val("");
						$("#syasin4dd").html("");
						$("#syasin4Title").val("");
						$("#syasin4").val("");
						$("#urltitle4").val("");
						$("#image4").val("");
						$("#reset4").val('1');
						$('#syasin4Title').attr('disabled', 'disabled');
						$('.rstsyasin4').prop('disabled', true);
						// $("label[for='syasin4Title']").empty();
						$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin4Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真5のリセット
	$(".rstsyasin5").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin5Path").val("");
						$("#syasin5dd").html("");
						$("#syasin5Title").val("");
						$("#syasin5").val("");
						$("#urltitle5").val("");
						$("#image5").val("");
						$("#reset5").val('1');
						$('#syasin5Title').attr('disabled', 'disabled');
						$('.rstsyasin5').prop('disabled', true);
						// $("label[for='syasin5Title']").empty();
						$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin5Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真6のリセット
	$(".rstsyasin6").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin6Path").val("");
						$("#syasin6dd").html("");
						$("#syasin6Title").val("");
						$("#syasin6").val("");
						$("#urltitle6").val("");
						$("#image6").val("");
						$("#reset6").val('1');
						$('#syasin6Title').attr('disabled', 'disabled');
						$('.rstsyasin6').prop('disabled', true);
						// $("label[for='syasin6Title']").empty();
						$("#thum06").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin6Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真7のリセット
	$(".rstsyasin7").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin7Path").val("");
						$("#syasin7dd").html("");
						$("#syasin7Title").val("");
						$("#syasin7").val("");
						$("#urltitle7").val("");
						$("#image7").val("");
						$("#reset7").val('1');
						$('#syasin7Title').attr('disabled', 'disabled');
						$('.rstsyasin7').prop('disabled', true);
						// $("label[for='syasin7Title']").empty();
						$("#thum07").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin7Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真8のリセット
	$(".rstsyasin8").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin8Path").val("");
						$("#syasin8dd").html("");
						$("#syasin8Title").val("");
						$("#syasin8").val("");
						$("#urltitle8").val("");
						$("#image8").val("");
						$("#reset8").val('1');
						$('#syasin8Title').attr('disabled', 'disabled');
						$('.rstsyasin8').prop('disabled', true);
						// $("label[for='syasin8Title']").empty();
						$("#thum08").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin8Title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 写真9のリセット
	$(".rstsyasin9").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#syasin9Path").val("");
						$("#syasin9dd").html("");
						$("#syasin9Title").val("");
						$("#syasin9").val("");
						$("#urltitle9").val("");
						$("#image9").val("");
						$("#reset9").val('1');
						$('#syasin9Title').attr('disabled', 'disabled');
						$('.rstsyasin9').prop('disabled', true);
						// $("label[for='syasin9Title']").empty();
						$("#thum09").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
						$(".syasin9Title").html("");
					}
				},
				キャンセル: function () {
				}
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
	$("#kurabucd").on("focus",function () {
        previous = $("#kurabucd").val(); 
    });

	$("#kurabucd").change(function () {
        current = $("#kurabucd").val(); 
        if(current!="") {
        	$(".buttonsearch").prop("disabled",false);
        }
        if(current=="sample") {
        	$(".buttonsearch").prop("disabled",false);
			$("#gaiyou").prop("disabled",false);
			$("#syokumu").prop("disabled",false);
			$("#kanji").prop("disabled",false);
			$("#kmember").prop("disabled",false);
			$("#njyoken").prop("disabled",false);
			$("#nhouhou").prop("disabled",false);
			$("#bikou").prop("disabled",false);
			$("#newRegister").prop("disabled",false);
			$("#mailchk").prop("disabled",false);
			$("#Preview").prop("disabled",false);
			//$("#syasinPath").prop("disabled",false);
			$("#syasinTitle").prop("disabled",false);
			$("#syasin1Title").prop("disabled",false);
			$("#syasin2Title").prop("disabled",false);
			$("#syasin3Title").prop("disabled",false);
			$("#syasin4Title").prop("disabled",false);
			$("#syasin5Title").prop("disabled",false);
			$("#syasin6Title").prop("disabled",false);
			$("#syasin7Title").prop("disabled",false);
			$("#syasin8Title").prop("disabled",false);
			$("#syasin9Title").prop("disabled",false);

			$(".syasinbtn").prop("disabled",false); 
			$(".syasin1btn").prop("disabled",false); 
			$(".syasin2btn").prop("disabled",false); 
			$(".syasin3btn").prop("disabled",false); 
			$(".syasin4btn").prop("disabled",false); 
			$(".syasin5btn").prop("disabled",false); 
			$(".syasin6btn").prop("disabled",false); 
			$(".syasin7btn").prop("disabled",false); 
			$(".syasin8btn").prop("disabled",false); 
			$(".syasin9btn").prop("disabled",false); 

			$('input[name="koukaikbn"]').attr('disabled', false);
			$("#mailchk").attr("disabled", false);

			//$("#syasinPath").prop("onclick",return false); 
			//$('.rstsyasin').prop('disabled', false);
        }
		if(previous!="") {
			$.confirm({
				title: '',
				content: BACK_PAGE,
				type: 'blue',
				buttons: {
					OK: {
						action: function(){
							// 画面の入力、選択内容をクリアする
							$("label[class='error']").empty();
							$("label[class='error']").css("padding","0");
							
							$("#gaiyou").val("");
							$("#syokumu").val("");
							$("#kanji").val("");
							$("#kmember").val("");
							$("#njyoken").val("");
							$("#nhouhou").val("");
							$("#bikou").val("");

							$("#image").val("");
							$("#reset").val("");
							$("#urlsyasin").val("");
							$("#syasin").val("");
							$("#syasinPath").val("");
							$("#thum").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasinTitle").val("");

							$("#image1").val("");
							$("#reset1").val("");
							$("#urlsyasin1").val("");
							$("#syasin1").val("");
							$("#syasin1Path").val("");
							$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin1Title").val("");

							$("#image2").val("");
							$("#reset2").val("");
							$("#urlsyasin2").val("");
							$("#syasin2").val("");
							$("#syasin2Path").val("");
							$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin2Title").val("");

							$("#image3").val("");
							$("#reset3").val("");
							$("#urlsyasin3").val("");
							$("#syasin3").val("");
							$("#syasin3Path").val("");
							$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin3Title").val("");

							$("#image4").val("");
							$("#reset4").val("");
							$("#urlsyasin4").val("");
							$("#syasin4").val("");
							$("#syasin4Path").val("");
							$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin4Title").val("");

							$("#image5").val("");
							$("#reset5").val("");
							$("#urlsyasin5").val("");
							$("#syasin5").val("");
							$("#syasin5Path").val("");
							$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin5Title").val("");

							$("#image6").val("");
							$("#reset6").val("");
							$("#urlsyasin6").val("");
							$("#syasin6").val("");
							$("#syasin6Path").val("");
							$("#thum06").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin6Title").val("");

							$("#image7").val("");
							$("#reset7").val("");
							$("#urlsyasin7").val("");
							$("#syasin7").val("");
							$("#syasin7Path").val("");
							$("#thum07").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin7Title").val("");

							$("#image8").val("");
							$("#reset8").val("");
							$("#urlsyasin8").val("");
							$("#syasin8").val("");
							$("#syasin8Path").val("");
							$("#thum08").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin8Title").val("");

							$("#image9").val("");
							$("#reset9").val("");
							$("#urlsyasin9").val("");
							$("#syasin9").val("");
							$("#syasin9Path").val("");
							$("#thum09").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
							$("#syasin9Title").val("");

							$(".rstsyasin").prop("disabled",true); 
							$(".rstsyasin1").prop("disabled",true); 
							$(".rstsyasin2").prop("disabled",true); 
							$(".rstsyasin3").prop("disabled",true); 
							$(".rstsyasin4").prop("disabled",true); 
							$(".rstsyasin5").prop("disabled",true); 
							$(".rstsyasin6").prop("disabled",true); 
							$(".rstsyasin7").prop("disabled",true); 
							$(".rstsyasin8").prop("disabled",true); 
							$(".rstsyasin9").prop("disabled",true);

							$("#mailchk").prop("checked",false);

					        if(current=="") {
					        	$(".buttonsearch").prop("disabled",true);
					        }
								$("#gaiyou").prop("disabled",true);
								$("#syokumu").prop("disabled",true);
								$("#kanji").prop("disabled",true);
								$("#kmember").prop("disabled",true);
								$("#njyoken").prop("disabled",true);
								$("#nhouhou").prop("disabled",true);
								$("#bikou").prop("disabled",true);

								$("#syasinPath").prop("disabled",true);
								$("#syasin1Path").prop("disabled",true);
								$("#syasin2Path").prop("disabled",true);
								$("#syasin3Path").prop("disabled",true);
								$("#syasin4Path").prop("disabled",true);
								$("#syasin5Path").prop("disabled",true);
								$("#syasin6Path").prop("disabled",true);
								$("#syasin7Path").prop("disabled",true);
								$("#syasin8Path").prop("disabled",true);
								$("#syasin9Path").prop("disabled",true);

								$("#syasinTitle").prop("disabled",true);
								$("#syasin1Title").prop("disabled",true);
								$("#syasin2Title").prop("disabled",true);
								$("#syasin3Title").prop("disabled",true);
								$("#syasin4Title").prop("disabled",true);
								$("#syasin5Title").prop("disabled",true);
								$("#syasin6Title").prop("disabled",true);
								$("#syasin7Title").prop("disabled",true);
								$("#syasin8Title").prop("disabled",true);
								$("#syasin9Title").prop("disabled",true);

								$(".syasinbtn").prop("disabled",true);
								//$(".syasinbtn").prop("disabled",true); 
								$(".syasin1btn").prop("disabled",true); 
								$(".syasin2btn").prop("disabled",true); 
								$(".syasin3btn").prop("disabled",true); 
								$(".syasin4btn").prop("disabled",true); 
								$(".syasin5btn").prop("disabled",true); 
								$(".syasin6btn").prop("disabled",true); 
								$(".syasin7btn").prop("disabled",true); 
								$(".syasin8btn").prop("disabled",true); 
								$(".syasin9btn").prop("disabled",true); 

								//$('#newRegister').prop('disabled', true);
								$('#newRegister').prop('disabled', true);
								$('#Preview').prop('disabled', true);
								$('#mailchk').prop('disabled', true); 
								$("#koukaikbn_r1").prop('checked', true);
								$('input[name="koukaikbn"]').attr('disabled', 'disabled');
								$('#newUpdate').prop('disabled', true);
								//$("#syasinPath").prop("onclick",return true); 
								//$('.rstsyasin').prop('disabled', true);
							// }
						}
					},
					キャンセル: function () {
							$("#kurabucd").val(previous);
					}
				}
			});
		}
		$("#koukaikbn").val(1);
		$(".buttonsearch").focus();
	});
	$(".b-preview").click(function () {
		$('#previewflg').val('1');
		$('#ClubInfoadd').submit();
	});
	$(".back-preview").click(function () {
		$('#frmClub').attr('action', '../Club/index');
		$('#frmClub').submit();
	});
	$(".b-release").click(function () {
		$('#ClubInfoadd').submit();
	}); 
});
jQuery.validator.addMethod("syasinPathreq", function(value, element) {
	if (value == "" && $("#urlsyasin").val() == "") {
		return false;
	} else if (value == "" && $("#reset").val() == "1") {
		return false;
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval", function(value, element) {
	if(value != "") {
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		if ($.inArray(lastChar, fileExtension) == -1) {
			if($("#image").val() == "" ) {
		    	$("#syasinPath").val("");
				$("#syasinTitle").val("");
				$("#syasin").val("");
				$('#syasinTitle').attr('disabled', 'disabled');
				$('.rstsyasin').prop('disabled', true);
				$("label[class='syasinTitle']").empty();
				$("#thum").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum").attr('src', $("#image").val());
				$("#syasinTitle").val($("#urltitle").val());
				$("#syasin").val("");
				$("#syasinPath").val("");
			}
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval1", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		if ($.inArray(lastChar, fileExtension) == -1) {
			if($("#image1").val() == "" ) {
				$("#syasin1Path").val("");
				$("#syasin1Title").val("");
				$("#syasin1").val("");
				$('#syasin1Title').attr('disabled', 'disabled');
				$('.rstsyasin1').prop('disabled', true);
				$("label[class='syasin1Title']").empty();
				$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum01").attr('src', $("#image1").val());
				$("#syasin1Title").val($("#urltitle1").val());
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
				$("#syasin2Path").val("");
				$("#syasin2Title").val("");
				$("#syasin2").val("");
				$('#syasin2Title').attr('disabled', 'disabled');
				$('.rstsyasin2').prop('disabled', true);
				$("label[class='syasin2Title']").empty();
				$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum02").attr('src', $("#image2").val());
				$("#syasin2Title").val($("#urltitle2").val());
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
				$("#syasin3Path").val("");
				$("#syasin3Title").val("");
				$("#syasin3").val("");
				$('#syasin3Title').attr('disabled', 'disabled');
				$('.rstsyasin3').prop('disabled', true);
				$("label[class='syasin3Title']").empty();
				$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum03").attr('src', $("#image3").val());
				$("#syasin3Title").val($("#urltitle3").val());
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
jQuery.validator.addMethod("imgval4", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	if($("#image4").val() == "" ) {
				$("#syasin4Path").val("");
				$("#syasin4Title").val("");
				$("#syasin4").val("");
				$('#syasin4Title').attr('disabled', 'disabled');
				$('.rstsyasin4').prop('disabled', true);
				$("label[class='syasin4Title']").empty();
				$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum04").attr('src', $("#image4").val());
				$("#syasin4Title").val($("#urltitle4").val());
				$("#syasin4").val("");
				$("#syasin4Path").val("");
			}
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval5", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	if($("#image5").val() == "" ) {
				$("#syasin5Path").val("");
				$("#syasin5Title").val("");
				$("#syasin5").val("");
				$('#syasin5Title').attr('disabled', 'disabled');
				$('.rstsyasin5').prop('disabled', true);
				$("label[class='syasin5Title']").empty();
				$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum05").attr('src', $("#image5").val());
				$("#syasin5Title").val($("#urltitle5").val());
				$("#syasin5").val("");
				$("#syasin5Path").val("");
			}
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval6", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	if($("#image6").val() == "" ) {
				$("#syasin6Path").val("");
				$("#syasin6Title").val("");
				$("#syasin6").val("");
				$('#syasin6Title').attr('disabled', 'disabled');
				$('.rstsyasin6').prop('disabled', true);
				$("label[class='syasin6Title']").empty();
				$("#thum06").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum06").attr('src', $("#image6").val());
				$("#syasin6Title").val($("#urltitle6").val());
				$("#syasin6").val("");
				$("#syasin6Path").val("");
			}
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval7", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	if($("#image7").val() == "" ) {
				$("#syasin7Path").val("");
				$("#syasin7Title").val("");
				$("#syasin7").val("");
				$('#syasin7Title').attr('disabled', 'disabled');
				$('.rstsyasin7').prop('disabled', true);
				$("label[class='syasin7Title']").empty();
				$("#thum07").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum07").attr('src', $("#image7").val());
				$("#syasin7Title").val($("#urltitle7").val());
				$("#syasin7").val("");
				$("#syasin7Path").val("");
			}
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval8", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	if($("#image8").val() == "" ) {
				$("#syasin8Path").val("");
				$("#syasin8Title").val("");
				$("#syasin8").val("");
				$('#syasin8Title').attr('disabled', 'disabled');
				$('.rstsyasin8').prop('disabled', true);
				$("label[class='syasin8Title']").empty();
				$("#thum08").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum08").attr('src', $("#image8").val());
				$("#syasin8Title").val($("#urltitle8").val());
				$("#syasin8").val("");
				$("#syasin8Path").val("");
			}
	    	return false;
	    } else {
	    	return true;
	    }
	} else {
		return true;
	}
});
jQuery.validator.addMethod("imgval9", function(value, element) {
	if(value != ""){
		var lastChar = value.substr(value.lastIndexOf('.') + 1);
		var lastChar = lastChar.toLowerCase();
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
	    if ($.inArray(lastChar, fileExtension) == -1) {
	    	if($("#image9").val() == "" ) {
				$("#syasin9Path").val("");
				$("#syasin9Title").val("");
				$("#syasin9").val("");
				$('#syasin9Title').attr('disabled', 'disabled');
				$('.rstsyasin9').prop('disabled', true);
				$("label[class='syasin9Title']").empty();
				$("#thum09").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
			} else {
				$("#thum09").attr('src', $("#image9").val());
				$("#syasin9Title").val($("#urltitle9").val());
				$("#syasin9").val("");
				$("#syasin9Path").val("");
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
			$('#ClubInfoadd').validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					$('#previewflg').val('0');
					$("#syasindd").html("");
					if(element.attr("name") == "syasinPath") {
						error.appendTo('#syasindd');
					} else if(element.attr("name") == "syasin1Path") {
						error.appendTo('#syasin1dd');
					} else if(element.attr("name") == "syasin2Path") {
						error.appendTo('#syasin2dd');
					} else if(element.attr("name") == "syasin3Path") {
						error.appendTo('#syasin3dd');
					} else if(element.attr("name") == "syasin4Path") {
						error.appendTo('#syasin4dd');
					} else if(element.attr("name") == "syasin5Path") {
						error.appendTo('#syasin5dd');
					} else if(element.attr("name") == "syasin6Path") {
						error.appendTo('#syasin6dd');
					} else if(element.attr("name") == "syasin7Path") {
						error.appendTo('#syasin7dd');
					} else if(element.attr("name") == "syasin8Path") {
						error.appendTo('#syasin8dd');
					} else if(element.attr("name") == "syasin9Path") {
						error.appendTo('#syasin9dd');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					//概要
					gaiyou:{
						required:true
					},
					//写真のパス
					syasinPath: {
						syasinPathreq:true,
						imgval:true
					},
					//写真ファイル
					syasinTitle: {
						required:true
					},
					syasin1Path: "imgval1",
					syasin2Path: "imgval2",
					syasin3Path: "imgval3",
					syasin4Path: "imgval4",
					syasin5Path: "imgval5",
					syasin6Path: "imgval6",
					syasin7Path: "imgval7",
					syasin8Path: "imgval8",
					syasin9Path: "imgval9",
				},
				messages: {
					//概要
					gaiyou:{
						required:"概要を入力してください。"
					},
					//写真のパス
					syasinPath: {
						syasinPathreq:"一覧写真を選択してください。",
						imgval:"画像しか入力できません。画像を入力してください。"
					},
					//写真ファイル
					syasinTitle: {
						required:"一覧写真タイトルを入力してください。"
					},
					syasin1Path : "画像しか入力できません。画像を入力してください。",
					syasin2Path : "画像しか入力できません。画像を入力してください。",
					syasin3Path : "画像しか入力できません。画像を入力してください。",
					syasin4Path : "画像しか入力できません。画像を入力してください。",
					syasin5Path : "画像しか入力できません。画像を入力してください。",
					syasin6Path : "画像しか入力できません。画像を入力してください。",
					syasin7Path : "画像しか入力できません。画像を入力してください。",
					syasin8Path : "画像しか入力できません。画像を入力してください。",
					syasin9Path : "画像しか入力できません。画像を入力してください。",
				},
				submitHandler: function(form) {
					if($("#urlsyasin").val() == "" && $("#syasinPath").val() == ""){
						$("#syasindd").text("画像しか入力できません。画像を入力してください。");
						$("#syasinPath").focus();
						return false;
					}else if ($("#urlsyasin").val() == 1 && $("#image").val() == "" && $("#syasinPath").val() == ""){
						$("#syasindd").text("画像しか入力できません。画像を入力してください。");
						$("#syasinPath").focus();
						return false;
					}
					if($("#syasinTitle").val() == ""){
						$("#syasinTitle").text("一覧写真タイトルを入力してください。");
						return false;
					}
					if($("#urlsyasin").val() != "") {
						var CONFIRM_MSG = UPDATE_CONFIRM;
						var SUCCESS_MSG = UPDATE_SUCCESS;
						var FAILURE_MSG = UPDATE_FAILURE;
						var PAGELOAD = 'updatecls';
					} else {
						var CONFIRM_MSG = INSERT_CONFIRM;
						var SUCCESS_MSG = INSERT_SUCCESS;
						var FAILURE_MSG = INSERT_FAILURE;
						var PAGELOAD = 'registercls';
					}
					if($('#previewflg').val() == 1 ) {
						$('#kurabunm').val($('#kurabucd option:selected').text());
						$('#kurabucdinsert').val($("#kurabucd").val());
						$('#ClubInfoadd').attr('target', '_blank');
						$('#ClubInfoadd').attr('action', '../Club/detail');
						$('#previewflg').val('0');
						form.submit();
					} else {
						$.confirm({
							title: '',
							content: CONFIRM_MSG,
							type: 'blue',
							buttons: {
								OK: {
									action: function(){
										$('#kurabunm').val($('#kurabucd option:selected').text());
										$("#registercls").addClass(PAGELOAD);
					                	$('.b-release').prop('disabled', true);
										$('#ClubInfoadd').attr('target', '');
										$('#ClubInfoadd').attr('action', '../AdminClubInfo/register');
										var data = new FormData();
										var serializedData = $("#ClubInfoadd").serialize();
										var serializedDatas = $("#ClubInfoedit").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('syasin', $("#syasin").get(0).files[0]);
										data.append('syasin1', $("#syasin1").get(0).files[0]);
										data.append('syasin2', $("#syasin2").get(0).files[0]);
										data.append('syasin3', $("#syasin3").get(0).files[0]);
										data.append('syasin4', $("#syasin4").get(0).files[0]);
										data.append('syasin5', $("#syasin5").get(0).files[0]);
										data.append('syasin6', $("#syasin6").get(0).files[0]);
										data.append('syasin7', $("#syasin7").get(0).files[0]);
										data.append('syasin8', $("#syasin8").get(0).files[0]);
										data.append('syasin9', $("#syasin9").get(0).files[0]);
										data.append('otherFields', serializedData);
										data.append('otherFieldssearch', serializedDatas);
										//data.append('file1', $("#file1").get(0).files[0]);
										var xhr = new XMLHttpRequest();
									 	xhr.open('POST', 'register', true);
									 	xhr.send(data);
									 	xhr.onload = function () {
									 		$("#registercls").removeClass(PAGELOAD);
									 		//alert(xhr.responseText);
									 		if(xhr.responseText == "1") {
										 		if (xhr.status === 200) {
										 			$.confirm({
														title: '',
														content: SUCCESS_MSG,
														type: 'blue',
														buttons: {
															OK: {
																btnClass: 'btn-blue',
																keys: ['enter'],
																action: function(){
																	$('#menuFrm').attr('action', '../AdminClubInfo/edit');
																	$("#menuFrm").submit();
																}
															}
														}
													});
												} else {
													$.confirm({
														title: '',
														content: FAILURE_MSG,
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
										 	// 	$(".shinkicatagery").html("");
												// $(".filetitle").html("");
												// $(".filepath").html("");
												// $(".hyojino").html("");
										 	//  	$(".rno").val("");
												// $(".filetitle").html("");
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
				}
			});
		}
	}
	$(D).ready(function($) {
		jqueryValidation.UTIL.setupFormValidation();
	});
})(jQuery, window, document);
