<?php


class NewsletterController extends CiselnikBase
{

	function __construct()
	{
		parent::__construct("Newsletter");
	}

	public function unregisterAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('newsletter_unregister', false))
		{
			// ověřím, zda-li již email není registrován
			$form = $this->formLoad('NewsletterRegister');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{
				$formdata = $form->getValues();
				$model = new models_Users();

				if ($user = $model->getUserByEmail($formdata["email"]))
				{

					if ($user->newsletter == 1) {

						$data = array();
						$data["newsletter"] = 0;
						if ($model->updateRecords($model->getTablename(),$data,"id=".$user->id))
						{

							$form->setResultSuccess("Váš email byl odhlášen z odběru newsletteru.");
						}

					}
					// už je registrovaný pokračuju bez registrace
					//$form->addError("nick","Tento email je již registrován!");
					//$form->addError("email","Tento email je již registrován!");
					//return true;
					$this->unregistraceComplete();
				}
			}
		}
	}

	public function registerAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('newsletter_register', false))
		{
			// ověřím, zda-li již email není registrován
			$form = $this->formLoad('NewsletterRegister');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{
				$formdata = $form->getValues();
				$model = new models_Users();

				if ($user = $model->getUserByEmail($formdata["email"]))
				{
					// už je registrovaný pokračuju bez registrace

					if ($user->newsletter == 0) {

						$data = array();
						$data["newsletter"] = 1;
						if ($model->updateRecords($model->getTablename(),$data,"id=".$user->id))
						{
							$form->setResultSuccess("Váš email byl přihlášen k odběru newsletteru. Děkujeme.");
						}

					}
					$this->registraceComplete();
				} else {
					$data = array();
					$data["email"] = $formdata["email"];
					$data["password"] = rand();
					$data["role"] = 4; // Registrovaný uživatel

					$this->registraceProcess($data, $form);
					$form->setResultSuccess("Váš email byl přihlášen k odběru newsletteru. Děkujeme.");
					$this->registraceComplete();
				}
			}
		}
	}


	protected function registraceComplete()
	{

	}

	protected function unregistraceComplete()
	{

	}
	protected function registraceProcess($formdata, $form)
	{
		$data = array();
		$data["nick"] = $formdata["email"];
		$data["email"] = $formdata["email"];
		$data["password"] = md5($formdata["password"]);
		$data["role"] = 4; // Registrovaný uživatel
		$data["newsletter"] = 1;
		$data["aktivni"] = 1;

		if (isset($formdata["jmeno"])) {
			$data["jmeno"] = $formdata["jmeno"];
		}


		if (isset($formdata["prijmeni"])) {
			$data["prijmeni"] = $formdata["prijmeni"];
		}
		if (isset($formdata["telefon"])) {
			$data["telefon"] = $formdata["telefon"];
		}
		if (isset($formdata["mobil"])) {
			$data["mobil"] = $formdata["mobil"];
		}



		$model = new models_Users();

		if ($model->insertRecords($model->getTablename(),$data)) {
			$user_id = $model->insert_id;




			if ($this->sendInfoRegisteredUser($data["email"], $data["nick"], $formdata["jmeno"],$formdata["password"],$user_id)) {}



			$protokolController = new ProtokolController();
			$protokolController->setProtokol("Založen nový účet","Byl vytvořen nový účet uživatele <strong>" . $data["nick"] . "</strong> (" . $user_id . ").");

			return true;


		}
	}

	public function sendInfoRegisteredUser($email, $nick, $prezdivka, $heslo,$user_id)
	{

/*
		$eshopController = new EshopController();

		$body ='<html lang="cs-CZ">';
		$body .="<head>";

		$html .= '	<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
		$html .= '<style>' . file_get_contents(dirname(__FILE__) . "/../../admin/print_pdf.css") . '</style>';
		$body .="</head>";
		$body .="<body>";

		$body .='<p>Vážený zákazníku,<br /><br /><br />
			Děkujeme Vám, že jste se zaregistrovali na internetovém obchodě <a href="'.URL_HOME.'"><strong>' . URL_DOMAIN . '</strong></a><br /><br />
</p>';


		$body .='<p>Pro přihlášení do administrace použijte prosím tyto přihlašovací údaje:<br /><br />

		Přihlašovací email: <strong>' . $email . '</strong><br />
		Heslo: <strong>' . $heslo . '</strong>
		<br /><br />

		<strong>Váš Tým<br /></strong><br /><br /></p>
		<span style="font-style:italic;font-size:12px;">Tato zpráva byla vygenerována systémem automaticky, prosím neodpovídejte na ní!</span>';
		$body .="</body></html>";

		$mailController = new MailingController();
		if ($mailController->odeslatEmail($email,"Nová registrace",$body)) {

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
*/
	}

}
?>