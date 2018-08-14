<?php

/**
 * Funkce vrací velikost v jednotkách
 * @return string;
 */

function sizeFormat($size)
{
	if($size<1024)
	{
		return numberFormat($size)." bytes";
	}
	else if($size<(1024*1024))
	{
		$size=numberFormat(round($size/1024,2));
		return $size." KB";
	}
	else if($size<(1024*1024*1024))
	{
		$size=numberFormat(round($size/(1024*1024),2));
		return $size." MB";
	}
	else
	{
		$size=numberFormat(round($size/(1024*1024*1024),2));
		return $size." GB";
	}

}