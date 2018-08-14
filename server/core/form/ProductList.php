<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_ProductList extends G_Form
{
	private $_view;
	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

		$eshop = new Eshop();
		$orderBySql = '';
		$headProduct= $eshop->get_orderByHead2(array('title'=>'Produkt','url'=>'prod','sql'=>'t1.nazev_mat'));
		$orderBySql = (empty($orderBySql)) ? $eshop->orderBySql : $orderBySql;

		$headNumber = $eshop->get_orderByHead2(array('title'=>'Číslo','url'=>'num','sql'=>'t1.cislo_mat'));
		$orderBySql = (empty($orderBySql)) ? $eshop->orderBySql : $orderBySql;

		$headCat = $eshop->get_orderByHead2(array('title'=>'Skupina','url'=>'cat','sql'=>'t2.nazev_cs'));
		$orderBySql = (empty($orderBySql)) ? $eshop->orderBySql : $orderBySql;

		$headPrice = $eshop->get_orderByHead2(array('title'=>'Cena','url'=>'prc','sql'=>'t1.prodcena'));
		$orderBySql = (empty($orderBySql)) ? $eshop->orderBySql : $orderBySql;

		//Implicitní řazení
		if (empty($orderBySql))
		{
			$headNumber= $eshop->get_orderByHead2(array('title'=>'Číslo','url'=>'num','sql'=>'t1.cislo_mat','sort'=>'ASC'));
			$orderBySql = $eshop->orderBySql;
		}

		$search_string = (isset($_GET["q"])) ? $_GET["q"] : "";

		$limit = 25;
		$l = $eshop->product_list(array(
								'limit'=>$limit,
								'fulltext'=>$search_string,
								'page'=>$_GET["pg"],
								'order'=>$orderBySql,
								'debug'=>0,
								));
	//	print_r($l);
		$output =$eshop->generuj_pagelist_html2(array('url_fiendly'=>'0'));
		$_product = new models_Products();

		$productCategoryList = $eshop->product_category_list(array("limit"=>1000,"debug"=>0));
		$typSortimentuList = array("P"=>"Produkt", "V"=>"Výrobek", "S"=>"Služba");
		for ($i=0;$i < count($l);$i++)
		{

			$l[$i]->popis = '<form action="' . URL_HOME . 'admin/sortiment.php" method="post">
<input class="tlac" type="submit" value="Smazat" name="del_product"/>
<input type="hidden" value="' . $l[$i]->klic_ma . '" name="product_id"/></form>';

			if (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])){



				$elemKlicMa = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$klicMa = $l[$i]->klic_ma;
				$elemKlicMa->setAttribs('value', $klicMa);
				$elemKlicMa->setAttribs('checked', 'checked');

				$l[$i]->check_column = $elemKlicMa->render();

				$elemNazevMat = new G_Form_Element_Text("nazev_mat[" . $i . "]");
				$nazev_mat = $this->Request->getPost("nazev_mat[" . $i . "]", $l[$i]->nazev_mat);
				$elemNazevMat->setAttribs('value',$nazev_mat);
				$l[$i]->nazev_mat = $elemNazevMat->render();

				$elemProdCena = new G_Form_Element_Text("prodcena[" . $i . "]");
				$prodCena = $this->Request->getPost("prodcena[" . $i . "]", $l[$i]->prodcena);
				$elemProdCena->setAttribs('value',$prodCena);
				$elemProdCena->setAttribs('style','text-align:right;width:100px;');
				$l[$i]->prodcena = $elemProdCena->render();

				//$l[$i]->prodcena = '<input class="textbox" type="textbox" value="' . $l[$i]->prodcena . '" name="prodcena[' . $i . ']">';

				$elemCategory = new G_Form_Element_Select("skupina[" . $i . "]");
				$skupina = $this->Request->getPost("skupina[" . $i . "]", $l[$i]->skupina);
				$elemCategory->setAttribs('value',$skupina);
				$elemCategory->setAttribs('style','width:185px;');

				$pole = array();
				foreach ($productCategoryList as $key => $value)
				{
					$pole[$value->uid] = $value->nazev_cs;
				}
				$elemCategory->setMultiOptions($pole);
				$l[$i]->skupina_cs = $elemCategory->render();




			} else {
				$l[$i]->check_column = '<input type="checkbox" name="slct['.$i.']" value="' . $l[$i]->klic_ma . '">';
				$elemKlicMa = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$klicMa = $l[$i]->klic_ma;
				$elemKlicMa->setAttribs('value', $klicMa);
				$l[$i]->check_column = $elemKlicMa->render();
			}

			$url = $url = URL_HOME . "admin/edit_product.php?id=" . $l[$i]->klic_ma;
			$l[$i]->cislo_mat = '<a href="' . $url . '">' . $l[$i]->cislo_mat . '</a>';


			$this->addElements(array(
				$elemKlicMa, $elemNazevMat,
				$elemCategory, $elemProdCena, $elemCommand,
			));
		}

		$data_grid = array(
		'check_column'=>'<input type="checkbox" onclick="multi_check(this);">','cislo_mat'=>$headNumber,
		'nazev_mat'=>$headProduct,'skupina_cs'=>$headCat,'prodcena'=>$headPrice,'popis'=>'',
		);
		$table = new G_Table($l,
		$data_grid,
		array(
			'check_column'=>array('class'=>'check-column'),
			'cislo_mat'=>array('class'=>'column-num'),
			'prodcena'=>array('class'=>'column-price'),
		),
		array(
			'check_column'=>array('class'=>'check-column'),
			'prodcena'=>array('class'=>'column-price'),
		)

		);

		$this->_view = $output;
		$this->_view .= $table->makeTable(array("id"=>"data_grid", "class"=>"widefat fixed", "cellspacing"=>"0"));
		$this->_view .= $output;

	}

	public function view()
	{
		return $this->_view;
	}
}