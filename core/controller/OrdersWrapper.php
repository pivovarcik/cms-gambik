<?php


class OrdersWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "objednavky?do=ObjednavkaEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

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