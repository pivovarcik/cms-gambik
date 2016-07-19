<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class SmsGateController extends G_Controller_Action
{
	public $search_destination = array();

	private $login_smsbrana = ""; //"taxikomat_h1";
	private $pwd_smsbrana = ""; //"3010d624";
	private $enabledGate = false;

	public function __construct()
	{
		parent::__construct();
		$settings = G_Setting::instance();

		$this->login_smsbrana = $settings->get("SMSBRANA_LOGIN");
		$this->pwd_smsbrana = $settings->get("SMSBRANA_PWD");

		if (!empty($this->login_smsbrana) && !empty($this->pwd_smsbrana)) {
			$this->enabledGate = true;
		}
	}
	public function isGateEnabled()
	{
		return $this->enabledGate;
	}
	public function odchoziSmsList($params = array())
	{
		$model = new models_SmsGate();
		$list = $model->getOdchoziSmsList($params);
		return $list;
	}

	public function odchoziSmsListEdit($params = array())
	{

		$list = $this->odchoziSmsList($params);

		for ($i=0;$i<count($list);$i++)
		{

			$list[$i]->TimeStamp = date('j.n.Y H:i:s',strtotime($list[$i]->TimeStamp));

			//	$list[$i]->caszapsani = date('j.n.Y H:i:s',strtotime($list[$i]->caszapsani)) ;
		}
		return $list;
	}

	public function prichoziSmsList($params = array())
	{
		$model = new models_SmsGate();
		$list = $model->getPrichoziSmsList($params);
		for ($i=0;$i<count($list);$i++)
		{
			$list[$i]->TimeStamp = date('j.n.Y H:i:s',strtotime($list[$i]->TimeStamp));
			$list[$i]->time = date('j.n.Y H:i:s',strtotime($list[$i]->time));

		}
		return $list;
	}
	public function getPrichoziSms($id)
	{
		$model = new models_SmsGate();
		$row = $model->getPrichoziSms($id);
		$row->TimeStamp = date('j.n.Y H:i:s',strtotime($row->TimeStamp));

		return $row;
	}

	public function prichoziSmsListEdit($params = array())
	{

		$list = $this->prichoziSmsList($params);

		for ($i=0;$i<count($list);$i++)
		{

			$list[$i]->TimeStamp = date('j.n.Y H:i:s',strtotime($list[$i]->TimeStamp));
			//	$list[$i]->caszapsani = date('j.n.Y H:i:s',strtotime($list[$i]->caszapsani)) ;
		}
		return $list;
	}
	public function sendSmsAction()
	{
		if($this->getRequest->isPost() && "send_sms" === $this->getRequest->getPost('Application_Form_SmsCreate_action', false))
		{
			// načtu Objekt formu

			//	error_reporting(E_ERROR);
			//	error_reporting(E_ALL);
			//	ini_set("display_errors", 1);

			//print "tudy";
			/*	*/
			$form = $this->formLoad('SmsCreate');
			// Provedu validaci formu


			if ($form->isValid($form->getPost()))
			{
				$postdata = $form->getValues();
				// translator
				$message = utfx($postdata["message"]);


				$number = trim($postdata["phone"]);

				$searched = array();
				$searched[] = " ";
				$searched[] = "+";

				$replaced = array();
				$replaced[] = "";

				$number = str_replace($searched, $replaced, $number);
				$number = $number*1;
				if ((strLen($number) == 9 || strLen($number) == 12) && is_int($number)) {

				} else {
					$form->setResultSuccess("Telefonní číslo není ve správném tvaru!");
					//	$_SESSION["statusmessage"]= "Telefonní číslo není ve správném tvaru!";
					//	$_SESSION["classmessage"]="errors";
					return false;
				}


				if ($this->sendSms($number,$message)) {
					$model = new models_Sms();
					$data = array();
					//$data["TimeStamp"] = date('Y-m-d H:i:s');
					$data["phone"] 	= $number;
					$data["message"] 	= $message;
					$data["price"] 	= 1;
					$data["autor_id"] 	= USER_ID;

					if ($model->insert($data)) {
						$form->setResultSuccess("SMS zpráva byla odeslána.");
						return true;
						//$this->getRequest->goBackRef();
					}
				} else {
					$form->setResultError("SMS zpráva nebyla odeslána!");
					$result = array();
					$result["status"] = "wrong";
					$json = json_encode($result);
					print_r($json);
					exit;
				}



			}
		}
	}

	public function getCreditInfo()
	{

		if (!$this->isGateEnabled()) {
			return 0;
		}

			require_once(PATH_ROOT . 'plugins/smsbrana/connect.php');
		//	require_once(PATH_ROOT . 'core/library/connect/connect.php');
		$sms = new CSMSConnect();
		//CSMSConnect::AUTH_HASH
		$sms->Create($this->login_smsbrana, $this->pwd_smsbrana,2);
			$myXMLData = $sms->getCreditInfo();

		//http://api.smsbrana.cz/smsconnect/http.php?login=pivovarcikcz_h1&password=ff1d4b28&action=credit_info

		//	$url = "http://api.smsbrana.cz/smsconnect/http.php?login=" . $this->login_smsbrana . "&password=" . $this->pwd_smsbrana . "&action=credit_info";

		$xml=simplexml_load_string($myXMLData);

	//	$file = file_get_contents($url);
		if ($xml->err == 0) {
			return $xml->credit;
		}
		return 0;
	//	print_r($xml);

	}
	private function sendSms($number,$message)
	{
		//return true;
		//$number, $message;
		require_once(PATH_ROOT . 'plugins/smsbrana/connect.php');
		//	require_once(PATH_ROOT . 'core/library/connect/connect.php');
		$sms = new CSMSConnect();
		//CSMSConnect::AUTH_HASH
		$sms->Create($this->login_smsbrana, $this->pwd_smsbrana,2); // inicializace a prihlaseni login, heslo, typ zabezpeceni
		// pridani nekolika sms do fronty
		// SMS odesilejte bez diakritiky !!!
		$sms->Add_SMS($number, $message);
		//$sms->Add_SMS("1234","test");
		//$sms->Add_SMS("+420733781178","test");
		$xmlString = $sms->SendAllSMS();

		$result = false;
		if ($xmlString) {

			$xml = new SimpleXMLElement($xmlString);

			/*
			   <?xml version="1.0" encoding="utf-8"?>
			   <result>
			   <you_send_time>19.02.2015 21:09:34</you_send_time>
			   <server_time>19.02.2015 21:22:02</server_time>
			   <err>4</err>
			   </result>

			*/

			if ($xml->err == 0) {
				$result = true;
			}




			//	print "kod chyby:". (string)$xml->err . "<br />";
			//	print_r($xml);



		}
		//print_r($sms->SendAllSMS());
		$sms->Logout();
		return $result;
	}
	public function PremiumSmsAgmoAction()
	{
		if($this->getRequest->isPost())
		{


			// Příjem informace o doručence
			if (isset($_POST["methodName"]) &&  $_POST["methodName"] == "receiveDlr") {

				if (isset($_POST["statusDesc"]) ) {


					switch ($_POST["statusDesc"]) {
						case "Not delivered":
							$statusDorucenky = "OK";
							break;
						case "Delivered":
							$statusDorucenky = "OK";
							break;
						default:
						;
					} // switch
				}

				header("HTTP/1.0 200 OK");
				header('Content-Type: text/plain');
				printf($statusDorucenky . "\r\n");
				exit;

			}
			// Přjem SMS od zákazníka

			if (isset($_POST["methodName"]) &&  $_POST["methodName"] == "receiveSmsMO") {
				//methodName = receiveSmsMO
				/*
				   $_POST["messageId"]; // ID zprávy
				   $_POST["appNumber"]; // placené číslo
				   $_POST["mobileNumber"]; // odesíltael
				   $_POST["messageText"]; // zpráva
				   $_POST["messageText"]; // zpráva
				   $_POST["billCode"]; // cena

				   $_POST["prefix1"]; // klíčové slovo
				   $_POST["prefix2"]; // za klíčovým slovem
				   //$message = "test".var_dump($_POST); //$_POST;

				*/
				//	billCode=CZK0000030

				$price = substr($_POST["billCode"],3,strlen($_POST["billCode"]));
				if (isset($_POST["prefix2"])) {
					$user_id = (int) $_POST["prefix2"];
					$PenezenkaController = new PenezenkaController();
					$description = "Dobití kreditu přes SMS.";
					$castka = $price * 1; //$_POST["billCode"];
					$PenezenkaController->dobitKredit($user_id,$castka,$description);
				}

			}








			// translator
			$message = $_POST["messageText"];


			$number = $_POST["mobileNumber"];

			$model = new models_SmsGate();
			$data = array();
			//$data["TimeStamp"] = date('Y-m-d H:i:s');
			$data["phone"] 	= $number;
			$data["message"] 	= $message;
			$data["price"] 	= 1;
			if ($model->insertRecords("mm_prichozi_sms", $data)) {

				$clientMessageId = $model->insert_id;
				//$_SESSION["statusmessage"]="SMS zpráva byla přijata.";
				//$_SESSION["classmessage"]="success";

				//$this->getRequest->goBackRef();

				// return ok and response
				header("HTTP/1.0 200 OK");
				header('Content-Type: text/plain');


				$responses = array(

								/*
								   array(
								   'methodName' => 'sendSmsMO',
								   'messageText' => "Děkujeme za dobití kreditu. SexVeMeste.cz",
								   'dataType' => '0',
								   'clientMessageId' => $clientMessageId
								   ),
								*/
				//methodName=sendWapPush&contentUrl=Client%2Ecom%3Fcode%3Dxxxxx&contentTitle=Client%2Ecom&clientMessageId=XYZ

				array(
				    'methodName' => 'sendSmsMT',
				    'messageText' => "Děkujeme za dobití kreditu.",
				    'dataType' => '0',
				    'clientMessageId' => $clientMessageId
				),

				//here you can add next responses
			);
				printf("OK\r\n");
				foreach ($responses as $response) {
					printf("%s\r\n", http_build_query($response));
				}

				//methodName=sendSmsMT&messageText=Thanks%20for%20your%20sms&clientMessageId=ABC methodName=sendWapPush&contentUrl=Client%2Ecom%3Fcode%3Dxxxxx&contentTitle=Client%2Ecom&clientMessageId=XYZ


			}


		}
	}


	// Zapíšu příchozí SMS
	public function setSmsLog($number, $message, $sms_id, $time)
	{
		$model = new models_SmsGate();

		$data = array();
		$data["TimeStamp"] = date('Y-m-d H:i:s');
		$data["phone"] 	= $number;
		$data["message"] 	= $message;
		$data["price"] 	= $price;
		$data["sms_id"] 	= $sms_id;
		$data["time"] 	=  date('Y-m-d H:i:s',strtotime($time));
		$data["code"] 	= strToUpper(nahodny_klic(8));

		if ($model->insertRecords($model->getTableName(), $data)) {


		}


		//return $model->log_sms($number, $message);
	}
	public function setSmsLog2($number, $message)
	{
		$model = new models_SmsTaxi();
		$searchTaxiController = new SearchTaxiController();

		$message_pole = explode("*", $message);
		$odkud = $message_pole[2];
		$kam = $message_pole[3];
		//print $list[$i]->message;
		//print "Odkud:" . $odkud . " kam:" . $kam . "<br />";
		$souradnice_odkud = $searchTaxiController->searchFromGoogleMaps($odkud,"");

		$list[$i]->odkud_souradnice = $souradnice_odkud[2] . "," . $souradnice_odkud[3];

		$souradnice_kam = $searchTaxiController->searchFromGoogleMaps($kam,"");
		$list[$i]->kam_souradnice = $souradnice_kam[2] . "," . $souradnice_kam[3];


		$data = array();
		$data["caszapsani"] = date('Y-m-d H:i:s');
		$data["phone"] 	= $number;
		$data["message"] 	= $message;
		$data["price"] 	= $price;

		$data["odkud"] 	= $searchTaxiController->searchAddressFromGoogleMaps($souradnice_odkud[2] . "," . $souradnice_odkud[3]);
		$data["kam"] 	= $searchTaxiController->searchAddressFromGoogleMaps($souradnice_kam[2] . "," . $souradnice_kam[3]);
		$data["odkud_pos"] 	= $souradnice_odkud[2] . "," . $souradnice_odkud[3];
		$data["kam_pos"] 	= $souradnice_kam[2] . "," . $souradnice_kam[3];
		$data["code"] 	= strToUpper(nahodny_klic(8));

		if ($model->insertRecords($model->getTableName(), $data)) {
			//$model->insert_id;
			$route_mapa = $searchTaxiController->googleMapsDirections($data["odkud_pos"], $data["kam_pos"],'cz',false);

			$gmaps = new gmaps3simple(array('id'=>'map_new'));
			$url = $gmaps->staticMapRender($data["odkud_pos"] . "|" . $data["kam_pos"], $route_mapa,"180x180");

			//	define('PATH_IMG', dirname(__FILE__).'/foto/');
			$file_name = $model->insert_id . "-mapa.jpg";

			copy($url,PATH_IMG . $file_name) or Die ('Při ukládání souboru nastala chyba.');

			$updateData = array();
			$updateData["route_image"] 	= $file_name;
			$updateData["distance"] 	= $searchTaxiController->distance;
			$updateData["duration"] 	= $searchTaxiController->duration;
			$updateData["odkud"] 	= $searchTaxiController->start_address;
			$updateData["kam"] 	= $searchTaxiController->end_address;

			$data["odkud_pos"] 	= $searchTaxiController->start_location;
			$data["kam_pos"] 	= $searchTaxiController->end_location;

			$updateData["route_mapa"] 	= mysql_real_escape_string($route_mapa);
			$model->updateRecords($model->getTableName(), $updateData, "uid=" . $model->insert_id);


		}


		//return $model->log_sms($number, $message);
	}
}