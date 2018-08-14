<?php

class  NewsletterWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);


      $radek->dg_commands = array();
      
      $command = new EditDataGridCommand(URL_HOME . "edit_newsletter?id=" . $radek->id);
			array_push($radek->dg_commands, $command);
      
      
      		$command = new CopyDataGridCommand(URL_HOME . "newsletter?do=NewsletterCopy&id=" . $radek->id);
		array_push($radek->dg_commands, $command);
    
      
         /*
      $command = new DeleteDataGridCommand(URL_HOME . "shop_transfer?do=ShopTransferDelete&id=" . $radek->id);
			array_push($radek->dg_commands, $command);
      
       */
      
      }
      }