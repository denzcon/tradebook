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
		$data['services'] = $this->site_model->getFullTradeServiceList();
		$data['userInfoArray'] = $this->membershipModel->getUserInfoArray();
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
		$rules['email_address'] = array(
			'field_name' => 'Email',
			'required' => true,
			'notEmpty' => true,
			'custom' => array(
				function ($_fieldName, $rule, $values)
				{
					if (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $values[$_fieldName]))
					{
						return true;
					}
					else
					{
						return 'You must provide a valid email address';
					}
				}
//				function ($_fieldName, $rule, $values)
//				{
//					$CI = get_instance();
//					$result = $CI->user_model->getUserByEmail($values[$_fieldName]);
//					if (!$result)
//					{
//						return true;
//					}
//					else
//					{
//						return "This email is already used by another organization.";
//					}
//				}
			)
		);

		$rules['first_name'] = array(
			'field_name' => 'First Name',
			'required' => true,
			'length' => array(
				'max' => 128
			)
		);
		$rules['username'] = array(
			'field_name' => 'User Name',
			'required' => true
		);

		$rules['last_name'] = array(
			'field_name' => 'Last Name',
			'required' => true,
			'length' => array(
				'max' => 255
			)
		);
		

		if (!count($_POST))
		{
			$json_results = array(
				'status' => false,
				'message' => 'The form you submitted has no parameters being passed'
			);
			echo json_encode($json_results);
			return;
		}

		$errors = validateArrays($rules, $_POST);

		if (is_array($errors) && count($errors))
		{
			$json_results = array(
				'status' => false,
				'message' => 'There have been errors in our validation for your record submit',
				'errors' => $errors
			);
			echo json_encode($json_results);
			return;
		}

		$json_results = array(
			'status' => true,
			'message' => 'Your user information has been successfully updated. You can continue to change any info you need to',
			'redirect' => "/settings/organization"
		);
		$this->load->model('user_model');
		$modifyStatus = $this->user_model->modifyUserInfo($this->input->post());
		$json_results['modifyStatus'] = $modifyStatus;
		echo json_encode($json_results);
		return;		

	}
	
	function scrapeWishFromURLRobert()
	{
		$url		= 'http://www.newegg.com/Product/Product.aspx?Item=9SIA016000HY14&cm_sp=Spotlight-_-9SIA016000HY14-_-12102011';
		$html		= $this->site_model->CURL($url);

		$dom		= new DOMDocument();
		@$dom->loadHTML($html);

		$xpath		= new DOMXPath($dom);
		$price		= $xpath->evaluate("//*[@id='synopsis']");
		
		echo "<pre>test";
		print_r($price);
		echo "</pre>";
		exit;

		
	}
}