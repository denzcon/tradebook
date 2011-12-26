<?php

class Home extends MY_Controller
{

	function index()
	{

		$data['grid'] = $this->site_model->build_grid_for_public();
		$data['userInfoArray'] = $this->session->userdata();

		$this->load->view('page_top.php', $data);
		$this->load->view('home/home_top.php');
		$this->load->view('home', $data);
	}

}