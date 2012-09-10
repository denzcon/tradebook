<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function addWish2User($data)
	{
		$this->load->model('membership_model');
		$values = array();
		$return = array();
		$relate_values = array();
		$values['id'] = '';
		$values['title'] = $data['itemTitle'];
		$values['price'] = $data['itemPrice'];
		$values['description'] = $data['itemDescription'];
		$values['preview_image'] = $data['itemImage'];

		$add_want = $this->db->insert('wanted', $values);
		$return['status_want_insert'] = $add_want;

		$relate_values['id'] = '';
		$relate_values['user_id'] = $this->membership_model->currentUserId();
		$relate_values['want_id'] = $this->db->insert_id();
		$relate = $this->db->insert('user2wants', $relate_values);
		$relate_values['service_id'] = $data['workTrade'];
		$relate_values = array_splice($relate_values, 2);
		$relate = $this->db->insert('wants2services', $relate_values);
		$return['status_want_relate2user'] = $relate;
		$return['data'] = $data;
		return $relate_values;
	}

	function getServicesForUser($user_id)
	{
		$this->db->Select('*');
		$this->db->from('services');
		$this->db->join('user2services', 'user2services.service_id = services.id', 'left');
		$this->db->join('users', 'users.id = user2services.user_id', 'left');
		$this->db->where('users.id', $user_id);
		$query = $this->db->get();
		$return = $query->result_array();
		return $return;
	}

	function scrapeWishFromURL($data)
	{
		$this->load->model('site_model');
		$domain = $this->getDomainFromURL($data['wishURL'], 'root');
		switch ($domain)
		{
			case 'newegg':
				$scrape = $this->scrapeWishFromNewegg($data);
				break;
			case 'bestbuy':
				$scrape = $this->scrapeWishFromBestBuy($data);
				break;
			default:
				break;
		}
	}

	function getDomainFromURL($data, $format)
	{
		$url_data = parse_url($data['wishURL']);
		return $url_data;
	}

	function modifyUserInfo($data)
	{
		$this->db->where('id', $data['user_id']);
		$data = array(
			'username' => $data['username'],
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email_address' => $data['email_address'],
		);
		$query = $this->db->update('users', $data);
		if ($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getUserWishList()
	{
		$session_data = $this->session->userdata();
		$user = $this->db->query('
			SELECT
			u.id,
			u2w.want_id,
			u2w.user_id,
			wd.id,
			wd.title,
			wd.price,
			wd.description,
			wd.preview_image,
			w2x.xp_value,
			format(((u2x.xp_value * 100) / (w2x.xp_value)), 0) as percent
			FROM wanted wd
			LEFT JOIN user2wants u2w ON u2w.want_id = wd.id
			LEFT JOIN users u ON u2w.user_id = u.id
			LEFT JOIN wants2xp w2x ON w2x.wanted_id = wd.id
			LEFT JOIN users2xp u2x ON u2x.user_id = u.id
			WHERE u.id=?
			AND wd.status = \'a\'
			GROUP BY wd.id
			ORDER BY  (percent+0) DESC
			', array($session_data['user_info']['id']));
		if ($user->num_rows == 0)
		{
			return false;
		}
		return $user->result_array();
	}

	function getUserWishListDeleted()
	{
		$session_data = $this->session->userdata();
		$user = $this->db->query('
			SELECT
			u.id,
			u2w.want_id,
			u2w.user_id,
			wd.id,
			wd.title,
			wd.price,
			wd.description,
			wd.preview_image,
			w2x.xp_value,
			format(((u2x.xp_value * 100) / (w2x.xp_value)), 0) as percent
			FROM wanted wd
			LEFT JOIN user2wants u2w ON u2w.want_id = wd.id
			LEFT JOIN users u ON u2w.user_id = u.id
			LEFT JOIN wants2xp w2x ON w2x.wanted_id = wd.id
			LEFT JOIN users2xp u2x ON u2x.user_id = u.id
			WHERE u.id=?
			AND wd.status = \'d\'
			GROUP BY wd.id
			ORDER BY  (percent+0) DESC
			', array($session_data['user_info']['id']));
		if ($user->num_rows == 0)
		{
			return false;
		}
		return $user->result_array();
	}

	function findAccountToLink($input)
	{
//		$lookup = $this->db->get_where('users', array('email_address' => $input['query']));
		$this->db->select('users.id, users.username, users.first_name, users.last_name, users.email_address, user_avatars.avatar_image_url');
		$this->db->join('user_avatars', 'user_avatars.user_id = users.id', 'left');
		$this->db->like('users.email_address', $input['query']);
		$this->db->or_like('users.first_name', $input['query']);
		$this->db->or_like('users.last_name', $input['query']);
		$this->db->or_like('users.username', $input['query']);
		return $this->db->get('users')->result_array();
	}

}