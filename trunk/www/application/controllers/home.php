<?php

class Home extends CI_Controller
{

	function index()
	{

		$data['grid'] = $this->site_model->build_grid_for_public();
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
		$this->load->view('home/home_top.php');
		$this->load->view('home', $data);
	}

}