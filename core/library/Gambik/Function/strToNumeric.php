<?php

/**
 * Funkce odstraní mezery a převde desetinou čárku na tečku
 * @return float;
 */
function strToNumeric($string){
	$xsea[]=' ';
	$xrep[]='';

	$xsea[]=',';
	$xrep[]='.';

	$xsea[]='&nbsp;';
	$xrep[]='';


	if (is_string($string)) {
		$string = str_replace($xsea, $xrep, $string);

		$string = 1 * $string;
	}

	return $string;

}