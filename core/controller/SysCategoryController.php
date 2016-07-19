<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */
require_once("CategoryController.php");






class SysCategoryController extends CategoryController
{
	function __construct()
	{
		$this->formEditName = "SysCategoryEdit";
		parent::__construct("SysCategory", "SysCategoryVersion");
	//	self::$isVersioning = (VERSION_CATEGORY == 1) ? true : false;
		self::$isVersioning = true;
	}
}