<?php

/**
 * Funkce obrátí pořadí pole
 * @return array;
 */

function drupal_strlen($text) {
	global $multibyte;
	if (defined("UNICODE_MULTIBYTE") == true && $multibyte == UNICODE_MULTIBYTE) {
		return mb_strlen($text);
	}
	else {
		// Do not count UTF-8 continuation bytes.
		return strlen(preg_replace("/[\x80-\xBF]/", '', $text));
	}
}