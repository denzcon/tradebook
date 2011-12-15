<?php

class Login extends MY_Controller {

	function index()
	{
		$data['grid'] = $this->site_model->build_grid_for_public();
		$this->load->view('page_head_incl');
		$this->load->view('header_menu_nav');
		$this->load->view('modals/login_form', $data);
	}
	
	function validate_credentials()
	{
		
		$query = $this->membershipModel->validate();;
		if($query)
		{
			$test = array();
			$data = array(
				'user_info' => $query,
				'is_logged_in' => true				
			);

			$this->site_model->updateSession($data);
			echo json_encode($data);
		}
		else
		{
			$data = array(
				'user_info' => $query,
				'is_logged_in' => false				
			);
			echo json_encode($data);
		}
	}
	
	function signup()
	{
//		echo "<pre>";
//		print_r($this->site_model->signupFormArray());
//		echo "</pre>";
//		exit;
		$this->index();
	}
	
	function createMemberAjax()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password1', 'Password1', 'trim|required|min_length[4]|max_length[32]|md5');
		$this->form_validation->set_rules('password2', 'Password2', 'trim|required|min_length[4]|max_length[32]|matches[password1]|md5');
		$validate = $this->form_validation->run();
		$return = array();
		$return['validation'] = $validate;
		if($validate == FALSE)
		{
			$return['validation_status'] = 'Validation Error';
			$return['validation_errors'] = validation_errors();
			echo json_encode($return);
		}
		else
		{
			$return['validation_status'] = 'Validation Success';
			$this->load->model('membership_model');
			if($query = $this->membership_model->create_member())
			{
			$return['signup_status'] = true;
			$return['signup_status_message'] = 'Successfully created user';
			echo json_encode($return);
				
			}
		}
	}
	
	function logout()
	{
		if($this->session->sess_destroy())
		{
			echo "LoggedOut";
			
		}

//		$this->index();
		
	}
	
}