<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */



class EshopController extends G_Controller_Action
{
	public $setting = array();

	function __construct()
	{

		parent::__construct();
		//$this->getSettings();
	}
	public function getSettings()
	{
		$model = new models_Eshop();
		$res =$model->getSettingsList();
		for ($i=0;$i<count($res);$i++)
		{
			$this->setting[$res[$i]->key]= $res[$i]->value;
		}

		//return $this->sql->get_row($query);
	}


	public function setEshopCategoryAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('set_cat_shop', false))
		{
			$cat_id = (int) $this->getRequest->getQuery("id",false);

			if ($this->setCategory($cat_id)) {

			}
			$this->getRequest->goBackRef();
		}
	}

	public function isEshopCategory($cat_id)
	{
		$key = "ESHOP_CATEGORY_LIST";
		$eshopSettings = G_EshopSetting::instance();

		$pole = explode("|",$eshopSettings->get($key));
		if (in_array($cat_id, $pole)) {
			return true;
		}
		return false;
	}
	public function setCategory($cat_id)
	{
		$key = "ESHOP_CATEGORY_LIST";

		$eshopSettings = G_EshopSetting::instance();

		$pole = explode("|",$eshopSettings->get($key));

		if ($this->isEshopCategory($cat_id)) {


			foreach ($pole as $key2 => $val) {
				if ($cat_id == $val) {

				//	print "unset" . $pole[$key2];
					unset($pole[$key2]);
					break;
				}
			}
		//	print_R($pole);

		//	print "odebrat";
		} else {

			array_push($pole, $cat_id);

		//	print "pridat";
		}
		$model = new models_Eshop();
		$value = implode("|", $pole);
		$data = array();
		$data["value"] = $value;

		//print $value;
		$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
		return true;
	}

	public function getLayoutMainSelected()
	{
		$eshopSettings = G_EshopSetting::instance();


		$key = "LEFT_PANEL_ON";
		$leftPanelOn = $eshopSettings->get($key);
		$key = "RIGHT_PANEL_ON";
		$rightPanelOn = $eshopSettings->get($key);
		$key = "ESHOP_MENU_POS";
		$menuPos = $eshopSettings->get($key);

		// && $menuPos == "LEFT"
		if ($leftPanelOn == "1" && $rightPanelOn == "1") {
			return 1;
		}
		// && $menuPos == "TOP"
		if ($leftPanelOn == "1" && $rightPanelOn == "0") {
			return 2;
		}
// && $menuPos == "TOP"
		if ($leftPanelOn == "0" && $rightPanelOn == "1") {
			return 3;
		}
// && $menuPos == "TOP"
		if ($leftPanelOn == "0" && $rightPanelOn == "0") {
			return 4;
		}
	}

	public function getLayoutShopSelected()
	{
		$eshopSettings = G_EshopSetting::instance();


		$key = "SHOP_LEFT_PANEL_ON";
		$leftPanelOn = $eshopSettings->get($key);
		$key = "SHOP_RIGHT_PANEL_ON";
		$rightPanelOn = $eshopSettings->get($key);
		$key = "SHOP_ESHOP_MENU_POS";
		$menuPos = $eshopSettings->get($key);

		// && $menuPos == "LEFT"
		if ($leftPanelOn == "1" && $rightPanelOn == "1") {
			return 1;
		}
		// && $menuPos == "TOP"
		if ($leftPanelOn == "1" && $rightPanelOn == "0") {
			return 2;
		}
		// && $menuPos == "TOP"
		if ($leftPanelOn == "0" && $rightPanelOn == "1") {
			return 3;
		}
		// && $menuPos == "TOP"
		if ($leftPanelOn == "0" && $rightPanelOn == "0") {
			return 4;
		}
	}
	public function saveLayoutAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('save-layout', false))
		{
			$layoutMainType = $this->getRequest->getPost('main_layout', false);
			$layoutShopType = $this->getRequest->getPost('shop_layout', false);
			$ESHOP_MENU_POS = $this->getRequest->getPost('ESHOP_MENU_POS', false);
			$ESHOP_MENU_MAIN_POS = $this->getRequest->getPost('ESHOP_MENU_MAIN_POS', false);
			$LOGO_MENU = $this->getRequest->getPost('LOGO_MENU', false);

			$model = new models_Eshop();


			$key = "LOGO_MENU";
			$data["value"] = $LOGO_MENU;
			$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

			$key = "ESHOP_MENU_POS";
			//$data["value"] = "LEFT";
			$data["value"] = $ESHOP_MENU_POS;
			$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

			$key = "ESHOP_MENU_MAIN_POS";
			//$data["value"] = "LEFT";
			$data["value"] = $ESHOP_MENU_MAIN_POS;
			$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

			switch ($layoutMainType) {
				case 1:
					$data = array();
					$key = "LEFT_PANEL_ON";

					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					$key = "LEFT_PANEL_SLIM";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "RIGHT_PANEL_ON";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					$key = "RIGHT_PANEL_SLIM";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


				/*	$key = "ESHOP_MENU_MAIN_POS";
					$data["value"] = "LEFT";
					$data["value"] = $ESHOP_MENU_POS;
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/

					break;
				case 2:
					$data = array();
					$key = "LEFT_PANEL_ON";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "LEFT_PANEL_SLIM";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					$key = "RIGHT_PANEL_ON";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

				/*	$key = "ESHOP_MENU_MAIN_POS";
					$data["value"] = "TOP";
					$data["value"] = $ESHOP_MENU_POS;
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/

					break;
				case 3:
					$data = array();
					$key = "LEFT_PANEL_ON";

					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "RIGHT_PANEL_ON";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "RIGHT_PANEL_SLIM";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


				/*	$key = "ESHOP_MENU_MAIN_POS";
					$data["value"] = "TOP";
					$data["value"] = $ESHOP_MENU_POS;
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/
					break;
				case 4:
					$data = array();
					$key = "LEFT_PANEL_ON";

					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "RIGHT_PANEL_ON";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

			/*		$key = "ESHOP_MENU_POS";
					$data["value"] = "TOP";
					$data["value"] = $ESHOP_MENU_POS;
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/
					break;

				default:
					;
			} // switch

			switch ($layoutShopType) {
				case 1:
					$data = array();
					$key = "SHOP_LEFT_PANEL_ON";

					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					$key = "SHOP_LEFT_PANEL_SLIM";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "SHOP_RIGHT_PANEL_ON";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					$key = "SHOP_RIGHT_PANEL_SLIM";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					/*	$key = "ESHOP_MENU_POS";
					   $data["value"] = "LEFT";
					   $data["value"] = $ESHOP_MENU_POS;
					   $model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/

					break;
				case 2:
					$data = array();
					$key = "SHOP_LEFT_PANEL_ON";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "SHOP_LEFT_PANEL_SLIM";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					$key = "SHOP_RIGHT_PANEL_ON";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					/*	$key = "ESHOP_MENU_POS";
					   $data["value"] = "TOP";
					   $data["value"] = $ESHOP_MENU_POS;
					   $model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/

					break;
				case 3:
					$data = array();
					$key = "SHOP_LEFT_PANEL_ON";

					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "SHOP_RIGHT_PANEL_ON";
					$data["value"] = "1";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "SHOP_RIGHT_PANEL_SLIM";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					/*	$key = "ESHOP_MENU_POS";
					   $data["value"] = "TOP";
					   $data["value"] = $ESHOP_MENU_POS;
					   $model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/
					break;
				case 4:
					$data = array();
					$key = "SHOP_LEFT_PANEL_ON";

					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");


					$key = "SHOP_RIGHT_PANEL_ON";
					$data["value"] = "0";
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");

					/*		$key = "ESHOP_MENU_POS";
					   $data["value"] = "TOP";
					   $data["value"] = $ESHOP_MENU_POS;
					   $model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");*/
					break;

				default:
				;
			} // switch
			$this->getRequest->goBackRef();
		}
	}
	public function saveAction(){
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd-setting-eshop', false))
		{
			$form = $this->formLoad('EshopSettings');
			$postdata = $form->getValues();
			$model = new models_Eshop();
			$this->getSettings();

			foreach ($this->setting as $key => $val) {

				if (isset($postdata[$key])) {
					$data = array();
					$data["value"] = $postdata[$key];
/*
					if (!isset($_POST[$key])) {
						$data["value"] = 0;
					}*/
					$model->updateRecords($model->getTableName(), $data, "`key`='{$key}'");
				}
			}
			$_SESSION["statusmessage"]='Nastavení bylo uloženo.';
			$_SESSION["classmessage"]="success";

			$this->getRequest->goBackRef();
			//$this->getRequest->clearPost();
		}
	}


/*	public function inicializujPostu()
	{
		$mail = new PHPMailer();

		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru


		$mail->Host = $this->setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($this->setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;

		$mail->Username = $this->setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $this->setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci

		// adresa odesílatele skriptu
		$mail->From = $this->setting["EMAIL_ORDER"];

		// jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $this->setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele

		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);

		return $mail;
	}*/

/*	public function odeslatEmail($komu,$predmet,$zprava,$priloha='',$prilohaName='objednavka.pdf',$skryta_kopie=false)
	{
		if (isEmail($komu)) {
			$mail = $this->inicializujPostu();

			$mail->AddAddress($komu);  // přidáme příjemce
			$mail->Subject = $predmet;
			$mail->Body = $zprava;


			if (isEmail($skryta_kopie)) {

			//	print $skryta_kopie;
			//	$mail->AddAddress($this->setting["BCC_EMAIL"]);
			//	$mail->AddAddress("info@svetfirem.cz");
				$mail->AddBCC($skryta_kopie);
			}
			if (!empty($priloha)) {
				$mail->AddAttachment($priloha, $prilohaName);
			}
			return $mail->send();
		}
		return false;

	}*/
}