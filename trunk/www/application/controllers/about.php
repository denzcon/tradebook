<?php
class About extends MY_Controller {

	function index()
	{
		
		$data = array();
		$data['userInfoArray'] = $this->session->userdata();
		$this->load->view('page_top.php', array('data' => $data));
		$this->load->view('about');
		
	}

}

?>
