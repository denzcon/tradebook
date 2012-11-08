<?php

class User extends MY_Controller
{

	protected $default_action_value = 3;
	public $api_names = array(
		1 => 'shopping',
		2 => 'customsearch'
	);
	public $search_types = array(
		0 => 'web',
		1 => 'image'
	);

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
		$data = array();
		$data['userInfoArray'] = $this->session->userdata();
		$user = $this->db->get_where('users', array('id' => $this->membershipModel->currentUserId()))->first_row();
		
		$data['wants'] = $this->user_model->getUserWishList($user);
		$data['progress'] = $this->progress_model->currentUserProgress();
		$data['wish_list'] = true;
//		$this->debug($this->progress_model->currentUserProgress());
		$data['is_logged_in'] = $this->session->userdata('is_logged_in');
		$this->load->view('page_top.php', array('data' => $data));
		$this->load->view('user', $data);
	}

	function settings()
	{
		$data = array();
		$data['services'] = $this->site_model->getFullTradeServiceList();
		$data['userInfoArray'] = $this->membershipModel->getUserInfoArray();
		$data['userInfoArray']['facebook'] = $this->facebook_data;
		$this->load->view('page_top.php', array('data' => $data));
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
		$data['user_info'] = $this->UserInfoArray;
		$data['userInfoArray'] = $this->session->userdata();
		$data['is_logged_in'] = $this->UserInfoArray['is_logged_in'];
		$this->load->view('page_top.php', array('data' => $data));
		$this->load->view('addwish', $data);
	}

	function searchWishAjax()
	{
		$type = (string) $this->input->post('type');
		$this->setSearchType();
		switch ($type)
		{
			case '2':
				return $this->searchWishCustom();
				break;

			default:
				return $this->searchWishShopping();
				break;
		}
	}

	function searchWishShopping()
	{
		$key = $this->google_api->getGoogleShoppingSearchApiKey();
//		$this->debug("test"); 
		$search_string = urlencode($this->input->post("itemSearch"));
		$search_type = $this->input->post('searchType');
		$response = array();
		$sort = $this->input->post('sort');
		$order = 'descending';
//		$custom_search_url = $this->google_api->buildCustomSearchUrl(1, 20, 'customsearch', 'v1', $search_string, $sort, $order);
		$url = $this->google_api->buildShoppingUrl($key, 1, 20, 'shopping', 'search', $search_string, $sort, $order);
		$this->shoppingSearchURL = $url;
		$data = $this->CURL($url);
		$this->searchResponse($data, 'shopping');
	}

	function searchWishCustom()
	{
		$search_string = urlencode($this->input->post("itemSearch"));
		$response = array();
		$response['status'] = true;
		$sort = $this->input->post('sort');
		$order = 'descending';
		$api_name = 'customsearch';
		$search_type = $this->getSearchType();
		$custom_search_url = $this->google_api->buildCustomSearchUrl(1, 10, $api_name, $search_type, 'v1', $search_string, $sort, $order);
		$this->customSearchURL = $custom_search_url;
		$data = $this->CURL($custom_search_url);
		$this->searchResponse($data, $api_name);
	}

	function searchResponse($data, $search_type)
	{
		switch ($search_type)
		{
			case 'customsearch':
				$response['status'] = true;
				$response['type'] = $search_type;
				$response['custom_search_url'] = $this->customSearchURL;

				$response['data'] = json_decode($data['output'], true);
				$page_index = $this->input->post('page_index');
				$results_max_page = $this->input->post('result_max_page');
				$prev_page_index = $page_index - $results_max_page;
				$next_page_index = $page_index + $results_max_page;
				$result_display_max = 16;
				$fetched_search_count = $response['data']['searchInformation']['totalResults'];
				$displayed_search_count = count($response['data']['items']);
				$pages = $fetched_search_count / $result_display_max;
				$response['pagination'] = array(
					'fetched_search_count' => $fetched_search_count,
					'displayed_search_count' => $displayed_search_count,
					'page_count' => $pages,
					'next_page' => $next_page_index,
					'prev_page' => $prev_page_index,
					'api_name' => $this->api_names[$this->input->post('type')],
					'search_type' => $this->getSearchType(),
					'api_call_url' => $this->customSearchURL
				);
				echo json_encode($response);

				break;

			case 'shopping':

				$response['status'] = true;
				$response['type'] = $search_type;
				$response['data'] = json_decode($data['output'], true);
				$page_index = $this->input->post('page_index');
				$results_max_page = $this->input->post('result_max_page');
				$prev_page_index = $page_index - $results_max_page;
				$next_page_index = $page_index + $results_max_page;
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
					'api_name' => $this->api_names[$this->input->post('type')],
					'search_type' => $this->getSearchType(),
					'api_call_url' => $this->shoppingSearchURL
				);
				echo json_encode($response);

				break;

			default:
				break;
		}
	}

	function addWishAjax()
	{

		$this->load->model('user_model');
		$status = $this->user_model->addWish2User($this->input->post());
		echo json_encode($status);
	}

	function member()
	{
		if (!isset($this->UserInfoArray['is_logged_in']))
		{
			redirect('/');
		}
		$data = array();
		$data['username'] = $this->uri->segment(3);
		$viewed_user = $this->db->get_where('users', array('username' => $data['username']))->first_row();
		$viewed_user_array = (array)$viewed_user;
//		$this->debug($viewed_user);
		
		$viewed_user_array['gravatarAvatarURL'] = $this->getGravatarURLForUser($viewed_user);
		$data['userInfoArray'] =array(
			'user_info' => $viewed_user_array
			);
		
		$data['wants'] = $this->user_model->getUserWishList($viewed_user);
		$data['progress'] = $this->progress_model->currentUserProgress($viewed_user);
		$data['wish_list'] = true;
		$data['is_logged_in'] = $this->session->userdata('is_logged_in');
		$this->load->view('page_top.php', array('data' => $data));
		$this->load->view('page_top.php', array('data' => $data));
		$this->load->view('user', $data);
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
//		$this->load->view('member/index', $data);
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
		$data = array(
			'user_id' => $this->membershipModel->currentUserId(),
			'package_name' => $this->input->post('packageName'),
		);

		$this->db->insert('package', $data);
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
						$item_array[$item]['status'] = 'a';
					}
					else
					{
						$item_array[$item][$key] = $v;
						$item_array[$item]['status'] = 'a';
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
				'wanted_id' => $u2w['want_id'],
				'xp_value' => round($item['price'] * $this->default_action_value),
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

	function linkAccountRequest()
	{
		if ($this->input->get('query'))
		{
			$input = $this->input->get();
			$target_acounts = $this->user_model->findAccountToLink($input);
			$suggestion = array();
			foreach ($target_acounts as $suggestion)
			{
				$suggestions[] = $suggestion['first_name'] . ' ' . $suggestion['last_name'];
				$data[] = $suggestion;
			}
			$response = array(
				'query' => $input['query'],
				'suggestions' => $suggestions,
				'data' => $data
			);
			echo json_encode($response);
		}
		else
		{
			$this->load->view('modals/link_accounts.php');
		}
	}

	function getLinkedAccounts()
	{
		$return = $this->db->get_where('account_links', array('user_id_alpha' => $this->membershipModel->currentUserId()));
		return $return;
	}

	function getSearchType()
	{
		return $this->search_type;
	}

	function setSearchType()
	{
		$types = $this->search_types;
		$this->search_type = $types[$this->input->post('extended_search')];
	}

	function manage_xp()
	{
		$this->db->select('user_id_bravo');
		$accounts = $this->db->get_where('account_links', array('user_id_alpha' => $this->membershipModel->currentUserId()));
		foreach ($accounts->result_array() as $account)
		{
			$this->db->select('username, first_name, last_name, email_address, xp_value');
			$this->db->from('users');
			$this->db->join('users2xp', 'users2xp.user_id = users.id');
			$this->db->where('users.id', $account['user_id_bravo']);
			$user = $this->db->get();
			$user = $user->result_array();
			$users[] = $user[0];
		}
//		$this->debug($accounts->result_array());
//		$this->db->select('*');
//		$this->db->from('account_links');
//		$this->db->where('user_id_alpha', $this->membershipModel->currentUserId());
//		$this->db->or_where('user_id_bravo', $this->membershipModel->currentUserId());
//		$this->debug($this->db->get());
		$this->load->view('modals/manage_xp.php', array(
			'users' => isset($users) ? $users : null,
			'current_xp' => Progress_model::getUserXp()
		));
	}

	function linkAccount()
	{
		echo json_encode($this->db->insert('account_links', array(
					'user_id_alpha' => $this->membershipModel->currentUserId(),
					'user_id_bravo' => $this->input->post('linkedUserId'),
					'status' => 1
				)));
	}

	function removeWishItem()
	{
		$undo_operation = $this->input->post('undo');
		$response = array(
			'undo operation' => $undo_operation
		);
		$wish_id = $this->input->post('wishId');
		$this->db->where('id', (int)$this->input->post('wishId'));
		$status = $this->db->update('wanted', array('status' => $undo_operation ? 'a' : 'd'));
		
		echo json_encode(array('success' => $status));
		return $status;
	}

	function deleted_items()
	{
		if (!$this->UserInfoArray['is_logged_in'])
		{
			redirect('/');
		}
		$data = array();
		$data['userInfoArray'] = $this->session->userdata();
		$data['wants'] = $this->user_model->getUserWishListDeleted();
		$data['progress'] = $this->progress_model->currentUserProgress();
		$data['wish_list'] = false;
//		$this->debug($this->progress_model->currentUserProgress());
		$data['is_logged_in'] = $this->session->userdata('is_logged_in');
		$this->load->view('page_top.php', array('data' => $data));
		$this->load->view('user', $data);
	}

}
