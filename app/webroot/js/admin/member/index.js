$(document).ready(function() {
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	$('#kaiincd_err').hide();
	$("#kaiincd").bind('blur',function(e) { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	    if($("#kaiincd").val() == "") {
			$('#kaiincd_err').hide();
		}
	});
	$("#kaisyacd").bind('blur',function(e) { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	    if($("#kaisyacd").val() == "") {
			$('#kaiincd_err').hide();
		}
	});
	$('#lgpass').blur(function() {
        this.value = this.value.replace(/\s+/g, '');
    });
    $("#searchbutton").click(function () {
		$("#selectedOrder").val('');
	});
});
$(function() {
	// 会員追加。
	$(".addValue").click(function () {
			// 会員コード
			$("#kaiinaddfrm #kaiincd").val($(this).attr("data-kaiincd"));
			// 会社コード
			$("#kaiinaddfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
			// フォーム提出
			$( "#kaiinaddfrm" ).submit();
	});
	//  会員編集。
	$(".editValue").click(function(){
			// 会員コード
			$("#kaiineditfrm #kaiincd").val($(this).attr("data-kaiincd"));
			// 会社コード
			$("#kaiineditfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
			// フォーム提出
			$( "#kaiineditfrm" ).submit();
	});
	// 追加プレビュー
	$(".b-preview").click(function(){
		$('#previewflg').val('0');
		$('#newListAddFrm').attr('target', '_blank');
		$('#newListAddFrm').attr('action', '../members/detail');
		$('#newListAddFrm').submit();
	});
	// 登録
	$(".b-release").click(function(){
		$('#previewflg').val('1');
		$('#newListAddFrm').attr('target', '');
		$('#newListAddFrm').attr('action', '../adminMember/add');
		$('#newListAddFrm').submit();
	});
	// 編集プレビュー
	$(".e-preview").click(function(){
		$('#previewflg').val('0');
		$('#editfrm').attr('target', '_blank');
		$('#editfrm').attr('action', '../members/detail');
		$('#editfrm').submit();
	});
	$(".e-release").click(function(){
		$('#previewflg').val('1');
		$('#editfrm').attr('target', '');
		$('#editfrm').attr('action', '../adminMember/memberEdit');
		$('#editfrm').submit();
	});
	$(".e2-release").click(function(){
		$('#previewflg').val('1');
		$('#editfrm').attr('target', '');
		$('#editfrm').attr('action', '../adminMember/memberEdit2');
		$('#editfrm').submit();
	});
	// 編集プレビュー
	$(".preview").click(function(){
		$('#previewflg').val('0');
		$('#memberAddFrm').attr('target', '_blank');
		$('#memberAddFrm').attr('action', '../members/detail');
		$('#memberAddFrm').submit();
	});
	// 編集プレビュー
	$(".release").click(function(){
		$('#previewflg').val('1');
		$('#memberAddFrm').attr('target', '');
		$('#memberAddFrm').attr('action', '../adminMember/memberAdd');
		$('#memberAddFrm').submit();
	});
	$(".delete").click(function(){
		var kaiincd = $(this).attr("data-kaiincd");
		var kaisyacd = $(this).attr("data-kaisyacd");
		var syasinkey = $(this).attr("data-syasinkey");
		$.confirm({
			title: '',
			content: "削除を実行しますとデータがディスク上から消去されます。<br/>削除してもよろしいですか？<br/><br/>※&nbsp;退会や休会は、会員情報編集ページで該当項目を<br/>&nbsp;&nbsp;&nbsp;&nbsp;更新してください。",
			type: 'blue',
	        columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
			buttons: {
				OK: {
					action: function(){
						var data = new FormData();
						data.append('kaiincd', kaiincd);
						data.append('kaisyacd', kaisyacd);
						data.append('syasinkey', syasinkey);
						var xhr = new XMLHttpRequest();
					 	xhr.open('POST', 'delete', true);
					 	xhr.send(data);
					 	xhr.onload = function () {
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
												$('#TKaiinSearchForm').submit();
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
								
							}
				 		};
						// // 会員コード
						// $("#kaiindeletefrm #kaiincd").val(kaiincd);
						// // 会社コード
						// $("#kaiindeletefrm #kaisyacd").val(kaisyacd);
						// $("#kaiindeletefrm #syasinkey").val(syasinkey);
						// // フォーム提出
			    		//$("#kaiindeletefrm").submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 会員の写真
	$( "#kaiinsyasin" ).change(function() {
		$("#resetKaiin").val("");
		$('.add2KaiinSyasinReset').prop('disabled', false);
		$('.rstKaiinSyasin').prop('disabled', false);
		$('.kaiinReset').prop('disabled', false);
		$("#ksyasintitle").prop("disabled", false);
		if ($("#kaiinsyasin").val() != "") {
			var iSize = ($("#kaiinsyasin")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#kaiinsyasin").val("");
				$("#kainnsyasin").val("");
				$("#thum01").attr('src', $("#image1").val());
				$("#kaiinerror").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image1").val() == "" || ($('#image1').length) == 0) {
					$("#resetKaiin").val("1");
					$("#image1").val("");
					$("#ksyasintitle").val("");
					$("#ksyasintitle").prop("disabled", true);
					$('.kaiinReset').prop('disabled', true);
					$('.add2KaiinSyasinReset').prop('disabled', true);
					$('.rstKaiinSyasin').prop('disabled', true);
					$("#urlkaiinsyasin").val("");
					$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
				}
			} else {
				$("#kaiinerror").html("");
			}
		}
		if(this.value !="") {
			$("#kainnsyasin").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum01").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 会員の写真のアップロード
	$(".kaiinbtn").click(function () {
		$("#kaiinsyasin").click();
	});
	// 会員の写真のリセット
	$(".rstKaiinSyasin").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#kainnsyasin").val("");
						$("#ksyasintitle").val("");
						$("#kaiinsyasin").val("");
						$("#ksyasintitle").prop("disabled", true);
						$('.rstKaiinSyasin').prop('disabled', true);
						$("#kaiinerror").html("");
						$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 会社ロゴ
	$( "#kaisyalogo" ).change(function() {
		$("#resetLogo").val("");
		if ($("#kaisyalogo").val() != "") {
			$('.rstkaisyalogo').prop('disabled', false);
			$('.kaisyaLogoReset').prop('disabled', false);
			var iSize = ($("#kaisyalogo")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#kaisyalogo").val("");
				$("#klogo").val("");
				$("#thum02").attr('src', $("#image2").val());
				$("#klogo_err").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image2").val() == "" || ($('#image2').length) == 0) {
					$("#resetLogo").val("1");
					$('.rstkaisyalogo').prop('disabled', true);
					$('.kaisyaLogoReset').prop('disabled', true);
					$("#urlkaisyalogo").val("");
					$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
				}
			} else {
				$("#klogo_err").html("");
			}
		}
		if(this.value !="") {
			$("#klogo").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum02").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// 会社ロゴのアップロード
	$(".kaisyalogobtn").click(function () {
		$("#kaisyalogo").click();
	});
	// 会社ロゴのリセット
	$(".rstkaisyalogo").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#klogo").val("");
						$("#kaisyalogo").val("");
						$("#klogo_err").html("");
						$('.rstkaisyalogo').prop('disabled', true);
						$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// PRイメージ1
	$( "#primage1" ).change(function() {
		$('.addPrImageReset1').prop('disabled', false);
		$("#syasintitle1").prop("disabled", false);
		if ($("#primage1").val() != "") {
			var iSize = ($("#primage1")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin1").val("");
				$("#primage1").val("");
				$("#thum03").attr('src', $("#image3").val());
				$("#syasin1dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image3").val() == "" || ($('#image3').length) == 0) {
					$("#reset1").val('1');
					$("#image3").val("");
					$("#syasintitle1").val("");
					$("#syasintitle1").prop("disabled", true);
					$('.addPrImageReset1').prop('disabled', true);
					$("#urlprimage1").val("");
					$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				}
			} else {
				$("#syasin1dd").html("");
			}
		}
		$("#reset1").val('');
		if(this.value !="") {
			$("#syasin1").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum03").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// PRイメージ1のアップロード
	$(".primagebtn1").click(function () {
		$("#primage1").click();
	});
	// PRイメージ1のリセット
	$(".addPrImageReset1").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#reset1").val('1');
						$("#image3").val("");
						$("#syasin1").val("");
						$("#syasintitle1").val("");
						$("#syasintitle1").prop("disabled", true);
						$('.addPrImageReset1').prop('disabled', true);
						$("#urlprimage1").val("");
						$("#primage1").val("");
						$("#syasin1dd").html("");
						$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// PRイメージ2
	$( "#primage2" ).change(function() {
		$('.addPrImageReset2').prop('disabled', false);
		$("#syasintitle2").prop("disabled", false);
		if ($("#primage2").val() != "") {
			var iSize = ($("#primage2")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin2").val("");
				$("#primage2").val("");
				$("#thum04").attr('src', $("#image4").val());
				$("#syasin2dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image4").val() == "" || ($('#image4').length) == 0) {
					$("#reset2").val('1');
					$("#image4").val("");
					$("#syasintitle2").val("");
					$("#syasintitle2").prop("disabled", true);
					$('.addPrImageReset2').prop('disabled', true);
					$("#urlprimage2").val("");
					$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				}
			} else {
				$("#syasin2dd").html("");
			}
		}
		$("#reset2").val('');
		if(this.value !="") {
			$("#syasin2").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum04").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// PRイメージ2のアップロード
	$(".primagebtn2").click(function () {
		$("#primage2").click();
	});
	// PRイメージ2のリセット
	$(".addPrImageReset2").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#reset2").val('1');
						$("#image4").val("");
						$("#syasin2").val("");
						$("#syasintitle2").val("");
						$("#syasintitle2").prop("disabled", true);
						$('.addPrImageReset2').prop('disabled', true);
						$("#urlprimage2").val("");
						$("#primage2").val("");
						$("#syasin2dd").html("");
						$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// PRイメージ3
	$( "#primage3" ).change(function() {
		$('.addPrImageReset3').prop('disabled', false);
		$("#syasintitle3").prop("disabled", false);
		if ($("#primage3").val() != "") {
			var iSize = ($("#primage3")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#syasin3").val("");
				$("#primage3").val("");
				$("#thum05").attr('src', $("#image5").val());
				$("#syasin3dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#image5").val() == "" || ($('#image5').length) == 0) {
					$("#reset3").val('1');
					$("#image5").val("");
					$("#syasintitle3").val("");
					$("#syasintitle3").prop("disabled", true);
					$('.addPrImageReset3').prop('disabled', true);
					$("#urlprimage3").val("");
					$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				}
			} else {
				$("#syasin3dd").html("");
			}
		}
		$("#reset3").val('');
		if(this.value !="") {
			$("#syasin3").val(this.value);
		}
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#thum05").attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	// PRイメージ3のアップロード
	$(".primagebtn3").click(function () {
		$("#primage3").click();
	});
	// PRイメージ3のリセット
	$(".addPrImageReset3").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#reset3").val('1');
						$("#image5").val("");
						$("#syasin3").val("");
						$("#syasintitle3").val("");
						$("#syasintitle3").prop("disabled", true);
						$('.addPrImageReset3').prop('disabled', true);
						$("#urlprimage3").val("");
						$("#primage3").val("");
						$("#syasin3dd").html("");
						$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});

	// 会員の写真のアップロード
	$(".addKaiinsyasinbtn").click(function () {
		$("#kaiinsyasin").click();
	});
	// 会員の写真のリセット
	$(".add2KaiinSyasinReset").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#kainnsyasin").val("");
						$("#ksyasintitle").val("");
						$("#kaiinsyasin").val("");
						$("#kaiinerror").html("");
						$("#ksyasintitle").prop("disabled", true);
						$('.add2KaiinSyasinReset').prop('disabled', true);
						$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 編集会員写真のリセット
	$(".kaiinReset").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#resetKaiin").val("1");
						$("#image1").val("");
						$("#kainnsyasin").val("");
						$("#ksyasintitle").val("");
						$("#ksyasintitle").prop("disabled", true);
						$('.kaiinReset').prop('disabled', true);
						$("#urlkaiinsyasin").val("");
						$("#kaiinsyasin").val("");
						$("#kaiinerror").html("");
						$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 編集会社ロゴのリセット
	$(".kaisyaLogoReset").click(function () {
		$.confirm({
			title: '',
			content: '画像ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#resetLogo").val("1");
						$("#klogo").val("");
						$('.kaisyaLogoReset').prop('disabled', true);
						$("#urlkaisyalogo").val("");
						$("#kaisyalogo").val("");
						$("#klogo_err").html("");
						$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 編集PRイメージ１のリセット
	$(".primageReset1").click(function () {
		$("#syasin1").val("");
		$("#syasintitle1").val($("#urltitle1").val());
		$("#primage1").val("");
		if($("#urlprimage1").val()=="") {
			$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		} else {
			$("#thum03").attr('src', $("#baseurl").val()+'/AdminMember/getSyasin/'+$("#urlprimage1").val()+'/'+$("#urlsyasinKey").val());
		}
	});
	// 編集PRイメージ2のリセット
	$(".primageReset2").click(function () {
		$("#syasin2").val("");
		$("#syasintitle2").val($("#urltitle2").val());
		$("#primage2").val("");
		if($("#urlprimage2").val()=="") {
			$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		} else {
			$("#thum04").attr('src', $("#baseurl").val()+'/AdminMember/getSyasin/'+$("#urlprimage2").val()+'/'+$("#urlsyasinKey").val());
		}
	});
	
	// 編集PRイメージ3のリセット
	$(".primageReset3").click(function () {
		$("#syasin3").val("");
		$("#syasintitle3").val($("#urltitle3").val());
		$("#primage3").val("");
		if($("#urlprimage3").val()=="") {
			$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		} else {
			$("#thum05").attr('src', $("#baseurl").val()+'/AdminMember/getSyasin/'+$("#urlprimage3").val()+'/'+$("#urlsyasinKey").val());
		}
	});
	// 戻るボタン
	$(".b-back").click(function(){
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$( "#membersModoruFrm" ).submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".admin-back").click(function(){
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$( "#membermgnt" ).submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
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
	// 一覧に戻る
	$(".add_2returnList").click(function(){
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$( "#membersModoruFrm" ).submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".edit_2returnList").click(function(){
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$( "#membersModoruFrm" ).submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// add会員登録ボタン
	$("#memberAdd").click(function(){
		if($("#memberAddFrm").valid()){
	    	if (confirm("登録してもよろしでしょうか。")) {
	    		$("#memberAddFrm").submit();
	    	}
	    }
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
    $('#tbusyo1').change(function() {
		var tbusyo1 = $( "#tbusyo1").val();
		var ttantounm1 = $( "#ttantounm1").val();
		if (tbusyo1 != "" || ttantounm1 != "") {
			$( "#tmailaddr1" ).rules( "add", "required" );
		} else {
			$( "#tmailaddr1" ).rules( "remove", "required" );
		}
	});
	$('#ttantounm1').change(function() {
		var tbusyo1 = $( "#tbusyo1").val();
		var ttantounm1 = $( "#ttantounm1").val();
		if (tbusyo1 != "" || ttantounm1 != "") {
			$( "#tmailaddr1" ).rules( "add", "required" );
		} else {
			$( "#tmailaddr1" ).rules( "remove", "required" );
		}
	});
	$('#tbusyo2').change(function() {
		var tbusyo2 = $( "#tbusyo2").val();
		var ttantounm2 = $( "#ttantounm2").val();
		if (tbusyo2 != "" || ttantounm2 != "") {
			$( "#tmailaddr2" ).rules( "add", "required" );
		} else {
			$( "#tmailaddr2" ).rules( "remove", "required" );
		}
	});
	$('#ttantounm2').change(function() {
		var tbusyo2 = $( "#tbusyo2").val();
		var ttantounm2 = $( "#ttantounm2").val();
		if (tbusyo2 != "" || ttantounm2 != "") {
			$( "#tmailaddr2" ).rules( "add", "required" );
		} else {
			$( "#tmailaddr2" ).rules( "remove", "required" );
		}
	});
	$('#tbusyo3').change(function() {
		var tbusyo3 = $( "#tbusyo3").val();
		var ttantounm3 = $( "#ttantounm3").val();
		if (tbusyo3 != "" || ttantounm3 != "") {
			$( "#tmailaddr3" ).rules( "add", "required" );
		} else {
			$( "#tmailaddr3" ).rules( "remove", "required" );
		}
	});
	$('#ttantounm3').change(function() {
		var tbusyo3 = $( "#tbusyo3").val();
		var ttantounm3 = $( "#ttantounm3").val();
		if (tbusyo3 != "" || ttantounm3 != "") {
			$( "#tmailaddr3" ).rules( "add", "required" );
		} else {
			$( "#tmailaddr3" ).rules( "remove", "required" );
		}
	});
	$('#syumicd1').change(function() {
		// 選択した値のセット
		var option = $(this).find('option:selected').val();
		// 会員種別が"正会員"or"準会員"の場合
		if(option == '99') {
			$('#syumitxt1').attr('readonly', false);
			$( "#syumitxt1" ).rules( "add", "required" );
		} else {
			$('#syumitxt1').attr('readonly', true);
			$( "#syumitxt1" ).val("");
			$( "#syumitxt1" ).rules( "remove", "required" );
		}
	});
	$('#syumicd2').change(function() {
		// 選択した値のセット
		var option = $(this).find('option:selected').val();
		// 会員種別が"正会員"or"準会員"の場合
		if(option == '99') {
			$('#syumitxt2').attr('readonly', false);
			$( "#syumitxt2" ).rules( "add", "required" );
		} else {
			$('#syumitxt2').attr('readonly', true);
			$( "#syumitxt2" ).val("");
			$( "#syumitxt2" ).rules( "remove", "required" );
		}
	});
	$('#syumicd3').change(function() {
		// 選択した値のセット
		var option = $(this).find('option:selected').val();
		// 会員種別が"正会員"or"準会員"の場合
		if(option == '99') {
			$('#syumitxt3').attr('readonly', false);
			$( "#syumitxt3" ).rules( "add", "required" );
		} else {
			$('#syumitxt3').attr('readonly', true);
			$( "#syumitxt3" ).val("");
			$( "#syumitxt3" ).rules( "remove", "required" );
		}
	});
	$(".backtohome").click(function () {
		$("#backtohome").submit();
	});
	jQuery.validator.addMethod("zenkaku", function(value, element) {
	 return this.optional(element) || /^[^ -~｡-ﾟ]*$/.test(value);
	});
	jQuery.validator.addMethod("kaiin_add", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
		    	$("#kainnsyasin").val("");
				$("#ksyasintitle").val("");
				$("#kaiinsyasin").val("");
				$('#ksyasintitle').attr('disabled', 'disabled');
				$('.rstKaiinSyasin').prop('disabled', true);
				$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
		    	return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("kaiin_add_2", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
		    	$("#kainnsyasin").val("");
				$("#ksyasintitle").val("");
				$("#kaiinsyasin").val("");
				$('#ksyasintitle').attr('disabled', 'disabled');
				$('.add2KaiinSyasinReset').prop('disabled', true);
				$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
		    	return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("kaiin_edit", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
				if($("#image1").val() == "" ) {
					$("#kaiinsyasin").val("");
					$("#kainnsyasin").val("");
					$("#ksyasintitle").val("");
					$('#ksyasintitle').attr('disabled', 'disabled');
					$('.kaiinReset').prop('disabled', true);
					$("#resetKaiin").val('1');
					$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
				} else {
					var img1 = $("#image1").val();
					var imgtit1 = $("#urlkaiintitle").val();
					$("#thum01").attr('src', img1);
					$("#ksyasintitle").val(imgtit1);
					$("#kaiinsyasin").val("");
					$("#kainnsyasin").val("");
				}
				return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("klogo_add", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
		    	$("#klogo").val("");
				$("#kaisyalogo").val("");
				$('.rstkaisyalogo').prop('disabled', true);
				$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
		    	return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("klogo_edit", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
				if($("#image2").val() == "" ) {
					$("#kaisyalogo").val("");
					$("#klogo").val("");
					$('.kaisyaLogoReset').prop('disabled', true);
					$("#thum02").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum.gif');
				} else {
					var img1 = $("#image2").val();
					$("#thum02").attr('src', img1);
					$("#kaisyalogo").val("");
					$("#klogo").val("");
				}
				return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("imgval1_add", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
		    	$("#syasin1").val("");
				$("#syasintitle1").val("");
				$("#primage1").val("");
				$('#syasintitle1').attr('disabled', 'disabled');
				$('.addPrImageReset1').prop('disabled', true);
				$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		    	return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("imgval1_edit", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
				if($("#image3").val() == "" ) {
					$("#primage1").val("");
					$("#syasin1").val("");
					$('#syasintitle1').attr('disabled', 'disabled');
					$('.addPrImageReset1').prop('disabled', true);
					$("#reset1").val('1');
					$("#thum03").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				} else {
					var img1 = $("#image3").val();
					var imgtit1 = $("#urltitle1").val();
					$("#thum03").attr('src', img1);
					$("#syasintitle1").val(imgtit1);
					$("#primage1").val("");
					$("#syasin1").val("");
				}
				return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("imgval2_add", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		    if ($.inArray(lastChar, fileExtension) == -1) {
		    	$("#syasin2").val("");
				$("#syasintitle2").val("");
				$("#primage2").val("");
				$('#syasintitle2').attr('disabled', 'disabled');
				$('.addPrImageReset2').prop('disabled', true);
				$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		    	return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("imgval2_edit", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
				if($("#image4").val() == "" ) {
					$("#primage2").val("");
					$("#syasin2").val("");
					$('#syasintitle2').attr('disabled', 'disabled');
					$('.addPrImageReset2').prop('disabled', true);
					$("#reset2").val('1');
					$("#thum04").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				} else {
					var img1 = $("#image4").val();
					var imgtit1 = $("#urltitle2").val();
					$("#thum04").attr('src', img1);
					$("#syasintitle2").val(imgtit1);
					$("#primage2").val("");
					$("#syasin2").val("");
				}
				return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("imgval3_add", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		    if ($.inArray(lastChar, fileExtension) == -1) {
		    	$("#syasin3").val("");
				$("#syasintitle3").val("");
				$("#primage3").val("");
				$('#syasintitle3').attr('disabled', 'disabled');
				$('.addPrImageReset3').prop('disabled', true);
				$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
		    	return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("imgval3_edit", function(value, element) {
		if(value != ""){
			var lastChar = value.substr(value.lastIndexOf('.') + 1);
			var lastChar = lastChar.toLowerCase();
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
			if ($.inArray(lastChar, fileExtension) == -1) {
				if($("#image5").val() == "" ) {
					$("#primage3").val("");
					$("#syasin3").val("");
					$('#syasintitle3').attr('disabled', 'disabled');
					$('.addPrImageReset3').prop('disabled', true);
					$("#reset3").val('1');
					$("#thum05").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				} else {
					var img1 = $("#image5").val();
					var imgtit1 = $("#urltitle3").val();
					$("#thum05").attr('src', img1);
					$("#syasintitle3").val(imgtit1);
					$("#primage3").val("");
					$("#syasin3").val("");
				}
				return false;
		    } else {
		    	return true;
		    }
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("checkkaincd", function(value, element) {
		var return_first = function () {
	    var tmp = null;
		    $.ajax({
				url    : 'checkkaincd',
				type   : 'POST',
				datatype : 'JSON',
				data   : {'kaincd': value },
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
			$('#kaiincd_err').hide();
			return true;
		} else {
			$('#kaiincd_err').show();
			$('#session_err').hide();
			return false;
		}
		if($("#kaiincd").val() == "") {
			$('#kaiincd_err').hide();
		}
	});
	jQuery.validator.addMethod("checkkaisyacd", function(value, element) {
		var return_first = function () {
	    var tmp = null;
		    $.ajax({
				url    : 'checkkaisyacd',
				type   : 'POST',
				datatype : 'JSON',
				data   : {'kaisyacd': value },
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
			$('#kaiincd_err').hide();
			return true;
		} else {
			$('#kaiincd_err').show();
			$('#session_err').hide();
			return false;
		}
		if($("#kaisyacd").val() == "") {
			$('#kaiincd_err').hide();
		}
	});
	jQuery.validator.addMethod("checklogid", function(value, element) {
		var return_first = function () {
	    var tmp = null;
		    $.ajax({
				url    : 'checklogid',
				type   : 'POST',
				datatype : 'JSON',
				data   : {'lgid': value },
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
		if(value == "") {
			$('#kaiincd_err').hide();
			return true;
		}
		if(return_first != 1) {
			$('#kaiincd_err').hide();
			return true;
		} else {
			$('#kaiincd_err').show();
			return false;
		}
	});
	jQuery.validator.addMethod("checklogidedit", function(value, element) {
		var return_first = function () {
	    var tmp = null;
		    $.ajax({
				url    : 'checklogid',
				type   : 'POST',
				datatype : 'JSON',
				data   : {'lgid': value },
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
		if($("#lgid_hid").val() == value ) {
			$('#logid_err').hide();
			return true;
		}
		if(value == "") {
			$('#logid_err').hide();
			return true;
		}
		if(return_first != 1) {
			$('#logid_err').hide();
			return true;
		} else {
			$('#logid_err').show();
			return false;
		}
	});
	jQuery.validator.addMethod("alphanumsymbol",function(value, element) {	
		return this.optional(element) || value.match(/^[A-Za-z0-9 !"#$%&'()=~|^`{[@+*}_?><,./\\\]:;-]*$/g);
	});
	jQuery.validator.addMethod("minlengthpass",function(value) {
		if(value == "") {
			return true;
		} else if(value.length < 6){
			return false;
		} else {
			return true;
		}
	});
	$.validator.addMethod("pwcheck", function(value) {
	    if(value == "") {
			return true;
		} else {
	      return /^[a-zA-Z0-9!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]+$/.test(value)
	       && /\d/.test(value)//has a digit
	       && /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/.test(value)// has a special character
		}
     });
	jQuery.validator.addMethod("checkmailId", function(value, element) {
		if(value != "") {
			var return_first = function () {
			var tmp = null;
				$.ajax({
					url    : 'checkmailid',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'mailaddr': value ,'editflg':'0'},
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
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("checkmailIdPR", function(value, element) {
		if(value != "") {
			var return_first = function () {
			var tmp = null;
				$.ajax({
					url    : 'checkmailidPR',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'mailaddr': value ,'editflg':'0'},
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
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("checkmailIdedit", function(value, element) {
		if(value != "") {
			var return_first = function () {
			var tmp = null;
				$.ajax({
					url    : 'checkmailid',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'mailaddr': value ,'editflg':'1','kaiincd': $("#kaiincd").val() },
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
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	});
	jQuery.validator.addMethod("checkmailIdPRedit", function(value, element) {
		if(value != "") {
			var return_first = function () {
			var tmp = null;
				$.ajax({
					url    : 'checkmailidPR',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'mailaddr': value ,'editflg':'1','kaisyacd': $("#kaisyacd").val() },
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
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	});
});
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#newListAddFrm").validate({
				onkeyup: false,
            	errorPlacement: function(error, element) {
            		$(".kaisyabikou").html("");
					$(".kaiinbikou").html("");
					$(".kaiincd").html("");
					$(".kaiinnm").html("");
					$(".kaisyacd").html("");
					$(".kaisyanm").html("");
					$(".kaiinnmkana").html("");
					$(".kaisyayknm").html("");
					$(".mailaddr").html("");
					$(".seinendate").html("");
					$(".syokaisyanm").html("");
					$(".ksyasintitle").html("");
					$(".tbusyo1").html("");
					$(".ttantounm1").html("");
					$(".tmailaddr1").html("");
					$(".tbusyo2").html("");
					$(".ttantounm2").html("");
					$(".tmailaddr2").html("");
					$(".tbusyo3").html("");
					$(".ttantounm3").html("");
					$(".tmailaddr3").html("");
					$(".lgid").html("");
					$(".lgpass").html("");
					$(".jyubinno").html("");
					$(".jjyusyo1").html("");
					$(".jjyusyo2").html("");
					$(".jtelno").html("");
					$(".kttelno").html("");
					$(".ktmailaddr").html("");
					$(".syumitxt1").html("");
					$(".syumitxt2").html("");
					$(".syumitxt3").html("");
					$(".sikousyoku").html("");
					$(".sikounomi").html("");
					$(".kaisyanmkana").html("");
					$(".yubinno").html("");
					$(".jyusyo1").html("");
					$(".jyusyo2").html("");
					$(".telno").html("");
					$(".faxno").html("");
					$(".daihyoyknm").html("");
					$(".daihyonm").html("");
					$(".seturitu").html("");
					$(".jyugyoin").html("");
					$(".hpurl").html("");
					$(".gyoumu").html("");
					$(".pr").html("");
					$(".syasintitle1").html("");
					$(".syasintitle2").html("");
					$(".syasintitle3").html("");
					if(element.attr("name") == "kainnsyasin" || element.attr("name") == "syasin1" || element.attr("name") == "syasin2" || element.attr("name") == "syasin3") {
						error.appendTo( element.parent("div").next("div") );
					} else if(element.attr("name") == "klogo") {
						error.appendTo('#klogo_err');
					} else {
						error.insertAfter(element);
					}
				},
                rules: {
                	kaiincd: {
                		required:true,
                		number:true,
                		checkkaincd:true,
                		maxlength: 6
					},
					syumitxt1: {
						maxlength: 40
					},
					syumitxt2: {
						maxlength: 40
					},
					syumitxt3: {
						maxlength: 40
					},
					kaiinnm: {
						required:true,
						withTwoStrings:true,
						maxlength: 40
					},
					kaiinnmkana:{
						hiragana:true,
						withTwoStrings:true,
						maxlength: 40
					},
					kaisyayknm:{
						maxlength: 40
					},
					mailaddr: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailId:true
                    },
					seinendate: {
						date:true
					},
					tbusyo1:{
						maxlength: 40
					},
					ttantounm1: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr1: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					tbusyo2:{
						maxlength: 40
					},
					ttantounm2: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr2: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					tbusyo3:{
						maxlength: 40
					},
					ttantounm3: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr3: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					lgid: {
						checklogid:true,
						maxlength: 100,
						alphanumsymbol:true
					},
					lgpass: {
						minlengthpass: true,
						maxlength: 40,
						pwcheck:true
					},
					nyukaidate: "date",
					kyukaidate: "date",
					taikaidate: "date",
					syokaisyanm: {
						withTwoStrings:true,
						maxlength: 40
					},
					jyubinno: {
						number:true,
						maxlength: 7,
						minlength: 7
					},
					yubinno: {
						number:true,
						maxlength: 7,
						minlength: 7
					},
					jtelno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					kttelno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					ktmailaddr: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					telno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					faxno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					kaisyacd: {
                		required:true,
                		checkkaisyacd:true,
                		number:true,
                		maxlength: 5
					},
					kaisyanm: {
                		required:true,
                		maxlength: 100
					},
					kaisyanmkana:{
						hirasymJH:true,
						maxlength: 255
					},
					daihyonm: {
						withTwoStrings: true,
						maxlength: 40
					},
					seturitu: {
						number:true,
						shouraiyear: true,
						maxlength: 4
					},
					jyugyoin: {
						number:true,
						range: [ -32768, 32767 ],
						maxlength: 5
					},
					hpurl: {
						url: true,
						maxlength: 255
					},
					ksyasintitle: {
						zenkaku: true,
						maxlength: 60
					},
					syasintitle1: {
						zenkaku: true,
						maxlength: 60
					},
					syasintitle2: {
						zenkaku: true,
						maxlength: 60
					},
					syasintitle3: {
						zenkaku: true,
						maxlength: 60
					},
					kaiinbikou: {
						maxlength: 255
					},
					jjyusyo1: {
						maxlength: 255
					},
					jjyusyo2: {
						maxlength: 255
					},
					sikousyoku: {
						maxlength: 60
					},
					sikounomi: {
						maxlength: 60
					},
					jyusyo1: {
						maxlength: 255
					},
					jyusyo2: {
						maxlength: 255
					},
					daihyoyknm: {
						maxlength: 80
					},
					gyoumu: {
						maxlength: 2048
					},
					pr: {
						maxlength: 2048
					},
					kaisyabikou: {
						maxlength: 1024
					},
					kainnsyasin: "kaiin_add",
					klogo: "klogo_add",
					syasin1: "imgval1_add",
					syasin2: "imgval2_add",
					syasin3: "imgval3_add",
					prmailaddr1: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPR:true,
                        notEqual: ['#prmailaddr2', '#prmailaddr3']
                    },
                    prmailaddr2: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPR:true,
                        notEqual: ['#prmailaddr1', '#prmailaddr3']
                    },
                    prmailaddr3: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPR:true,
                        notEqual: ['#prmailaddr1', '#prmailaddr2']
                    }
                },
                messages: {
                	kaiincd: {
						required:"会員コードが未入力です。",
						number:"数値を入力してください。",
						maxlength: "最大文字数を超えています。",
						checkkaincd:""
					},
                	syumitxt1:{
                		required:"趣味１（その他）を入力してください。",
                		maxlength: "最大文字数を超えています。"
                	},
					syumitxt2:{
                		required:"趣味2（その他）を入力してください。",
                		maxlength: "最大文字数を超えています。"
                	},
					syumitxt3:{
                		required:"趣味3（その他）を入力してください。",
                		maxlength: "最大文字数を超えています。"
                	},
                	kaiinnm: {
						required:"会員名称が未入力です。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaiinnmkana:{
						hiragana:"ひらがなのみ入力できます。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaisyayknm:{
						maxlength: "最大文字数を超えています。"
					},
					mailaddr: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailId:"入力したメールアドレスは既に登録されています。"
                	},
					seinendate: {
						date:"生年月日が不正な形式です。",
					},
					tbusyo1:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm1: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr1:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					tbusyo2:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm2: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr2:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					tbusyo3:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm3: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr3:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					lgid: {
						maxlength: "最大文字数を超えています。",
                        checklogid:"",
						alphanumsymbol:"入力可能文字種は、英数字、記号です。"
					},
					lgpass: {
						minlengthpass:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						pwcheck:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					nyukaidate: "入会日付が不正な形式です。",
					kyukaidate: "休会日付が不正な形式です。",
					taikaidate: "退会日付が不正な形式です。",
					syokaisyanm:{
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					jyubinno:{
						maxlength: "正しい郵便番号を入力してください。",
						minlength: "正しい郵便番号を入力してください。",
						number:"数値を入力してください。"
					},
					yubinno:{
						maxlength: "正しい郵便番号を入力してください。",
						minlength: "正しい郵便番号を入力してください。",
						number:"数値を入力してください。"
					},
					jtelno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kttelno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					ktmailaddr:{
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					telno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					faxno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaisyacd: {
						required:"会員コードが未入力です。",
						number:"数値を入力してください。",
						maxlength: "最大文字数を超えています。",
						checkkaisyacd:""
					},
					kaisyanm: {
						required:"会社名称が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kaisyanmkana:{
						hirasymJH:"入力可能文字種は、ひらがな、記号、ーです。",
						maxlength: "最大文字数を超えています。"
					},
					daihyonm: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					seturitu: {
						number:"数値を入力してください。",
						shouraiyear: "未来の年は入力できません。",
						maxlength: "最大文字数を超えています。"
					},
					jyugyoin: {
						number:"数値を入力してください。",
						range: "最大文字数を超えています。",
						maxlength: "最大文字数を超えています。"
					},
					hpurl: {
						url: "正しいURLを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					ksyasintitle: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasintitle1: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasintitle2: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasintitle3: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaiinbikou: {
						maxlength: "最大文字数を超えています。"
					},
					jjyusyo1: {
						maxlength: "最大文字数を超えています。"
					},
					jjyusyo2: {
						maxlength: "最大文字数を超えています。"
					},
					sikousyoku: {
						maxlength: "最大文字数を超えています。"
					},
					sikounomi: {
						maxlength: "最大文字数を超えています。"
					},
					jyusyo1: {
						maxlength: "最大文字数を超えています。"
					},
					jyusyo2: {
						maxlength: "最大文字数を超えています。"
					},
					daihyoyknm: {
						maxlength: "最大文字数を超えています。"
					},
					gyoumu: {
						maxlength: "最大文字数を超えています。"
					},
					pr: {
						maxlength: "最大文字数を超えています。"
					},
					kaisyabikou: {
						maxlength: "最大文字数を超えています。"
					},
					kainnsyasin : "画像しか入力できません。画像を入力してください。",
					klogo : "画像しか入力できません。画像を入力してください。",
					syasin1 : "画像しか入力できません。画像を入力してください。",
					syasin2 : "画像しか入力できません。画像を入力してください。",
					syasin3 : "画像しか入力できません。画像を入力してください。",
					prmailaddr1: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailIdPR:"入力したメールアドレスは既に登録されています。",
                        notEqual:"メールアドレスは既に入力されています。"
                	},
                	prmailaddr2: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailIdPR:"入力したメールアドレスは既に登録されています。",
                        notEqual:"メールアドレスは既に入力されています。"
                	},
                	prmailaddr3: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailIdPR:"入力したメールアドレスは既に登録されています。",
                        notEqual:"メールアドレスは既に入力されています。"
                	}
                },
                submitHandler: function(form) {
                	if($('#previewflg').val() == 1 ) {
						$.confirm({
							title: '',
							content: INSERT_CONFIRM,
							type: 'blue',
							buttons: {
								OK: {
									action: function(){
										$("#registercls").addClass('registercls');
										var data = new FormData();
										var serializedData = $("#newListAddFrm").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('kaiinsyasin', $("#kaiinsyasin").get(0).files[0]);
										data.append('kaisyalogo', $("#kaisyalogo").get(0).files[0]);
										data.append('primage1', $("#primage1").get(0).files[0]);
										data.append('primage2', $("#primage2").get(0).files[0]);
										data.append('primage3', $("#primage3").get(0).files[0]);
										data.append('otherFields', serializedData);
										var xhr = new XMLHttpRequest();
									 	xhr.open('POST', 'add', true);
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
																$( "#listModoruFrm" ).attr('action', '../adminMember/add');
																$( "#listModoruFrm" ).submit();
															}
														}
													}
												});
											} else {
												window.location = "../Error/systemError";
											}
									 	} else if (xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200) {
									 		window.location = "../Error/systemError";
									 	}else {
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
									 		$("#registercls").removeClass('registercls');
									 		var allErrArr = xhr.responseText.split("$$");
									 		var focusArea ="";
											$(".kaisyabikou").html("");
											$(".kaiinbikou").html("");
											$(".kaiincd").html("");
											$(".kaiinnm").html("");
											$(".kaisyacd").html("");
											$(".kaisyanm").html("");
											$(".kaiinnmkana").html("");
											$(".kaisyayknm").html("");
											$(".mailaddr").html("");
											$(".seinendate").html("");
											$(".syokaisyanm").html("");
											$(".ksyasintitle").html("");
											$(".tbusyo1").html("");
											$(".ttantounm1").html("");
											$(".tmailaddr1").html("");
											$(".tbusyo2").html("");
											$(".ttantounm2").html("");
											$(".tmailaddr2").html("");
											$(".tbusyo3").html("");
											$(".ttantounm3").html("");
											$(".tmailaddr3").html("");
											$(".lgid").html("");
											$(".lgpass").html("");
											$(".jyubinno").html("");
											$(".jjyusyo1").html("");
											$(".jjyusyo2").html("");
											$(".jtelno").html("");
											$(".kttelno").html("");
											$(".ktmailaddr").html("");
											$(".syumitxt1").html("");
											$(".syumitxt2").html("");
											$(".syumitxt3").html("");
											$(".sikousyoku").html("");
											$(".sikounomi").html("");
											$(".kaisyanmkana").html("");
											$(".yubinno").html("");
											$(".jyusyo1").html("");
											$(".jyusyo2").html("");
											$(".telno").html("");
											$(".faxno").html("");
											$(".daihyoyknm").html("");
											$(".daihyonm").html("");
											$(".seturitu").html("");
											$(".jyugyoin").html("");
											$(".hpurl").html("");
											$(".gyoumu").html("");
											$(".pr").html("");
											$(".syasintitle1").html("");
											$(".syasintitle2").html("");
											$(".syasintitle3").html("");
									 		allErrArr.forEach(function(errArr) {
									 			var err = errArr.split("##");
									 			focusArea = err[0];
									 		   $("."+err[0]).html(err[1]);
									 		});
									 		$("#"+focusArea).focus();
									 		$('.b-release').prop('disabled', false);
									 	}
										};
                						// form.submit();
									}
								},
								キャンセル: function () {
								}
							}
						});
						$('#previewflg').val('0');
                	} else {
                		form.submit();
                	}
                }
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });
})(jQuery, window, document);

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules for add_2
            $("#memberAddFrm").validate({
				onkeyup: false,
            	errorPlacement: function(error, element) {
            		$(".kaiincd").html("");
					$(".kaiinnm").html("");
					$(".bikou").html("");
					$(".kaiinnmkana").html("");
					$(".kaisyayknm").html("");
					$(".mailaddr").html("");
					$(".syokaisyanm").html("");
					$(".ksyasintitle").html("");
					$(".tbusyo1").html("");
					$(".ttantounm1").html("");
					$(".tmailaddr1").html("");
					$(".tbusyo2").html("");
					$(".ttantounm2").html("");
					$(".tmailaddr2").html("");
					$(".tbusyo3").html("");
					$(".ttantounm3").html("");
					$(".tmailaddr3").html("");
					$(".lgid").html("");
					$(".lgpass").html("");
					$(".jyubinno").html("");
					$(".jjyusyo1").html("");
					$(".jjyusyo2").html("");
					$(".jtelno").html("");
					$(".kttelno").html("");
					$(".ktmailaddr").html("");
					$(".syumitxt1").html("");
					$(".syumitxt2").html("");
					$(".syumitxt3").html("");
					$(".sikousyoku").html("");
					$(".sikounomi").html("");
					$(".syasintitle1").html("");
					$(".syasintitle2").html("");
					$(".syasintitle3").html("");
					if(element.attr("name") == "kainnsyasin" ) {
						error.appendTo( element.parent("div").next("div") );
					} else {
						error.insertAfter(element);
					}
				},
                rules: {
                	kaiincd: {
                		required:true,
                		number:true,
                		checkkaincd:true,
                		maxlength: 6
					},
                	kaiinnm: {
						required:true,
						withTwoStrings:true,
						maxlength: 40
					},
					kaiinnmkana:{
						hiragana:true,
						withTwoStrings:true,
						maxlength: 40
					},
					kaisyayknm:{
						maxlength: 40
					},
					mailaddr: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailId:true
                    },
					seinendate: {
						date:true
					},
					tbusyo1:{
						maxlength: 40
					},
					ttantounm1: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr1: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					tbusyo2:{
						maxlength: 40
					},
					ttantounm2: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr2: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					tbusyo3:{
						maxlength: 40
					},
					ttantounm3: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr3: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					lgid: {
						checklogid:true,
						maxlength: 100,
						alphanumsymbol:true
					},
					nyukaidate: "date",
					kyukaidate: "date",
					taikaidate: "date",
					jyubinno: {
						number:true,
						maxlength: 7,
						minlength: 7
					},
					yubinno: {
						number:true,
						maxlength: 7,
						minlength: 7
					},
					jtelno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					kttelno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						maxlength: 15
					},
					ktmailaddr: {
						email: true,
						specialChar:true,
						mailvalidation:true,
						maxlength: 100
					},
					telno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true
					},
					faxno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true
					},
					kaisyacd: "required",
					kaisyanm: "required",
					daihyonm: {
						withTwoStrings: true
					},
					seturitu: {
						number:true,
						shouraiyear: true
					},
					jyugyoin: {
						number:true,
						range: [ -32768, 32767 ]
					},
					hpurl: {
						url: true
					},
					ksyasintitle: {
						zenkaku: true,
						maxlength: 60
					},
					lgpass: {
						minlengthpass: true,
						maxlength: 40,
						pwcheck:true
					},
					jjyusyo1: {
						maxlength: 255
					},
					jjyusyo2: {
						maxlength: 255
					},
					sikousyoku: {
						maxlength: 60
					},
					sikounomi: {
						maxlength: 60
					},
					bikou: {
						maxlength: 255
					},
					kainnsyasin: "kaiin_add_2",
					syumitxt1: {
						maxlength: 40
					},
					syumitxt2: {
						maxlength: 40
					},
					syumitxt3: {
						maxlength: 40
					},
					syokaisyanm: {
						withTwoStrings:true,
						maxlength: 40
					},
					prmailaddr1: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPR:true,
                        notEqual: ['#prmailaddr2', '#prmailaddr3']
                    },
                    prmailaddr2: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPR:true,
                        notEqual: ['#prmailaddr1', '#prmailaddr3']

                    },
                    prmailaddr3: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPR:true,
                        notEqual: ['#prmailaddr1', '#prmailaddr2']
                    }
				},
				messages: {
					kaiincd: {
						required:"会員コードが未入力です。",
						number:"数値を入力してください。",
						maxlength: "最大文字数を超えています。",
						checkkaincd:""
					},
					syumitxt1:{
						required:"趣味１（その他）を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syumitxt2:{
						required:"趣味2（その他）を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syumitxt3:{
						required:"趣味3（その他）を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaiinnm: {
						required:"会員名称が未入力です。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaiinnmkana:{
						hiragana:"ひらがなのみ入力できます。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaisyayknm:{
						maxlength: "最大文字数を超えています。"
					},
					mailaddr: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailId:"入力したメールアドレスは既に登録されています。"
                	},
					seinendate: {
						date:"生年月日が不正な形式です。",
					},
					tbusyo1:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm1: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr1:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					tbusyo2:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm2: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr2:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					tbusyo3:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm3: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr3:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					lgid: {
						maxlength: "最大文字数を超えています。",
						checklogid:"",
						alphanumsymbol:"入力可能文字種は、英数字、記号です。"
					},
					nyukaidate: "入会日付が不正な形式です。",
					kyukaidate: "休会日付が不正な形式です。",
					taikaidate: "退会日付が不正な形式です。",
					jyubinno:{
						maxlength: "正しい郵便番号を入力してください。",
						minlength: "正しい郵便番号を入力してください。",
						number:"数値を入力してください。"
					},
					yubinno:{
						maxlength: "正しい郵便番号を入力してください。",
						minlength: "正しい郵便番号を入力してください。",
						number:"数値を入力してください。"
					},
					jtelno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kttelno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					ktmailaddr:{
						email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。"
					},
					telno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。"
					},
					faxno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。"
					},
					kaisyacd: "会社コードが未入力です。",
					kaisyanm: "会社名称が未入力です。",
					daihyonm: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。"
					},
					seturitu: {
						number:"数値を入力してください。",
						shouraiyear: "未来の年は入力できません。"
					},
					jyugyoin: {
						number:"数値を入力してください。",
						range: "最大文字数を超えています。"
					},
					hpurl: {
						url: "正しいURLを入力してください。"
					},
					ksyasintitle: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					lgpass: {
						minlengthpass:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						pwcheck:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					jjyusyo1: {
						maxlength: "最大文字数を超えています。"
					},
					jjyusyo2: {
						maxlength: "最大文字数を超えています。"
					},
					sikousyoku: {
						maxlength: "最大文字数を超えています。"
					},
					sikounomi: {
						maxlength: "最大文字数を超えています。"
					},
					bikou: {
						maxlength: "最大文字数を超えています。"
					},
					kainnsyasin : "画像しか入力できません。画像を入力してください。",
	                syokaisyanm:{
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					prmailaddr1: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailIdPR:"入力したメールアドレスは既に登録されています。",
                        notEqual:"メールアドレスは既に入力されています。"
                	},
                	prmailaddr2: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailIdPR:"入力したメールアドレスは既に登録されています。",
                        notEqual:"メールアドレスは既に入力されています。"
                	},
                	prmailaddr3: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                        checkmailIdPR:"入力したメールアドレスは既に登録されています。",
                        notEqual:"メールアドレスは既に入力されています。"
                	}
				},
                submitHandler: function(form) {
                	if($('#previewflg').val() == 1 ) {
						$.confirm({
							title: '',
							content: INSERT_CONFIRM,
							type: 'blue',
							buttons: {
								OK: {
									action: function(){
										$("#registercls").addClass('registercls');
										$("#ksyasintitle").prop("disabled", false);
                						var data = new FormData();
										var serializedData = $("#memberAddFrm").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('kaiinsyasin', $("#kaiinsyasin").get(0).files[0]);
										data.append('otherFields', serializedData);
										var xhr = new XMLHttpRequest();
									 	xhr.open('POST', 'memberAdd', true);
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
																	$( "#memberAddFrm" ).attr('action', '../adminMember/add_2');
																	form.submit();
																	// $( "#membersModoruFrm" ).submit();
																}
															}
														}
													});
												} else {
													window.location = "../Error/systemError";
												}
									 		} else if (xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200) {
									 			window.location = "../Error/systemError";
									 		}else {
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
											$(".kaiincd").html("");
											$(".kaiinnm").html("");
											$(".bikou").html("");
											$(".kaiinnmkana").html("");
											$(".kaisyayknm").html("");
											$(".mailaddr").html("");
											$(".syokaisyanm").html("");
											$(".ksyasintitle").html("");
											$(".tbusyo1").html("");
											$(".ttantounm1").html("");
											$(".tmailaddr1").html("");
											$(".tbusyo2").html("");
											$(".ttantounm2").html("");
											$(".tmailaddr2").html("");
											$(".tbusyo3").html("");
											$(".ttantounm3").html("");
											$(".tmailaddr3").html("");
											$(".lgid").html("");
											$(".lgpass").html("");
											$(".jyubinno").html("");
											$(".jjyusyo1").html("");
											$(".jjyusyo2").html("");
											$(".jtelno").html("");
											$(".kttelno").html("");
											$(".ktmailaddr").html("");
											$(".syumitxt1").html("");
											$(".syumitxt2").html("");
											$(".syumitxt3").html("");
											$(".sikousyoku").html("");
											$(".sikounomi").html("");
											$(".syasintitle1").html("");
											$(".syasintitle2").html("");
											$(".syasintitle3").html("");
									 		allErrArr.forEach(function(errArr) {
									 			var err = errArr.split("##");
									 			focusArea = err[0];
									 		   $("."+err[0]).html(err[1]);
									 		});
									 		$("#"+focusArea).focus();
									 		$('.release').prop('disabled', false);
									 	}
										};
									}
								},
								キャンセル: function () {
								}
							}
						});
						$('#previewflg').val('0');
                	} else {
						$("#ksyasintitle").prop("disabled", false);
                		form.submit();
						$("#ksyasintitle").prop("disabled", true);
                	}
                }
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });
})(jQuery, window, document);

(function($,W,D)
{
    var JQUERY4U = {};
    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules edit
            $("#editfrm").validate({
				onkeyup: false,
            	errorPlacement: function(error, element) {
					$(".kaisyabikou").html("");
					$(".kaiinbikou").html("");
					$(".kaiinnm").html("");
					$(".kaiinnmkana").html("");
					$(".kaisyayknm").html("");
					$(".mailaddr").html("");
					$(".syokaisyanm").html("");
					$(".ksyasintitle").html("");
					$(".tbusyo1").html("");
					$(".ttantounm1").html("");
					$(".tmailaddr1").html("");
					$(".tbusyo2").html("");
					$(".ttantounm2").html("");
					$(".tmailaddr2").html("");
					$(".tbusyo3").html("");
					$(".ttantounm3").html("");
					$(".tmailaddr3").html("");
					$(".lgid").html("");
					$(".lgpass").html("");
					$(".jyubinno").html("");
					$(".jjyusyo1").html("");
					$(".jjyusyo2").html("");
					$(".jtelno").html("");
					$(".kttelno").html("");
					$(".ktmailaddr").html("");
					$(".syumitxt1").html("");
					$(".syumitxt2").html("");
					$(".syumitxt3").html("");
					$(".sikousyoku").html("");
					$(".sikounomi").html("");
					$(".kaisyanm").html("");
					$(".kaisyanmkana").html("");
					$(".yubinno").html("");
					$(".jyusyo1").html("");
					$(".jyusyo2").html("");
					$(".telno").html("");
					$(".faxno").html("");
					$(".daihyoyknm").html("");
					$(".daihyonm").html("");
					$(".seturitu").html("");
					$(".jyugyoin").html("");
					$(".hpurl").html("");
					$(".gyoumu").html("");
					$(".pr").html("");
					$(".syasintitle1").html("");
					$(".syasintitle2").html("");
					$(".syasintitle3").html("");
					if(element.attr("name") == "kainnsyasin" || element.attr("name") == "syasin1" || element.attr("name") == "syasin2" || element.attr("name") == "syasin3") {
						error.appendTo( element.parent("div").next("div") );
					} else if(element.attr("name") == "klogo") {
						error.appendTo('#klogo_err');
					} else {
						error.insertAfter(element);
					}
				},
                rules: {
                	kaiincd: {
                		required:true,
                		number:true
                	},
                	kaiinnm: {
						required:true,
						withTwoStrings:true,
						maxlength: 40
					},
					kaiinnmkana:{
						hiragana:true,
						withTwoStrings:true,
						maxlength: 40
					},
					kaisyayknm:{
						maxlength: 40
					},
					mailaddr: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdedit:true
                    },
					seinendate: {
						date:true
					},
					tbusyo1:{
						maxlength: 40
					},
					ttantounm1: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr1: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					tbusyo2:{
						maxlength: 40
					},
					ttantounm2: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr2: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					tbusyo3:{
						maxlength: 40
					},
					ttantounm3: {
						withTwoStrings:true,
						maxlength: 40
					},
					tmailaddr3: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					lgid: {
						checklogidedit:true,
						maxlength: 100,
						alphanumsymbol:true
					},
					nyukaidate: "date",
					kyukaidate: "date",
					taikaidate: "date",
					syokaisyanm: {
						withTwoStrings:true,
						maxlength: 40
					},
					jyubinno: {
						number:true,
						maxlength: 7,
						minlength: 7
					},
					yubinno: {
						number:true,
						maxlength: 7,
						minlength: 7
					},
					jtelno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						 maxlength: 15
					},
					kttelno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						 maxlength: 15
					},
					ktmailaddr: {
						email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100
					},
					telno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						 maxlength: 15
					},
					faxno: {
						alphahypen:true,
						hyphensnecessary:true,
						jpnumberformat:true,
						jpnumbernotzeros:true,
						 maxlength: 15
					},
					kaisyacd: "required",
					kaisyanm:{
						required:true,
						maxlength: 100
					},
					kaisyanmkana:{
						hirasymJH:true,
						maxlength: 255
					},
					daihyonm: {
						withTwoStrings: true,
						maxlength: 40
					},
					seturitu: {
						number:true,
						shouraiyear: true,
						maxlength: 4
					},
					jyugyoin: {
						number:true,
						range: [ -32768, 32767 ],
						maxlength: 5
					},
					hpurl: {
						url: true,
						maxlength: 255
					},
					ksyasintitle: {
						zenkaku: true,
						maxlength: 60
					},
					syasintitle1: {
						zenkaku: true,
						maxlength: 60
					},
					syasintitle2: {
						zenkaku: true,
						maxlength: 60
					},
					syasintitle3: {
						zenkaku: true,
						maxlength: 60
					},
					kaiinbikou: {
						maxlength: 255
					},
					lgpass: {
						minlengthpass: true,
						maxlength: 40,
						pwcheck:true
					},
					jjyusyo1: {
						maxlength: 255
					},
					jjyusyo2: {
						maxlength: 255
					},
					sikousyoku: {
						maxlength: 60
					},
					sikounomi: {
						maxlength: 60
					},
					jyusyo1: {
						maxlength: 255
					},
					jyusyo2: {
						maxlength: 255
					},
					daihyoyknm: {
						maxlength: 80
					},
					gyoumu: {
						maxlength: 2048
					},
					pr: {
						maxlength: 2048
					},
					kaisyabikou: {
						maxlength: 1024
					},
					kainnsyasin: "kaiin_edit",
					klogo: "klogo_edit",
					syasin1: "imgval1_edit",
					syasin2: "imgval2_edit",
					syasin3: "imgval3_edit",
					syumitxt1: {
						maxlength: 40
					},
					syumitxt2: {
						maxlength: 40
					},
					syumitxt3: {
						maxlength: 40
					},
					prmailaddr1: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPRedit:true,
                        notEqual: ['#prmailaddr2', '#prmailaddr3']

                    },
                    prmailaddr2: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPRedit:true,
                        notEqual: ['#prmailaddr1', '#prmailaddr3']

                    },
                    prmailaddr3: {
                        email: true,
                        specialChar:true,
                        mailvalidation:true,
                        maxlength: 100,
                        checkmailIdPRedit:true,
                        notEqual: ['#prmailaddr1', '#prmailaddr2']

                    }
	        	},
			messages: {
					kaiincd: {
                		required:"会員コードが未入力です。",
                		number:"数値を入力してください。"
                	},
					syumitxt1:{
						required:"趣味１（その他）を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syumitxt2:{
						required:"趣味2（その他）を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syumitxt3:{
						required:"趣味3（その他）を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaiinnm: {
						required:"会員名称が未入力です。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaiinnmkana:{
						hiragana:"ひらがなのみ入力できます。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaisyayknm:{
						maxlength: "最大文字数を超えています。"
					},
					mailaddr: {
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。",
                        checkmailIdedit:"入力したメールアドレスは既に登録されています。"
					},
					seinendate: {
						date:"生年月日が不正な形式です。",
					},
					tbusyo1:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm1: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr1:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。"
					},
					tbusyo2:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm2: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr2:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。"
					},
					tbusyo3:{
						maxlength: "最大文字数を超えています。"
					},
					ttantounm3: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					tmailaddr3:{
						required:"メールアドレスが未入力です。",
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。"
					},
					lgid: {
						maxlength: "最大文字数を超えています。",
						checklogidedit:"",
						alphanumsymbol:"入力可能文字種は、英数字、記号です。"
					},
					nyukaidate: "入会日付が不正な形式です。",
					kyukaidate: "休会日付が不正な形式です。",
					taikaidate: "退会日付が不正な形式です。",
					syokaisyanm:{
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					jyubinno:{
						maxlength: "正しい郵便番号を入力してください。",
						minlength: "正しい郵便番号を入力してください。",
						number:"数値を入力してください。"
					},
					yubinno:{
						maxlength: "正しい郵便番号を入力してください。",
						minlength: "正しい郵便番号を入力してください。",
						number:"数値を入力してください。"
					},
					jtelno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kttelno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					ktmailaddr:{
						email:"メールアドレスの形式が不正です。",
						specialChar:"メールアドレスに使用できない文字が含まれています。",
						mailvalidation:"メールアドレスの形式が不正です。",
						maxlength: "最大文字数を超えています。"
					},
					telno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					faxno: {
						jpnumbernotzeros:"正しい番号を入力してください。",
						alphahypen:"数値を入力してください。",
						jpnumberformat:"正しい番号を入力してください。",
						hyphensnecessary:"ハイフンを含めた番号を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaisyacd: "会社コードが未入力です。",
					kaisyanm:{
						required:"会社名称が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					kaisyanmkana:{
						hirasymJH:"入力可能文字種は、ひらがな、記号、ーです。",
						maxlength: "最大文字数を超えています。"
					},
					daihyonm: {
						withTwoStrings:"姓と名の間に全角スペースを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					seturitu: {
						number:"数値を入力してください。",
						shouraiyear: "未来の年は入力できません。",
						maxlength: "最大文字数を超えています。"
					},
					jyugyoin: {
						number:"数値を入力してください。",
						range: "最大文字数を超えています。",
						maxlength: "最大文字数を超えています。"
					},
					hpurl: {
						url: "正しいURLを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					ksyasintitle: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasintitle1: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasintitle2: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasintitle3: {
						zenkaku: "全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					kaiinbikou: {
						maxlength: "最大文字数を超えています。"
					},
					lgpass: {
						minlengthpass:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						pwcheck:"半角英字、数字、記号を含み6ケタ以上の文字列を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					jjyusyo1: {
						maxlength: "最大文字数を超えています。"
					},
					jjyusyo2: {
						maxlength: "最大文字数を超えています。"
					},
					sikousyoku: {
						maxlength: "最大文字数を超えています。"
					},
					sikounomi: {
						maxlength: "最大文字数を超えています。"
					},
					jyusyo1: {
						maxlength: "最大文字数を超えています。"
					},
					jyusyo2: {
						maxlength: "最大文字数を超えています。"
					},
					daihyoyknm: {
						maxlength: "最大文字数を超えています。"
					},
					gyoumu: {
						maxlength: "最大文字数を超えています。"
					},
					pr: {
						maxlength: "最大文字数を超えています。"
					},
					kaisyabikou: {
						maxlength: "最大文字数を超えています。"
					},
					kainnsyasin : "画像しか入力できません。画像を入力してください。",
					klogo : "画像しか入力できません。画像を入力してください。",
					syasin1 : "画像しか入力できません。画像を入力してください。",
					syasin2 : "画像しか入力できません。画像を入力してください。",
					syasin3 : "画像しか入力できません。画像を入力してください。",
					prmailaddr1: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                		checkmailIdPRedit: "入力したメールアドレスは既に登録されています。",
                		notEqual:"メールアドレスは既に入力されています。"
                	},
                	prmailaddr2: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                		checkmailIdPRedit: "入力したメールアドレスは既に登録されています。",
                		notEqual:"メールアドレスは既に入力されています。"
                	},
                	prmailaddr3: {
                		email:"メールアドレスの形式が不正です。",
                		specialChar:"メールアドレスに使用できない文字が含まれています。",
                		mailvalidation:"メールアドレスの形式が不正です。",
                		maxlength: "最大文字数を超えています。",
                		checkmailIdPRedit: "入力したメールアドレスは既に登録されています。",
                		notEqual:"メールアドレスは既に入力されています。"
                	}
                },
                submitHandler: function(form) {
                	if($('#previewflg').val() == 1 ) {
						$.confirm({
							title: '',
							content: UPDATE_CONFIRM,
							type: 'blue',
							buttons: {
								OK: {
									action: function(){
										$("#updatecls").addClass('updatecls');
										$("#ksyasintitle").prop("disabled", false);
                						var data = new FormData();
										var serializedData = $("#editfrm").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('kaiinsyasin', $("#kaiinsyasin").get(0).files[0]);
										if($("#pagename").val() == '1') {
											data.append('kaisyalogo', $("#kaisyalogo").get(0).files[0]);
											data.append('primage1', $("#primage1").get(0).files[0]);
											data.append('primage2', $("#primage2").get(0).files[0]);
											data.append('primage3', $("#primage3").get(0).files[0]);
										}
										data.append('otherFields', serializedData);
										var xhr = new XMLHttpRequest();
										if($("#pagename").val() == '1') {
										 	xhr.open('POST', 'memberEdit', true);
									 	} else {
										 	xhr.open('POST', 'memberEdit2', true);
									 	}
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
																if($('#kanrikbn').val() >= SYS_KANRISHA) {
																	$( "#membersModoruFrm" ).submit();
																} else {
																	$( "#listModoruFrm" ).submit();
																}
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
									 		$(".kaisyabikou").html("");
											$(".kaiinbikou").html("");
											$(".kaiinnm").html("");
											$(".kaiinnmkana").html("");
											$(".kaisyayknm").html("");
											$(".mailaddr").html("");
											$(".syokaisyanm").html("");
											$(".ksyasintitle").html("");
											$(".tbusyo1").html("");
											$(".ttantounm1").html("");
											$(".tmailaddr1").html("");
											$(".tbusyo2").html("");
											$(".ttantounm2").html("");
											$(".tmailaddr2").html("");
											$(".tbusyo3").html("");
											$(".ttantounm3").html("");
											$(".tmailaddr3").html("");
											$(".lgid").html("");
											$(".lgpass").html("");
											$(".jyubinno").html("");
											$(".jjyusyo1").html("");
											$(".jjyusyo2").html("");
											$(".jtelno").html("");
											$(".kttelno").html("");
											$(".ktmailaddr").html("");
											$(".syumitxt1").html("");
											$(".syumitxt2").html("");
											$(".syumitxt3").html("");
											$(".sikousyoku").html("");
											$(".sikounomi").html("");
											$(".kaisyanm").html("");
											$(".kaisyanmkana").html("");
											$(".yubinno").html("");
											$(".jyusyo1").html("");
											$(".jyusyo2").html("");
											$(".telno").html("");
											$(".faxno").html("");
											$(".daihyoyknm").html("");
											$(".daihyonm").html("");
											$(".seturitu").html("");
											$(".jyugyoin").html("");
											$(".hpurl").html("");
											$(".gyoumu").html("");
											$(".pr").html("");
											$(".syasintitle1").html("");
											$(".syasintitle2").html("");
											$(".syasintitle3").html("");
									 		allErrArr.forEach(function(errArr) {
									 			var err = errArr.split("##");
									 			focusArea = err[0];
									 		   $("."+err[0]).html(err[1]);
									 		});
									 		$("#"+focusArea).focus();
									 		$('.e-release').prop('disabled', false);
									 		$('.e2-release').prop('disabled', false);
									 	}
										};
									}
								},
								キャンセル: function () {
								}
							}
						});
						$('#previewflg').val('0');
                	} else {
						$("#ksyasintitle").prop("disabled", false);
                		form.submit();
						$("#ksyasintitle").prop("disabled", true);
                	}
                }
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });
})(jQuery, window, document);

jQuery.validator.addMethod(
	"withTwoStrings",
	function(value, element) {
	if(value != '') {
		howManyWords = value.trim();
		howManyWords = howManyWords.replace(/\s{2,}/g, '　'); //remove extra spaces
		howManyWords = howManyWords.split('　');
			if(howManyWords.length == 2){
				return true;
			}
			else{
				return false;
			}
	} else {
		return true;
	}	
	e.preventDefault();
});
jQuery.validator.addMethod(
	"jpcharacter", 
	function(value, element) {
		return this.optional(element) || value.match(/[一-龠]+|[ぁ-ゔ]+|[ァ-ヴー]+|[ａ-ｚＡ-Ｚ０-９]+[々〆〤]+/);
	});
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
jQuery.validator.addMethod("hirasymJH", function(value, element) {
	 return this.optional(element) || /^([ぁ-ん　ー＝~｜－＾\＠［｀｛＋＊｝；：］＜＞？＿，．／！"＃＄％＆'（）－＾＠「‘｛｝＊＋；：」＿？＞＜、。・￥]+)$/.test(value);
	});
jQuery.validator.addMethod(
	"shouraiyear", 
	function(value, element) {
		var currentYear = (new Date).getFullYear();
		if(value <= currentYear){
			return true;
		}
		else{
			return false;
		}
		e.preventDefault();
	});
jQuery.validator.addMethod("notEqual",function(value, element, param) {
    var notEqual = true;
    value = $.trim(value);
    for (i = 0; i < param.length; i++) {
        if (value == $.trim($(param[i]).val())) { notEqual = false; }
    }
    return this.optional(element) || notEqual;
});