<?php

class Lookforwork extends MY_Controller {

	function index()
	{
		
		$data['grid'] = $this->site_model->build_grid_for_public(1);
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
		$this->load->view('home', $data);
	}

}