<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ShopPlatbyController extends G_Controller_Action
{
	public function saveAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_product', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ProductEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				//print_r($form->getValues());
				//print_r($form->getValues());
				$_product = new models_Products();
				$_product->setData($form->getValues());
				if($_product->update())
				{
					$_SESSION["statusmessage"]="Produkt byl aktualizován.";
					$_SESSION["classmessage"]="success";
					//$this->clear_post();
					$this->getRequest->clearPost();
				}
			} else {
			//	print "Neprošel valid";
				//print_r($form->getValues());
				foreach($form->getError() as $key => $value)
				{
					$_SESSION["statusmessage"]= $key . ": ". $value;
				}
				//print_r($form->getError());

				$_SESSION["classmessage"]="errors";

			//	return $form;
			}
		}
	}
	public function deleteAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('del_product', false))
		{
			//print "mažu";
			//print
			/*
			foreach($this->getRequest->getPost('del_product', false) as $key => $value)
			{
				list($key,$value);
			}*/
			$tenzin = $this->getRequest->getPost('del_product', false);
			list($key,$value) = each($tenzin);
		//	print $key;
			$product_id = $_POST['product_id'][$key];
		//	print_r($this->getRequest->getPost('product_id[$key]', false));
		//	$product_id = $this->getRequest->getPost('product_id['.$key.']', false);
			if ($product_id) {

				$_product = new models_ProductVyrobce();
				$row = $_product->getRow($product_id);

				//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
				if ($row) {
					//$_fotoPlaces->setData($data);

					if($_product->delete($product_id))
					{
						//$_SESSION["statusmessage"]="Foto bylo úspěšně přidáno k produktu.";
						//$_SESSION["classmessage"]="success";
						$this->getRequest->clearPost();
					}
				}
			}

		}
	}
	public function createAction()
	{
		if(false !== $this->getRequest->getPost('status', false))
		{


			/*

			   status = PAID, CANCELLED, PENDING


			   merchant=www_papiroverucniky_cz&test=true&price=1234&curr=CZK
			   &label=Payment+test&refId=27&cat=PHYSICAL&method=BANK_CZ_CSOB
			   &email=rudolf.pivovarcik%40centrum.cz
			   &transId=AVK7-1C7L-9OBV
			   &secret=WAdi305NpxXCoWtVIQkci6FXLOcXPtto
			   &status=PAID
			*/

			$status = $this->getRequest->getPost('status', false);
			$price = $this->getRequest->getPost('price', false) * 0.01;
			$method_code = $this->getRequest->getPost('method', false);
			$transId = $this->getRequest->getPost('transId', false);

			$label = $this->getRequest->getPost('label', false);

			$model = new models_ShopPlatby();
			$data = array();
			$data["amount"] = $price;
			$data["method"] = $method_code;
			$data["status"] = $status;


			/*
			if ($status == "PAID") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena.";
				$_SESSION["classmessage"]="success";
			}
			$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena.";
			$_SESSION["classmessage"]="success";
			if ($status == "CANCELLED") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena. Kontaktujte nás.";
				$_SESSION["classmessage"]="errors";
			}*/

			$data["label"] = $label;
			$data["transId"] = $transId;
			if ($model->insert($data)) {

			}

			print "code=0&message=OK";
			return $status;

		}
	}

  public function setPlatbaGpWepPayStatus()
  {
  
    if (isset($_GET["DIGEST"]) && !empty($_GET["DIGEST"]))
    {
       
       //print "ok1";
       $operation = urldecode($_GET["OPERATION"]);
       $code = urldecode($_GET["ORDERNUMBER"]);
       $transId = urldecode($_GET["MERORDERNUM"]);
       $description = urldecode($_GET["MD"]);
       $productCode = urldecode($_GET["PRCODE"]);
       $resultCode = urldecode($_GET["SRCODE"]);
       $resultText = urldecode($_GET["RESULTTEXT"]);
        //CREATE_ORDER|152166358433|150644694849|PHP demoshop|14|0|Duplicate order number
      $data = "";
      $data =  $operation;
      if (!empty($code))
      {
         $data .=  "|" . $code;
      }
      if (!empty($transId))
      {
         $data .=  "|" . $transId;
      }
      
      if (!empty($description))
      {
         $data .=  "|" . $description;
      }
      if (($productCode!=""))
      {
         $data .=  "|" . $productCode;
      }
      if (($resultCode !=""))
      {
         $data .=  "|" . $resultCode;
      }
      if (!empty($resultText))
      {
         $data .=  "|" . $resultText;
      }   
      
      $eshopSettings = G_EshopSetting::instance();
              
      $signature = ($_GET["DIGEST"]);
      
       /*
      print $signature;
      print "<br />";
      print $data;
      print "<br />"; */
      require_once(PATH_CMS. "plugins/gpwp/signature.php");
          /*
      $private_key = PATH_ROOT.  "key/gpwebpay-pvk.key";
      //$public_key = "./key/test_cert.pem";
      $public_key = PATH_ROOT.  "key/gpe.signing_test.pem";
      $private_pwd = $eshopSettings->get("GPWP_SECRET");
      
        */
      
      
      
      
      
      $private_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PRIVATE_KEY");   
      $public_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PUBLIC_KEY");      
      $private_pwd = $eshopSettings->get("GPWP_SECRET");
        
			$testPayment = true;
			if ($eshopSettings->get("GPWP_TEST") == "0") {
       // $paymentsUrl ='https://test.3dsecure.gpwebpay.com/pgw/order.do?';
        /*
        $private_key = PATH_ROOT.  "key/gpwebpay-pvk_test.key"; 
        $public_key = PATH_ROOT.  "key/gpe.signing_test.pem";
                    */
        $private_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PRIVATE_KEY_TEST");  
        $public_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PUBLIC_KEY_TEST");  
        
        $private_pwd = $eshopSettings->get("GPWP_SECRET_TEST");
				$testPayment = false;
			}
      
      
      
      
      
      
      
      
      
      
  
      $sign = new CSignature($private_key, $private_pwd, $public_key); 
      
      if ($verify = $sign->verify($data,$signature))
      {
      
       //  print "ok2";
          $Orders = new models_Orders();
          $orderDetail = $Orders->getDetailByTransId($transId);
          
          
          if (!$orderDetail)
          {
            return false;
          }
          
          
        //  platba_id
          
      		$modelPlatby = new models_ShopPlatby($transId);
          
          $platbaDetail = $modelPlatby->getDetailByTransId($transId);
          if (!$platbaDetail)
          {
            return false;
          }
          
    			

          $status = "CANCELLED";
          if ($resultText=="OK")
          {
              $status = "PAID";
          }
				  $modelPlatby->updateRecords($modelPlatby->getTableName(),array("status"=>$status),"id=".$platbaDetail->id);
          
          
          
          
          if ($status=="PAID")
          {
              // nastavení platby v objednavce
              $Orders->updateRecords($Orders->getTableName(),array("platba_id"=>$platbaDetail->id),"id=".$orderDetail->id);
              
              $this->generujFakturuZeZaplaceneObjednavky($orderDetail->id,$platbaDetail->id);
              
              
          } 
          
       			/*  */ 
			if ($status == "PAID") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou byla úspěšně dokončena.";
				$_SESSION["classmessage"]="success";
			}

			if ($status == "CANCELLED") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena. Kontaktujte nás.";
				$_SESSION["classmessage"]="errors";
			}  

				    
      }  
    }
  
  }
  
  private function generujFakturuZeZaplaceneObjednavky($order_id,$platba_id)
  {
     $OrderController = new ObjednavkaController();
      $doklad = $OrderController->getOrder($order_id);

			$doklad->faktura_type_id = 1;
			$doklad->duzp_date =  date("Y-m-d");
			$doklad->pay_date =  date("Y-m-d");
			$doklad->amount_paid =  $doklad->cost_total;
			$doklad->platba_id =  $platba_id;
			$doklad->doklad_id =  $order_id;

			$doklad->description = "";
			$radky = $OrderController->order_details;

			$res = $OrderController->createFaktura($doklad,$radky);

			if ($res) {

			//	print_r($res);
				$odeslano2 = $OrderController->odeslatEmailSFakturouZaplaceno($res);

				//print "ok";
			}
  }
  
  public function platbaGpWepPay($dokladSaveData, $callbackUrl)
	{
		$eshopSettings = G_EshopSetting::instance();
       /*  
       testovací karta
       4056070000000008
         12/2020
         200
         
         K_aktus753
         
         PVK:Kruci8py_sk
         */

      $paymentsUrl ='https://3dsecure.gpwebpay.com/pgw/order.do?';
      
      /*
      $private_key = PATH_ROOT.  "key/gpwebpay-pvk.key";   
      $public_key = PATH_ROOT.  "key/gpe.signing.pem";  
      */
      $private_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PRIVATE_KEY");   
      $public_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PUBLIC_KEY");      
      $private_pwd = $eshopSettings->get("GPWP_SECRET");
        
			$testPayment = true;
			if ($eshopSettings->get("GPWP_TEST") == "0") {
        $paymentsUrl ='https://test.3dsecure.gpwebpay.com/pgw/order.do?';
        /*
        $private_key = PATH_ROOT.  "key/gpwebpay-pvk_test.key"; 
        $public_key = PATH_ROOT.  "key/gpe.signing_test.pem";
                    */
        $private_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PRIVATE_KEY_TEST");  
        $public_key = PATH_ROOT.  "key/" . $eshopSettings->get("GPWP_PUBLIC_KEY_TEST");  
        
        $private_pwd = $eshopSettings->get("GPWP_SECRET_TEST");
				$testPayment = false;
			}

      $currency = "203";
      $code = $dokladSaveData["code"];
      $obchodnikId = $eshopSettings->get("GPWP_MERCHANT");
      $price =  round($dokladSaveData["cost_total"] * 100);
      $autorizace = "0";
      $callback_url = $callbackUrl;
      // $callback_url = URL_HOME . "dokonceno?pay";
  
      $transId = rand();
 			require_once(PATH_CMS. "plugins/gpwp/signature.php");

   //   $private_key = PATH_ROOT.  "key/gpwebpay-pvk.key";
      //$public_key = "./key/test_cert.pem";
      
      
      $private_pwd = trim($private_pwd);
  
      /*
      19315411|CREATE_ORDER|152165852443|100|203|0|150644193919|https://www.mesaexo.com:80/demopay/index.php?action=response
      */
      
      $data = $obchodnikId .  "|CREATE_ORDER|" . $code . "|" . $price . "|" . $currency . "|" . $autorizace . "|" . $transId . "|" . $callback_url;
  
     //   print ":" . $eshopSettings->get("GPWP_SECRET") . ":";
    $sign = new CSignature($private_key, $private_pwd, $public_key);
    $signature = $sign->sign($data);

       /*
if (defined("SAVE_SIGNATURE_TO_FILE") && SAVE_SIGNATURE_TO_FILE){
 //   print $filePath;
	$filePath = (defined("SAVE_SIGNATURE_FILE_PATH") && trim(SAVE_SIGNATURE_FILE_PATH)!="")?strftime(SAVE_SIGNATURE_FILE_PATH):"signature.sign";
	if (strpos($filePath, "@ORDERID@") !== false) {
		$filePath=str_replace("@ORDERID@", $code, $filePath);
	}

	$f = fopen($filePath, "w");
	fwrite($f, $signature);
	fclose($f);

	$filePath = (defined("SAVE_SIGNATURE_FILE_PATH_ENCODED") && trim(SAVE_SIGNATURE_FILE_PATH_ENCODED)!="")?strftime(SAVE_SIGNATURE_FILE_PATH_ENCODED):"signatureEnc.sign";
	if (strpos($filePath, "@ORDERID@") !== false) {
		$filePath=str_replace("@ORDERID@", $code, $filePath);
	}

	$f = fopen($filePath, "w");
	fwrite($f, urlencode($signature));
	fclose($f);
}   */

  

      $params = array();
      $params["MERCHANTNUMBER"] = $obchodnikId;
      $params["OPERATION"] = "CREATE_ORDER";
      $params["ORDERNUMBER"] = $code;
      $params["AMOUNT"] = $price;
      $params["DEPOSITFLAG"] = $autorizace;
      $params["CURRENCY"] = $currency;
      $params["MERORDERNUM"] = $transId;
      $params["URL"] = ($callback_url);
      $params["DIGEST"] =   ($signature);
      /*
      
      https://test.3dsecure.gpwebpay.com/pgw/order.do?
      MERCHANTNUMBER=19315411
      &OPERATION=CREATE_ORDER
      &ORDERNUMBER=123456789
      &AMOUNT=100
      &DEPOSITFLAG=0
      &CURRENCY=203
      &MERORDERNUM=123456789
      &URL=http%253A%252F%252Fjoyashop.pivovarcik.cz%252Fdokonceno%253Fpay
      &DIGEST=nstUroQGwUM1AqFdT7%252B%252FLnT3absCYEjpEGQFeNUiqY7c5EL3%252FqHGtG4YFee%252B5rrOY5rF3LXzoiU9RYgfv9XEtwejN90AW0IfqNCKoMQcZfWDPOx89KlgbokbbJA7csHR269w1FGgHArevl2bOEnJTxmUh1q6FnX4SpNN9BXUQN%252BVU%252B5R%252FqxDZ1vVNbmLYeudXgJSgnLpW3NqzlstiXbhV%252F8l8YtfVtdv8u7wbU8SsTv%252Bj7jH8AMpgMRoOdexEMPfl7EQn1%252BQsvtHEKaToFLPpqZfdHz5K5bUx8edXSEpL7PjLL1Mk7%252F%252BNiJwRo3KlvqEkIPgddl6jJuspPa6B2mTwQ%253D%253D
      
      https://test.3dsecure.gpwebpay.com/pgw/order.do?
      MERCHANTNUMBER=19315411
      &OPERATION=CREATE_ORDER
      &ORDERNUMBER=152165852443
      &AMOUNT=100
      &DEPOSITFLAG=0
      &CURRENCY=203
      &MERORDERNUM=150644193919
      &URL=https%3A%2F%2Fwww.mesaexo.com%3A80%2Fdemopay%2Findex.php%3Faction%3Dresponse
      &DIGEST=gFOd7Cwt7u91gMyPgBfkTnk2wpFl5qlHUIAkyqHdf39c%2FWarj2i5qGJ1AmOJd8HrLsdI2HuqR9CJ9lS8%2FvUYRbhqRvTJ0VVVPH2JWTBHf%2Fld4qlvO%2FBfFvw3WXA6rIcO7ziT4dbFek2CRKemhXaYKlJBJcQsNB9YUiU57RdnHX8V2d3mb53rrP%2BOohwJd7%2BEbf3n72EvkC1P56wI%2FcMyNlMFA715l1cs8H%2B0iQ%2Fk%2B1YjrzyLCWf3CJBWJPdErKEbdvMLmvn4F%2Bh6eOA0W2WfIQ2oloTsO3BTh3llFlmeKqXQI%2B%2FnfZugCQbiY7s53RcUXm0C6kFZX4Ji2BRupx2ZGA%3D%3D
      
      */



        $paymentsUrl .= http_build_query($params);
        
       /* print $paymentsUrl;
        print "<br />";
        print "<br />";  */
       // exit;
          

				$modelObjednavky = new models_Orders();

				$modelObjednavky->updateRecords($modelObjednavky->getTableName(),array("transId"=>$transId),"id=".$dokladSaveData["id"]);
        
        
        $modelPlatba = new models_ShopPlatby(); 
        $status = "CREATE";
    //    $label = "GP webpay online platba - " . $code;
        $label = "Úhrada objednávky č. " . $code;
        $data = array();
  			$data["amount"] = $dokladSaveData["cost_total"] ;
  		//	$data["method"] = $method_code;
  			$data["status"] = $status;
  			$data["code"] = $code;


			/*
			if ($status == "PAID") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena.";
				$_SESSION["classmessage"]="success";
			}
			$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena.";
			$_SESSION["classmessage"]="success";
			if ($status == "CANCELLED") {
				$_SESSION["statusmessage"]= "Úhrada platební kartou nebyla úspěšně dokončena. Kontaktujte nás.";
				$_SESSION["classmessage"]="errors";
			}*/

			$data["label"] = $label;
			$data["transId"] = $transId;
			if ($modelPlatba->insert($data)) {

			}
      
      
        /**/

       //   $verify = $sign->verify($data,$signature);
         // var_dump($verify);
        //  exit;

				// redirect to agmo payments system
				header('location: '. $paymentsUrl);
				exit;
		
	}

}