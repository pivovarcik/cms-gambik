<?php

/**
 * Funkce převede string na vaildní url
 * @return string;
 */
function url_friendly($string)
{
	$string = strip_tags($string);
	$string = utfx($string);
	$string = str_replace(' ', '-', $string);
//	$string = eregi_replace('[^0-9a-z\-]', '', $string);
	$string = preg_replace('[^0-9a-z\-]', '', $string);

	// odstrani ze zacatku a z konce retezce pomlcky
	$string = trim ($string, "-");

	// odstrani z adresy pomlcky, pokud jsou dve a vice vedle sebe
	$re = "/[-]+/";
	$replacement = "-";
	$string = preg_replace ($re, $replacement, $string);
	//$string = strtolower($string);

	$string = trim(urlencode($string));

	return $string;
}