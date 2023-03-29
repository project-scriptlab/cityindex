$(document).ready(function(){
	"use strict";

	$(document).on('blur', '#name', function(e) {
		e.preventDefault();
		let parent = jQuery(this);
		if (parent.val() != '') {
			$.ajax({
				type: 'POST',
				url: site_url+'users/generateUniqueUserName',
				data: { 
					'name': parent.val(), 
					csrf_token_name: $("[name='csrf_token_name']").val(),
				},
				success: function (data) {
					var JsonObject= JSON.parse(data);
					if (JsonObject.success) {
						$("[name='csrf_token_name']").val(JsonObject.hash);
						$("#username").val(JsonObject.username);
						$('.submit').attr("disabled", false);
					} else {
						error(JsonObject.message);
					}
				}
			},'json');
		}else{
			return false;
		}
	});

	var randomstring = Math.random().toString(36).slice(-8);
	$('#password, #confirm_pwd').val(randomstring);
});