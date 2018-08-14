<?php
function numberFormatNowrap($number, $decimal = 2) {
/*
	$xsea[]=' ';
	$xrep[]='';

	$xsea[]=',';
	$xrep[]='.';

	$value = str_replace($xsea, $xrep, $number);
*/
	//&nbsp;

	$number = numberFormat($number, $decimal);

	$number = str_replace(" ", "&nbsp;",$number);
	return $number;
}