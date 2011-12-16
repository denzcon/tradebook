<?php

class Membership_model extends CI_Model
{

	static $currentUserId = '0';
	static $currentUsername = 'default';
	static $currentUserFirstName = 'default';
	static $currentUserLastName = 'default';
	static $currentUserEmailAddress = 'default';

	function __construct()
	{
		parent::__construct();
	}

	function currentUserId()
	{
		return self::$currentUserId;
	}

	function currentUsername()
	{
		return self::$currentUsername;
	}

	function currentUserFirstName()
	{
		return self::$currentUserFirstName;
	}

	function currentUserLastName()
	{
		return self::$currentUserLastName;
	}

	function currentUserEmailAddress()
	{
		return self::$currentUserEmailAddress;
	}

	function validate()
	{
		$this->db->select('id, username, first_name, last_name, email_address');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password1')));
		$query = $this->db->get('users');
		if ($query->num_rows == 1)
		{
			$results = $query->result_array();
			$user2Collection	= $this->getUser2Collection($results[0]['id']);
			$results[0]['user2Collection'] = $user2Collection;
			self::$currentUserId			= $results[0]['id'];
			self::$currentUsername			= $results[0]['username'];
			self::$currentUserFirstName		= $results[0]['first_name'];
			self::$currentUserLastName		= $results[0]['last_name'];
			self::$currentUserEmailAddress	= $results[0]['email_address'];
			$return = array(
				'loginStatus' => 'true',
				'results' => $results[0]
			);
			return $return;
		}
		else
		{
			$return = array(
				'loginStatus' => 'false',
				'results' => ''
			);
			return $return;
		}
	}

	function create_member()
	{
		$new_member_insert_data = array(
			'first_name'	=> $this->input->post('first_name'),
			'last_name'		=> $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),
			'username'		=> $this->input->post('username'),
			'password'		=> $this->input->post('password1')
		);
		$insert = $this->db->insert('users', $new_member_insert_data);
		return $insert;
	}
	function getUserInfoArray()
	{
//		$userInfoArray = array(
//			'currentUserId'				=> self::$currentUserId,
//			'currentUserUsername'		=> self::$currentUserUsername,
//			'currentUserFirstName'		=> self::$currentUserFirstName,
//			'currentUserLastName'		=> self::$currentUserLastName,
//			'currentUserEmailAddress'	=> self::$currentUserEmailAddress
//		);
		
		return $this->session->userdata();
	}
	
	function isUserAdmin($user_id)
	{
		$this->db->select('user_id', 'collection_id', 'description');
		$this->db->from('user2collection');
		$this->db->join('collection', 'user2collection.user_id = collection.id', 'left');
		$this->db->where('user2collection.user_id', $user_id);
		$query = $this->db->get();
		$return = $query->result_array();
		if($query->num_rows == 1)
		{
			$return = array(
				'status' => true,
				'isAdminResults' => $return
			);
			return $return;
		}
		else
		{
		return false;			
		}
	}
	function getUser2Collection($user_id)
	{
		$this->db->select('collection_id');
//		$this->db->from('user2collection');
		$query = $this->db->get_where('user2collection', array('user_id' => $user_id));
		$results = $query->result_array();
		return $results;		
	}
}