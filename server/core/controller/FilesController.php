<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class FilesController extends G_Controller_Action
{

	private $file_id;
	private $upload_name;
	public function __construct($upload_name= "Filedata")
	{

		parent::__construct();
    $this->upload_name = $upload_name;
		$this->uidSession = $this->getRequest->getSession('uidlogin2', '');

		//print $this->uidSession;
		$this->timeBan = (30) * 60; // Platnost 30min
		$this->newUidSession = strtolower(substr(md5(rand()),0,12)); // Vytvořím unikátní ID



	}

	public function getFileId()
	{
		return $this->file_id;
	}

	public function getDetailById($id)
	{
		$model = new models_Files();

		return $model->getDetail($id);
	}

	// tabulkový výpis fotek
	public function fotoListTable($params = array())
	{
		$list = $this->filesListEdit($params);


		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["filename"] = "Soubor";
		$column["filesize"] = "Velikost";
		$column["vlozeno"] = "Nahráno / uživatel";
		$column["cmd"] = '';


		$column = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
	//	$column["preview"] = "Náhled";
		$column["filename"] = "Soubor";
		//$column["filepath"] = "Cesta";
		$column["filesize"] = "Velikost";
		$column["type"] = "Typ";
		$column["vlozeno"] = "Nahráno / uživatel";
		$column["cmd"] = '';

		$th_attrib = array();
		$th_attrib["checkbox"]["class"] = "check-column";

		$th_attrib["vlozeno"]["class"] = "column-date";
		$th_attrib["filesize"]["class"] = "column-qty";
		$th_attrib["type"]["class"] = "column-qty";
		$th_attrib["autor"]["class"] = "column-date";
		$th_attrib["cmd"]["class"] = "column-cmd";
		$th_attrib["preview"]["class"] = "column-thumbs";

		$td_attrib = array();
		$td_attrib["filesize"]["class"] = "column-qty";

		$table = new G_Table($list, $column, $th_attrib, $td_attrib);

		/*
		   $table_attrib = array(
		   "class" => "widefat fixed",
		   "id" => "data_grid",
		   "cellspacing" => "0",
		   );
		*/
		$table_attrib = array(
			"class" => "widefat fixed",
			"id" => "data_grid",
			"cellspacing" => "0",
			);
		return $table->makeTable($table_attrib);

		//return $table;

	}

	public function filesListEdit($params = array())
	{
		$l = $this->filesList($params);
		for($i=0;$i<count($l);$i++)
		{

			$elemKlicMa = new G_Form_Element_Checkbox("slct[" . $i . "]");
			$elemKlicMa->setAttribs('value', $l[$i]->uid);
			$l[$i]->checkbox = $elemKlicMa->render();
/*
			if (round($l[$i]->size/1024,2) > 1000) {
				$filesize = round($l[$i]->size/1024/1024,2) . " MB";
			} else {
				$filesize = round($l[$i]->size/1024,2) . " kB";
			}
			*/
			$l[$i]->filesize = sizeFormat($l[$i]->size);//$filesize;

			$filename = '<a target="_blank" href="'.URL_DATA . $l[$i]->file.'">' . $l[$i]->file . '</a><br />';

			$elem = new G_Form_Element_Text("path[" . $i . "]");
			$elem->setAttribs('value', URL_DATA . $l[$i]->file);
			$elem->setAttribs('style', 'width:99%;');
			$filename .= $elem->render();

			$l[$i]->filename = $filename;
			$l[$i]->vlozeno = date("j.n.Y H:i:s",strtotime($l[$i]->TimeStamp)) . "<br />" . $l[$i]->uzivatel;

			$command = '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu SMAZAT soubor '.$l[$i]->file.'?\')" type="image" src="'.URL_HOME . 'admin/action_delete.gif" value="X" name="delete_file[' . $i . ']"/>';
			$command .= '<input type="hidden" value="' . $l[$i]->id . '" name="file_id[' . $i . ']"/>';
			$l[$i]->cmd = $command;
		}
		return $l;
	}
	public function filesList($params = array())
	{
		$model = new models_Files();

		$limit 	= $this->getRequest->getQuery('limit', 100);
		$page 	= $this->getRequest->getQuery('pg', 1);
		$search_string = $this->getRequest->getQuery('q', '');

		$querys = array();

		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'t1.titulek_cs');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'t1.description_cs');
		$orderFromQuery = $this->orderFromQuery($querys, 't1.TimeStamp DESC');

		$l = $model->getList(array(
						'limit' => $limit,
						'fulltext' => $search_string,
						'page' => $page,
						'catalog' => $catalogID,
						'product' => $productID,
						'order' => $orderFromQuery,
						'debug' => 0,
						));
		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}


	public function copyProces($from_url, $extension_whitelist, $table, $target_id)
	{

		$uploadAdapter = new G_UploadUrl();
		$uploadAdapter->from_url = $from_url;
		$uploadAdapter->filename = rand();
		$data = array();
		$data["user_id"] = (int) USER_ID;

		return $this->create2($uploadAdapter, $data, $extension_whitelist, $target_id, $table);
	}

	private function create2(IUploadAdapter $uploadAdapter, $data = array(),$extension_whitelist = NULL,$target_id = false,$table=null)
	{
		$insertData = array();
		//$data["caszapsani"] = date('Y-m-d H:i:s');
		if (defined("USER_ID")) {
			$insertData["user_id"] = USER_ID;
		}
		if (!empty($data["popis"])) {
			$insertData["description"] = $data["popis"];
		}


		$model = new models_Files();
		//$model->setData($data);
		if($model->insertRecords($model->getTableName(),$insertData))
		{
			$this->file_id = $model->insert_id;

			if ($extension_whitelist == NULL) {
				$extension_whitelist = explode(",",DATA_EXTENSION_WHITELIST);
			}

			// vyhybka pro url/ nebo upload
			$uploadAdapter->extension_whitelist = $extension_whitelist;
			$uploadAdapter->setSavePath(PATH_DATA);
			//$upload->setPrefixFilename($this->file_id . "-");
      
      
      				$uploadAdapter->upload_name = $this->upload_name;
			//	$upload->filename = $this->getNewFileName();
        
        
			if (!$uploadAdapter->move()) {

			//	print "tudy";
				// uklidím po sobě
				$model->deleteRecords($model->getTableName(), "id={$this->file_id}");
				$_SESSION["statusmessage"]= $uploadAdapter->message; //"Nepodařilo se nahrát soubor!";
				$_SESSION["classmessage"]="errors";
				return false;
			}

			$insertData =array();
			$insertData["file"] = $uploadAdapter->filename;
			//$data["uid_key"] = $upload->filename;
			$insertData["size"] = $uploadAdapter->file_size;
			$insertData["type"] = $uploadAdapter->file_extension;

			if($model->updateRecords($model->getTableName(), $insertData, "id={$this->file_id}"))
			{
				$_SESSION["statusmessage"]="Soubor byl nahrán.";
				$_SESSION["classmessage"]="success";


				if ($target_id)
				{
					// pokud existuje vazba k umístění
					$this->addFotoGallery($this->file_id, $target_id, $table);
				}

				return true;
			}
		} else {
			$_SESSION["statusmessage"]= "Nepodařilo se uložit soubor do databáze!";
			$_SESSION["classmessage"]="errors";
			return false;
		}



	}
	public function create($data = array(),$extension_whitelist = NULL,$target_id = false,$table=null)
	{

		$uploadAdapter = new G_Upload();
		return $this->create2($uploadAdapter, $data, $extension_whitelist, $target_id, $table);
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upload_file', false))
		{

			$form = $this->formLoad('FileUpload');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$formdata = $form->getValues();


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

				$this->create($formdata,null,$target_id,$table);


			} else {
				foreach($form->getError() as $key => $value)
				{
					$_SESSION["statusmessage"]= $key . ": ". $value;
				}
				//print_r($form->getError());

				$_SESSION["classmessage"]="errors";
			}


		}
	}

	public function addFotoGallery($foto_id, $target_id, $table)
	{
		$data = array();
		$data["source_id"] = $foto_id;
		$data["target_id"] = $target_id;
		$data["table"] = $table;

		//
		$where = array();
		$where[] = "source_id =" . $foto_id;
		$where[] = "target_id =" . $target_id;
		$where[] = "`table` ='" . $table . "'";

		$fotoPlacesModel = new models_FilePlaces();
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

	public function deleteFile($id)
	{
		$model = new models_Files();
		$file = $model->getDetailById($id);

		if ($file) {
			if (!empty($file->file))
			{
				$filename =  PATH_DATA . $file->file;

				if($model->deleteRecords(T_FILE_PLACES, "source_id={$id} "))
				{

				}

				$model->deleteRecords($model->getTableName(),"id=" . $id);
				if (@file_exists($filename))
				{
					$delete = unlink($filename);
					return true;
				}
			}
		}
		return false;
	}


	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "FileEdit" ==$this->getRequest->getPost('action', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('FileEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$postdata = $form->getValues();

				//	$postdata["description"]=  ($postdata["description"]);
				$foto_id = (int) $this->getRequest->getQuery('id', false);

				$FotoEntity = new DataEntity($foto_id);

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

		$filename =  PATH_DATA . $originalFileName;

		if (file_exists($filename))
		{
		//	$delete = unlink($filename);
		//	print $filename . ">" . PATH_DATA . $newFileName;
			rename($filename, PATH_DATA . $newFileName);

			return true;
		}
		return false;
	}

	public function deleteAjaxAction()
	{
		//	print "aaaa";
		if($this->getRequest->isPost() && "FileDelete" == $this->getRequest->getPost('action', false))
		{
			$foto_id = (int) $this->getRequest->getQuery('id', false);

			$place_id = (int) $this->getRequest->getQuery('place_id', false);




			$model = new models_Files();
			$obj = $model->getDetailById($foto_id);

			if ($obj) {
				$this->deleteFile($foto_id);
			/*	if ($deleteFoto == 1 || !$place_id) {
					$this->deleteFile($obj);
				} else {
					$this->removePlaceFoto($place_id);
				}*/

				return true;
				//	return true;

			}



		}



	}

	public function deleteAction()
	{


		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('delete_file', false)
			 && false !== $this->getRequest->getPost('file_id', false))
		{
			$model = new models_Files();

			$tenzin = $this->getRequest->getPost('delete_file', false);
			list($key,$value) = each($tenzin);
			//	print $key;
			$id = (int) $_POST['file_id'][$key];

			if ($this->deleteFile($id)) {
				$_SESSION["statusmessage"]="Soubor byl smazán.";
				$_SESSION["classmessage"]="success";
				//$this->clear_post();
				//$this->getRequest->clearPost();
				$this->getRequest->goBackRef();
				exit;
				return true;
			}
		}

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('delete_file', false))
		{
			$model = new models_Files();

			$id = $this->getRequest->getPost('delete_file', false);

			if ($this->deleteFile($id)) {

				return true;
			}
		}

		if($this->getRequest->isPost() && false !==$this->getRequest->getPost('action', false)
			&& "deleteFiles" == $this->getRequest->getPost('action', false))
		{

			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						//$model = new models_Files();

							if($this->deleteFile($doklad_id))
							{
								// smažu i přiřazení fotky
								array_push($seznamCiselObjednavek,$doklad_id );
							}


					}
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Soubor " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
				$_SESSION["classmessage"]="success";
				$this->getRequest->goBackRef();
			}

		}
	}



	public function filesUmisteniList($params = array())
	{
		$model = new models_Files();
		$params2 = array();
		$limit 	= $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}

		$page 	= $this->getRequest->getQuery('pg', 1);
		if (isset($params['page']) && is_numeric($params['page'])) {
			$page = $params['page'];
		}
		//$search_string = $this->getRequest->getQuery('q', '');
		//$skupina = $this->getRequest->getQuery('grp', '');
		//$category = $this->getRequest->getQuery('cat', '');

		if (isset($params['gallery_id']) && is_numeric($params['gallery_id'])) {
			$params2['gallery_id'] = $params['gallery_id'];

			$myClass = $params["gallery_type"] . "Controller";

			if (class_exists($myClass)) {
				$pageController = new $myClass();
				//	print "tudy";
				$params2['gallery_type'] = $pageController->getTableName();
				//$params2['gallery_type'] = CatalogVideoController::getModel()->getTableName();

			} else {
				$params2['gallery_type'] = $params['gallery_type'];
			}

		}

		$querys = array();

		//	$querys[] = array('title'=>'Název','url'=>'name','sql'=>'t1.name');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'t1.description');

		$orderFromQuery = $this->orderFromQuery($querys, 't2.order ASC, t1.TimeStamp DESC');

		if (isset($params['order']) && !empty($params['order'])) {
			$orderFromQuery = $params['order'];
		}
		$params2["order"] = $orderFromQuery;
		$params2["limit"] = $limit;
		$params2["page"] = $page;
		$l = $model->get_umisteni_list($params2);

		$this->total = $model->total;
		//$this->categoryTable();
		return $l;
	}




  	public function filesUmisteniListEdit(FotoPlacesListArgs $args = null)
	{

		$gallery_type  = $args->gallery_type;
		if (!empty($args->gallery_type)) {
			$myClass = $args->gallery_type . "Controller";

			if (class_exists($myClass)) {
				$testController = new $myClass();
				$args->gallery_type = $testController->getTableName();
			}
		}


		$model = new models_FilePlaces();
		$fotoGallery = $model->getList($args);
		$this->total = $model->total;

		$foto_id = 0;

		$res = '<input type="hidden" id="gallery_id" value="'.$args->gallery_id.'" name="gallery_id" />';
		$res .= '<input type="hidden" id="gallery_type" value="'.$gallery_type.'" name="gallery_type" />';

		$res .= '<ul class="filesGallery">';
		if (count($fotoGallery)>0)
		{
		//	$imageController = new ImageController();
	//		$imageController->setPathImage(PATH_DATA);
      
			for ($i=0;$i < count($fotoGallery);$i++)
			{


				if (!empty($fotoGallery[$i]->file))
				{
					//$PreviewUrl = $g->get_thumb3($fotoGallery[$i]->file,90,90);
					//$PreviewUrl = $imageController->getZmensitOriginal($fotoGallery[$i]->dir . $fotoGallery[$i]->file,$args->width,$args->height);

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
					$res .= '<li><a class="modal-form" data-url=' . URL_HOME_SITE . 'admin/data?do=FileDelete&id=' . $fotoGallery[$i]->id . '&place_id=' . $fotoGallery[$i]->place_id . '" data-callback="loadFilesGallery" data-callback-params="'.$args->gallery_id.', \''.$gallery_type.'\'" href="#" title="Smazat soubor" id="foto_' . $fotoGallery[$i]->id . '" href="#"><i class="fa fa-times"></i> smazat</a></li>';
					$res .= '<li><a class="modal-form" data-url="' . URL_HOME_SITE . 'admin/data?do=FileEdit&id=' . $fotoGallery[$i]->id . '&place_id=' . $fotoGallery[$i]->place_id . '" data-callback="loadFilesGallery" data-callback-params="'.$args->gallery_id.', \''.$gallery_type.'\'" href="#" title="Editovat soubor" id="foto_' . $fotoGallery[$i]->id . '" href="#"><i class="fa fa-pencil"></i> editovat</a></li>';
				  	$res .= '</ul>';
					$res .= '</div>';


					$res .= '<input type="hidden" class="place_id" value="'.$fotoGallery[$i]->id.'" name="place_id" />';



					$res .= '<span class="foto-description">' . $fotoGallery[$i]->description . '</span>';

					$res .= '<a title="' . $fotoGallery[$i]->description . '" href="' . URL_IMG . $fotoGallery[$i]->file . '" class="lightbox2">' . $fotoGallery[$i]->file . '<br />' . $fotoGallery[$i]->size . '</a>';
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
  
	public function filesUmisteniListEditOld(FotoPlacesListArgs $args = null)
	{
  
    $type  = $args->gallery_type;
    
    
		$fotoGallery = $this->filesUmisteniList($params);

		//print_r($fotoGallery);
		$foto_id = 0;

	//	$type = $params['gallery_type'];


		$width = 180;
		if (isset($params['width'])) {
			$width = $params['width'];
		}
		$height = 180;
		if (isset($params['height'])) {
			$height = $params['height'];
		}
		$res = '<input type="hidden" class="gallery_id" value="'.$params["gallery_id"].'" name="gallery_id" />';
		$res .= '<input type="hidden" class="gallery_type" value="'.$type.'" name="gallery_type" />';

		$imagesExtended = array("jpg","jpeg","png");
		$res .= '<ul class="filesGallery">';
		if (count($fotoGallery)>0)
		{
			$imageController = new ImageController();
			$imageController->setPathImage(PATH_DATA);
			for ($i=0;$i < count($fotoGallery);$i++)
			{

				$PreviewUrl = "";
				if (!empty($fotoGallery[$i]->file))
				{
					//$PreviewUrl = $g->get_thumb3($fotoGallery[$i]->file,90,90);
				//	$PreviewUrl = $imageController->getZmensitOriginal($fotoGallery[$i]->file,$width,$height);


					if (in_array($fotoGallery[$i]->type,$imagesExtended )) {
						//$PreviewUrl = $g->get_thumb3($fotoGallery[$i]->file,90,90);
						$PreviewUrl = '<img src="'.$imageController->getZmensitOriginal($fotoGallery[$i]->file,$width,$height).'" />' ;
					}
					$class_main = '';
					if ($foto_id == $fotoGallery[$i]->id) {
						$class_main = ' is-main';
					}
					$res .= '<li class="foto_item2'.$class_main.'" id="sort_'.$fotoGallery[$i]->place_id.'" style="position:relative;">';

					$res .= '<input type="hidden" class="place_id" value="'.$fotoGallery[$i]->place_id.'" name="place_id" />';
					$res .= '<input type="hidden" class="file_id" value="'.$fotoGallery[$i]->id.'" name="file_id" />';
					// Delete

					$res .= '<a class="delete-btn" href="#" title="Smazat soubor" id="foto_' . $fotoGallery[$i]->id . '" style="height: 16px;cursor:pointer;position: absolute;width: 16px;right:5px;top:5px;display:block;">';
					$res .= '<img src="/admin/style/images/minus.png" />';
					$res .= '</a>';

					// Set main
				/*	$res .= '<a class="main-btn" href="#" title="Nastavit obrázek jako hlavní" style="height: 16px;cursor:pointer;position: absolute;width: 16px;right:5px;top:35px;display:block;">';
					$res .= '<img src="/admin/style/images/flag.png" />';
					$res .= '</a>';*/
					/**/
$res .= '<div style="display:none;">';
					$res .= '<input type="text" name="title" value="' . $fotoGallery[$i]->title . '" class="textbox" />';
					$res .= '</div>';

					$res .= '<a target="_blank" title="" href="' . URL_DATA . $fotoGallery[$i]->file . '">';
						$res .=$PreviewUrl;
					 	$res .= '<span class="title">' . $fotoGallery[$i]->file. '</span>';
						$res .='</a>';
					//	$res .= '<div style="text-align:center;"><input type="text" name="title" value="' . $fotoGallery[$i]->title . '" class="textbox" /></div>';
					//	$res .= '</div>';

					$res .= '</li>';
				}
			}


		} else {

			$res .= 'žádné přílohy!';
		}

		$res .= '</ul>';
		$res .= '<div class="clearfix"> </div>';
		return $res;

	}
}

