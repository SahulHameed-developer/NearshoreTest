$(document).ready(function() {
	$(".backtohome").click(function () {
		$("#backtohome").submit();
	});
	$(".b-search").click(function () {
		$('#adminDownload').submit();
	});
	//編集処理
	$(".edit").click(function () {
		$("#adminDownloadeditArno").val($(this).attr("data-arno"));
		$("#adminDownloadeditFilekey").val($(this).attr("data-filekey"));
		$('#adminDownloadedit').submit();
	});
	//削除処理
	$(".delete").click(function () {
		var arno = $(this).attr("data-arno");
		// var filekey = $("#filekey").val($(this).attr("data-filekey"));
		// var hyojino = $("#hyojino").val($(this).attr("data-hyojino"));
		$.confirm({
			title: '',
			content: '削除を実行しますとデータがディスク上から消去されます。<br>削除してもよろしいですか？',
			columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$('#adminDownloaddelete').attr('target', '');
						$('#adminDownloaddelete').attr('action', '../AdminDlFile/delete');
						var data = new FormData();
						data.append('arno', arno);
						var xhr = new XMLHttpRequest();
					 	xhr.open('POST', 'delete', true);
					 	xhr.send(data);
					 	xhr.onload = function () {
				 		$("#registercls").removeClass('registercls');
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
												$('#adminDownload').submit();
											}
										}
									}
								});
							}else if (xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200 ){
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