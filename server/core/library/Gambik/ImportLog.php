<?php

/*
* Deklarace hlavičky odesílané prohlížeči
*/
class ImportLog
{
	/**
	 * Vrací název logovacího souboru
	 *
	 * @return String
	 */
	private static function __logfile()
	{
		return IMP_DIRECTORY.'import.log';
	}

	/**
	 * Vymaže všechny zprávy z logu
	 *
	 */
	public static function clear()
	{
		@file_put_contents(self::__logfile(), '');
	}

	/**
	 * Zapíše text do logu
	 *
	 * @param String $text Zapisovaný text
	 */
	public static function write($text)
	{
		@file_put_contents(self::__logfile(), $text, FILE_APPEND);
	}

	/**
	 * Zapíše řádek do logu
	 *
	 * @param String $text Zapisovaný text
	 */
	public static function writeLn($text)
	{
		@file_put_contents(self::__logfile(), $text."\r\n", FILE_APPEND);
	}

	/**
	 * Zapíše chybu do logu
	 *
	 * @param Exception $err Chybový objekt
	 */
	public static function message(Exception $err, $text=NULL)
	{
		@file_put_contents(self::__logfile(), "*** CHYBA: ".$err->getMessage()." ***\n", FILE_APPEND);
	}
}