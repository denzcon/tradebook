<?php

class User extends MY_Controller
{

	function index()
	{
		$session_data = $this->session->userdata();

		echo "<pre>";
		print_r($session_data);
		echo "</pre>";
		exit;
		$data = array();
		$data['username'] = $this->uri->segment(2);
		$data['userInfoArray'] = $this->session->userdata();
		$this->load->view('page_top.php', $data);
		$this->load->view('user', $data);
	}

	function settings()
	{
		$data = array();
		$data['userInfoArray'] = $this->session->userdata();
		$this->load->view('page_top.php', $data);
		if ($this->site_model->is_logged_in())
		{
			$this->load->view('settings', $data);
		}
		else
		{
			$this->load->view('home');
		}
	}

	function addWish()
	{
		$this->load->model('user_model');
		$this->load->model('membership_model');
		$data = array();
		$data['user_id']		= $this->membership_model->currentUserId();
		$data['userServices']	= $this->user_model->getServicesForUser($data['user_id']);
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
		$this->load->view('addwish', $data);
	}

	function addWishAjax()
	{
		$this->load->model('user_model');
		$ajax = $this->input->post();
		$status = $this->user_model->addWish2User($ajax);
		echo json_encode($status);
	}

	function member()
	{
		$data = array();
		$data['username'] = $this->uri->segment(2);
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
		$this->load->view('member/index', $data);
	}

	function addWishURLAjax()
	{
		$this->load->model('user_model');
		$ajax = $this->input->post();
		$status = $this->user_model->scrapeWishFromURL($ajax);
		echo json_encode($status, true);
	}

	function update()
	{
		$this->load->model('user_model');
		$return = $this->user_model->modifyUserInfo($this->input->post());
		echo json_encode($return);
	}

}