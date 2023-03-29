$(document).ready(function(){
	"use strict";

	$(document).on('click','.search-value', function(e) {
		e.preventDefault();
		var val = $('#investment_id').val();	
		if (val) {
			$.ajax({
				type: 'POST',
				url: site_url+'payout/ajax-get-data-by-investment-id',
				data: { 
					'id': val, 
					csrf_token_name: $("[name='csrf_token_name']").val(),
				},
				success: function (data) {
					var JsonObject= JSON.parse(data);
					if (JsonObject.success) {
						$("[name='total_amount']").val(JsonObject.details['updated_investment_amount']);
						$("#investorName").val(JsonObject.details['name']+' ('+JsonObject.details['member_id']+')');
						$("[name='withdraw_amount']").attr("readonly", false); 

						$("[name='csrf_token_name']").val(JsonObject.hash);
					} else {
						error(JsonObject.message);
						$("[name='csrf_token_name']").val(JsonObject.hash);
						$("[name='total_amount']").val(''); 
						$("#investorName").val('');
						$("[name='withdraw_amount']").attr("readonly", true).val(''); 
						$("[name='remaining_amount']").val(''); 
						$('.btnWithdraw').attr("disabled", true);
					}
				}
			},'json');
		} else {
			$("#investorName").val('');
			$("[name='total_amount']").val(''); 
			$("[name='withdraw_amount']").attr("readonly", true).val(''); 
			$("[name='remaining_amount']").val(''); 
			$('.btnWithdraw').attr("disabled", true);
		} 
		
	});


	$(document).on('keyup ',"[name='withdraw_amount']", function(e){
		e.preventDefault();
		var amount = jQuery(this).val(),
		totsAmount = $("[name='total_amount']").val(),
		newAmount = totsAmount - amount;
		if (amount > 0) {
			if (newAmount >= 0) {
				$("[name='remaining_amount']").val(newAmount);
				$('.btnWithdraw').attr("disabled", false);
			}else{
				$("[name='remaining_amount']").val(0);
				$('.btnWithdraw').attr("disabled", true);
				error("Withdraw amount can't be greater than available amount");
			}
		}else{
			$("[name='remaining_amount']").val(totsAmount);
			$('.btnWithdraw').attr("disabled", true);
		}
	});
});