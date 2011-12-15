<?php

class MY_Controller extends CI_Controller
{
	/**
	 * @var Membership_model
	 */
	public $membershipModel;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('membership_model');
		$this->membershipModel=$this->membership_model;
	}
}
