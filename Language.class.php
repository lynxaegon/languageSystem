<?php
/*
 * @version 1.0
 * @author Andrei Vaduva <andrei.vaduva@gmail.com>
*/
class Language
{
	private $settings;
	public function __construct($path,$render = "ini")
	{
		if( $path[strlen($path)-1] != "/" )
			$path .= "/";
		$this->settings->path = $path;
		$this->settings->render = $render;
	}
	public function load($lang,$file = "")	
	{
		$file = ($file == "")? $_SERVER['SCRIPT_FILENAME'] : $file;

		$info = pathinfo($file);
		$file =  basename($file,'.'.$info['extension']);
		$this->settings->file = $this->settings->path . $lang . "/" . $file . ".lang";
		$this->settings->language = $lang;
		
		if(file_exists($this->settings->file))
			$this->data = $this->getLanguage($this->settings->render);
		else
			return false;
		return true;
	}
	public function __get($var) 
	{ 
		if( isset($this->data->$var) )
		{
		    return $this->data->$var;
	    }
	    return new langObj();
	}
	public function getSupported()
	{
		$return = array();
		if ($handle = opendir($this->settings->path)) 
		{
	    	while (false !== ($file = readdir($handle))) 
	    	{
		        if ($file != "." && $file != "..") {
		             $return[] = $file;
		        }
		    }
		}
    	closedir($handle);
    	return $return;
	}
	private function arrayToLangObj($array) 
	{
		$return = new langObj();
		foreach ($array as $k => $v) {
			if (is_array($v)) 
				$return->$k = $this->arrayToLangObj($v);
			else 
				$return->$k = $v;
		}
		return $return;
	}
	private function xmlToLangObj($xml) {
		$tmp = get_object_vars($xml);
		$return = new langObj();
		foreach($tmp as $k => $v)
		{	
			if(is_string($v))
			{
				$return->$k = $v;
			}
			if($v instanceof SimpleXmlElement)
			{
				$return->$k = $this->xmlToLangObj($xml->$k);
			}
		}
		return $return;
	}
	private function getLanguage($render)
	{
		if($render == "ini")
				return $this->arrayToLangObj(parse_ini_file($this->settings->file,true));
		else if($render == "xml")
		{
			$xml = simplexml_load_file($this->settings->file);
			$data = $this->xmlToLangObj($xml);
			return $data;
		}
	}
}
class langObj extends stdClass
{
	public function __toString()
	{
		return "Undefined Language";
	}
	public function __get($var)
	{
		if(!isset($this->$var))
			return new langObj();
		return $this->$var;
	}
}
?>
