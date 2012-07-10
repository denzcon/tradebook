<?php
/**
 * The Google_api (wrapper)  is the central access point to GoogleAPI functionality here on tradebook.
 *
 * @since   2.0
 * @author  Jonatan Conoley <jonathan@pixelmegood.com>
 */
class Google_api extends CI_Model
{
	/**
	 *
	 * @var string 
	 */
	private $google_shopping_search_api_key = "AIzaSyAySuFAOmi99yabjRlYEvssJnLHQUUBNmw";
	
	/**
	 * 
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 *
	 * @return string 
	 */
	public function getGoogleShoppingSearchApiKey()
	{
		return $this->google_shopping_search_api_key;
	}
	
	/**
	 *
	 * @param string $search_string // i.e.    warm+sweater
	 * @param string $key // AIzaSyAySuFAOmi99yabjRlYEvssJnLHQUUBNmw
	 * @param integer $index // used for paging index=1 if you want to start at first result and should increment in accordance with your max results value
	 * @param integer $max_results // max reults returned in the data object
	 * @param string $api_name // the name of the api you are calling, will usually be "shopping"
	 * @return string // https://code.google.com/api..... 
	 */
	public function buildShoppingUrl($search_string="warm+sweater", $key, $index, $max_results, $api_name= shopping)
	{
		return "https://www.googleapis.com/".$api_name."/search/v1/public/products?key=".$this->google_shopping_search_api_key."&country=US&q=".$search_string."&startIndex=".$index."&maxResults=".$max_results;
	}
}