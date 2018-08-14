<?php


class OrdersWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();



    $radek->zasilka_link = "";
    
    switch($radek->kod_dopravce)
    {
      case "CPOST" :
        $radek->zasilka_link = "http://www.ceskaposta.cz/cz/nastroje/sledovani-zasilky.php?locale=CZ&go=ok&barcode=";
      break; 
      case "FOFR" :
        $radek->zasilka_link = "https://objednavky.fofrcz.cz/index.php?id=sledovani&rok=2018&shipment_num=";
      break; 
      case "DPD" :
        $radek->zasilka_link = "https://tracking.dpd.de/parcelstatus?locale=cs_CZ&Tracking=Sledovat&query=";
      break; 
    }
    
		if ($radek->isHeureka == 1) {
			$radek->h_total_rating = '<img src="/admin/images/heureka-icon.jpg" style="height: 20px;" /> ' . $radek->h_total_rating;
		}
		$command = new EditDataGridCommandModal(URL_HOME . "objednavky?do=ObjednavkaEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

    if ($radek->faktura_id > 0) {
      $command = new DataGridCommand("faktura");
      $command->data_url = URL_HOME . "faktury?do=FakturaEdit&id=" . $radek->faktura_id;
      $command->label = '<i class="fa fa-pencil"></i> faktura';
      
      
  		array_push($radek->dg_commands, $command);
     }
		$command = new DeleteDataGridCommand(URL_HOME . "objednavky?do=ObjednavkaDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);


		$command = new CopyDataGridCommand(URL_HOME . "objednavky?do=ObjednavkaCopy&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new PrintDataGridCommand(URL_HOME . "orders_pdf.php?id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new StornoDataGridCommand(URL_HOME . "objednavky?do=ObjednavkaStorno&id=" . $radek->id);
		array_push($radek->dg_commands, $command);
	}
}