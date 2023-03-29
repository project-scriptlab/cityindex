$(document).ready(function(){
	"use strict";
	$(".basicDatatable").DataTable({lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],keys:!0,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});var a=$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["copy","print"],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});

	//tooltip
	$('[data-toggle="tooltip"]').tooltip();

	//select 2
	$('.select2').select2({
		placeholder: "Select a data",
		allowClear: false
	});

	$('#select2introducer').select2({
		placeholder: "Select a Introducer",
		allowClear: false
	});

	$('#select2InvestmentFilter').select2({
		placeholder: "Select Investor",
		allowClear: false
	});


	$('#select2StartInvestment').select2({
		dropdownParent: $('#new-investment'),
		placeholder: "Select Investor",
		allowClear: false
	});

	//single date picker
	$('.singleDatePicker').daterangepicker({
		singleDatePicker: true,
		autoUpdateInput: false,
		showDropdowns: true,
		minYear: 1990,
		maxYear: 2200,
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});
	$('.singleDatePicker').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
	});

	$('#investmentDatePicker').daterangepicker({
		singleDatePicker: true,
		autoUpdateInput: true,
		showDropdowns: true,
		minYear: 1990,
		maxYear: 2200,
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});

	$('#date').daterangepicker({
		singleDatePicker: true,
		autoUpdateInput: true,
		showDropdowns: true,
		minYear: 1990,
		maxDate: new Date(),
		autoApply: true,
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Clear'
		}
	});

	$('[data-bs-toggle="popover"]').popover({});   

	$('body').on('click', function (e) {
		$('[data-bs-toggle=popover]').each(function () {
        // hide any open popovers when the anywhere else in the body is clicked
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
        	$(this).popover('hide');
        }
    });
	});
});
