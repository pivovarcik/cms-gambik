<?php

/**
 * Funkce vrací true, jedná-li se o url adresu
 * @return bool;
 */
function isNumeric($val)
{
	//print $val * 1;
	if (is_numeric($val) && $val * 1 == $val) {
		return true;
	}
	return false;
	//return preg_match('^http(s):\/\/[[:alnum:]]+([-_\.]?[[:alnum:]])*\.[[:alpha:]]{2,6}(\/{1}[-_ ~&=\?\.a-z0-9]*)*$', $url);

}