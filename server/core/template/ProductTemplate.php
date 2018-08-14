<?php


define("T_SHOP_PRODUCT",DB_PREFIX . "products");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT;
		$this->parent = "PageEntity";

		$this->_attributtes["cislo"] = array("type" => "varchar(30)", "default" => "NULL", "index" => true);
		$this->_attributtes["cis_skladu"] = array("type" => "varchar(5)", "default" => "NULL");
		$this->_attributtes["typ_sort"] = array("type" => "varchar(1)", "default" => "NULL");

		$this->_attributtes["hl_mj_id"] = array("type" => "int", "default" => "NULL","reference" => "Mj");
		$this->_attributtes["mj_id"] = array("type" => "int", "default" => "NULL","reference" => "Mj");
    
    $this->_attributtes["objem"] = array("type" => "decimal(10,5)", "default" => "NULL");
    $this->_attributtes["rozmer"] = array("type" => "varchar(25)", "default" => "NULL");
    

		$this->_attributtes["dph_id"] = array("type" => "int", "default" => "NULL","reference" => "Dph");
//		$this->_attributtes["category_id"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["skupina_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductCategory");
		$this->_attributtes["vyrobce_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductVyrobce");
	//	$this->_attributtes["foto_id"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["aktivni"] = array("type" => "int", "default" => "0", "index" => true);
    
	//	$this->_attributtes["sync_stav"] = array("type" => "int", "default" => "0", "index" => true);


		$this->_attributtes["min_prodcena"] = array("type" => "decimal(10,2)", "default" => "0");
		$this->_attributtes["min_prodcena_sdph"] = array("type" => "decimal(10,2)", "default" => "0");


		$this->_attributtes["max_prodcena"] = array("type" => "decimal(10,2)", "default" => "0");
		$this->_attributtes["max_prodcena_sdph"] = array("type" => "decimal(10,2)", "default" => "0");

		$this->_attributtes["nakupni_cena"] = array("type" => "decimal(10,2)", "default" => "0");


		// příznak bazarové položky, defaultně je položka nová
		$this->_attributtes["bazar"] = array("type" => "int", "default" => "0", "index" => true);

		// obsahuje varianty
		$this->_attributtes["isVarianty"] = array("type" => "int", "default" => "0", "index" => true);

		$this->_attributtes["qty"] = array("type" => "decimal(10,2)", "default" => "NULL");

		$this->_attributtes["code01"] = array("type" => "varchar(150)", "default" => "NULL", "index" => true);
		$this->_attributtes["code02"] = array("type" => "varchar(150)", "default" => "NULL", "index" => true);
		$this->_attributtes["code03"] = array("type" => "varchar(150)", "default" => "NULL", "index" => true);

		// neexportovat do porovnávačů
		$this->_attributtes["neexportovat"] = array("type" => "int", "default" => "0");

		$this->_attributtes["dostupnost_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductDostupnost");
		
    // ID dodavatele
    $this->_attributtes["dodavatel_id"] = array("type" => "int", "default" => "NULL");
		
    // identifikátor čísla přenosu při založení 
    $this->_attributtes["import_id"] = array("type" => "int", "default" => "NULL");


    // originální categorie produktu z feedu
    $this->_attributtes["import_category"] = array("type" => "varchar(255)", "default" => "NULL");
    

		$this->_attributtes["zaruka_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductZaruka");

    /*
		$this->_attributtes["novinka"] = array("type" => "int", "default" => "0", "index" => true);

		$this->_attributtes["akce"] = array("type" => "int", "default" => "0", "index" => true);
		$this->_attributtes["doporucujeme"] = array("type" => "int", "default" => "0", "index" => true);
      */

		$this->_attributtes["group_label"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["group_id"] = array("type" => "varchar(255)", "default" => "NULL");
    
    
    // synchronizační stav
    $this->_attributtes["sync_stav"] = array("type" => "int", "default" => "0", "index" => true);
    $this->_attributtes["sync_not"] = array("type" => "tinyint", "default" => "0", "index" => true);
    $this->_attributtes["LastSyncTime"] = array("type" => "datetime", "default" => "NULL");

		$this->_attributtes["stav_qty"] = array("type" => "decimal(12,2)");
		$this->_attributtes["stav_qty_min"] = array("type" => "decimal(12,2)");
		$this->_attributtes["stav_qty_max"] = array("type" => "decimal(12,2)");
    
    // moznost odberu pouze v nasobku qty
    $this->_attributtes["qty_nasobek"] = array("type" => "int", "default" => "0");

		// toto zboží nelze zakoupit - neprodejní zboží
		$this->_attributtes["neprodejne"] = array("type" => "int", "default" => "0");
            
	// ceník se defnuje přes kod, jeden produkt může mít více cen pro více kodu.
	//	$this->_attributtes["cenik_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductCenik");



	}
}
