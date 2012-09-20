<?php

class Sandbox extends MY_Controller
{

	function index()
	{
		$this->debug($this->input->get('stype', FALSE));
		$this->debug($this->input->get('stype', TRUE));
	}

}