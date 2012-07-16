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

	public function currentUserProgress()
	{
		$user_xp_value = $this->getUserXp();
		$return = array(
			'xp' => $user_xp_value[0],
			'rank' => $this->currentRank(),
		);
		return $return;
	}

	public function currentRank()
	{
		$user_xp_value = $this->getUserXp();
		foreach ($this->ranks as $k => $v)
		{
			if ($user_xp_value[0]['xp_value'] <= $v)
			{
				$count1 = $user_xp_value[0]['xp_value'] / $v;
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

	public function getUserXp()
	{
		$current_user = $this->session->userdata('user_info');
		$progress = $this->db->get_where('users2xp', array('user_id' => $current_user['id']));
		return $progress->result_array();
	}

}