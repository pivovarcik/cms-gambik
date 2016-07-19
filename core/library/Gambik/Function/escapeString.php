<?php

/**
 * Funkce proti SQL Injection
 * @return array;
 */

function escapeString($string){

	$string = mysql_real_escape_string($string);
	return $string;
}