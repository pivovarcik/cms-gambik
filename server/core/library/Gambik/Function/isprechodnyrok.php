<?php

/**
 * Funkce vrací true jedná-li se o přechodný rok.
 * @return string
 */
function isPrechodnyRok ($year = null)
{
	if (is_null($year)) {
		$year = date("Y");
	}
	return (boolean) date("L", mktime(0,0,0,1,1,$year));
}