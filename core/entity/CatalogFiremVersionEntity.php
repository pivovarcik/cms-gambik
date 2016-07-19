<?php
/*************
* Třída CatalogFiremVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CatalogVersionEntity.php");
class CatalogFiremVersionEntity extends CatalogVersionEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_catalog_firem_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_catalog_firem_version";
		$this->metadata["page_id"]["reference"] = "CatalogFirem";
		$this->metadata["firstname"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["lastname"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["address1"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["city"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["zip_code"] = array("type" => "varchar(10)","default" => "null");
		$this->metadata["firstname2"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["lastname2"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["city2"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["address2"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["zip_code2"] = array("type" => "varchar(10)","default" => "null");
		$this->metadata["femail"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["ftelefon"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["fnazev_firmy"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["website"] = array("type" => "varchar(150)","default" => "null");
		$this->metadata["ico"] = array("type" => "varchar(25)","default" => "null");
		$this->metadata["dic"] = array("type" => "varchar(25)","default" => "null");
		$this->metadata["lng"] = array("type" => "varchar(25)","default" => "null");
		$this->metadata["lat"] = array("type" => "varchar(25)","default" => "null");
		$this->metadata["telefon"] = array("type" => "varchar(100)","default" => "null");
		$this->metadata["registrace"] = array("type" => "datetime","default" => "null");
		$this->metadata["expirace"] = array("type" => "datetime","default" => "null");
		$this->metadata["foto_id"] = array("type" => "int","default" => "null");
		$this->metadata["vip"] = array("type" => "int","default" => "0");
		$this->metadata["status_id"] = array("type" => "int","default" => "0");
		$this->metadata["poradi"] = array("type" => "int","default" => "0");
		$this->metadata["popa_start"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["popa_end"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["ut_start"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["ut_end"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["st_start"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["st_end"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["ct_start"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["ct_end"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["pa_start"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["pa_end"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["sone_start"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["sone_end"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["ne_start"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["ne_end"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["cena_1"] = array("type" => "decimal(12,2)","default" => "null");
		$this->metadata["cena_2"] = array("type" => "decimal(12,2)","default" => "null");
		$this->metadata["cena_3"] = array("type" => "decimal(12,2)","default" => "null");
		$this->metadata["cena_4"] = array("type" => "decimal(12,2)","default" => "null");
	}
	#endregion

	#region Property
	// varchar(150)
	protected $firstname = null;
	protected $firstnameOriginal = null;

	// varchar(150)
	protected $lastname = null;
	protected $lastnameOriginal = null;

	// varchar(150)
	protected $address1 = null;
	protected $address1Original = null;

	// varchar(150)
	protected $city = null;
	protected $cityOriginal = null;

	// varchar(10)
	protected $zip_code = null;
	protected $zip_codeOriginal = null;

	// varchar(150)
	protected $firstname2 = null;
	protected $firstname2Original = null;

	// varchar(150)
	protected $lastname2 = null;
	protected $lastname2Original = null;

	// varchar(150)
	protected $city2 = null;
	protected $city2Original = null;

	// varchar(150)
	protected $address2 = null;
	protected $address2Original = null;

	// varchar(10)
	protected $zip_code2 = null;
	protected $zip_code2Original = null;

	// varchar(150)
	protected $femail = null;
	protected $femailOriginal = null;

	// varchar(150)
	protected $ftelefon = null;
	protected $ftelefonOriginal = null;

	// varchar(150)
	protected $fnazev_firmy = null;
	protected $fnazev_firmyOriginal = null;

	// varchar(150)
	protected $website = null;
	protected $websiteOriginal = null;

	// varchar(25)
	protected $ico = null;
	protected $icoOriginal = null;

	// varchar(25)
	protected $dic = null;
	protected $dicOriginal = null;

	// varchar(25)
	protected $lng = null;
	protected $lngOriginal = null;

	// varchar(25)
	protected $lat = null;
	protected $latOriginal = null;

	// varchar(100)
	protected $telefon = null;
	protected $telefonOriginal = null;

	// datetime
	protected $registrace = null;
	protected $registraceOriginal = null;

	// datetime
	protected $expirace = null;
	protected $expiraceOriginal = null;

	// int
	protected $foto_id = null;
	protected $foto_idOriginal = null;

	// int
	protected $vip = 0;
	protected $vipOriginal = 0;

	// int
	protected $status_id = 0;
	protected $status_idOriginal = 0;

	// int
	protected $poradi = 0;
	protected $poradiOriginal = 0;

	// varchar(5)
	protected $popa_start = null;
	protected $popa_startOriginal = null;

	// varchar(5)
	protected $popa_end = null;
	protected $popa_endOriginal = null;

	// varchar(5)
	protected $ut_start = null;
	protected $ut_startOriginal = null;

	// varchar(5)
	protected $ut_end = null;
	protected $ut_endOriginal = null;

	// varchar(5)
	protected $st_start = null;
	protected $st_startOriginal = null;

	// varchar(5)
	protected $st_end = null;
	protected $st_endOriginal = null;

	// varchar(5)
	protected $ct_start = null;
	protected $ct_startOriginal = null;

	// varchar(5)
	protected $ct_end = null;
	protected $ct_endOriginal = null;

	// varchar(5)
	protected $pa_start = null;
	protected $pa_startOriginal = null;

	// varchar(5)
	protected $pa_end = null;
	protected $pa_endOriginal = null;

	// varchar(5)
	protected $sone_start = null;
	protected $sone_startOriginal = null;

	// varchar(5)
	protected $sone_end = null;
	protected $sone_endOriginal = null;

	// varchar(5)
	protected $ne_start = null;
	protected $ne_startOriginal = null;

	// varchar(5)
	protected $ne_end = null;
	protected $ne_endOriginal = null;

	// decimal(12,2)
	protected $cena_1 = null;
	protected $cena_1Original = null;

	// decimal(12,2)
	protected $cena_2 = null;
	protected $cena_2Original = null;

	// decimal(12,2)
	protected $cena_3 = null;
	protected $cena_3Original = null;

	// decimal(12,2)
	protected $cena_4 = null;
	protected $cena_4Original = null;

	#endregion

	#region Method
	// Setter page_id
	protected function setPage_id($value)
	{
		$this->page_id = $value;
	}
	// Getter page_id
	public function getPage_id()
	{
		return $this->page_id;
	}
	// Getter page_idOriginal
	public function getPage_idOriginal()
	{
		return $this->page_idOriginal;
	}
	// Setter firstname
	protected function setFirstname($value)
	{
		$this->firstname = $value;
	}
	// Getter firstname
	public function getFirstname()
	{
		return $this->firstname;
	}
	// Getter firstnameOriginal
	public function getFirstnameOriginal()
	{
		return $this->firstnameOriginal;
	}
	// Setter lastname
	protected function setLastname($value)
	{
		$this->lastname = $value;
	}
	// Getter lastname
	public function getLastname()
	{
		return $this->lastname;
	}
	// Getter lastnameOriginal
	public function getLastnameOriginal()
	{
		return $this->lastnameOriginal;
	}
	// Setter address1
	protected function setAddress1($value)
	{
		$this->address1 = $value;
	}
	// Getter address1
	public function getAddress1()
	{
		return $this->address1;
	}
	// Getter address1Original
	public function getAddress1Original()
	{
		return $this->address1Original;
	}
	// Setter city
	protected function setCity($value)
	{
		$this->city = $value;
	}
	// Getter city
	public function getCity()
	{
		return $this->city;
	}
	// Getter cityOriginal
	public function getCityOriginal()
	{
		return $this->cityOriginal;
	}
	// Setter zip_code
	protected function setZip_code($value)
	{
		$this->zip_code = $value;
	}
	// Getter zip_code
	public function getZip_code()
	{
		return $this->zip_code;
	}
	// Getter zip_codeOriginal
	public function getZip_codeOriginal()
	{
		return $this->zip_codeOriginal;
	}
	// Setter firstname2
	protected function setFirstname2($value)
	{
		$this->firstname2 = $value;
	}
	// Getter firstname2
	public function getFirstname2()
	{
		return $this->firstname2;
	}
	// Getter firstname2Original
	public function getFirstname2Original()
	{
		return $this->firstname2Original;
	}
	// Setter lastname2
	protected function setLastname2($value)
	{
		$this->lastname2 = $value;
	}
	// Getter lastname2
	public function getLastname2()
	{
		return $this->lastname2;
	}
	// Getter lastname2Original
	public function getLastname2Original()
	{
		return $this->lastname2Original;
	}
	// Setter city2
	protected function setCity2($value)
	{
		$this->city2 = $value;
	}
	// Getter city2
	public function getCity2()
	{
		return $this->city2;
	}
	// Getter city2Original
	public function getCity2Original()
	{
		return $this->city2Original;
	}
	// Setter address2
	protected function setAddress2($value)
	{
		$this->address2 = $value;
	}
	// Getter address2
	public function getAddress2()
	{
		return $this->address2;
	}
	// Getter address2Original
	public function getAddress2Original()
	{
		return $this->address2Original;
	}
	// Setter zip_code2
	protected function setZip_code2($value)
	{
		$this->zip_code2 = $value;
	}
	// Getter zip_code2
	public function getZip_code2()
	{
		return $this->zip_code2;
	}
	// Getter zip_code2Original
	public function getZip_code2Original()
	{
		return $this->zip_code2Original;
	}
	// Setter femail
	protected function setFemail($value)
	{
		$this->femail = $value;
	}
	// Getter femail
	public function getFemail()
	{
		return $this->femail;
	}
	// Getter femailOriginal
	public function getFemailOriginal()
	{
		return $this->femailOriginal;
	}
	// Setter ftelefon
	protected function setFtelefon($value)
	{
		$this->ftelefon = $value;
	}
	// Getter ftelefon
	public function getFtelefon()
	{
		return $this->ftelefon;
	}
	// Getter ftelefonOriginal
	public function getFtelefonOriginal()
	{
		return $this->ftelefonOriginal;
	}
	// Setter fnazev_firmy
	protected function setFnazev_firmy($value)
	{
		$this->fnazev_firmy = $value;
	}
	// Getter fnazev_firmy
	public function getFnazev_firmy()
	{
		return $this->fnazev_firmy;
	}
	// Getter fnazev_firmyOriginal
	public function getFnazev_firmyOriginal()
	{
		return $this->fnazev_firmyOriginal;
	}
	// Setter website
	protected function setWebsite($value)
	{
		$this->website = $value;
	}
	// Getter website
	public function getWebsite()
	{
		return $this->website;
	}
	// Getter websiteOriginal
	public function getWebsiteOriginal()
	{
		return $this->websiteOriginal;
	}
	// Setter ico
	protected function setIco($value)
	{
		$this->ico = $value;
	}
	// Getter ico
	public function getIco()
	{
		return $this->ico;
	}
	// Getter icoOriginal
	public function getIcoOriginal()
	{
		return $this->icoOriginal;
	}
	// Setter dic
	protected function setDic($value)
	{
		$this->dic = $value;
	}
	// Getter dic
	public function getDic()
	{
		return $this->dic;
	}
	// Getter dicOriginal
	public function getDicOriginal()
	{
		return $this->dicOriginal;
	}
	// Setter lng
	protected function setLng($value)
	{
		$this->lng = $value;
	}
	// Getter lng
	public function getLng()
	{
		return $this->lng;
	}
	// Getter lngOriginal
	public function getLngOriginal()
	{
		return $this->lngOriginal;
	}
	// Setter lat
	protected function setLat($value)
	{
		$this->lat = $value;
	}
	// Getter lat
	public function getLat()
	{
		return $this->lat;
	}
	// Getter latOriginal
	public function getLatOriginal()
	{
		return $this->latOriginal;
	}
	// Setter telefon
	protected function setTelefon($value)
	{
		$this->telefon = $value;
	}
	// Getter telefon
	public function getTelefon()
	{
		return $this->telefon;
	}
	// Getter telefonOriginal
	public function getTelefonOriginal()
	{
		return $this->telefonOriginal;
	}
	// Setter registrace
	protected function setRegistrace($value)
	{
		$this->registrace = strToDatetime($value);
	}
	// Getter registrace
	public function getRegistrace()
	{
		return $this->registrace;
	}
	// Getter registraceOriginal
	public function getRegistraceOriginal()
	{
		return $this->registraceOriginal;
	}
	// Setter expirace
	protected function setExpirace($value)
	{
		$this->expirace = strToDatetime($value);
	}
	// Getter expirace
	public function getExpirace()
	{
		return $this->expirace;
	}
	// Getter expiraceOriginal
	public function getExpiraceOriginal()
	{
		return $this->expiraceOriginal;
	}
	// Setter foto_id
	protected function setFoto_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->foto_id = $value; }
	}
	// Getter foto_id
	public function getFoto_id()
	{
		return $this->foto_id;
	}
	// Getter foto_idOriginal
	public function getFoto_idOriginal()
	{
		return $this->foto_idOriginal;
	}
	// Setter vip
	protected function setVip($value)
	{
		if (isInt($value) || is_null($value)) { $this->vip = $value; }
	}
	// Getter vip
	public function getVip()
	{
		return $this->vip;
	}
	// Getter vipOriginal
	public function getVipOriginal()
	{
		return $this->vipOriginal;
	}
	// Setter status_id
	protected function setStatus_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->status_id = $value; }
	}
	// Getter status_id
	public function getStatus_id()
	{
		return $this->status_id;
	}
	// Getter status_idOriginal
	public function getStatus_idOriginal()
	{
		return $this->status_idOriginal;
	}
	// Setter poradi
	protected function setPoradi($value)
	{
		if (isInt($value) || is_null($value)) { $this->poradi = $value; }
	}
	// Getter poradi
	public function getPoradi()
	{
		return $this->poradi;
	}
	// Getter poradiOriginal
	public function getPoradiOriginal()
	{
		return $this->poradiOriginal;
	}
	// Setter popa_start
	protected function setPopa_start($value)
	{
		$this->popa_start = $value;
	}
	// Getter popa_start
	public function getPopa_start()
	{
		return $this->popa_start;
	}
	// Getter popa_startOriginal
	public function getPopa_startOriginal()
	{
		return $this->popa_startOriginal;
	}
	// Setter popa_end
	protected function setPopa_end($value)
	{
		$this->popa_end = $value;
	}
	// Getter popa_end
	public function getPopa_end()
	{
		return $this->popa_end;
	}
	// Getter popa_endOriginal
	public function getPopa_endOriginal()
	{
		return $this->popa_endOriginal;
	}
	// Setter ut_start
	protected function setUt_start($value)
	{
		$this->ut_start = $value;
	}
	// Getter ut_start
	public function getUt_start()
	{
		return $this->ut_start;
	}
	// Getter ut_startOriginal
	public function getUt_startOriginal()
	{
		return $this->ut_startOriginal;
	}
	// Setter ut_end
	protected function setUt_end($value)
	{
		$this->ut_end = $value;
	}
	// Getter ut_end
	public function getUt_end()
	{
		return $this->ut_end;
	}
	// Getter ut_endOriginal
	public function getUt_endOriginal()
	{
		return $this->ut_endOriginal;
	}
	// Setter st_start
	protected function setSt_start($value)
	{
		$this->st_start = $value;
	}
	// Getter st_start
	public function getSt_start()
	{
		return $this->st_start;
	}
	// Getter st_startOriginal
	public function getSt_startOriginal()
	{
		return $this->st_startOriginal;
	}
	// Setter st_end
	protected function setSt_end($value)
	{
		$this->st_end = $value;
	}
	// Getter st_end
	public function getSt_end()
	{
		return $this->st_end;
	}
	// Getter st_endOriginal
	public function getSt_endOriginal()
	{
		return $this->st_endOriginal;
	}
	// Setter ct_start
	protected function setCt_start($value)
	{
		$this->ct_start = $value;
	}
	// Getter ct_start
	public function getCt_start()
	{
		return $this->ct_start;
	}
	// Getter ct_startOriginal
	public function getCt_startOriginal()
	{
		return $this->ct_startOriginal;
	}
	// Setter ct_end
	protected function setCt_end($value)
	{
		$this->ct_end = $value;
	}
	// Getter ct_end
	public function getCt_end()
	{
		return $this->ct_end;
	}
	// Getter ct_endOriginal
	public function getCt_endOriginal()
	{
		return $this->ct_endOriginal;
	}
	// Setter pa_start
	protected function setPa_start($value)
	{
		$this->pa_start = $value;
	}
	// Getter pa_start
	public function getPa_start()
	{
		return $this->pa_start;
	}
	// Getter pa_startOriginal
	public function getPa_startOriginal()
	{
		return $this->pa_startOriginal;
	}
	// Setter pa_end
	protected function setPa_end($value)
	{
		$this->pa_end = $value;
	}
	// Getter pa_end
	public function getPa_end()
	{
		return $this->pa_end;
	}
	// Getter pa_endOriginal
	public function getPa_endOriginal()
	{
		return $this->pa_endOriginal;
	}
	// Setter sone_start
	protected function setSone_start($value)
	{
		$this->sone_start = $value;
	}
	// Getter sone_start
	public function getSone_start()
	{
		return $this->sone_start;
	}
	// Getter sone_startOriginal
	public function getSone_startOriginal()
	{
		return $this->sone_startOriginal;
	}
	// Setter sone_end
	protected function setSone_end($value)
	{
		$this->sone_end = $value;
	}
	// Getter sone_end
	public function getSone_end()
	{
		return $this->sone_end;
	}
	// Getter sone_endOriginal
	public function getSone_endOriginal()
	{
		return $this->sone_endOriginal;
	}
	// Setter ne_start
	protected function setNe_start($value)
	{
		$this->ne_start = $value;
	}
	// Getter ne_start
	public function getNe_start()
	{
		return $this->ne_start;
	}
	// Getter ne_startOriginal
	public function getNe_startOriginal()
	{
		return $this->ne_startOriginal;
	}
	// Setter ne_end
	protected function setNe_end($value)
	{
		$this->ne_end = $value;
	}
	// Getter ne_end
	public function getNe_end()
	{
		return $this->ne_end;
	}
	// Getter ne_endOriginal
	public function getNe_endOriginal()
	{
		return $this->ne_endOriginal;
	}
	// Setter cena_1
	protected function setCena_1($value)
	{
		$this->cena_1 = strToNumeric($value);
	}
	// Getter cena_1
	public function getCena_1()
	{
		return $this->cena_1;
	}
	// Getter cena_1Original
	public function getCena_1Original()
	{
		return $this->cena_1Original;
	}
	// Setter cena_2
	protected function setCena_2($value)
	{
		$this->cena_2 = strToNumeric($value);
	}
	// Getter cena_2
	public function getCena_2()
	{
		return $this->cena_2;
	}
	// Getter cena_2Original
	public function getCena_2Original()
	{
		return $this->cena_2Original;
	}
	// Setter cena_3
	protected function setCena_3($value)
	{
		$this->cena_3 = strToNumeric($value);
	}
	// Getter cena_3
	public function getCena_3()
	{
		return $this->cena_3;
	}
	// Getter cena_3Original
	public function getCena_3Original()
	{
		return $this->cena_3Original;
	}
	// Setter cena_4
	protected function setCena_4($value)
	{
		$this->cena_4 = strToNumeric($value);
	}
	// Getter cena_4
	public function getCena_4()
	{
		return $this->cena_4;
	}
	// Getter cena_4Original
	public function getCena_4Original()
	{
		return $this->cena_4Original;
	}
	#endregion

}
