<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 *
 */

class MailingController extends G_Controller_Action
{
	public $total = 0;
	public $exception_text = "";

	private $from;
	private $bcc;

	public function mailingListEdit($params = array())
	{
		$l = $this->mailingList($params);

		for ($i=0;$i < count($l);$i++)
		{
			$url = URL_HOME . "admin/edit_mail.php?id=" . $l[$i]->id;

			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{

				$uid = $l[$i]->uid;
				$elemUid = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemUid->setAttribs('value', $value);
				$elemUid->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemUid->render();

				$titulek = $l[$i]->titulek_cs;
				//	$l[$i]->name = '<a href="' . $url . '">' . $l[$i]->name . '</a>';

				$elemTitulek = new G_Form_Element_Text("titulek_cs[" . $i . "]");
				$value = $this->getRequest->getPost("titulek_cs[" . $i . "]", $titulek);
				$elemTitulek->setAttribs('value',$value);
				$l[$i]->titulek_cs = $elemTitulek->render();

				$elemDescription = new G_Form_Element_Textarea("description_cs[" . $i . "]");
				$elemDescription->setAttribs(array("id"=>"description_cs"));
				$value = $this->getRequest->getPost("description_cs[" . $i . "]", $l[$i]->description_cs);
				$elemDescription->setAttribs('value',$value);
				$l[$i]->description_cs = $elemDescription->render();


				/**
				 * Umístění v TREE
				 * */
				$elemUmisteni = new G_Form_Element_Select("category[" . $i . "]");
				$value = $this->getRequest->getPost("category[" . $i . "]", $l[$i]->category);
				$elemUmisteni->setAttribs('value',$value);
				$elemUmisteni->setAttribs('style','width:100px;');

				$pole = array();
				$attrib =array();
				$pole[0] = " -- bez umístění -- ";
				foreach ($productUmisteniList as $key => $value)
				{
					//$pole[$value->uid] = $value->nazev_cs;

					$pole[$value->uid] = $value->nazev;

					//if () {
					$attrib[$value->uid]["class"] = "vnoreni" . $value->vnoreni;

					//print_r($value->nazev);

				}
				$elemUmisteni->setMultiOptions($pole,$attrib);
				$l[$i]->category_nazev = $elemUmisteni->render();

				//$elemDescription->setAttribs('class','mceEditorX');
				//$elemDescription->setAttribs('label','Popis produktu:');
				$l[$i]->cmd = '';

			} else {


				$klic_ma = $l[$i]->id;
				$titulek = $l[$i]->subject;

				$l[$i]->counter = ($i+1) . ".";

				$uid = $l[$i]->uid;
				$elemUid = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$value = $l[$i]->uid;
				$elemUid->setAttribs('value', $value);
				//$elemUid->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemUid->render();

				$datum_vlozeni = date("j.n.Y H:i", strtotime($l[$i]->TimeStamp)) . ' <a title="Zobrazit detail uživatele: ' . $l[$i]->user_id . '" href="'.URL_HOME.'admin/user_detail.php?id='.$l[$i]->user_id.'">' . $l[$i]->nick . '</a>';

				$datum_precteno ='<br />Nepřečteno';
				if (!empty($l[$i]->ReadTimeStamp)) {
					$datum_precteno ='<br /><span style="color:#13B754;font-weight:bold;">' . date("j.n.Y H:i", strtotime($l[$i]->ReadTimeStamp)).'</span>';
				}
				$l[$i]->vlozeno_zmeneno = $datum_vlozeni . $datum_precteno;

				$adresati_text = '';
				if ($l[$i]->adresat_pocet > 1) {
					$adresati_text = ' + '.($l[$i]->adresat_pocet-1).'';
				}
				$l[$i]->adresati = $l[$i]->email . $adresati_text;

				$l[$i]->description = trim(truncate(trim(strip_tags($l[$i]->description)),150));
			}
		}
		return $l;
	}
	public function mailingList($params = array())
	{

		$model = new models_Mailing();

		$limit 	= $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}

		if (isset($params['odesilatel']) && is_numeric($params['odesilatel'])) {
			$odesilatel = $params['odesilatel'];
		}

		$page 	= $this->getRequest->getQuery('pg', 1);

		$search_string = $this->getRequest->getQuery('q', '');


		$querys = array();
		$querys[] = array('title'=>'Předmět','url'=>'title','sql'=>'t1.subject');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'t1.description_cs');
		$querys[] = array('title'=>'Zařazení','url'=>'cat','sql'=>'t5.nazev_' . $znak);
		$querys[] = array('title'=>'Město','url'=>'city','sql'=>'t2.mesto');

		$querys[] = array('title'=>'Vloženo','url'=>'add','sql'=>'t1.TimeStamp');
		$querys[] = array('title'=>'Editace','url'=>'edit','sql'=>'t1.ChangeTimeStamp');


		if (isset($params['order']) && !empty($params['order'])) {
			$orderFromQuery = $params['order'];
		}


		$l = $model->getList(array(
						'limit' => $limit,
						'search' => $search_string,
						'page' => $page,
						'order' => $orderFromQuery,
						'autor' => $odesilatel,
						'debug' => 0,
						));
		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}
	public function readEmailAction()
	{
		if($this->getRequest->isGet() && false !== $this->getRequest->getQuery('v', false))
		{
			$model = new models_Mailing();
			$data2= array();
			$visit = $this->getRequest->getQuery('v', false);
			$data2["ReadTimeStamp"] = date("Y-m-d H:i:s");
			$model->updateRecords(T_NEWSLETTER_STATUS,$data2,"visitor='" . $visit . "' and ReadTimeStamp is null");
		}
	}


	function __construct()
	{

		parent::__construct();
		$this->inicializujPostu();
	}



	public function getBCC()
	{
		return $this->bcc;
	}
	public function getFrom()
	{
		return $this->from;
	}
	private function inicializujPostu()
	{
		//$eshopController = new EshopController();
		$mail = new PHPMailer();

		$mail->Body ='';


		$settings = G_Setting::instance();

		if ( $settings->get("EMAIL_SMTP_SEND") =="1")
		{
			$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		}

		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru


		$this->from = $settings->get("EMAIL_ORDER");
		$mail->Host = $settings->get("EMAIL_SMTP_SERVER");
		$mail->SMTPAuth = ($settings->get("EMAIL_SMTP_AUTH")) ? true : false;

		if (isInt($settings->get("EMAIL_SMTP_PORT"))) {
			$mail->Port = $settings->get("EMAIL_SMTP_PORT"); //465;
		}


		if (($settings->get("EMAIL_SMTP_CERT") !="")) {
			$mail->SMTPSecure = $settings->get("EMAIL_SMTP_CERT"); //465;
		}
           /*
			$mail->SMTPDebug= 2;
			$mail->Debugoutput= "html";
		$mail->SMTPSecure = "tls";
    $mail->Port = 465;
    */

		$mail->Username = $settings->get("EMAIL_USERNAME");  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $settings->get("EMAIL_PWD");           // heslo pro SMTP autentizaci

		// adresa odesílatele skriptu
		$mail->From = $settings->get("EMAIL_ORDER");

		$this->bcc = $settings->get("BCC_EMAIL");
		// jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $settings->get("EMAIL_ORDER_ALIAS"); //"Objednávka"; // jméno odesílatele

		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);

		return $mail;
	}       
  
  // Nový zpusob odesilani newsletteru - puvodni ponechan
	public function odeslatNewsletter2($newsletter_id, $komu, $predmet, $zprava, $property = array())
	{

		$settings = G_Setting::instance();
		$hash = strtolower(substr(md5(rand()),0,50));
		$link_odhlaseni = URL_HOME2 . "newsletter-odhlaseni?email=" . $komu . "&v=" . $hash;
		$link_odhlaseni = str_replace("//","/" ,URL_HOME2 . $link_odhlaseni );
		$link .= "?v=" . $hash;



    
		$model = new models_Newsletter();

		$sablona = $model->getDetailById($newsletter_id);

		if (!$sablona) {
			return;
		}
    if (is_null($property)){
    
    
    
      $property = array();
  		$property["NEWS_LINK"] = $link;
  		$property["NEWS_LINK_ODHLASENI"] = $link_odhlaseni;
  		$property["NEWS_EMAIL_ODBERATEL"] = $komu;
    }
    
    
    $property["NEWS_LINK_ODHLASENI"] = URL_HOME_SITE . "odhlaseni-newsletter?email=" . $komu. "&V=" . $hash;
    $property["NEWS_LINK_GDPR"] = URL_HOME_SITE . "gdpr?m=" . $komu. "&hash=" . $hash;

    
    
     $property["NEWS_EMAIL_HASH"] = $hash;
    if (is_null($predmet)){
       $predmet =  $sablona->subject;
    }
    $predmet =  propertyToText($predmet,$property);
    

    if (is_null($zprava)){
       $zprava =  $sablona->html;
       $zprava .=  $sablona->html_footer;
    }
    $zprava =  propertyToText($zprava,$property);
    
    

		$res .= $zprava;

	//	$res .= propertyToText($sablona->html_footer,$property);

    
    if ($this->odeslatEmail($komu,$predmet,$res,"","",FALSE, $newsletter_id))
    {
      // zaspat odesláno
      
      return true;
    }
		return false;


	}
	public function odeslatNewsletter($komu, $predmet, $zprava, $link)
	{

		$settings = G_Setting::instance();
		$visit = strtolower(substr(md5(rand()),0,50));
		$link_odhlaseni = URL_HOME2 . "newsletter-odhlaseni?email=" . $komu . "&v=" . $visit;
		$link_odhlaseni = str_replace("//","/" ,URL_HOME2 . $link_odhlaseni );
		$link .= "?v=" . $visit;


		$model = new models_Newsletter();

		$sablona = $model->getDetailById(1);

		if (!$sablona) {
			return;
		}
		$property = array();
		$property["NEWS_LINK"] = $link;
		$property["NEWS_LINK_ODHLASENI"] = $link_odhlaseni;
		$property["NEWS_EMAIL_ODBERATEL"] = $komu;

		//print_r($property);
		//define("NEWS_LINK",$link);
		//define("NEWS_LINK_ODHLASENI",$link);
		$res = propertyToText($sablona->html,$property);
	/*
		$res .='<html>
							<head>
							<title></title>';


		$res .= '<style>' . $settings->get("TINY_CSS") . '</style>';
		$res .='</head>
							<body style="margin: 0; padding: 0;">';


		$res .='<div style=" background-color:#afc92a;font-family: Verdana,sans-serif;font-size:12px;height:100%">
						   <div style="max-width:650px;margin:0 auto;padding:25px 0;">';



		$res .='<div style="background-color: rgb(230, 230, 230);color: rgb(153, 102, 0);font-size: 11px;padding: 2px 15px;">Email se Vám nezobrazuje správně?
						   <a href="' . $link. '">Podívejte se na něj ve Vašem prohlížeči.</a>
						   </div>';

		$res .='<div style="padding: 0;background-color: #fff;">';
		$res .='<img alt="DK Ostrov" width="100%"  src="http://www.dk-ostrov.cz/public/style/images/dk_newsletter.jpg" />';
		$res .='</div>';

		$res .='<div style="padding: 15px;background-color: #fff;overflow:hidden;clear:both;">';

		*/
		$res .= $zprava;

		$res .= propertyToText($sablona->html_footer,$property);
/*
		$res .='</div>';
		$res .='<div style="background-color:rgb(255, 255, 204);font-size:11px;color:rgb(153, 102, 0);padding:15px;">
						Newsletter DK Ostrov<br><br>
						<a style="color:rgb(255, 102, 0);" href="' . $link_odhlaseni. '">Odhlásit</a> email <a style="color:rgb(255, 102, 0);" href="mailto:' . $komu. '">' . $komu. '</a> z tohoto mail listu.<br><br>
		Email:<br><a style="color:rgb(255, 102, 0);" href="mailto:info@dk-ostrov.cz" >info@dk-ostrov.cz</a><br><br>Telefon:<br>353 800
		511<br><br>Copyright (C) 2014 DK Ostrov Všechna práva vyhrazena.</div>
		</div>'; // vnitřní center


		$res .='</div>'; // hlavní rám
		$res .='</body></html>'; // hlavní rám
		*/

		//	print $res;
		//	exit;
		return $this->odeslatEmail($komu,$predmet,$res,"","",FALSE);


	}

	public function createAjaxAction()
	{
		if($this->getRequest->isPost() && "ins_mail" === $this->getRequest->getPost('F_MailCreate_action', false))
		{
			// načtu Objekt formu

			$form = $this->formLoad('MailCreate');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{
				$model = new models_Mailing();
				$postdata = $form->getValues();


				if ($this->odeslatEmail($postdata["adresat_id"],$postdata["subject"],$postdata["description"])) {
					$form->setResultSuccess("SMS zpráva byla odeslána.");
					return true;
				} else {
					$form->setResultError($this->exception_text);
				}


			}
		}
	}

	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_mail', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('MailCreate');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{
				$model = new models_Mailing();
				$postdata = $form->getValues();


				if ($this->odeslatEmail($postdata["adresat_id"],$postdata["subject"],$postdata["description"])) {
					$form->setResultSuccess("Email byl odeslán.");
					$this->getRequest->goBackRef();
				}


			}
		}
	}

	// zapíše email do DB
	private function createEmail($komu,$subject,$body,$visit, $newsletter_id = null)
	{
		$model = new models_Mailing();

		$data = array();
		//	$data["email"] = $komu;
		$data["subject"] = $subject;
		$data["description"] = $body;

		if (defined("USER_ID")) {
			$data["user_id"] = USER_ID;
		}

		$model->setData($data);
		if($model->insert())
		{
			//	$visit = strtolower(substr(md5(rand()),0,50));
			$id = $model->insert_id;

			$protokolController = new ProtokolController();
			$protokolController->setProtokol("Odeslán email","Byl vytvořen nový email (" . $id . ").");


			$data2= array();
			$data2["email"] = $komu;
			$data2["visitor"] = $visit;
			$data2["mailing_id"] = $id;
			$data2["newsletter_id"] = $newsletter_id;
			$model->insertRecords(T_NEWSLETTER_STATUS,$data2);

			return true;
		}
		return false;
	}

	public function checkSmtpServerAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('smtp_check', false))
		{
			if ($this->checkSmtpServer()) {
				/*
				$response = new StdClass();

				$form = new F_AdminSettings();
				$GTabs = new SettingsTabs($form);
$form->setResultSuccess('Ověřeno.');
				$response->html = $form->Result();
				$response->html .= $GTabs->makeTabs();
				return $response;*/
				return true;
			}
		}
	}
	public function checkSmtpServer()
	{
		$komu = "rudolf.pivovarcik@centrum.cz";
		$predmet = "Test SMTP serveru";
		$zprava = "Testování SMTP serveru";
		$mail = $this->inicializujPostu();

		$mail->AddAddress($komu);  // přidáme příjemce
		$mail->Subject = $predmet;
		$mail->Body = $zprava;
		$model = new models_Settings();
		if ($mail->send()) {

			$model->updateRecords($model->getTableName(),array("value"=> ""), "`key`='EMAIL_ERROR'");

			return true;
		} else{
			$this->exception_text = $mail->exception_text;
			//	if ("SMTP Error: Could not authenticate." == $mail->exception_text) {
			$model->updateRecords($model->getTableName(),array("value"=> $mail->exception_text), "`key`='EMAIL_ERROR'");
			//	}
			return false;

		}


	}
	public function odeslatEmail($komu,$predmet,$zprava,$priloha='',$prilohaName='', $skryta_kopie=false , $newsletter_id = null)
	{
		if (isEmail($komu)) {
			$visit = strtolower(substr(md5(rand()),0,50));
			$mail = $this->inicializujPostu();

			$mail->AddAddress($komu);  // přidáme příjemce
			$mail->Subject = $predmet;

			//	$zprava .='<img src="' . URL_HOME . 'audit.php?v='.$visit.'"/>';

			$mail->Body = $zprava;



			// 	print $mail->Body;

			//	exit;
			if (isEmail($skryta_kopie)) {
				$mail->AddBCC($skryta_kopie);
			}
                  /*
            print  is_array($priloha);
      print  $prilohaName;
      
      print_r($priloha);
           exit;

                */
      if (is_array($priloha)) {
         foreach ($priloha as $key => $val)
         {
           // $mail->AddAttachment($val, $prilohaName[$key]);
            $mail->AddAttachment($val, $key);
         }
      } else {
    		if (!empty($priloha)) {
    			$mail->AddAttachment($priloha, $prilohaName);
    		}      
      }

			//	return $mail->send();
			if ($mail->send()) {
				return $this->createEmail($komu,$predmet,$zprava,$visit, $newsletter_id);
			} else{
				$this->exception_text = $mail->exception_text;
			//	if ("SMTP Error: Could not authenticate." == $mail->exception_text) {
					$model = new models_Settings();
					$model->updateRecords($model->getTableName(),array("value"=> $mail->exception_text), "`key`='EMAIL_ERROR'");
			//	}

			}
		}
		return false;

	}

}
