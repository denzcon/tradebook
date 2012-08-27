<?php

class Package_model extends CI_Model
{

	/**
	 * @var current_package_id
	 */
	public $current_package_id;
	
	/**
	 * @var current_package
	 */
	public $current_package;

	function __construct()
	{
	}

	function setCurrentPackage($data)
	{
		$this->current_package_id = $data;
		$this->current_package = $this->db->get_where('package', array('id' => $data));
	}

}