<?php

/**
 * Funkce vrací true, jedná-li se o emailovou adresu
 * @return bool;
 */
function isEmail($email)
{
	//preg_match('/^.+@.+\\..+$/', $value);

	//return preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/", $email);

	//yahoo.co.uk - neprocházela emailová adresa
	return preg_match('/^([_a-zA-Z0-9\.\-]+@[_a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4})$/', $email);
}