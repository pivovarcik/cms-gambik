<?php

/**
 * Funkce převede string na vaildní url
 * @return string;
 */
function strToUrl($string)
{
//	$string = strtolower(trim($string));
	$string = (trim($string));
	$string = mb_strtolower($string, 'UTF-8');
	//	return title2url($string);
	// odstraní html značky
	$string = strip_tags($string);
	// odstraní počáteční a konečnou mezeru
	$string = trim($string);
	// odstraní interpunkci
	$string = utfx($string);
	$string = str_replace('–', '-', $string);
	$string = str_replace(' ', '-', $string);
	//	$string = str_replace('_', '-', $string);
	$string = str_replace('+', '-', $string);
	$string = str_replace('?', '-', $string);
	$string = str_replace('!', '', $string);
	$string = str_replace('/', '-', $string);
	$string = str_replace('.', '', $string);
	$string = str_replace('"', '', $string);
	$string = str_replace("'", '', $string);
	$string = str_replace(',', '-', $string);
	$string = str_replace('%', '-', $string);
	$string = str_replace('(', '-', $string);
	$string = str_replace(')', '-', $string);
	$string = str_replace('¨', '-', $string);

	$string = str_replace('*', '-', $string);
	$string = str_replace('´', '', $string);
	$string = str_replace(':', '', $string);
	$string = str_replace('&', '-', $string);


	// pocetacne Hashtag nechám
	$string =  substr($string,0,1) . str_replace('#', '-', substr($string,1,strlen($string)));

	$string = preg_replace('[^0-9a-z\-]', '', $string);

	/*
	   $string = str_replace('ů', 'u', $string);
	   $string = str_replace('ď', 'd', $string);
	   $string = str_replace('í', 'i', $string);
	   $string = str_replace('ř', 'r', $string);
	   $string = str_replace('á', 'a', $string);

	   $string = str_replace('ý', 'y', $string);
	   $string = str_replace('š', 's', $string);
	   $string = str_replace('ě', 'e', $string);
	   $string = str_replace('é', 'e', $string);
	   $string = str_replace('ó', 'o', $string);
	   $string = str_replace('ó', 'o', $string);
	   $string = str_replace('ť', 't', $string);
	   $string = str_replace('č', 'c', $string);
	   $string = str_replace('ý', 'y', $string);
	   $string = str_replace('ž', 'z', $string);
	*/

	// odstrani ze zacatku a z konce retezce pomlcky
	$string = trim ($string, "-");

	// odstrani z adresy pomlcky, pokud jsou dve a vice vedle sebe
	$re = "/[-]+/";
	$replacement = "-";
	$string = preg_replace ($re, $replacement, $string);
	//$string = strtolower($string);

	//	$string = title2url($string);
	$string = strtolower(trim(($string)));
	//	$string = strtolower(trim(urlencode($string)));

	return $string;
}



function title2url($string=null){
	// return if empty
	if(empty($string)) return false;

	// replace spaces by "-"
	// convert accents to html entities
	$string=htmlentities(utf8_decode(str_replace(' ', '-', $string)));

	// remove the accent from the letter
	$string=preg_replace(array('@&([a-zA-Z]){1,2}(acute|grave|circ|tilde|uml|ring|elig|zlig|slash|cedil|strok|lig){1};@', '@&[euro]{1};@'), array('${1}', 'E'), $string);

	// now, everything but alphanumeric and -_ can be removed
	// aso remove double dashes
	$string=preg_replace(array('@[^a-zA-Z0-9\-_]@', '@[\-]{2,}@'), array('', '-'), html_entity_decode($string));

	return $string;
}
