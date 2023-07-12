$(document).ready(function() {
	// 会員追加。
	$(".addValue").click(function () {
			// 会員コード
			$("#Productaddfrm #kaiincd").val($(this).attr("data-kaiincd"));
			// 会社コード
			$("#Productaddfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
			// 会社名前
			$("#Productaddfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
			$("#Productaddfrm #g_keiyaku_from").val($(this).attr("data-g_keiyaku_from"));
			$("#Productaddfrm #g_keiyaku_to").val($(this).attr("data-g_keiyaku_to"));
			// フォーム提出
			$("#Productaddfrm" ).submit();
	});
	//  会員編集。
	$(".editValue").click(function(){
			$("#Producteditfrm #arno").val($(this).attr("data-arno"));
			// 会員コード
			$("#Producteditfrm #kaiincd").val($(this).attr("data-kaiincd"));
			// 会社コード
			$("#Producteditfrm #kaisyacd").val($(this).attr("data-kaisyacd"));
			// 会社名前
			$("#Producteditfrm #kaisyanm").val($(this).attr("data-kaisyanm"));
			$("#Producteditfrm #g_keiyaku_from").val($(this).attr("data-g_keiyaku_from"));
			$("#Producteditfrm #g_keiyaku_to").val($(this).attr("data-g_keiyaku_to"));
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
					 	xhr.open('POST', 'AdminProductsite/delete', true);
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
												window.location="AdminProductsite";
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