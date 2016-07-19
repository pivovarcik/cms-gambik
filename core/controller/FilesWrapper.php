<?php

class FilesWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);


		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "data?do=FileEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "data?do=FileDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

	//	$radek->thumb = '';
		if (!empty($radek->file)) {

		/*	$imageController = new ImageController();
			$eshopSettings = G_EshopSetting::instance();
			$thumb_width= $eshopSettings->get("PRODUCT_THUMB_WIDTH"); // 190;
			$thumb_height= $eshopSettings->get("PRODUCT_THUMB_HEIGHT"); //200;
*/
			$radek->file = '<a target="_blank" href="' . URL_DATA . $radek->file . '">' .  $radek->file . '</a>';
		}

		$radek->size = sizeFormat($radek->size);//$filesize;
	}
}