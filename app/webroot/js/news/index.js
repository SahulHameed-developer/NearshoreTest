/*
 * onSubmit お知らせの詳細情報画面へ
 */
$(document).ready(function() {
	$.ajax({
     url    : 'news/getMoreRecords',
     type   : 'POST',
     datatype : 'JSON',
     data   : {'reccount': parseInt($("#recCount").val()) },
     async: false,
     success : function(data){
    	 data = JSON.parse(data);
    	 var count = Object.keys(data).length;
    	 	$('#record').empty();
     		$.each(data , function(i, val) {
     			var arno = JSON.stringify(data[i]['TOsirase']['arno']);
     			var title = JSON.stringify(data[i]['TOsirase']['title']).replace(/\"/g, "");
     			var osirasedt = JSON.stringify((data[i]['TOsirase']['osirasedt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
     			// var kousinTourokudt = JSON.stringify((data[i]['TOsirase']['kousinTourokudt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
     			$('#record').append( '<a href="javascript:;" data-arno='+arno+' class="news_list_item displayDtl"><dl><dt>'+osirasedt+'</dt><dd><div class="oshirasewidht titleOverflow">'+title+'</div></dd></dl></a>' );
   			});
       }
	});
	if($('#scroll_val').val() > 0 && $('#scroll_val').val() != "" ) {
		$('body,html').animate({scrollTop: $('#scroll_val').val() }, 0, "swing");
	}
	$('#record').on('click', '.news_list_item', function() {
		$("#scroll_val").val($(window).scrollTop());
		$("#arno").val($(this).attr("data-arno"));
		$("#newsDetailfrm").submit();
	});
	$(".displayBtn").click(function () {
		var recCount = parseInt($("#recCount").val())+parseInt('8');
		$("#recCount").val(recCount);
		if(parseInt($("#recCount").val()) >= parseInt($("#count").val())) {
			$(".btndiv").hide();
		}
		$.ajax({
	     url    : 'news/getMoreRecords',
	     type   : 'POST',
	     datatype : 'JSON',
	     data   : {'reccount': parseInt($("#recCount").val()) },
	     async: false,
	     success : function(data){
	    	 data = JSON.parse(data);
	    	 var count = Object.keys(data).length;
	    	 $('#record').empty();
			 $.each(data , function(i, val) {
				var arno = JSON.stringify(data[i]['TOsirase']['arno']);
				var title = JSON.stringify(data[i]['TOsirase']['title']).replace(/\"/g, "");
				var osirasedt = JSON.stringify((data[i]['TOsirase']['osirasedt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
				// var kousinTourokudt = JSON.stringify((data[i]['TOsirase']['kousinTourokudt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
				$('#record').append( '<a href="javascript:;" data-arno='+arno+' class="news_list_item displayDtl"><dl><dt>'+osirasedt+'</dt><dd><div class="oshirasewidht titleOverflow">'+title+'</div></dd></dl></a>' );
			 });
	      },
	      error : function(errorData){
	    	  alert(errorData.status);
	      }
		});
	});
	if(parseInt($("#recCount").val()) >= parseInt($("#count").val())) {
		$(".btndiv").hide();
	}
});