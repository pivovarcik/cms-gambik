<?php

/**
 * Funkce obrátí pořadí pole
 * @return array;
 */

function truncateUtf8($string, $len, $wordsafe = FALSE, $dots = FALSE) {

	if (drupal_strlen($string) <= $len) {
		return $string;
	}

	if ($dots) {
		$len -= 4;
	}

	if ($wordsafe) {
		$string = drupal_substr($string, 0, $len + 1); // leave one more character
		if ($last_space = strrpos($string, ' ')) { // space exists AND is not on position 0
			$string = substr($string, 0, $last_space);
		}
		else {
			$string = drupal_substr($string, 0, $len);
		}
	}
	else {
		$string = drupal_substr($string, 0, $len);
	}

	if ($dots) {
		$string .= ' ...';
	}

	return $string;
}