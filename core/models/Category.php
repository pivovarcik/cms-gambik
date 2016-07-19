<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACategory.php");
class models_Category extends models_ACategory{

	public $linkEdit;
	function __construct()
	{
		$this->linkEdit = "category/cat";
		parent::__construct(T_CATEGORY);
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