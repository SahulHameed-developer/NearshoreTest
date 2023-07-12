/*
 * onSubmit 有益の詳細情報画面へ
 */
$(document).ready(function() {
	$.ajax({
     url    : 'Beneficial/getMoreRecords',
     type   : 'POST',
     datatype : 'JSON',
     data   : {'reccount': parseInt($("#recCount").val()) },
     async: false,
     success : function(data){
    	 data = JSON.parse(data);
    	 var count = Object.keys(data).length;
    	 	$('#record').empty();
     		$.each(data , function(i, val) {
     			var arno = JSON.stringify(data[i]['TYueki']['arno']);
     			var title = JSON.stringify(data[i]['TYueki']['title']).replace(/\"/g, "");
     			var jyohodt = JSON.stringify((data[i]['TYueki']['jyohodt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
     			// var kousinTourokudt = JSON.stringify((data[i]['TYueki']['kousinTourokudt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
     			$('#record').append( '<a href="javascript:;" data-arno='+arno+' class="beneficial_list_item displayDtl"><dl><dt>'+jyohodt+'</dt><dd><div class="oshirasewidht titleOverflow">'+title+'</div></dd></dl></a>' );
   			});
       }
	});
	if($('#scroll_val').val() > 0 && $('#scroll_val').val() != "" ) {
		$('body,html').animate({scrollTop: $('#scroll_val').val() }, 0, "swing");
	}
	$('#record').on('click', '.beneficial_list_item', function() {
		$("#scroll_val").val($(window).scrollTop());
		$("#arno").val($(this).attr("data-arno"));
		$("#beneficialDetailfrm").submit();
	});
	$(".displayBtn").click(function () {
		var recCount = parseInt($("#recCount").val())+parseInt('8');
		$("#recCount").val(recCount);
		if(parseInt($("#recCount").val()) >= parseInt($("#count").val())) {
			$(".btndiv").hide();
		}
		$.ajax({
	     url    : 'Beneficial/getMoreRecords',
	     type   : 'POST',
	     datatype : 'JSON',
	     data   : {'reccount': parseInt($("#recCount").val()) },
	     async: false,
	     success : function(data){
	    	 data = JSON.parse(data);
	    	 var count = Object.keys(data).length;
	    	 $('#record').empty();
			 $.each(data , function(i, val) {
				var arno = JSON.stringify(data[i]['TYueki']['arno']);
				var title = JSON.stringify(data[i]['TYueki']['title']).replace(/\"/g, "");
				var jyohodt = JSON.stringify((data[i]['TYueki']['jyohodt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
				// var kousinTourokudt = JSON.stringify((data[i]['TYueki']['kousinTourokudt']).substring(0,10)).replace(/\-/g, ".").replace(/\"/g, " ");
				$('#record').append( '<a href="javascript:;" data-arno='+arno+' class="beneficial_list_item displayDtl"><dl><dt>'+jyohodt+'</dt><dd><div class="oshirasewidht titleOverflow">'+title+'</div></dd></dl></a>' );
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