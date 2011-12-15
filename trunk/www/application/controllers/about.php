<?php
class About extends CI_Controller {

	function index()
	{
		
		$data = array();
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
		$this->load->view('about');
		
	}

}

?>
