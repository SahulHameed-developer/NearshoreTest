$(document).ready(function() {
	$("#dlcatename").change(function()
    {
    	var id = $("#dlcatename option:selected").text();
        $('#categoryname_edit').val(id);
    });
	$('#dlcatenmselectbox').hide();
	$('#categorynametextbox').show();
	$('#category_editdl').hide();
	$('.reg').show();
	$('.upd').hide();
	$('.delete').hide();
	var clicks = new Array();
	clicks[0] = 1;
	$('input[type=radio][name=category]').change(function() {
		clicks.push($(this).val());
		$('#hiddenradio_previous').val(clicks[clicks.length-2]);
		var selectedVal = this.value;
		if(selectedVal == $("#hdnCATEGORY_ADD").val()) {
			$.confirm({
			title: '',
			content: '入力内容がクリアされますが、<br>よろしいですか？',
			type: 'blue',
				buttons: {
					OK: {
						action: function() {
						sendAjaxRequest();
						$('[id$=categorycombo]').text("カテゴリー");
       					$('#categoryname_edit').val("");
						$("#koukaikbn_r1").attr('checked', 'checked');
						$('#dlcatenmselectbox').hide();
						$('#categorynametextbox').show();
						$('#category_editdl').hide();
						$('.reg').show();
						$('.upd').hide();
						$('.delete').hide();
						$("#hyojino").val("");
						$('input[name="koukaikbn"]').removeAttr('disabled');
						$('#hyojino').attr('disabled',false);
						var validator = $( "#categoryedit" ).validate();
						validator.resetForm();
						}
					},
					キャンセル: function () {
						// 会員区分「会員 」の場合
						var radchk = $('#hiddenradio_previous').val();
						$("#cat_"+radchk).prop('checked', true);
						clicks.pop(radchk);
					}
				}
			});
		} else if (selectedVal == $("#hdnCATEGORY_UPD").val()) {
			$.confirm({
			title: '',
			content: '入力内容がクリアされますが、<br>よろしいですか？',
			type: 'blue',
				buttons: {
					OK: {
						action: function() {
							sendAjaxRequest();
							$('[id$=categorycombo]').text("カテゴリーコンボ");
							$('#categorynametextbox').hide();
							$('#dlcatenmselectbox').show();
							$('#category_editdl').show();
							$('.reg').hide();
							$('.upd').show();
							$('.delete').hide();
							$('input[name="koukaikbn"]').removeAttr('disabled');
							$('#hyojino').attr('disabled', false);
							$('#dlcatename').val('');
							$("#koukaikbn_r1").attr('checked', 'checked');
							$('#hyojino').val('');
							var validator = $( "#categoryedit" ).validate();
							validator.resetForm();
						}
					},
					キャンセル: function () {
						// 会員区分「会員 」の場合
						var radchk = $('#hiddenradio_previous').val();
						$("#cat_"+radchk).prop('checked', true);
						clicks.pop(radchk);
					}
				}
			});
		} else if (selectedVal == $("#hdnCATEGORY_DEL").val()) {
			$.confirm({
			title: '',
			content: '入力内容がクリアされますが、<br>よろしいですか？',
			type: 'blue',
				buttons: {
					OK: {
						action: function() {
						sendAjaxRequest();
						$('[id$=categorycombo]').text("カテゴリーコンボ");
       					$('#categoryname_edit').val("");
						$(".hyojino").html("");
						$("#hyojino").val("");
						$("#categoryname").val("");
						$('#categorynametextbox').hide();
						$('#category_editdl').hide();
						$('#dlcatenmselectbox').show();
						$('.reg').hide();
						$('.upd').hide();
						$('.delete').show();
						$("#koukaikbn_r1").attr('checked', 'checked');
						$('input[name="koukaikbn"]').attr('disabled', 'disabled');
				    	$("#hyojino").attr('disabled', 'disabled');
				    	var validator = $( "#categoryedit" ).validate();
						$("#hyojino").removeClass('error');
						validator.resetForm();
							}
					},
					キャンセル: function () {
						// 会員区分「会員 」の場合
						var radchk = $('#hiddenradio_previous').val();
						$("#cat_"+radchk).prop('checked', true);
						clicks.pop(radchk);
					}
				}
			});
		}
	});
	$('#dlcatename').change(function() {
		var arno = $("#dlcatename").val();
		var return_first = function () {
		    var tmp = null;
				$.ajax({
					url    : 'getRegData',
					type   : 'POST',
					datatype : 'JSON',
					data   : {'arno': arno },
					async: false,
					success : function(data){
    					data = JSON.parse(data);
		     			var hyojino = JSON.stringify(data['MDlcate']['hyojino']).replace(/\"/g, "");
		     			var koukaikbn = JSON.stringify(data['MDlcate']['koukaikbn']).replace(/\"/g, "");
						$("#hyojino").val(hyojino);
						$("input[name=koukaikbn][value=" + koukaikbn + "]").attr('checked', 'checked');
					},
					error : function(errorData){
						alert(errorData.status);
					}
				});
			}();

	});
	$(".b-release").click(function(){
		$('#categoryedit').submit();
	});
	$('.backpage_head').click(function() {
		$.confirm({
			title: '',
			content: BACK_PAGE,
			type: 'blue',
			buttons: {
				OK: {
					action: function() {
						$('#homepageForm').submit();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
});

jQuery.validator.addMethod("numbersOnly", function(value, element) {
	return this.optional(element) || value.match(/^[0-9]*$/);
});
jQuery.validator.addMethod("notzero", function(value, element) {
	if( value != 0 ) { return true; } else { return false; }
});
function sendAjaxRequest() {
	$.ajax({
		url    : 'getdlcatenm',
		type   : 'POST',
		datatype : 'JSON',
		async: false,
		success : function(data) {
	    	data = JSON.parse(data);
	    	jQuery('#dlcatename').val('');
	     	jQuery('#dlcatename').text('');
	     	$('#dlcatename').append( '<option value="">選択してください</option>' );
	     	$.each(data , function( i, val) {
	     		var fields = val.split('##');
	    		$("#dlcatename").append('<option value="'+fields[0]+'">'+fields[1]+'</option>');
	    	});
		},
	 error : function(errorData) {
		 alert(errorData.status);
	 }
	});
}
(function($,W,D)
{
	var jqueryValidation = {};
	jqueryValidation.UTIL =
	{
		setupFormValidation: function()
		{
			// 入会申込フォーム確認
			$("#categoryedit").validate({
				onkeyup: false,
				rules: {
					dlcatename: "required",
					categoryname: {
						required:true,
						maxlength: 30
					},
					categoryname_edit: {
						required:true,
						maxlength: 30
					},
					hyojino: {
						required:true,
						numbersOnly:true,
						notzero:true,
                		maxlength: 3
					}
				},
				messages: {
					dlcatename: "カテゴリーを選択してください。",
					categoryname: { 
						required:"カテゴリー名を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					categoryname_edit: { 
						required:"カテゴリー名を入力してください。",
						maxlength: "最大文字数を超えています。"
					},
					hyojino: {
						required:"表示順を入力してください。",
						numbersOnly:"数値を入力してください。",
						notzero:"有効な表示順を入力してください。",
                		maxlength: "最大文字数を超えています。"
					}
				},
				submitHandler: function(form) {
					var check = 0;
					if($('input[name=category]:checked').val() == $("#hdnCATEGORY_ADD").val()) {
						var CONFIRM_MSG = INSERT_CONFIRM;
						var SUCCESS_MSG = INSERT_SUCCESS;
						var FAILURE_MSG = INSERT_FAILURE;
						var PAGELOAD = 'registercls';
					} else if ($('input[name=category]:checked').val() == $("#hdnCATEGORY_UPD").val()) {
						var CONFIRM_MSG = UPDATE_CONFIRM;
						var SUCCESS_MSG = UPDATE_SUCCESS;
						var FAILURE_MSG = UPDATE_FAILURE;
						var PAGELOAD = 'updatecls';
					} else if ($('input[name=category]:checked').val() == $("#hdnCATEGORY_DEL").val()) {
						var CONFIRM_MSG = DELETE_CONFIRM;
						var SUCCESS_MSG = DELETE_SUCCESS;
						var FAILURE_MSG = DELETE_FAILURE;
						var PAGELOAD = 'deletecls';
					}
					if(PAGELOAD == 'deletecls'){
						var arno = $("#dlcatename").val();
						$.ajax({
					        url: '../AdminDLCategory/deleteCategorycheck',
					        type: 'POST',
					        dataType: 'JSON',
					        data   : {'arno': arno},
					        async: false,
					        success:function(data){
					        	if(data == 1){
					        		check = 1;
					        		$.confirm({
					        			title: '',
										content: '対応カテゴリーはすでに使用中ですので<br>削除できません。',
										type: 'blue',
										keys: ['enter'],
					        			buttons: {
					        				OK: {
					        					action: function(){
					        						
					        					}
					        				}
					        			}
					        		});
					        	} else {
					        		check = 0;
					        	}
					        },
					         error : function(errorData){
	    	 					 alert(errorData.status);
	      					} 
					     });
					}	
					if(check == 0){
						$.confirm({
							title: '',
							content: CONFIRM_MSG,
							type: 'blue',
							buttons: {
								OK: {
									action: function(){
										$("#pageloadcls").addClass(PAGELOAD);
										$('#hyojino').attr('disabled', false);
										var data = new FormData();
										var serializedData = $("#categoryedit").serialize();
										serializedData = decodeURIComponent(serializedData);
										data.append('otherFields', serializedData);
										var xhr = new XMLHttpRequest();
									 	xhr.open('POST', 'register', true);
									 	xhr.send(data);
									 	xhr.onload = function () {
									    	$("#pageloadcls").removeClass(PAGELOAD);
									    	if(xhr.responseText == "1") {
									    		if (xhr.status === 200) {
										 			$.confirm({
														title: '',
														content: SUCCESS_MSG,
														type: 'blue',
														buttons: {
															OK: {
																btnClass: 'btn-blue',
																keys: ['enter'],
																action: function(){
																	$('#homepageForm').submit();
																}
															}
														}
													});
												}else{
													window.location="../Error/systemError";
												}
											} else if (xhr.responseText == "SYSTEM_ERROR" || xhr.status != 200 ){
												window.location="../Error/systemError";
											}else {
												$.confirm({
														title: '',
														content: FAILURE_MSG,
														type: 'blue',
														buttons: {
															OK: {
																btnClass: 'btn-blue',
																keys: ['enter']
															}
														}
													});
												var allErrArr = xhr.responseText.split("$$");
										 		var focusArea ="";
										 		$(".dlcatename").html("");
												$(".categoryname").html("");
												$(".hyojino").html("");
										 		allErrArr.forEach(function(errArr) {
										 			var err = errArr.split("##");
										 			focusArea = err[0];
										 			if(err[0] == "dlcatenm" && $('input[name=category]:checked').val() == $("#hdnCATEGORY_ADD").val()) {
												 		$(".categoryname").html(err[1]);
										 			} else if(err[0] == "dlcatenm" && $('input[name=category]:checked').val() != $("#hdnCATEGORY_ADD").val()) {
												 		$(".dlcatename").html(err[1]);
										 			} else {
												 		$("."+err[0]).html(err[1]);
										 			}
										 		});
										 		$("#"+focusArea).focus();
										 		$('.b-release').prop('disabled', false);
											}	
										};
									}
								},
								キャンセル: function () {
								}
							}
						});
					}	
				}
			});
		}
	}
	$(D).ready(function($) {
		jqueryValidation.UTIL.setupFormValidation();
	});
})(jQuery, window, document);