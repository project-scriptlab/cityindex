$(document).ready(function(){
	"use strict";

	//on change dropdown set filter investment list
	$('#select2InvestmentFilter').on('select2:select', function (e) {
		var data = e.params.data;
		window.location.href = site_url+'users/investment-list/'+data.id;
	});

	$('#select2StartInvestment').on('select2:select', function (e) {
		e.preventDefault();
		var data = e.params.data;
		$.ajax({
			type: 'POST',
			url: site_url+'users/ajax-get-user-by-id/'+data.id,
			data: { csrf_token_name: $("[name='csrf_token_name']").val()},
			dataType: "json",
			success: function (data) {
				if (data.success) {
					$('#form_investment').attr('action', site_url+'users/add-new-investment/'+data['details'].id);
					$("[name='csrf_token_name']").val(data.hash);
					$("[name='account_number']").val(data['details'].account_number);					
					$("[name='commission']").val(data['introducer'].introducer_commission);						
					$("[name='introducer']").val(data['details'].introducer_id);					
				} else {
					$("[name='csrf_token_name']").val(data.hash);
					error(data.message);
				}
			}
		});
	});
});