<?php

class ProductImporter
{
	private static $__decoder = NULL;
	private static $__block_size = 0;
	private static $__start_index = 0;
	public function __construct($decoder)
	{

		self::$__decoder = $decoder;

	}

	public function setBlockSize($size)
	{
		self::$__block_size=$size;
	}
	public function setUrl($size)
	{
		//self::$__block_size=$size;
	}


	public function import(SimpleXMLElement $productList)
	{
		// poslední importovaný index
		//	print "*********LAST INDEX*********" . ImportIteratorLog::getLastIndex() . "******************";

		self::$__start_index = (int) ImportIteratorLog::getLastIndex();
		$fotoController = new FotoController();
		$modelFoto = new models_FotoPlaces();


		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$productController = new ProductController();
		$productModel = new models_Products();
		//15+15 > 20
		if ((self::$__start_index + self::$__block_size)> count($productList)) {
			self::$__block_size = count($productList);
		} else {

		}
		$only_price = false;
		if (ImportConfig::get('sync_price') + ImportConfig::get('sync_stav') + ImportConfig::get('sync_aktivni')) {
			$only_price = true;
		}

		$import_images = ImportConfig::get('import_images');
		$dodavatel_id = ImportConfig::get('id');
		$import_id = ImportConfig::get('syncLastId');

		$blockIterator = 1;
		for($i=0;$i<count($productList);$i++)
		{
    
         /*   if ((string)$productList[$i]->PRODUCT_ID == "23"){
              print_r($productList[$i]);
        break;
        
        }
            */
			if ($blockIterator > self::$__block_size) {
				break; // otočit pouze nastavený limit
			}


			if ($i >= self::$__start_index) {
				$blockIterator++;

				print "*********blockIterator**************".$blockIterator." od ".$i."<br />";

				$decoder = new self::$__decoder;
				//$importData = $decoder::decode($productList[$i]);
				$productWrapper = ProductDecoder::decode($productList[$i]);

				$importData = $productWrapper->product;
			  $importData["sync_stav"] = 1;
			  $importData["dodavatel_id"] = $dodavatel_id;
          
         if (isset($productWrapper->category_name))
         {
         
            $importData["import_category"] = $productWrapper->category_name;
         }
          
          

            
				$variantyData = $productWrapper->varianty;

				ImportLog::writeLn('Import Produktu: ' . $importData['title']);


				$eshopSettings = G_EshopSetting::instance();
				if ($eshopSettings->get("PLATCE_DPH") == 0) {
					// pokud nejsem platce mazu DPH !
					$importData["dph_id"] = null;
					$importData["sazba_dph"] = 1;
				}

				$sazbaRadek = $importData["sazba_dph"];
        
        
				if ($eshopSettings->get("PRICE_TAX") == 0) {
					// s daní se dopočítává
					if ($sazbaRadek > 0) {
						$sazbaRadek = $sazbaRadek / 100;
					}

					$sazbaRadek = 1 + $sazbaRadek;
					$importData["prodcena_sdph"] = round($sazbaRadek * $importData["prodcena"],2);
				//	$importData["prodcena_sdph"] = ($sazbaRadek * $importData["prodcena"]);
				} else {
        
					if (!isset($importData["prodcena"]))
					{
												// bez dph se dopočítává
								//1 - 21/(100+21) = 0.8264
								//if ($sazba > 0) {
								$sazbaRadek = 1 - $sazbaRadek / (100 + $sazbaRadek);
								//	}
								$importData["prodcena"] = round($sazbaRadek * $importData["prodcena_sdph"],2);
							//	$importData["prodcena"] = ($sazbaRadek * $importData["prodcena_sdph"]);
					
					}

				}

				$importDataAll = $importData;
			//	$importData['sazba_dph'];


				$saveEntity = new SaveEntity();

				if ($detail = $productModel->getDetailByReference($importData["reference"])) 
        {
          // Existují produkt - aktualizace  
        

					$importDataOnly = array();
				//	$only_price = ImportConfig::get('only_price');
					$importDataOnly["sync_stav"] = 1;
					$importDataOnly["dodavatel_id"] = $dodavatel_id;
					$importDataOnly["imagesList"] = $importData["imagesList"];
          $importDataOnly["category_id"] = $importData['category_id'];
          
          if (isset($productWrapper->category_name))
          {
          
            $importDataOnly["import_category"] = $productWrapper->category_name;
          }


					if ($only_price) {

            if (isset($importData["bazar"]))
            {
                 $importDataOnly["bazar"] = $importData["bazar"];
            }
           // $importDataOnly["cislo2"] = $importData["cislo2"];
           
           	$importDataOnly["netto"] =	$importData['netto'];
		        $importDataOnly["objem"] = $importData['objem'];
		        $importDataOnly["rozmer"] = $importData['rozmer'];
		        
    
    
            $importDataOnly["polozka2"] = $importData["polozka2"];
            if (isset($importData["neexportovat"]))
            {
                 $importDataOnly["neexportovat"] = $importData["neexportovat"];
            }
						if (ImportConfig::get('sync_price') == 1) {
							$importDataOnly["prodcena"] = $importData["prodcena"];
							$importDataOnly["prodcena_sdph"] = $importData["prodcena_sdph"];

							$importDataOnly['min_prodcena'] = $importData['min_prodcena'];
							$importDataOnly['max_prodcena'] = $importData['max_prodcena'];

							$importDataOnly['min_prodcena_sdph'] = $importData['min_prodcena_sdph'];
							$importDataOnly['max_prodcena_sdph'] = $importData['max_prodcena_sdph'];
              
              
              $importDataOnly['dph_id'] = $importData["dph_id"];
				    	$importDataOnly['sazba_dph'] = $importData["sazba_dph"];
          
							if (isset($importData["nakupni_cena"]))
							{
								$importDataOnly['nakupni_cena'] = $importData['nakupni_cena'];
							}
						}

						if (ImportConfig::get('sync_stav') == 1) {
							$importDataOnly["dostupnost_id"] = $importData["dostupnost_id"];
						}

						if (ImportConfig::get('sync_aktivni') == 1) {
							$importDataOnly["aktivni"] = $importData["aktivni"];
						}

						$importDataOnly["qty"] = $importData["qty"];
						if (isset($importData["code02"]))
						{
							$importDataOnly["code02"] = $importData["code02"];
						}
            




						$importData = $importDataOnly;
						$import_images = 0;
					}


					// Je produkt zároveň variantou?
					if ($productWrapper->isVarianty) {
						// hledám variantu podle čísla varianty
						$VariantyModel = new models_ProductVarianty();

						$varianta = $VariantyModel->getDetailByProductIdAndCode($detail->page_id, $variantyData["code"]);

						if ($varianta) {
							$ProductVariantyEntity = new ProductVariantyEntity($varianta);

						} else {
							$ProductVariantyEntity = new ProductVariantyEntity();
              $importData["paramList"] = $variantyData["paramList"];

        
						}
						$ProductVariantyEntity->product_id = $detail->page_id;
						$ProductVariantyEntity->name = $variantyData["title"];
						if (ImportConfig::get('sync_price') == 1 || !$varianta) {
						$ProductVariantyEntity->price = $importData["prodcena"];
						$ProductVariantyEntity->price_sdani = $importData["prodcena"];
            }
						$ProductVariantyEntity->code = $variantyData["code"];
            
						if (ImportConfig::get('sync_stav') == 1 || !$varianta) {
						  $ProductVariantyEntity->dostupnost_id = $importData["dostupnost_id"];
            }
						$ProductVariantyEntity->qty = $importData["qty"];

						$saveEntity->addSaveEntity($ProductVariantyEntity);
					}
					if ($detail->foto_id > 0) {

					} else {
						$import_images = 1;
					}


					// synchronizace
					$ProductEntity = new ProductEntity($detail->page_id,false);

          if ($productWrapper->isVarianty) {
             $ProductEntity->isVarianty = 1; 
          }
           
           if ($ProductEntity->category_id > 0 && !is_null($ProductEntity->category_id))
           {
             // pokud je kategorie, tak ji nech, jinak pridej
              unset($importData["category_id"]);
           }   else {
           
                /*     print_r($ProductEntity);
          print_r($importData);
          exit; */
           }
           
           
                     

          $ProductEntity->LastSyncTime = date("Y-m-d H:i:s");
					if ($productWrapper->isProduct) {
						// cislo produktu je rovno skupine = hlavni varianta
						$ProductEntity->naplnEntitu($importData);


					//	print_r($detail);
						foreach ($languageList as $key => $val){

							$version_id = "version_id_". $val->code;
							//$detail->id = $detail->id;
						//	$detail->id = $version_id;
							//$version_id = $detail->$version_id;
							$entitaOut = new ProductVersionEntity((int)$detail->$version_id);

							if (is_null($entitaOut->id)) {
								$productVersinFactory = new ProductVersionFactory();
								$entitaOut = $productVersinFactory->create($importDataAll);
								$entitaOut->lang_id=$val->id;
								$entitaOut->page_id=$detail->page_id;

							//	print $val->code . " je null";
							//	print_r($importDataAll);
							//	$entitaOut->naplnEntitu($importDataAll);
							//	$importDataAll
							} else {
								$entitaOut->naplnEntitu($importData);
							}

							$saveEntity->addSaveEntity($entitaOut);
						}

					}
          
       /*   if ($detail->page_id == 3098)
          {
          
          print_r($importData);
          print_r($productWrapper);
          print "import_category:" .  $productWrapper->category_name;
            print_R($ProductEntity);
            exit;
          }     */
	//				
					$saveEntity->addSaveEntity($ProductEntity);




					$models_ProductStavy = new models_ProductStavy();
					$productStav = $models_ProductStavy->getDetailByProductId($ProductEntity->id);

					$ProductStavEntity = new ProductStavEntity($productStav);
					$ProductStavEntity->product_id = $ProductEntity->id;
					//	$ProductStavEntity->qty = $importData['qty'];

					$saveEntity->addSaveEntity($ProductStavEntity);


				} else {

          // Nový záznam
					if ($productWrapper->isProduct) {
						// cislo produktu je rovno skupine = hlavni varianta

						$import_images = 1;
						$productFactory = new ProductFactory();
						$ProductEntity = $productFactory->create($importData);
						$ProductEntity->LastSyncTime = date("Y-m-d H:i:s");
						$ProductEntity->import_id = $import_id;


            if (ImportConfig::get('product_is_active') == 1) {
							$ProductEntity->aktivni = 1;
						}  else {
               $ProductEntity->aktivni = 0;
            }
            
            
						$saveEntity->addSaveEntity($ProductEntity);

						$ProductStavEntity = new ProductStavEntity();
					//	$ProductStavEntity->product_id = $ProductEntity->id;
						$ProductStavEntity->qty = $importData['Availability'];
						$saveEntity->addSaveEntity($ProductStavEntity);

					//	print_r($importData);
						foreach ($languageList as $key => $val){

							$productVersinFactory = new ProductVersionFactory();
							$entitaOut = $productVersinFactory->create($importData);
							$entitaOut->lang_id=$val->id;

					//		print_R($entitaOut);
							$saveEntity->addSaveEntity($entitaOut);
						}


						if ($productWrapper->isVarianty) {
							// hledám variantu podle čísla varianty
							//$VariantyModel = new models_ProductVarianty();

               $importData["paramList"] = $variantyData["paramList"];
							$ProductVariantyEntity = new ProductVariantyEntity();

							//	$ProductVariantyEntity->product_id = $$detail->id;
							$ProductVariantyEntity->name = $variantyData["title"];
							$ProductVariantyEntity->code = $variantyData["code"];
							$ProductVariantyEntity->price = $importData["prodcena"];
							$ProductVariantyEntity->price_sdani = $importData["prodcena"];
							$ProductVariantyEntity->dostupnost_id = $importData["dostupnost_id"];
							$ProductVariantyEntity->qty = $importData["qty"];

            
            
							$saveEntity->addSaveEntity($ProductVariantyEntity);
						}

					}

				}


				// obsahuje seznam variant
				if (isset($productWrapper->variantyList) && is_array($productWrapper->variantyList) && count($productWrapper->variantyList) > 0) {

					if ($detail->page_id > 0) {
						$saveEntity->addBeforeQuery("delete from " . T_SHOP_PRODUCT_VARIANTY . " where product_id=" . $detail->page_id);
					}

					foreach ($productWrapper->variantyList as $key => $variantyData){

						$ProductVariantyEntity = new ProductVariantyEntity();

						//	$ProductVariantyEntity->product_id = $detail->page_id;
            if (isset($variantyData["title"]))
            {
              $ProductVariantyEntity->name = $variantyData["title"];
            }
            if (isset($variantyData["name"]))
            {
              $ProductVariantyEntity->name = $variantyData["name"];
            }						
						$ProductVariantyEntity->price = $variantyData["price"];
						$ProductVariantyEntity->price_sdani = $variantyData["price_sdani"];
						$ProductVariantyEntity->code = $variantyData["code"];
						$ProductVariantyEntity->dostupnost_id = $importData["dostupnost_id"];
						$ProductVariantyEntity->qty = $importData["qty"];
            
            if (isset($importData["dph_id"]))
            {            
						  $ProductVariantyEntity->dph_id = $importData["dph_id"];
            }
						$saveEntity->addSaveEntity($ProductVariantyEntity);
					}
				}


             /*
				if ($productWrapper->isProduct) {
						// cislo produktu je rovno skupine = hlavni varianta
					if (isset($importData["paramList"]) && is_array($importData["paramList"])) {


  					foreach ($importData["paramList"] as $param => $attribute_id) {
  						//		$attribute_id = ProductAttributesValueDictionary::getDictionaryEntry($param, $value);
  
  						$entitaOut = new ProductAttributeValueAssociationEntity();
  						$entitaOut->naplnEntitu(array("attribute_id" => $attribute_id));
  						$saveEntity->addSaveEntity($entitaOut);
  					}
					}

				} 
             */
        
        
   
        
        print "aaaaa";
                    print_r($importData["paramList"]);
         print "bbbbb";
        if (isset($importData["paramList"]) && is_array($importData["paramList"])) {


  					foreach ($importData["paramList"] as $param => $attribute_id) {
  						//		$attribute_id = ProductAttributesValueDictionary::getDictionaryEntry($param, $value);
  
              if ($productWrapper->isVarianty) {
  						  $entitaOut = new ProductVariantyValueAssociationEntity();
              } else {
                
                $entitaOut = new ProductAttributeValueAssociationEntity();
              }
  						$entitaOut->naplnEntitu(array("attribute_id" => $attribute_id));
  						$saveEntity->addSaveEntity($entitaOut);
  					}
					}
          

        if ($detail->sync_not == 1)
        {
          ImportLog::writeLn('Vynechano');
					ImportIteratorLog::write($i+1);
        } else {
        
          // print_r($saveEntity->getSaveEntity("ProductEntity"));
          // print_r($saveEntity->getSaveEntity("ProductVersionEntity"));
        //   print_r($saveEntity->getSaveEntity());
				if ($saveEntity->save()) {

				//	print_r( $productWrapper);
        $page_id = false;
        $savedProductEntity = $saveEntity->getSavedEntity("ProductEntity");
        if  ($savedProductEntity)
        {
           $page_id = $savedProductEntity->getId();
        }
					


				//	$savedProductEntity = $saveEntity->getSavedEntity("ProductEntity");

					if ($page_id) {


						//$page_id = $savedProductEntity->getId();



						if ($productWrapper->isVarianty) {
						$model = new G_Service("");
						$sql = "update `mm_products` left join (
						SELECT product_id,max(price) as max_price,max(price_sdani) as max_price_sdani,
						min(price) as min_price, min(price_sdani) as min_price_sdani FROM `mm_product_varianty` where product_id=" . $page_id . " and isDeleted=0
						group by product_id) v on `mm_products`.id = v.product_id
						set max_prodcena = v.max_price,
						max_prodcena_sdph = v.max_price_sdani,
						min_prodcena = v.min_price,
						min_prodcena_sdph = v.min_price_sdani
						where v.product_id=" . $page_id;
						$model->query($sql);


            // nově natahuju cenu MIN
						$sql = "update `mm_products_version` left join (
						SELECT product_id,max(price) as max_price,max(price_sdani) as max_price_sdani,
						min(price) as min_price, min(price_sdani) as min_price_sdani FROM `mm_product_varianty` where product_id=" . $page_id . " and isDeleted=0
						group by product_id) v on `mm_products_version`.page_id = v.product_id
						set prodcena = v.max_price,
					   prodcena_sdph = v.max_price_sdani
						where v.product_id=" . $page_id;
						$model->query($sql);
            
					/*		$sql = "update `mm_products_version`
						set prodcena = 0,
						prodcena_sdph = 0
						where page_id=" . $page_id;   */
							$model->query($sql);

						}

						if ($import_images == 1) {
							$params = array();
							$params['gallery_id'] = (int) $page_id;
							$params['gallery_type'] = T_SHOP_PRODUCT;
							//	$fotoController = new FotoController();


							$args = new FotoPlacesListArgs();
							$args->gallery_id = (int) $page_id;
							$args->gallery_type = T_SHOP_PRODUCT;

							$fotoGallery = $modelFoto->getList($args);


							//	$fotoGallery = $fotoController->fotoUmisteniList($params);

							foreach ($fotoGallery as $key => $foto) {

								if ($foto_id = $fotoController->deleteProcess($foto->id)) {

								}
							}

							// nejdrive smazu fotky produktu
              $firstFoto = true;
							foreach ($importData["imagesList"] as $param => $value) {

								if ($foto_id = $fotoController->copyProces($value, T_SHOP_PRODUCT,$page_id)) {
                  
                  if ($firstFoto)
                  {
                     $productController->setMainFoto($page_id,$foto_id);
                     $firstFoto = false;
                  }
                  
									
								}
							}
             /*  if (is_array($importData["imagesList"]) && count($importData["imagesList"])>0)
               {
               print_r($importData);
              print "foto galerie";
              exit;               
               }     */

						}

					}
					ImportLog::writeLn('OK');
					ImportIteratorLog::write($i+1);
				} else {
        
        
					ImportLog::writeLn('Chyba - NEULOŽENO');
				}
        
       } 
			}
		}

		//	print ($i) . "==" . count($productList);
		if (($i) == count($productList)) {
			ImportManagerLog::write("complete");
		}



	}

}
  