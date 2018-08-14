<?php

class G_Authentification
{
	private static $instance;
	private static $getRequest;
	private static $token;
	private static $timeBan;
	private static $newToken;
	private static $aktTime;

	private static $stillIn;


	private static $pohlavi;
	private static $user;
	private static $jmeno;
	private static $prijmeni;
	private static $uid_user;
	private static $role;
	private static $sex;
	private static $nick;
	private static $pwd;
	private static $email;
	private static $casnaposledy;
	private static $user_p1;
	private static $user_p2 ;
	private static $user_p3;
	private static $user_p4;
	private static $user_p5;
	private static $user_p6;
	private static $user_p7;
	private static $user_p8;
	private static $user_p9;
	private static $user_p10;

	private static $role_p1;
	private static $role_p2;
	private static $role_p3;
	private static $role_p4;
	private static $role_p5;
	private static $role_p6;
	private static $role_p7;
	private static $role_p8;
	private static $role_p9;
	private static $role_p10;

	private static $maska;

	private static $chyba;

	private function __construct() {}
	private function __clone() {}

	public static function instance()
	{
		if( !isset( self::$instance ) )
		{
			$c = __CLASS__;
			self::$instance = new $c();
			self::$instance->_inicializace();
		}
		return self::$instance;
	}

	private function _inicializace()
	{
		self::$getRequest = new G_Html();

		self::$token = self::$getRequest->getSession('uidlogin2', '');

		//print $this->uidSession;
		self::$timeBan = (30) * 60; // Platnost 30min
		self::$newToken = strtolower(substr(md5(rand()),0,100)); // Vytvořím unikátní ID
		self::$aktTime = time();
	}


	public function logOut()
	{
		//if (self::$instance->isLogIn()) {
		$_SESSION["uidlogin2"] = "";
		unset($_SESSION["uidlogin2"]);
		$_SESSION["statusmessage"]="Byli jste odhlášeni.";
		$_SESSION["classmessage"]="success";


		$tokenCookies = self::$getRequest->getCookie("ug" , false);
		if ($tokenCookies && !empty($tokenCookies)) {
			$UserLogin = new models_UserLogin();
			$UserLogin->removeToken($tokenCookies);
			self::$getRequest->setCookie("ug", "");
		}
		return true;
		//}
	}

	private function isLoginProcess()
	{

	}
	public function isLogIn()
	{

		if(isset(self::$token) && !empty(self::$token))
		{
			//	print self::$token;
			//exit;




			$model = new models_Users();
			$userDetail = $model->getUserByToken(self::$token);
			if($userDetail)
			{
				// Kontrola shody Ip adresy
				if ($userDetail->aktivni==1 && $userDetail->ip_adresa == self::$getRequest->getServer("REMOTE_ADDR"))
				{
					// Kontrola aktivního účtu
					if (self::$instance->setUserToken($userDetail)) {
						if ($model->setUserByToken(self::$instance->setUserData(), self::$token)) {
							return true;
						}
					}
				}

			}




		}


		$tokenCookies = self::$getRequest->getCookie("ug" , false);
		if ($tokenCookies && !empty($tokenCookies)) {
			$UserLogin = new models_UserLogin();
			$detail = $UserLogin->getUserLoginByToken($tokenCookies);

			if ($detail) {

				if ($detail->ip_adresa != self::$getRequest->getServer("REMOTE_ADDR")) {

				}
				$model = new models_Users();
				$userDetail = $model->getUserById($detail->user_id);
				if(!$userDetail)
				{
					return false;
				}

				// Kontrola shody Ip adresy
				if ($userDetail->ip_adresa != self::$getRequest->getServer("REMOTE_ADDR"))
				{
					//return false;
				}

				// Kontrola aktivního účtu
				if ($userDetail->aktivni==0)
				{
					return false;
				}

				if (self::$instance->setUserToken($userDetail)) {
					if ($model->setUserById(self::$instance->setUserData(), $userDetail->id)) {

						if (self::$instance->setLoginPermanent($userDetail->id,  $tokenCookies)) {
						}
						return true;
					}
				}
			} else {
				self::$getRequest->setCookie("ug", "");
				//$UserLogin = new models_UserLogin();
				$UserLogin->removeToken($tokenCookies);
			}
		}



		return false;

	}

	private function setLoginPermanent($user_id, $token = false)
	{
		if (!$token) {
			$token = md5(uniqid(mt_rand(), true));
		}
		$UserLogin = new models_UserLogin();
		$detail = $UserLogin->setLoginPermanent($user_id, self::$getRequest->getServer("REMOTE_ADDR"), $token);

		self::$getRequest->setCookie("ug", $token);

	}



	// ověření na základě emailu
	public function loginFromFacebook($facebookData)
	{

		//print($facebookData["email"]);
		if (isset($facebookData["email"]) && isEmail($facebookData["email"])) {

			$model = new models_Users();
			$userDetail = self::$instance->logInByFacebookEmail($facebookData["email"]);

			//	print_r($userDetail);
			if($userDetail)
			{
				if ($userDetail->aktivni==0)
				{
					print "účet je uzamčen!";
					return false;
				}
        $model = new models_Users();
        $data = array();
        
        if (is_null($userDetail->sex))
        {
           
           if ($facebookData["gender"] == "male")
           {
               $data["sex"] = 1;
           }
           
            if ($facebookData["gender"] == "female")
           {
               $data["sex"] = 2;
           }
           
        }        
        if (is_null($userDetail->fb_user_id))
        {
           $data["fb_user_id"] = $facebookData["id"];
        }
        if (is_null($userDetail->foto_id) || empty($userDetail->foto_id))
        {
            $from = 'https://graph.facebook.com/'.$facebookData["id"].'/picture?type=large';
            $fotoController = new FotoController();  
            if ($foto_id = $fotoController->copyProces($from, T_USERS, $userDetail->id)) {

        			$data["foto_id"] = $foto_id;
        			
        		}
        }
        
        if (count($data)>0)
        {
            $model->updateRecords($model->getTableName(), $data, "id={$userDetail->id}");
        }
        
        
				return true;
			} else {
				// účet ještě neexistuje, vytvořím ho
				if (self::$instance->createUserByFacebook($facebookData)) {
					return self::$instance->logInByFacebookEmail($facebookData["email"]);
				}
				return false;
			}
		}
	}

	private function createUserByFacebook($facebookData)
	{
		$data = array();
		//$data["nick"] = $facebookData["email"];
    
            $emailParser = explode("@",$facebookData["email"]);
        
        $nick = $emailParser[0];
			//	$nick ="host_" . rand();
		/*		if (!$model->checkNick($nick))
				{
					$msg = $translator->prelozitFrazy("username_is_duplicity");
					$form->addError("nick",$msg);
					return false;
				} */
        
        $data["nick"] = $nick."@";
		$data["email"] = $facebookData["email"];
		$data["password"] = strtolower(substr(md5(rand()),0,20));;
		$data["role"] = 4;

		$data["fb_user_id"] = $facebookData["id"];
		//$data["caszapsani"] = date('Y-m-d H:i:s');
		if (isset($facebookData["first_name"])) {
			$data["jmeno"] = $facebookData["first_name"];
		}

		$data["aktivni"] = 1;

		if (isset($facebookData["last_name"])) {
			$data["prijmeni"] = $facebookData["last_name"];
		}

		$model = new models_Users();
		if ($model->insertRecords($model->getTablename(),$data)) {
		//	$_SESSION["statusmessage"]="Uživatel byl založen.";
		//	$_SESSION["classmessage"]="success";

     $user_id = $model->insert_id;
      $from = 'https://graph.facebook.com/'.$facebookData["id"].'/picture?type=large';
    $fotoController = new FotoController();  
    if ($foto_id = $fotoController->copyProces($from, T_USERS, $user_id)) {
			$model = new models_Users();
			$data = array();
			$data["foto_id"] = $foto_id;
			$model->updateRecords($model->getTableName(), $data, "id={$user_id}");
		}
    
			$protokolController = new ProtokolController();
			$protokolController->setProtokol("Založen nový účet","Byl vytvořen nový účet uživatele <strong>" . $data["nick"] . "</strong> (" . $user_id . ").");
			//$this->getRequest->goBackRef();
			return true;
		}
	}


	public function akcePoUspesnemPrihlaseni()
	{
		// uživatelská část;
		return true;
	}
	private function _akcePoUspesnemPrihlaseni($userDetail, $pernament = false)
	{
		$_SESSION["statusmessage"]="Byli jste úspěšně přihlášeni.";
		$_SESSION["classmessage"]="success";

		$protokolController = new ProtokolController();
		$protokolController->setProtokol("Přihlášení do systému","Úspěšné přihlášení uživatele <strong>" . $userDetail->nick . "</strong> (" . $userDetail->id . ").");

	//	print "tudy" . $pernament;
	//	var_dump($pernament);
	//	exit;

		if ($pernament) {

			if (self::$instance->setLoginPermanent($userDetail->id)) {
			}

		}

		//self::$getRequest->goBackRef();

		return self::akcePoUspesnemPrihlaseni();
		//return true;


	}
	// tady je nebezpečí obejetí
	public function logInByFacebookEmail($email)
	{

		$model = new models_Users();
		$userDetail = $model->getUserByEmail($email);
		//	print_r($userDetail);
		if(self::$instance->validPrihlasenehoUzivatele($userDetail))
		{
			if (self::$instance->setUserToken($userDetail)) {

				if ($model->setUserById(self::$instance->setUserData(), $userDetail->id)) {
					//return self::$instance->_akcePoUspesnemPrihlaseni($userDetail);
					if (self::$instance->_akcePoUspesnemPrihlaseni($userDetail)) {
						return $userDetail;
					}
				}
			}
		}
		return false;
	}

	// společná validace uživatele, jestli je aktivní, nezabanovaný apod.
	private function validPrihlasenehoUzivatele($user)
	{
		if (!$user) {

			# Neplatné přihlašovací údaje!!
			self::$instance->nastavChybu("Zadaná kombinace jména a hesla je neplatná!");

			$protokolController = new ProtokolController();
			$protokolController->setProtokol("Přihlášení do systému","Neúspěšný pokus o přihlášení uživatele <strong>" . $email . "</strong>.");
			return false;
		}

		if ($user->aktivni == 0)
		{
			self::$instance->nastavChybu("Přístup do systému Vám byl odepřen!<br />Obraťte se na správce.");
			return false;
		}

		return true;
	}



	public function logInByKey($key)
	{
		/*
		   if (!self::$instance->checkPassword($password))
		   {
		   self::$instance->nastavChybu("Nesprávně zadané jméno!");
		   return false;
		   }
		*/
		$model = new models_Users();
		$userDetail = $model->getUserByKeyLostPassword($key);

		if(self::$instance->validPrihlasenehoUzivatele($userDetail))
		{
			if (self::$instance->setUserToken($userDetail)) {

				if ($model->setUserById(self::$instance->setUserData(), $userDetail->id)) {
					if (self::$instance->_akcePoUspesnemPrihlaseni($userDetail)) {
						self::$getRequest->goBackRef();
					}
				}
			}
		}
		return false;

	}

	// Přihlášení s callbackem
	public function logInByEmail($email, $password, $pernament = false)
	{

		if (!self::$instance->checkPassword($password))
		{
			self::$instance->nastavChybu("Nesprávně zadané jméno!");
			return false;
		}

		$model = new models_Users();
		$userDetail = $model->getUserByEmailPwd($email, $password);

		if(self::$instance->validPrihlasenehoUzivatele($userDetail))
		{
			if (self::$instance->setUserToken($userDetail)) {

				if ($model->setUserById(self::$instance->setUserData(), $userDetail->id)) {

					return self::$instance->_akcePoUspesnemPrihlaseni($userDetail, $pernament);
					/*if (self::$instance->_akcePoUspesnemPrihlaseni($userDetail)) {
					   //	self::$getRequest->goBackRef();
					   }*/
				}
			}
		}
		return false;

	}
	private function nastavChybu($chybovaHlaska)
	{
		return self::$chyba = $chybovaHlaska;
	}
	public function vratChybu()
	{
		return self::$chyba;
	}
	// spustí se vždy když neprojde přihlášení
	public function akcePoPrihlaseniSChybou()
	{
		return self::$instance->vratChybu();
	}

	public function logIn($nick, $password, $pernament = false)
	{
		// Nick i pass jsou v poho.
		if (!self::$instance->checkNick($nick))
		{
			//$this->resultAlert .= "Nesprávně zadané jméno.<br />";
			self::$instance->nastavChybu("Nesprávně zadané jméno!");
			//$_SESSION["statusmessage"]="Nesprávně zadané jméno!";
			//$_SESSION["classmessage"]="errors";

			return false;
		}

		if (!self::$instance->checkPassword($password))
		{
			self::$instance->nastavChybu("Nesprávně zadané heslo!");
			//	$_SESSION["statusmessage"]="Nesprávně zadané heslo!";
			//	$_SESSION["classmessage"]="errors";
			return false;
		}


		$model = new models_Users();
		$userDetail = $model->getUserByLogin($nick, $password);


		if(self::$instance->validPrihlasenehoUzivatele($userDetail))
		{

			if (self::$instance->setUserToken($userDetail)) {
				//if ($model->setUserByLogin(self::$instance->setUserData(), $nick, MD5($pass))) {
				if ($model->setUserById(self::$instance->setUserData(), $userDetail->id)) {
					return self::$instance->_akcePoUspesnemPrihlaseni($userDetail, $pernament);
				}
			}
		}

		return false;

	}

	// připravý data pro aktualizaci do DB
	private function setUserData()
	{
		$updateData = array();
		$updateData["token"] = self::$newToken;
		$updateData["naposledy"] = date("Y-m-d H:i:s");
		$updateData["ip_adresa"] = self::$getRequest->getServer("REMOTE_ADDR");
		$updateData["prihlasen"] = 1;
   // print self::$casnaposledy;
  //  print time();
		$doba_relace = strtotime(self::$casnaposledy) + (time() - strtotime(self::$casnaposledy));
		$updateData["doba"] = $doba_relace;
		//$updateData["stillin"] = self::$stillIn;

		return $updateData;
	}

	public function getJmeno()
	{
		return self::$jmeno;
	}
	public function getPrijmeni()
	{
		return self::$prijmeni;
	}
	public function getUser()
	{
		return self::$user;
	}
	public function getNickName()
	{
		return self::$nick;
	}

	public function getEmail()
	{
		return self::$email;
	}

	public static function getPassword()
	{
		return self::$pwd;
	}

	public function getSex()
	{
		return self::$sex;
	}
	private function setUserToken($obj)
	{

		define("USER_ID",$obj->id);
		define("USER_ROLE_ID",$obj->role);
		if (isset($obj->uid_charts)) {
			define("CHART_ID",$obj->uid_charts);
		}
    self::$user = new UserWrapper($obj);
		self::$pohlavi 		= $obj->sex;
		self::$jmeno 		= $obj->jmeno;
		self::$prijmeni 	= $obj->prijmeni;
		self::$uid_user		= $obj->id;
		self::$role			= $obj->role;
		self::$nick 		= $obj->nick;
		self::$pwd 			= $obj->password;
		self::$email 		= $obj->email;
		self::$casnaposledy	= $obj->naposledy;
		self::$user_p1 		= $obj->p1;
		self::$user_p2 		= $obj->p2;
		self::$user_p3 		= $obj->p3;
		self::$user_p4 		= $obj->p4;
		self::$user_p5 		= $obj->p5;
		self::$user_p6 		= $obj->p6;
		self::$user_p7 		= $obj->p7;
		self::$user_p8 		= $obj->p8;
		self::$user_p9 		= $obj->p9;
		self::$user_p10 	= $obj->p10;


		self::$role_p1 		= $obj->role_p1;
		self::$role_p2 		= $obj->role_p2;
		self::$role_p3 		= $obj->role_p3;
		self::$role_p4 		= $obj->role_p4;
		self::$role_p5 		= $obj->role_p5;
		self::$role_p6 		= $obj->role_p6;
		self::$role_p7 		= $obj->role_p7;
		self::$role_p8 		= $obj->role_p8;
		self::$role_p9 		= $obj->role_p9;
		self::$role_p10 	= $obj->role_p10;

		self::$maska    	= $obj->maska;





/*
		if (self::$stillIn == 1) {
			self::$getRequest->setCookie("stillIn", 1);
			self::$getRequest->setCookie("gb_userId", $obj->id);
			self::$getRequest->setCookie("gb_pwd", $obj->password);

		} else {
			self::$getRequest->setCookie("stillIn", 0);
			self::$getRequest->setCookie("gb_userId", self::$aktTime-3600);
			self::$getRequest->setCookie("gb_pwd", self::$aktTime-3600);
		}
*/
		self::$getRequest->setSession('uidlogin2', self::$newToken);
		return true;


	}



	/** primitivní funkce ke zvalidování a odchytávání neplatně zadaného hesla */
	public function checkPassword($password)
	{
		//$this->pass = $password;
		$password = MD5($password);
		if (!$password || $password == ""){ return false; } else { return true; }
	}

	public function checkNick($nick)
	{
		//$this->nick = $nick;
		/** Pravidla
		 * 1. Musí existovat
		 * 2. Nesmí být prázdný
		 * 3. Nesmí mít méně než 3 znaky
		 * 4. Nesmí být delší než 17 znaků
		 * 5. Nesmí obsahovat interpunkci a mezery
		 *		 		*/
		if (!$nick || $nick=="" || strlen($nick)< 3 || strlen($nick)> 30 || strtolower($nick) != StrTr(str_replace(" ","",strtolower($nick)),"áäčçďéěëíňóöřšťúůüýž","aaccdeeeinoorstuuuyz") ){ return FALSE; } else { return TRUE; }
	}



	public static function getP1()
	{
		return self::$user_p1;
	}

	public static function getP2()
	{
		return self::$user_p2;
	}

	public static function getP3()
	{
		return self::$user_p3;
	}

	public static function getP4()
	{
		return self::$user_p4;
	}


	public static function getP5()
	{
		return self::$user_p5;
	}



	public static function getP6()
	{
		return self::$user_p6;
	}

	public static function getP7()
	{
		return self::$user_p7;
	}

	public static function getP8()
	{
		return self::$user_p8;
	}

	public static function getP9()
	{
		return self::$user_p9;
	}

	public static function getP10()
	{
		return self::$user_p10;
	}

	public static function getRoleParam1()
	{
		return self::$role_p1;
	}

	public static function getRoleParam2()
	{
		return self::$role_p2;
	}

	public static function getRoleParam3()
	{
		return self::$role_p3;
	}

	public static function getRoleParam4()
	{
		return self::$role_p4;
	}


	public static function getRoleParam5()
	{
		return self::$role_p5;
	}



	public static function getRoleParam6()
	{
		return self::$role_p6;
	}

	public static function getRoleParam7()
	{
		return self::$role_p7;
	}

	public static function getRoleParam8()
	{
		return self::$role_p8;
	}

	public static function getRoleParam9()
	{
		return self::$role_p9;
	}

	public static function getRoleParam10()
	{
		return self::$role_p10;
	}
}



