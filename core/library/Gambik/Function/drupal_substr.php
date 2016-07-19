<?php

/**
 * Funkce obrátí pořadí pole
 * @return array;
 */

function drupal_substr($text, $start, $length = NULL) {
	global $multibyte;
	if (defined("UNICODE_MULTIBYTE") == true && $multibyte == UNICODE_MULTIBYTE) {
		return $length === NULL ? mb_substr($text, $start) : mb_substr($text, $start, $length);
	}
	else {
		$strlen = strlen($text);
		// Find the starting byte offset
		$bytes = 0;
		if ($start > 0) {
			// Count all the continuation bytes from the start until we have found
			// $start characters
			$bytes = -1;
			$chars = -1;
			while ($bytes < $strlen && $chars < $start) {
				$bytes++;
				$c = ord($text[$bytes]);
				if ($c < 0x80 || $c >= 0xC0) {
					$chars++;
				}
			}
		}
		else if ($start < 0) {
			// Count all the continuation bytes from the end until we have found
			// abs($start) characters
			$start = abs($start);
			$bytes = $strlen;
			$chars = 0;
			while ($bytes > 0 && $chars < $start) {
				$bytes--;
				$c = ord($text[$bytes]);
				if ($c < 0x80 || $c >= 0xC0) {
					$chars++;
				}
			}
		}
		$istart = $bytes;

		// Find the ending byte offset
		if ($length === NULL) {
			$bytes = $strlen - 1;
		}
		else if ($length > 0) {
			// Count all the continuation bytes from the starting index until we have
			// found $length + 1 characters. Then backtrack one byte.
			$bytes = $istart;
			$chars = 0;
			while ($bytes < $strlen && $chars < $length) {
				$bytes++;
				$c = ord($text[$bytes]);
				if ($c < 0x80 || $c >= 0xC0) {
					$chars++;
				}
			}
			$bytes--;
		}
		else if ($length < 0) {
			// Count all the continuation bytes from the end until we have found
			// abs($length) characters
			$length = abs($length);
			$bytes = $strlen - 1;
			$chars = 0;
			while ($bytes >= 0 && $chars < $length) {
				$c = ord($text[$bytes]);
				if ($c < 0x80 || $c >= 0xC0) {
					$chars++;
				}
				$bytes--;
			}
		}
		$iend = $bytes;

		return substr($text, $istart, max(0, $iend - $istart + 1));
	}
}