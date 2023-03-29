<script>
	site_url = '<?= site_url() ?>';
</script>

<!-- bundle -->
<script src="<?= site_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= site_url(); ?>assets/js/app.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="<?= site_url(); ?>assets/js/swall.min.js"></script>
<script src="<?= site_url(); ?>assets/js/custom/select2.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/quill.min.js"></script>
<script src="<?= site_url(); ?>assets/js/custom/daterangepicker.min.js"></script>

<!-- custom party js -->
<script src="<?=site_url('assets/js/scripts.js')?>"></script>
<script src="<?=site_url('assets/js/custom.js')?>"></script>
<!-- custom party js ends -->


<script>
	//sweet alert
	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});

	function success(message) {
		Toast.fire({
			icon: 'success',
			title: message
		})

		setTimeout(function () {
			location.reload(true);
		}, 3000	);
	}
	function error(message) {
		Toast.fire({
			icon: 'error',
			title: message
		})
	}
</script>

<?php if($this->session->getFlashdata('message') && $this->session->getFlashdata('message_type') == 'success'){ ?>
	<script>
		Toast.fire({
			icon: 'success',
			title: "<?=$this->session->getFlashdata('message');?>"
		})
	</script>
<?php } elseif ($this->session->getFlashdata('message') && $this->session->getFlashdata('message_type') == 'error') { ?>
	<script type="text/javascript">
		Toast.fire({
			icon: 'error',
			title: "<?=$this->session->getFlashdata('message');?>"
		})
	</script>
<?php } unset($_SESSION['message']); ?>	

<script type="text/javascript">
	document.addEventListener('contextmenu', function(e) {
		e.preventDefault();
	});
	document.onkeydown = function(e) {
		if(event.keyCode == 123) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
			return false;
		}
	}
</script>

<!-- third party js -->
<script src="<?= site_url(); ?>assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/dataTables.bootstrap5.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/dataTables.responsive.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/responsive.bootstrap5.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/dataTables.buttons.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/buttons.bootstrap5.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/buttons.html5.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/buttons.flash.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/buttons.print.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/dataTables.keyTable.min.js"></script>
<script src="<?= site_url(); ?>assets/js/vendor/dataTables.select.min.js"></script>
<!-- third party js ends -->
