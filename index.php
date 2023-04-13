<?php
error_reporting(E_ALL);
define("DS", DIRECTORY_SEPARATOR);

spl_autoload_register(function ($className) {
    $classPath = str_replace('_', '/', $className);
	require_once "{$classPath}.php";
});	


class Ccc
{
	public static function init()
	{
		$front = new Controller_Core_Front();
		$front->init();
	}

	public static function getModel($className)
	{
		$className = 'Model_'.$className;
		return new $className();
	}

	public static function register($key, $value)
	{
		$GLOBALS[$key] = $value;
	}
	public static function getRegistry($key)
	{
		if (array_key_exists($key, $GLOBALS)) {
			return $GLOBALS[$key];
		}
		return null;
	}
}
Ccc::init();


?>