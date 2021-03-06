<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Progress_model extends CI_Model
{

	protected $ranks = array(
		1 => 500,
		2 => 1000,
		3 => 2500,
		4 => 4000,
		5 => 6000
	);

	function index()
	{
		
	}

	public function currentUserProgress($user=null)
	{
		$user_xp_value = $this->getUserXp($user);
		$return = array(
			'xp' => $user_xp_value,
			'rank' => $this->currentRank(),
		);
		return $return;
	}

	public function currentRank()
	{
		$user_xp_value = $this->getUserXp();
		foreach ($this->ranks as $k => $v)
		{
			if ($user_xp_value['xp_value'] <= $v)
			{
				$count1 = $user_xp_value['xp_value'] / $v;
				$count2 = $count1 * 100;
				$percent = number_format($count2, 0);
				return array(
					'rank' => $k,
					'threshold' => $v,
					'percent' => $percent
				);
			}
		}
		return false;
	}

	public function getUserXp($user=null)
	{
		if(is_null($user) OR !isset($user))
		{
			$current_user = $this->session->userdata('user_info');
			$progress = $this->db->get_where('users2xp', array('user_id' => $current_user['id']));
			$return = $progress->row_array();
		}
		else if(is_numeric($user))
		{
			$progress = $this->db->get_where('users2xp', array('user_id' => $user));
			$return = $progress->row_array();
		}
		else
		{
			$viewed_user = $user;
			$progress = $this->db->get_where('users2xp', array('user_id' => $viewed_user->id));
			$return = $progress->row_array();
		}
		return $return;
	}
	
	public function sendUserXP($data)
	{
		foreach ($data as $value)
		{
			return $value;
		}
		
	}
	
	public function sendUsersXP()
	{
		
	}

}