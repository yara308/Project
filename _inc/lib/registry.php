<?php
/*
| -----------------------------------------------------
| PRODUCT NAME: 	Onzwo
| -----------------------------------------------------
| AUTHOR:			ONZWO.COM
| -----------------------------------------------------
| EMAIL:			info@ONZWO.COM
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY ONZWO.COM
| -----------------------------------------------------
| WEBSITE:			http://ONZWO.COM
| -----------------------------------------------------
*/
final class Registry 
{
	private $data = array();

	public function get($key) 
	{
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}

	public function set($key, $value) 
	{
		$this->data[$key] = $value;
	}

	public function has($key) 
	{
		return isset($this->data[$key]);
	}
}