<?php



require_once("ACiselnikModel.php");
class models_Newsletter extends ACiselnikModel{

	public $formNameEdit = "NewsletterEdit";
	function __construct()
	{
		parent::__construct(T_NEWSLETTER);
	}


	public function getList(IListArgs $params = null)
	{


		if(isset($params->date) && !empty($params->date))
		{
			$this->addWhere("t1.datum=".$params->date . "");
		}

		if(isset($params->kod) && !empty($params->kod))
		{
			$this->addWhere("t1.kod='".$params->kod . "'");
		}

		$list = parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = '/admin/newsletter_edit?id='.$list[$i]->id;
		}
		return $list;
	}
}

?>