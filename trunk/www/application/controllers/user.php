<?php

class User extends MY_Controller
{
	protected $default_action_value = 7;
	
	/**
	 *
	 * @var Google_api
	 */
	static public $google_api_model;

	function index()
	{

		if (!$this->UserInfoArray['is_logged_in'])
		{
			redirect('/');
		}
		$session_data = $this->session->userdata();
		$data = array();
		$data['username'] = $this->uri->segment(2);
		$data['userInfoArray'] = $this->session->userdata();
		$data['wants'] = $this->user_model->getUserWishList();
		$data['progress'] = $this->progress_model->currentUserProgress();
//		$this->debug($data['wants']);
//		$this->debug($this->progress_model->currentUserProgress());
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
		if (!$this->UserInfoArray['is_logged_in'])
		{
			redirect('/');
		}
		$this->load->model('user_model');
		$this->load->model('membership_model');
		$data = array();
		$data['user_id'] = $this->membership_model->currentUserId();
		$data['userServices'] = $this->user_model->getServicesForUser($data['user_id']);
		$data['package_name'] = $this->session->userdata('package_name') ? $this->session->userdata('package_name') : 'Create a package';

		$this->load->view('page_head_incl', $this->UserInfoArray);
		$this->load->view('header_menu_nav', $this->UserInfoArray);
		$this->load->view('addwish', $data);
	}

	function searchWishAjax()
	{
		$key = $this->google_api->getGoogleShoppingSearchApiKey();
//		$this->debug("test"); 
		$search_string = urlencode($this->input->post("itemSearch"));
		$response = array();
//		$response['key'] = $key;
		$response['status'] = true;
//		$response["post"] = $ajax;
		$url = $this->google_api->buildShoppingUrl($key, 1, 20, 'shopping', 'search', $search_string);
		$data = $this->CURL($url);
		$response['data'] = json_decode($data['output'], true);
		$page_index = $this->input->post('page_index');
		$results_max_page = $this->input->post('result_max_page');
		$prev_page_index = $page_index - $results_max_page;
		$next_page_index = $page_index + $results_max_page;
//		$prev_page = $this->google_api->buildShoppingUrl($ajax, $key, $prev_page_index, $results_max_page, "shopping");
//		$next_page = $this->google_api->buildShoppingUrl($ajax, $key, $next_page_index, $results_max_page, "shopping");
//		$this->debug($response);
//		log_message('error', $response['data']);
		$result_display_max = 16;
		$fetched_search_count = $response['data']['totalItems'];
		$displayed_search_count = isset($response['data']['currentItemCount']);
		$pages = $fetched_search_count / $result_display_max;
		$response['pagination'] = array(
			'fetched_search_count' => $fetched_search_count,
			'displayed_search_count' => $displayed_search_count,
			'page_count' => $pages,
			'next_page' => $next_page_index,
			'prev_page' => $prev_page_index,
		);
//		$this->debug($response);
//		exit;
		echo json_encode($response);
	}

	function addWishAjax()
	{

		$this->load->model('user_model');
		$status = $this->user_model->addWish2User($this->input->post());
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
		$url = 'http://www.newegg.com/Product/Product.aspx?Item=9SIA016000HY14&cm_sp=Spotlight-_-9SIA016000HY14-_-12102011';
		$html = $this->site_model->CURL($url);

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

		$xpath = new DOMXPath($dom);
		$price = $xpath->evaluate("//*[@id='synopsis']");

		echo "<pre>test";
		print_r($price);
		echo "</pre>";
		exit;
	}

	function save_package_name()
	{
		$this->session->set_userdata(array('package_name' => trim($this->input->post('packageName'))));
		echo json_encode(array(
			'package_name_from_session' => $this->session->userdata('package_name'),
			'form_post' => $this->input->post()
		));
	}

	function save_package_data()
	{
		$item_array = array();
		foreach ($this->input->post() as $key => $post)
		{
			if (is_array($post))
			{
				foreach ($post as $item => $v)
				{
					if ($key == 'price')
					{
						$item_array[$item][$key] = str_replace('$', '', $v);
					}
					else
					{
						$item_array[$item][$key] = $v;
					}
				}
			}
		}
		foreach ($item_array as $item)
		{
			$this->db->insert('wanted', $item);
			$u2w = array(
				'user_id' => $this->membershipModel->currentUserId(),
				'want_id' => $this->db->insert_id()
			);
			$this->db->insert('user2wants', $u2w);
			$w2xp = array(
				'wanted_id' =>$u2w['want_id'],
				'xp_value' => round($item['price']*$this->default_action_value),
			);
			$this->db->insert('wants2xp', $w2xp);
			$query = '
				UPDATE users2xp SET xp_value = xp_value + ? WHERE user_id = ?
				';
			$this->db->query($query, array(
				$this->default_action_value,
				$this->membershipModel->currentUserId()
			));
		}
	}

	function current()
	{
		$this->debug($this->membershipModel, $this->membershipModel->currentUserId());
	}
	
	function getUserWishList()
	{
		$this->debug($this->user_model->getUserWishList());
	}
	
	function session()
	{
		$this->debug($this->session->userdata());
	}

}