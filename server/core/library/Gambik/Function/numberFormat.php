<?php
function numberFormat($number, $decimal = 2) {
/*
	$xsea[]=' ';
	$xrep[]='';

	$xsea[]=',';
	$xrep[]='.';

	$value = str_replace($xsea, $xrep, $number);
*/
	//&nbsp;
	$number = strToNumeric($number);

	$number = number_format($number, $decimal, ',', ' ');
	$number = str_replace(" ", " ",$number);
	return $number;
}