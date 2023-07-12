$(document).ready(function() {	
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
	// 添付ファイル1のアップロード
	$(".filebtn").click(function () {
		$("#file").click();
	});
	// ダウンロードファイルのリセット
	$(".rstFile").click(function () {
		$.confirm({
			title: '',
			content: 'ファイルパスがクリアされます。<br>よろしいですか？',
			type: 'blue',
			boxWidth: '310px',
   	 		useBootstrap: false,
			buttons: {
				OK: {
					action: function(){
						$("#filePath").val("");
						$("#filetitle").val("");
						$("#urlfiletitle2").val("");
						$("#pathfile").val("");
						$("#resetfile").val('1');
						$("#file").val("");
						$("#filedd").html("");
						$('.rstFile').prop('disabled', true);
						$('#filetitle').attr('disabled', 'disabled');
						$("#path").hide();
						$(".filetitle").html("");
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	// 添付ファイル
	$( "#file" ).change(function() {
		$('#filetitle').removeAttr('disabled');
		$("#path").hide();
		$(".filetitle").html("");
		if($("#file").val() !="") {
			var iSize = ($("#file")[0].files[0].size / 1024); 
			iSize = (Math.round((iSize / 1024) * 100) / 100);
			if(iSize >= 2) {
				$("#file").val("");
				$("#filePath").val("");
				$("#filedd").html("ファイルサイズは2MB未満でなければなりません。"); 
				if($("#pathfile").val() == "") {
					$("#filetitle").val("");
					$("#urlfiletitle").val("");
					$("#pathfile").val("");
					$("#resetfile").val('1');
					$('.rstFile').prop('disabled', true);
					$('#filetitle').attr('disabled', 'disabled');
					$("#path").hide();
					$(".filetitle").html("");
				}
			} else {
				$("#filedd").html("");
				$('.rstFile').prop('disabled', false);
				$("#resetfile").val('');
			}
		}
		if(this.value !="") {
			$("#filePath").val(this.value);
		}
	});
	$(".b-preview").click(function () {
		// alert('未作成');
		$('#previewflg').val('1');
		$('#adminDownloadedit').submit();
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
			$("#adminDownloadedit").validate({
				onkeyup: false,
				errorPlacement: function(error, element) {
					$('#previewflg').val('0');
					if(element.attr("name") == "filePath") {
						$("#filedd").html("");
						error.appendTo('#filedd');
					} else {
						error.insertAfter(element);
					}
				},
				rules: {
					//カテゴリー
					catageryType:{
						required:true
					},
					//ダウンロードファイルのタイトル
					filetitle: {
						required:true
					},
					//ダウンロードファイルのパス
					filePath: {
						required: function(){
                        	return $("#resetfile").val() == 1;
                  		}
					},
					//表示順
					hyojino: {
						required:true,
						number:true,
					}
				},
				messages: {
					//カテゴリー
					catageryType:{
						required:"カテゴリーを選択してください。"
					},
					//ダウンロードファイルのタイトル
					filetitle: {
						required:"ファイルタイトルを入力してください。"
					},
					//ダウンロードファイルのパス
					filePath: {
						required:"ファイルを選択してください。"
					},
					//表示順
					hyojino: {
						required:"表示順を入力してください。",
						number:"数値を入力してください。"
					}
				},
				submitHandler: function(form) {
					if($('#previewflg').val() == 1 ) {
						$('#adminDownloadedit').attr('target', '_blank');
						$('#adminDownloadedit').attr('action', '../download/index');
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
										$('#adminDownloadedit').attr('target', '');
										$('#adminDownloadedit').attr('action', '../adminDownload/update');
										var data = new FormData();
										var serializedData = $("#adminDownloadedit").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('otherFields', serializedData);
										data.append('file', $("#file").get(0).files[0]);
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
																	$("#menuFrm").submit();
																}
															}
														}
													});
												} else {
													window.location = "../Error/systemError";
												}
										 	} else if(xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200 ) {
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
										 		$(".catageryType").val("");
												$(".filetitle").html("");
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
