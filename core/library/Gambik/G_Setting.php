<?php

class G_Setting {

	private static $settings = array();
	private static $logo_file = "";
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


	public static function getLogoFile(){

		return self::$logo_file;
	}

	private function init()
	{
		self::$settings = array();

		$model = new models_Settings();
		$res =$model->getSettingsList();
		for ($i=0;$i<count($res);$i++)
		{
			self::$settings[$res[$i]->key]= $res[$i]->value;
		}


		$logo_id = self::$settings["LOGO_FILE_ID"];
		//print_r($form->page);
		//print $logo_id;
		if ($logo_id > 0) {
			$fotoController = new FotoController();
			$fotoDetail = $fotoController->getFoto($logo_id);
			//$imageController = new ImageController();

			if (!empty($fotoDetail->file)) {

				self::$logo_file = $fotoDetail->file;

			}
		}

		//print_r(self::$settings);

	}
}