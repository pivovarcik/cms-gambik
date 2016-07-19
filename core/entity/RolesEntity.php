<?php
/*************
* Třída RolesEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class RolesEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_roles";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_roles";
		$this->metadata["title"] = array("type" => "varchar(25)");
		$this->metadata["description"] = array("type" => "varchar(255)");
		$this->metadata["maska"] = array("type" => "varchar(5)","default" => "null");
		$this->metadata["typ_masky"] = array("type" => "int","default" => "0");
		$this->metadata["p1"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p2"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p3"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p4"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p5"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p6"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p7"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p8"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p9"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p10"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p11"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["p12"] = array("type" => "tinyint(1)","default" => "0");
	}
	#endregion

	#region Property
	// varchar(25)
	protected $title;

	protected $titleOriginal;
	// varchar(255)
	protected $description;

	protected $descriptionOriginal;
	// varchar(5)
	protected $maska = null;
	protected $maskaOriginal = null;

	// int
	protected $typ_masky = 0;
	protected $typ_maskyOriginal = 0;

	// tinyint(1)
	protected $p1 = 0;
	protected $p1Original = 0;

	// tinyint(1)
	protected $p2 = 0;
	protected $p2Original = 0;

	// tinyint(1)
	protected $p3 = 0;
	protected $p3Original = 0;

	// tinyint(1)
	protected $p4 = 0;
	protected $p4Original = 0;

	// tinyint(1)
	protected $p5 = 0;
	protected $p5Original = 0;

	// tinyint(1)
	protected $p6 = 0;
	protected $p6Original = 0;

	// tinyint(1)
	protected $p7 = 0;
	protected $p7Original = 0;

	// tinyint(1)
	protected $p8 = 0;
	protected $p8Original = 0;

	// tinyint(1)
	protected $p9 = 0;
	protected $p9Original = 0;

	// tinyint(1)
	protected $p10 = 0;
	protected $p10Original = 0;

	// tinyint(1)
	protected $p11 = 0;
	protected $p11Original = 0;

	// tinyint(1)
	protected $p12 = 0;
	protected $p12Original = 0;

	#endregion

	#region Method
	// Setter title
	protected function setTitle($value)
	{
		$this->title = $value;
	}
	// Getter title
	public function getTitle()
	{
		return $this->title;
	}
	// Getter titleOriginal
	public function getTitleOriginal()
	{
		return $this->titleOriginal;
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
	// Setter maska
	protected function setMaska($value)
	{
		$this->maska = $value;
	}
	// Getter maska
	public function getMaska()
	{
		return $this->maska;
	}
	// Getter maskaOriginal
	public function getMaskaOriginal()
	{
		return $this->maskaOriginal;
	}
	// Setter typ_masky
	protected function setTyp_masky($value)
	{
		if (isInt($value) || is_null($value)) { $this->typ_masky = $value; }
	}
	// Getter typ_masky
	public function getTyp_masky()
	{
		return $this->typ_masky;
	}
	// Getter typ_maskyOriginal
	public function getTyp_maskyOriginal()
	{
		return $this->typ_maskyOriginal;
	}
	// Setter p1
	protected function setP1($value)
	{
		$this->p1 = $value;
	}
	// Getter p1
	public function getP1()
	{
		return $this->p1;
	}
	// Getter p1Original
	public function getP1Original()
	{
		return $this->p1Original;
	}
	// Setter p2
	protected function setP2($value)
	{
		$this->p2 = $value;
	}
	// Getter p2
	public function getP2()
	{
		return $this->p2;
	}
	// Getter p2Original
	public function getP2Original()
	{
		return $this->p2Original;
	}
	// Setter p3
	protected function setP3($value)
	{
		$this->p3 = $value;
	}
	// Getter p3
	public function getP3()
	{
		return $this->p3;
	}
	// Getter p3Original
	public function getP3Original()
	{
		return $this->p3Original;
	}
	// Setter p4
	protected function setP4($value)
	{
		$this->p4 = $value;
	}
	// Getter p4
	public function getP4()
	{
		return $this->p4;
	}
	// Getter p4Original
	public function getP4Original()
	{
		return $this->p4Original;
	}
	// Setter p5
	protected function setP5($value)
	{
		$this->p5 = $value;
	}
	// Getter p5
	public function getP5()
	{
		return $this->p5;
	}
	// Getter p5Original
	public function getP5Original()
	{
		return $this->p5Original;
	}
	// Setter p6
	protected function setP6($value)
	{
		$this->p6 = $value;
	}
	// Getter p6
	public function getP6()
	{
		return $this->p6;
	}
	// Getter p6Original
	public function getP6Original()
	{
		return $this->p6Original;
	}
	// Setter p7
	protected function setP7($value)
	{
		$this->p7 = $value;
	}
	// Getter p7
	public function getP7()
	{
		return $this->p7;
	}
	// Getter p7Original
	public function getP7Original()
	{
		return $this->p7Original;
	}
	// Setter p8
	protected function setP8($value)
	{
		$this->p8 = $value;
	}
	// Getter p8
	public function getP8()
	{
		return $this->p8;
	}
	// Getter p8Original
	public function getP8Original()
	{
		return $this->p8Original;
	}
	// Setter p9
	protected function setP9($value)
	{
		$this->p9 = $value;
	}
	// Getter p9
	public function getP9()
	{
		return $this->p9;
	}
	// Getter p9Original
	public function getP9Original()
	{
		return $this->p9Original;
	}
	// Setter p10
	protected function setP10($value)
	{
		$this->p10 = $value;
	}
	// Getter p10
	public function getP10()
	{
		return $this->p10;
	}
	// Getter p10Original
	public function getP10Original()
	{
		return $this->p10Original;
	}
	// Setter p11
	protected function setP11($value)
	{
		$this->p11 = $value;
	}
	// Getter p11
	public function getP11()
	{
		return $this->p11;
	}
	// Getter p11Original
	public function getP11Original()
	{
		return $this->p11Original;
	}
	// Setter p12
	protected function setP12($value)
	{
		$this->p12 = $value;
	}
	// Getter p12
	public function getP12()
	{
		return $this->p12;
	}
	// Getter p12Original
	public function getP12Original()
	{
		return $this->p12Original;
	}
	#endregion

}
