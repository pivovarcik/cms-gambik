<?php

class ImportIteratorLog
{
	/**
	 * Vrací název logovacího souboru
	 *
	 * @return String
	 */
	private static function __logfile()
	{
		return IMP_DIRECTORY.'iterator.log';
	}




	/**
	 * Vymaže všechny zprávy z logu
	 *
	 */
	public static function getLastIndex()
	{
		//@file_put_contents(self::__logfile(), '');
		if (!file_exists(self::__logfile())) {
			ImportIteratorLog::clear();
		}
		$file = file_get_contents(self::__logfile(),FILE_USE_INCLUDE_PATH);

		return $file;

		//$file = readfile(self::__logfile());
		//return $file;

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
		ImportIteratorLog::clear();
		@file_put_contents(self::__logfile(), $text, FILE_APPEND);
	}
}

?>