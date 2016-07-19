<?php

/**
 * Funkce vrací true, jedná-li se o emailovou adresu
 * @return bool;
 */
function isEmpty($value)
{

	if (empty($value) ) {
		if ($value == "0") {
			return false;
		}
		return true;
	}
	return false;
}