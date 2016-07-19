<?php
require_once("G_Controller_Action.php");
class PageController extends G_Controller_Action {

	public static $model;

	function __construct($TPageModel)
	{

		if (empty($TPageModel)) {

			print get_parent_class($this) . " - chybí parametry v konstruktoru!";
			return false;
		}

		$name = "models_" . $TPageModel;
		self::$model = new $name;
		parent::__construct();
	}
	public function getNewItemLink()
	{

		return $this->link_add;
	}

	public function getTableName()
	{
		return self::$model->getTableName();
	}

	public function setMainFoto($page_id, $foto_id)
	{
		return self::$model->setMainFoto($page_id, $foto_id);
	}


	public function getNewItemButton()
	{
		$newLink = '<a href="'.$this->getNewItemLink().'"><i class="fa fa-plus-square"></i> Nový</a>';
		return $newLink;
	}
/*	public function getNextPrevButton($id,$url)
	{
		$params = array();
		$urlParse = parse_url($url);
		if (isset($urlParse["query"])) {
			parse_str($urlParse['query'], $params);
		}
	//	$catalogModel = new models_CatalogPodniku();

		$nextPrev = self::$model->getNextPrevById($params,$_GET["id"]);

		$nextLink = '';$prevLink = '';
		if (isset($nextPrev["next"]->link_edit)) {
			$nextLink = '<a title="'.$nextPrev["next"]->title.'" href="'.$nextPrev["next"]->link_edit.'">další <i class="fa fa-chevron-right"></i></a>';
		}
		if (isset($nextPrev["prev"]->link_edit)) {
			$prevLink = '<a title="'.$nextPrev["prev"]->title.'" href="'.$nextPrev["prev"]->link_edit.'"><i class="fa fa-chevron-left"></i> předchozí</a>';
		}

		return $prevLink . ' ' . $nextLink;
	}*/


	public function getNextPrevButton($id,$url)
	{
		$params = array();
		$urlParse = parse_url($url);
		if (isset($urlParse["query"])) {
			parse_str($urlParse['query'], $params);
		}
		//	$catalogModel = new models_CatalogPodniku();

		$nextPrev = self::$model->getNextPrevById($params,$_GET["id"]);



		$nextLink = '';

		$prevLink = '';

		if (isset($nextPrev["next"]->link_edit)) {
			$nextLink = '<a title="'.$nextPrev["next"]->title.'" href="'.$nextPrev["next"]->link_edit.'"><i class="fa fa-chevron-right"></i></a>';
		}
		if (isset($nextPrev["prev"]->link_edit)) {
			$prevLink = '<a title="'.$nextPrev["prev"]->title.'" href="'.$nextPrev["prev"]->link_edit.'"><i class="fa fa-chevron-left"></i></a>';
		}


		return '<div class="btn-group btn-nextprev">' . $prevLink . ' ' . $nextLink . '</div>';
	}
}
?>