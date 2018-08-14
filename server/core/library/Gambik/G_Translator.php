<?php

class G_Translator {

	private static $slovnikList = array();

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
			self::$instance->prekladacInit();
			//print_R(self::$slovnikList);
		}
		return self::$instance;
	}

	public static function prelozVyraz($fraze){
		return self::prelozitFrazy($fraze);
	}
	public static function prelozitFrazy($fraze){

		if (empty($fraze)) {
			return "";
		}

	//	print USER_ROLE_ID;
		// 0 bral jako prázdné a nepřekládal to.
		if (isset(self::$slovnikList[$fraze]) && strlen(self::$slovnikList[$fraze]) > 0) {

			if (defined("USER_ROLE_ID") && USER_ROLE_ID == 2) {
			//	return '<span title="'.$fraze.'">'.self::$slovnikList[$fraze].'</span>';
			//	return self::$slovnikList[$fraze]."{" . $fraze . "}";
			}
			return self::$slovnikList[$fraze];
		}
		return "{" . $fraze . "}";

	}

	private function prekladacInit()
	{
		self::$slovnikList = array();

		$args = new ListArgs();
		$args->limit = 10000;
		$args->page = 1;
    $args->cache  = 60;
		$args->lang = LANG_TRANSLATOR;

		$controller = new models_Translator();
		$l = $controller->getList($args);
		for ($i=0;$i < count($l);$i++)
		{
			self::$slovnikList[$l[$i]->keyword] = $l[$i]->name;
		}
	}
}