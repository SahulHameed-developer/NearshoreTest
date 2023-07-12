$(document).ready(function() {
	$(".backtohome").click(function () {
		$("#backtohome").submit();
	});
	jQuery.validator.addMethod(
		"dateFormat",
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
	jQuery.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.appendTo('#dateFmtError');
		}
	});
	// 会員追加。
	$(".addValue").click(function () {
			// 会員コード
			// $("#Productaddfrm #TPrkeiyakuarno").val($(this).attr("data-TPrkeiyakuarno"));
			$("#Productaddfrm #g_keiyaku_from").val($(this).attr("data-g_keiyaku_from"));
			$("#Productaddfrm #g_keiyaku_to").val($(this).attr("data-g_keiyaku_to"));
			$("#Productaddfrm #kaiincd").val($(this).attr("data-kaiincd"));
			// 会社コード
			$("#Productaddfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
			// 会社名前
			$("#Productaddfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
			// フォーム提出
			$("#Productaddfrm" ).submit();
	});
	//  会員編集。
	$(".editValue").click(function(){
			
			$("#Producteditfrm #arno").val($(this).attr("data-arno"));
			// $("#Producteditfrm #TPrkeiyakuarno").val($(this).attr("data-TPrkeiyakuarno"));
			$("#Producteditfrm #g_keiyaku_from").val($(this).attr("data-g_keiyaku_from"));
			$("#Producteditfrm #g_keiyaku_to").val($(this).attr("data-g_keiyaku_to"));
			// 会員コード
			$("#Producteditfrm #kaiincd").val($(this).attr("data-kaiincd"));
			// 会社コード
			$("#Producteditfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
			// 会社名前
			$("#Producteditfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
			// フォーム提出
			$("#Producteditfrm" ).submit();
	});
	$(".delete").click(function(){
		var arno = $(this).attr("data-arno");
		$.confirm({
			title: '',
			content: "削除を実行しますとデータがディスク上から消去されます。<br/>削除してもよろしいですか？",
			type: 'blue',
	        columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
			buttons: {
				OK: {
					action: function(){
						var data = new FormData();
						data.append('arno', arno);
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
												$('#ProductSearchForm').submit();
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
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
});

//入力値の検証
(function($,W,D) {
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#ProductSearchForm").validate({
				rules: {
					// 期間（From）
					fromdate:{
						dateFormat:true},
					// 期間（To）
					todate: {
						dateFormat:true,
						lessThan: '[name="fromdate"]'}
				},
				messages: {
					//期間（From）のエラーメッセージ。
					fromdate: "正しい日付を入力してください。",
					// 期間（To）のエラーメッセージ。
					todate: { 
						dateFormat:"正しい日付を入力してください。",
						lessThan:"期間の開始、終了を正しく入力してください。"
					}
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