<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

function getBrowserLanguage($availableLanguages, $default="en")
{

	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

		$langs=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

		//start going through each one
		foreach ($langs as $value){

			$choice=substr($value,0,2);
			if(in_array($choice, $availableLanguages)){
				return $choice;

			}

		}
	}
	return $default;

}
?>