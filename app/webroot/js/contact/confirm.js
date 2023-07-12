/*
 * onSubmit お問い合わせの詳細情報画面へ
 */
$(function() {
	$('.confirmSend').click(function() {
		$('#toiawaseiConfirm').attr('action', 'sendmail');
		$("#toiawaseiConfirm").submit();
	});
	$('.backSend').click(function() {
		$('#toiawaseiConfirm').attr('action', 'entry');
		$("#toiawaseiConfirm").submit();
	});
});