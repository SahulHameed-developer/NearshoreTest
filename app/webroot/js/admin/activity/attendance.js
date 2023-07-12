var alertFlg = false;
$(document).ready(function() {	
	$(".backtohome").click(function () {
		if(alertFlg == 1){
			$.confirm({
				title: '',
				content: BACK_PAGE,
				type: 'blue',
				buttons: {
					OK: {
						action: function() {
							$( "#backtohome" ).submit();
						}
					},
					キャンセル: function () {
						
					}
				}
			});
		} else {
			$( "#backtohome" ).submit();
		}
	});
	$(".katsudoModoruFrm").click(function () {
		// calenderType : 0 活動カレンダー一覧
		// calenderType : 1 活動報告一覧
		var calenderType = $("#calenderType").val();
		if(alertFlg == 1){
			$.confirm({
				title: '',
				content: BACK_PAGE,
				type: 'blue',
				buttons: {
					OK: {
						action: function() {
							if (calenderType != 0) {
								$('#MSosiki').attr('action', '../adminActivity/activityReportSearch');
								$( "#MSosiki" ).submit();
							} else {
								$('#katsudoModoruFrm').attr('action', '../adminActivity/search');
								$( "#katsudoModoruFrm" ).submit();
							}
						}
					},
					キャンセル: function () {
						
					}
				}
			});
		}
		else {
			if (calenderType != 0) {
				$('#MSosiki').attr('action', '../adminActivity/activityReportSearch');
				$( "#MSosiki" ).submit();
			} else {
				$('#katsudoModoruFrm').attr('action', '../adminActivity/search');
				$( "#katsudoModoruFrm" ).submit();
			}
		}
	});

	$(".b-search").click(function () {
		$("#adminAttendanceFrmKoushinbtn").val("");
		if(alertFlg == 1){
			$.confirm({
				title: '',
				content: BACK_PAGE,
				type: 'blue',
				buttons: {
					OK: {
						action: function() {
							$('#adminAttendanceFrm').submit();
						}
					},
					キャンセル: function () {
						
					}
				}
			});
		} else{
			$('#adminAttendanceFrm').submit();
		}
	});

	$(".b-attend").click(function () {
		alertFlg = false;
		var kaiincd = $(this).attr("data-kaiincd");
		// get the class for change the color
		var color = $("#"+kaiincd).hasClass( "notAttandanceColor" );
		if(color){
			$(this).removeClass( "notAttandanceColor" ).addClass( "attandanceColor" );
			if($("#hnd_attantance"+kaiincd).val() == 1){
				$("#hnd_attantance"+kaiincd).val(0);
			} else {
				$("#hnd_attantance"+kaiincd).val(1);
			}
		}　else {
			$(this).removeClass( "attandanceColor" ).addClass( "notAttandanceColor" );
			if($("#hnd_attantance"+kaiincd).val() == 1){
				$("#hnd_attantance"+kaiincd).val(0);
			} else {
				$("#hnd_attantance"+kaiincd).val(1);
			}
		}
		// to sert the alert flag
		$('input[name^="hnd_attantance"]').each(function() {
			if ($(this).val() == 1) {
				alertFlg = true;
			}
		});
	});
	$(".b-release").click(function() {
		$("#adminAttendanceFrmKoushinbtn").val(1);
		$.confirm({
			title: '',
			content: UPDATE_CONFIRM,
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$('.b-release').prop('disabled', false);
						$("#updatecls").addClass('updatecls');
						var serializedData = $("#adminAttendanceFrm").serialize();
						$.ajax({
							url    : '../AdminActivity/attandancesearch',
							type   : 'POST',
							datatype : 'JSON',
							data   : serializedData,
							async: false,
							success : function(data){
								$("#updatecls").removeClass('updatecls');
								if (data == 1) {
									$.confirm({
										title: '',
										content: UPDATE_SUCCESS,
										type: 'blue',
										buttons: {
											OK: {
												btnClass: 'btn-blue',
												keys: ['enter'],
												action: function(){
													$("#adminAttendanceFrmKoushinbtn").val("");
													$( "#adminAttendanceFrm" ).submit();
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
												keys: ['enter'],
												action: function(){
													window.location = "../Error/systemError";
												}																	
											}
										}
									});
							 	}
							},
						});
					}
				},
				キャンセル: function () {
					
				}
			}
		});
	});
});
