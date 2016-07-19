<?php

/**
 * Funkce odstraní interpunkci a převede do latinky
 * @return int
 */
function textFix($s)
{
	unset($xsea);
	unset($xrep);

	unset($xsea);
	unset($xrep);

	$xsea[]=' & ';
	$xrep[]=' &amp; ';

	$xsea[]='"';
	$xrep[]='&quot;';


	return str_replace($xsea, $xrep, $s);
}