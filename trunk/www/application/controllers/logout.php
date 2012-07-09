<?php
class Logout extends MY_Controller
{
	function index()
	{
		$this->debug($this->session->userdata());
		$this->session->destroy();
		$this->debug($this->session->userdata());
	}
}