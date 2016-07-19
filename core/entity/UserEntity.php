<?php
/*************
* Třída UserEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class UserEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_users";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_users";
		$this->metadata["nick"] = array("type" => "varchar(30)");
		$this->metadata["password"] = array("type" => "varchar(100)");
		$this->metadata["salt"] = array("type" => "varchar(100)");
		$this->metadata["sex"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["timezone"] = array("type" => "varchar(30)","default" => "NULL");
		$this->metadata["newsletter"] = array("type" => "tinyint","default" => "0");
		$this->metadata["email"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["titul"] = array("type" => "varchar(15)","default" => "NULL");
		$this->metadata["jmeno"] = array("type" => "varchar(30)");
		$this->metadata["prijmeni"] = array("type" => "varchar(30)");
		$this->metadata["token"] = array("type" => "varchar(100)");
		$this->metadata["ip_adresa"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["naposledy"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["stillin"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["last_page"] = array("type" => "varchar(20)");
		$this->metadata["aktivni"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["doba"] = array("type" => "int(11)","default" => "0");
		$this->metadata["autorizace"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["role"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["mobil"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["telefon"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["prihlasen"] = array("type" => "tinyint(1)","default" => "0");
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
		$this->metadata["maska"] = array("type" => "varchar(5)","default" => "NULL");
		$this->metadata["uid_category"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["typ_masky"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["lost_pwd"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["lost_pwd_ip"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["lost_pwd_date"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["foto_id"] = array("type" => "int(11)","default" => "NULL");
		$this->metadata["birthday"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["fb_user_id"] = array("type" => "bigint(11)","default" => "NULL");
	}
	#endregion

	#region Property
	// varchar(30)
	protected $nick;

	protected $nickOriginal;
	// varchar(100)
	protected $password;

	protected $passwordOriginal;
	// varchar(100)
	protected $salt;

	protected $saltOriginal;
	// int(11)
	protected $sex = NULL;
	protected $sexOriginal = NULL;

	// varchar(30)
	protected $timezone = NULL;
	protected $timezoneOriginal = NULL;

	// tinyint
	protected $newsletter = 0;
	protected $newsletterOriginal = 0;

	// varchar(50)
	protected $email = NULL;
	protected $emailOriginal = NULL;

	// varchar(15)
	protected $titul = NULL;
	protected $titulOriginal = NULL;

	// varchar(30)
	protected $jmeno;

	protected $jmenoOriginal;
	// varchar(30)
	protected $prijmeni;

	protected $prijmeniOriginal;
	// varchar(100)
	protected $token;

	protected $tokenOriginal;
	// varchar(50)
	protected $ip_adresa = NULL;
	protected $ip_adresaOriginal = NULL;

	// datetime
	protected $naposledy = NULL;
	protected $naposledyOriginal = NULL;

	// tinyint(1)
	protected $stillin = 0;
	protected $stillinOriginal = 0;

	// varchar(20)
	protected $last_page;

	protected $last_pageOriginal;
	// tinyint(1)
	protected $aktivni = 0;
	protected $aktivniOriginal = 0;

	// int(11)
	protected $doba = 0;
	protected $dobaOriginal = 0;

	// tinyint(1)
	protected $autorizace = 0;
	protected $autorizaceOriginal = 0;

	// int(11)
	protected $role = NULL;
	protected $roleOriginal = NULL;

	// varchar(25)
	protected $mobil = NULL;
	protected $mobilOriginal = NULL;

	// varchar(25)
	protected $telefon = NULL;
	protected $telefonOriginal = NULL;

	// tinyint(1)
	protected $prihlasen = 0;
	protected $prihlasenOriginal = 0;

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

	// varchar(5)
	protected $maska = NULL;
	protected $maskaOriginal = NULL;

	// int(11)
	protected $uid_category = NULL;
	protected $uid_categoryOriginal = NULL;

	// int(11)
	protected $typ_masky = NULL;
	protected $typ_maskyOriginal = NULL;

	// varchar(25)
	protected $lost_pwd = NULL;
	protected $lost_pwdOriginal = NULL;

	// varchar(25)
	protected $lost_pwd_ip = NULL;
	protected $lost_pwd_ipOriginal = NULL;

	// datetime
	protected $lost_pwd_date = NULL;
	protected $lost_pwd_dateOriginal = NULL;

	// int(11)
	protected $foto_id = NULL;
	protected $foto_idOriginal = NULL;

	// datetime
	protected $birthday = NULL;
	protected $birthdayOriginal = NULL;

	// bigint(11)
	protected $fb_user_id = NULL;
	protected $fb_user_idOriginal = NULL;

	#endregion

	#region Method
	// Setter nick
	protected function setNick($value)
	{
		$this->nick = $value;
	}
	// Getter nick
	public function getNick()
	{
		return $this->nick;
	}
	// Getter nickOriginal
	public function getNickOriginal()
	{
		return $this->nickOriginal;
	}
	// Setter password
	protected function setPassword($value)
	{
		$this->password = $value;
	}
	// Getter password
	public function getPassword()
	{
		return $this->password;
	}
	// Getter passwordOriginal
	public function getPasswordOriginal()
	{
		return $this->passwordOriginal;
	}
	// Setter salt
	protected function setSalt($value)
	{
		$this->salt = $value;
	}
	// Getter salt
	public function getSalt()
	{
		return $this->salt;
	}
	// Getter saltOriginal
	public function getSaltOriginal()
	{
		return $this->saltOriginal;
	}
	// Setter sex
	protected function setSex($value)
	{
		if (isInt($value) || is_null($value)) { $this->sex = $value; }
	}
	// Getter sex
	public function getSex()
	{
		return $this->sex;
	}
	// Getter sexOriginal
	public function getSexOriginal()
	{
		return $this->sexOriginal;
	}
	// Setter timezone
	protected function setTimezone($value)
	{
		$this->timezone = $value;
	}
	// Getter timezone
	public function getTimezone()
	{
		return $this->timezone;
	}
	// Getter timezoneOriginal
	public function getTimezoneOriginal()
	{
		return $this->timezoneOriginal;
	}
	// Setter newsletter
	protected function setNewsletter($value)
	{
		$this->newsletter = $value;
	}
	// Getter newsletter
	public function getNewsletter()
	{
		return $this->newsletter;
	}
	// Getter newsletterOriginal
	public function getNewsletterOriginal()
	{
		return $this->newsletterOriginal;
	}
	// Setter email
	protected function setEmail($value)
	{
		$this->email = $value;
	}
	// Getter email
	public function getEmail()
	{
		return $this->email;
	}
	// Getter emailOriginal
	public function getEmailOriginal()
	{
		return $this->emailOriginal;
	}
	// Setter titul
	protected function setTitul($value)
	{
		$this->titul = $value;
	}
	// Getter titul
	public function getTitul()
	{
		return $this->titul;
	}
	// Getter titulOriginal
	public function getTitulOriginal()
	{
		return $this->titulOriginal;
	}
	// Setter jmeno
	protected function setJmeno($value)
	{
		$this->jmeno = $value;
	}
	// Getter jmeno
	public function getJmeno()
	{
		return $this->jmeno;
	}
	// Getter jmenoOriginal
	public function getJmenoOriginal()
	{
		return $this->jmenoOriginal;
	}
	// Setter prijmeni
	protected function setPrijmeni($value)
	{
		$this->prijmeni = $value;
	}
	// Getter prijmeni
	public function getPrijmeni()
	{
		return $this->prijmeni;
	}
	// Getter prijmeniOriginal
	public function getPrijmeniOriginal()
	{
		return $this->prijmeniOriginal;
	}
	// Setter token
	protected function setToken($value)
	{
		$this->token = $value;
	}
	// Getter token
	public function getToken()
	{
		return $this->token;
	}
	// Getter tokenOriginal
	public function getTokenOriginal()
	{
		return $this->tokenOriginal;
	}
	// Setter ip_adresa
	protected function setIp_adresa($value)
	{
		$this->ip_adresa = $value;
	}
	// Getter ip_adresa
	public function getIp_adresa()
	{
		return $this->ip_adresa;
	}
	// Getter ip_adresaOriginal
	public function getIp_adresaOriginal()
	{
		return $this->ip_adresaOriginal;
	}
	// Setter naposledy
	protected function setNaposledy($value)
	{
		$this->naposledy = strToDatetime($value);
	}
	// Getter naposledy
	public function getNaposledy()
	{
		return $this->naposledy;
	}
	// Getter naposledyOriginal
	public function getNaposledyOriginal()
	{
		return $this->naposledyOriginal;
	}
	// Setter stillin
	protected function setStillin($value)
	{
		$this->stillin = $value;
	}
	// Getter stillin
	public function getStillin()
	{
		return $this->stillin;
	}
	// Getter stillinOriginal
	public function getStillinOriginal()
	{
		return $this->stillinOriginal;
	}
	// Setter last_page
	protected function setLast_page($value)
	{
		$this->last_page = $value;
	}
	// Getter last_page
	public function getLast_page()
	{
		return $this->last_page;
	}
	// Getter last_pageOriginal
	public function getLast_pageOriginal()
	{
		return $this->last_pageOriginal;
	}
	// Setter aktivni
	protected function setAktivni($value)
	{
		$this->aktivni = $value;
	}
	// Getter aktivni
	public function getAktivni()
	{
		return $this->aktivni;
	}
	// Getter aktivniOriginal
	public function getAktivniOriginal()
	{
		return $this->aktivniOriginal;
	}
	// Setter doba
	protected function setDoba($value)
	{
		if (isInt($value) || is_null($value)) { $this->doba = $value; }
	}
	// Getter doba
	public function getDoba()
	{
		return $this->doba;
	}
	// Getter dobaOriginal
	public function getDobaOriginal()
	{
		return $this->dobaOriginal;
	}
	// Setter autorizace
	protected function setAutorizace($value)
	{
		$this->autorizace = $value;
	}
	// Getter autorizace
	public function getAutorizace()
	{
		return $this->autorizace;
	}
	// Getter autorizaceOriginal
	public function getAutorizaceOriginal()
	{
		return $this->autorizaceOriginal;
	}
	// Setter role
	protected function setRole($value)
	{
		if (isInt($value) || is_null($value)) { $this->role = $value; }
	}
	// Getter role
	public function getRole()
	{
		return $this->role;
	}
	// Getter roleOriginal
	public function getRoleOriginal()
	{
		return $this->roleOriginal;
	}
	// Setter mobil
	protected function setMobil($value)
	{
		$this->mobil = $value;
	}
	// Getter mobil
	public function getMobil()
	{
		return $this->mobil;
	}
	// Getter mobilOriginal
	public function getMobilOriginal()
	{
		return $this->mobilOriginal;
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
	// Setter prihlasen
	protected function setPrihlasen($value)
	{
		$this->prihlasen = $value;
	}
	// Getter prihlasen
	public function getPrihlasen()
	{
		return $this->prihlasen;
	}
	// Getter prihlasenOriginal
	public function getPrihlasenOriginal()
	{
		return $this->prihlasenOriginal;
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
	// Setter uid_category
	protected function setUid_category($value)
	{
		if (isInt($value) || is_null($value)) { $this->uid_category = $value; }
	}
	// Getter uid_category
	public function getUid_category()
	{
		return $this->uid_category;
	}
	// Getter uid_categoryOriginal
	public function getUid_categoryOriginal()
	{
		return $this->uid_categoryOriginal;
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
	// Setter lost_pwd
	protected function setLost_pwd($value)
	{
		$this->lost_pwd = $value;
	}
	// Getter lost_pwd
	public function getLost_pwd()
	{
		return $this->lost_pwd;
	}
	// Getter lost_pwdOriginal
	public function getLost_pwdOriginal()
	{
		return $this->lost_pwdOriginal;
	}
	// Setter lost_pwd_ip
	protected function setLost_pwd_ip($value)
	{
		$this->lost_pwd_ip = $value;
	}
	// Getter lost_pwd_ip
	public function getLost_pwd_ip()
	{
		return $this->lost_pwd_ip;
	}
	// Getter lost_pwd_ipOriginal
	public function getLost_pwd_ipOriginal()
	{
		return $this->lost_pwd_ipOriginal;
	}
	// Setter lost_pwd_date
	protected function setLost_pwd_date($value)
	{
		$this->lost_pwd_date = strToDatetime($value);
	}
	// Getter lost_pwd_date
	public function getLost_pwd_date()
	{
		return $this->lost_pwd_date;
	}
	// Getter lost_pwd_dateOriginal
	public function getLost_pwd_dateOriginal()
	{
		return $this->lost_pwd_dateOriginal;
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
	// Setter birthday
	protected function setBirthday($value)
	{
		$this->birthday = strToDatetime($value);
	}
	// Getter birthday
	public function getBirthday()
	{
		return $this->birthday;
	}
	// Getter birthdayOriginal
	public function getBirthdayOriginal()
	{
		return $this->birthdayOriginal;
	}
	// Setter fb_user_id
	protected function setFb_user_id($value)
	{
		$this->fb_user_id = $value;
	}
	// Getter fb_user_id
	public function getFb_user_id()
	{
		return $this->fb_user_id;
	}
	// Getter fb_user_idOriginal
	public function getFb_user_idOriginal()
	{
		return $this->fb_user_idOriginal;
	}
	#endregion

}
