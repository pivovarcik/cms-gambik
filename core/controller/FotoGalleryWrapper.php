<?php

class FotoGalleryWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();
		$command = new EditDataGridCommandModal(URL_HOME . "admin/foto?do=ImageEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "admin/foto?do=ImageDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$radek->thumb = '';
		if (!empty($radek->file)) {

			$imageController = new ImageController();
			$eshopSettings = G_EshopSetting::instance();
			$thumb_width= $eshopSettings->get("PRODUCT_THUMB_WIDTH"); // 190;
			$thumb_height= $eshopSettings->get("PRODUCT_THUMB_HEIGHT"); //200;

			$radek->thumb = '<a href="' . URL_IMG . $radek->file . '"><img src="' . $imageController->get_thumb($radek->file,$thumb_width,$thumb_height,null,false,true) . '" class="imgobal" /></a>';
		}

		$radek->size = sizeFormat($radek->size);//$filesize;
	}
}