<?php

if($this->site_model->is_logged_in())
{
$user_info = $this->session->all_userdata();
define('USER_USERNAME',			$user_info['user_info']['username']);
define('USER_EMAIL_ADDRESS',	$user_info['user_info']['email_address']);
define('USER_FIRST_NAME',		$user_info['user_info']['first_name']);
define('USER_LAST_NAME',		$user_info['user_info']['last_name']);
define('USER_USER_ID',			$user_info['user_info']['id']);
}

?>
<!DOCTYPE html>
<html>
    <head>
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/twitter.bootstrap.min.css" />
		<link href="<?php echo base_url(); ?>css/tradebook_core.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-buttons.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-modal.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-dropdown.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/tradebook_core.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Welcome to tradebook</title>
    </head>
<body>