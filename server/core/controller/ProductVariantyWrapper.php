<?php

class ProductVariantyWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

    $radek->dg_commands = array();
    $command = new EditDataGridCommandModal(URL_HOME . "sortiment?do=ProductVariantyEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "sortiment?do=ProductVariantyDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);



    if ($radek->dostupnost_id=="0")
    {
         
         if ($radek->stav_qty > 0) {
         
         }
         $radek->nazev_dostupnost = "Skladem " . $radek->stav_qty . "" . $radek->nazev_mj;
    }
	}
}