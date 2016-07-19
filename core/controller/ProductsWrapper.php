<?php

class ProductsWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "sortiment?do=ProductEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "sortiment?do=ProductDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$radek->thumb = '';
		if (!empty($radek->file)) {

			$imageController = new ImageController();
			$eshopSettings = G_EshopSetting::instance();
			$thumb_width= $eshopSettings->get("PRODUCT_THUMB_WIDTH"); // 190;
			$thumb_height= $eshopSettings->get("PRODUCT_THUMB_HEIGHT"); //200;

			$radek->thumb = '<a class="lightbox" href="' . URL_IMG . $radek->file . '" title="' . $radek->title . '"><img alt="' . $radek->title . '" src="' . $imageController->getZmensitOriginal($radek->file,$thumb_width,$thumb_height) . '" class="imgobal" /></a>';
		}

	//	$radek->size = sizeFormat($radek->size);//$filesize;
	}
}