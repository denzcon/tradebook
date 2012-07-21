<?php

class Login extends MY_Controller
{

	function index()
	{
		$data['grid'] = $this->site_model->build_grid_for_public();
		$data['userInfoArray'] = $this->session->userdata();
		$this->load->view('page_top.php', $data);
		$this->load->view('modals/login_form', $data);
	}

	function validate_credentials()
	{

		$query = $this->membershipModel->validate();
		if ($query['loginStatus'] == true)
		{
			$isAdmin = $this->membershipModel->isUserAdmin($query['results']['id']);
			$data = array(
				'user_info' => $query['results'],
				'is_logged_in' => true,
				'isAdmin' => isset($isAdmin)
			);

			$this->site_model->updateSession($data);
			echo json_encode($data);
		}
		else
		{
			$data = array(
//				'user_info'		=> $query,
				'is_logged_in' => false,
				'isAdmin' => false
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

	function logout()
	{
		if ($this->session->destroy())
		{
			echo "LoggedOut";
		}

//		$this->index();
	}

	function signupSubmit()
	{
		$rules['email_address'] = array(
			'field_name' => 'Email',
			'required' => true,
			'notEmpty' => true,
			'custom' => array(
				function ($_fieldName, $rule, $values)
				{
					if (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $values[$_fieldName]))
					{
						return true;
					}
					else
					{
						return 'You must provide a valid email address';
					}
				}
			)
		);

		$rules['first_name'] = array(
			'field_name' => 'First Name',
			'required' => true,
			'length' => array(
				'max' => 128
			)
		);
		$rules['username'] = array(
			'field_name' => 'User Name',
			'required' => true
		);

		$rules['last_name'] = array(
			'field_name' => 'Last Name',
			'required' => true,
			'length' => array(
				'max' => 255
			)
		);

		$rules['password1'] = array(
			'field_name' => 'New Password',
			'required' => true,
			'length' => array(
				'min' => 5,
				'max' => 20
			)
		);

		$rules['password2'] = array(
			'field_name' => 'Confirm Password',
			'required' => true,
			'length' => array(
				'min' => 5,
				'max' => 20
			),
			'notEmpty' => true,
			'custom' => function ($_fieldName, $rule, $values)
			{
				if ($values[$_fieldName] == $values['password1'])
				{
					return true;
				}
				else
				{
					return "Passwords don't match";
				}
			}
		);

		if (!count($_POST))
		{
			$json_results = array(
				'status' => false,
				'message' => 'The form you submitted has no parameters being passed'
			);
			echo json_encode($json_results);
			return;
		}

		$errors = validateArrays($rules, $_POST);

		if (is_array($errors) && count($errors))
		{
			$json_results = array(
				'status' => false,
				'message' => 'There have been errors in our validation for your record submit',
				'errors' => $errors
			);
			echo json_encode($json_results);
			return;
		}

		$json_results = array(
			'status' => true,
			'message' => 'Your form has been successfully Edited, please wait to be redirected',
			'redirect' => "/settings/organization"
		);
		$json_results['create_member'] = $this->membershipModel->create_member();
		echo json_encode($json_results);
	}

	function loginSubmit()
	{
		$rules['email_address'] = array(
			'field_name' => 'Email',
			'required' => true,
			'notEmpty' => true,
			'custom' => array(
				function ($_fieldName, $rule, $values)
				{
					if (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $values[$_fieldName]))
					{
						return true;
					}
					else
					{
						return 'You must provide a valid email address';
					}
				}
//				function ($_fieldName, $rule, $values)
//				{
//					$CI = get_instance();
//					$result = $CI->user_model->getUserByEmail($values[$_fieldName]);
//					if (!$result)
//					{
//						return true;
//					}
//					else
//					{
//						return "This email is already used by another organization.";
//					}
//				}
			)
		);



		$rules['password1'] = array(
			'field_name' => 'New Password',
			'required' => true,
			'length' => array(
				'min' => 5,
				'max' => 10
			)
		);



		if (!count($_POST))
		{
			$json_results = array(
				'status' => false,
				'message' => 'The form you submitted has no parameters being passed'
			);
			echo json_encode($json_results);
			return;
		}

		$errors = validateArrays($rules, $_POST);

		if (is_array($errors) && count($errors))
		{
			$json_results = array(
				'status' => false,
				'message' => 'There have been errors in our validation for your record submit',
				'errors' => $errors
			);
			echo json_encode($json_results);
			return;
		}

		$json_results = array(
			'status' => true,
			'message' => 'Your form has been successfully Edited, please wait to be redirected',
			'redirect' => "/settings/organization"
		);
		$json_results['create_member'] = $this->membershipModel->create_member();
		echo json_encode($json_results);
		return;
	}

	function sessionDump()
	{
		$this->debug($this->session);
	}

}