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


		if(false !== self::$getRequest->getQuery('email', false))
		{
			// ověřím, zda-li již email není registrován
			$form = $this->formLoad('NewsletterRegister');


			$email = self::$getRequest->getQuery('email', false);



				$model = new models_Users();

				if ($user = $model->getUserByEmail($email))
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

	public function registerAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('newsletter_register', false))
		{
			// ověřím, zda-li již email není registrován
			$form = $this->formLoad('NewsletterRegister');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{






      				$settings = G_Setting::instance();
				$recaptcha_secret =  $settings->get("reCAPTCHA_SECRET_KEY");
        
        if (!empty($recaptcha_secret)){
        
  				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
  				$response = json_decode($response, true);
  				if($response["success"] === true)
  				{
  					//	echo "Logged In Successfully";
  				}
  				else
  				{
  					$form->setResultError("Potvrďte prosím, že nejste robot.");
  					return false;
  				}        
        }

        
              /*
				$recaptcha_secret = "6Lfe2wgTAAAAAAh8jK9LKTpQIH3nA7Y42gROr_bx";
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
				$response = json_decode($response, true);
				if($response["success"] === true)
				{
					//	echo "Logged In Successfully";
				}
				else
				{
					$form->setResultError("Potvrďte prosím, že nejste robot.");
					//	$_SESSION["statusmessage"]= "Prosím potvrdťe ochranu!";
					//	$_SESSION["classmessage"]="errors";
					return false;
					//echo "You are a robot";
				}
           */

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
		self::$getRequest->goBackRef();
	}

	protected function unregistraceComplete()
	{
		self::$getRequest->goBackRef();
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

 	public function copyAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "NewsletterCopy" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);
			$model = new models_Newsletter();
			$obj = $model->getDetailById($doklad_id);

			if ($obj) {
         $data = array();
         $data["name"] =  $obj->name . " - kopie";
         $data["subject"] =  $obj->subject;
         $data["html"] =  $obj->html;
         $data["html_footer"] =  $obj->html_footer;

				if ($model->insertRecords($model->getTableName(),$data)) {
					return true;
				}
				//	return true;

			}
		}
	}
  public function sendNewsletterAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('send_newsletter', false))
		{
			$form = $this->formLoad('NewsletterEdit');


			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();



				$zprava = $postdata["html"] ;
				$predmet = $postdata["subject"]; //"Newsletter";
				if (empty($postdata["html"])) {
					return false;
				}


				$link_clanek = $form->page->link;
				if (substr($link_clanek,0,1) == "/") {
					$link_clanek = substr($link_clanek,1,strlen($link_clanek));
				}
				$link_clanek = URL_HOME2 . $link_clanek; //str_replace("//","/" ,URL_HOME2 . $link_clanek );

				$res = "";


				$MailingController = new MailingController();

    
				$modelUser = new models_Users();
            /*
				$args = new ListArgs();
				$args->limit = 10000;
				$args->page = 1;
				$args->newsletter = 1;
				$args->aktivni = 1;
				$newsletterList = $modelUser->getList($args);
                   */
				$pocetNewsletteru = 0;
				//print_r($newsletterList);

				//	exit;
        
        $newsletterList = $postdata["user_id"];
				foreach ($newsletterList as $key => $user_id) {

        $user = $modelUser->getUserById($user_id);
					if (!empty($user->email) && isEmail($user->email)) {
						$komu = strtolower($user->email);
            
            
                  		$property = array();
  		$property["NEWS_LINK"] = $form->page->link;
  		$property["NEWS_LINK_ODHLASENI"] = URL_HOME . "odhlaseni-newsletter";
  		$property["NEWS_EMAIL_ODBERATEL"] = $user->email;
  		$property["NEWS_EMAIL_JMENO"] = $user->jmeno;
  		$property["NEWS_EMAIL_PRIJMENI"] = $user->prijmeni;
  		
  	//	$property["NEWS_EMAIL_HASH"] = "xxxxxx";
      
    
    
            propertyToText($form->sablona->html, $property);
            
            
            
              $newsletter_id =  $form->page_id;
						//	print $komu . "<br />";
						if ($MailingController->odeslatNewsletter2($newsletter_id, $komu, $predmet, $zprava, $property)) {
							$pocetNewsletteru++;
						}
					}

				}

				$form->setResultSuccess("Newsletter byl odeslán " . $pocetNewsletteru .  " odběratelům.");
				self::$getRequest->goBackRef();
			}
		}
	}
 
 
 
 
 	public function sendNewsletterTestAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('send_newsletter_test', false))
		{
			$form = $this->formLoad('NewsletterEdit');


			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();

         //print_r($postdata);
         //exit;
				$komu = $postdata["email_test"];

				$zprava = $postdata["html"];
				$predmet = $postdata["subject"]; //"Newsletter";
				if (empty($postdata["html"])) {
					return false;
				}
                     /*
				//$link_clanek = str_replace("//","/" ,URL_HOME2 . $form->page->link );

				$link_clanek = $form->page->link;
				if (substr($link_clanek,0,1) == "/") {
					$link_clanek = substr($link_clanek,1,strlen($link_clanek));
				}
				$link_clanek = URL_HOME2 . $link_clanek; //str_replace("//","/" ,URL_HOME2 . $link_clanek );
*/

				$res = "";


				$MailingController = new MailingController();



				$pocetNewsletteru = 0;
       $GAuth = G_Authentification::instance();


                          		$property = array();
  		$property["NEWS_LINK"] = $form->page->link;
  		$property["NEWS_LINK_ODHLASENI"] = URL_HOME . "odhlaseni-newsletter";
  		$property["NEWS_EMAIL_ODBERATEL"] = $GAuth->getEmail();
  		$property["NEWS_EMAIL_JMENO"] = $GAuth->getJmeno();
      $property["NEWS_EMAIL_PRIJMENI"] = $GAuth->getPrijmeni();
  //		$property["NEWS_EMAIL_HASH"] = "xxxxxx";
      
          $newsletter_id =  $form->page_id;
						//	print $komu . "<br />";
				if ($MailingController->odeslatNewsletter2($newsletter_id, $komu, $predmet, $zprava, $property)) {
					$pocetNewsletteru++;
				}

				$form->setResultSuccess("Testovací článek odeslán " . $pocetNewsletteru .  ".");
				self::$getRequest->goBackRef();
			}
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