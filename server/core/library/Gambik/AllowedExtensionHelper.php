<?php

class AllowedExtensionHelper{
	static function get($string) {
		$whiteList = explode(",",$string);
		$whiteList2 = array();
		foreach ($whiteList as $key => $extension) {
			array_push($whiteList2, "*.".$extension);
		}
		return implode(";",$whiteList2 );
	}
}
