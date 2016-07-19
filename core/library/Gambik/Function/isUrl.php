<?php

/**
 * Funkce vrací true, jedná-li se o url adresu
 * @return bool;
 */
function isUrl($url)
{
//	if (preg_match('^http(s):\/\/[[:alnum:]]+([-_\.]?[[:alnum:]])*\.[[:alpha:]]{2,6}(\/{1}[-_ ~&=\?\.a-z0-9]*)*$', $url)) {
	if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url)) {

	 	return true;
	}
	return false;
}