<?php

class ProductCenaWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

    $radek->dg_commands = array();

   // 		$radek->link_delete = URL_HOME . "product_ceny?do=ProductCenaDelete&id=" . $radek->id;
    
   // $radek->link_edit = '/admin/product_ceny?do=productCenaEdit&id='.$radek->id;
    
    
    
      $radek->vypocet_cena = 0;
      $radek->vypocet_cena_sdph = 0;

      $sazba_dph = ($radek->value_dph>0) ? $radek->value_dph/100 : $radek->value_dph * 1;

           
      if ($radek->cenik_cena <> 0)
      {
          $radek->vypocet_cena = $radek->cenik_cena;
          
          
      
      } else {
        if ($radek->typ_slevy =="%")
        {
             $radek->vypocet_cena = $radek->prodcena + ($radek->prodcena *  $radek->sleva / 100);
        } else {
            $radek->vypocet_cena = $radek->prodcena +  $radek->sleva;
        }
      
      }
      $radek->vypocet_cena_sdph = $radek->vypocet_cena + $sazba_dph * $radek->vypocet_cena; 
     
      $radek->marze = 0; 
      if ($radek->nakupni_cena <> 0)
      {
         $radek->marze = $radek->vypocet_cena / $radek->nakupni_cena * 100 - 100; 
      }
        
      
    
		$command = new EditDataGridCommandModal(URL_HOME . "product_ceny?do=ProductCenaEdit&id=" . $radek->id);
    
		array_push($radek->dg_commands, $command);
    
    $command = new EditDataGridCommandModal(URL_HOME . "sortiment?do=ProductEdit&id=" . $radek->product_id);
    $command->label = '<i class="fa fa-pencil"></i> produkt';
		array_push($radek->dg_commands, $command);

		$command = new DeleteDataGridCommand(URL_HOME . "product_ceny?do=ProductCenaDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);
    
	//	$radek->link_delete = URL_HOME . "sortiment?do=ProductVariantyDelete&id=" . $radek->id;
    
   // $radek->link_edit = '/admin/sortiment?do=variantyEdit&id='.$radek->id;
	}
}