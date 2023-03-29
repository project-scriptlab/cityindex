$(document).ready(function(){
	"use strict";

	$(document).on('click', '.add-more-file-input', function(e){
		let html = '<div class="row mb-3"><div class="col-md-10"><div class="input-group"><input class="form-control" type="file" name="documents[]"><input type="text" class="form-control document_title" name="document_title[]" placeholder="Enter document title"><a href="javascript:void(0)" class="btn btn-danger btn-icon btn-sm remove-file-input"><i class="fa-solid fa-minus"></i></a></div></div></div>';
		$('#formInvestorDocuments').append(html);
	});

	$(document).on('click', '.remove-file-input', function(e){
		$(this).closest('.row').remove();
	});
});