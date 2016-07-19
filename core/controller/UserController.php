<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class UserController extends PageController
{

	public function __construct()
	{
		parent::__construct("Users");
	}


	/**
	 * Změna hesla přes zadání původního hesla
	 * **/
	public function changePasswordProfilAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('user_pwd_change', false))
		{
			$form = $this->formLoad('PublicUserPwdChangeEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();

				$GAuth = G_Authentification::instance();
				if ($GAuth->getPassword() != md5($formdata["pwd"])) {
					$form->setResultError("Staré heslo nesouhlasí!");
					return false;
				}
				if ($formdata["newpwd1"] != $formdata["newpwd2"])
				{
					$form->setResultError("Nově zadaná hesla se neshodují!");
					return false;
				}

				if ($this->changePasswordFromOldPassword($formdata["newpwd1"])) {

					$form->setResultSuccess("Změna hesla provedena.");
					$this->getRequest->goBackRef();
				}

			}
		}


	}

	/**
	 * Změna hesla bez nutnosti zadání původního hesla
	 * **/
	public function changePasswordAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('changepassword', false))
		{
			$form = $this->formLoad('AdminUserPasswordChange');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();

				if ($formdata["pwd1"] != $formdata["pwd2"])
				{
					$form->setResultError("Hesla se neshodují!");
					return false;
				}

				$key = $formdata["key"];
				$password = $formdata["pwd1"];
				if ($this->changePassword($password, $key, $form)) {

					$form->setResultSuccess("Změna hesla provedena.");
					$this->getRequest->goBackRef(URL_HOME2 . "login");
				}
			}
		}

	}

	/**
	 * Provede změnu hesla z profilu
	 * */
	protected function changePasswordFromOldPassword($newpassword)
	{
		$model = new models_Users();
		$updateData = array();
		$updateData["password"] = md5($newpassword);

		if ($model->updateRecords($model->getTablename(),$updateData,"id=" . USER_ID))
		{
			$protokolController = new ProtokolController();
			$protokolController->setProtokol("Změna hesla","Heslo k účtu <strong>" . $this->nick . "</strong> (" . USER_ID . ") bylo změněno.;");
			return true;

		}

	}
	/**
	 * Provede změnu hesla na základě vygenerovaného klíče z emailu
	 * */
	protected function changePassword($password, $key, $form = false)
	{
		$model = new models_Users();
		$userDetail = $model->getUserByKeyLostPassword($key);

	//	print_r($userDetail);
		if (!$userDetail) {

			if (is_object($form)) {
				$form->setResultError("Neplatný klíč! Požádejte o obnovu znova.");
			}
			return false;
		}

		if ($userDetail->aktivni == 0) {

			if (is_object($form)) {
				$form->setResultError("Tento účet je uzamčen!");
			}
			return false;
		}

		if (strtotime($userDetail->lost_pwd_date) + 3600 > time() ) {


		} else {
			if (is_object($form)) {
				$form->setResultError("Platnost klíče pro obnovu vypršela! Požádejte o obnovu znova.");
			}
			return false;
		}
		$updateData = array();
		$updateData["password"] = md5($password);
		$updateData["lost_pwd"] = "";
		//$updateData["lost_pwd_date"] = date("Y-m-d H:i:s");
		//$updateData["lost_pwd_ip"] = $this->getRequest->getServer("REMOTE_ADDR");
		if ($model->updateRecords($model->getTablename(),$updateData,"id=" . $userDetail->id))
		{

			if ($this->sendInfoChangePassword($userDetail->email,$userDetail->nick)) {}

			$message ='Vašeho heslo bylo úspěšně změněno.';
			$modelMessage = new models_Message();
			$modelMessage->setMessage(3, $userDetail->id, $message);

			$protokolController = new ProtokolController();
			$protokolController->setProtokol("Změna hesla","Heslo k účtu <strong>" . $userDetail->nick . "</strong> (" . $userDetail->id . ") bylo změněno.;");


			return true;

		}

	}

	public function logInAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('login', false))
		{
			$form = $this->formLoad('AdminUserLogin');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$formdata = $form->getValues();
				$username = $formdata["nick"];
				$password = $formdata["pwd"];

				$GAuth = G_Authentification::instance();

				if (!$GAuth->logIn($username, $password)) {

					$form->setResultError($GAuth->vratChybu());
					return false;
				}
				return true;

			}
		}
	}


	public function logInByEmailAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('login', false))
		{
			$form = $this->formLoad('PublicUserLogin');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$formdata = $form->getValues();
				$email = $formdata["email"];
				$password = $formdata["pwd"];


				$GAuth = G_Authentification::instance();

				if (!$GAuth->logInByEmail($email, $password)) {

					$form->setResultError($GAuth->vratChybu());
					return false;
				}

				//$form->setResultSuccess("Uloženo.");
				$this->getRequest->goBackRef();

				return true;
			}
		}
	}

	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('add_user', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('AdminUserCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();
				$model = new models_Users();

				if (!$model->checkEmail($formdata["email"]))
				{
					$form->setResultError("Tento email je již registrován!");
					return false;
				}

				if (!$model->checkNick($formdata["nick"]))
				{
					$form->setResultError("Toto uživatelské jméno je již registrováno!");
					return false;
				}

				if ($formdata["pwd1"] != $formdata["pwd2"])
				{
					$form->setResultError("Hesla se neshodují!");
					return false;
				}


			//	if (USER_ROLE_ID == 2 && $user_id != 3) {

				if (USER_ROLE_ID == 2 && $user_id != 3) {
					/*	$name = "role";
					   if (false !== $this->getRequest->getPost($name, false)) {
					   $data[$name] = $this->getRequest->getPost($name, '');
					   }*/
					if (isset($formdata["newpassword"]) && !empty($formdata["newpassword"])) {
						$formdata["password"] = md5($formdata["newpassword"]);
					}
				} else {
				//	unset($formdata["role"]);
					unset($formdata["password"]);
				}
				$entitaOut = new UserEntity();
				$entitaOut->naplnEntitu($formdata);

				//print_r($entitaOut);
				//exit;
				$saveEntity = new SaveEntity();
				$saveEntity->addSaveEntity($entitaOut);

				if ($saveEntity->save()) {


					$form->setResultSuccess("Uživatel byl založen.");
					$protokolController = new ProtokolController();
					$protokolController->setProtokol("Založen nový účet","Byl vytvořen nový účet uživatele <strong>" . $formdata["nick"] . "</strong> (" . $model->insert_id . ").");

					$this->getRequest->goBackRef();
				}
			}
		}
	}

	public function registerAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('register', false))
		{


			// načtu Objekt formu
			$form = $this->formLoad('PublicUserRegister');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();
				$model = new models_Users();

				if (!$model->checkEmail($formdata["email"]))
				{
					$form->setResultError("Tento email je již registrován!");
					//$_SESSION["err_elem"]["email"] = "Tento email je již registrován!";
					return false;
				}

				$nick ="host_" . rand();
				if (!$model->checkNick($nick))
				{
					$form->setResultError("Toto uživatelské jméno je již registrováno!");
					return false;
				}

				if ($formdata["pwd1"] != $formdata["pwd2"])
				{
					$form->setResultError("Hesla se neshodují!");
					return false;
				}

				$data = array();
				$data["nick"] = $nick;
				$data["email"] = $formdata["email"];
				$data["password"] = md5($formdata["pwd1"]);
				$data["role"] = 4; // Registrovaný uživatel
				//$data["caszapsani"] = date('Y-m-d H:i:s');
				if (isset($formdata["jmeno"])) {
					$data["jmeno"] = $formdata["jmeno"];
				}
				/*if (isset($formdata["aktivni"])) {
					$data["aktivni"] = 1;
				}*/
				$data["aktivni"] = 1;
				if (isset($formdata["prijmeni"])) {
					$data["prijmeni"] = $formdata["prijmeni"];
				}
				if (isset($formdata["telefon"])) {
					$data["telefon"] = $formdata["telefon"];
				}
				if (isset($formdata["mobil"])) {
					$data["mobil"] = $formdata["mobil"];
				}


				if ($model->insertRecords($model->getTablename(),$data)) {

					if ($this->sendInfoRegisteredUser($data["email"], $data["nick"], $formdata["jmeno"],$formdata["pwd1"],$model->insert_id)) {
					}
					//	$_SESSION["statusmessage"]="Uživatel byl založen.";
					//	$_SESSION["classmessage"]="success";
						$form->setResultSuccess("Registrace proběhla v pořádku.");

						$protokolController = new ProtokolController();
						$protokolController->setProtokol("Založen nový účet","Byl vytvořen nový účet uživatele <strong>" . $data["nick"] . "</strong> (" . $model->insert_id . ").");

						// Automatické přihlášení po zaregistrování
						$GAuth = G_Authentification::instance();
						return $GAuth->logInByEmail($data["email"], $formdata["pwd1"]);
				}
			}
		}
	}

	public function sendInfoRegisteredUser($email, $nick, $prezdivka, $heslo,$user_id)
	{

		$predmet= "Registrace";

		$body ='';
		$body .="<html>";
		$body .="<head></head>";
		$body .="<body>";



		$body .='Dobrý den,<br /><br />
		děkujeme Vám, že jste se zaregistrovali ZDARMA na portál <a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a><br />
		<br />
		Pro přihlášení do administrace použijte prosím tyto přihlašovací údaje.<br /><br />

		Login email: <strong>' . $email . '</strong><br />
		Heslo: <strong>' . $heslo . '</strong><br />
		Přezdívka: <strong>' . $prezdivka . '</strong>
		<br /><br />
		S pozdravem<br />
		Tým<br />
		<a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a><br />
		';

		$body .="</body></html>";


		$mailController = new MailingController();
		if ($mailController->odeslatEmail($email, $predmet, $body)) {
			$message ='Dobrý den, děkujeme Vám, že jste se zaregistrovali ZDARMA na portál <a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a>
			<br /><br />
			S pozdravem<br />
			Tým<br />
			<a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a>
			';
			$modelMessage = new models_Message();
			$modelMessage->setMessage(3, $user_id, $message);
			return true;
		}




	}

	public function usersList($params = array())
	{
		$model = new models_Users();

		$params2 = array();
		$limit 	= (int) $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		//print $limit;
		$params2["limit"] = $limit;

		$page 	= (int) $this->getRequest->getQuery('pg', 1);
		$params2["page"] = $page;

		$search_string = $this->getRequest->getQuery('q', '');
		$params2["fulltext"] = $search_string;

		$querys = array();

		$querys[] = array('title'=>'Uživatel','url'=>'nick','sql'=>'t1.nick');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'t1.description_cs');
		$querys[] = array('date'=>'Poslední ativita','url'=>'date','sql'=>'t1.naposledy');
		$querys[] = array('email'=>'Email','url'=>'email','sql'=>'t1.email');
		$querys[] = array('jmeno'=>'Jméno','url'=>'jmeno','sql'=>'t1.jmeno');
		$querys[] = array('email'=>'Příjmení','url'=>'prijm','sql'=>'t1.prijmeni');
		$querys[] = array('role'=>'Název role','url'=>'role','sql'=>'t2.title');
		$querys[] = array('autor'=>'Ověř.','url'=>'autor','sql'=>'t1.autorizace');
		$querys[] = array('akt'=>'Odemčené','url'=>'akt','sql'=>'t1.aktivni');

		$orderFromQuery = $this->orderFromQuery($querys, 't1.naposledy DESC');
		//print $orderFromQuery;
		$params2["order"] = $orderFromQuery;

		$l = $model->getList($params2);
		$this->total = $model->total;

		return $l;
	}

	public function lostPasswordAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('lostpassword', false))
		{

			$form = $this->formLoad('AdminUserLostPassword');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();
				if (md5(strtolower($formdata["captcha"])) != $_SESSION["captcha"]) {
					$form->setResultError("Kontrolní kód se neshoduje!");
					$form->addError("captcha","Kontrolní kód se neshoduje!");
					return false;
				}
				$email = $form->getPost('email', '');
				if ($this->sendLostPassword($email)) {

					$form->setResultSuccess("Požadavek na změnu hesla byl odeslán na registrační email.");
					$this->getRequest->goBackRef();
				} else {
					$form->setResultError("Vygenerování hesla se nezdařilo!");
					return false;
				}
			}
		}
	}


	/**
	 * Základní šablona - informační email o provešdení změny hesla
	 * v potomkovi lze přepsat na svojí šablonu
	 * **/
	protected function sendInfoChangePassword($email, $nick)
	{

		$body = $this->getEmailBodyChangePassword($user);

		$predmet = "Heslo bylo změněno";
		$mailController = new MailingController();
		if ($mailController->odeslatEmail($email, $predmet, $body)) {
			return true;
		}

	}


	protected function getEmailBodyChangePassword($user)
	{

		$body ='Dobrý den,<br /><br />
		Vaše heslo na webu <a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a> bylo úspěšně změněno.<br /><br />

		Váš email pro přihlášení: <strong>' . $user->email . '</strong><br /><br />
		S pozdravem,<br />
		<a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a>';

		return $body;
	}


	/**
	 * Generátor klíče pro obnovu hesla
	 * vygeneruje klíč a uloží ho k uživateli.
	 * @return $key
	 * */
	protected function generateLostPasswordByEmail($user)
	{

		if ($user) {
			$key = strtolower(substr(md5(rand()),0,25));
			$model = new models_Users();
			$updateData = array();
			$updateData["lost_pwd"] = $key;
			$updateData["lost_pwd_date"] = date("Y-m-d H:i:s");
			$updateData["lost_pwd_ip"] = $this->getRequest->getServer("REMOTE_ADDR");
			if ($model->updateRecords($model->getTablename(),$updateData,"id=" . $user->id))
			{
				return $key;
			}
		}

		return false;

	}


	/***
	 * Základní šablona emailu - zaslání resetu hesla,
	 * lze v potomkovi přepsat na vlastní šablonu
	 * */
	protected function getEmailBodyLostPassword($user, $key)
	{
		$url = URL_HOME2 . 'login.php?action=changepassword&key=' . $key;

		$body .='Dobrý den,<br /><br />
				požadoval jste o reset hesla na serveru <a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a>, protože jste své původní heslo zapomněl(a). Pokud jste tento požadavek nezaslal, prosím ignorujte tento email. Informace zde uvedené jsou platné pouze 1 hodinu.<br /><br />
				Pokud chcete resetovat heslo, naštivte následující stránku:<br />
				<a href="' . $url . '">' . $url . '</a><br /><br />
				Pokud tuto stránku navštívíte, vaše heslo bude resetováno a budete vyzváni k zadání nového hesla.<br /><br />
				Vaše uživatelské jméno je: <strong>' . $user->nick . '</strong><br /><br /><br />
				S pozdravem,<br />
				<a href="' . URL_HOME2 . '">' . SERVER_NAME . '</a>';

		return $body;
	}

	/**
	 * Odeslání požadavku na změnu hesla
	 * **/
	protected function sendLostPassword($email)
	{

		$model = new models_Users();
		$userDetail = $model->getUserByEmail($email);
		if ($userDetail) {
			if ($key = $this->generateLostPasswordByEmail($userDetail)) {
				$mailController = new MailingController();


				$predmet = "Žádost o obnovu hesla";

				$body ='';
				$body .="<html>";
				$body .="<head></head>";
				$body .="<body>";

				$body .= $this->getEmailBodyLostPassword($userDetail, $key);

				$body .="</body></html>";



				if ($mailController->odeslatEmail($email, $predmet, $body) != false) {
					$protokolController = new ProtokolController();
					$protokolController->setProtokol("Obnova hesla","Požadavek na obnovu hesla uživatele <strong>" . $user->nick . "</strong> (" . $user->id . "). byl odelsán na email <strong>" . $user->email . "</strong>.");
					return true;
				}
				return true;
			}
		} else {
			$protokolController = new ProtokolController();
			$protokolController->setProtokol("Žádost o zaslání nového hesla","Email <strong>" . $email . " nebyl nalezen v seznamu uživatelů!</strong>.");
			return false;
		}
	}

	public function usersListEdit($params = array())
	{
		$l = $this->usersList($params);
		$rolesController = new RolesController();
		$rolesList = $rolesController->rolesList();
		for($i=0;$i<count($l);$i++)
		{

			$url= URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->id;

			if ($l[$i]->prihlasen == 1 && ($l[$i]->casnaposledy + 60*6) > time()){
				$status = "online";
			} else {
				$status = "offline";
			}
			$l[$i]->nick = '<a href="'.$url.'"><span class="'. $status . '">' . $l[$i]->nick . '</span></a>';
			$l[$i]->last_active = "";
			if (!is_null($l[$i]->naposledy)) {
				$l[$i]->last_active = date("j.n.Y H:i:s",strtotime($l[$i]->naposledy));
			}

			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i]) || (isset($_GET["mode"]) && $_GET["mode"] == "edit")))
			{
				$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$elem->setAttribs('value', $l[$i]->id);
				$elem->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elem->render();

				$elem = new G_Form_Element_Checkbox("aktivni[" . $i . "]");
				$elem->setAttribs('value', 1);
				//$elem->setAttribs('disabled', 'disabled');
				if ($l[$i]->aktivni == 1) {
					$elem->setAttribs('checked', 'checked');
				}
				$l[$i]->aktivni = $elem->render();

				$elem = new G_Form_Element_Checkbox("autorizace[" . $i . "]");
				$elem->setAttribs('value', 1);
				if ($l[$i]->autorizace == 1) {
					$elem->setAttribs('checked', 'checked');
				}
				$l[$i]->autorizace = $elem->render();

				$elem = new G_Form_Element_Text("jmeno[" . $i . "]");
				$value = $this->getRequest->getPost("jmeno[" . $i . "]", $l[$i]->jmeno);
				$elem->setAttribs('value',$value);
				$l[$i]->jmeno = $elem->render();

				$elem = new G_Form_Element_Text("prijmeni[" . $i . "]");
				$value = $this->getRequest->getPost("prijmeni[" . $i . "]", $l[$i]->prijmeni);
				$elem->setAttribs('value',$value);
				$l[$i]->prijmeni = $elem->render();

				$elem = new G_Form_Element_Text("email[" . $i . "]");
				$value = $this->getRequest->getPost("email[" . $i . "]", $l[$i]->email);
				$elem->setAttribs('value',$value);
				$l[$i]->email = $elem->render();

				$elem = new G_Form_Element_Text("mobil[" . $i . "]");
				$value = $this->getRequest->getPost("mobil[" . $i . "]", $l[$i]->mobil);
				$elem->setAttribs('value',$value);
				$l[$i]->mobil = $elem->render();


				//$l[$i]->titulek = $titulek;
				/**
				 * Umístění v TREE
				 * */
				if (USER_ROLE_ID == 2) {


					$elemUmisteni = new G_Form_Element_Select("role[" . $i . "]");
					$value = $this->getRequest->getPost("role[" . $i . "]", $l[$i]->role);
					$elemUmisteni->setAttribs('value',$value);
					$elemUmisteni->setAttribs('style','width:100px;');

					$pole = array();
					$attrib =array();
					//$pole[0] = " -- bez umístění -- ";
					foreach ($rolesList as $key => $value)
					{
						$pole[$value->uid] = $value->title;
						//$attrib[$value->uid]["class"] = "vnoreni" . $value->vnoreni;
					}
					$elemUmisteni->setMultiOptions($pole);
					$l[$i]->nazev_role = $elemUmisteni->render();
				}


				$l[$i]->cmd = '';
			} else {
				$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$elem->setAttribs('value', $l[$i]->id);
				//$elem->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elem->render();

				$elem = new G_Form_Element_Checkbox("aktivni[" . $i . "]");
				$elem->setAttribs('value', 1);
				$elem->setAttribs('disabled', 'disabled');
				if ($l[$i]->aktivni == 1) {
					$elem->setAttribs('checked', 'checked');
					$l[$i]->aktivni = '<img width="15" height="18" border="0" style="cursor: pointer;vertical-align: middle;" alt="Open" src="/admin/unlockbig.gif">';

				} else {
					$l[$i]->aktivni = '<img width="15" height="18" border="0" style="cursor: pointer;vertical-align: middle;" alt="Lock" src="/admin/lockbig.gif">';

				}

				//$l[$i]->aktivni = $elem->render();
				$elem = new G_Form_Element_Checkbox("autorizace[" . $i . "]");
				$elem->setAttribs('value', 1);
				$elem->setAttribs('disabled', 'disabled');
				if ($l[$i]->autorizace == 1) {
					$elem->setAttribs('checked', 'checked');
				}
				$l[$i]->autorizace = $elem->render();
				$commnad ='<a href="' . $url. '">Zobrazit</a> <a href="' . URL_HOME . 'admin/post_edit.php?id=' . $l[$i]->id . '">Upravit</a> <a href="' . $url . '">Smazat</a>';

				$l[$i]->cmd = $commnad;
			}

		}
		return $l;
	}

	public function usersListTable($params = array())
	{
		$l = $this->usersListEdit($params);
		$sorting = new G_Sorting("date","desc");

		$column = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["autorizace"] = $sorting->render("Ověř.", "autor");
		$column["aktivni"] = $sorting->render("Odem.", "akt");
		$column["nick"] = $sorting->render("Uživatel", "nick");
		$column["email"] = $sorting->render("Email", "email");
		$column["jmeno"] = $sorting->render("Jméno", "jmeno");
		$column["prijmeni"] = $sorting->render("Příjmení", "prijm");

		$column["mobil"] = $sorting->render("Mobil", "mob");
		$column["nazev_role"] = $sorting->render("Role", "role");
		$column["last_active"] = $sorting->render("Poslední aktivita", "date");
		//$column["cmd"] = '';

		$th_attrib = array();
		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["autorizace"]["class"] = "column-cmd";
		$th_attrib["aktivni"]["class"] = "column-cmd";
		$th_attrib["add_label"]["class"] = "column-autor";
		$th_attrib["edit_label"]["class"] = "column-autor";
		$th_attrib["last_active"]["class"] = "column-date";
		$th_attrib["cmd"]["class"] = "column-cmd";

		$td_attrib = array();
		$td_attrib["filesize"]["class"] = "column-qty";
		$table = new G_Table($l, $column, $th_attrib, $td_attrib);

		$table_attrib = array(
				"class" => "widefat fixed",
				"id" => "data_grid",
				"cellspacing" => "0",
				);
		return $table->makeTable($table_attrib);
	}

	public function userPanelRender()
	{
		if (LOGIN_STATUS=="ON" && (USER_ROLE_ID == "1" || USER_ROLE_ID == "2"))
		{
			$GAuth = G_Authentification::instance();

			return '<div style="color: rgb(255, 255, 255); display: block; position: absolute; text-align: center; z-index: 99999; font-size: 11px; font-family: arial; background-color: rgb(75, 168, 46) ! important; border-bottom: 0px none; top: 0px; left: 40%; padding: 4px 6px; border-radius: 0px 0px 5px 5px;">přihlášen <strong>' .$GAuth->getJmeno() . ' ' . $GAuth->getPrijmeni() . '</strong> (' .$GAuth->getNickName() . ') <a style="color:#fff;" onclick="return confirm(\'Opravdu chcete odhlásit?\')" href="' . URL_HOME2 . 'logout.php">Odhlásit se</a> | <a style="color:#fff;" href="' . URL_HOME2 . 'admin/">Přejít do administrace &rarr;</a></div>';
		}
		return '';
	}
	public function saveAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('edit_user', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('AdminUserEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$zmenaHeslaAlert = "";
				$formdata = $form->getValues();
				$models = new models_Users();
				$user_id = $form->getPost('id', 0);
				$userDetail = $models->getUserById($user_id);
				if (!$userDetail)
				{
					$form->setResultError("Uživatel s tímto ID neexistuje!");
					return false;
				}

				if ($userDetail->email != $formdata["email"] && !$models->checkEmail($formdata["email"]))
				{

					$form->addError("email","Tento email je již registrován!");
					$form->setResultError("Tento email je již registrován!");
					return false;
				}
				//if (USER_ROLE_ID == 2 && $user_id != 3) {
				if (USER_ROLE_ID == 2 && $userDetail->nick != "sysadmin") {
					/*	$name = "role";
						if (false !== $this->getRequest->getPost($name, false)) {
							$data[$name] = $this->getRequest->getPost($name, '');
						}*/
					if (isset($formdata["newpassword"]) && !empty($formdata["newpassword"])) {
							$formdata["password"] = md5($formdata["newpassword"]);
							$zmenaHeslaAlert = " Heslo bylo změněno.";
					}
				} else {
					unset($formdata["role"]);
					unset($formdata["password"]);
				}


			//	print_r($formdata);
			//	exit;
				$entitaOut = new UserEntity($userDetail);
				$entitaOut->naplnEntitu($formdata);

			//	print_r($entitaOut);
			//	exit;
				$saveEntity = new SaveEntity();
				$saveEntity->addSaveEntity($entitaOut);

				if ($saveEntity->save()) {


					$form->setResultSuccess("Uloženo." . $zmenaHeslaAlert);
					$this->getRequest->goBackRef();
				}

			}
		}
	}

	public function deleteAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteUsers" == $this->getRequest->getPost('action', false))
		{



			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Users();
						$obj = $model->getUserById($doklad_id);

						if ($obj) {

							if ($obj->nick == "sysadmin") {
								$_SESSION["statusmessage"]="Uživatel " . $obj->nick . " nelze smazat!";
								$_SESSION["classmessage"]="errors";
								return false;
							}
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->nick );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Uživatel " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}
			}
		}
	}
}