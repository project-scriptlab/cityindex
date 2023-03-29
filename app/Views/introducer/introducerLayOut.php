<?php
use Config\Services;
$this->session = Services::session();
helper("custom");
if (!is_introducer() || !$this->session->isLoggedIn) {
	header('Location: '.site_url('login'));
	die;
}
?>
<?= view('introducer/include/intro_header'); ?>
<?= view('include/js'); ?>
<?= $this->renderSection('body'); ?>
<?= view('include/footer'); ?> 
