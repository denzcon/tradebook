<?php
$this->load->helper('utility');
$this->jsonAjaxResponseHeaders();

$rules['email'] = array(
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
		},
		function ($_fieldName, $rule, $values)
		{
			$CI = get_instance();
			$result = $CI->user_model->getUserByEmail($values[$_fieldName]);
			if (!$result)
			{
				return true;
			}
			else
			{
				return "This email is already used by another organization.";
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

$rules['last_name'] = array(
	'field_name' => 'Last Name',
	'required' => true,
	'length' => array(
		'max' => 255
	)
);

$rules['timezone'] = array(
	'field_name' => 'Time Zone',
	'required' => true
);

$rules['password'] = array(
	'field_name' => 'New Password',
	'required' => false,
	'length' => array(
		'min' => $this->config->item('min_password_length', 'auth'),
		'max' => $this->config->item('max_password_length', 'auth')
	)
);

$rules['password_confirm'] = array(
	'field_name' => 'Confirm Password',
	'required' => false,
	'length' => array(
		'min' => $this->config->item('min_password_length', 'auth'),
		'max' => $this->config->item('max_password_length', 'auth')
	),
	'notEmpty' => true,
	'custom' => function ($_fieldName, $rule, $values)
	{
		if ($values[$_fieldName] == $values['password'])
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

$organizationId = $this->getUserOrganizationId();
$returnInfo = $this->Organization_Model->addNewUserToOrganization(
		$organizationId
		, $_POST['email']
		, $_POST['password']
		, "{$_POST['first_name']} {$_POST['last_name']}"
		, $_POST['timezone']
);

$json_results = array(
	'status' => true,
	'message' => 'Your form has been successfully Edited, please wait to be redirected',
	'redirect' => "/settings/organization"
);

echo json_encode($json_results);
return;