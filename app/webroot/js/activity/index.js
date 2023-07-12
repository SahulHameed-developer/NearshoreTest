$(document).ready(function() {
	// 活動カレンダー画面から、必要なデータを取得して、詳細画面へ移動する処理。
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	if($('#scroll_val').val() > 0 && $('#scroll_val').val() != "" ) {
		$('body,html').animate({scrollTop: $('#scroll_val').val() }, 0, "swing");
	}
	$(".shosaiShutoku").click(function () {
		// 連番
		$("#scroll_val").val($(window).scrollTop());
		$("#shosaiShutokuFrmArno").val($(this).attr("data-arno"));
		$("#shosaiShutokuFrm").attr("action", $(this).attr("data-actionfunction"));
		$("#shosaiShutokuFrm").submit();
	});
	$(".shousaijouhou").click(function () {
		// 連番
		$("#scroll_val").val($(window).scrollTop());
		$("#shosaiJouhouFrmArno").val($(this).attr("data-arno"));
		$("#shosaiJouhouFrm").submit();
	});
	$(".moshiKomi").click(function () {
		// 連番
		$("#moshiKomiFrmArno").val($(this).attr("data-arno"));
		$("#moshiKomiFrm").submit();
	});
	/*$(".moshiKomitorikeshi_index").click(function () {
		$("#moshiKomitorikeshiFrmArno").val($(this).attr("data-arno"));
		$.confirm({
			title: '',
			content: '申し込みが取り消されます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#shorichuucls").addClass('shorichuucls');
						$("#moshiKomitorikeshiFrm").submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});*/
	/*$(".moshiKomitorikeshi").click(function () {
		$.confirm({
			title: '',
			content: '申し込みが取り消されます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#shorichuucls").addClass('shorichuucls');
						$("#moshiKomitorikeshiFrm").submit();
						// 画面の入力、選択内容をクリアする
					}
				},
				キャンセル: function () {
				}
			}
		});
	});*/
	$(".moshiKomitorikeshi_index").click(function () {
		$("#moshiKomitorikeshiFrmArno").val($(this).attr("data-arno"));
		$("#moshiKomitorikeshiFrmBunruicd").val($(this).attr("data-bunruicd"));
		$("#moshiKomitorikeshiFrm").submit();
	});
	$('.moshiKomitorikeshi').on('click', function() {
		if ($("#moshiKomitorikeshiFrm").valid()) {
			$.confirm({
				title: '',
				content: '申し込みが取り消されます。<br>よろしいですか？',
				type: 'blue',
				buttons: {
					OK: {
						action: function(){
							$("#shorichuucls").addClass('shorichuucls');
							$("#moshiKomitorikeshiFrm").submit();
							// 画面の入力、選択内容をクリアする
						}
					},
					キャンセル: function () {
					}
				}
			});
		}
	});
	// 活動カレンダー詳細画面から活動カレンダー 一覧画面へ移動する処理
	$(".shosaiModoru").click(function () {
		if(btop == "top") {
			window.location = "<?php echo $this->Html->url(array('controller' => 'Top', 'action' => 'index')); ?>";
		} else {
			$( "#shosaiModoruFrm" ).submit();
		}
	});

	// 出席する　（会議）
	$(".shuseki").click(function () {
		// 連番
		$("#moshiKomiFrmArno").val($(this).attr("data-arno"));
		$("#moshiKomiFrm").submit();
	});

	// 出席を取り消す　（会議）
	/*$(".shusekiTorikeshi_index").click(function () {
		$("#moshiKomitorikeshiFrmArno").val($(this).attr("data-arno"));
		$.confirm({
			title: '',
			content: '出席が取り消されます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#shorichuucls").addClass('shorichuucls');
						$("#moshiKomitorikeshiFrm").submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});*/

	/*$(".shusekiTorikeshi").click(function () {
		$.confirm({
			title: '',
			content: '出席が取り消されます。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
						$("#shorichuucls").addClass('shorichuucls');
						$("#moshiKomitorikeshiFrm").submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});*/
	$('.shusekiTorikeshi').on('click', function() {
		if ($("#moshiKomitorikeshiFrm").valid()) {
			$.confirm({
				title: '',
				content: '出席が取り消されます。<br>よろしいですか？',
				type: 'blue',
				buttons: {
					OK: {
						action: function(){
							$("#shorichuucls").addClass('shorichuucls');
							$("#moshiKomitorikeshiFrm").submit();
						}
					},
					キャンセル: function () {
					}
				}
			});
		}
	});
	$(".shusekiTorikeshi_index").click(function () {
		$("#moshiKomitorikeshiFrmArno").val($(this).attr("data-arno"));
		$("#moshiKomitorikeshiFrmBunruicd").val($(this).attr("data-bunruicd"));
		$("#moshiKomitorikeshiFrm").submit();
	});

	$('#kaigiFrom, #kaigiTo').on('change blur',function() {
		var kaigiFrom = $( "#kaigiFrom" ).val();
		var kaigiTo = $( "#kaigiTo" ).val();
		var kaigiFromchk = dateformat(kaigiFrom);
		var kaigiTochk = dateformat(kaigiTo);
		if(!kaigiFromchk || !kaigiTochk) {
			$("#selectError1").html('正しい年月を入力してください。');
			return false;
		} else if (kaigiFrom > kaigiTo && kaigiFrom != "" && kaigiTo != "")  {
			$("#selectError1").html(dataCompareError);
			return false;
		} else {
			$("#selectError1").html('');
		}
	});
	$('#eventFrom, #eventTo').on('change blur',function() {
		var eventFrom = $( "#eventFrom" ).val();
		var eventTo = $( "#eventTo" ).val();
		var eventFromchk = dateformat(eventFrom);
		var eventTochk = dateformat(eventTo);
		if(!eventFromchk || !eventTochk) {
			$("#selectError2").html('正しい年月を入力してください。');
			return false;
		} else if (eventFrom > eventTo && eventFrom != "" && eventTo != "")  {
			$("#selectError2").html(dataCompareError);
			return false;
		} else {
			$("#selectError2").html('');
		}
	});
	$(".kaigibtn").click(function () {
		$("#srchtyp").val('1');
		$("#event").val('');
		$("#eventFrom").val('');
		$("#eventTo").val('');
		$("#selectError2").html("");
		var kaigiFrom = $( "#kaigiFrom" ).val();
		var kaigiTo = $( "#kaigiTo" ).val();
		var kaigiFromchk = dateformat(kaigiFrom);
		var kaigiTochk = dateformat(kaigiTo);
		if(!kaigiFromchk || !kaigiTochk) {
			$("#selectError1").html('正しい年月を入力してください。');
			return false;
		} else {
			$("#selectError1").html('');
		}
		if(kaigiFrom > kaigiTo && kaigiFrom != "" && kaigiTo != "") {
			$("#selectError1").html(dataCompareError);
			return false;
		}
	});
	$(".eventbtn").click(function () {
		$("#srchtyp").val('2');
		$("#conference").val('');
		$("#kaigiFrom").val('');
		$("#kaigiTo").val('');
		$("#selectError1").html("");
		var eventFrom = $( "#eventFrom" ).val();
		var eventTo = $( "#eventTo" ).val();
		var eventFromchk = dateformat(eventFrom);
		var eventTochk = dateformat(eventTo);
		if(!eventFromchk || !eventTochk) {
			$("#selectError2").html('正しい年月を入力してください。');
			return false;
		} else {
			$("#selectError2").html('');
		}
		if(eventFrom > eventTo && eventFrom != "" && eventTo != "") {
			$("#selectError2").html(dataCompareError);
			return false;
		}
	});
	$(".kaigi1").click(function () {
		$("#srchtyp").val('1');
	});
	$(".event2").click(function () {
		$("#srchtyp").val('2');
	});
	$(".backLink").click(function () {
		$( "#MSosiki" ).submit();
	})
});
function dateformat(value) {
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
		} else {
			check = false;
		}
	} else {
		check = false;
	}
	if(value == "") {
		check = true;
	}
	return check;
}
