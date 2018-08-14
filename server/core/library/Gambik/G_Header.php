<?php

/*
* Deklarace hlavičky odesílané prohlížeči
*/
class G_Header {

  private $_headers = array();
  function __construct()
  {
    $this->setHeader('Content-type', 'text/html; charset=utf-8');
    $this->setHeader('Cache-Control', 'no-cache');
    $this->setHeader('Pragma', 'nocache');
	}
	public function setHeader($content, $value)
	{
		$this->_headers[$content] = $value;
	}

	public function getHeader($content)
	{
		return $this->_headers[$content];
	}
	
	public function render()
	{
    session_start();
		foreach($this->_headers as $key => $value)
		{
      header($key . ': ' . $value);
		}
	}
}