<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\Common\Util;

/**
 * Static class containing most used debug methods.
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Giorgio Sironi <piccoloprincipeazzurro@gmail.com>
 */
final class Debug
{

	/**
	 * Private constructor (prevents from instantiation)
	 *
	 */
	private function __construct()
	{
		
	}

	/**
	 * Prints a dump of the public, protected and private properties of $var.
	 *
	 * @static
	 * @link http://xdebug.org/
	 * @param mixed $var
	 * @param integer $maxDepth Maximum nesting level for object properties
	 * @param boolean $stripTags Flag that indicate if output should strip HTML tags
	 */
	public static function dump($var, $maxDepth = 2, $stripTags = true)
	{
		ini_set('html_errors', 'On');

		if (extension_loaded('xdebug'))
		{
			ini_set('xdebug.var_display_max_depth', $maxDepth);
		}

		$var = self::export($var, $maxDepth++);

		ob_start();
		var_dump($var);
		$dump = ob_get_contents();
		ob_end_clean();
		\Doctrine\Common\Util\Debug::debug($dump);

//		echo ($stripTags ? strip_tags(html_entity_decode($dump)) : $dump);

		ini_set('html_errors', 'Off');
	}

	public static function export($var, $maxDepth)
	{
		$return = null;
		$isObj = is_object($var);

		if ($isObj && in_array('Doctrine\Common\Collections\Collection', class_implements($var)))
		{
			$var = $var->toArray();
		}

		if ($maxDepth)
		{
			if (is_array($var))
			{
				$return = array();

				foreach ($var as $k => $v)
				{
					$return[$k] = self::export($v, $maxDepth - 1);
				}
			}
			else if ($isObj)
			{
				$return = new \stdclass();
				if ($var instanceof \DateTime)
				{
					$return->__CLASS__ = "DateTime";
					$return->date = $var->format('c');
					$return->timezone = $var->getTimeZone()->getName();
				}
				else
				{
					$reflClass = ClassUtils::newReflectionObject($var);
					$return->__CLASS__ = ClassUtils::getClass($var);

					if ($var instanceof \Doctrine\Common\Persistence\Proxy)
					{
						$return->__IS_PROXY__ = true;
						$return->__PROXY_INITIALIZED__ = $var->__isInitialized();
					}

					foreach ($reflClass->getProperties() as $reflProperty)
					{
						$name = $reflProperty->getName();

						$reflProperty->setAccessible(true);
						$return->$name = self::export($reflProperty->getValue($var), $maxDepth - 1);
					}
				}
			}
			else
			{
				$return = $var;
			}
		}
		else
		{
			$return = is_object($var) ? get_class($var) : (is_array($var) ? 'Array(' . count($var) . ')' : $var);
		}

		return $return;
	}

	public static function toString($obj)
	{
		return method_exists('__toString', $obj) ? (string) $obj : get_class($obj) . '@' . spl_object_hash($obj);
	}

	/**
	 * this function prettily prints out debug info, in that it displays the file and line number and dumps the input wrapped in <pre>
	 *
	 * @param mixed $input - the data to be dumped
	 * @param int $backtrace_depth - the depth of scope of the file name and number to be output.  ie if function Foo() calls debug(), but the desired file and line number are from wherever Foo() was called, the depth should be 1.
	 * @param array $options - additional options such as dataType
	 */
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
		$output .= '<link href="' . base_url() . 'css/prettify/sunburst.css" type="text/css" rel="stylesheet" /><script type="text/javascript" src="http://openstory.dev/js/prettify/prettify.js"></script>';
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
