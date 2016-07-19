<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACategory.php");
class models_SysCategory extends models_ACategory{

	public $linkEdit;
	function __construct()
	{
		$this->linkEdit = "syscategory/syscat";
		parent::__construct(T_SYSCATEGORY);
	}

	public function levelDown($page_id)
	{
		parent::levelDown($page_id);
		$this->generateCategoryTree();
	}

	public function levelUp($page_id)
	{
		parent::levelUp($page_id);
		$this->generateCategoryTree();
	}
}