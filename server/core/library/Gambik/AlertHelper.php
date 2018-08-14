<?php

class AlertHelper {

	private $allowedClass = array("danger","warning","info","success");
	static function alert($alert,$class = "info")
	{
		$res = '<div role="alert" class="alert alert-' . $class . '">' . $alert . '</div>';
		return $res;
	}
}

?>