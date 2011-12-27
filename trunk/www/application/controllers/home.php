<?php

class Home extends MY_Controller
{

	function index()
	{
		echo "processing image from:  ".base_url().'images/xmas.jpg';
		$process = $this->site_model->processItemImage('/images/xmas.jpg', 'gd2', 'xmas_processed.jpg', '', 50, 50);
//		echo "test";
		echo $this->image_lib->display_errors();
		echo $process;
		exit;
		$data['grid'] = $this->site_model->build_grid_for_public();
		$data['userInfoArray'] = $this->session->userdata();

		$this->load->view('page_top.php', $data);
		$this->load->view('home/home_top.php');
		$this->load->view('home', $data);
	}

}