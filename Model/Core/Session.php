<?php

class Model_Core_Session
{
	public function start()
	{
		if(!isset($_SESSION)){
		session_start();
		}
		return $this;	
	}

	public function destroy()	
	{
		session_destroy();
		return $this;
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
		return $this;
	}

	public function get($key)
	{
		if (!array_key_exists($key, $_SESSION)) {
			$_SESSION[$key] = null;
		}
		return $_SESSION[$key];
	}


	public function unset($key)
	{
		if (array_key_exists($key, $_SESSION)) {
			unset($_SESSION[$key]);
		}
	}

	public function has($key)
	{
		if(array_key_exists($key, $_SESSION))
		{
			return true;
		}

		return false;
	}
}

?>