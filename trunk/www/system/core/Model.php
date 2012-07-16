<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
* CodeIgniter Model Class
*
* @package		CodeIgniter
* @subpackage	Libraries
* @category	Libraries
* @author		ExpressionEngine Dev Team
* @link		http://codeigniter.com/user_guide/libraries/config.html 
* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
* @property CI_Config $config
* @property CI_Loader $load
* @property CI_Session $session
*/
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
	public static function debug()
	{
		$args = func_get_args();
		// if only a single argument was passed, use it instead of an array
		if (count($args) == 1)
		{
			$args = $args[0];
		}
		$trace = debug_backtrace();
		$trace_string = '';
		for ($i = sizeof($trace) - 1; $i >= 0; $i--)
		{
			if(isset($trace[$i]['file']))
			{
				$trace_string .= str_replace('/xamp/htdocs/', "", isset($trace[$i]['file'])? $trace[$i]['file'] : $trace[$i]['class']) . ": " .$trace[$i]['line'] . " -> <br/>\n";
			}
		}

		$line = $trace[0]['line'];
		$file = $trace[0]['file'];
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
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */