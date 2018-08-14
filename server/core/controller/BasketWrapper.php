<?php

class  BasketWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "basket?do=BasketEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "basket?do=BasketDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		if (($radek->varianty_id) > 0) {

			$radek->product_name = $radek->product_name . "<br />" . $radek->varianty_code. " : " . $radek->varianty_name;
		}
		$radek->thumb = '';
		$radek->thumb_link = '';

		if (!empty($radek->file)) {

			$imageController = new ImageController();
			$eshopSettings = G_EshopSetting::instance();
			$thumb_width= $eshopSettings->get("PRODUCT_THUMB_WIDTH"); // 190;
			$thumb_height= $eshopSettings->get("PRODUCT_THUMB_HEIGHT"); //200;

		//	$radek->thumb_link = $imageController->getZmensitOriginal($radek->dir . $radek->file,$thumb_width,$thumb_height);
      $radek->thumb_link = $imageController->getFileUrl($radek->dir . $radek->file,$thumb_width,$thumb_height);
			$radek->thumb = '<a class="lightbox" href="' . URL_IMG . $radek->dir . $radek->file . '" title="' . $radek->title . '"><img alt="' . $radek->title . '" src="' . $radek->thumb_link . '" class="imgobal" /></a>';
		}
	}
}