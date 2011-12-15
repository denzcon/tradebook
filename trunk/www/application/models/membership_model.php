<?php

class Membership_model extends CI_Model
{

	static $currentUserId = '1';
	static $currentUserUsername = 'default';
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

			self::$currentUserId = $results[0]['id'];
			self::$currentUserFirstName = $results[0]['first_name'];
			self::$currentUserLastName = $results[0]['last_name'];
			self::$currentUserUsername = $results[0]['username'];
			self::$currentUserEmailAddress = $results[0]['email_address'];

			$return = array(
				'results' => $results[0]
			);
			return $results[0];
		}
		else
		{
			return false;
		}
	}

	function create_member()
	{
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password1')
		);
		$insert = $this->db->insert('users', $new_member_insert_data);
		return $insert;
	}

}