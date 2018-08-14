<?php


class MailingWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();


		$command = new EditDataGridCommandModal(URL_HOME . "mailing?do=MailEdit&id=" . $radek->id);
		array_push($radek->dg_commands, $command);
    /*
		$command = new DeleteDataGridCommand(URL_HOME . "faktury?do=FakturaDelete&id=" . $radek->id);
		array_push($radek->dg_commands, $command);


		$command = new CopyDataGridCommand(URL_HOME . "faktury?do=FakturaCopy&id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new PrintDataGridCommand(URL_HOME . "faktura_pdf.php?id=" . $radek->id);
		array_push($radek->dg_commands, $command);

		$command = new StornoDataGridCommand(URL_HOME . "faktury?do=FakturaStorno&id=" . $radek->id);
		array_push($radek->dg_commands, $command);          */
	}
}