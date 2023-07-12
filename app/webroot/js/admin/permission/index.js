$(document).ready(function() {
	// 一覧に戻る
	$(".returnList").click(function(){
		if($( "#count" ).val() > 0) {
			$.confirm({
				title: '',
				content: BACK_PAGE,
				type: 'blue',
				buttons: {
					OK: {
						action: function(){
							$( "#listModoruFrm" ).submit();
						}
					},
					キャンセル: function () {
					}
				}
			});
		} else {
			$( "#listModoruFrm" ).submit();
		}
	});
	$(".buttonsearch").click(function () {
		$("#selectedOrder").val('');
	});
	$(".b-sendregister").click(function () {
		var kcaltouroku_val = '';
	    $('.kcaltouroku_checkbox:checked').each(function(){     
	        var kcaltouroku_values = $(this).val();
	        kcaltouroku_val += kcaltouroku_values+',';
	    });
	    kcaltouroku_val = kcaltouroku_val.slice(0, -1);
	    var kcaltouroku_ncval = '';
	    $('.kcaltouroku_checkbox:unchecked').each(function(){     
	        var kcaltouroku_ncvalues = $(this).val();
	        kcaltouroku_ncval += kcaltouroku_ncvalues+',';
	    });
	    kcaltouroku_ncval = kcaltouroku_ncval.slice(0, -1);
	    var kcalkoukai_val = '';
	    $('.kcalkoukai_checkbox:checked').each(function(){     
	        var kcalkoukai_values = $(this).val();
	        kcalkoukai_val += kcalkoukai_values+',';
	    });
	    kcalkoukai_val = kcalkoukai_val.slice(0, -1);
	    var kcalkoukai_ncval = '';
	    $('.kcalkoukai_checkbox:unchecked').each(function(){     
	        var kcalkoukai_ncvalues = $(this).val();
	        kcalkoukai_ncval += kcalkoukai_ncvalues+',';
	    });
	    kcalkoukai_ncval = kcalkoukai_ncval.slice(0, -1);
	    var khoutouroku_val = '';
	    $('.khoutouroku_checkbox:checked').each(function(){     
	        var khoutouroku_values = $(this).val();
	        khoutouroku_val += khoutouroku_values+',';
	    });
	    khoutouroku_val = khoutouroku_val.slice(0, -1);
	    var khoutouroku_ncval = '';
	    $('.khoutouroku_checkbox:unchecked').each(function(){     
	        var khoutouroku_ncvalues = $(this).val();
	        khoutouroku_ncval += khoutouroku_ncvalues+',';
	    });
	    khoutouroku_ncval = khoutouroku_ncval.slice(0, -1);
	    var khoukoukai_val = '';
	    $('.khoukoukai_checkbox:checked').each(function(){     
	        var khoukoukai_values = $(this).val();
	        khoukoukai_val += khoukoukai_values+',';
	    });
	    khoukoukai_val = khoukoukai_val.slice(0, -1);
	    var khoukoukai_ncval = '';
	    $('.khoukoukai_checkbox:unchecked').each(function(){     
	        var khoukoukai_ncvalues = $(this).val();
	        khoukoukai_ncval += khoukoukai_ncvalues+',';
	    });
	    khoukoukai_ncval = khoukoukai_ncval.slice(0, -1);
	    var osirasetouroku_val = '';
	    $('.osirasetouroku_checkbox:checked').each(function(){     
	        var osirasetouroku_values = $(this).val();
	        osirasetouroku_val += osirasetouroku_values+',';
	    });
	    osirasetouroku_val = osirasetouroku_val.slice(0, -1);
	    var osirasetouroku_ncval = '';
	    $('.osirasetouroku_checkbox:unchecked').each(function(){     
	        var osirasetouroku_ncvalues = $(this).val();
	        osirasetouroku_ncval += osirasetouroku_ncvalues+',';
	    });
	    osirasetouroku_ncval = osirasetouroku_ncval.slice(0, -1);
	    var osirasekoukai_val = '';
	    $('.osirasekoukai_checkbox:checked').each(function(){     
	        var osirasekoukai_values = $(this).val();
	        osirasekoukai_val += osirasekoukai_values+',';
	    });
	    osirasekoukai_val = osirasekoukai_val.slice(0, -1);
	    var osirasekoukai_ncval = '';
	    $('.osirasekoukai_checkbox:unchecked').each(function(){     
	        var osirasekoukai_ncvalues = $(this).val();
	        osirasekoukai_ncval += osirasekoukai_ncvalues+',';
	    });
	    osirasekoukai_ncval = osirasekoukai_ncval.slice(0, -1);
	    var yuekitouroku_val = '';
	    $('.yuekitouroku_checkbox:checked').each(function(){     
	        var yuekitouroku_values = $(this).val();
	        yuekitouroku_val += yuekitouroku_values+',';
	    });
	    yuekitouroku_val = yuekitouroku_val.slice(0, -1);
	    var yuekitouroku_ncval = '';
	    $('.yuekitouroku_checkbox:unchecked').each(function(){     
	        var yuekitouroku_ncvalues = $(this).val();
	        yuekitouroku_ncval += yuekitouroku_ncvalues+',';
	    });
	    yuekitouroku_ncval = yuekitouroku_ncval.slice(0, -1);
	    var yuekikoukai_val = '';
	    $('.yuekikoukai_checkbox:checked').each(function(){     
	        var yuekikoukai_values = $(this).val();
	        yuekikoukai_val += yuekikoukai_values+',';
	    });
	    yuekikoukai_val = yuekikoukai_val.slice(0, -1);
	    var yuekikoukai_ncval = '';
	    $('.yuekikoukai_checkbox:unchecked').each(function(){     
	        var yuekikoukai_ncvalues = $(this).val();
	        yuekikoukai_ncval += yuekikoukai_ncvalues+',';
	    });
	    yuekikoukai_ncval = yuekikoukai_ncval.slice(0, -1);
	    var syukketusansyo_val = '';
	    $('.syukketusansyo_checkbox:checked').each(function(){     
	        var syukketusansyo_values = $(this).val();
	        syukketusansyo_val += syukketusansyo_values+',';
	    });
	    syukketusansyo_val = syukketusansyo_val.slice(0, -1);
	    var syukketusansyo_ncval = '';
	    $('.syukketusansyo_checkbox:unchecked').each(function(){     
	        var syukketusansyo_ncvalues = $(this).val();
	        syukketusansyo_ncval += syukketusansyo_ncvalues+',';
	    });
	    syukketusansyo_ncval = syukketusansyo_ncval.slice(0, -1);
	    $("#kcaltouroku_val").val(kcaltouroku_val);
	    $("#kcaltouroku_ncval").val(kcaltouroku_ncval);
	    $("#kcalkoukai_val").val(kcalkoukai_val);
	    $("#kcalkoukai_ncval").val(kcalkoukai_ncval);
	    $("#khoutouroku_val").val(khoutouroku_val);
	    $("#khoutouroku_ncval").val(khoutouroku_ncval);
	    $("#khoukoukai_val").val(khoukoukai_val);
	    $("#khoukoukai_ncval").val(khoukoukai_ncval);
	    $("#osirasetouroku_val").val(osirasetouroku_val);
	    $("#osirasetouroku_ncval").val(osirasetouroku_ncval);
	    $("#osirasekoukai_val").val(osirasekoukai_val);
	    $("#osirasekoukai_ncval").val(osirasekoukai_ncval);
	    $("#yuekitouroku_val").val(yuekitouroku_val);
	    $("#yuekitouroku_ncval").val(yuekitouroku_ncval);
	    $("#yuekikoukai_val").val(yuekikoukai_val);
	    $("#yuekikoukai_ncval").val(yuekikoukai_ncval);
	    $("#syukketusansyo_val").val(syukketusansyo_val);
	    $("#syukketusansyo_ncval").val(syukketusansyo_ncval);
	    $.confirm({
			title: '',
			content: '登録・更新してもよろしいですか。',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
					    $("#upregtext").addClass('upregtext');
					    var request;
				        var $inputs = $("#index").find("input");
				        var serializedData = $("#index").serialize();
				        $('.buttonsearch').prop("disabled", true);
				        $inputs.prop("disabled", true);
				        request = $.ajax({
				            url: "regupdate",
				            type: "post",
				            datatype : 'JSON',
				            data: serializedData
				        });
				        request.done(function (response, textStatus, jqXHR) {
				        	$.confirm({
				    			title: '',
				    			content: INSERT_SUCCESS,
				    			type: 'blue',
				    			buttons: {
				    				OK: {
				    					btnClass: 'btn-blue',
										keys: ['enter'],
				    					action: function(){
				    						$('.buttonsearch').prop("disabled", false);
				    						$inputs.prop("disabled", false);
				    					}
				    				}
				    			}
				    		});
				        });
				        request.fail(function (jqXHR, textStatus, errorThrown) {
				        	$.confirm({
				    			title: '',
				    			content: INSERT_FAILURE,
				    			type: 'blue',
				    			buttons: {
				    				OK: {
				    					btnClass: 'btn-blue',
										keys: ['enter']
				    				}
				    			}
				    		});
				        });
				        request.always(function () {
						    $("#upregtext").removeClass('upregtext');
				            $inputs.prop("disabled", false);
				        });
			        }
				},
				キャンセル: function () {
				}
			}
		});
	});
});