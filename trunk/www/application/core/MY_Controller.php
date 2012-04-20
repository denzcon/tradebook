<?php

class   MY_Controller extends CI_Controller
{

	/**
	 * @var Membership_model
	 */
	public $membershipModel;

	/**
	 *
	 * @var array 
	 */
	public $UserInfoArray;

	/**
	 *
	 * @var \Doctrine\ORM\EntityManager 
	 */
	public $em;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('membership_model');
		$this->membershipModel = $this->membership_model;
		$this->UserInfoArray = $this->membershipModel->getUserInfoArray();
		$this->em = $this->doctrine->em;
	}

	public static function debug()
	{
		$args = func_get_args();



		// if only a single argument was passed, use it instead of an array
		if (count($args) == 1)
		{
			$args = $args[0];
		}

//		$trace = debug_backtrace();
		$trace_string = '';
//		for ($i = sizeof($trace) - 1; $i >= 0; $i--)
//		{
//			$trace_string .= str_replace('/xamp/htdocs/', "", $trace[$i]['file']) . ": " . $trace[$i]['line'] . " -> <br/>\n";
//		}
//
//		$line = $trace[0]['line'];
//		$file = $trace[0]['file'];

		$output = "";
		$output .= '<link href="http://openstory.dev/css/prettify/sunburst.css" type="text/css" rel="stylesheet" /><script type="text/javascript" src="http://openstory.dev/js/prettify/prettify.js"></script>';
		$output .= '<script type="text/javascript">window.onload = function(){prettyPrint();}</script>';
		$output .= "<div class='debug' style='overflow: auto; margin:20px; text-align: left;'>\n"; // Inline styling sadly necessary. The css file may never load in certain debug situations.
		// file/line info:
		$output .= "<div class='file_info' style=''>$trace_string</div>"; // ie '/var/www/dev_brian/includes/view_packages.inc.php (line 340)'
		// dump the input
		$output .= '<pre class="prettyprint linenums">';
		ob_start();
		var_dump($args);
		$dump_output = ob_get_clean();
		$output .= preg_replace('/\=\>\n/', ' => ', $dump_output);
		$output .= "</pre>";
		$output .= "\n</div>\n";
		echo $output;
	}

	/**
	 *
	 * @param string $url
	 * @param string $post
	 * @param string $retries
	 * @return array 
	 */
	function CURL($url, $post = null, $retries = 3)
	{
		$curl = curl_init($url);
		if (is_resource($curl) === true)
		{
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_ENCODING, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Encoding: gzip,deflate'));
			if (null != $post)
			{
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($post) === true) ? http_build_query($post, '', '&') : $post);
			}
			$result = false;
			while (($result === false) && (--$retries > 0))
			{
				$result = curl_exec($curl);
				$response = curl_getinfo($curl);
			}
			curl_close($curl);
		}
		switch ($response['http_code'])
		{
			case 200:
				$return = array(
					'response' => $response,
					'output' => $result
				);
				break;
			case 301:
			case 302:
				foreach (get_headers($response['url']) as $value)
				{
					if (substr(strtolower($value), 0, 9) == "location:")
					{
						return self::CURL(trim(substr($value, 9, strlen($value))));
					}
				}
				break;
			default:
				$return = false;
				break;
		}
		return $return;
	}

	/**
	 * this function fwrites out debug info
	 *
	 * @param mixed $input - the data to be dumped
	 * @param int $backtrace_depth - not yet implemented
	 * @param array $options - additional options such as dataType
	 */
	function fdebug($input, $backtrace_depth = 0, $options = array())
	{

		$trace = debug_backtrace();

		for ($i = sizeof($trace) - 1; $i >= 0; $i--)
		{
			$trace_string .= str_replace($GLOBALS['system_path'], "", $trace[$i]['file']) . ": " . $trace[$i]['line'] . " ->\n";
		}
		ob_start();
		print_r($trace_string);
		print_r($input);
		print("\n");
		$dump = ob_get_clean();

		$fp = fopen('/tmp/debug.log', 'a');
		fwrite($fp, $dump);
		fwrite($fp, "\n");
		fclose($fp);
	}

}
