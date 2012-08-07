<?php
class Sessionjc extends MY_Controller
{

	function index()
	{
		$this->debug($this->session->userdata());
	}
	
	function sandbox()
	{
//		$user = new models\Entities\User(array('id' => 1));
//		$test = $this->em->find('models\Entities\User', array('username' => 'jdconoley'));
		$test = $this->em->getRepository('models\Entities\User');
		$test->findOneBy(array('username'=>'jdconoley'));
//		$this->debug($user);
		Doctrine\Common\Util\Debug::dump($test, 4);
		$this->debug($test->getUsername());
	}

}