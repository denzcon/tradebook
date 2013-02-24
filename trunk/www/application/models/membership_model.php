<?php

class Membership_model extends CI_Model
{

	protected $currentUserId = '0';
	protected $currentUsername = 'default';
	protected $currentUserFirstName = 'default';
	protected $currentUserLastName = 'default';
	protected $currentUserEmailAddress = 'default';
	protected $default_new_user_xp_value = 15;

	function __construct()
	{
		$user_info = $this->session->userdata('user_info');
		if (isset($user_info['id']))
		{
			$this->currentUserId = $user_info['id'];
			$this->currentUsername = $user_info['username'];
			$this->currentUserFirstName = $user_info['first_name'];
			$this->currentUserLastName = $user_info['last_name'];
			$this->currentUserEmailAddress = $user_info['email_address'];
			$this->default_new_user_xp_value = 15;
		}
	}

	function currentUserId()
	{
		return $this->currentUserId;
	}

	function currentUsername()
	{
		return $this->currentUsername;
	}

	function currentUserFirstName()
	{
		return $this->currentUserFirstName;
	}

	function currentUserLastName()
	{
		return $this->currentUserLastName;
	}

	function currentUserEmailAddress()
	{
		return $this->currentUserEmailAddress;
	}

	function currentUserGravatarProfileURL()
	{
		return $this->currentUserGravatarProfileURL;
	}
	
	function currentUserGravatarAvatarURL()
	{
		return $this->currentUserGravatarAvatarURL;
	}

	function validate()
	{
		$this->db->select('id, username, first_name, last_name, email_address');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password1')));
		$query = $this->db->get('users');
//		$this->debug($query->num_rows);
		if ($query->num_rows >0)
		{
			$results = $query->result_array();
			$user2Collection = $this->getUser2Collection($results[0]['id']);
			$results[0]['user2Collection'] = $user2Collection;
			$results[0]['gravatarProfileURL'] = 'http://www.gravatar.com/' . md5($results[0]['email_address']);
			$results[0]['gravatarAvatarURL'] = 'http://www.gravatar.com/avatar/' . md5($results[0]['email_address']).'?s=200';
			$gravatarProfileData = $this->site_model->CURL($results[0]['gravatarProfileURL'] . '.json');
			$results[0]['gravatarProfileData'] = json_decode($gravatarProfileData['output']);
			$this->currentUserId = $results[0]['id'];
			$this->currentUsername = $results[0]['username'];
			$this->currentUserFirstName = $results[0]['first_name'];
			$this->currentUserLastName = $results[0]['last_name'];
			$this->currentUserEmailAddress = $results[0]['email_address'];
			$this->currentUserGravatarProfileURL = $results[0]['gravatarProfileURL'];
			$this->currentUserGravatarAvatarURL = $results[0]['gravatarAvatarURL'];
			$return = array(
				'loginStatus'	=> TRUE,
				'results'		=> $results[0]
			);
			$this->site_model->updateSession(array('user_info' => array(
				'id'				=> $this->currentUserId,
				'username'			=> $this->currentUsername,
				'email_address'		=> $this->currentUserEmailAddress,
				'first_name'		=> $this->currentUserFirstName,
				'last_name'		=> $this->currentUserLastName,
				)));
			return $return;
		}
		else
		{
			$return = array(
				'loginStatus' => FALSE,
				'results' => ''
			);
			return $return;
		}
	}

	function create_member()
	{
		$user = new models\Entities\User();
		$user->setUsername($this->security->xss_clean($this->input->post('username')));
		$user->setFirstName($this->security->xss_clean($this->input->post('first_name')));
		$user->setLastName($this->security->xss_clean($this->input->post('last_name')));
		$user->setPassword(md5($this->security->xss_clean($this->input->post('password1'))));
		$user->setEmailAddress($this->security->xss_clean($this->input->post('email_address')));
//		\Doctrine\Common\Util\Debug::dump($user);
		$this->em->persist($user);
		$this->em->flush();

		$this->db->insert('users2xp', array(
			'user_id'		=> $user->getId(),
			'xp_value'		=> $this->default_new_user_xp_value
		));
		$this->currentUserId = $user->getId();
		$this->currentUserUsername = $this->input->post('username');
		$this->currentUsername = $this->input->post('username');
		$this->currentUserEmailAddress = $this->input->post('email_address');
		$this->currentUserLastName = $this->input->post('last_name');
		$this->currentUserFirstName = $this->input->post('first_name');
		$this->site_model->updateSession(array('user_info' => array(
				'id'				=> $this->currentUserId,
				'username'			=> $this->currentUsername,
				'email_address'		=> $this->currentUserEmailAddress,
				'first_name'		=> $this->currentUserFirstName,
				'last_name'		=> $this->currentUserLastName,
				)));
		return true;
	}

	function getUserInfoArray()
	{
		$userInfoArray = array(
			'currentUserId'				=> $this->currentUserId,
			'currentUsername'			=> $this->currentUsername,
			'currentUserFirstName'		=> $this->currentUserFirstName,
			'currentUserLastName'		=> $this->currentUserLastName,
			'currentUserEmailAddress'		=> $this->currentUserEmailAddress
		);

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
		if ($query->num_rows > 0)
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