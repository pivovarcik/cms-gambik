<?php

/**
 * Funkce odstraní mezery a převde desetinou čárku na tečku
 * @return float;
 */
function gDate($string,$format = "j.n.Y H:i"){

	if (empty($string) || trim($string) === "0000-00-00 00:00:00") {
		return NULL;
	}
	$string = date($format, strtotime($string));

	return $string;

}