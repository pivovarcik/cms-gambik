<?php
require_once("ImportManagerLog.php");
/***
 * Zajištuje obsluhu importu
 * */
class ImportManager{

	public static function downloadFeed()
	{
	//	$to = dirname(__FILE__) . "/" . ImportConfig::get('syncLastId') . ".xml";
  
    $syncLastId =  ImportConfig::get('syncLastId');
    
    if (empty($syncLastId))
    {
         $syncLastId = "0";
    }
		$to = PATH_ROOT . "import/" . ImportConfig::get('name') . "/" . $syncLastId . ".xml";
		$uploadAdapter = new G_UploadUrl();
		print "stahuji feed " . ImportConfig::get('url') . " do " . $to;
		$uploadAdapter->copy(ImportConfig::get('url'), $to);
	}
	/**
	 * Zahájení importu
	 *
	 */
	public static function start()
	{
	//	print "****" . ImportManagerLog::getStatus() . "*********";
	//	print ImportManagerLog::getStatus();
                                      
      $syncLastId =  ImportConfig::get('syncLastId');
   /*   print "syncLastId:" . $syncLastId;
      print "name:" . ImportConfig::get('name');
      exit;  */
    if (empty($syncLastId))
    {
         $syncLastId = "0";
    }

		//	print "syncLastId:" . $syncLastId;
//		$check_url = ImportConfig::get('url');
//		$check_url = PATH_ROOT . "/import/wood/" . ImportConfig::get('syncLastId') . ".xml";
		$check_url =  PATH_ROOT . "import/" . ImportConfig::get('name') . "/" . $syncLastId . ".xml";
		//	$file = simplexml_load_file($check_url, 'SimpleXMLElement');
		if (file_exists($check_url) && $file = simplexml_load_file($check_url, 'SimpleXMLElement', LIBXML_NOCDATA)) {

		// 	$file = simplexml_load_file($check_url, 'SimpleXMLElement', LIBXML_NOCDATA);
		} else {
			ImportManager::downloadFeed();
			//exit;
      if (file_exists($check_url) && $file = simplexml_load_file($check_url, 'SimpleXMLElement', LIBXML_NOCDATA)) {

		// 	$file = simplexml_load_file($check_url, 'SimpleXMLElement', LIBXML_NOCDATA);
		} 
    
		}


		if (ImportManagerLog::getStatus() == "start") {
		//	print ImportManagerLog::getStatus();

			//print "pokracuju v nedokoncenem importu";

		} else {
			// vynulovat iterátor
			//print "zahajuji novy import";

			ImportManagerLog::clear();
			ImportIteratorLog::write(0);

			$deactive_product = ImportConfig::get('deactive_product');
			$import_reference = ImportConfig::get('import_reference');


		//	print $deactive_product;
		//	exit;

		//	print_r($import_reference);
		//	exit;


			if ($deactive_product == 1) {
				ImportLog::writeLn('Deaktivuji produkty');
				$model = new models_Products;
		//		$model->updateRecords($model->getTableName(),array("aktivni" => "0"),"reference like '" . $import_reference . "%'");
				$model->updateRecords($model->getTableName(),array("sync_stav" => "0"),"reference like '" . $import_reference . "%'");
			}

			$model = new models_ImportProductSetting();
			$model->updateRecords($model->getTableName(),array("syncStatus" => 1),"id=" . ImportConfig::get('id') . "");



		}
	//	print ImportIteratorLog::getLastIndex();
	//	exit;
		// zapíšu start
		ImportManagerLog::write("start");
//print ImportManagerLog::getStatus();
		$importCategory = new ProductImporter("ProductDecoder");




	//	$importCategory->setUrl(StasanetImportConfig::get('url'));
		$importCategory->setBlockSize(ImportConfig::get('block_size'));



	//	print $check_url;
	//	exit;
		$shop_items = ImportConfig::get('shop_items');
	//	$articles = $file->$shop_items;

		if (!empty($shop_items)) {
			$articles = $file->$shop_items;
		} else {
			$articles = $file;
		}
	//	$articles = $file;
	//	$articles = $file->Table;

		//print "tudy";
	//	print_r($articles);
	//	exit;
		//	print_r($articles);

		$importCategory->import($articles);

	//	print ImportManagerLog::getStatus();
		if (ImportManagerLog::getStatus() == "complete") {
			ImportManager::stop();
		}
	}

	/*
	 Zastaví a ukončí přenos, nový začne od začátku
	*/
	public function stop()
	{
    $import_reference = ImportConfig::get('import_reference');
		$model = new models_ImportProductSetting();
		$model->updateRecords($model->getTableName(),array("syncLastTimeStamp" =>date("Y-m-d H:i:s"), "syncStatus" => 0, "syncLastId" => ImportConfig::get('syncLastId') + 1 ),"id=" . ImportConfig::get('id') . "");

//    print $model->getLastQuery();
    $model = new models_Products();
    if (ImportConfig::get('sync_aktivni') == 1) {
    // todo Předělat na dodavatel_id !!!
      $model->updateRecords($model->getTableName(),array("aktivni" => "{sync_stav}"),"reference like '" . $import_reference . "%'");
    }
    ProductDecoder::stop();
        /*
        $model->query("delete FROM `mm_product_ceny` WHERE product_id in (select id from mm_products where reference like '" . $import_reference . "%')");
    $model->query("insert into `mm_product_ceny` (typ_slevy,sleva,cenik_id,product_id) select '%',-15,1,id from mm_products where CODE02<>'ΡRΟΜΟΤΙΟΝ' and reference like '" . $import_reference . "%'");
    $model->query("insert into `mm_product_ceny` (typ_slevy,sleva,cenik_id,product_id) select '%',-5,1,id from mm_products where (CODE02='ΡRΟΜΟΤΙΟΝ' or CODE02='ΝΕW/ΡRΟΜ') and reference like '" . $import_reference . "%'");
          */
    
		$dir = "";
		ImportManagerLog::setStatus("cancel");
		$contents = ob_get_contents();
		ob_end_clean();
		$step = isset($_GET['chain']) ? (int)$_GET['chain'] + 1 : 1;
		echo '
<!DOCTYPE html>
<html lang="cs-CZ">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            </head>
            <body onload="chain()">
            	<h1>'.ImportConfig::get('type', 'XML').' IMPORT: '.ImportConfig::get('url').'</h1>
                Import byl úspěšně dokončen!
                <br>
                <br>
                <a href="'.$dir.'/ajax_abort.php">Přerušit</a>
                <a href="'.$dir.'/ajax_cancel.php">Ukončit</a>*
                <br>
                <br>
                <p><i>
                	*) <b>Přerušení</b> importu znamená, že po opětovném spuštění se bude pokračovat tam, kde<br>
                	   se přestalo, <b>ukončení</b> importu znamená, že po opětovném spuštění import bude probíhat<br>
                	   od počátku.
               	</i></p>
            </body>
            </html>
        ';
		exit;
	}


	/**
	 * Nastartuje další běh skriptu
	 *
	 */
	protected static function _startNewProcess()
	{
		if (ImportManagerLog::getStatus() == "complete") {
			ImportManager::stop();
		}
		$dir = dirname($_SERVER['PHP_SELF']);

		$contents = ob_get_contents();
		ob_end_clean();
		$step = isset($_GET['chain']) ? (int)$_GET['chain'] + 1 : 1;
		echo '
<!DOCTYPE html>
<html lang="cs-CZ">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <script type="text/javascript">
                    function chain()
                    {
                        window.location="'.$_SERVER['PHP_SELF'].'?chain='.$step.'";
                    }
                </script>
            </head>
            <body onload="chain()">
            	<h1>'.ImportConfig::get('type', 'XML').' IMPORT: '.ImportConfig::get('url').'</h1>
                Zpracovává se v pořadí '.$step.' blok!
                <br>
                <br>
                <a href="'.$dir.'/ajax_abort.php">Přerušit</a>
                <a href="'.$dir.'/ajax_cancel.php">Ukončit</a>*
                <br>
                <br>
                Naposledy zpracované entity:
                <br>
                <br>
                '.$contents.'
                <br>
                <br>
                <a href="'.$dir.'/ajax_abort.php">Přerušit</a>
                <a href="'.$dir.'/ajax_cancel.php">Ukončit</a>*
                <br>
                <br>
                <p><i>
                	*) <b>Přerušení</b> importu znamená, že po opětovném spuštění se bude pokračovat tam, kde<br>
                	   se přestalo, <b>ukončení</b> importu znamená, že po opětovném spuštění import bude probíhat<br>
                	   od počátku.
               	</i></p>
            </body>
            </html>
        ';
		exit;
	}

	/**
	 * Provede zřetězení provádění skriptů
	 *
	 */
	public static function chain()
	{
		self::_startNewProcess();
	}
}

?>