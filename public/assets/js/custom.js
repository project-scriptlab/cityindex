$(document).ready(function(){
	"use strict";
	

	$(document).on('click','.submit', function(e){
		e.preventDefault();
		let parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($(".formSubmit")[0]);
		if($("#bubble-editor").length == 1) {
			var bubble = quill.container.firstChild.innerHTML;
			formData.append("rm_discussion_points", bubble);
		}
		
		$.ajax({
			url: $('.formSubmit').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					$('.formSubmit').trigger("reset");
					success(JsonObject.message);
					parent.removeClass('btn-progress').attr("disabled", false);
				} else {
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
					parent.removeClass('btn-progress').attr("disabled", false);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	})

	$('#select2introducer').on('select2:select', function (e) {
		var data = e.params.data;
		$.ajax({
			type: 'POST',
			url: site_url+'users/ajax-get-user-by-id/'+data.id,
			data: { csrf_token_name: $("[name='csrf_token_name']").val()},
			dataType: "json",
			success: function (data) {
				if (data.success) {
					$("[name='csrf_token_name']").val(data.hash);
					$("[name='introducer_commission']").val(data['details'].introducer_commission);			
				} else {
					$("[name='csrf_token_name']").val(data.hash);
					error(data.message);
				}
			}
		});
	});


	$(document).on('click','.btn-add-investment', function(e){
		e.preventDefault();
		let parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		$(this).find(".btn-add-investment").prop('disabled',true);
		const formData = new FormData($("#form_investment")[0]);		
		$.ajax({
			url: $('#form_investment').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				$(this).find(".btn-add-investment").prop('disabled',false);
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					$('.formSubmit').trigger("reset");
					success(JsonObject.message);
					$('#new-investment').modal('hide');
					parent.removeClass('btn-progress').attr("disabled", false);
				} else {
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
					parent.removeClass('btn-progress').attr("disabled", false);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});


	$(document).on('click','.btn-new-admin', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($("#form-add-admin")[0]);		
		$.ajax({
			url: $('#form-add-admin').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					parent.removeClass('btn-progress').attr("disabled", false);
					$('#form-add-admin').trigger("reset");
					success(JsonObject.message);
					$('#modalAddNewAdmin').modal('hide');
					
				} else {
					parent.removeClass('btn-progress').attr("disabled", false);
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});

	$('.edit-admin').on('click', function (e) {
		e.preventDefault();
		let save_button = $(this);
		save_button.addClass('btn-progress');
		$.ajax({
			type: 'POST',
			url: site_url+'users/ajax-get-user-by-id/'+save_button.attr('data-id'),
			data: { csrf_token_name: $("[name='csrf_token_name']").val()},
			dataType: "json",
			success: function (data) {
				if (data.success) {
					$("[name='csrf_token_name']").val(data.hash);
					$('#form-edit-admin').attr('action', site_url+'users/update-admin/'+data['details'].id)
					$("#name").val(data['details'].name);
					$("#email").val(data['details'].email);
					$("#username").val(data['details'].user_name);
					$("#mobile").val(data['details'].mobile);
					$('#modalEditAdmin').modal('show');
					save_button.removeClass('btn-progress');					
				} else {
					$("[name='csrf_token_name']").val(data.hash);
					error(data.message);
					save_button.removeClass('btn-progress');
				}
			}
		});
	});

	$(document).on('click','.btn-update-admin', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($("#form-edit-admin")[0]);		
		$.ajax({
			url: $('#form-edit-admin').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					parent.removeClass('btn-progress').attr("disabled", false);
					success(JsonObject.message);
					$('#modalEditAdmin').modal('hide');
					
				} else {
					parent.removeClass('btn-progress').attr("disabled", false);
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});

	$(document).on('click', '.delete-user', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress');
		$.confirm({
			title: 'Confirm!',
			content: "Are you sure? If you delete, this user won't be able to login again.",
			icon: 'fa fa-warning',
			type: 'red',
			buttons: {
				omg: {
					text: 'Confirm',
					btnClass: 'btn-red',
					action: function () {
						$.ajax({
							type: 'POST',
							url: site_url+'users/delete-user-by-id',
							data: { 
								'id': parent.attr('data-delete'), 
								csrf_token_name: $("[name='csrf_token_name']").val(),
							},
							success: function (data) {
								parent.removeClass('btn-progress');
								var JsonObject= JSON.parse(data);
								if (JsonObject.success) {
									success(JsonObject.message);
								} else {
									error(JsonObject.message);
									$("[name='csrf_token_name']").val(JsonObject.hash);
								}
							}
						},'json');
					}
				},
				close: function(){
					parent.removeClass('btn-progress');
				}
			}
		});
	});

	$(document).on('click','.btn-new-rm', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($("#form-add-rm")[0]);		
		$.ajax({
			url: $('#form-add-rm').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					parent.removeClass('btn-progress').attr("disabled", false);
					$('#form-add-rm').trigger("reset");
					success(JsonObject.message);
					$('#modalAddNewRm').modal('hide');
					
				} else {
					parent.removeClass('btn-progress').attr("disabled", false);
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});

	$('.edit-rm').on('click', function (e) {
		e.preventDefault();
		let save_button = $(this);
		save_button.addClass('btn-progress');
		$.ajax({
			type: 'POST',
			url: site_url+'users/ajax-get-rm-by-id/'+save_button.attr('data-id'),
			data: { csrf_token_name: $("[name='csrf_token_name']").val()},
			dataType: "json",
			success: function (data) {
				if (data.success) {
					$("[name='csrf_token_name']").val(data.hash);
					$('#form-edit-rm').attr('action', site_url+'users/update-rm/'+data['details'].id)
					$("#name").val(data['details'].name);
					$("#email").val(data['details'].email);
					$("#mobile").val(data['details'].phone);
					$('#modalEditRm').modal('show');
					save_button.removeClass('btn-progress');					
				} else {
					$("[name='csrf_token_name']").val(data.hash);
					error(data.message);
					save_button.removeClass('btn-progress');
				}
			}
		});
	});

	$(document).on('click','.btn-update-rm', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($("#form-edit-rm")[0]);		
		$.ajax({
			url: $('#form-edit-rm').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					parent.removeClass('btn-progress').attr("disabled", false);
					success(JsonObject.message);
					$('#modalEditRm').modal('hide');
					
				} else {
					parent.removeClass('btn-progress').attr("disabled", false);
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	})


	$(document).on('click', '.change-password', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		$('#form-change-password').attr('action', site_url+'users/change-password/'+parent.attr('data-delete'));
		$('#change-password-modal').modal('show');
	});


	$(document).on('click','.btn-change-password', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($("#form-change-password")[0]);
		$.confirm({
			title: 'Confirm!',
			content: "Are you sure? You want to reset password for this user.",
			icon: 'fa fa-warning',
			type: 'dark',
			buttons: {
				omg: {
					text: 'Yes',
					btnClass: 'btn-dark',
					action: function () {
						$.ajax({
							url: $('#form-change-password').attr('action'),
							type: 'POST',
							data: formData,
							async: false,
							success: function (data) {
								var JsonObject= JSON.parse(data);
								if (JsonObject.success) {
									parent.removeClass('btn-progress').attr("disabled", false);
									success(JsonObject.message);
									$('#change-password-modal').modal('hide');
									
								} else {
									parent.removeClass('btn-progress').attr("disabled", false);
									error(JsonObject.message);
									$("[name='csrf_token_name']").val(JsonObject.hash);
								}
							},
							cache: false,
							contentType: false,
							processData: false
						});
					}
				},
				No: function(){
					parent.removeClass('btn-progress').attr("disabled", false);
					$('#change-password-modal').modal('hide');
				}
			}
		});		
	});

	$(document).on('keyup','.search-member',function(e) {
		e.preventDefault();
		if (event.keyCode === 13) {
			var val = $(this).val();
			if (val) {
				window.location.href = site_url+"users/details/"+val;
			} else {
				return false;
			} 
		}
	});

	$(document).on('click','#search-member',function(e) {
		e.preventDefault();      
		var val = $('.search-member').val();
		if (val) {
			window.location.href = site_url+"users/details/"+val;
		} else {
			return false;
		} 
	});


	$(document).on('click','.upload-investor-docs', function(e){
		e.preventDefault();
		var parent = jQuery(this),
		fileEmpty = false,
		titleEmpty = false;
		$('input[type=file]').each(function () {
			if (!$(this).val()) {
				fileEmpty =  true;
				return false;
			}else{
				fileEmpty =  false;
			};
		});
		$('.document_title').each(function () {
			if (!$(this).val()) {
				titleEmpty =  true;
				return false;
			}else{
				titleEmpty =  false;
			};
		});
		if (fileEmpty || titleEmpty) {
			if (fileEmpty) {
				error('Kindly select file.');
			}else if(titleEmpty){
				error('Kindly enter file title.');
			}
		}else{
			parent.addClass('btn-progress').attr("disabled", true);
			const formData = new FormData($("#formInvestorDocuments")[0]);
			$.ajax({
				url: $('#formInvestorDocuments').attr('action'),
				type: 'POST',
				data: formData,
				async: false,
				success: function (data) {
					var JsonObject= JSON.parse(data);
					if (JsonObject.success) {
						parent.removeClass('btn-progress').attr("disabled", false);
						success(JsonObject.message);					
					} else {
						parent.removeClass('btn-progress').attr("disabled", false);
						error(JsonObject.message);
						$("[name='csrf_token_name']").val(JsonObject.hash);
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
	});

	$(document).on('click', '.delete-doc', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress');
		$.confirm({
			title: 'Confirm!',
			content: "Are you sure? You want to delete this document",
			icon: 'fa fa-warning',
			type: 'red',
			buttons: {
				omg: {
					text: 'Confirm',
					btnClass: 'btn-red',
					action: function () {
						$.ajax({
							type: 'POST',
							url: site_url+'users/delete-doc',
							data: { 
								'id': parent.attr('data-delete'), 
								csrf_token_name: $("[name='csrf_token_name']").val(),
							},
							success: function (data) {
								parent.removeClass('btn-progress');
								var JsonObject= JSON.parse(data);
								if (JsonObject.success) {
									success(JsonObject.message);
								} else {
									error(JsonObject.message);
									$("[name='csrf_token_name']").val(JsonObject.hash);
								}
							}
						},'json');
					}
				},
				close: function(){
					parent.removeClass('btn-progress');
				}
			}
		});
	});


	$(document).on('click','.manual-generate', function(e){
		e.preventDefault();
		let parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($(".formPayout")[0]);		
		$.ajax({
			url: $('.formPayout').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					$('.formPayout').trigger("reset");
					success(JsonObject.message);
					parent.removeClass('btn-progress').attr("disabled", false);
				} else {
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
					parent.removeClass('btn-progress').attr("disabled", false);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});


	$(document).on('click','.btnMonthlyPayout', function(e){
		e.preventDefault();
		let parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($(".formMonthlyPayout")[0]);		
		$.ajax({
			url: $('.formMonthlyPayout').attr('action'),
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				var JsonObject= JSON.parse(data);
				if (JsonObject.success) {
					$('.formMonthlyPayout').trigger("reset");
					success(JsonObject.message);
					parent.removeClass('btn-progress').attr("disabled", false);
				} else {
					error(JsonObject.message);
					$("[name='csrf_token_name']").val(JsonObject.hash);
					if (JsonObject.payoutReport) {
						$('.custom-title').text('Payout Details of '+JsonObject.monthName+', '+JsonObject.year);
						$('#totsCommission').html(' <i class="fa-solid fa-indian-rupee-sign"></i>'+addCommas(Math.round(JsonObject.payoutReport['total_commission'])));
						$('#totsInterest').html(' <i class="fa-solid fa-indian-rupee-sign"></i>'+addCommas(Math.round(JsonObject.payoutReport['total_interest'])));
						$('#totsPaybleInterest').html(' <i class="fa-solid fa-indian-rupee-sign"></i>'+addCommas(Math.round(JsonObject.payoutReport['payble_interest'])));
						$('#totsTds').html(' <i class="fa-solid fa-indian-rupee-sign"></i>'+addCommas(Math.round(JsonObject.payoutReport['tds_charges'])));
						$('#totsOther').html(' <i class="fa-solid fa-indian-rupee-sign"></i>'+addCommas(Math.round(JsonObject.payoutReport['other_charges'])));
						$("#check_commission").attr('href',site_url+'payout/monthly-commission/'+JsonObject.month+'/'+JsonObject.year);
						$("#check_interest").attr('href',site_url+'payout/monthly-interest/'+JsonObject.month+'/'+JsonObject.year);
						$('.existingForm').fadeIn(2000);
					}else{
						$('.existingForm').fadeOut(2000);
					}
					parent.removeClass('btn-progress').attr("disabled", false);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});


	$(document).on('click','.btnWithdraw', function(e){
		e.preventDefault();
		var parent = jQuery(this);
		parent.addClass('btn-progress').attr("disabled", true);
		const formData = new FormData($("#formWithdraw")[0]);
		$.confirm({
			title: 'Confirm!',
			content: "Are you sure? You want to withdraw amount.",
			icon: 'fa fa-warning',
			type: 'dark',
			buttons: {
				omg: {
					text: 'Yes',
					btnClass: 'btn-dark',
					action: function () {
						$("[name='investment_id'], [name='withdraw_amount']").attr("readonly", true);
						$.ajax({
							url: $('#formWithdraw').attr('action'),
							type: 'POST',
							data: formData,
							async: false,
							success: function (data) {
								var JsonObject= JSON.parse(data);
								if (JsonObject.success) {
									parent.removeClass('btn-progress').attr("disabled", false);
									success(JsonObject.message);
									
								} else {
									$("[name='investment_id'], [name='withdraw_amount']").attr("readonly", false);
									parent.removeClass('btn-progress').attr("disabled", false);
									error(JsonObject.message);
									$("[name='csrf_token_name']").val(JsonObject.hash);
								}
							},
							cache: false,
							contentType: false,
							processData: false
						});
					}
				},
				No: function(){
					parent.removeClass('btn-progress').attr("disabled", false);
				}
			}
		});		
	});

	$(document).on('click', '.withdraw-details', function(e){
		e.preventDefault();
		var parent = jQuery(this),
		id = parent.attr('data-id'),
		visible = parent.attr('data-visible');
		if (visible == 0) {
			$.ajax({
				type: 'POST',
				url: site_url+'payout/ajaxGetWithdrawlDetails/'+id,
				data: {  
					csrf_token_name: $("[name='csrf_token_name']").val(),
				},
				success: function (data) {
					parent.removeClass('btn-progress');
					var JsonObject= JSON.parse(data);
					if (JsonObject.success) {
						$('.child').fadeOut(500);
						$('.child').remove();
						parent.closest('tr').after(JsonObject.view).fadeIn(500);
						$("[name='csrf_token_name']").val(JsonObject.hash);
					} else {
						error(JsonObject.message);
						$("[name='csrf_token_name']").val(JsonObject.hash);
					}
				}
			},'json');
		}else{

		}
	});

	function addCommas(nStr)
	{
		nStr += '';
		var x = nStr.split('.');
		var x1 = x[0];
		var x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

});