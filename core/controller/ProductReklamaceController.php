<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 *
 * status,
 * vip,
 * description,
 * address1,
 * address1,
 * psc
 * telefon
 * poznamka
 * lng, lat
 */

class ProductReklamaceController extends G_Controller_Action
{
	private $subject = "Reklamační formulář";

	public function sendEmail($postdata)
	{
		$body ='';
		$body .="<html>";
		$body .="<head></head>";
		$body .="<body>";


		$body .='Vážený zákazníku,';
		$body .='<br /><br />';
		// do kurzů ze dne ' .date("j.n.Y") . '
		$body .='<p>Děkujeme Vám za vyplnění reklamačního formuláře na <a href="' . URL_HOME . '">' . URL_DOMAIN . '</a>.</p>';
		$body .='<p style="font-size:14px;font-weight:bold;padding:10px 0;">Potvrzení o příjetí reklamace:</p>';
		$body .='<div style="background-color:#F5F5F5;padding:10px;">';
		$body .="<p><label>Faktura:</label> <strong>" . $postdata["faktura_code"] . "</strong></p>";
		$body .="<p><label>Email:</label> <strong>" . $postdata["customer_email"] . "</strong></p>";
		$body .="<p><label>Objednávka:</label> <strong>" . $postdata["order_code"] . "</strong></p>";
		$body .="<p><label>Zákazník:</label> <strong>" . $postdata["customer_name"] . "</strong></p>";
		$body .="<p><label>Kontaktní osoba:</label> <strong>" . $postdata["customer_person"] . "</strong></p>";
		$body .="<p><label>Telefon:</label> <strong>" . $postdata["customer_phone"] . "</strong></p>";
		$body .="<p><label>Datum objednávky:</label> <strong>" . $postdata["order_date"] . "</strong></p>";
		$body .="<p><label>Datum dodání zboží:</label> <strong>" . $postdata["transfer_date"] . "</strong></p>";
		$body .="<p><label>Název zboží:</label> <strong>" . $postdata["product_name"] . "</strong></p>";
		$body .="<p><label>Důvod reklamace:</label> <strong>" . $postdata["description"] . "</strong></p>";
		$body .="<p><label>Počet reklamovaných kusů:</label> <strong>" . $postdata["qty"] . "</strong></p>";

		$body .='</div>';
		$body .='<br />';
		$body .='<p>Vaší reklamaci se budeme snažit vyřešit v co nejkratším možném termínu a následně Vás budeme informovat.
</p>';

		$body .='<br /><br />';
		$body .='S přátelským pozdravem,';
		$body .='<br /><br />';
		//	$mail->Body .='<strong>společnost Baustav</strong><br />';

		$body .="</body></html>";
		return $body;
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('reklamace', false))
		{

			$translator = G_Translator::instance();

			// načtu Objekt formu
			$form = $this->formLoad('ProductReklamaceForm');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$order_email = $form->getValue("customer_email");
				$order_phone = $form->getValue("shipping_phone");

				$postdata = $form->getValues();

				$priloha = "";
				$priloha_nazev = "";
				if (isset($_FILES["priloha"]) && !empty($_FILES["priloha"]["name"])) {
					$priloha = $_FILES["priloha"]["tmp_name"];
					$priloha_nazev = $_FILES["priloha"]["name"];
				}

				$eshopController = new EshopController();

				$skryty = false;
				if (isEmail($eshopController->setting["BCC_EMAIL"])) {
					$skryty = $eshopController->setting["BCC_EMAIL"];
				}


				$body = $this->sendEmail($postdata);

				$mailController = new MailingController();
				$odeslano = $mailController->odeslatEmail($order_email,"Reklamační formulář",$body ,$priloha,$priloha_nazev,$skryty);

				if ($odeslano) {
					$form->setResultSuccess($translator->prelozitFrazy("formular_reklamace_uspesne_odeslan"));
					$this->getRequest->goBackRef();
				}
			}
		}
	}
}
