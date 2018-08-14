<?php


class ProductAttributesWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();



    			$command = new EditDataGridCommandModal(URL_HOME . "eshop/attributes?do=edit&id=" . $radek->id);
			array_push($radek->dg_commands, $command);

			$command = new DeleteDataGridCommand(URL_HOME . "eshop/attributes?do=AttributesDelete&id=" . $radek->id);
			array_push($radek->dg_commands, $command);
  }
}
