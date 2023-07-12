$(document).ready(function() {
	$(".shosaiSakujo").click(function () {
		var arno = $(this).attr("data-arno");
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
												if($(".srch").val() == 1){
													$(".kaigisrch").trigger("click");
												} else {
													$(".eventsrch").trigger("click");
												}
												// $('#MSosikiSearchForm').submit();
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
						//$("#shosaiSakujoFrmArno").val(arno);
						//$("#MSosikiSearchForm").submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
	$(".shosaiShutoku").click(function () {
		var arno = $(this).attr("data-arno");
		$("#shosaiShutokuFrmArno").val(arno);
		$("#shosaiShutokuFrm").submit();
	});
	$(".shosaiTouroku").click(function () {
		var arno = $(this).attr("data-arno");
		$("#shosaiShutokuFrmArno").val(arno);
		$('#shosaiShutokuFrm').attr('action', '../AdminActivity/add');
		$("#shosaiShutokuFrm").submit();
	});

	$(".attendanceReport").click(function () {
		$("#adminActivityAttendanceFrmArno").val($(this).attr("data-arno"));
		$("#adminActivityAttendanceFrmMeisyou").val($(this).attr("data-meisyou"));
		$("#adminActivityAttendanceFrmHdnBunruicd").val($(this).attr("data-hdn_bunruicd"));
		$("#adminActivityAttendanceFrm" ).submit();
	});

	$(".backtohome").click(function () {
		$("#backtohome").submit();
	});
});