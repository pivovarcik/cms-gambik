<?php

class GdprWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

    $radek->dg_commands = array();


      
    
		$command = new EditDataGridCommandModal(URL_HOME . "gdpr?do=GdprEdit&id=" . $radek->id);
    
		array_push($radek->dg_commands, $command);


		$command = new DeleteDataGridCommand(URL_HOME . "gdpr?do=GdprDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);
    
	//	$radek->link_delete = URL_HOME . "sortiment?do=ProductVariantyDelete&id=" . $radek->id;
    
   // $radek->link_edit = '/admin/sortiment?do=variantyEdit&id='.$radek->id;
	}
}