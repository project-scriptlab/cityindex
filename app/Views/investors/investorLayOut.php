<?php
use Config\Services;
$this->session = Services::session();
helper("custom");
if (!is_investor() || !$this->session->isLoggedIn ) {
	header('Location: '.site_url('login'));
	die;
}
?>
<?= view('investors/include/investor-header'); ?>
<?= view('include/js'); ?>
<?= $this->renderSection('body'); ?>
<?= view('include/footer'); ?> 
