<?php
function numberFormatMena($number, $decimal = null, $menaPred = false) {

if (is_null($number))
{
  $decimal = round($number - round($number),2) < 0.09 ? 0 : 2;
}


/*
	$xsea[]=' ';
	$xrep[]='';

	$xsea[]=',';
	$xrep[]='.';

	$value = str_replace($xsea, $xrep, $number);
*/
	//&nbsp;

	$kurz = 1;
	//PRINT LANG_KURZ;
	if (defined("LANG_KURZ")) {
		$kurz = (LANG_KURZ) * 1;
	}
//	print $kurz;
	$number = strToNumeric($number);
	$number = $number / $kurz;

	$mena = "";
	if (defined("LANG_CURRENCY")) {
		$mena = LANG_CURRENCY;
	}

	if (empty($mena)) {
		$mena = "Kč";
	}
  $res = "";
  if ($menaPred)
  {
     $res .= $mena . '&nbsp;';
  }
  
  $res .= numberFormatNowrap($number,$decimal);
  if (!$menaPred)
  {
     $res .= '&nbsp;'  . $mena;
  }  
  
  return $res;
//	return numberFormatNowrap($number,$decimal) . '&nbsp;'  . $mena;
}