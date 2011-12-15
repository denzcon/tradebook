<?php
require_once 'includes/config.inc.php';
require_once 'models/site.model.php';
define(DEVELOPMENT_ENVIRONMENT, true);
function setReporting() {
if (DEVELOPMENT_ENVIRONMENT == true) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
}
}

//exit;
$user_id = 1;
if(isset($_GET['url'])) 
{
	$url = explode('/', $_GET['url']);
	$controller = $url[0];
	$view = $url[1];
}
else
{
	$controller= 'home';
}

switch ($controller)
{
	case 'user':
		$page = 'user';
		break;


	default:
		$page = $controller;
		break;
}

include 'view/page_head_incl.phtml';
include 'view/header_menu_nav.phtml';

//echo "<pre>url";
//print_r($url);
//echo "</pre>";

//exit;
//exit;
include $controller.'.php';
//include 'view/footer.phtml';