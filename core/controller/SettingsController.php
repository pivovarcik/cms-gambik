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

			$upload_form_name = "Application_Form_AdminSettings_LOGO_FILE";
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
}