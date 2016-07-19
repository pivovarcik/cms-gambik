<?php

/**
 * Funkce obrátí pořadí pole
 * @return array;
 */

function arrayReversed($array){
	$array = array_reverse($array);
	ksort($array);
	return($array);
}