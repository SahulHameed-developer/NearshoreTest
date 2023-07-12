$(document).ready(function() {
	//更新日
	$('input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
	if($("#mailidarr").val() != "") {
		var arr = ($("#mailidarr").val()).split(',');
		for (var i = 0; i < arr.length; i++) {
			$("#choice"+arr[i]).prop( "checked", true );
		}
	}
	$(".backtohome").click(function () {
		if($( "#count" ).val() > 0) {
			$.confirm({
				title: '',
				content: BACK_PAGE,
				type: 'blue',
				buttons: {
					OK: {
						action: function(){
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
	$(".b-search").click(function () {
		$("#selectedOrder").val('');
	});
	$(".datepicker").datepicker();
	$('.b-sendregister').click(function(){
	    var final = '';
	    $('.s_checkbox:checked').each(function(){        
	        var values = $(this).val();
	        final += values+',';
	    });
	    final = final.slice(0, -1);
	    $("#mailidarr").val(final);
	    if(final == "") {
	    	$.confirm({
				title: '',
				content: '登録情報の送信対象が選択されていません。',
				type: 'blue',
				boxWidth: '320px',
    			useBootstrap: false,
				buttons: {
					OK: {
						btnClass: 'btn-blue',
						keys: ['enter'],
						action: function(){	}
					}
				}
			});
	    } else {
	    	$.confirm({
				title: '',
				content: '登録情報の通知メール送信してもよろしいですか。',
				type: 'blue',
				boxWidth: '370px',
   	 			useBootstrap: false,
				buttons: {
					OK: {
						action: function(){
							$("#mailsendtext").addClass('mailsendtext');
					    	var request;
					        var $inputs = $("#sendmail").find("input");
					        var serializedData = $("#sendmail").serialize();
					        $('.b-sendregister').prop("disabled", true);
					        $('.b-search').prop("disabled", true);
					        $('.b-edit').prop("disabled", true);
					        $inputs.prop("disabled", true);
					        request = $.ajax({
					                url: "sendmail",
					                type: "post",
					                datatype : 'JSON',
					                data: serializedData
					        });
					        request.done(function (response, textStatus, jqXHR) {
					        	$.confirm({
					    			title: '',
					    			content: '登録情報の通知メール送信しました。',
					    			type: 'blue',
					    			buttons: {
					    				OK: {
					    					btnClass: 'btn-blue',
											keys: ['enter'],
					    					action: function(){
					    						$("#membermgnt").submit();
					    						$('.b-sendregister').prop("disabled", false);
					    						$('.b-search').prop("disabled", false);
					    						$('.b-edit').prop("disabled", false);
					    						$('input:checkbox').removeAttr('checked');
					    					}
					    				}
					    			}
					    		});
					        });
					        request.fail(function (jqXHR, textStatus, errorThrown) {
					        	$.confirm({
					    			title: '',
					    			content: '登録情報の通知メール送信できませんでした。',
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
						    	$("#mailsendtext").removeClass('mailsendtext');
					            $inputs.prop("disabled", false);
					        }); 
						}
					},
					キャンセル: function () {
					}
				}
			});
	    }
	});
	jQuery.validator.addMethod(
		"dateFormat",
		function(value, element) {
			var check = false;
			var re = /^(\d{4})\/(\d{1,2})\/(\d{1,2})$/;
			if( re.test(value)){
				var adata = value.split('/');
				var yyyy = parseInt(adata[0],10);
				var mm = parseInt(adata[1],10);
				var dd = parseInt(adata[2],10);
				var xdata = new Date(yyyy,mm-1,dd);
				if ( ( xdata.getFullYear() === yyyy ) && ( xdata.getMonth () === mm - 1 ) && ( xdata.getDate() === dd ) ) {
					check = true;
				}
				else {
					check = false;
				}
			} else {
				check = false;
			}
			return this.optional(element) || check;
	});
	jQuery.validator.addMethod(
		"lessThan", 
		function(value, element, params) {
			if(value==''){
				return true;
			}else{
				var fromtime = $(params).val();
				if(fromtime > value){
					return false;
				} 
			}
			return true;
	});
	jQuery.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.appendTo('#dateFmtError');
		}
	});
});
function editprocess(kaiincd,kaisyacd) {
	var final = '';
	$('.s_checkbox:checked').each(function(){        
		var values = $(this).val();
		final += values+',';
	});
	final = final.slice(0, -1);
	$("#mailarrmm").val(final);
	$("#kaiincd" ).val(kaiincd);
	$("#kaisyacd" ).val(kaisyacd);
	$('#membermgnt').attr('action', '../adminMember/edit_2');
	$("#membermgnt").submit();
}
function checkprocess(id,uid,pass,mail) {
	if(id == "" || pass == "" || mail == "" ) {
		$.confirm({
			title: '',
			content: 'ログインＩＤ、パスワード、メールアドレスの<br>何れかが未設定です。',
			type: 'blue',
			boxWidth: '340px',
   	 		useBootstrap: false,
			buttons: {
				OK: {
					btnClass: 'btn-blue',
					keys: ['enter'],
					action: function(){
						
					}
				}
			}
		});
		$('#choice'+id).attr('checked', false);
	}
}
//入力値の検証
(function($,W,D) {
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#membermgnt").validate({
				rules: {
					// 期間（From）
					fromdate:{
						dateFormat:true},
					// 期間（To）
					todate: {
						dateFormat:true,
						lessThan: '[name="fromdate"]'}
				},
				messages: {
					//期間（From）のエラーメッセージ。
					fromdate: "正しい年月を入力してください。",
					// 期間（To）のエラーメッセージ。
					todate: { 
						dateFormat:"正しい年月を入力してください。",
						lessThan:"期間のFrom、Toを正しく入力してください。"
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		}
	}
	$(D).ready(function($) {
		jqueryValidation.UTIL.setupFormValidation();
	});
})(jQuery, window, document);