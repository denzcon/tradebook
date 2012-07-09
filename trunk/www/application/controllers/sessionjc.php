<?php
class Sessionjc extends MY_Controller
{

	function index()
	{
		$this->debug($this->session->userdata());
	}

}