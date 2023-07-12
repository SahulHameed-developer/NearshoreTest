$(function() {
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	$('.members_list_item').matchHeight();
	$('.blocked_list_item').matchHeight();
});
$(document).ready(function() {
	$(".kaishaShosai").click(function () {
		//会員コード
		$("#kaishaShosaifrmKaiincd").val($(this).attr("data-kaishakaiincd"));
		// 会社コード
		$("#kaishaShosaifrmKaisyacd").val($(this).attr("data-kaiinKaisyacd"));
		
		$( "#kaishaShosaifrm" ).submit();
	});
	$(".membersModoru").click(function () {
		$( "#membersModoruFrm" ).submit();
	});
});