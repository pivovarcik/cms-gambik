<?php

class DefaultSetting{

	private static $__params = NULL;

	/**
	 * Načte konfigurace
	 *
	 */
	private static function load()
	{
		$model = new models_Settings();
		$detail = $model->getSettingsList();

		//print_r($detail);

		// Napln z objektu
		/*	if (is_object($detail)) {
		   $detail = get_object_vars($detail);
		   }*/

		foreach ($detail as $property => $value) {
			self::$__params[strtolower($value->key)] = $value->value;
		}

		//	print_r(self::$__params);
	}

	/**
	 * Vrací konfigurační parametr
	 *
	 * @param string $name    Název parametru
	 * @param object $default Implicitní hodnota parametru
	 * @return object
	 */
	public static function get($name, $default=NULL)
	{
		if (! self::$__params) DefaultSetting::load();

		if (key_exists($name = strtolower($name), self::$__params))
			return self::$__params[$name];

		elseif (! is_null($default))
			return $default;

		else
			return NULL;
	}
}