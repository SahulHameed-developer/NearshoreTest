$(document).ready(function() {	
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
	$("#katsudo2").click(function () {
		$(".freeword-search .searchcontrol .searchcontrolcheckbox li label").css("cursor", "pointer");
		$(".freeword-search .searchcontrol .searchcontrolcheckbox label").addClass('active cursorpointer');
		$('.check').prop('disabled', false);
	});
	$("#katsudo1").click(function () {
		$(".freeword-search .searchcontrol .searchcontrolcheckbox li label").css("cursor", "default");
		$(".freeword-search .searchcontrol .searchcontrolcheckbox label").removeClass('active cursorpointer');
		$('.check').prop('checked', false);
		$('.check').prop('disabled', true);
	});
	$(".b-search").click(function () {
		$("#narabijun").val('3');
		$('#AdminAttendanceKaigi').submit();
	});
	$("#narabijun").change(function () {
		$('#AdminAttendanceKaigi').submit();
	});
	jQuery.validator.addMethod(
			"dateFormat",
			function(value, element) {
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
						}
						else {
							check = false;
						}
					} else {
						check = false;
					}
					return this.optional(element) || check;
	});
	jQuery.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.appendTo('#dateFmtError');
		}
	});
});