<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */
function gDecode($string=""){

	$posunuti=-1;
	$smer=1;
	$abeceda = '0123456789=aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ-';

	if ($smer==0){
		$string = base64_encode($string);
	}
	for($i = 0; $i < strlen($string); $i++)
	{
		$new_pos = strpos($abeceda, $string[$i]) + intval($posunuti);

		if($new_pos >= ($len = strlen($abeceda))){
			$new_pos = $new_pos - $len;
		}
		$new_str .= $abeceda[$new_pos];
	}
	if ($smer ==1){
		//$ss = (string) $new_str;
		$new_str = base64_decode($new_str);
	}
	return $new_str;
}