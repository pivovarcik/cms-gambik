<?php


function getResultMessage()
{
	if(empty($_SESSION["statusmessage"]))
	{
		return;
	}

	if(isset($_SESSION["classmessage"]))
	{
		$class = ' class="' . $_SESSION["classmessage"] . '"';
	}

	$print = '<p' . $class . '>' . $_SESSION["statusmessage"] . '</p>';
	$_SESSION["statusmessage"]="";
	$_SESSION["classmessage"]="";
	return $print;
}

?>