<?php 

class Model_Core_Log 
{
	const DIR_PATH = "var";
	protected $handler = null;

	public function open($filename)
	{
		$filename = Ccc::getBasedir(DS.self::DIR_PATH).DS.$filename;
		$this->handler = fopen($filename, 'a');	
		// print_r($this->handler);

	}

	public function close()
	{
		fclose($this->handler);
		
	}

	public function write($data)
	{
		fwrite($this->handler, date('Y-m-d H-i-s')." : ".print_r($data, true)."\n\n");
		
	}


	public function log($data, $fileName = 'system.log', $newFile = false)
	{
		$this->open($fileName);
		$this->write($data);
		$this->close();
	}
}