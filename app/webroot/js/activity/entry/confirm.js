$(document).ready(function() {
	// 会議・イベント申込確認画面から、必要なデータを取得して、会議・イベント申込入力画面へ移動する処理。
	$(".kaigiEvent").click(function () {
		$("#moshiKomiFrm").submit();
	});

	$(".confirm_button").click(function () {
		$("#shorichuucls").addClass('shorichuucls');
	});
});