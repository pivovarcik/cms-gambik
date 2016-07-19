<?php
/*************
* Třída DokladEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
abstract class DokladEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["code"] = array("type" => "varchar(25)");
		$this->metadata["user_id"] = array("type" => "int(11)","default" => "NULL","reference" => "User");
		$this->metadata["stav"] = array("type" => "int(11)","default" => "0");
		$this->metadata["order_date"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["customer_id"] = array("type" => "int");
		$this->metadata["cost_subtotal"] = array("type" => "decimal(12,2)");
		$this->metadata["cost_shipping"] = array("type" => "decimal(12,2)");
		$this->metadata["cost_tax"] = array("type" => "decimal(12,2)");
		$this->metadata["cost_total"] = array("type" => "decimal(12,2)");
		$this->metadata["shipping_first_name"] = array("type" => "varchar(50)");
		$this->metadata["shipping_last_name"] = array("type" => "varchar(50)");
		$this->metadata["shipping_address_1"] = array("type" => "varchar(100)");
		$this->metadata["shipping_address_2"] = array("type" => "varchar(100)");
		$this->metadata["shipping_city"] = array("type" => "varchar(50)");
		$this->metadata["shipping_state"] = array("type" => "char(2)");
		$this->metadata["shipping_zip_code"] = array("type" => "char(8)");
		$this->metadata["shipping_phone"] = array("type" => "char(12)");
		$this->metadata["shipping_email"] = array("type" => "varchar(100)");
		$this->metadata["shipping_pay"] = array("type" => "int","reference" => "ShopPayment");
		$this->metadata["shipping_transfer"] = array("type" => "int","reference" => "ShopTransfer");
		$this->metadata["shipping_dic"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["shipping_ico"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["ip_address"] = array("type" => "varchar(30)","default" => "NULL");
		$this->metadata["storno"] = array("type" => "tinyint(4)","default" => "0");
		$this->metadata["description"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["description_secret"] = array("type" => "longtext","default" => "NULL");
		$this->metadata["shipping_first_name2"] = array("type" => "varchar(50)");
		$this->metadata["shipping_last_name2"] = array("type" => "varchar(50)");
		$this->metadata["shipping_address_12"] = array("type" => "varchar(100)");
		$this->metadata["shipping_address_22"] = array("type" => "varchar(100)");
		$this->metadata["shipping_city2"] = array("type" => "varchar(50)");
		$this->metadata["shipping_state2"] = array("type" => "char(2)");
		$this->metadata["shipping_zip_code2"] = array("type" => "char(8)");
		$this->metadata["transId"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["kurz_id"] = array("type" => "int","default" => "NULL","reference" => "Kurz");
		$this->metadata["kurz"] = array("type" => "decimal(8,3)","default" => "NULL");
		$this->metadata["mena"] = array("type" => "varchar(3)","default" => "NULL");
		$this->metadata["kurz_datum"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["kurz_mnoz"] = array("type" => "int","default" => "NULL");
		$this->metadata["cost_subtotal_mena"] = array("type" => "decimal(12,2)");
		$this->metadata["cost_tax_mena"] = array("type" => "decimal(12,2)");
		$this->metadata["cost_total_mena"] = array("type" => "decimal(12,2)");
	}
	#endregion

	#region Property
	// varchar(25)
	protected $code;

	protected $codeOriginal;
	// int(11)
	protected $user_id = NULL;
	protected $user_idOriginal = NULL;

	protected $userUserEntity;

	// int(11)
	protected $stav = 0;
	protected $stavOriginal = 0;

	// datetime
	protected $order_date = NULL;
	protected $order_dateOriginal = NULL;

	// int
	protected $customer_id;

	protected $customer_idOriginal;
	// decimal(12,2)
	protected $cost_subtotal;

	protected $cost_subtotalOriginal;
	// decimal(12,2)
	protected $cost_shipping;

	protected $cost_shippingOriginal;
	// decimal(12,2)
	protected $cost_tax;

	protected $cost_taxOriginal;
	// decimal(12,2)
	protected $cost_total;

	protected $cost_totalOriginal;
	// varchar(50)
	protected $shipping_first_name;

	protected $shipping_first_nameOriginal;
	// varchar(50)
	protected $shipping_last_name;

	protected $shipping_last_nameOriginal;
	// varchar(100)
	protected $shipping_address_1;

	protected $shipping_address_1Original;
	// varchar(100)
	protected $shipping_address_2;

	protected $shipping_address_2Original;
	// varchar(50)
	protected $shipping_city;

	protected $shipping_cityOriginal;
	// char(2)
	protected $shipping_state;

	protected $shipping_stateOriginal;
	// char(8)
	protected $shipping_zip_code;

	protected $shipping_zip_codeOriginal;
	// char(12)
	protected $shipping_phone;

	protected $shipping_phoneOriginal;
	// varchar(100)
	protected $shipping_email;

	protected $shipping_emailOriginal;
	// int
	protected $shipping_pay;

	protected $shipping_payOriginal;
	protected $shipping_payShopPaymentEntity;

	// int
	protected $shipping_transfer;

	protected $shipping_transferOriginal;
	protected $shipping_transferShopTransferEntity;

	// varchar(25)
	protected $shipping_dic = NULL;
	protected $shipping_dicOriginal = NULL;

	// varchar(25)
	protected $shipping_ico = NULL;
	protected $shipping_icoOriginal = NULL;

	// varchar(30)
	protected $ip_address = NULL;
	protected $ip_addressOriginal = NULL;

	// tinyint(4)
	protected $storno = 0;
	protected $stornoOriginal = 0;

	// varchar(255)
	protected $description = NULL;
	protected $descriptionOriginal = NULL;

	// longtext
	protected $description_secret = NULL;
	protected $description_secretOriginal = NULL;

	// varchar(50)
	protected $shipping_first_name2;

	protected $shipping_first_name2Original;
	// varchar(50)
	protected $shipping_last_name2;

	protected $shipping_last_name2Original;
	// varchar(100)
	protected $shipping_address_12;

	protected $shipping_address_12Original;
	// varchar(100)
	protected $shipping_address_22;

	protected $shipping_address_22Original;
	// varchar(50)
	protected $shipping_city2;

	protected $shipping_city2Original;
	// char(2)
	protected $shipping_state2;

	protected $shipping_state2Original;
	// char(8)
	protected $shipping_zip_code2;

	protected $shipping_zip_code2Original;
	// varchar(50)
	protected $transId = NULL;
	protected $transIdOriginal = NULL;

	// int
	protected $kurz_id = NULL;
	protected $kurz_idOriginal = NULL;

	protected $kurzKurzEntity;

	// decimal(8,3)
	protected $kurz = NULL;
	protected $kurzOriginal = NULL;

	// varchar(3)
	protected $mena = NULL;
	protected $menaOriginal = NULL;

	// datetime
	protected $kurz_datum = NULL;
	protected $kurz_datumOriginal = NULL;

	// int
	protected $kurz_mnoz = NULL;
	protected $kurz_mnozOriginal = NULL;

	// decimal(12,2)
	protected $cost_subtotal_mena;

	protected $cost_subtotal_menaOriginal;
	// decimal(12,2)
	protected $cost_tax_mena;

	protected $cost_tax_menaOriginal;
	// decimal(12,2)
	protected $cost_total_mena;

	protected $cost_total_menaOriginal;
	#endregion

	#region Method
	// Setter code
	protected function setCode($value)
	{
		$this->code = $value;
	}
	// Getter code
	public function getCode()
	{
		return $this->code;
	}
	// Getter codeOriginal
	public function getCodeOriginal()
	{
		return $this->codeOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->user_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->userUserEntity = new UserEntity($value,false);
		} else {
			$this->userUserEntity = null;
		}
	}
	// Getter user_id
	public function getUser_id()
	{
		return $this->user_id;
	}
	// Getter user_idOriginal
	public function getUser_idOriginal()
	{
		return $this->user_idOriginal;
	}
	// Setter stav
	protected function setStav($value)
	{
		if (isInt($value) || is_null($value)) { $this->stav = $value; }
	}
	// Getter stav
	public function getStav()
	{
		return $this->stav;
	}
	// Getter stavOriginal
	public function getStavOriginal()
	{
		return $this->stavOriginal;
	}
	// Setter order_date
	protected function setOrder_date($value)
	{
		$this->order_date = strToDatetime($value);
	}
	// Getter order_date
	public function getOrder_date()
	{
		return $this->order_date;
	}
	// Getter order_dateOriginal
	public function getOrder_dateOriginal()
	{
		return $this->order_dateOriginal;
	}
	// Setter customer_id
	protected function setCustomer_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->customer_id = $value; }
	}
	// Getter customer_id
	public function getCustomer_id()
	{
		return $this->customer_id;
	}
	// Getter customer_idOriginal
	public function getCustomer_idOriginal()
	{
		return $this->customer_idOriginal;
	}
	// Setter cost_subtotal
	protected function setCost_subtotal($value)
	{
		$this->cost_subtotal = strToNumeric($value);
	}
	// Getter cost_subtotal
	public function getCost_subtotal()
	{
		return $this->cost_subtotal;
	}
	// Getter cost_subtotalOriginal
	public function getCost_subtotalOriginal()
	{
		return $this->cost_subtotalOriginal;
	}
	// Setter cost_shipping
	protected function setCost_shipping($value)
	{
		$this->cost_shipping = strToNumeric($value);
	}
	// Getter cost_shipping
	public function getCost_shipping()
	{
		return $this->cost_shipping;
	}
	// Getter cost_shippingOriginal
	public function getCost_shippingOriginal()
	{
		return $this->cost_shippingOriginal;
	}
	// Setter cost_tax
	protected function setCost_tax($value)
	{
		$this->cost_tax = strToNumeric($value);
	}
	// Getter cost_tax
	public function getCost_tax()
	{
		return $this->cost_tax;
	}
	// Getter cost_taxOriginal
	public function getCost_taxOriginal()
	{
		return $this->cost_taxOriginal;
	}
	// Setter cost_total
	protected function setCost_total($value)
	{
		$this->cost_total = strToNumeric($value);
	}
	// Getter cost_total
	public function getCost_total()
	{
		return $this->cost_total;
	}
	// Getter cost_totalOriginal
	public function getCost_totalOriginal()
	{
		return $this->cost_totalOriginal;
	}
	// Setter shipping_first_name
	protected function setShipping_first_name($value)
	{
		$this->shipping_first_name = $value;
	}
	// Getter shipping_first_name
	public function getShipping_first_name()
	{
		return $this->shipping_first_name;
	}
	// Getter shipping_first_nameOriginal
	public function getShipping_first_nameOriginal()
	{
		return $this->shipping_first_nameOriginal;
	}
	// Setter shipping_last_name
	protected function setShipping_last_name($value)
	{
		$this->shipping_last_name = $value;
	}
	// Getter shipping_last_name
	public function getShipping_last_name()
	{
		return $this->shipping_last_name;
	}
	// Getter shipping_last_nameOriginal
	public function getShipping_last_nameOriginal()
	{
		return $this->shipping_last_nameOriginal;
	}
	// Setter shipping_address_1
	protected function setShipping_address_1($value)
	{
		$this->shipping_address_1 = $value;
	}
	// Getter shipping_address_1
	public function getShipping_address_1()
	{
		return $this->shipping_address_1;
	}
	// Getter shipping_address_1Original
	public function getShipping_address_1Original()
	{
		return $this->shipping_address_1Original;
	}
	// Setter shipping_address_2
	protected function setShipping_address_2($value)
	{
		$this->shipping_address_2 = $value;
	}
	// Getter shipping_address_2
	public function getShipping_address_2()
	{
		return $this->shipping_address_2;
	}
	// Getter shipping_address_2Original
	public function getShipping_address_2Original()
	{
		return $this->shipping_address_2Original;
	}
	// Setter shipping_city
	protected function setShipping_city($value)
	{
		$this->shipping_city = $value;
	}
	// Getter shipping_city
	public function getShipping_city()
	{
		return $this->shipping_city;
	}
	// Getter shipping_cityOriginal
	public function getShipping_cityOriginal()
	{
		return $this->shipping_cityOriginal;
	}
	// Setter shipping_state
	protected function setShipping_state($value)
	{
		$this->shipping_state = $value;
	}
	// Getter shipping_state
	public function getShipping_state()
	{
		return $this->shipping_state;
	}
	// Getter shipping_stateOriginal
	public function getShipping_stateOriginal()
	{
		return $this->shipping_stateOriginal;
	}
	// Setter shipping_zip_code
	protected function setShipping_zip_code($value)
	{
		$this->shipping_zip_code = $value;
	}
	// Getter shipping_zip_code
	public function getShipping_zip_code()
	{
		return $this->shipping_zip_code;
	}
	// Getter shipping_zip_codeOriginal
	public function getShipping_zip_codeOriginal()
	{
		return $this->shipping_zip_codeOriginal;
	}
	// Setter shipping_phone
	protected function setShipping_phone($value)
	{
		$this->shipping_phone = $value;
	}
	// Getter shipping_phone
	public function getShipping_phone()
	{
		return $this->shipping_phone;
	}
	// Getter shipping_phoneOriginal
	public function getShipping_phoneOriginal()
	{
		return $this->shipping_phoneOriginal;
	}
	// Setter shipping_email
	protected function setShipping_email($value)
	{
		$this->shipping_email = $value;
	}
	// Getter shipping_email
	public function getShipping_email()
	{
		return $this->shipping_email;
	}
	// Getter shipping_emailOriginal
	public function getShipping_emailOriginal()
	{
		return $this->shipping_emailOriginal;
	}
	// Setter shipping_pay
	protected function setShipping_pay($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->shipping_pay = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->shipping_payShopPaymentEntity = new ShopPaymentEntity($value,false);
		} else {
			$this->shipping_payShopPaymentEntity = null;
		}
	}
	// Getter shipping_pay
	public function getShipping_pay()
	{
		return $this->shipping_pay;
	}
	// Getter shipping_payOriginal
	public function getShipping_payOriginal()
	{
		return $this->shipping_payOriginal;
	}
	// Setter shipping_transfer
	protected function setShipping_transfer($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->shipping_transfer = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->shipping_transferShopTransferEntity = new ShopTransferEntity($value,false);
		} else {
			$this->shipping_transferShopTransferEntity = null;
		}
	}
	// Getter shipping_transfer
	public function getShipping_transfer()
	{
		return $this->shipping_transfer;
	}
	// Getter shipping_transferOriginal
	public function getShipping_transferOriginal()
	{
		return $this->shipping_transferOriginal;
	}
	// Setter shipping_dic
	protected function setShipping_dic($value)
	{
		$this->shipping_dic = $value;
	}
	// Getter shipping_dic
	public function getShipping_dic()
	{
		return $this->shipping_dic;
	}
	// Getter shipping_dicOriginal
	public function getShipping_dicOriginal()
	{
		return $this->shipping_dicOriginal;
	}
	// Setter shipping_ico
	protected function setShipping_ico($value)
	{
		$this->shipping_ico = $value;
	}
	// Getter shipping_ico
	public function getShipping_ico()
	{
		return $this->shipping_ico;
	}
	// Getter shipping_icoOriginal
	public function getShipping_icoOriginal()
	{
		return $this->shipping_icoOriginal;
	}
	// Setter ip_address
	protected function setIp_address($value)
	{
		$this->ip_address = $value;
	}
	// Getter ip_address
	public function getIp_address()
	{
		return $this->ip_address;
	}
	// Getter ip_addressOriginal
	public function getIp_addressOriginal()
	{
		return $this->ip_addressOriginal;
	}
	// Setter storno
	protected function setStorno($value)
	{
		$this->storno = $value;
	}
	// Getter storno
	public function getStorno()
	{
		return $this->storno;
	}
	// Getter stornoOriginal
	public function getStornoOriginal()
	{
		return $this->stornoOriginal;
	}
	// Setter description
	protected function setDescription($value)
	{
		$this->description = $value;
	}
	// Getter description
	public function getDescription()
	{
		return $this->description;
	}
	// Getter descriptionOriginal
	public function getDescriptionOriginal()
	{
		return $this->descriptionOriginal;
	}
	// Setter description_secret
	protected function setDescription_secret($value)
	{
		$this->description_secret = $value;
	}
	// Getter description_secret
	public function getDescription_secret()
	{
		return $this->description_secret;
	}
	// Getter description_secretOriginal
	public function getDescription_secretOriginal()
	{
		return $this->description_secretOriginal;
	}
	// Setter shipping_first_name2
	protected function setShipping_first_name2($value)
	{
		$this->shipping_first_name2 = $value;
	}
	// Getter shipping_first_name2
	public function getShipping_first_name2()
	{
		return $this->shipping_first_name2;
	}
	// Getter shipping_first_name2Original
	public function getShipping_first_name2Original()
	{
		return $this->shipping_first_name2Original;
	}
	// Setter shipping_last_name2
	protected function setShipping_last_name2($value)
	{
		$this->shipping_last_name2 = $value;
	}
	// Getter shipping_last_name2
	public function getShipping_last_name2()
	{
		return $this->shipping_last_name2;
	}
	// Getter shipping_last_name2Original
	public function getShipping_last_name2Original()
	{
		return $this->shipping_last_name2Original;
	}
	// Setter shipping_address_12
	protected function setShipping_address_12($value)
	{
		$this->shipping_address_12 = $value;
	}
	// Getter shipping_address_12
	public function getShipping_address_12()
	{
		return $this->shipping_address_12;
	}
	// Getter shipping_address_12Original
	public function getShipping_address_12Original()
	{
		return $this->shipping_address_12Original;
	}
	// Setter shipping_address_22
	protected function setShipping_address_22($value)
	{
		$this->shipping_address_22 = $value;
	}
	// Getter shipping_address_22
	public function getShipping_address_22()
	{
		return $this->shipping_address_22;
	}
	// Getter shipping_address_22Original
	public function getShipping_address_22Original()
	{
		return $this->shipping_address_22Original;
	}
	// Setter shipping_city2
	protected function setShipping_city2($value)
	{
		$this->shipping_city2 = $value;
	}
	// Getter shipping_city2
	public function getShipping_city2()
	{
		return $this->shipping_city2;
	}
	// Getter shipping_city2Original
	public function getShipping_city2Original()
	{
		return $this->shipping_city2Original;
	}
	// Setter shipping_state2
	protected function setShipping_state2($value)
	{
		$this->shipping_state2 = $value;
	}
	// Getter shipping_state2
	public function getShipping_state2()
	{
		return $this->shipping_state2;
	}
	// Getter shipping_state2Original
	public function getShipping_state2Original()
	{
		return $this->shipping_state2Original;
	}
	// Setter shipping_zip_code2
	protected function setShipping_zip_code2($value)
	{
		$this->shipping_zip_code2 = $value;
	}
	// Getter shipping_zip_code2
	public function getShipping_zip_code2()
	{
		return $this->shipping_zip_code2;
	}
	// Getter shipping_zip_code2Original
	public function getShipping_zip_code2Original()
	{
		return $this->shipping_zip_code2Original;
	}
	// Setter transId
	protected function setTransId($value)
	{
		$this->transId = $value;
	}
	// Getter transId
	public function getTransId()
	{
		return $this->transId;
	}
	// Getter transIdOriginal
	public function getTransIdOriginal()
	{
		return $this->transIdOriginal;
	}
	// Setter kurz_id
	protected function setKurz_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->kurz_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->kurzKurzEntity = new KurzEntity($value,false);
		} else {
			$this->kurzKurzEntity = null;
		}
	}
	// Getter kurz_id
	public function getKurz_id()
	{
		return $this->kurz_id;
	}
	// Getter kurz_idOriginal
	public function getKurz_idOriginal()
	{
		return $this->kurz_idOriginal;
	}
	// Setter kurz
	protected function setKurz($value)
	{
		$this->kurz = strToNumeric($value);
	}
	// Getter kurz
	public function getKurz()
	{
		return $this->kurz;
	}
	// Getter kurzOriginal
	public function getKurzOriginal()
	{
		return $this->kurzOriginal;
	}
	// Setter mena
	protected function setMena($value)
	{
		$this->mena = $value;
	}
	// Getter mena
	public function getMena()
	{
		return $this->mena;
	}
	// Getter menaOriginal
	public function getMenaOriginal()
	{
		return $this->menaOriginal;
	}
	// Setter kurz_datum
	protected function setKurz_datum($value)
	{
		$this->kurz_datum = strToDatetime($value);
	}
	// Getter kurz_datum
	public function getKurz_datum()
	{
		return $this->kurz_datum;
	}
	// Getter kurz_datumOriginal
	public function getKurz_datumOriginal()
	{
		return $this->kurz_datumOriginal;
	}
	// Setter kurz_mnoz
	protected function setKurz_mnoz($value)
	{
		if (isInt($value) || is_null($value)) { $this->kurz_mnoz = $value; }
	}
	// Getter kurz_mnoz
	public function getKurz_mnoz()
	{
		return $this->kurz_mnoz;
	}
	// Getter kurz_mnozOriginal
	public function getKurz_mnozOriginal()
	{
		return $this->kurz_mnozOriginal;
	}
	// Setter cost_subtotal_mena
	protected function setCost_subtotal_mena($value)
	{
		$this->cost_subtotal_mena = strToNumeric($value);
	}
	// Getter cost_subtotal_mena
	public function getCost_subtotal_mena()
	{
		return $this->cost_subtotal_mena;
	}
	// Getter cost_subtotal_menaOriginal
	public function getCost_subtotal_menaOriginal()
	{
		return $this->cost_subtotal_menaOriginal;
	}
	// Setter cost_tax_mena
	protected function setCost_tax_mena($value)
	{
		$this->cost_tax_mena = strToNumeric($value);
	}
	// Getter cost_tax_mena
	public function getCost_tax_mena()
	{
		return $this->cost_tax_mena;
	}
	// Getter cost_tax_menaOriginal
	public function getCost_tax_menaOriginal()
	{
		return $this->cost_tax_menaOriginal;
	}
	// Setter cost_total_mena
	protected function setCost_total_mena($value)
	{
		$this->cost_total_mena = strToNumeric($value);
	}
	// Getter cost_total_mena
	public function getCost_total_mena()
	{
		return $this->cost_total_mena;
	}
	// Getter cost_total_menaOriginal
	public function getCost_total_menaOriginal()
	{
		return $this->cost_total_menaOriginal;
	}
	#endregion

}
