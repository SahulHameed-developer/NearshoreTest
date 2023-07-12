$(document).ready(function() {	
	//初期表示でファイルを選択してリセットする
	$('.rstFile1').prop('disabled', true);
	//初期表示にファイル選択で、ファイルタイトル
	$('#title').attr('disabled', 'disabled');
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
	//アップロードファイル
	$(".downloadbtn").click(function () {
		$("#file1").click();
	});
	// アップロードファイル
	$( "#file1" ).change(function() {
		$('#title').removeAttr('disabled');
		$('.rstFile1').prop('disabled', false);
		$(".title").html("");
		$('#filetitle').removeAttr('disabled');
		$(".filetitle").html("");
		if($("#file1").val() !="") {
			var iSize = ($("#file1")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file1").val("");
				$("#filepath").val("");
				$('.rstFile1').prop('disabled', true);
				$("#file1dd").html("ファイルサイズは2MB未満でなければなりません。");
				$("#title").val("");
				$('.rstFile1').prop('disabled', true);
				$('#title').attr('disabled', 'disabled');
				$(".title").html("");
			} else {
				$("#file1dd").html("");
				$('.rstFile1').prop('disabled', false);
			}
		}
		if(this.value !="") {
			$("#filepath").val(this.value);
		}
	});
	// アップロードファイル
	$(".rstFile1").click(function () {
		$.confirm({
			title: '',
			content: 'ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			boxWidth: '310px',
   	 		useBootstrap: false,
			buttons: {
				OK: {
					action: function(){
						$("#filepath").val("");
						$("#title").val("");
						$("#file1").val("");
						$("#file1dd").html("");
						$('.rstFile1').prop('disabled', true);
						$('#title').attr('disabled', 'disabled');
						$(".title").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".b-preview").click(function () {
		$('#previewflg').val('1');
		$('#downloadregister').submit();
	});
});
jQuery.validator.addMethod("numbersOnly", function(value, element) {
	return this.optional(element) || value.match(/^[0-9]*$/);
});
jQuery.validator.addMethod("notzero", function(value, element) {
	if( value != 0 ) { return true; } else { return false; }
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
			$("#downloadregister").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					$('#previewflg').val('0');
					if(element.attr("name") == "filepath") {
						$("#file1dd").html("");
						error.appendTo('#file1dd');
						//error.appendTo('.error-list');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					//カテゴリー
					rno:{
						 required:true
					},
					//ダウンロードファイルのタイトル
					title: {
						  required:true,
						  maxlength: 60
					},
					//ダウンロードファイルのパス
					filepath: {
						required:true
					},
					//表示順
					hyojino: {
						 required:true,
						 numbersOnly:true,
						 notzero:true,
                   		 maxlength: 3
					}
				},
				messages: {
					//カテゴリー
					rno:{
						required:"カテゴリーを選択してください。"
					},
					//ダウンロードファイルのタイトル
					title: {
						required:"ファイルタイトルを入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					//ダウンロードファイルのパス
					filepath: {
						required:"ファイルを選択してください。"
					},
					//表示順
					hyojino: {
						required:"表示順を入力してください。",
						numbersOnly:"数値を入力してください。",
						notzero:"有効な表示順を入力してください。",
                		maxlength: "最大文字数を超えています。"
					}
				},
				submitHandler: function(form) {
					if($('#previewflg').val() == 1 ) {
						$('#downloadregister').attr('target', '_blank');
						$('#downloadregister').attr('action', '../download/index');
						$('#previewflg').val('0');
						form.submit();
					} else {
						$.confirm({
							title: '',
							content: INSERT_CONFIRM,
							type: 'blue',
							buttons: {
								OK: {
									action: function(){
										$("#registercls").addClass('registercls');
					                	$('.b-release').prop('disabled', true);
										$('#downloadregister').attr('target', '');
										$('#downloadregister').attr('action', '../AdminDlFile/register');
										var data = new FormData();
										var serializedData = $("#downloadregister").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('otherFields', serializedData);
										data.append('file1', $("#file1").get(0).files[0]);
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
																	$("#menuFrm").attr('action', '../AdminDlFile/add');
																	$("#menuFrm").submit();
																}
															}
														}
													});
												} else {
													window.location = "../Error/systemError";
												}
										 	} else if(xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200){
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
										 		$(".shinkicatagery").html("");
												$(".filetitle").html("");
												$(".filepath").html("");
												$(".hyojino").html("");
										 	 	$(".rno").val("");
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
