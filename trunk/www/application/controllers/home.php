<?php

class Home extends MY_Controller
{

	function index()
	{
//		echo "processing image from:  ".base_url().'images/xmas.jpg';
//		$process = $this->site_model->processItemImage('/images/xmas.jpg', 'gd2', 'xmas_processed.jpg', '', 50, 50);
////		echo "test";
//		echo $this->image_lib->display_errors();
//		echo $process;
//		exit;

		$data['grid'] = $this->site_model->build_grid_for_public();
		$data['userInfoArray'] = $this->session->userdata();

		$this->load->view('page_top.php', $data);
		$this->load->view('home/home_top.php');
//		$this->load->view('home', $data);
	}

	function search()
	{
		require_once 'apiClient.php';
		require_once 'apiCustomsearchService.php';
		session_start();

		$client = new apiClient();
		$client->setApplicationName('Google CustomSearch PHP Starter Application');
		// Docs: http://code.google.com/apis/customsearch/v1/using_rest.html
		// Visit https://code.google.com/apis/console?api=customsearch to generate
		// your developer key (simple api key).
		// $client->setDeveloperKey('INSERT_your_developer_key');
		$search = new apiCustomsearchService($client);


		// Example executing a search with your custom search id.
		$result = $search->cse->listCse('burrito', array(
			'cx' => 'INSERT_SEARCH_ENGINE_ID', // The custom search engine ID to scope this search query.
				));
		print "<pre>" . print_r($result, true) . "</pre>";

		// Example executing a search with the URL of a linked custom search engine.
		$result = $search->cse->listCse('burrito', array(
			'cref' => 'http://www.google.com/cse/samples/vegetarian.xml',
				));
		print "<pre>" . print_r($result, true) . "</pre>";
	}

}