<?php

class ImportManagerLog
{
	/**
	 * Vrac� n�zev logovac�ho souboru
	 *
	 * @return String
	 */
	private static function __logfile()
	{
		return IMP_DIRECTORY.'manager.log';
	}




	/**
	 * Vyma�e v�echny zpr�vy z logu
	 *
	 */
	public static function getStatus()
	{
		//@file_put_contents(self::__logfile(), '');
		if (!file_exists(self::__logfile())) {
			ImportManagerLog::clear();
		}
		$file = file_get_contents(self::__logfile(),FILE_USE_INCLUDE_PATH);
		return $file;
	}

	/**
	 * Vyma�e v�echny zpr�vy z logu
	 *
	 */
	public static function clear()
	{
		@file_put_contents(self::__logfile(), '');
	}

	/**
	 * Zap�e text do logu
	 *
	 * @param String $text Zapisovan� text
	 */
	public static function write($text)
	{
		ImportManagerLog::clear();
		@file_put_contents(self::__logfile(), $text, FILE_APPEND);
	}

	/**
	 * Zap�e text do logu
	 *
	 * @param String $text Zapisovan� text
	 */
	public static function setStatus($status)
	{
		ImportManagerLog::clear();
		@file_put_contents(self::__logfile(), $status, FILE_APPEND);
	}

}

?>