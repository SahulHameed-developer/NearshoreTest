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
	jQuery.validator.addMethod("monthFormat", function(value, element) {
		var check = false;
		var re = /^(\d{4})\/(\d{1,2})$/;
			if( re.test(value)) {
				var adata = value.split('/');
				var yyyy = parseInt(adata[0],10);
				var mm = parseInt(adata[1],10);
				var xdata = new Date(yyyy,mm-1);
				if ( ( xdata.getFullYear() === yyyy ) && ( xdata.getMonth () === mm - 1 ) ) {
					check = true;
				} else {
					check = false;
				}
			} else {
				check = false;
			}
			return this.optional(element) || check;
	});
	$(".rirekiListBack").click(function () {
		$("#ContractSearchForm" ).submit();
	});
	// 会員追加。
	$(".rirekiList").click(function () {
		// alert("未作成")
		$("#Contractaddfrm #arno").val($(this).attr("data-arno"));
		// 会員コード
		$("#Contractaddfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
		// 会社名前
		$("#Contractaddfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
		// フォーム提出
		$('#Contractaddfrm').attr('action', 'rirekiList');
		$("#Contractaddfrm" ).submit();
	});
	// 会員追加。
	$(".editValue").click(function () {
		// alert("未作成")
		$("#Contracteditfrm #arno").val($(this).attr("data-arno"));
		// 会員コード
		$("#Contracteditfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
		// 会社名前
		$("#Contracteditfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
		$("#Contracteditfrm #prevaluesto").val($(this).attr("data-prevaluesto"));
		$("#Contracteditfrm #nextvaluesfrom").val($(this).attr("data-nextvaluesfrom"));
		// フォーム提出
		$("#Contracteditfrm" ).submit();
	});
	// 会員追加。
	$(".renewalValue").click(function () {
		// alert("未作成")
		$("#Contractrenewalfrm #arno").val($(this).attr("data-arno"));
		// 会員コード
		$("#Contractrenewalfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
		// 会社名前
		$("#Contractrenewalfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
		$("#Contractrenewalfrm #g_keiyaku_from").val($(this).attr("data-g_keiyaku_from"));
		$("#Contractrenewalfrm #g_keiyaku_to").val($(this).attr("data-g_keiyaku_to"));

		var from = $(this).attr("data-g_keiyaku_from");
		var to = $(this).attr("data-g_keiyaku_to");
		var dt = new Date();
		var curdate = dt.getFullYear() + "-" + String("0" + (dt.getMonth() + 1)).slice(-2) + "-" + String("0" + (dt.getDate())).slice(-2);
		if(from <= curdate) {
			// フォーム提出
			$("#Contractrenewalfrm" ).submit();
		} else {
			$.confirm({
				title: '',
				content: '開始前の契約が存在しているため、契約更新はできません。',
	        	columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-11 col-xs-offset-1',
				type: 'blue',
				buttons: {
					OK: {
						btnClass: 'btn-blue',
						keys: ['enter']                                 
					}
				}
			});
		}
	});
	// 会員追加。
	$(".addValue").click(function () {
		// 会社コード
		$("#Contractaddfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
		// 会社名前
		$("#Contractaddfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
		// フォーム提出
		$("#Contractaddfrm" ).submit();
	});
	$(".delete").click(function(){
		var arno = $(this).attr("data-arno");
		var kaisyacd = $(this).attr("data-kaisyacd");
		var g_keiyaku_from = $(this).attr("data-g_keiyaku_from");
		var g_keiyaku_to = $(this).attr("data-g_keiyaku_to");
		var ktukisuu = $(this).attr("data-ktukisuu");
		var g_keikin = $(this).attr("data-g_keikin");
		var kykbn = $(this).attr("data-kykbn");
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
						data.append('kaisyacd', kaisyacd);
						data.append('s_keiyaku_from', g_keiyaku_from);
						data.append('s_keiyaku_to', g_keiyaku_to);
						data.append('ktukisuu', ktukisuu);
						data.append('s_keikin', g_keikin);
						data.append('kykbn', kykbn);
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
												$('#ContractSearchForm').submit();
											}
										}
									}
								});
							} else if (xhr.responseText == "2") {
					 			$.confirm({
									title: '',
									content: "契約期間内にPR商品情報が登録されているため、削除できません。",
	        						columnClass: 'col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-3 col-xs-11 col-xs-offset-1',
									type: 'blue',
									buttons: {
										OK: {
											btnClass: 'btn-blue',
											keys: ['enter']																	
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
			$("#ContractSearchForm").validate({
				rules: {
					// 期間（From）
					fromdate:{
						monthFormat:true
					},
					// 期間（To）
					todate: {
						monthFormat:true,
						lessThan: '[name="fromdate"]'}
				},
				messages: {
					//期間（From）のエラーメッセージ。
					fromdate: "正しい年月を入力してください。",
					// 期間（To）のエラーメッセージ。
					todate: { 
						monthFormat:"正しい年月を入力してください。",
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