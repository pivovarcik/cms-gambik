<?php
/**
 * Funkce vrací true, jedná-li se o mobilní zařízení
 * @return bool;
 */
function isMobile($browser = null)
{
	if ($browser == null) {
		$browser = $_SERVER["HTTP_USER_AGENT"];
	}
	// funkcí ERegI zjistím výskyt některé části řídícího řetězce
	// v řetězci identifikace prohlížeče
	/*	*/
	/*
	$ret = ERegI(QuoteMeta("UP.LINK|MIDP|UP.BROWSER|NOKIA|MOT|SEC-".
	   "|WAP|ERICSSON|SAMSUNG|SIE-|PHONE|PANASONIC|SYMBOS".
	   "|MITSU|LG|PORTALMMM|BLACKBERRY|SYMBIAN|PHILIPS".
	   "|SENDO|KLONDIKE|SAGEM|MOBILE|ALCATEL|SONY|ANDROID"),
	   $browser);
*/
	/*
	   $ret = 	preg_match(QuoteMeta("UP.LINK|MIDP|UP.BROWSER|NOKIA|MOT|SEC-".
	   "|WAP|ERICSSON|SAMSUNG|SIE-|PHONE|PANASONIC".
	   "|MITSU|LG|PORTALMMM|BLACKBERRY|SYMBIAN|PHILIPS".
	   "|SENDO|KLONDIKE|SAGEM|MOBILE|ALCATEL|SONY"),
	   $_SERVER["HTTP_USER_AGENT"]);
	*/

	$ret = preg_match(QuoteMeta("~UP.LINK|MIDP|UP.BROWSER|NOKIA|MOT|SEC-".
		"|WAP|ERICSSON|SAMSUNG|SIE-|PHONE|PANASONIC|SYMBOS".
		"|MITSU|LG|PORTALMMM|BLACKBERRY|SYMBIAN|PHILIPS".
		"|SENDO|KLONDIKE|SAGEM|MOBILE|ALCATEL|SONY|ANDROID~i"),
		$browser);

	// vrácení návratové hodnoty
	return $ret;
}