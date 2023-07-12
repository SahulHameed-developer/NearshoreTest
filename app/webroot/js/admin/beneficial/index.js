$(document).ready(function() {
	// 有益編集。
	$(".edit").click(function () {
		$("#adminBeneficialeditId").val($(this).attr("data-id"));
		$("#adminBeneficialeditSyasinKey").val($(this).attr("data-syasinkey"));
		$("#adminBeneficialedit" ).submit();
	});
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	$(".backtohome").click(function () {
		$("#backtohome").submit();
	});
	// 削除処理
	$(".delete").click(function () {
		var arno = $(this).attr("data-id");
		var syasin = $(this).attr("data-syasinkey");
		var filekey = $(this).attr("data-filekey");
		$.confirm({
			title: '',
			content: '削除を実行しますとデータがディスク上から消去されます。<br>削除してもよろしいですか？',
			columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						var data = new FormData();
						data.append('arno', arno);
						data.append('syasinKey', syasin);
						data.append('filekey', filekey);
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
												$('#yuekiSearchForm').submit();
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
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".datepickerfmt").MonthPicker({  Button: false, MonthFormat: 'yy/mm' });
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
	jQuery.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.appendTo('#dateFmtError');
		}
	});
});
function sample() {
	var Todate = $("#yuekiDtTo").val();
	var Fromdate = $("#yuekiDtFrm").val();
	alert(Todate);
	$("#Fromdate").val(Fromdate);
	$("#Todate").val(Todate);
}
//入力値の検証
(function($,W,D)
{
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#yuekiSearchForm").validate({
				rules: {
					// 期間（From）
					yuekiDtFrm: "dateFormat",
					// 期間（To）
					yuekiDtTo: "dateFormat"
				},
				messages: {
					//期間（From）のエラーメッセージ。
					yuekiDtFrm: "正しい年月を入力してください。",
					// 期間（To）のエラーメッセージ。
					yuekiDtTo: "正しい年月を入力してください。"
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		}
	}
	$(D).ready(function($) {
		jqueryValidation.UTIL.setupFormValidation();
	});
})(jQuery, window, document);