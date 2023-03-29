<?php
use Config\Services;
$this->session = Services::session();
helper("custom");
if (!is_admin() || !$this->session->isLoggedIn) {
	header('Location: '.site_url('login'));
	die;
}
?>

<?= view('include/header'); ?>
<?= view('include/js'); ?>
<?= $this->renderSection('body'); ?>
<?= view('include/footer'); ?>
