<?php
class ProductCenikTabs extends CiselnikTabs {


	public $produkty_count = 0;
	public $skupiny_produktu_count = 0;
	public function __construct($pageForm)
	{

		$this->form = $pageForm;
	}

	protected function MainTabs()
	{


		$form = $this->form;
		$contentMain = parent::MainTabs();

		$contentMain .= $form->getElement("sleva")->render() . '<p class="desc"></p><br />';

		$contentMain .= $form->getElement("typ_slevy")->render() . '<p class="desc"></p><br />';

		$contentMain .= $form->getElement("platnost_od")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("platnost_do")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("priorita")->render() . '<p class="desc"></p><br />';
		return $contentMain;
	}

	protected function ProduktyTabs()
	{

		$contentMain = '<p>Produkty, pro které platí tato sleva.</p> ';
		$form = $this->form;

		if ($form->getElement("id") !== false) {
			$cenik_id .= $form->getElement("id")->getValue();
			$model = new models_ProductCenik();
	//		$list = $model->getProduktyList($cenik_id);

			$this->produkty_count = count($list);
		//	print_r($list);
			$contentMain .= '<ul>';
			foreach ($list as $key => $product) {
				$contentMain .= '<li><a target="_blank" href="'.$product->link_edit.'">' . $product->cislo . ' ' . $product->title . '</a></li>';
			}
			$contentMain .= '</ul>';
		}





		return $contentMain;
	}

	protected function SkupinyProduktuTabs()
	{


		$contentMain = '<p>Skupiny produktu uplatňující tuto slevu.</p> ';
		$form = $this->form;

		if ($form->getElement("id") !== false) {
			$cenik_id .= $form->getElement("id")->getValue();
			$model = new models_ProductCenik();
			$list = $model->getSkupinyProduktuList($cenik_id);

			$this->skupiny_produktu_count = count($list);
		//		print_r($list);
			$contentMain .= '<ul>';
			foreach ($list as $key => $product) {
				$contentMain .= '<li><a target="_blank" href="'.$product->link_edit.'">' . $product->name . '</a></li>';
			}
			$contentMain .= '</ul>';
		}





		return $contentMain;
	}


	public function makeTabs($tabs = array()) {

		$ProduktyTabs = $this->ProduktyTabs();
		array_push($tabs, array("name" => "Produkty", "title" => 'Produkty (' . $this->produkty_count . ')',"content" => $ProduktyTabs));
		$ProduktyTabs = $this->SkupinyProduktuTabs();
		array_push($tabs, array("name" => "SkupinyProduktu", "title" => 'Skupiny (' . $this->skupiny_produktu_count . ')',"content" => $ProduktyTabs));

		return parent::makeTabs($tabs);
	}

}