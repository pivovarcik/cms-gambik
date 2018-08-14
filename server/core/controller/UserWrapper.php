<?php

class UserWrapper extends G_Wrapper{

  public $thumb_width = 50;

	public $thumb_height = 50;
	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "users?do=UserEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "users?do=ProductDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);


    $this->thumb_width = 50;

		$this->thumb_height = 50;
    
    $radek->title = $radek->jmeno . " " . $radek->prijmeni;
    $PreviewUrl = '/admin/images/avatar.png';
    $radek->thumb = "";
		if (!empty($radek->file)) {
			$imageController = new ImageController();
		//	$PreviewUrl =$imageController->getThumbOriznoutOriginal($radek->file,$width,$height);
      $PreviewUrl = $imageController->getFileUrl($radek->dir . $radek->file,$this->thumb_width,$this->thumb_height);
	
		}
    $radek->thumb = '<a class="lightbox" href="' . URL_IMG . $radek->file . '" title="' . $radek->title . '"><img height="' . $this->thumb_height . '" width="' . $this->thumb_width . '" alt="' . $radek->title . '" src="' . $PreviewUrl  . '" class="imgobal" /></a>';
		$radek->thumb_link = $PreviewUrl;

	}
}

