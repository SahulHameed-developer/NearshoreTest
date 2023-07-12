$(document).ready(function() {

	// 初期表示に画像選択で、画像タイトル
	if($("#urlsyasin1").val() == ""){
		$('#syasin1Title').attr('disabled', 'disabled');
	}
	// 初期表示に画像選択で、リセット
	if($("#urlsyasin1").val() == ""){
		$('.rstSyasin1').prop('disabled', true);
	}
	// $('#busyo').prop('disabled', true);
	// $('#tantounm').prop('disabled', true);
	// $('#tantoumsg').prop('disabled', true);

	if($("#kikanfrom").prop('disabled') == false) {
		function validategContractDate() {
			$('#kikanfrom').trigger('focusin');
			$('#kikanfrom').trigger('focusout');
			$('#kikanto').trigger('focusin');
			$('#kikanto').trigger('focusout');
		}
		$('#kikanfrom, #kikanto').datepicker()
		    .on("input change click", function (e) {
		    	validategContractDate();
		});
	}

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
				// alert(errorData.status);
			}
		});
	});
	
	$(".listBack").click(function () {
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
		$('#adminPRshohinupdate').attr('target', '_blank');
		$('#adminPRshohinupdate').attr('action', PR_PREVIEW_PATH);
		$('#adminPRshohinupdate').submit();
	});
	$(".edit").click(function(){
		$('#adminPRshohinupdate').submit();
	});
	// 写真1のアップロード
	$(".syasin1btn").click(function () {
		$("#syasin1").click();
	});
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
				$("#thum01").attr('src', $("#baseurl").val()+'/app/webroot/img/admin/thum_02.gif');
				$("#syasin1dd").html("ファイルサイズは2MB未満でなければなりません。"); 
				$("#syasin1Title").val("");
				$('#syasin1Title').attr('disabled', 'disabled');
				$("#reset1").val('1');
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

	$('#prtantou').change(function() {
		var validator = $("#adminPRshohinupdate").validate();
		validator.resetForm();
		if($(this).val() != "") {
			var id = this.id;
			$.ajax({
				url    : '../AdminProductsite/gettantoudata',
				type   : 'POST',
				datatype : 'JSON',
				data   : {'arno': this.value},
				async: false,
				success : function(data){
					data = JSON.parse(data);
					$('#busyo').val(data.TPrtantou.busyo);
					$('#tantounm').val(data.TPrtantou.tantounm);
					$('#tantoumsg').val(data.TPrtantou.tantoumsg);
				},
				error : function(errorData){
					// alert(errorData.status);
				}
			});
			$('#deletetantou').show();
			// $('#busyo').attr('disabled','true');
			// $('#tantounm').attr('disabled','true');
			// $('#tantoumsg').attr('disabled','true');
		} else {
			$('#busyo').val('');
			$('#tantounm').val('');
			$('#tantoumsg').val('');
			$('#deletetantou').hide();
			// $('#busyo').removeAttr('disabled');
			// $('#tantounm').removeAttr('disabled');
			// $('#tantoumsg').removeAttr('disabled');
		}
	});

	$('#deletetantou').click(function () {
		var prtantou = $('#prtantou').val();
		$.confirm({
			title: '',
			content: '選択している担当者情報がディスク上から消去されます。<br>削除してもよろしいですか？',
			type: 'blue',
	        columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
			buttons: {
				OK: {
					action: function(){
						var id = this.id;
						$.ajax({
							url    : '../AdminProductsite/deletetantoudata',
							type   : 'POST',
							datatype : 'JSON',
							data   : {'arno': prtantou, 'kaisyacd': $("#kaisyacd").val() },
							async: false,
							success : function(data){
								data = JSON.parse(data);
								if(data == "0") {
									$.confirm({
										title: '',
										content: "この担当者は、他のPR商品情報で使用されています。",
										type: 'blue',
	        							columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
										buttons: {
											OK: {
												btnClass: 'btn-blue',
												keys: ['enter']																	
											}
										}
									});
								} else {
									var count = Object.keys(data).length;
									jQuery('#prtantou').val('');
									jQuery('#prtantou').text('');
							     	$('#prtantou').append( '<option value="">選択してください</option>' );
							     	$.each(data , function(i, val) { 
							    		 $("#prtantou").append('<option value="'+i+'">'+val+'</option>');
							    	});
									$('#busyo').val('');
									$('#tantounm').val('');
									$('#tantoumsg').val('');
									$('#deletetantou').hide();
									// $('#busyo').removeAttr('disabled');
									// $('#tantounm').removeAttr('disabled');
									// $('#tantoumsg').removeAttr('disabled');
								}
							},
							error : function(errorData){
								// alert(errorData.status);
							}
						});
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
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
			$("#adminPRshohinupdate").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					$(".syohinnm").html("");
					$(".syousai").html("");
					$(".kikanfrom").html("");
					$(".kikanto").html("");
					$(".syasin1Title").html("");
					if(element.attr("name") == "syasin1Path") {
						error.appendTo( element.parent("div").next("div") );
					} else if(element.attr("name") == "kikanfrom" || element.attr("name") == "kikanto") {
						$(".date_errorft").html("");
						error.appendTo('.date_errorft');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					// 有益内容
					syohinnm: {
						required:true,
						maxlength: 1024
					},
					// 有益内容
					syousai: {
						required:true,
						maxlength: 1024
					},
					//全角のみ
					syasin1Title: {
						zenkaku:true,
						maxlength: 60
					},
					syasin1Path: "imgval1",
					busyo: {
						required:true
					},
					tantounm: {
						required:true,
						withTwoStrings: true

					},
					tantoumsg: {
						required:true
					},
					// 有益日付
					kikanfrom: {
						required:true,
						dateFormat: true,
						gkeiyakukikan: true
					},
					// 有益時刻
					kikanto: {
						required:true,
						dateFormat: true,
						lessThan: '[name="kikanfrom"]',
						gkeiyakukikan: true
					},
					//表示順
					hyojino: {
						required:true,
						number:true,
					}
				},
				messages: {
					// 有益内容
					syohinnm: { 
						required:"商品・サービス名が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					// 有益内容
					syousai: {
						required:"商品・サービス詳細が未入力です。",
						maxlength: "最大文字数を超えています。"
					},
					//全角のみ
					syasin1Title: {
						zenkaku:"全角を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					syasin1Path : "画像しか入力できません。画像を入力してください。",
					busyo: { 
						required:"担当部署が未入力です。"
					},
					tantounm: {
						required:"担当者名が未入力です。",
						withTwoStrings:"姓と名の間に全角スペースを入力してください。"
					},
					tantoumsg: { 
						required:"メッセージが未入力です。"
					},
					// 有益日付
					kikanfrom: {
						required:"公開期間（開始日）を入力してください。",
						dateFormat: "公開期間（開始日）が不正な形式です。",
						gkeiyakukikan: "公開期間は、契約期間内の日付にしてください。"
					},
					// 有益時刻
					kikanto: {
						required:"公開期間（終了日）を入力してください。",
						dateFormat: "公開期間（終了日）が不正な形式です。",
						lessThan:"期間の開始、終了を正しく入力してください。",
						gkeiyakukikan: "公開期間は、契約期間内の日付にしてください。"
					},
					//表示順
					hyojino: {
						required:"表示順を入力してください。",
						number:"数値を入力してください。"
					}
				},
				submitHandler: function(form) {
					if($('#previewflg').val() == 1 ) {
						$('#previewflg').val('0');
						form.submit();
					} else {
						$.confirm({
							title: '',
							content: UPDATE_CONFIRM,
							type: 'blue',
							buttons: {
								OK: {
									action: function(){
										$("#updatecls").addClass('updatecls');
					                	$('.b-release').prop('disabled', true);
										$('#adminPRshohinupdate').attr('target', '');
										$('#adminPRshohinupdate').attr('action', '../AdminProductsite/update');
										var data = new FormData();
										var serializedData = $("#adminPRshohinupdate").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('syasin1', $("#syasin1").get(0).files[0]);
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
																keys: ['enter'],
																action: function(){
															 		$('.b-release').prop('disabled', false);
																}																	
															}
														}
													});
										 		var allErrArr = xhr.responseText.split("$$");
										 		var focusArea ="";
												$(".syohinnm").html("");
												$(".syousai").html("");
												$(".kikanfrom").html("");
												$(".kikanto").html("");
												$(".syasin1Title").html("");
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
jQuery.validator.addMethod("gkeiyakukikan", function(value, element) {
	var to = new Date($("#gkeiyakukikanto").val()+ "/01"), y = to.getFullYear(), m = to.getMonth();
	var lastDay = new Date(y, m + 1, 0).getDate();
	var startDate = $("#gkeiyakukikanfrom").val() + "/01";
	var EndDate = $("#gkeiyakukikanto").val()+ "/" + lastDay;
	if(dateCheck(startDate,EndDate,value)){
		return true;
	} else {
		return false;
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