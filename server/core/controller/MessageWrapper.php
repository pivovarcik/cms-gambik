<?php

class MessageWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);
    /*
		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "users?do=UserEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "users?do=ProductDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);
       */

    $width = 50;

		$height = 50;

    $PreviewUrl = '/admin/images/avatar.png';
    $radek->fad_thumb = "";
		if (!empty($radek->fad_file)) {
			$imageController = new ImageController();
			$PreviewUrl =$imageController->getThumbOriznoutOriginal($radek->fad_file,$width,$height);
	
		}
    $radek->ad_thumb = '<a class="lightbox" href="' . URL_IMG . $radek->fad_file . '" ' . $radek->title . '"><img height="' . $height . '" width="' . $width . '" alt="' . $radek->title . '" src="' . $PreviewUrl  . '" class="imgobal" /></a>';
		$radek->ad_thumb_link = $PreviewUrl;


    $PreviewUrl = '/admin/images/avatar.png';
    $radek->fau_thumb = "";
		if (!empty($radek->fau_file)) {
			$imageController = new ImageController();
			$PreviewUrl =$imageController->getThumbOriznoutOriginal($radek->fau_file,$width,$height);
	
		}
    $radek->au_thumb = '<a class="lightbox" href="' . URL_IMG . $radek->fau_file . '" ' . $radek->title . '"><img height="' . $height . '" width="' . $width . '" alt="' . $radek->title . '" src="' . $PreviewUrl  . '" class="imgobal" /></a>';
		$radek->au_thumb_link = $PreviewUrl;
    
    $radek->response_user_id = $radek->autor_id;
    
    if (defined("USER_ID")){
    
    
    if ($radek->autor_id == USER_ID)
    {
        $radek->response_user_id = $radek->adresat_id;
    }
    
    if ($radek->adresat_id == USER_ID)
    {
        $radek->response_user_id = $radek->autor_id;
    }
    }
	}
}
