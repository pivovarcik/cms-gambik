<?php


require_once("CatalogController.php");
class CatalogZakaznikuController extends CatalogController
{
	public $photos = array();
	public $total = 0;
	public $programs = array();
	public $services = array();


	function __construct()
	{
		parent::__construct("CatalogFirem", "CatalogFiremVersion");
		self::$isVersioning = true;
	}
	public function getCatalog($catalog_id){
		$catalog = self::$model->getDetailById($catalog_id);
		//	$model = new models_CatalogDivek();
		//	$catalog = $model->getDetailById($catalog_id);

		return $catalog;

	}

	public function setMainLogo($catalog_id, $foto_id)
	{
		self::$model->setMainLogo($catalog_id, $foto_id);
	}


	public function saveAction()
	{
		// Je odeslán formulář

		if(self::$getRequest->isPost()
			&& false !== self::$getRequest->getPost('upd_catalog', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('CatalogWebEdit');
			if (false == $form->getPost('id', false)) {
				return;
			}

			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();

				$pageSaveData = self::setPageData($postdata, $form->page);

				$pageSaveData["id"] = $form->page->page_id;
				$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData["id"], $pageSaveData["version"]);







				if (self::saveData($pageSaveData, $pageVersionSaveData, $form)) {

					$pageData = self::getPageSaveData();
					$page_id = $pageData["id"];

					self::$getRequest->goBackRef();



				}
			}
		}

	}



	public function createAction()
	{
		if (self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins_catalog', false)) {
			// načtu Objekt formu
			$form = $this->formLoad('CatalogWebCreate');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost())) {
				$postdata = $form->getValues();

				$pageSaveData = self::setPageData($postdata);
				$pageSaveData["vlastnik_id"] = (int) USER_ID;

				$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData["id"], $pageSaveData["version"]);

				//     print_r($pageVersionSaveData);
				if (self::saveData($pageSaveData, $pageVersionSaveData)) {
					$pageData = self::getPageSaveData();
					$page_id = $pageData["id"];

					$resultText = "Web byl úspěšně přidán. Pokračujte prosím přidáním obrázků do fotogalerie."; //'<a href="'.URL_HOME.'admin/edit_catalog.php?id='.$page_id.'">Přejít na právě pořízený záznam.</a>';

					$form->setResultSuccess($resultText);

					//	$protokolController = new ProtokolController();
					//	$protokolController->setProtokol("Přidán podnik", "Byla přidána nová dívka <strong><a href=\"http://www.sexvemeste.cz/admin/edit_divka.php?id=" . $id . "\">" . $nazev_podniku . "</a></strong> do katalogu  (" . $id . ").");

				//	$message = 'Podnik <a href="' . URL_HOME . 'edit_podnik?id=' . $page_id . '"><strong>' . $nazev_podniku . '</strong></a> byl přidán. Nyní prosím vyčkejte na schválení od administrátora.';
				//	$modelMessage = new models_Message();
				//	if ($modelMessage->setMessage(3, USER_ID, $message)) {
				//	}
					// mail("registrace@sexvemeste.cz","Zalozeni profilu - podnik","Profil podniku byl zalozen <strong><a href=\"http://www.sexvemeste.cz/admin/edit_catalog.php?id=" . $id . "\">" . $nazev_podniku . "</a></strong> do katalogu  (" . $id . ").");
					self::$getRequest->goBackRef(URL_HOME . "edit_web?id=" . $page_id);
				} else {
					$form->setResultError(self::akcePoUlozeniSChybou());
				}
			}
		}
	}

	public function setPageData($postdata, $originalData = null)
	{
		$data = parent::setPageData($postdata, $originalData);

		/*	$name = 'youtube_id';
		   if (array_key_exists($name, $postdata)) {
		   $data[$name] = $postdata[$name];
		   }*/

		return $data;
	}

	public function setPageVersionData($postdata, $page_id, $version)
	{

		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$versionData = parent::setPageVersionData($postdata, $page_id, $version, $languageList);






		$i = 0;
		foreach ($languageList as $key => $val){

			$name = 'ftp_server';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'ftp_username';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'ftp_password';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$name = 'db_server';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'db_username';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'db_password';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$name = 'db_name';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'phpmyadmin';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'web_created';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = date("Y-m-d", strtotime($postdata[$name]));
				//	$versionData[$i][$name] = $postdata[$name];
			}

			$name = 'cms_expired';
			if (array_key_exists($name, $postdata)) {
				//	$versionData[$i][$name] = $postdata[$name];
				$versionData[$i][$name] = date("Y-m-d", strtotime($postdata[$name]));
			}
			$name = 'cms_licence_key';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$name = 'cms_version';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$i++;
		}

		//	print_r($versionData);
		//	exit;
		return $versionData;
	}





	public function sendInfoEmail($data)
	{
		//$eshop = new Eshop();
		$mail = new PHPMailer();
		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru
		$this->eshop = new Eshop();

		$cat = $this->eshop->get_category(array("id" => $data["category"]));
		//$data["kr"];


		//	print_R($this->eshop->eshop_setting);
		$mail->Host = $this->eshop->eshop_setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($this->eshop->eshop_setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;

		$mail->Username = $this->eshop->eshop_setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $this->eshop->eshop_setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci

		$mail->From = $this->eshop->eshop_setting["EMAIL_ORDER"];
		//$mail->From = "objednavky@kolakv.cz";   // adresa odesílatele skriptu
		//$mail->FromName = "Objednávka kolaKV.cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $this->eshop->eshop_setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele
		$mail->AddAddress($this->eshop->eshop_setting["INFO_EMAIL"]);  // přidáme příjemce
		//print 	$this->eshop->eshop_setting["INFO_EMAIL"];
		//$mail->AddAddress("rudolf.pivovarcik@centrum.cz");  // přidáme příjemce
		$mail->Subject = "Přidán podnik";
		//$mail->AddBCC($eshop->eshop_setting["BCC_EMAIL"]);
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);
		//$mail->AddAttachment($this->order_pdf, "objednavka.pdf");

		//$mail->AddAttachment($this->createPDF($_orders->insert_id), "objednavka.pdf");
		//	$mail->AddAttachment(dirname(__FILE__) . "/../../public/data/2011060024.pdf", "objednavka.pdf");
		//$this->createPDF($_orders->insert_id);
		//$mail->AddAttachment(dirname(__FILE__) . "/../../admin/2011060024.pdf", "objednavka.pdf");

		//	$mail->AddAttachment("/public/data/2011060024.pdf", "objednavka.pdf");
		//$mail->AddAttachment("admin/order_pdf.php?id=" . $_orders->insert_id, "objednavka.pdf");


		$mail->Body ='';
		$mail->Body .="<html>";
		$mail->Body .="<head></head>";
		$mail->Body .="<body>";

		//					$mail->Body .='Dobrý den,<br />Vaší objednávku jsme přijali ke zpracování.<br />V příloze naleznete detail objednávky<br />';
		$mail->Body .='Byl přidán nový podnik <strong>' . $data["titulek_cs"] . '</strong> z webu <strong>' . URL_DOMAIN . '</strong>.';
		$mail->Body .='<br /><br />';

		$mail->Body .="<p><label>Název podniku:</label> <strong>" . $data["titulek_cs"] . "</strong></p>";
		$mail->Body .="<p><label>Typ podniku:</label> <strong>" . $cat->nazev . "</strong></p>";
		$mail->Body .="<p><label>Kraj:</label> <strong>" . $data["kr"] . "</strong></p>";
		$mail->Body .="<p><label>Ulice, číslo:</label> <strong>" . $data["address1"] . "</strong></p>";
		$mail->Body .="<p><label>Město:</label> <strong>" . $data["address2"] . "</strong></p>";
		$mail->Body .="<p><label>Psč:</label> <strong>" . $data["zip_code"] . "</strong></p>";
		$mail->Body .="<p><label>Telefon:</label> <strong>" . $data["telefon"] . "</strong></p>";
		$mail->Body .="<p><label>Kontaktní telefon:</label> <strong>" . $data["ftelefon"] . "</strong></p>";
		$mail->Body .="<p><label>Email:</label> <strong>" . $data["titulek_cs"] . "</strong></p>";
		$mail->Body .="<p><label>WWW:</label> <strong>" . $data["www"] . "</strong></p>";
		$mail->Body .="<p><label>Vstupné:</label> <strong>" . $data["vstupne"] . "</strong></p>";

		$mail->Body .="<p><label>Otevírací doba:</label></p>";
		$mail->Body .="<p><label>Po-Pá:</label> <strong>" . $data["popa_start"] . " - " . $data["popa_end"] . "</strong></p>";
		$mail->Body .="<p><label>Út:</label> <strong>" . $data["ut_start"] . " - " . $data["ut_end"] . "</strong></p>";
		$mail->Body .="<p><label>St:</label> <strong>" . $data["st_start"] . " - " . $data["st_end"] . "</strong></p>";
		$mail->Body .="<p><label>Čt:</label> <strong>" . $data["ct_start"] . " - " . $data["ct_end"] . "</strong></p>";
		$mail->Body .="<p><label>Pá:</label> <strong>" . $data["pa_start"] . " - " . $data["pa_end"] . "</strong></p>";
		$mail->Body .="<p><label>So-Ne:</label> <strong>" . $data["sone_start"] . " - " . $data["sone_end"] . "</strong></p>";
		$mail->Body .="<p><label>Ne:</label> <strong>" . $data["ne_start"] . " - " . $data["ne_end"] . "</strong></p>";

		$mail->Body .="<p><label>Popis podniku:</label> <strong>" . $data["description_cs"] . "</strong></p>";


		/*	*/

		/*
		   $mail->Body .="<table>";


		   $mail->Body .= $mail_text;
		   $mail->Body .="</table>";
		*/
		//	$mail->Body .='děkujeme Vám za vytvoření objednávky v internetovém obchodě <a href="http://www.kolakv.cz">www.kolakv.cz</a>. Vaše objednávka byla přijata ke zpracování. V příloze Vám zasíláme kopii objednávky.';
		//	$mail->Body .='<br /><br />';
		$mail->Body .='<br /><br />Tato zpráva byla vygenerována systémem automaticky, neodpovídejte na ní!';
		$mail->Body .='<br />';
		$mail->Body .=URL_DOMAIN; // 'www.humboldt.cz';


		//					$mail->Body .='<p><a href="http://www.kolakv.cz">www.kolakv.cz</a></p>';
		$mail->Body .="</body></html>";

		return $mail->Send();
	}

	public function sendInfoEmail2($catalog_id,$data)
	{
		//$eshop = new Eshop();
		$mail = new PHPMailer();
		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru
		$this->eshop = new Eshop();

		$cat = $this->eshop->get_category(array("id" => $data["category"]));
		//$data["kr"];


		//	print_R($this->eshop->eshop_setting);
		$mail->Host = $this->eshop->eshop_setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($this->eshop->eshop_setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;

		$mail->Username = $this->eshop->eshop_setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $this->eshop->eshop_setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci

		$mail->From = $this->eshop->eshop_setting["EMAIL_ORDER"];
		//$mail->From = "objednavky@kolakv.cz";   // adresa odesílatele skriptu
		//$mail->FromName = "Objednávka kolaKV.cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $this->eshop->eshop_setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele
		$mail->AddAddress($this->eshop->eshop_setting["INFO_EMAIL"]);  // přidáme příjemce
		//print 	$this->eshop->eshop_setting["INFO_EMAIL"];
		//$mail->AddAddress("rudolf.pivovarcik@centrum.cz");  // přidáme příjemce
		$mail->Subject = "Přidán podnik";
		//$mail->AddBCC($eshop->eshop_setting["BCC_EMAIL"]);
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);
		//$mail->AddAttachment($this->order_pdf, "objednavka.pdf");

		//$mail->AddAttachment($this->createPDF($_orders->insert_id), "objednavka.pdf");
		//	$mail->AddAttachment(dirname(__FILE__) . "/../../public/data/2011060024.pdf", "objednavka.pdf");
		//$this->createPDF($_orders->insert_id);
		//$mail->AddAttachment(dirname(__FILE__) . "/../../admin/2011060024.pdf", "objednavka.pdf");

		//	$mail->AddAttachment("/public/data/2011060024.pdf", "objednavka.pdf");
		//$mail->AddAttachment("admin/order_pdf.php?id=" . $_orders->insert_id, "objednavka.pdf");


		$mail->Body ='';
		$mail->Body .="<html>";
		$mail->Body .="<head></head>";
		$mail->Body .="<body>";

		//					$mail->Body .='Dobrý den,<br />Vaší objednávku jsme přijali ke zpracování.<br />V příloze naleznete detail objednávky<br />';
		$mail->Body .='Byl přidán nový podnik <strong>' . $data["titulek_cs"] . '</strong> z webu <strong>' . URL_DOMAIN . '</strong>.';
		$mail->Body .='<br /><br />';

		$mail->Body .="<p><label>Popis služby:</label> <strong>" . $data["description2_cs"] . "</strong></p>";


		$program = new models_CatalogProgram();
		$programsList = $program->get_catalogProgramTempList2($catalog_id);

		$vybaveni = new models_CatalogVybaveni();
		$servicesList = $vybaveni->get_catalogVybaveniTempList2($catalog_id);

		$mail->Body .='<table>
			<tr>
			<td style="vertical-align:top">';


		if (count($programsList)>0)
		{

			$mail->Body .="<h4>Program</h4>
			<ul>";

			$sudy = false;
			for ($i=0;$i < count($programsList);$i++)
			{
				$mail->Body .="<li>" . $programsList[$i]->hodnota . "</li>";
			}

			$mail->Body .="</ul>";

		}
		$mail->Body .='</td>
		<td style="vertical-align:top">';

		if (count($servicesList)>0)
		{

			$mail->Body .="<h4>Vybavení</h4>
				<ul>";

			$sudy = false;
			for ($i=0;$i < count($servicesList);$i++)
			{
				$mail->Body .="<li>" . $servicesList[$i]->hodnota . "</li>";

			}

			$mail->Body .="</ul>";
		}
		$mail->Body .="</td>
		</tr>
		</table>";

		//	$mail->Body .="<p><label>Popis podniku:</label> <strong>" . $data["description_cs"] . "</strong></p>";


		/*	*/

		/*
		   $mail->Body .="<table>";


		   $mail->Body .= $mail_text;
		   $mail->Body .="</table>";
		*/
		//	$mail->Body .='děkujeme Vám za vytvoření objednávky v internetovém obchodě <a href="http://www.kolakv.cz">www.kolakv.cz</a>. Vaše objednávka byla přijata ke zpracování. V příloze Vám zasíláme kopii objednávky.';
		//	$mail->Body .='<br /><br />';
		$mail->Body .='<br /><br />Tato zpráva byla vygenerována systémem automaticky, neodpovídejte na ní!';
		$mail->Body .='<br />';
		$mail->Body .=URL_DOMAIN;


		$mail->Body .="</body></html>";

		return $mail->Send();
	}

}