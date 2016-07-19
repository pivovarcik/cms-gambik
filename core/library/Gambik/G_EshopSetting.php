<?php

class G_EshopSetting {

	private static $settings = array();

	private static $instance;
	// Prevent this class from being directly instantiated externally.
	private function __construct() {}
	private function __clone() {}

	public static function instance()
	{
		if( !isset( self::$instance ) )
		{
			$c = __CLASS__;
			self::$instance = new $c();
			self::$instance->init();
			//print_R(self::$slovnikList);
		}
		return self::$instance;
	}

	public static function get($fraze){

		if (empty($fraze)) {
			return false;
		}

		// 0 bral jako prázdné a nepřekládal to.
		if (isset(self::$settings[$fraze]) && strlen(self::$settings[$fraze]) > 0) {
			return self::$settings[$fraze];
		}
		return false;
	}

	private function init()
	{
		self::$settings = array();

		$model = new models_Eshop();
		$res =$model->getSettingsList();
		for ($i=0;$i<count($res);$i++)
		{
			self::$settings[$res[$i]->key]= $res[$i]->value;
		}

		//print_r(self::$settings);

	}
}