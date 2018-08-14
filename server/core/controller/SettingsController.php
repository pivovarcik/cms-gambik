<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class SettingsController extends G_Controller_Action
{
	public $setting = array();


	function __construct()
	{

		parent::__construct();
		$this->getSettings();
	}
	public function getSettings()
	{
		$model = new models_Settings();
		$res =$model->getSettingsList();
		for ($i=0;$i<count($res);$i++)
		{
			$this->setting[$res[$i]->key]= $res[$i]->value;
		}



		//return $this->sql->get_row($query);
	}

	private function validLicenceKey($string)
	{

	//	print_R($string);
	//	exit;
		if (empty($string)) {
			return false;
		}
		$stringDecode = gDeCode(($string));

		$stringDecodeA = explode("|", $stringDecode);
	//	print_R($stringDecodeA);
	//	exit;
		if (count($stringDecodeA) == 2) {
			$domain = $stringDecodeA[0];
			$cmsExpire = strtotime($stringDecodeA[1]);

			if (strtoupper($domain) != strtoupper(str_replace("www.","",$_SERVER["HTTP_HOST"]))) {
				// licenční číslo je pro jinou doménu
			//		print $domain . "<>" . strtoupper($_SERVER["HTTP_HOST"]);
			//		exit;

				return false;
			}
			if (time() > $cmsExpire) {

			//	print time() . "<>" . $cmsExpire;
			//	exit;
				// licenční číslo je již neplatné
			//	return false;
			}

			return $cmsExpire;
		}

		return false;


	}

	public function saveLicenceKeyAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_licence', false))
		{

			$model = new models_Settings();

			$form = $this->formLoad('LicenceEdit');

			$postdata = $form->getValues();
			if ($cmsExpireDate = $this->validLicenceKey($postdata["licence_key"])) {

				//		print $cmsExpireDate;
				//	exit;
				$data = array();
				$data["value"] = date("Y-m-d H:i:s",$cmsExpireDate);
				$model->updateRecords($model->getTableName(), $data, "`key`='INSTALL_DATE'");

				$data["value"] =$postdata["licence_key"];

				$model->updateRecords($model->getTableName(), $data, "`key`='LICENCE_KEY'");
				return true;
			} else {

				$form->setResultError("Zadali jste neplatné licenční číslo.");
				//	break;
				return false;
			}
		}
	}
	public function saveAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd-nastaveni', false))
		{


			$model = new models_Settings();

			$upload_form_name = "F_AdminSettings_LOGO_FILE";
			if (isset($_FILES[$upload_form_name])) {
				$FotoController = new FotoController();
				if ($id = $FotoController->createFoto($upload_form_name)) {


					$key = "LOGO_FILE_ID";
					$data = array();
					$data["value"] = $id;


					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
				//	print_r($_FILES);
				//	exit;
				}
			}



			$form = $this->formLoad('AdminSettings');
		//	$postdata = $form->getValues();
			//$postdata = $_POST;



			$postdata = $form->getValues();
		//	$model = new models_Eshop();
			$settings = G_Setting::instance();

		//	print_r($postdata);
			//exit;
			foreach ($this->setting as $key => $val) {

				if (isset($postdata[$key])) {
					$data = array();
					$data["value"] = $postdata[$key];

					if (!isset($_POST[$key])) {
						//$data["value"] = 0;
					}

					if ($key == "LICENCE_KEY") {
				//	if ($postdata[$key] != $settings->get("LICENCE_KEY")) {

						if ($cmsExpireDate = $this->validLicenceKey($postdata[$key])) {

					//		print $cmsExpireDate;
						//	exit;
							$model->updateRecords($model->getTableName(), array("value" => date("Y-m-d H:i:s",$cmsExpireDate)), "`key`='INSTALL_DATE'");
						} else {
						//	break;
						}
					}
				//	}



					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
				}
			}
			$key = "WATERMARK_POS";
			$data = array();
			$data["value"] = $_POST[$key];


			$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");





			$_SESSION["statusmessage"]='Nastavení bylo uloženo.';
			$_SESSION["classmessage"]="success";
			$this->getRequest->goBackRef();
			//$this->getRequest->clearPost();
		}
	}
	public function saveLogoAjaxAction(){
		if($this->getRequest->isPost())
	//	if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd-nastaveni', false))
		{


			$model = new models_Settings();

			$upload_form_name = "file";
			if (isset($_FILES[$upload_form_name])) {
				$FotoController = new FotoController();
				if ($id = $FotoController->createFoto($upload_form_name)) {


					$key = "LOGO_FILE_ID";
					$data = array();
					$data["value"] = $id;


					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
					//	print_r($_FILES);
					//	exit;
				}
			}
          			
			$response = new StdClass();

			$form = new F_AdminSettings();
      $form->setResultSuccess('Nastavení bylo uloženo.');
			$GTabs = new SettingsTabs($form);

			$response->html = $form->Result();
			$response->html .= $GTabs->makeTabs();
			return $response;
      }
    }
	public function saveAjaxAction(){
		if($this->getRequest->isPost())
	//	if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd-nastaveni', false))
		{


			$model = new models_Settings();

			$upload_form_name = "F_AdminSettings_LOGO_FILE";
			if (isset($_FILES[$upload_form_name])) {
				$FotoController = new FotoController();
				if ($id = $FotoController->createFoto($upload_form_name)) {


					$key = "LOGO_FILE_ID";
					$data = array();
					$data["value"] = $id;


					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
					//	print_r($_FILES);
					//	exit;
				}
			}



			$form = $this->formLoad('AdminSettings');
			//	$postdata = $form->getValues();
			//$postdata = $_POST;



			$postdata = $form->getValues();
			//	$model = new models_Eshop();
			$settings = G_Setting::instance();

			//	print_r($postdata);
			//exit;
			foreach ($this->setting as $key => $val) {

				if (isset($postdata[$key])) {
					$data = array();
					$data["value"] = $postdata[$key];

					if (!isset($_POST[$key])) {
						//$data["value"] = 0;
					}

					if ($key == "LICENCE_KEY") {
						//	if ($postdata[$key] != $settings->get("LICENCE_KEY")) {

						if ($cmsExpireDate = $this->validLicenceKey($postdata[$key])) {

							//		print $cmsExpireDate;
							//	exit;
							$model->updateRecords($model->getTableName(), array("value" => date("Y-m-d H:i:s",$cmsExpireDate)), "`key`='INSTALL_DATE'");
						} else {
							//	break;
						}
					}
					//	}



					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
				}
			}
			$key = "WATERMARK_POS";
			$data = array();
			$data["value"] = $_POST[$key];


			$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


			$form->setResultSuccess('Nastavení bylo uloženo.');
			$response = new StdClass();

			$form = new F_AdminSettings();
			$GTabs = new SettingsTabs($form);

			$response->html = $form->Result();
			$response->html .= $GTabs->makeTabs();
			return $response;
		}
	}


	public function getProblemList()
	{
		$upozorneniSystemuA = array();
		$settings = G_Setting::instance();
		$userModelTest = new models_Users();
		$userDetail = $userModelTest->getUserById(1);

		if ($userDetail && $userDetail->aktivni== 1 && $userDetail->password == "78a301055dc251d6de30ee8f013bc18f") {
			array_push($upozorneniSystemuA, AlertHelper::alert("Bezpečnostní riziko! Změňte heslo pro <strong>admin</strong> účet! Je použito univerzální heslo.","danger"));
		}

		if ($settings->get("google_analytics_key") == "") {
			array_push($upozorneniSystemuA,AlertHelper::alert("<strong>Není vyplněn <strong>kód Google Analytics</strong> pro sledování statistik přístupů návštěvníků!","warning"));
		}

    $mail_error = $settings->get("EMAIL_ERROR");
		if (!empty($mail_error)) {

			if ($settings->get("EMAIL_ERROR") == "!") {
				array_push($upozorneniSystemuA,AlertHelper::alert("<strong>SMTP server není ověřen</strong> Bez něj nemůže systém odesílat emaily!","warning"));
			} else {
				array_push($upozorneniSystemuA,AlertHelper::alert("SMTP server ohlásil chybu <strong>" . $settings->get("EMAIL_ERROR") . "</strong> Zkontrolujte nastavení odchozí pošty!","danger"));
			}

		}


	//	$filename = PATH_HOME. "robots.txt";
    $filename = PATH_HOME. "export/robots.php";
    
  //  print $filename;
		//$file = file_get_contents($filename);
		if(!is_file($filename)) {
			array_push($upozorneniSystemuA,AlertHelper::alert("Neexistuje konfigurační soubor <strong>robots.txt</strong>! Některé vyhledávače vyžadují přítomnost souboru.","warning"));
		}

		$filename = PATH_HOME. "export/sitemap.php";
		if(!is_file($filename)) {
			array_push($upozorneniSystemuA,AlertHelper::alert("<strong>Neexistuje soubor <strong>sitemap.xml</strong>! Některé vyhledavče vyžadují přítomnost souboru.","warning"));
		}     



		if(7 > phpversion()) {
			array_push($upozorneniSystemuA,AlertHelper::alert("Vaše verze PHP <strong>" . phpversion() . "</strong> je zastaralá. Přejděte prosím na ve verzi PHP 7.","warning"));
		}

		$start = date("Y-m-d H:i:s",strtotime($settings->get("INSTALL_DATE")));
		//print $start;
		$date_diff = diff(date("Y-m-d H:i:s"), date("Y-m-d H:i:s",strtotime($settings->get("INSTALL_DATE"))+(365 * 24 * 3600)) );
		//print_r($date_diff);
		$expirate_system = "";
		$licence_info = "";


		if ($date_diff["day"] < 60  && $date_diff["day"] > 0) {
			//print
			$expirate_system = (date("j.n.Y",strtotime($settings->get("INSTALL_DATE"))+(365 * 24 * 3600)));
			//	$licence_info = 'Blíží se vypršení licence (' . $expirate_system . ') k užívání systému. Zbývá <strong>' . $date_diff["day"] . ' dnů.</strong>';
		} else {
			//$licence_info = 'Licence do: ' . $expirate_system . ', (zbývá ' . $date_diff["day"] . 'dnů)<a href="' . URL_HOME . '" title="O aplikaci">v' . VERSION_RS . '</a>';
		}

		$style_main = '';
		if ($date_diff["day"] <= 0) {
		//	define("disabled_cms","1");
			$licence_info = 'POZOR! Licence k používání CMS systému již vypršela. Užívání systému je nyní omezené!';
			$style_main=' style="background-color:#AA1600;"';
		} elseif($date_diff["day"] <= 30) {
			$licence_info = 'POZOR! Licence k používání CMS systému brzy vyprší. Užívání systému bude omezeno! Kontaktujte obchodníka';
			//	$style_main=' style="background-color:#AA1600;"';
		}
		if (!empty($licence_info)) {
			array_push($upozorneniSystemuA, AlertHelper::alert($licence_info,"danger"));
		}

		return $upozorneniSystemuA;
	}
}