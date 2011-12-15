<?php
class Settings extends CI_Controller {

	function index()
	{
		
		$data = array();
		$this->load->model('site_model');
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
		$this->load->view('settings');
		
	}

}