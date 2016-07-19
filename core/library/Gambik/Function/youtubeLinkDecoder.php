<?php

/**
 * Funkce obrátí pořadí pole
 * @return array;
 */

function youtubeLinkDecoder($link){
	$result = array();

	if (strlen($link) == 11) {
		$result["id"] = $link;
	}
	$parseUrl = parse_url($link);

	$queryArray = explode("&",$parseUrl["query"]);

	foreach ($queryArray as $key => $val) {

		//	print substr($val,0,2);
		if (substr($val,0,2) == "v=") {
			$result["id"] = substr($val,2,strlen($val));
			break;
		}
	}


	return $result;
}