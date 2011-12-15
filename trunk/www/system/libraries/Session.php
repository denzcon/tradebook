<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Session
{

	var $flash_key = 'flash'; // prefix for "flash" variables (eg. flash:new:message)

	function __construct()
	{
		$this->_sess_run();
	}

	/**
	 * Destroys the session and erases session storage
	 */
	function destroy()
	{
		unset($_SESSION);
		if (isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(), '', time() - 42000, '/');
		}
		session_destroy();
	}

	/**
	 * Reads given session attribute value
	 */
	function userdata($item = null)
	{
		if($item == null)
		{
			return $_SESSION;
		}
		else
		{
			return (!isset($_SESSION[$item])) ? false : $_SESSION[$item];
		}
	}

	/**
	 * Sets session attributes to the given values
	 */
	function set_userdata($newdata = array(), $newval = '')
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$_SESSION[$key] = $val;
			}
		}
	}

	/**
	 * Erases given session attributes
	 */
	function unset_userdata($newdata = array())
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => '');
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				unset($_SESSION[$key]);
			}
		}
	}

	/**
	 * Starts up the session system for current request
	 */
	function _sess_run()
	{
		session_start();

		// delete old flashdata (from last request)
		$this->_flashdata_sweep();

		// mark all new flashdata as old (data will be deleted before next request)
		$this->_flashdata_mark();
	}

	/**
	 * Sets "flash" data which will be available only in next request (then it will
	 * be deleted from session). You can use it to implement "Save succeeded" messages
	 * after redirect.
	 */
	function set_flashdata($key, $value)
	{
		$flash_key = $this->flash_key . ':new:' . $key;
		$this->set_userdata($flash_key, $value);
	}

	/**
	 * Keeps existing "flash" data available to next request.
	 */
	function keep_flashdata($key)
	{
		$old_flash_key = $this->flash_key . ':old:' . $key;
		$value = $this->userdata($old_flash_key);

		$new_flash_key = $this->flash_key . ':new:' . $key;
		$this->set_userdata($new_flash_key, $value);
	}

	/**
	 * Returns "flash" data for the given key.
	 */
	function flashdata($key)
	{
		$flash_key = $this->flash_key . ':old:' . $key;
		return $this->userdata($flash_key);
	}

	/**
	 * PRIVATE: Internal method - marks "flash" session attributes as 'old'
	 */
	function _flashdata_mark()
	{
		foreach ($_SESSION as $name => $value)
		{
			$parts = explode(':new:', $name);
			if (is_array($parts) && count($parts) == 2)
			{
				$new_name = $this->flash_key . ':old:' . $parts[1];
				$this->set_userdata($new_name, $value);
				$this->unset_userdata($name);
			}
		}
	}

	/**
	 * PRIVATE: Internal method - removes "flash" session marked as 'old'
	 */
	function _flashdata_sweep()
	{
		foreach ($_SESSION as $name => $value)
		{
			$parts = explode(':old:', $name);
			if (is_array($parts) && count($parts) == 2 && $parts[0] == $this->flash_key)
			{
				$this->unset_userdata($name);
			}
		}
	}

}