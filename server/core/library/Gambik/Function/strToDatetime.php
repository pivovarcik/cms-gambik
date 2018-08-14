<?php

/**
 * Funkce odstraní mezery a převde desetinou čárku na tečku
 * @return float;
 */
function strToDatetime($string){

	if (empty($string) || trim($string) === "0000-00-00 00:00:00") {
		return NULL;
	}
	$string = date("Y-m-d H:i:s", strtotime($string));

	return $string;

}