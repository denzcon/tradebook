<?php
if(!isset($data['is_logged_in']))
{
	$data['is_logged_in'] = $this->session->userdata('is_logged_in');
}

$this->load->view('page_head_incl.php');
$data['current_user_info'] = $this->session->userdata();
$this->load->view('header_menu_nav.php', $data);

$this->load->view('modals.php', array('data' =>$data));
?>
