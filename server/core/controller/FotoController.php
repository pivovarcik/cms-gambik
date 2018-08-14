<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class FotoController extends G_Controller_Action
{

	private $upload_name;

//	public function __construct($upload_name = "Filedata")
	public function __construct($upload_name = "Filedata")
	{
		parent::__construct();

		$this->upload_name = $upload_name;
	}

	public function getFoto($foto_id)
	{
		$_fotoGallery = new models_FotoGallery();
		return $_fotoGallery->getRow($foto_id);
	}

	public function sortItemsAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('sort', false))
		{
			//
			$sortId = $this->getRequest->getPost('sort', false);
			print_r($sortId);
			$galleryType = $this->getRequest->getPost('sort', false);
			if (!is_array($sortId) || count($sortId) <= 0) {
				return false;
			}

			$model = new models_FotoPlaces();
			for ($i=0; $i < count($sortId); $i++) {

				$model->updateRecords($model->getTableName(),array("order" => $i),"id=".$sortId[$i]);
				//print $model->getLastQuery();
			}



		}
	}

	public function deleteProcess($fotoId)
	{
		$fotoInfo = $this->getFoto($fotoId);

		if (!$fotoInfo) {

			print "foto ID: " . $fotoId . " nebylo nelazeno!";
			return false;
		}
		//$fotoInfo->file;

		$model = new models_FotoGallery();


		$file =  PATH_IMG . $fotoInfo->file;

		if (file_exists($file))
		{
			$delete = unlink($file);  // Velký obrázek
		}
		if($model->delete($fotoId))
		{
			// smažu i přiřazení fotky
			$model->deleteRecords(T_FOTO_PLACES, "uid_source=" . $fotoId);
			return true;
		}

	}

	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "ImageEdit" ==$this->getRequest->getPost('action', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ImageEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$postdata = $form->getValues();

			//	$postdata["description"]=  ($postdata["description"]);
				$foto_id = (int) $this->getRequest->getQuery('id', false);

				$FotoEntity = new FotoEntity($foto_id);

				$FotoEntity->file = $postdata["file"];
				$FotoEntity->description = $postdata["description"];

				$zmenaNazvuSouboru = false;
				if ($FotoEntity->file != $FotoEntity->fileOriginal) {
					$zmenaNazvuSouboru = true;

					$FotoEntity->file = autoFileName($FotoEntity->file, $FotoEntity->type);
				}


				$saveEntity = new SaveEntity();

				$saveEntity->addSaveEntity($FotoEntity);

				if ($saveEntity->save()) {

					if ($zmenaNazvuSouboru) {

						//	print_r($FotoEntity);
						//		print "|" . $FotoEntity->fileOriginal . ">" . $FotoEntity->file . "|";
						return	$this->renameFile($FotoEntity->fileOriginal, $FotoEntity->file);
					}

					return true;
				}



			}


		}
	}

	private function renameFile($originalFileName, $newFileName)
	{

		$filename =  PATH_IMG . $originalFileName;

		if (file_exists($filename))
		{
			//	$delete = unlink($filename);
			//	print $filename . ">" . PATH_DATA . $newFileName;
			rename($filename, PATH_IMG . $newFileName);

			return true;
		}
		return false;
	}

	public function deleteAjaxAction()
	{
		//	print "aaaa";
		if($this->getRequest->isPost() && "ImageDelete" == $this->getRequest->getPost('action', false))
		{
			$foto_id = (int) $this->getRequest->getQuery('id', false);

			$place_id = (int) $this->getRequest->getQuery('place_id', false);
			$deleteFoto = (int) $this->getRequest->getPost('F_ImageDeleteConfirm_delete', 0);



			$model = new models_FotoGallery();
			$obj = $model->getDetailById($foto_id);

			if ($obj) {

				if ($deleteFoto == 1 || !$place_id) {
					$this->deleteFile($obj);
				} else {
					$this->removePlaceFoto($place_id);
				}

				return true;
				//	return true;

			}



		}



	}

	private function removePlaceFoto($place_id)
	{
		$model = new models_FotoGallery();

		$model->deleteRecords(T_FOTO_PLACES, "id=" . $place_id);

	}

	private function deleteFile($foto)
	{
		if ($foto) {
			$file =  PATH_IMG . $foto->dir . $foto->file;

			if (file_exists($file))
			{
				$delete = unlink($file);  // Velký obrázek
			}
			$model = new models_FotoGallery();
			if($model->delete($foto->id))
			{
				// smažu i přiřazení fotky
				$model->deleteRecords(T_FOTO_PLACES, "uid_source=" . $foto->id);
			//	array_push($seznamCiselObjednavek,$obj->file );
			}
		}
	}
	public function deleteAction($fotoId=null)
	{
		//	print "aaaa";
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('delete_foto_umisteni', false))
		{
			$fotoId = (int) $this->getRequest->getPost('delete_foto_umisteni', false);
			$table = $this->getRequest->getPost('gallery_type', false);
			$targetId = (int) $this->getRequest->getPost('gallery_id', false);

			$model = new models_FotoGallery();
			if($model->deleteRecords(T_FOTO_PLACES, "uid_source=" . $fotoId . " and uid_target=" . $targetId . " and `table`='" . $table. "'"))
			{

			}

		}



		if($this->getRequest->isPost() && false !==$this->getRequest->getPost('action', false)
			&& "deleteFotoGallery" == $this->getRequest->getPost('action', false))
		{

			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_FotoGallery();
						$obj = $model->getDetailById($doklad_id);


						if ($obj) {
							$file =  PATH_IMG . $obj->dir . "" . $obj->file;

							if (file_exists($file))
							{
								$delete = unlink($file);  // Velký obrázek
							}
							if($model->delete($doklad_id))
							{
								// smažu i přiřazení fotky
								$model->deleteRecords(T_FOTO_PLACES, "uid_source=" . $doklad_id);
								array_push($seznamCiselObjednavek,$obj->file );
							}
						}

					}
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Fotky " . implode(",", $seznamCiselObjednavek) . " byla smazána.";
				$_SESSION["classmessage"]="success";
				$this->getRequest->goBackRef();
			}

		}

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('delete_foto', false))
		{
			$fotoId = (int) $this->getRequest->getPost('delete_foto', false);

			if (isset($_POST["delete_foto"]) && is_array($_POST["delete_foto"])) {
				$tenzin = $_POST["delete_foto"];
				list($key,$value) = each($tenzin);

				$fotoId = (int) $_POST["foto_id"][$key];
			}


			$targetId = (int) $this->getRequest->getPost('gallery_id', false);
			$type = $this->getRequest->getPost('gallery_type', false);
			$fotoInfo = $this->getFoto($fotoId);

			if (!$fotoInfo) {

				print "foto ID: " . $fotoId . " nebylo nelazeno!";
				return false;
			}
			//$fotoInfo->file;

			$model = new models_FotoGallery();

			if ($targetId && $type == "Products") {
				// u produktu mazu pouze odkaz, pri kopii to smazalo fotky i u vsech kopirovaných!!
				$table=T_SHOP_PRODUCT;
				if($model->deleteRecords(T_FOTO_PLACES, "uid_source=" . $fotoId . " and uid_target=" . $targetId . " and `table`='" . $table. "'"))
				{

				}
			} else {
				$file =  PATH_IMG . $fotoInfo->dir . $fotoInfo->file;

				if (file_exists($file))
				{
					$delete = unlink($file);  // Velký obrázek
				}

				//print "mažu";
				if($model->delete($fotoId))
				{
					// smažu i přiřazení fotky
					$model->deleteRecords(T_FOTO_PLACES, "uid_source=" . $fotoId);

					//$this->getRequest->goBackRef();
					//exit;
					return true;
				}
			}

		}


	}

	public function fotoList(IListArgs $params = null)
	{
		$model = new models_FotoGallery();
		if (is_null($params)) {
			$params = new ListArgs();
		}
		$l = $model->getList($params);
		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}

	public function fotoUmisteniListEdit(FotoPlacesListArgs $args = null)
	{

		$gallery_type  = $args->gallery_type;
		if (!empty($args->gallery_type)) {
			$myClass = $args->gallery_type . "Controller";

			if (class_exists($myClass)) {
				$testController = new $myClass();
				$args->gallery_type = $testController->getTableName();
			}
		}


		$model = new models_FotoPlaces();
		$fotoGallery = $model->getList($args);
		$this->total = $model->total;

		$foto_id = 0;

		$res = '<input type="hidden" id="gallery_id" value="'.$args->gallery_id.'" name="gallery_id" />';
		$res .= '<input type="hidden" id="gallery_type" value="'.$gallery_type.'" name="gallery_type" />';

		$res .= '<ul class="photoGallery">';
		if (count($fotoGallery)>0)
		{
			$imageController = new ImageController();
			for ($i=0;$i < count($fotoGallery);$i++)
			{


				if (!empty($fotoGallery[$i]->file))
				{
					//$PreviewUrl = $g->get_thumb3($fotoGallery[$i]->file,90,90);
				//	$PreviewUrl = $imageController->getZmensitOriginal($fotoGallery[$i]->dir . $fotoGallery[$i]->file,$args->width,$args->height);
          $PreviewUrl = $imageController->getFileUrl($fotoGallery[$i]->dir . $fotoGallery[$i]->file,$args->width,$args->height);

					$class_main = '';
					if ($foto_id == $fotoGallery[$i]->id) {
						$class_main = ' is-main';
					}
					$res .= '<li title="' . $fotoGallery[$i]->description . '" class="foto_item'.$class_main.'" id="sort_'.$fotoGallery[$i]->place_id. '" style="position:relative;">';


					$res .= '<div class="dropdown">';
					$res .= '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu' . $fotoGallery[$i]->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
					$res .= '<i class="fa fa-gear"></i> ';
					$res .= '<span class="caret"></span>';
					$res .= '</button>';
					$res .= '<ul class="dropdown-menu" aria-labelledby="dropdownMenu' . $fotoGallery[$i]->id . '">';
					$res .= '<li><a class="modal-form" data-url=' . URL_HOME_SITE . 'admin/foto?do=ImageDelete&id=' . $fotoGallery[$i]->id . '&place_id=' . $fotoGallery[$i]->place_id . '" data-callback="loadPhotoGallery" data-callback-params="'.$args->gallery_id.', \''.$gallery_type.'\'" href="#" title="Smazat obrázek" id="foto_' . $fotoGallery[$i]->id . '" href="#"><i class="fa fa-times"></i> smazat</a></li>';
					$res .= '<li><a class="modal-form" data-url="' . URL_HOME_SITE . 'admin/foto?do=ImageEdit&id=' . $fotoGallery[$i]->id . '&place_id=' . $fotoGallery[$i]->place_id . '" data-callback="loadPhotoGallery" data-callback-params="'.$args->gallery_id.', \''.$gallery_type.'\'" href="#" title="Editovat obrázek" id="foto_' . $fotoGallery[$i]->id . '" href="#"><i class="fa fa-pencil"></i> editovat</a></li>';
          $res .= '<li><a href="' . URL_HOME_SITE . 'admin/download.php?f=' . urlencode( $fotoGallery[$i]->dir . $fotoGallery[$i]->file) . '"><i class="fa fa-download"></i> Stáhnout</a></li>';
					$res .= '<li><a class="main-btn" data-place-id="' . $fotoGallery[$i]->id . '" href="#"><i class="fa fa-check-square-o"></i> jako hlavní</a></li>';
				  	$res .= '</ul>';
					$res .= '</div>';


					$res .= '<input type="hidden" class="place_id" value="'.$fotoGallery[$i]->id.'" name="place_id" />';
					// Delete
			/*		$res .= '<a class="delete-btn2 modal-form" data-url="/admin/foto?do=PhotoDelete&id=' . $fotoGallery[$i]->id . '&place_id=' . $fotoGallery[$i]->place_id . '" data-callback="loadPhotoGallery" data-callback-params="'.$args->gallery_id.', \''.$gallery_type.'\'" href="#" title="Smazat obrázek" id="foto_' . $fotoGallery[$i]->id . '" style="height: 16px;cursor:pointer;position: absolute;width: 16px;right:5px;top:5px;display:block;">';
					$res .= '<img src="/admin/style/images/minus.png" />';
					$res .= '</a>';

					// Set main
					$res .= '<a class="main-btn" href="#" title="Nastavit obrázek jako hlavní" style="height: 16px;cursor:pointer;position: absolute;width: 16px;right:5px;top:35px;display:block;">';
					$res .= '<img src="/admin/style/images/flag.png" />';
					$res .= '</a>';
					*/
					/**/


		$res .= '<span class="foto-description">#' . $fotoGallery[$i]->id . ' ' . $fotoGallery[$i]->description . '</span>';

					$res .= '<a title="' . $fotoGallery[$i]->description . '" href="' . URL_IMG . $fotoGallery[$i]->dir . $fotoGallery[$i]->file . '" data-rel="lightbox[roadtrip]" class="lightbox"><img class="imgobal" src="' . $PreviewUrl . '" alt="' . $fotoGallery[$i]->file . '"/></a>';
					//	$res .= '<div style="text-align:center;"><input type="text" name="title" value="' . $fotoGallery[$i]->title . '" class="textbox" /></div>';
					//	$res .= '</div>';

					$res .= '</li>';
				}
			}


		} else {

			$res .= 'galerie produktu je prázdná!';
		}

		$res .= '</ul>';
		$res .= '<div class="clearfix"> </div>';
		return $res;

	}

	public function fotoUmisteniListEditOld(FotoPlacesListArgs $args = null)
	{

		$gallery_type  = $args->gallery_type;
		if (!empty($args->gallery_type)) {
			$myClass = $args->gallery_type . "Controller";

			if (class_exists($myClass)) {
				$testController = new $myClass();
				$args->gallery_type = $testController->getTableName();
			}
		}


		$model = new models_FotoPlaces();
		$fotoGallery = $model->getList($args);


		$foto_id = 0;

		$res = '<input type="hidden" id="gallery_id" value="'.$args->gallery_id.'" name="gallery_id" />';
		$res .= '<input type="hidden" id="gallery_type" value="'.$gallery_type.'" name="gallery_type" />';

		$res .= '<ul class="photoGallery">';
		if (count($fotoGallery)>0)
		{
			$imageController = new ImageController();
			for ($i=0;$i < count($fotoGallery);$i++)
			{


				if (!empty($fotoGallery[$i]->file))
				{
					//$PreviewUrl = $g->get_thumb3($fotoGallery[$i]->file,90,90);
					$PreviewUrl = $imageController->getZmensitOriginal($fotoGallery[$i]->file,$args->width,$args->height);

					$class_main = '';
					if ($foto_id == $fotoGallery[$i]->id) {
						$class_main = ' is-main';
					}
					$res .= '<li class="foto_item'.$class_main.'" id="sort_'.$fotoGallery[$i]->place_id.'" style="position:relative;">';



					$res .= '<input type="hidden" class="place_id" value="'.$fotoGallery[$i]->id.'" name="place_id" />';
					// Delete
					$res .= '<a class="delete-btn" href="#" title="Smazat obrázek" id="foto_' . $fotoGallery[$i]->id . '" style="height: 16px;cursor:pointer;position: absolute;width: 16px;right:5px;top:5px;display:block;">';
					$res .= '<img src="/admin/style/images/minus.png" />';
					$res .= '</a>';

					// Set main
					$res .= '<a class="main-btn" href="#" title="Nastavit obrázek jako hlavní" style="height: 16px;cursor:pointer;position: absolute;width: 16px;right:5px;top:35px;display:block;">';
					$res .= '<img src="/admin/style/images/flag.png" />';
					$res .= '</a>';
					/**/
$res .= '<div style="display:none;">';

					if (isset($fotoGallery[$i]->title)) {
						$res .= '<input type="text" name="title" value="' . $fotoGallery[$i]->title . '" class="textbox" />';
					}

					$res .= '</div>';
					$res .= '<a title="" href="' . URL_IMG . $fotoGallery[$i]->file . '" data-rel="lightbox[roadtrip]" class="lightbox"><img class="imgobal" src="' . $PreviewUrl . '" alt="' . $fotoGallery[$i]->file . '"/></a>';
					//	$res .= '<div style="text-align:center;"><input type="text" name="title" value="' . $fotoGallery[$i]->title . '" class="textbox" /></div>';
					//	$res .= '</div>';

					$res .= '</li>';
				}
			}


		} else {

			$res .= 'galerie produktu je prázdná!';
		}

		$res .= '</ul>';
		$res .= '<div class="clearfix"> </div>';
		return $res;

	}
	public function copyAction()
	{

	}

	public function copyProces($from_url, $table, $target_id)
	{
		$data = array();
		if (defined("USER_ID")) {
			$data["user_id"] = (int) USER_ID;
		}

		//	$data["description"] = $description;
		//, $description = NULL

		$model = new models_FotoGallery();
		if($model->insertRecords($model->getTableName(),$data))
		{
			$path_info_source = pathinfo($from_url);
       //  print_r($path_info_source);
      $extension = "jpg";   
      if (isset($path_info_source["extension"]))
      {
          $extension2 = explode("?",$path_info_source["extension"]);
          $extension = $extension2[0];
      }
      if (!in_array($extension,array("jpg","png","gif")))
      {
         $extension = "jpg";  
      }   
       
      
       
			$id = $model->insert_id;
			$upload_filename = $this->getNewFileName() . "." . $extension;
      
  //    print $upload_filename;
    //  exit;
      
      
			$to = PATH_IMG . $upload_filename;


			$dir = null;
			$settings = G_Setting::instance();
			if ("1" == $settings->get("IMG_TREE"))
			{
				$DirOrganizator = new DirOrganizator();

				$dir = $DirOrganizator->getPath();
				$to = $dir . $upload_filename;


				$dir = substr($dir,strlen(PATH_IMG),strlen($dir));
			}



			if (!$this->copy($from_url, $to)) {
				// uklidím po sobě
				$model->deleteRecords($model->getTableName(), "id={$id}");
				return false;
			}

			$data =array();
			$data["file"] = $upload_filename;
			$path_info = pathinfo($to);
			$data["size"] = @filesize($to);
			$data["type"] = strtolower($extension);
      
      $data["filename_original"] = $path_info["filename"] . "." . $path_info["extension"];
			$data["dir"] = $dir;


			if($model->updateRecords($model->getTableName(), $data, "id={$id}"))
			{

				if ($target_id)
				{
					// pokud existuje vazba k umístění
					$this->addFotoGallery($id, $target_id, $table);
				}

				// Přesunuto níže, kvůli tomu, že občas přeteče velikost
				$image = new ImageController();
				$image->resize($upload_filename,MAX_WIDTH,MAX_HEIGHT,PATH_WATERMARK);
			//	$data["size"] = filesize (PATH_IMG .$upload_filename);

				return $id;
			}
		}
	}

	/**
	 * zkopíruje soubor odkud -> kam
	 * **/
	public function copy($from, $to)
	{
		$arrContextOptions=array(
		"ssl"=>array(
		    "verify_peer"=>false,
		    "verify_peer_name"=>false,
			),
	);
		return file_put_contents($to, @file_get_contents($from, false, stream_context_create($arrContextOptions)) );

	}

	public function getNewFileName()
	{
		return rand_str(15);
	}


	public function createFoto($upload_form_name)
	{


		$data = array();
		$data["user_id"] = USER_ID;

		///print_r($data);
		$model = new models_FotoGallery();
		if($model->insertRecords($model->getTableName(),$data))
		{
			$id = $model->insert_id;
			$this->insert_id = $model->insert_id;

			// Upload file
			$upload = new G_Upload();
			$extension_whitelist = explode(",",IMAGE_EXTENSION_WHITELIST);

			$upload->extension_whitelist = $extension_whitelist;
			//$upload->setPrefixFilename($id . "-");
			//$upload->filename = mt_rand();

			$upload->upload_name = $upload_form_name;
			$upload->filename = $this->getNewFileName();
			if (!$upload->move()) {
				// uklidím po sobě
				$model->deleteRecords($model->getTableName(), "id={$id}");
				$_SESSION["statusmessage"]= $upload->message; //"Nepodařilo se nahrát soubor!";
				$_SESSION["classmessage"]="errors";
				return false;
			}
			$data =array();
			$data["file"] = $upload->filename;
			$data["size"] = $upload->file_size;
			$data["filename_original"] = $upload->filename_original;
			$data["type"] = $upload->file_extension;


			if($model->updateRecords($model->getTableName(), $data, "id={$id}"))
			{
/*
				if ($target_id)
				{
					// pokud existuje vazba k umístění
					$this->addFotoGallery($id, $target_id, $table);
				}

*/
				// Přesunuto níže, kvůli tomu, že občas přeteče velikost
				$image = new ImageController();
				$image->resize($upload->filename,MAX_WIDTH,MAX_HEIGHT,PATH_WATERMARK);
				$data["size"] = filesize (PATH_IMG .$upload->filename);


				$_SESSION["statusmessage"]="Soubor byl nahrán.";
				$_SESSION["classmessage"]="success";
				return $id;
			}

		} else {
			$_SESSION["statusmessage"]= "Nepodařilo se uložit soubor do databáze!";
			$_SESSION["classmessage"]="errors";
			return false;
		}
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('create_foto', false))
		{

			$data = array();

			//	$data["caszapsani"] = date('Y-m-d H:i:s');
			//$data["uid_user"] = USER_ID;
			$data["user_id"] = USER_ID;


			$table = $this->getRequest->getPost('table', false);
			$controller = $this->getRequest->getPost('controller', false);
			$target_id = $this->getRequest->getPost('id', false);


			if ($controller) {
				//	$controller = NULL;
				$myClass = $controller . "Controller";

				if (class_exists($myClass)) {
					$pageController = new $myClass();

					$table = $pageController->getTableName();
					//	$modelName = $table;
					//	$table = NULL;

				}
			}
      
     // print_r($_FILES);
      //EXIT;

     // Array ( [files] => Array ( [name] => Joya_CZ_SS18_2.jpg [type] => image/jpeg [tmp_name] => /tmp_vz/tmp_www/phpEJ94lD [error] => 0 [size] => 290785 ) ) 
     
     //Array ( [files] => Array ( [name] => Array ( [0] => Joya_CZ_SS18_4.jpg ) [type] => Array ( [0] => image/jpeg ) [tmp_name] => Array ( [0] => /tmp_vz/tmp_www/phpyXIPxK ) [error] => Array ( [0] => 0 ) [size] => Array ( [0] => 254323 ) ) )
      
			///print_r($data);
			$model = new models_FotoGallery();
			if($model->insertRecords($model->getTableName(),$data))
			{
				$id = $model->insert_id;
				$this->insert_id = $model->insert_id;

				// Upload file
				$upload = new G_Upload();
				$extension_whitelist = explode(",",IMAGE_EXTENSION_WHITELIST);

				$upload->extension_whitelist = $extension_whitelist;
				//$upload->setPrefixFilename($id . "-");
				//$upload->filename = mt_rand();

				$dir = null;
				$settings = G_Setting::instance();
				if ("1" == $settings->get("IMG_TREE"))
				{
					$DirOrganizator = new DirOrganizator();

					$dir = $DirOrganizator->getPath();
					$upload->setSavePath($dir);


					$dir = substr($dir,strlen(PATH_IMG),strlen($dir));
				}



				$upload->upload_name = $this->upload_name;
				$upload->filename = $this->getNewFileName();
				if (!$upload->move()) {
					// uklidím po sobě
					$model->deleteRecords($model->getTableName(), "id={$id}");
					$_SESSION["statusmessage"]= $upload->message; //"Nepodařilo se nahrát soubor!";
					$_SESSION["classmessage"]="errors";
					return false;
				}
				$data =array();
				$data["file"] = $upload->filename;
				$data["size"] = $upload->file_size;
				$data["type"] = $upload->file_extension;
        $data["filename_original"] = $upload->filename_original;
				$data["dir"] = $dir;


				if($model->updateRecords($model->getTableName(), $data, "id={$id}"))
				{
					if ("1" == $settings->get("IMG_TREE"))
					{
						$DirOrganizator->setLogCurrentFolder();
					}

					if ($target_id)
					{
						// pokud existuje vazba k umístění
						$this->addFotoGallery($id, $target_id, $table);
					}


					// Přesunuto níže, kvůli tomu, že občas přeteče velikost
					$image = new ImageController();
					$image->resize($upload->filename,MAX_WIDTH,MAX_HEIGHT,PATH_WATERMARK);
					$data["size"] = filesize (PATH_IMG .$upload->filename);


					$_SESSION["statusmessage"]="Soubor byl nahrán.";
					$_SESSION["classmessage"]="success";
					return true;
				}

			} else {
				$_SESSION["statusmessage"]= "Nepodařilo se uložit soubor do databáze!";
				$_SESSION["classmessage"]="errors";
				return false;
			}
		}

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('create_logo', false))
		{

			$data = array();

			$data["caszapsani"] = date('Y-m-d H:i:s');
			$uid_catalog = $this->getRequest->getPost('uid_catalog', false);
			/*
			   if ($uid_catalog && is_numeric($uid_catalog)) {
			   $data["uid_catalog"] = $uid_catalog;
			   }
			*/

			$model = new models_FotoGallery();
			$model->setData($data);
			if($model->insert())
			{
				$id = $model->insert_id;
			}

			// Upload file
			$upload = new G_Upload();
			$upload->setPrefixFilename($id . "-");
			if (!$upload->move()) {
				// uklidím po sobě
				$model->deleteRecords($model->getTableName(), "uid={$id}");
			}
			$data =array();
			$data["file"] = $upload->filename;

			if($model->updateRecords($model->getTableName(), $data, "uid={$id}"))
			{
				$modelCatalog = new models_Catalog();
				$modelCatalog->setMainLogo($uid_catalog,$id);
			}
		}
	}

	/*
	   * Tvorba vazby mezi fotkou a galeriií
	*/
	public function addFotoGallery($foto_id, $target_id, $table)
	{
		$data = array();
		$data["uid_source"] = $foto_id;
		$data["uid_target"] = $target_id;
		$data["table"] = $table;

		//
		$where = array();
		$where[] = "uid_source =" . $foto_id;
		$where[] = "uid_target =" . $target_id;
		$where[] = "`table` ='" . $table . "'";

		$fotoPlacesModel = new models_FotoPlaces();
		$fotoPlacesModel->setWhere($where);
		$query = "select * from " . $fotoPlacesModel->getTableName() . $fotoPlacesModel->getWhere();
		//print $query;
		$row = $fotoPlacesModel->getRow($query);

		if (!$row) {
			if($fotoPlacesModel->insertRecords($fotoPlacesModel->getTableName(), $data))
			{
				return true;
			}
		}
	}
}